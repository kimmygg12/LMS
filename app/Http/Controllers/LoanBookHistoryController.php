<?php


namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanBookHistory;
use App\Models\Member;
use Illuminate\Http\Request;

class LoanBookHistoryController extends Controller
{
    public function index()
    {

        $books = Book::all();
        $members = Member::all();
        $loanHistory = LoanBookHistory::with(['book', 'member'])->get();
        $totalLoanHistory = $loanHistory->count();
        $newHistory = LoanBookHistory::orderBy('created_at', 'desc')->first();

        return view('loanBookHistories.index', compact('loanHistory', 'totalLoanHistory', 'newHistory'));
    }


    public function show($id)
    {
        $members = Member::all();
        $books = Book::all();
        $loanHistory = LoanBookHistory::with(['book', 'member'])->findOrFail($id);

        return view('loanBookHistories.show', compact('loanHistory'));
    }

    public function print($id)
    {
        $loanHistory = LoanBookHistory::with(['book', 'member'])->findOrFail($id);

        return view('loanBookHistories.print', compact('loanHistory'));
    }
    public function memberLoanDetails($memberId)
    {
        $member = Member::findOrFail($memberId);
        $loanHistory = LoanBookHistory::where('member_id', $memberId)->with('book')->get();
        $loanHistoryCount = $loanHistory->count();

        return view('loanBookHistories.member-loan-details', compact('member', 'loanHistory', 'loanHistoryCount'));
    }
    // public function showInvoice($id)
    // {

    //     $loanHistory = LoanBookHistory::with('member', 'book')->findOrFail($id);
    //     return view('loanBookHistories.show-invoice-return', compact('loanHistory'));
    // }
    public function showInvoice($id)
    {
        // Fetch the loan details along with related member and book
        $loanHistory = LoanBookHistory::with('member', 'book')->findOrFail($id);

        // Get the search date and time from the request, if available
        $searchDate = request('date');
        $searchTime = request('time');

        // Query to get other loans by the same member, excluding the current loan
        $query = LoanBookHistory::with('book')
        ->where('member_id', $loanHistory->member_id)
        ->where('id', '!=', $id); // Exclude the current loan to avoid du

        // Apply filters based on search date and time
        if ($searchDate) {
            $query->whereDate('loan_date', $searchDate);
        }
        if ($searchTime) {
            $query->whereTime('loan_date', $searchTime);
        }

        // Get the filtered list of loans
        $memberLoans = $query->get();

        // Return the view with the loan history and other loans
        return view('loanBookHistories.show-invoice-return', compact('loanHistory', 'memberLoans', 'searchDate', 'searchTime'));
    }

}

