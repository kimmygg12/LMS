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
       
        // $totalOverdue = 0;
        // $totalDeadlines = 0;
    
        // foreach ($loans as $loan) {
        //     $dueDate = Carbon::parse($loan->due_date);
        //     $renewDate = $loan->renew_date ? Carbon::parse($loan->renew_date) : null;
        //     $now = Carbon::now();
    
        //     // Check if due_date is overdue
        //     if ($dueDate->isPast() && (!$renewDate || $renewDate->isPast())) {
        //         $totalOverdue++;
        //     }
    
        //     // Check if due_date is within one day
        //     if ($dueDate->diffInDays($now) <= 1 && (!$renewDate || $renewDate->diffInDays($now) > 1)) {
        //         $totalDeadlines++;
        //     }
    
        //     // Update renew_date if due_date is overdue
        //     if ($dueDate->isPast() && (!$renewDate || $renewDate->isPast())) {
        //         $loan->renew_date = $now->addDays(7); // Example: Extend the renew_date by 7 days
        //         $loan->save();
        //     }
        // }
    
        // // Add the count of overdue loans to the total deadlines
        // $totalDeadlines += $totalOverdue;
    


    //     $currentDate = now()->startOfDay();

    // // Calculate total deadlines
    // $totalDueSoon = LoanBook::whereDate('due_date', $currentDate->copy()->addDay())
    //     ->where('status', 'borrowed')  // Only count borrowed books
    //     ->count();

    // $totalRenewSoon = LoanBook::whereDate('renew_date', $currentDate->copy()->addDay())
    //     ->where('status', 'borrowed')  // Only count borrowed books
    //     ->count();

    // // Calculate total count of deadlines
    // $totalDeadlines = $totalDueSoon + $totalRenewSoon;

    // // Calculate overdue books
    // $totalOverdue = LoanBook::whereDate('due_date', '<', $currentDate)
    //     ->where('status', 'borrowed')  // Only count borrowed books
    //     ->count();

    // // Add overdue count to total deadlines
    // $totalDeadlines += $totalOverdue;
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
