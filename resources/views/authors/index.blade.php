<!-- resources/views/authors/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Authors</h1>
    <a href="{{ route('authors.create') }}" class="btn btn-primary">Add New Author</a>
    <ul class="list-group mt-3">
        @foreach($authors as $author)
        <li class="list-group-item">{{ $author->name }}</li>
        @endforeach
    </ul>
</div>
@endsection
