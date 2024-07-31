<?php

// namespace App\Http\Controllers;

// use App\Models\LoanBookHistory;
// use App\Models\Member;

// class LoanBookHistoryController extends Controller
// {
//     public function index()
//     {
//         $members = Member::all();
//         $loanHistory = LoanBookHistory::with(['book', 'member'])->get();
//         return view('loanBookHistories.index', compact('loanHistory'));
//     }
//     public function show($id)
//     {
//         $members = Member::all();
//         $loanHistory = LoanBookHistory::with(['book', 'member'])->findOrFail($id);

//         return view('loanBookHistories.show', compact('loanHistory'));
//     }

//     public function print($id)
//     {
//         $loanHistory = LoanBookHistory::with(['book', 'member'])->findOrFail($id);

//         return view('loanBookHistories.print', compact('loanHistory'));
//     }
// }

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
        $totalLoanHistory = $loanHistory->count(); // Total count of loan histories

        return view('loanBookHistories.index', compact('loanHistory', 'totalLoanHistory'));
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
}

