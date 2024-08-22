<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanBook;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::guard('member')->check()) {
            return view('students.dashboard');
        }

        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            $currentDate = Carbon::now()->toDateString();

            // Common data for both user and admin
            $bookCount = Book::count();
            $memberCount = Member::count();
            $loanBookCount = LoanBook::count();
            $totalQuantity = Book::sum('quantity');
            $borrowedQuantity = LoanBook::whereNull('returned_at')->sum('quantity');
            $totalLoanedBooks = LoanBook::where('status', 'borrowed')->sum('quantity');

            // Overdue books
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
        

            $overdueDetails = $overdueBooks->map(function ($loan) use ($currentDate) {
                $actualDueDate = $loan->renew_date ?? $loan->due_date;
                $daysOverdue = Carbon::parse($actualDueDate)->diffInDays(Carbon::now());
                $fine = $daysOverdue * 500; // Example fine rate: $5 per overdue day

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
            $availableQuantity = $totalQuantity - $borrowedQuantity;

            if ($usertype === 'user') {
                return view('dashboard', compact('bookCount', 'memberCount', 'totalLoanedBooks', 'loanBookCount', 'totalOverdueBooks', 'totalQuantity', 'availableQuantity'));
            } elseif ($usertype === 'admin') {
                return view('admin.adminhome', compact('bookCount', 'memberCount', 'totalLoanedBooks', 'loanBookCount', 'totalOverdueBooks', 'totalQuantity', 'availableQuantity'));
            }
        }

        return redirect()->route('login');
    }
}
