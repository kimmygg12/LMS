<?php

namespace App\Http\Controllers;

use App\Models\LoanBookHistory;
use App\Models\Member;

class LoanBookHistoryController extends Controller
{
    public function index()
    {
        $members = Member::all();
        $loanHistory = LoanBookHistory::with(['book', 'member'])->get();
        return view('loanBookHistories.index', compact('loanHistory'));
    }
    public function show($id)
    {
        $members = Member::all();
        $loanHistory = LoanBookHistory::with(['book', 'member'])->findOrFail($id);

        return view('loanBookHistories.show', compact('loanHistory'));
    }

    public function print($id)
    {
        $loanHistory = LoanBookHistory::with(['book', 'member'])->findOrFail($id);

        return view('loanBookHistories.print', compact('loanHistory'));
    }
}
