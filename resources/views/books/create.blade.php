@extends('layouts.app')

@section('content')
    <style>
        .select2-container {
            width: calc(100% - 40px);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            white-space: normal;
            text-align: center;
        }
        .select2-container--default .select2-selection--multiple {
            width: 100% !important;
            min-height: 38px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice .select2-selection__choice__remove {
            position: relative;
            margin-left: 5px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            white-space: normal;
            text-align: left;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__placeholder {
            text-align: center;
        }
        @media (max-width: 768px) {
            .custom-select2-width {
                width: 100%;
            }
        }
    </style>
    <div class="card mt-3">
        <div class="card-header">
            <h2>{{ __('books.add_book') }}</h2>
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
                    <!-- Title Input -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="title">{{ __('books.title') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-book"></i></span>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="author_id" class="form-label">{{ __('books.authors') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"
                                    style="width: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-user-pen" id="btn-search-authors" data-bs-toggle="modal"
                                        data-bs-target="#addAuthorModal"></i>
                                </span>
                                <select name="author_id[]" id="author_id" multiple
                                    class="form-select select2 custom-select2-width">
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}"
                                            {{ in_array($author->id, old('author_id', [])) ? 'selected' : '' }}>
                                            {{ $author->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('author_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                @error('isbn')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
                                @error('publication_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
                                    value="{{ old('quantity') }}" min="0" required>
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="genre_id">{{ __('books.genre') }}</label>
                            <div class="input-group">
                                <span class="input-group-text d-flex align-items-center justify-content-center"
                                    style="width: 40px;"><i class="fa-sharp fa-light fa-layer-group"></i></span>
                                <select class="form-control" id="genre_id" name="genre_id">
                                    <option value="">{{ __('books.genre') }}</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre->id }}"
                                            {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                            {{ $genre->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('genre_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="cover_image">{{ __('books.cover_image') }}</label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control">
                    @error('cover_image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description">{{ __('books.additional_info') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-not-equal"></i></span>
                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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
    </div>

    <script>
        
        $(document).ready(function() {
            $('#author_id').select2({
                placeholder: "Select authors",
                width: 'resolve'
            });

            // Ensure Select2 adjusts on window resize
            $(window).resize(function() {
                $('#author_id').select2('destroy').select2({
                    placeholder: "Select authors",
                    width: 'resolve'
                });
            });
            $('#genre_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select genre',
                allowClear: true
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
                        $('#author_id').append(newOption).trigger('change');
                        document.querySelector('.btn-close').click();
                    });
            });
        });
    </script>
@endsection
