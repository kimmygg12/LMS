@extends('layouts.app')

@section('content')

    <div class="card mt-3">
        <div class="card-header">
            <h1>Edit Book</h1>
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
                        <div class="form-group mb-3"">
                            <label for="title" class="form-label">ចំណងជើង</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-book"></i></span>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $book->title ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3"">
                            <label for="author_id" class="form-label">អ្នកនិពន្ធ</label>
                            <div class="input-group">
                                <div class="input-group">
                                    <span class="input-group-text" style="width: 40px;"><i class="fa-solid fa-user-pen"></i></span>
                                <select class="form-control" id="author_id" name="author_id" required>
                                    <option value="">ជ្រើសរើសអ្នកនិពន្ធ</option>
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
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3"">
                            <label for="isbn">លេខកូដ</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-book-bookmark"></i></span>
                            <input type="text" class="form-control" name="isbn" id="isbn"
                                value="{{ old('isbn', $book->isbn) }}">
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3"">
                            
                            <label for="publication_date">បោះពុម្ពផ្សាយ</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-book-atlas"></i></span>
                            <input type="date" class="form-control" name="publication_date" id="publication_date"
                                value="{{ old('publication_date', $book->publication_date) }}">
                        </div>
                    </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description">ព័ត៌មានបន្ថែប</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-not-equal"></i></span>
                    <textarea class="form-control" name="description" id="description">{{ old('description', $book->description) }}</textarea>
                </div>
                </div>
                <div class="form-group mb-3">
                    <label for="status">ស្ថានភាព</label>
                    <div class="input-group">
                        <span class="input-group-text">  <i class="fa-solid fa-bars"></i></span>
                  
                    <select class="form-control" name="status" id="status">
                        <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>ទំនេ
                        </option>
                        <option value="borrowed" {{ old('status', $book->status) == 'borrowed' ? 'selected' : '' }}>
                            មិនទំនេរ</option>
                        <option value="reserved" {{ old('status', $book->status) == 'reserved' ? 'selected' : '' }}>ខូចខាត
                        </option>
                    </select>
                </div>
                </div>

                <div class="form-group mb-3">
                    <label for="cover_image">រូបភាពក្រប</label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control"
                        onchange="previewImage(event)">

                    {{-- @if ($book->cover_image)
                            <div class="card mt-3" style="max-width: 150px;">
                                <img src="{{ asset($book->cover_image) }}" alt="Cover Image" class="card-img-top">
                            </div>
                        @endif --}}

                    <div id="imagePreview" class="mt-3">
                        <img id="previewImage" src="#" alt="Image Preview"
                            style="display:none; max-width: 100%; height: auto;">
                    </div>
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
