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
        
        // Retrieve overdue books
        $overdueBooks = LoanBook::where('due_date', '<', $currentDate)
            ->where('status', 'borrowed')
            ->get();
    
        // Calculate overdue fines
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
          // Calculate totals
          $totalOverdueBooks = $overdueDetails->count();
          $totalFine = $overdueDetails->sum('fine');
      
    
        
            return view('dashboard.index', compact('bookCount', 'memberCount', 'loanBookCount', 'loans','totalOverdueBooks'));
        }
     
}
