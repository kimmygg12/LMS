@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Book</h1>
        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label for="author_id" class="form-label">Author</label>
                <div class="input-group">
                    <select class="form-control" id="author_id" name="author_id" required>
                        <option value="">Select an author</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
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
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn') }}" >
            </div>
            <div class="form-group">
                <label for="publication_date">ឆ្នាំបោះពុម្ព:</label>
                <input type="date" name="publication_date" class="form-control" id="publication_date"
                    value="{{ old('publication_date') }}"required>
            </div>
            {{-- <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
            </div>  --}}
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
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
