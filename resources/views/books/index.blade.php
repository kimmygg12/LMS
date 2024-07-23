@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Books</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                {{ $message }}
            </div>
        @endif
        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Author ID</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Publication Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author->name }}</td>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->publication_date }}</td>
                        {{-- <td>{{ $book->status }}</td> --}}
                        <td>
                            @if ($book->status === 'available')
                                <span class="badge badge-success">ទំនេរ</span>
                            @elseif ($book->status === 'borrowed')
                                <span class="badge badge-warning">មិនទំនេរ</span>
                            @elseif ($book->status === 'reserved')
                                <span class="badge badge-secondary">Reserved</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
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
