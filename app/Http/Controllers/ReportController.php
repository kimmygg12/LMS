<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanBook;
use App\Models\LoanBookHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $books = Book::all();

        $bookRecords = $books->map(function ($book) {
            // Total number of times the book has been borrowed
            $totalBorrowed = LoanBook::where('book_id', $book->id)
                ->sum('quantity');

            // Quantity of the book that is currently on loan
            $quantityOnLoan = LoanBook::where('book_id', $book->id)
                ->whereNull('returned_at')
                ->sum('quantity');

            // Remaining quantity of the book
            $remainingQuantity = $book->quantity - $quantityOnLoan;

            // Loan history with count of entries
            $loanHistory = LoanBookHistory::where('book_id', $book->id)
                ->orderBy('pay_date', 'desc')
                ->get();

            // Count of the loan history entries
            $loanHistoryCount = $loanHistory->count();

            return [
                'title' => $book->title,
                'remaining_quantity' => $remainingQuantity,
                'quantity_on_loan' => $quantityOnLoan,
                'total_borrowed' => $totalBorrowed,
                'loan_history' => $loanHistory,
                'loan_history_count' => $loanHistoryCount
            ];
        });

        return view('reports.index', ['bookRecords' => $bookRecords]);
    }
    public function combinedReport(Request $request)
    {
        $action = $request->input('action', 'loan');
        $startDate = Carbon::parse($request->input('start_date', Carbon::now()->startOfMonth()));
        $endDate = Carbon::parse($request->input('end_date', Carbon::now()->endOfMonth()));

        // Query LoanBook
        $query = LoanBook::whereBetween('loan_date', [$startDate, $endDate])
            ->orWhereBetween('pay_date', [$startDate, $endDate])
            ->orWhereBetween('renew_date', [$startDate, $endDate]);

        if ($action === 'return') {
            $query->whereNotNull('pay_date');
        }

        $totalLoansByLoanDate = $query->count();
        $totalLoansByPayDate = LoanBookHistory::whereBetween('pay_date', [$startDate, $endDate])->count();

        // Filter LoanBook data based on action
        $loans = ($action === 'loan' || $action === 'return')
            ? $query->with('book', 'member', 'member.study', 'member.category')->get()
            : collect();

        $historyData = $action === 'return'
            ? LoanBookHistory::whereBetween('loan_date', [$startDate, $endDate])
                ->whereNotNull('pay_date')
                ->with('book', 'member')
                ->get()
            : collect();

        $topBorrowedBooks = [];
        if ($action === 'topBorrowedBooks') {
            $topBorrowedBooks = Book::withCount([
                'loanBooks as total_borrowed' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('loan_date', [$startDate, $endDate]);
                },
                'loanBooks as quantity_on_loan' => function ($query) {
                    $query->whereNull('pay_date');
                },
                'loanBookHistories as loan_history_count' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('loan_date', [$startDate, $endDate]);
                }
            ])
                ->get()
                ->map(function ($book) {
                    $remainingQuantity = $book->quantity + $book->quantity_on_loan;
                    $remainingQuantityCount = $book->quantity_on_loan + $book->loan_history_count;

                    return [
                        'book' => $book,
                        'total_borrowed' => $book->total_borrowed,
                        'remaining_quantity' => $remainingQuantity,
                        'quantity_on_loan' => $book->quantity_on_loan,
                        'loanHistoryCount' => $book->loan_history_count,
                        'remainingQuantitycount' => $remainingQuantityCount,
                    ];
                })
                ->filter(function ($item) {
                    return $item['total_borrowed'] > 0 || $item['loanHistoryCount'] > 0;
                })
                ->sortByDesc('total_borrowed')
                ->values();
        }

        return view(
            'reports.combinedReport',
            compact(
                'totalLoansByLoanDate',
                'totalLoansByPayDate',
                'action',
                'loans',
                'historyData',
                'topBorrowedBooks',
                'startDate',
                'endDate'
            )
        );
    }

    public function newBooks(Request $request)
    {
        // Default to the current month if no dates are provided
        $startDate = Carbon::parse($request->input('start_date', Carbon::now()->startOfMonth()));
        $endDate = Carbon::parse($request->input('end_date', Carbon::now()->endOfMonth()));
    
        // Fetch and sort books added within the specified date range
        $newBooks = Book::whereBetween('created_at', [$startDate, $endDate])
                        ->orderBy('created_at', 'desc') // Order by newest first
                        ->get();
    
        return view('reports.new_books', compact('newBooks', 'startDate', 'endDate'));
    }
    
    
}
