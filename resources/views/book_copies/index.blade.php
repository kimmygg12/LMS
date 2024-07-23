@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Book Copies</h1>
    <a href="{{ route('book_copies.create') }}" class="btn btn-primary">Add Book Copy</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Book</th>
                <th>Copy Number</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookCopies as $copy)
            <tr>
                <td>{{ $copy->id }}</td>
                <td>{{ $copy->book->title }}</td>
                <td>{{ $copy->copy_number }}</td>
                <td>{{ $copy->status }}</td>
                <td>
                    <a href="{{ route('book_copies.show', $copy->id) }}" class="btn btn-info">Show</a>
                    <a href="{{ route('book_copies.edit', $copy->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('book_copies.destroy', $copy->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
