<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('query');

        $authors = Author::where('name', 'like', '%' . $query . '%')->get();

        return response()->json($authors);
    }


    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }
    public function create()
    {
        return view('authors.create');
    }
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        return Author::create($request->all());
    }
    
    public function show(Author $author)
    {
        return view('authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate(['name' => 'required']);
        $author->update($request->all());
        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}
