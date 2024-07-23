<!-- resources/views/books/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $book->title }}</h1>
        <p><strong>Author:</strong> {{ $book->author->name }}</p>
        <p><strong>Other Authors:</strong></p>
        <ul>
            @foreach($book->otherAuthors as $otherAuthor)
                <li>{{ $otherAuthor->name }}</li>
            @endforeach
        </ul>
    </div>
@endsection
