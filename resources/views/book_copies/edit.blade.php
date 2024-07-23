@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Book Copy</h1>
    <form action="{{ route('book_copies.update', $bookCopy->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="book_id">Book</label>
            <select name="book_id" id="book_id" class="form-control">
                @foreach ($books as $book)
                    <option value="{{ $book->id }}" {{ $book->id == $bookCopy->book_id ? 'selected' : '' }}>{{ $book->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="copy_number">Copy Number</label>
            <input type="number" name="copy_number" id="copy_number" class="form-control" value="{{ $bookCopy->copy_number }}">
        </div>
        <div class="form-group">
            {{-- <label for="status">Status</label>
            <input type="text" name="status" id="status" class="form-control" value="{{ $bookCopy->status }}"> --}}
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="available">Available</option>
                <option value="borrowed">Borrowed</option>
                <option value="reserved">Reserved</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
