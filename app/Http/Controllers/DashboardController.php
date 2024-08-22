<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanBook;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bookCount = Book::count();
        $memberCount = Member::count();
        $loanBookCount = LoanBook::count();
        $loans = LoanBook::all();
        $currentDate = Carbon::now()->toDateString();
        $totalQuantity = Book::sum('quantity');
        $borrowedQuantity = LoanBook::whereNull('returned_at')->sum('quantity');

        $totalLoanedBooks = LoanBook::where('status', 'borrowed')
            ->sum('quantity'); // Sum the quantity of loaned books

            $overdueBooks = LoanBook::where('status', 'borrowed')
            ->where(function ($query) use ($currentDate) {
                $query->where(function ($query) use ($currentDate) {
                    // Show if due_date < currentDate and renew_date is null
                    $query->where('due_date', '<', $currentDate)
                          ->whereNull('renew_date');
                })
                ->orWhere(function ($query) use ($currentDate) {
                    // Show if due_date < currentDate and renew_date < currentDate
                    $query->whereNotNull('renew_date')
                          ->where('due_date', '<', $currentDate)
                          ->where('renew_date', '<', $currentDate);
                });
            })
            ->get();
        $overdueDetails = $overdueBooks->map(function ($loan) {
            $daysOverdue = Carbon::parse($loan->due_date)->diffInDays(Carbon::now());
            $fine = $daysOverdue * 5; // Example fine rate: $5 per overdue day

            return [
                'member' => $loan->member,
                'book' => $loan->book,
                'due_date' => $loan->due_date,
                'days_overdue' => $daysOverdue,
                'fine' => $fine
            ];
        });
        $totalOverdueBooks = $overdueDetails->count();
        $totalFine = $overdueDetails->sum('fine');

        $availableQuantity = $totalQuantity + $borrowedQuantity;

        return view('dashboard.index', compact('bookCount', 'memberCount', 'totalLoanedBooks', 'loanBookCount', 'loans', 'totalOverdueBooks', 'totalQuantity', 'availableQuantity'));
    }

}
