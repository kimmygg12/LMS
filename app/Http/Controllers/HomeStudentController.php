<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeStudentController extends Controller
{
    public function homeStudent(Request $request)
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

        $books = $query->paginate(5);

        return view('homestudents.index', compact('books'));
    }
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('homestudents.home-showbook', compact('book'));
    }

}
