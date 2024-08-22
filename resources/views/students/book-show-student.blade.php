@extends('layouts.studentbook')

@section('title', __('books.book_details'))

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">{{ __('books.book_details') }}</h1>
        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        @if ($book->cover_image)
                            <img src="{{ asset($book->cover_image) }}" class="img-fluid rounded-start"
                                alt="{{ $book->title }} Cover">
                        @else
                            <img src="{{ asset('images/default-cover.jpg') }}" class="img-fluid rounded-start"
                                alt="Default Cover">
                        @endif
                    </div>
                    <div class="col-md-9">
                        <h5 class="card-title">{{ $book->title }}</h5>

                        <p class="card-text"><strong>{{ __('books.isbn') }}:</strong> {{ $book->isbn }}</p>

                        <p class="card-text">
                            <strong>{{ __('books.author') }}:</strong>
                            @if ($book->authors->isNotEmpty())
                                @foreach ($book->authors as $author)
                                    {{ $author->name }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @else
                                {{ __('books.no_author') }}
                            @endif
                        </p>


                        <p class="card-text">
                            <strong>{{ __('books.genre') }}:</strong>
                            {{ $book->genre ? $book->genre->name : __('books.no_genre') }}
                        </p>

                        <p class="card-text"><strong>{{ __('books.publication_date') }}:</strong>
                            {{ $book->publication_date }}</p>
                        <p class="card-text"><strong>{{ __('books.quantity') }}:</strong> {{ $book->quantity }}</p>
                        <p class="card-text"><strong>{{ __('books.description') }}:</strong> {{ $book->description }}</p>
                        <p class="card-text">
                            <strong>{{ __('books.status') }}:</strong>
                            @if ($book->status === 'available')
                                <span class="badge bg-success">{{ __('books.status_available') }}</span>
                            @elseif ($book->status === 'borrowed')
                                <span class="badge bg-warning text-dark">{{ __('books.status_borrowed') }}</span>
                            @elseif($book->status == 'unavailable')
                                <span class="badge bg-danger">{{ __('messages.Unavailable') }}</span>
                            @elseif ($book->status === 'reserved')
                                <span class="badge bg-info text-dark">{{ __('books.status_reserved') }}</span>
                            @elseif($book->status === 'rejected')
                                <span class="badge bg-danger">{{ __('books.status_rejected') }}</span>
                            @endif
                        </p>

                        <!-- Reservation Form -->
                        <form id="reservation-form" action="{{ route('reservations.reserve') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            {{-- <input type="hidden" name="member_id" value="{{ Auth::guard('member')->user()->id }}"> --}}
                            <input type="hidden" name="member_id" value="{{ Auth::guard('member')->user()->id }}">
                            <button type="submit" class="btn btn-success mt-3" id="reserve-button">
                                <i class="fa-solid fa-cart-shopping"></i> {{ __('books.reserve') }}
                            </button>
                        </form>

                        <a href="{{ route('students.dashboard') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-arrow-left-circle"></i> {{ __('books.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('reservation-form');
                const reserveButton = document.getElementById('reserve-button');
                const bookStatus = "{{ $book->status }}"; // Get book status from Blade template

                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    if (bookStatus === 'unavailable') {
                        Swal.fire({
                            title: '{{ __('books.book_unavailable_title') }}',
                            text: '{{ __('books.book_unavailable_text') }}',
                            icon: 'info',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '{{ __('books.confirmation_ok') }}'
                        });
                    } else {
                        Swal.fire({
                            title: '{{ __('books.confirmation_title') }}',
                            text: "{{ __('books.confirmation_text') }}",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '{{ __('books.confirmation_yes') }}',
                            cancelButtonText: '{{ __('books.confirmation_cancel') }}',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire(
                                    '{{ __('books.confirmation_reserved') }}',
                                    '{{ __('books.confirmation_success') }}',
                                    'success'
                                ).then(() => {
                                    form.submit(); // Proceed with form submission
                                });
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    title: '{{ __('books.confirmation_cancelled_title') }}',
                                    text: '{{ __('books.confirmation_cancelled_text') }}',
                                    icon: 'info',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: '{{ __('books.confirmation_ok') }}'
                                });
                            }
                        });
                    }
                });
            });
        </script>

    @endsection
