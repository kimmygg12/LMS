@extends('layouts.app')

@section('content')

    <div class="card mt-3">
        <div class="card-header">
            <h1>{{ __('books.edit_book') }}</h1>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">{{ __('books.title') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-book"></i></span>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $book->title ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="author_id" class="form-label">{{ __('books.author') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" style="width: 40px;"><i
                                        class="fa-solid fa-user-pen"></i></span>
                                <select class="form-control" id="author_id" name="author_id" required>
                                    <option value="">{{ __('books.select_author') }}</option>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}"
                                            {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="isbn">{{ __('books.isbn') }}</label>
                            <div class="input-group">
                                <span class="input-group-text d-flex align-items-center justify-content-center" style="width: 40px;"><i class="fa-solid fa-code"></i></span>
                                <input type="text" class="form-control" name="isbn" id="isbn"
                                    value="{{ old('isbn', $book->isbn) }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="publication_date">{{ __('books.publication_date') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-book-atlas"></i></span>
                                <input type="date" class="form-control" name="publication_date" id="publication_date"
                                    value="{{ old('publication_date', $book->publication_date) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="quantity">{{ __('books.quantity') }}</label>
                            <input type="number" id="quantity" name="quantity" class="form-control"
                                value="{{ old('quantity', $book->quantity) }}" required min="1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status">{{ __('books.status') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa-solid fa-bars"></i></span>

                                <select class="form-control" name="status" id="status">
                                    <option value="available"
                                        {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>
                                        {{ __('books.available') }}
                                    </option>
                                    <option value="borrowed"
                                        {{ old('status', $book->status) == 'borrowed' ? 'selected' : '' }}>
                                        {{ __('books.borrowed') }}</option>
                                    {{-- <option value="reserved"
                                        {{ old('status', $book->status) == 'reserved' ? 'selected' : '' }}>
                                        {{ __('books.reserved') }}
                                    </option> --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="cover_image">{{ __('books.cover_image') }}</label>
                            <input type="file" name="cover_image" id="cover_image" class="form-control"
                                onchange="previewImage(event)">

                            <div id="imagePreview" class="mt-3">
                                <img id="previewImage" src="#" alt="{{ __('books.image_preview') }}"
                                    style="display:none; max-width: 100%; height: auto;">
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
                                    <option value="">{{ __('books.select_subject') }}</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ $subject->id == $book->subject_id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="description">{{ __('books.additional_info') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-not-equal"></i></span>
                        <textarea class="form-control" name="description" id="description">{{ old('description', $book->description) }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('books.save') }}</button>
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
                            <label for="authorName" class="form-label">ឈ្មោះអ្នកនិពន្ធ</label>
                            <input type="text" class="form-control" id="authorName" name="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="saveAuthorBtn">{{ __('books.save') }}</button>
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

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('previewImage');
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('previewImage').style.display = 'none';
            }
        }
    </script>
@endsection
