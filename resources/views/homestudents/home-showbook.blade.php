@extends('layouts.homestudent')
@section('content')
    <div class="container">
        <div class="card mb-3 shadow-sm border-0">
            <div class="row g-0">
                <!-- Book Cover Image -->
                <div class="col-md-4">
                    <div class="p-3">
                        @if ($book->cover_image)
                            <img src="{{ asset($book->cover_image) }}" class="img-fluid rounded"
                                alt="{{ __('messages.cover_image_alt') }}">
                        @else
                            <img src="{{ asset('images/default-cover.jpg') }}" class="img-fluid rounded"
                                alt="{{ __('messages.default_cover_alt') }}">
                        @endif
                    </div>
                </div>
                <!-- Book Details -->
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('messages.book_title') }}: {{ $book->title }}</h5>
                        <p class="card-text">
                            <strong>{{ __('messages.author') }}:</strong>
                            @if ($book->authors->isNotEmpty())
                                @foreach ($book->authors as $author)
                                    {{ $author->name }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @else
                                {{ __('messages.n_a') }}
                            @endif
                        </p>

                        <p class="card-text"><strong>{{ __('messages.isbn') }}:</strong> {{ $book->isbn }}</p>
                        <p class="card-text">
                            <strong>{{ __('messages.genre') }}:</strong>
                            {{ $book->genre ? $book->genre->name : __('messages.no_genre') }}
                        </p>

                        <p class="card-text"><strong>{{ __('messages.publication_date') }}:</strong>
                            {{ $book->publication_date }}</p>
                        <p class="card-text"><strong>{{ __('messages.quantity') }}:</strong> {{ $book->quantity }}</p>
                        <p class="card-text"><strong>{{ __('messages.description') }}:</strong> {{ $book->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Back Button -->
        <a href="{{ route('student.home') }}" class="btn btn-primary">{{ __('messages.back_to_list') }}</a>
    </div>
@endsection
