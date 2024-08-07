@extends('layouts.app')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h2>{{ __('books.book_list') }}</h2>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="title">{{ __('books.title') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-book"></i></span>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ old('title') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="author_id" class="form-label">{{ __('books.author') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" style="width: 40px;"><i
                                        class="fa-solid fa-user-pen"></i></span>
                                <select class="form-control select2" id="author_id" name="author_id" required>
                                    <option value="">{{ __('books.select_author') }}</option>
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="isbn">{{ __('books.isbn') }}</label>
                            <div class="input-group">
                                <span class="input-group-text d-flex align-items-center justify-content-center"
                                    style="width: 40px;"><i class="fa-solid fa-code"></i></span>
                                <input type="text" name="isbn" id="isbn" class="form-control"
                                    value="{{ old('isbn') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="publication_date">{{ __('books.publication_date') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-book-atlas"></i></span>
                                <input type="date" name="publication_date" id="publication_date" class="form-control"
                                    value="{{ old('publication_date') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="quantity">{{ __('books.quantity') }}</label>
                            <div class="input-group">
                                <span class="input-group-text d-flex align-items-center justify-content-center"
                                    style="width: 40px;"><i class="fa-solid fa-cubes"></i></span>
                                <input type="number" name="quantity" id="quantity" class="form-control"
                                    value="{{ old('quantity') }}" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="subject_id">{{ __('books.subject') }}</label>
                            <div class="input-group">
                                <span class="input-group-text d-flex align-items-center justify-content-center"
                                    style="width: 40px;"><i class="fa-sharp fa-light fa-layer-group"></i></span>
                                <select class="form-control" id="subject_id" name="subject_id">
                                    <option value="">{{ __('books.subject') }}</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="cover_image">{{ __('books.cover_image') }}</label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="description">{{ __('books.additional_info') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-not-equal"></i></span>
                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">{{ __('books.save') }}</button>
            </form>
        </div>
    </div>

    <!-- Modal for Adding Authors -->
    <div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAuthorModalLabel">{{ __('books.add_author') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAuthorForm">
                        <div class="mb-3">
                            <label for="authorName" class="form-label">{{ __('books.author') }}</label>
                            <input type="text" class="form-control" id="authorName" name="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">{{ __('books.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function() {
                $('#author_id').select2({
                    theme: 'bootstrap-5'
                });
            });
            $(document).ready(function() {
                $('#subject_id').select2({
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
