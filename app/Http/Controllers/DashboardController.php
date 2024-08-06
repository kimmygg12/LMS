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
    //     $bookCount = Book::count();
    //     $memberCount = Member::count();
    //     $loanBookCount = LoanBook::count();
    //     $loans = LoanBook::all();
       
    // $currentDate = Carbon::now()->toDateString();
        
    // // Retrieve overdue books
    // $overdueBooks = LoanBook::where('due_date', '<', $currentDate)
    //     ->where('status', 'borrowed')
    //     ->get();

    // // Calculate overdue fines
    // $overdueDetails = $overdueBooks->map(function ($loan) {
    //     $daysOverdue = Carbon::parse($loan->due_date)->diffInDays(Carbon::now());
    //     $fine = $daysOverdue * 5; // Example fine rate: $5 per overdue day

    //     return [
    //         'member' => $loan->member,
    //         'book' => $loan->book,
    //         'due_date' => $loan->due_date,
    //         'days_overdue' => $daysOverdue,
    //         'fine' => $fine
    //     ];
    // });
    //   // Calculate totals
    //   $totalOverdueBooks = $overdueDetails->count();
    //   $totalFine = $overdueDetails->sum('fine');
  

    
    //     return view('dashboard.index', compact('bookCount', 'memberCount', 'loanBookCount', 'loans','totalOverdueBooks'));
    // }
    // public function Payments(Request $request)
    // {
    //     // Retrieve action from the request
    //     $action = $request->input('action', 'loan'); // Default to loan
        
    //     // Define query based on action type
    //     $query = LoanBook::query();
        
    //     if ($action === 'return') {
    //         // Filter for returned loans
    //         $query->whereNotNull('pay_date');
    //     } else {
    //         // Default to loan action, you can add specific filters here if needed
    //         $query->whereNull('pay_date'); // Assuming you want to filter out returned loans
    //     }
        
    //     // Calculate total loans based on loan_date
    //     $totalLoansByLoanDate = $query->count();
        
    //     // Calculate total loans based on pay_date
    //     $totalLoansByPayDate = LoanBook::whereNotNull('pay_date')->count();
        
    //     // Fetch loan data based on action
    //     $loans = $query->with('book', 'member', 'member.study', 'member.category')->get();
        
    //     // Return the view with the data
    //     return view('dashboard.Payments', compact('totalLoansByLoanDate', 'totalLoansByPayDate', 'action', 'loans'));
    // }
    $bookCount = Book::count();
        $memberCount = Member::count();
        $loanBookCount = LoanBook::count();
        $loans = LoanBook::all();
        $currentDate = Carbon::now()->toDateString();
        $totalQuantity = Book::sum('quantity'); 
        $borrowedQuantity = LoanBook::whereNull('returned_at')->sum('quantity');

        $totalLoanedBooks = LoanBook::where('status', 'borrowed')
        ->sum('quantity'); // Sum the quantity of loaned books

        $overdueBooks = LoanBook::where('due_date', '<', $currentDate)
            ->where('status', 'borrowed')
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
          // Calculate totals
          $totalOverdueBooks = $overdueDetails->count();
          $totalFine = $overdueDetails->sum('fine');
      
          $availableQuantity = $totalQuantity + $borrowedQuantity;
        
            return view('dashboard.index', compact('bookCount', 'memberCount','totalLoanedBooks','loanBookCount', 'loans','totalOverdueBooks','totalQuantity','availableQuantity'));
        }
    
}
