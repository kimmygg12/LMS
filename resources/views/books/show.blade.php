@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <div class="row mt-4">
                    <div class="col">
                        <h2>ព័ត៌មានសៀវភៅ</h2>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('books.index') }}" class="btn btn btn-outline-success"><i
                                class="fa-solid fa-arrow-left"></i> ត្រឡប់ក្រោយ</a>
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
                            <p class="card-text"><strong>ចំណងជើង:</strong> {{ $book->title }}</p>
                            <p class="card-text"><strong>អ្នកនិពន្ធ:</strong> {{ $book->author->name }}</p>
                            <p class="card-text"><strong>លេខកូដ:</strong> {{ $book->isbn }}</p>
                            <p class="card-text"><strong>បោះពុម្ពផ្សាយ:</strong> {{ $book->publication_date }}</p>
                            <p class="card-text"><strong>ស្ថានភាព:</strong>
                                @if ($book->status === 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif ($book->status === 'borrowed')
                                    <span class="badge bg-warning text-dark">មិនទំនេ</span>
                                @elseif ($book->status === 'reserved')
                                    <span class="badge bg-info text-dark">Reserved</span>
                                @endif
                            </p>
                            <p class="card-text"><strong>ព័ត៌មានបន្ថែប:</strong> {{ $book->description}}</p>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-success"><i
                                    class="fa-solid fa-edit"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
