@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Book Copy Details</h1>
    <p><strong>ID:</strong> {{ $bookCopy->id }}</p>
    <p><strong>Book:</strong> {{ $bookCopy->book->title }}</p>
    <p><strong>Copy Number:</strong> {{ $bookCopy->copy_number }}</p>
    <p><strong>Status:</strong> {{ $bookCopy->status }}</p>
    <a href="{{ route('book_copies.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
