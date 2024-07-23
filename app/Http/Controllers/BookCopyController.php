<?php
namespace App\Http\Controllers;

use App\Models\BookCopy;
use App\Models\Book;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BookCopyController extends Controller
{
    public function index()
    {
        $bookCopies = BookCopy::with('book')->get();
        return view('book_copies.index', compact('bookCopies'));
    }

    public function create()
    {
        $books = Book::all();
        return view('book_copies.create', compact('books'));
    }


    public function store(Request $request)
    {
        try {
            // Validate and store book copy
            $validatedData = $request->validate([
                'book_id' => 'required|exists:books,id',
                'copy_number' => 'required|integer',
                'status' => 'required|in:available,borrowed,reserved',
            ]);

            $bookCopy = BookCopy::create($validatedData);

            return redirect()->route('book_copies.index')
                             ->with('success', 'Book copy created successfully.');
        } catch (QueryException $e) {
            // Handle duplicate entry error
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) { // 1062 is the MySQL error code for duplicate entry
                return back()->withInput()->withErrors(['error' => 'Duplicate entry. This book copy already exists.']);
            }

            // Handle other possible query exceptions
            return back()->withInput()->withErrors(['error' => 'Error creating book copy.']);
        }
    }

    public function show(BookCopy $bookCopy)
    {
        return view('book_copies.show', compact('bookCopy'));
    }

    public function edit(BookCopy $bookCopy)
    {
        $books = Book::all();
        return view('book_copies.edit', compact('bookCopy', 'books'));
    }

    public function update(Request $request, BookCopy $bookCopy)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'copy_number' => 'required|integer',
            'status' => 'required|in:available,borrowed,reserved',
        ]);

        $bookCopy->update($request->all());

        return redirect()->route('book_copies.index')->with('success', 'Book Copy updated successfully.');
    }

    public function destroy(BookCopy $bookCopy)
    {
        $bookCopy->delete();
        return redirect()->route('book_copies.index')->with('success', 'Book Copy deleted successfully.');
    }
}
