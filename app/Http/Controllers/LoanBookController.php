<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanBook;
use App\Models\LoanBookHistory;
use App\Models\Member;
use Illuminate\Http\Request;

class LoanBookController extends Controller
{
    public function index()
    {

        $loans = LoanBook::all();
        $members = Member::all();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $books = Book::where('status', 'available')->get();
        $members = Member::all();
        return view('loans.create', compact('books', 'members'));
    }
    public function show(LoanBook $loan)
    {
        return view('Loans.show', compact('loan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'price' => 'required|numeric',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
        ]);

        $invoice_number = $this->generateInvoiceNumber();

        $loan = LoanBook::create([
            'book_id' => $request->book_id,
            'member_id' => $request->member_id,
            'price' => $request->price,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
            'invoice_number' => $invoice_number,
        ]);
        // LoanBookHistory::create([
        //     'loan_book_id' => $loan->id,
        //     'book_id' => $loan->book_id,
        //     'member_id' => $loan->member_id,
        //     'price' => $loan->price,
        //     'loan_date' => $loan->loan_date,
        //     'invoice_number' => $loan->invoice_number,
        // ]);

        $book = Book::find($request->book_id);
        $book->status = 'borrowed';
        $book->save();

        return redirect()->route('loans.index')->with('success', 'Loan created successfully.');
    }
    private function generateInvoiceNumber()
    {
        $lastInvoice = LoanBook::orderBy('id', 'desc')->first();
        $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        return 'INV' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
    public function return(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|exists:loan_books,invoice_number',
        ]);
        $loan = LoanBook::where('invoice_number', $request->invoice_number)->firstOrFail();

        LoanBookHistory::create([
            'loan_book_id' => $loan->id,
            'book_id' => $loan->book_id,
            'member_id' => $loan->member_id,
            'price' => $loan->price,
            'loan_date' => $loan->loan_date,
            'invoice_number' => $loan->invoice_number,
            'renew_date' => $loan->renew_date,
            'fine' => $loan->fine,
            'fine_reason' => $loan->fine_reason,
        ]);

        $loan->delete();
        Book::find($loan->book_id)->update(['status' => 'available']);

        return redirect()->route('loans.index')->with('success', 'Book returned successfully!');
    }
    public function renew(Request $request, $id)
    {
        $request->validate([
            'due_date' => 'required|date|after_or_equal:loan_date',
            'renew_date' => 'required|date',
        ]);

        $loan = LoanBook::findOrFail($id);

        if ($loan->status !== 'borrowed') {
            return redirect()->back()->with('error', 'The book is not currently borrowed.');
        }

        $loan->update([
            'due_date' => $request->input('due_date'),
            'renew_date' => $request->input('renew_date'),
        ]);

        LoanBookHistory::create([
            'loan_book_id' => $loan->id,
            'book_id' => $loan->book_id,
            'member_id' => $loan->member_id,
            'price' => $loan->price,
            'loan_date' => $loan->loan_date,
            'invoice_number' => $loan->invoice_number,
            'renew_date' => $loan->renew_date,
            'fine' => $loan->fine,
            'fine_reason' => $loan->fine_reason,
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan successfully renewed.');
    }
    public function showFinebookForm($id)
    {
        $members = Member::all();
        $loan = LoanBook::findOrFail($id);
        return view('loans.finebook', compact('loan'));
    }
    public function finebook(Request $request, $id)
    {
        $request->validate([
            'due_date' => 'required|date|after_or_equal:loan_date',
            'renew_date' => 'required|date',
            'fine' => 'nullable|numeric',
            'fine_reason' => 'nullable|string',
        ]);

        $loan = LoanBook::findOrFail($id);

        if ($loan->status !== 'borrowed') {
            return redirect()->back()->with('error', 'The book is not currently borrowed.');
        }

        $loan->update([
            'due_date' => $request->input('due_date'),
            'renew_date' => $request->input('renew_date'),
            'fine' => $request->input('fine') ?? 0,
            'fine_reason' => $request->input('fine_reason'),
        ]);

        LoanBookHistory::create([
            'loan_book_id' => $loan->id,
            'book_id' => $loan->book_id,
            'member_id' => $loan->member_id,
            'price' => $loan->price,
            'loan_date' => $loan->loan_date,
            'invoice_number' => $loan->invoice_number,
            'renew_date' => $loan->renew_date,
            'fine' => $loan->fine,
            'fine_reason' => $loan->fine_reason,
        ]);
        $loan->delete();
        Book::find($loan->book_id)->update(['status' => 'available']);
        return redirect()->route('loans.index')->with('success', 'Loan successfully renewed.');
    }
    // public function history()
    // {
    //     $loans = LoanBook::all();
    //     return view('loans.history', compact('loans'));
    // }
    // public function history()
    // {
    //     $loanHistories = LoanBookHistory::all();
    //     return view('loanBookHistories.index', compact('loanHistories'));
    // }

}
