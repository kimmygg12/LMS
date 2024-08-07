<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\LoanBook;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where('title', 'LIKE', "%$query%")
            ->orWhere('author', 'LIKE', "%$query%")
            ->orWhere('isbn', 'LIKE', "%$query%")
            ->paginate(10);

        return view('books.index', compact('books'))->render();
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Book::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('isbn', 'like', "%{$search}%")
                ->orWhereHas('author', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }
        $books = $query->with('author', 'subject')->paginate(3);
        $newBooks = Book::orderBy('created_at', 'desc')->limit(1)->get();
        return view('books.index', compact('books', 'newBooks', 'search'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $authors = Author::all(); // Fetch all authors
        $subjects = Subject::all(); // Fetch all subjects
    
        return view('books.create', compact('authors', 'subjects'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'nullable|string|max:200',
            'publication_date' => 'nullable|date',
            'description' => 'nullable|string',
            'subject_id' => 'nullable|integer|exists:subjects,id',
            'status' => 'nullable|in:available,borrowed,reserved',
            'quantity' => 'required|integer|min:1', // Add quantity validation
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Create new book instance
            $book = new Book();
            $book->title = $request->title;
            $book->author_id = $request->author_id;
            $book->isbn = $request->isbn;
            $book->publication_date = $request->publication_date;
            $book->description = $request->description;
            $book->quantity = $request->quantity; // Set quantity
            $book->subject_id = $request->subject_id;

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('covers'), $imageName);
                $book->cover_image = 'covers/' . $imageName;

            }

            // Save book
            $book->save();

            // Redirect with success message
            return redirect()->route('books.index');

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle duplicate entry
            if ($e->getCode() == '23000') { // Duplicate entry code
                return redirect()->back()->with('error', 'The ISBN has already been taken.')->withInput();
            }

            // Handle other exceptions
            return redirect()->back()->with('error', 'An error occurred while saving the book.')->withInput();
        }
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        $subjects = Subject::all();
        return view('books.edit', compact('book', 'authors', 'subjects'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required|string|unique:books,isbn,' . $id,
            'publication_date' => 'required|date',
            'description' => 'nullable|string',
            'subject_id' => 'nullable|integer|exists:subjects,id',
            'status' => 'required|string',
            'quantity' => 'required|integer|min:1', // Add quantity validation
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->author_id = $request->author_id;
        $book->isbn = $request->isbn;
        $book->publication_date = $request->publication_date;
        $book->description = $request->description;
        $book->status = $request->status;
            $book->subject_id = $request->subject_id;
            $book->quantity = $request->quantity; // Update quantity


        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $image = $request->file('cover_image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('covers'), $imageName);
            $book->cover_image = 'covers/' . $imageName;
        }

        $book->save();


        return redirect()->route('books.index');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);



        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->back();
    }
}
