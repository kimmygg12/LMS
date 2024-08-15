@extends('layouts.app')

@section('title', __('messages.new_books_report'))

@section('content')
    <h1 class="my-4">{{ __('messages.new_books_report') }}</h1>

    <form method="GET" action="{{ route('reports.new_books') }}" class="mb-4">
        <div class="form-row">
            <div class="col-md-4">
                <label for="start_date">{{ __('messages.start_date') }}</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">{{ __('messages.end_date') }}</label>
                <input type="date" name="end_date" id="end_date" class="form-control"
                    value="{{ $endDate ? $endDate->format('Y-m-d') : '' }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>{{ __('messages.isbn') }}</th>
                    <th>{{ __('messages.title') }}</th>
                    <th>{{ __('messages.genre') }}</th>
                    <th>{{ __('messages.author') }}</th>
                    <th>{{ __('messages.published_date') }}</th>
                    <th>{{ __('messages.quantity') }}</th>
                    <th>{{ __('messages.created_date') }}</th> <!-- New column for Created Date -->
                </tr>
            </thead>
            <tbody>
                @forelse($newBooks as $book)
                    <tr onclick="window.location.href='{{ route('books.show', $book->id) }}';" style="cursor: pointer;">
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->subject->name }}</td>
                        <td>{{ $book->author->name }}</td>
                        <td>{{ $book->publication_date }}</td>
                        <td>{{ $book->quantity }} {{ __('messages.Total') }}</td>
                        <td>{{ $book->created_at->format('Y-m-d H:i:s') }}</td> <!-- Display Created Date -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">{{ __('messages.no_books') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
