<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
   
    // public function showBook(Book $book)
    // {
    //     return view('members.student-book', compact('book'));
    // }

    // public function searchBooks(Request $request)
    // {
    //     $search = $request->input('search');
    //     return redirect()->route('home.student', ['search' => $search]);
    // }
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $books = Book::where('title', 'LIKE', "%$query%")
            ->orWhere('isbn', 'LIKE', "%$query%")
            ->orWhereHas('authors', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%");
            })
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
                ->orWhereHas('authors', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }
    
        $books = $query->with('authors', 'genre')
            ->orderBy('created_at', 'desc')
            ->paginate(3);
    
        // Get the most recently created book
        $newBooks = Book::orderBy('created_at', 'desc')->limit(1)->get();
    
        return view('books.index', compact('books', 'newBooks', 'search'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    

    public function create()
    {
        $authors = Author::all(); // Fetch all authors
        $genres = Genre::all(); // Fetch all genres

        return view('books.create', compact('authors', 'genres'));
    }
    public function store(Request $request)
    {
        // Validation rules
        $validation = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|array',
            'author_id.*' => 'exists:authors,id',
            'isbn' => 'nullable|string|max:200|unique:books,isbn,' . ($request->input('id') ?? 'NULL'),
            'publication_date' => 'nullable|date',
            'description' => 'nullable|string',
            'genre_id' => 'nullable|integer|exists:genres,id',
            'status' => 'nullable|in:available,borrowed,reserved',
            'quantity' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        DB::beginTransaction();
    
        try {
            $bookId = $request->input('id');
            $status = $request->input('quantity') < 1 ? 'unavailable' : $request->input('status', 'available');
            if ($bookId) {
                // Update existing book
                $book = Book::findOrFail($bookId);
                $book->title = $request->title;
                $book->isbn = $request->isbn;
                $book->publication_date = $request->publication_date;
                $book->description = $request->description;
                $book->quantity = $request->quantity;
                $book->genre_id = $request->genre_id;
    
                if ($request->hasFile('cover_image')) {
                    $image = $request->file('cover_image');
                    $imageName = time() . '.' . $image->extension();
                    $image->move(public_path('covers'), $imageName);
                    $book->cover_image = 'covers/' . $imageName;
                }
            
                $book->save();
                $book->authors()->sync($request->author_id);
            } else {
                // Create new book
                $book = new Book();
                $book->title = $request->title;
                $book->isbn = $request->isbn;
                $book->publication_date = $request->publication_date;
                $book->description = $request->description;
                $book->quantity = $request->quantity;
                $book->genre_id = $request->genre_id;
                $book->status = $status;
    
                if ($request->hasFile('cover_image')) {
                    $image = $request->file('cover_image');
                    $imageName = time() . '.' . $image->extension();
                    $image->move(public_path('covers'), $imageName);
                    $book->cover_image = 'covers/' . $imageName;
                }
    
                $book->save();
                $book->authors()->attach($request->author_id);
            }
    
            DB::commit();
            return redirect()->route('books.index')->with('success', __('messages.book_added_successfully'));
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            if ($e->getCode() == '23000') { // Unique constraint violation
                return redirect()->back()->with('error', __('messages.isbn_taken'));
            } else {
                return redirect()->back()->with('error', __('messages.error_occurred'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('messages.error_occurred'));
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
        $genres = Genre::all(); // Fetch all genres
        return view('books.edit', compact('book', 'authors', 'genres'));
    }


    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'author_id' => 'required|exists:authors,id',
    //         'isbn' => 'required|string|unique:books,isbn,' . $id,
    //         'publication_date' => 'required|date',
    //         'description' => 'nullable|string',
    //         'genre_id' => 'nullable|integer|exists:genres,id',
    //         'status' => 'required|string',
    //         'quantity' => 'required|integer|min:1', // Add quantity validation
    //         'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $book = Book::findOrFail($id);
    //     $book->title = $request->title;
    //     $book->author_id = $request->author_id;
    //     $book->isbn = $request->isbn;
    //     $book->publication_date = $request->publication_date;
    //     $book->description = $request->description;
    //     $book->status = $request->status;
    //     $book->genre_id = $request->genre_id;
    //     $book->quantity = $request->quantity; // Update quantity


    //     if ($request->hasFile('cover_image')) {
    //         // Delete old cover image
    //         if ($book->cover_image) {
    //             Storage::disk('public')->delete($book->cover_image);
    //         }
    //         $image = $request->file('cover_image');
    //         $imageName = time() . '.' . $image->extension();
    //         $image->move(public_path('covers'), $imageName);
    //         $book->cover_image = 'covers/' . $imageName;
    //     }

    //     $book->save();


    //     return redirect()->route('books.index');
    // }
    public function update(Request $request, $id)
    {
        // Validation rules
        $validation = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|array',
            'author_id.*' => 'exists:authors,id',
            'isbn' => 'nullable|string|max:200|unique:books,isbn,' . $id,
            'publication_date' => 'nullable|date',
            'description' => 'nullable|string',
            'genre_id' => 'nullable|integer|exists:genres,id',
            'status' => 'nullable|in:available,borrowed,reserved',
            'quantity' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        DB::beginTransaction();
    
        try {
            $book = Book::findOrFail($id);
            $book->title = $request->title;
            $book->isbn = $request->isbn;
            $book->publication_date = $request->publication_date;
            $book->description = $request->description;
            $book->quantity = $request->quantity;
            $book->genre_id = $request->genre_id;
            if ($request->quantity < 1) {
                $book->status = 'unavailable';
            } else {
                $book->status = $request->status;
            }
            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('covers'), $imageName);
                $book->cover_image = 'covers/' . $imageName;
            }
    
            $book->save();
            $book->authors()->sync($request->author_id);
    
            DB::commit();
            return redirect()->route('books.index')->with('success', __('messages.book_updated_successfully'));
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            if ($e->getCode() == '23000') { // Unique constraint violation
                return redirect()->back()->with('error', __('messages.isbn_taken'));
            } else {
                return redirect()->back()->with('error', __('messages.error_occurred'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('messages.error_occurred'));
        }
    }
    
    
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Check if the user is an admin
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $book->delete();

            return redirect()->route('books.index')->with('success', __('messages.book_deleted_successfully'));
        } else {
            return redirect()->route('books.index')->with('error', __('messages.permission_denied'));
        }
    }
}
