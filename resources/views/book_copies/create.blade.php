@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Book Copy</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('book_copies.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="book_id">Book</label>
            <select name="book_id" id="book_id" class="form-control">
                @foreach ($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="copy_number">Copy Number</label>
            <input type="number" name="copy_number" id="copy_number" class="form-control">
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="available">Available</option>
                <option value="borrowed">Borrowed</option>
                <option value="reserved">Reserved</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Add</button>
    </form>
</div>
@endsection
