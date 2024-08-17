@extends('layouts.studentbook')

@section('content')
    <div class="card text-center mb-4">
        <div class="card-body">
            <h4 class="card-title">{{ __('messages.library_title') }}</h4>
        </div>
    </div>

    <form action="{{ route('students.dashboard') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control"
                placeholder="{{ __('messages.search_books') }}" value="{{ request()->input('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
    </form>

    <div class="card-container mt-4 mb-4 d-flex flex-wrap gap-3">
        @forelse($books as $book)
            <div class="card" style="width: 180px; margin-bottom: 15px;">
                <img src="{{ asset($book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $book->author->name }}</h6>
                </div>
                <div class="card-footer text-muted">
                    <a href="{{ route('students.book-student', $book->id) }}"
                        class="btn btn-primary">{{ __('messages.view_details') }}</a>
                </div>
            </div>
        @empty
            <div class="alert alert-info" role="alert">
                {{ __('messages.no_books_found') }}
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-end mt-4">
        {{ $books->links('pagination::bootstrap-5') }}
    </div>
@endsection
