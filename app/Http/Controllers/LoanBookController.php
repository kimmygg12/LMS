<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanBook;
use App\Models\LoanBookHistory;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    public function indexloan(Request $request)
    {
        $books = Book::all();
        $search = $request->input('search');
        $members = Member::all();
        $loans = LoanBook::query()
            ->with('book', 'member')
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
        return view('loans.indexloan', compact('loans'));
    }

    public function create()
    {
        $books = Book::where('status', 'available')->get();
        $members = Member::all();
        return view('loans.create', compact('books', 'members'));
    }
    // public function show(LoanBook $loan)
    // {
    //     // Convert to DateTime objects
    //     $loanDate = new \DateTime($loan->loan_date);
    //     $dueDate = new \DateTime($loan->due_date);

    //     $formattedLoanDate = $loanDate->format('Y-m-d');
    //     $formattedDueDate = $dueDate->format('Y-m-d');

    //     return view('loans.show', compact('loan', 'formattedLoanDate', 'formattedDueDate'));
    // }
//     public function show($id)
// {
//     // Find the loan book by its ID
//     $loan = LoanBook::findOrFail($id);

    //     // Pass the loan book to the view
//         return view('loans.show', compact('loan'));
// }
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

        $invoice_number = $this->generateInvoiceNumber();

        $loan = LoanBook::create([
            'book_id' => $book->id,
            'member_id' => $request->member_id,
            'price' => $request->price,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
            'invoice_number' => $invoice_number,
        ]);

        $book->status = 'borrowed';
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
        $loan->update([
            'book_id' => $request->book_id,
            'member_id' => $request->member_id,
            'price' => $request->price,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
        ]);

        // Optionally, update the book status
        $book = Book::find($request->book_id);
        $book->status = $request->status === 'available' ? 'available' : 'borrowed';
        $book->save();

        return redirect()->route('loans.index');
    }

    private function generateInvoiceNumber()
    {
        $randomNumber = rand(100000, 999999);
        return 'INV-' . $randomNumber;
    }
    public function destroy($id)
    {
        $loan = LoanBook::findOrFail($id);

        // Optionally, update the book status if it was borrowed
        $book = Book::find($loan->book_id);
        if ($book) {
            $book->status = 'available'; // Mark as available when the loan is deleted
            $book->save();
        }

        $loan->delete();

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
            'renew_date' => 'nullable|after_or_equal:due_date',
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

            Book::find($loan->book_id)->update(['status' => 'available']);
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
                'invoice_number' => $loan->invoice_number,
                'renew_date' => $loan->renew_date,
                'fine' => $loan->fine,
                'fine_reason' => $loan->fine_reason,
                'status' => 'returned'
            ]);
            $loan->delete();
            Book::find($loan->book_id)->update(['status' => 'available']);
            return redirect()->route('loans.index');
        }
        // if (!$request->filled('pay_date') || !$request->filled('fine') || !$request->filled('fine_reason')) {
        //     return redirect()->back()->with('error', 'Please fill in all required fields.')->withInput();
        // }
        if (!$request->filled('renew_date') && !$request->filled('pay_date')) {
            return redirect()->back()->with('error', 'Please fill in both renew date and pay date.')->withInput();
        } elseif (!$request->filled('renew_date')) {
            return redirect()->back()->with('error', 'Please fill in the renew date.')->withInput();
        } elseif (!$request->filled('pay_date')) {
            return redirect()->back()->with('error', 'Please fill in the pay date.')->withInput();
        }

    }
    public function reportLoan(Request $request)
    {
        $period = $request->input('period', 'daily'); // Default to daily
        $dateRange = $this->getDateRange($period);

        // LoanBook statistics
        $loans = LoanBook::whereBetween('loan_date', [$dateRange['start'], $dateRange['end']])->get();

        $totalIssued = $loans->count();
        $totalReturned = $loans->where('status', 'returned')->count();
        $totalRenewed = $loans->whereNotNull('renew_date')->count();
        $totalPayments = $loans->whereNotNull('pay_date')->count();
        $totalFine = $loans->sum('fine');

        // Additional statistics
        $totalLoanDate = $loans->pluck('loan_date')->unique()->count();
        $totalReturnDate = $loans->pluck('pay_date')->filter()->unique()->count();
        $totalRenewDate = $loans->pluck('renew_date')->filter()->unique()->count();

        // LoanBookHistory statistics
        $loanHistory = LoanBookHistory::whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->get();
        $totalLoanHistory = $loanHistory->count();

        return view(
            'loans.reportLoan',
            compact(
                'totalIssued',
                'totalReturned',
                'totalRenewed',
                'totalPayments',
                'totalFine',
                'totalLoanHistory',
                'totalLoanDate',
                'totalReturnDate',
                'totalRenewDate',
                'period'
            )
        );
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
        $currentDate = Carbon::now()->toDateString();

        // Retrieve overdue books
        $overdueBooks = LoanBook::where('due_date', '<', $currentDate)
            ->where('status', 'borrowed')
            ->get();

        // Calculate overdue fines
        $overdueDetails = $overdueBooks->map(function ($loan) {
            $daysOverdue = Carbon::parse($loan->due_date)->diffInDays(Carbon::now());
            $fine = $daysOverdue * 300; // Example fine rate: $5 per overdue day

            return [
                'member' => $loan->member,
                'book' => $loan->book,
                'due_date' => $loan->due_date,
                'days_overdue' => $daysOverdue,
                'fine' => $fine
            ];
        });

        return view('loans.overdueBooksReport', compact('overdueDetails'));
    }

    public function indexReport()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $weeklyReports = LoanBook::whereBetween('loan_date', [$startOfWeek, $endOfWeek])->get();
        $monthlyReports = LoanBook::whereBetween('loan_date', [$startOfMonth, $endOfMonth])->get();
        $totalReports = LoanBook::all();

        return view('loans.reports', [
            'weeklyReports' => $weeklyReports,
            'monthlyReports' => $monthlyReports,
            'totalReports' => $totalReports
        ]);
    }

    public function reportTotalLoan()
    {

        $totalLoans = LoanBook::count();

        return view('loans.report_total', compact('totalLoans'));
    }



}
