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

// app/Http/Controllers/AuthorController.php

public function edit($id)
{
    $author = Author::findOrFail($id);
    return response()->json($author);
}

public function update(Request $request, $id)
{
    $request->validate(['name' => 'required']);

    $author = Author::findOrFail($id);
    $author->update($request->all());

    return response()->json($author);
}

public function destroy($id)
{
    $author = Author::findOrFail($id);
    $author->delete();

    return response()->json(['success' => true]);
}

}
