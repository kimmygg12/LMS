<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanBook;
use App\Models\LoanBookHistory;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanBookController extends Controller
{
    public function index(Request $request)
    {
        $loans = LoanBook::with('book', 'member')->paginate(4);
        $members = Member::all();
        $search = $request->input('search');

        $loans = LoanBook::query()
            ->with('book', 'member') // Eager load relationships
            ->when($search, function ($query, $search) {
                $query->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('book', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('member', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->paginate(4);

        return view('loans.index', compact('loans'));
    }
    public function return()
    {
        $loans = LoanBook::all();
        $members = Member::all();
        return view('loans.return', compact('loans'));
    }
    public function create()
    {
        $books = Book::where('status', 'available')->get();
        $members = Member::all();
        return view('loans.create', compact('books', 'members'));
    }
    public function show($id)
    {
        $loan = LoanBook::with(['book', 'member', 'member.study', 'member.category'])
            ->findOrFail($id);

        return response()->json([
            'invoice_number' => $loan->invoice_number,
            'book_title' => $loan->book->title,
            'member_name' => $loan->member->name,
            'member_id' => $loan->member->id,
            'memberId' => $loan->member->memberId,
            'cover_image' => $loan->book->cover_image,
            'loan_date' => $loan->loan_date->format('Y-m-d'),
            'due_date' => $loan->due_date->format('Y-m-d'),
            'renew_date' => $loan->renew_date ? $loan->renew_date->format('Y-m-d') : null,
            'price' => $loan->price,
            'status' => $loan->status,
            'isbn' => $loan->book->isbn,
            'fine' => $loan->fine,
            'gender' => $loan->member->gender,
            'phone' => $loan->member->phone,
            'study_name' => $loan->member->study->name,
            'category_name' => $loan->member->category->name,
            'author' => $loan->book->author->name,
            'subject' => $loan->book->subject->name,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'isbn' => 'required|exists:books,isbn',
            'member_id' => 'required|exists:members,id',
            'price' => 'required|numeric',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
        ]);

        $book = Book::where('isbn', $request->isbn)->first();

        if (!$book) {
            return redirect()->back()->with('error', 'Book not found.');
        }
        if ($book->quantity < 1) {
            return redirect()->back()->with('error', 'No copies of this book are available.');
        }

        $invoice_number = $this->generateInvoiceNumber();

        $loan = LoanBook::create([
            'book_id' => $book->id,
            'member_id' => $request->member_id,
            'price' => $request->price,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
            'invoice_number' => $invoice_number,
        ]);
        $book->quantity -= 1;

        if ($book->quantity > 0) {
            $book->status = 'available'; // Status is 'borrowed' if there are still copies left
        } else {
            $book->status = 'borrowed'; // Status is 'unavailable' if no copies are left
        }
        $book->save();
        return redirect()->route('loans.index');
    }

    public function edit($id)
    {
        $loan = LoanBook::findOrFail($id);
        $books = Book::all();
        $members = Member::all();

        return view('loans.edit', compact('loan', 'books', 'members'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'price' => 'required|numeric',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
        ]);

        $loan = LoanBook::findOrFail($id);
        $previousBookId = $loan->book_id;

        // Update the loan record
        $loan->update([
            'book_id' => $request->book_id,
            'member_id' => $request->member_id,
            'price' => $request->price,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
        ]);

        // Fetch the new and previous book records
        // $newBook = Book::find($request->book_id);
        $previousBook = Book::find($previousBookId);

        // Update the status of the previous book
        if ($previousBook) {
            // $previousBook->quantity += 1;
            $previousBook->status = $previousBook->quantity > 0 ? 'available' : 'borrowed';
            $previousBook->save();
        }

        return redirect()->route('loans.index');
    }


    private function generateInvoiceNumber()
    {
        do {
            $randomNumber = rand(100000, 999999);
            $invoiceNumber = 'INV-' . $randomNumber;
        } while (LoanBookHistory::where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }

    public function destroy($id)
    {
        $loan = LoanBook::findOrFail($id);

        // Find the book associated with the loan
        $book = Book::find($loan->book_id);

        if ($book) {
            // Increment the quantity of the book
            $book->quantity += 1;

            // Update the book status
            if ($book->quantity > 0) {
                $book->status = 'available'; // Status is 'available' if there are copies left
            } else {
                $book->status = 'borrowed'; // Status is 'unavailable' if no copies are left
            }
            // Save the updated book details
            $book->save();
        }
        // Delete the loan record
        $loan->delete();
        // Redirect to the loans index with a success message
        return redirect()->route('loans.index');
    }

    public function showFinebookForm($id)
    {
        
        $loan = LoanBook::findOrFail($id);
        return view('loans.finebook', compact('loan'));
    }
    public function finebook(Request $request, $id)
    {
        $request->validate([
            'due_date' => 'required|date|after_or_equal:loan_date',
            'renew_date' => 'nullable|date|after_or_equal:due_date',
            'pay_date' => 'nullable|date',
            'fine' => 'nullable|numeric',
            'fine_reason' => 'nullable|string',
        ]);

        $loan = LoanBook::findOrFail($id);

        if ($loan->status !== 'borrowed') {
            return redirect()->back()->with('error', 'The book is not currently borrowed.');
        }

        $loanData = $request->only(['due_date', 'renew_date', 'pay_date', 'fine', 'fine_reason']);
        $loan->update($loanData);

        $invoiceNumber = $this->generateInvoiceNumber(); // Ensure a unique invoice number

        if ($request->filled('renew_date') && $request->filled('pay_date')) {
            LoanBookHistory::create([
                'loan_book_id' => $loan->id,
                'book_id' => $loan->book_id,
                'member_id' => $loan->member_id,
                'price' => $loan->price,
                'loan_date' => $loan->loan_date,
                'due_date' => $loan->due_date,
                'pay_date' => $loan->pay_date,
                'invoice_number' => $invoiceNumber,
                'renew_date' => $loan->renew_date,
                'fine' => $loan->fine,
                'fine_reason' => $loan->fine_reason,
                'status' => 'returned'
            ]);
            $loan->delete();

            // Update book quantity and status
            $book = Book::find($loan->book_id);
            if ($book) {
                $book->quantity += 1;
                $book->status = 'available';
                $book->save();
            }

            return redirect()->route('loans.index');
        } elseif ($request->filled('renew_date')) {
            return redirect()->route('loans.index');
        } elseif ($request->filled('pay_date')) {
            LoanBookHistory::create([
                'loan_book_id' => $loan->id,
                'book_id' => $loan->book_id,
                'member_id' => $loan->member_id,
                'price' => $loan->price,
                'loan_date' => $loan->loan_date,
                'due_date' => $loan->due_date,
                'pay_date' => $loan->pay_date,
                'invoice_number' => $invoiceNumber,
                'renew_date' => $loan->renew_date,
                'fine' => $loan->fine,
                'fine_reason' => $loan->fine_reason,
                'status' => 'returned'
            ]);
            $loan->delete();

            $book = Book::find($loan->book_id);
            if ($book) {
                $book->quantity += 1;
                $book->status = 'available';
                $book->save();
            }

            return redirect()->route('loans.index');
        }

        if (!$request->filled('renew_date') && !$request->filled('pay_date')) {
            return redirect()->back()->with('error', 'Please fill in both renew date and pay date.')->withInput();
        } elseif (!$request->filled('renew_date')) {
            return redirect()->back()->with('error', 'Please fill in the renew date.')->withInput();
        } elseif (!$request->filled('pay_date')) {
            return redirect()->back()->with('error', 'Please fill in the pay date.')->withInput();
        }
    }


    private function getDateRange($period)
    {
        switch ($period) {
            case 'weekly':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
                break;
            case 'monthly':
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                break;
            default: // daily or any other period
                $start = Carbon::now()->startOfDay();
                $end = Carbon::now()->endOfDay();
                break;
        }

        return ['start' => $start, 'end' => $end];
    }

    // public function overdueBooksReport(Request $request)
    // {
    //     $loans =LoanBook::all();
    //     $currentDate = Carbon::now()->toDateString();
    
    //     // Retrieve overdue books
    //     $overdueBooks = LoanBook::where(function ($query) use ($currentDate) {
    //         $query->where(function ($query) use ($currentDate) {
    //                 // Books with due_date before current date and no renewal
    //                 $query->where('due_date', '<', $currentDate)
    //                       ->whereNull('renew_date');
    //             })
    //             ->orWhere(function ($query) use ($currentDate) {
    //                 // Books with a renewal date before current date
    //                 $query->whereNotNull('renew_date')
    //                       ->where('renew_date', '<', $currentDate);
    //             });
    //     })
    //     ->where('status', 'borrowed')
    //     ->get();
    
    //     // Calculate overdue fines
    //     $overdueDetails = $overdueBooks->map(function ($loan) use ($currentDate) {
    //         // Determine the actual due date considering renewals
    //         $actualDueDate = isset($loan->renew_date) ? $loan->renew_date : $loan->due_date;
    //         $daysOverdue = Carbon::parse($actualDueDate)->diffInDays(Carbon::now());
    //         $fine = $daysOverdue * 500; // Example fine rate: $5 per overdue day
    
    //         return [
    //             'member' => $loan->member,
    //             'book' => $loan->book,
    //             'loan_date' => $loan->loan_date,
    //             'due_date' => $loan->due_date,
    //             'renew_date' => $loan->renew_date,
    //             'days_overdue' => $daysOverdue,
    //             'invoice_number' => $loan->invoice_number ,
    //             'fine' => $fine,
    //             'id' => $loan->id, // Add this line to include the loan
    //         ];
    //     });
    //     $totalOverdueBooks = $overdueBooks->count();
    //     return view('loans.overdueBooksReport', compact('overdueDetails','loans','totalOverdueBooks'));
    // }
    public function overdueBooksReport(Request $request)
    {
        // Get current date
        $currentDate = Carbon::now()->toDateString();
        
        // Retrieve overdue books
        $overdueBooks = LoanBook::where('status', 'borrowed')
            ->where(function ($query) use ($currentDate) {
                $query->where(function ($query) use ($currentDate) {
                    // Books with due_date before current date and no renewal
                    $query->where('due_date', '<', $currentDate)
                          ->whereNull('renew_date');
                })
                ->orWhere(function ($query) use ($currentDate) {
                    // Books with a renewal date before current date
                    $query->whereNotNull('renew_date')
                          ->where('renew_date', '<', $currentDate);
                });
            })
            ->get();
    
        // Calculate overdue fines
        $overdueDetails = $overdueBooks->map(function ($loan) use ($currentDate) {
            // Determine the actual due date considering renewals
            $actualDueDate = $loan->renew_date ?? $loan->due_date;
            $daysOverdue = Carbon::parse($actualDueDate)->diffInDays(Carbon::now());
            $fine = $daysOverdue * 500; // Example fine rate: $500 per overdue day
    
            return [
                'member' => $loan->member,
                'book' => $loan->book,
                'loan_date' => $loan->loan_date,
                'due_date' => $loan->due_date,
                'renew_date' => $loan->renew_date,
                'days_overdue' => $daysOverdue,
                'invoice_number' => $loan->invoice_number,
                'fine' => $fine,
                'id' => $loan->id,
            ];
        });
    
        $totalOverdueBooks = $overdueBooks->count();
    
        return view('loans.overdueBooksReport', compact('overdueDetails', 'totalOverdueBooks'));
    }

    public function indexReport(Request $request)
    {
        // Validation of the date inputs
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        // Fetching reports based on the request parameters
        $borrowedReports = LoanBook::whereBetween('loan_date', [$startDate, $endDate])
            ->whereNull('pay_date')
            ->get();

        $returnedReports = LoanBook::whereBetween('pay_date', [$startDate, $endDate])
            ->whereNotNull('pay_date')
            ->get();

        return view('loans.indexReport', [
            'borrowedReports' => $borrowedReports,
            'returnedReports' => $returnedReports,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
    public function reportTotalLoan()
    {

        $totalLoans = LoanBook::count();

        return view('loans.report_total', compact('totalLoans'));
    }

   
}
