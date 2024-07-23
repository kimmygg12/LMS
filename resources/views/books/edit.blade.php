@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <h1>Edit Book</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('books.update', $book->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $book->title ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="author_id" class="form-label">Author</label>
                    <div class="input-group">
                        <select class="form-control" id="author_id" name="author_id" required>
                            <option value="">Select an author</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}" {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" id="btn-search-authors"
                                data-bs-toggle="modal" data-bs-target="#addAuthorModal">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" class="form-control" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}">
                </div>
                <div class="form-group">
                    <label for="publication_date">Publication Date</label>
                    <input type="date" class="form-control" name="publication_date" id="publication_date" value="{{ old('publication_date', $book->publication_date) }}">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description">{{ old('description', $book->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="available" {{ $book->status == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="borrowed" {{ $book->status == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                        <option value="reserved" {{ $book->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Book</button>
            </form>
        </div>

    </div>

    <div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAuthorModalLabel">Add New Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAuthorForm">
                        <div class="mb-3">
                            <label for="authorName" class="form-label">Author Name</label>
                            <input type="text" class="form-control" id="authorName" name="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#author_id').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
    <script>
        document.getElementById('addAuthorForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('authorName').value;

            fetch('{{ route('authors.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const newOption = new Option(data.name, data.id, false, false);
                    document.getElementById('author_id').appendChild(newOption);
                    document.getElementById('author_id').value = data.id;
                    document.querySelector('.btn-close').click();
                });
        });
    </script>
@endsection
