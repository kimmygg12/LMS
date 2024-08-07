<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanBook;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        
        $bookCount = Book::count();
        $memberCount = Member::count();
        $loanBookCount = LoanBook::count();
        $loans = LoanBook::all();
        $currentDate = Carbon::now()->toDateString();
        $totalQuantity = Book::sum('quantity'); 
        $borrowedQuantity = LoanBook::whereNull('returned_at')->sum('quantity');

        $totalLoanedBooks = LoanBook::where('status', 'borrowed')
        ->sum('quantity'); // Sum the quantity of loaned books

        $overdueBooks = LoanBook::where(function ($query) use ($currentDate) {
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
        ->where('status', 'borrowed')
        ->get();
    
        // Calculate overdue fines
        $overdueDetails = $overdueBooks->map(function ($loan) use ($currentDate) {
            // Determine the actual due date considering renewals
            $actualDueDate = isset($loan->renew_date) ? $loan->renew_date : $loan->due_date;
            $daysOverdue = Carbon::parse($actualDueDate)->diffInDays(Carbon::now());
            $fine = $daysOverdue * 500; // Example fine rate: $5 per overdue day
    
            return [
                'member' => $loan->member,
                'book' => $loan->book,
                'loan_date' => $loan->loan_date,
                'due_date' => $loan->due_date,
                'renew_date' => $loan->renew_date,
                'days_overdue' => $daysOverdue,
                'invoice_number' => $loan->invoice_number ,
                'fine' => $fine,
                'id' => $loan->id, // Add this line to include the loan
            ];
        });
        $totalOverdueBooks = $overdueBooks->count();
      
          $availableQuantity = $totalQuantity + $borrowedQuantity;
        
            return view('dashboard.index', compact('bookCount', 'memberCount','totalLoanedBooks','loanBookCount', 'loans','totalOverdueBooks','totalQuantity','availableQuantity'));
        }
     
}
