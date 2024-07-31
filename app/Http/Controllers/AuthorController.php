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
        return Author::all();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        return Author::create($request->all());
    }
}
