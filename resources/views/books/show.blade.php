@extends('layouts.app')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col">
                    <h2>{{ __('books.book_details') }}</h2>
                </div>
                <div class="col text-end">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-success">
                        <i class="fa-solid fa-arrow-left"></i> {{ __('books.back') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-0">
                <div class="col-md-3">
                    @if ($book->cover_image)
                        <img src="{{ asset($book->cover_image) }}" class="img-fluid rounded-start"
                            alt="{{ $book->title }} Cover">
                    @else
                        <img src="{{ asset('images/default-cover.jpg') }}" class="img-fluid rounded-start"
                            alt="Default Cover">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <p class="card-text"><strong>{{ __('books.title') }}:</strong> {{ $book->title }}</p>
                        <p class="card-text">
                            <strong>{{ __('books.author') }}:</strong> 
                            @if ($book->authors->isNotEmpty())
                                @foreach ($book->authors as $author)
                                    {{ $author->name }}@if (!$loop->last), @endif
                                @endforeach
                            @else
                                {{ __('books.no_authors') }}
                            @endif
                        </p>
                        
                        <p class="card-text"><strong>{{ __('books.isbn') }}:</strong> {{ $book->isbn }}</p>
                        <p class="card-text"><strong>{{ __('books.publication_date') }}:</strong> {{ $book->publication_date }}</p>
                        <p class="card-text"><strong>{{ __('books.quantity') }}:</strong> {{ $book->quantity }}</p>
                        <p class="card-text"><strong>{{ __('books.genre') }}:</strong> {{ $book->genre ? $book->genre->name : __('messages.not_available') }}</p>
                        <p class="card-text"><strong>{{ __('books.status') }}:</strong>
                            @if ($book->status === 'available')
                                <span class="badge bg-success">{{ __('books.available') }}</span>
                            @elseif ($book->status === 'borrowed')
                                <span class="badge bg-warning text-dark">{{ __('books.borrowed') }}</span>
                            @elseif ($book->status === 'reserved')
                                <span class="badge bg-info text-dark">{{ __('books.reserved') }}</span>
                            @endif
                        </p>
                        <p class="card-text"><strong>{{ __('books.additional_info') }}:</strong> {{ $book->description}}</p>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-success">
                            <i class="fa-solid fa-edit"></i> {{ __('books.edit') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
