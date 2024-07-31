@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>
                    បន្ថែមសៀវភៅថ្មី</h1>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="title">ចំណងជើង</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="author_id" class="form-label">អ្នកនិពន្ធ</label>
                                <div class="input-group">
                                    <select class="form-control" id="author_id" name="author_id" required>
                                        <option value="">ជ្រើសរើសអ្នកនិពន្ធ</option>
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" id="btn-search-authors" data-bs-toggle="modal" data-bs-target="#addAuthorModal">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="isbn">លេខកូដ</label>
                                <input type="text" name="isbn" id="isbn" class="form-control" value="{{ old('isbn') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="publication_date">បោះពុម្ពផ្សាយ</label>
                                <input type="date" name="publication_date" id="publication_date" class="form-control" value="{{ old('publication_date') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">ព័ត៌មានបន្ថែប</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="cover_image">រូបភាពក្រប</label>
                        <input type="file" name="cover_image" id="cover_image" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success">រក្សាទុក</button>
                </form>
            </div>
        </div>

        <!-- Modal for Adding Authors -->
        <div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAuthorModalLabel">បន្ថែមអ្នកនិពន្ធថ្មី។</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addAuthorForm">
                            <div class="mb-3">
                                <label for="authorName" class="form-label">ឈ្មោះអ្នកនិពន្ធ</label>
                                <input type="text" class="form-control" id="authorName" name="name" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">រក្សាទុក</button>
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
