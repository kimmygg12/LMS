<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanBook;
use App\Models\LoanBookHistory;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoanBookController extends Controller
{
    public function index(Request $request)
    {
        $query = LoanBook::with('book', 'member');
        $members = Member::all();
        $search = $request->input('search');

        if ($search) {
            $query->where('invoice_number', 'like', "%{$search}%")
                ->orWhereHas('book', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                })
                ->orWhereHas('member', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }
        $loans = $query->orderBy('created_at', 'desc')->paginate(4);
        $newLoan = LoanBook::orderBy('created_at', 'desc')->first();
        return view('loans.index', compact('loans', 'newLoan', 'search'));
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
        // Fetch the loan with related models
        $loan = LoanBook::with(['book', 'member', 'member.study', 'member.category', 'book.authors', 'book.genre'])
            ->findOrFail($id);
    
        // Collect all authors' names into a comma-separated string
        $authorNames = $loan->book->authors->pluck('name')->implode(', ') ?? 'Unknown Author';
    
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
            'author' => $authorNames,
            'genre' => $loan->book->genre->name,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'books' => 'required|array',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.member_id' => 'required|exists:members,id',
            'books.*.price' => 'required|numeric',
            'books.*.loan_date' => 'required|date',
            'books.*.due_date' => 'required|date|after_or_equal:books.*.loan_date',
        ]);

        foreach ($request->books as $bookData) {
            $book = Book::find($bookData['book_id']);

            if (!$book || $book->quantity < 1) {
                return redirect()->back()->with('error', 'The book is not available.');
            }

            $invoice_number = $this->generateInvoiceNumber();

            LoanBook::create([
                'book_id' => $book->id,
                'member_id' => $bookData['member_id'],
                'price' => $bookData['price'],
                'loan_date' => $bookData['loan_date'],
                'due_date' => $bookData['due_date'],
                'invoice_number' => $invoice_number,
            ]);

            $book->decrement('quantity');
            $book->update(['status' => $book->quantity > 0 ? 'available' : 'borrowed']);
        }

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

        $previousBook = Book::find($previousBookId);

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
        $book = Book::find($loan->book_id);

        // Check if the user is an admin
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            if ($book) {
                // If the loan was borrowed, increase the book quantity by 1
                if ($loan->status === 'borrowed') {
                    $book->quantity += 1;
                }

                // Update the book status based on the new quantity
                if ($book->quantity > 0) {
                    $book->status = 'available';
                } else {
                    $book->status = 'borrowed';
                }
                $book->save();
            }

            // Delete the loan record regardless of its status
            $loan->delete();

            return redirect()->route('loans.index');
        } else {
            return redirect()->route('loans.index');
        }
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


        if ($request->filled('renew_date') && $request->filled('pay_date')) {
            LoanBookHistory::create([
                'loan_book_id' => $loan->id,
                'book_id' => $loan->book_id,
                'member_id' => $loan->member_id,
                'price' => $loan->price,
                'loan_date' => $loan->loan_date,
                'due_date' => $loan->due_date,
                'pay_date' => $loan->pay_date,
                'invoice_number' => $loan->invoice_number,
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

            return redirect()->route('loanBookHistories.index');
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
                'invoice_number' => $loan->invoice_number,
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

            return redirect()->route('loanBookHistories.index');
        }

        if (!$request->filled('renew_date') && !$request->filled('pay_date')) {
            return redirect()->back()->with('error', 'Please fill in both renew date and pay date.');
        } elseif (!$request->filled('renew_date')) {
            return redirect()->back()->with('error', 'Please fill in the renew date.');
        } elseif (!$request->filled('pay_date')) {
            return redirect()->back()->with('error', 'Please fill in the pay date.');
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

        $overdueDetails = $overdueBooks->map(function ($loan) use ($currentDate) {
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

    public function memberLoanDetails($id)
    {
        $member = Member::findOrFail($id);

        $today = Carbon::today()->toDateString();
        $loans = LoanBook::where('member_id', $id)
            ->whereDate('loan_date', $today)
            ->with('book')
            ->get();

        // Count the number of loans
        $loanCount = $loans->count();

        return view('loans.member-loan-details', compact('member', 'loans', 'loanCount'));
    }
    public function showInvoice($id)
    {
        // Fetch the loan details along with related member and book
        $loan = LoanBook::with('member', 'book')->findOrFail($id);

        // Get the search date and time from the request, if available
        $searchDate = request('date');
        $searchTime = request('time');
        $query = LoanBook::with('book')
            ->where('member_id', $loan->member_id)
            ->where('id', '!=', $id); // Exclude the current loan to avoid duplication
        if ($searchDate) {
            $query->whereDate('loan_date', $searchDate);
        }
        if ($searchTime) {
            $query->whereTime('loan_date', $searchTime);
        }
        $memberLoans = $query->get();
        return view('loans.show-invoice', compact('loan', 'memberLoans', 'searchDate', 'searchTime'));
    }

    public function showReservedBooks()
    {
        $member = Auth::guard('member')->user();
        $reservedBooks = LoanBook::where('member_id', $member->id)
            ->where('status', 'reserved')
            ->get();

        $totalReserved = $reservedBooks->count();

        return view('reservations.show_reserved', compact('reservedBooks', 'totalReserved'));
    }

    public function reserve(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'reservation_date' => 'required|date',
        ]);

        $book = Book::find($request->book_id);

        if (!$book || $book->quantity < 1) {
            return redirect()->back()->with('error', 'The book is not available for reservation.');
        }

        $reservationNumber = $this->generateInvoiceNumber();

        LoanBook::create([
            'book_id' => $book->id,
            'member_id' => $request->member_id,
            'reservation_date' => $request->reservation_date,
            'invoice_number' => $reservationNumber,
            'status' => 'reserved',
        ]);

        return redirect()->route('reservations.index');
    }

    public function approveReservation($id)
    {
        $reservation = LoanBook::findOrFail($id);

        if ($reservation->status !== 'reserved') {
            return redirect()->back()->with('error', 'Reservation not found or already processed.');
        }

        $book = Book::find($reservation->book_id);

        if (!$book || $book->quantity < 1) {
            return redirect()->back()->with('error', 'The book is not available for approval.');
        }

        $loan = LoanBook::create([
            'book_id' => $reservation->book_id,
            'member_id' => $reservation->member_id,
            'price' => $reservation->price,
            'loan_date' => Carbon::now()->toDateString(),
            'due_date' => Carbon::now()->addDays(14)->toDateString(), // Example: 2 weeks loan
            'invoice_number' => $reservation->invoice_number,
        ]);

        $book->decrement('quantity');
        $book->update(['status' => $book->quantity > 0 ? 'available' : 'borrowed']);

        $reservation->update(['status' => 'approved']);

        return redirect()->route('loans.index');
    }
    public function showApproveForm(LoanBook $loan)
    {
        if ($loan->status !== 'reserved') {
            return redirect()->route('loans.index')->with('error', 'Loan is not in reserved status.');
        }
        return view('loans.approve', compact('loan'));
    }

    public function approve(Request $request, LoanBook $loan)
    {
        // Uncomment this block if you want to ensure the user is an admin
        // if (Auth::user()->usertype !== 'admin') {
        //     return redirect()->route('loans.index')->with('error', 'Unauthorized action.');
        // }

        if ($loan->status !== 'reserved') {
            return redirect()->route('loans.index')->with('error', 'Loan is not in reserved status.');
        }

        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $book = Book::find($loan->book_id);

        if (!$book) {
            return redirect()->route('loans.index')->with('error', 'Book not found.');
        }

        if ($book->quantity < 1) {
            return redirect()->route('loans.index')->with('error', 'Not enough quantity available for the loan.');
        }

        // Approve the loan
        $loan->status = 'borrowed'; // Or 'approved' if that's the intended status
        $loan->loan_date = Carbon::now()->toDateString();
        $loan->due_date = Carbon::now()->addDays(14)->toDateString(); // Example: 2 weeks loan
        $loan->price = $request->input('price');
        $loan->save();

        $book->decrement('quantity');
        $book->update(['status' => $book->quantity > 0 ? 'available' : 'borrowed']);
        return redirect()->route('loans.index');
    }

    public function rejectReservation($id)
    {
        $reservation = LoanBook::findOrFail($id);

        if ($reservation->status !== 'reserved') {
            return redirect()->back()->with('error', 'Reservation not found or already processed.');
        }

        $reservation->update(['status' => 'rejected']);

        // Optionally, you can also revert any changes to the book's quantity or status if needed.
        // For example, if the book's quantity was reduced when the reservation was made:
        // $book = Book::find($reservation->book_id);
        // $book->increment('quantity');
        // $book->update(['status' => 'available']);

        return redirect()->route('loans.index');
    }
    public function reApproveReservation($id)
    {
        $reservation = LoanBook::findOrFail($id);

        if ($reservation->status !== 'rejected') {
            return redirect()->back()->with('error', 'Reservation not found or not rejected.');
        }

        $book = Book::find($reservation->book_id);

        if (!$book || $book->quantity < 1) {
            return redirect()->back()->with('error', 'The book is not available for re-approval.');
        }

        $reservation->update(['status' => 'reserved']);
        $book->update(['status' => 'available']);

        return redirect()->route('loans.index');
    }

}
