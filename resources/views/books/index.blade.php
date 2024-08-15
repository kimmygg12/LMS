@extends('layouts.app')

@section('content')
<div class="row mt-4 mb-4">
    <div class="col">
        <h2>{{ __('messages.manage_books') }}</h2>
    </div>
    <div class="col text-end">
        <a href="{{ route('books.create') }}" class="btn btn-success">
            <i class="fa-solid fa-plus"></i> {{ __('messages.add') }}
        </a>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success mt-2">
        {{ $message }}
    </div>
@endif

<div class="card mb-4">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="col-md-7">
            <h5 class="card-title mb-2 mb-md-0">{{ __('messages.book_list') }}</h5>
        </div>
        <div class="col-md-5 text-end">
            <form method="GET" action="{{ route('books.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="{{ __('messages.search') }}"
                    value="{{ request()->get('search') }}">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('messages.cover') }}</th>
                        <th class="text-center">{{ __('messages.title') }}</th>
                        <th class="text-center">{{ __('messages.author') }}</th>
                        <th class="text-center">{{ __('messages.isbn') }}</th>
                        <th class="text-center">{{ __('messages.genre') }}</th>
                        <th class="text-center">{{ __('messages.publication_date') }}</th>
                        <th class="text-center">{{ __('messages.quantity') }}</th>
                        <th class="text-center">{{ __('messages.status') }}</th>
                        <th class="text-center">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr class="{{ $book->id == $newBooks->first()->id ? 'table-success-hidden' : '' }}">

                        <td class="text-center tdsearch">
                            @if ($book->cover_image)
                                <img src="{{ asset($book->cover_image) }}" alt="{{ __('messages.no_image') }}"
                                    style="max-width: 50px;">
                            @else
                                <span>{{ __('messages.no_image') }}</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $book->title }}</td>
                        <td class="text-center">{{ $book->author->name }}</td>
                        <td class="text-center">{{ $book->isbn }}</td>
                        <td class="text-center">{{ $book->subject->name ?? __('messages.no_subject') }}</td>
                        <td class="text-center">{{ $book->publication_date }}</td>
                        <td class="text-center">{{ $book->quantity }} {{ __('messages.Total') }}</td>
                        <td class="text-center">
                            @if ($book->status === 'available')
                                <span class="badge bg-success">{{ __('messages.status_available') }}</span>
                            @elseif ($book->status === 'borrowed')
                                <span class="badge bg-warning text-dark">{{ __('messages.status_borrowed') }}</span>
                            @elseif ($book->status === 'reserved')
                                <span class="badge bg-secondary">{{ __('messages.status_reserved') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            {{-- <form id="delete-form-{{ $book->id }}"
                                action="{{ route('books.destroy', $book->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="confirmDelete({{ $book->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form> --}}
                            @if (Auth::check() && Auth::user()->usertype === 'admin')
                            <!-- Admin-specific delete button -->
                            <form id="delete-form-{{ $book->id }}"
                                action="{{ route('books.destroy', $book->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="confirmDelete({{ $book->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">{{ __('messages.no_books_found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
                
            </table>
            <div class="pagination-wrapper">
                {{ $books->appends(['search' => request()->input('search')])->links() }}
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(bookId) {
            Swal.fire({
                title: '{{ __('messages.confirm_delete') }}',
                text: '{{ __('messages.confirm_delete_text') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('messages.confirm_delete_button') }}',
                cancelButtonText: '{{ __('messages.cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show success alert and then submit the form after 1 second
                    Swal.fire({
                        title: '{{ __('messages.deleted') }}',
                        text: '{{ __('messages.delete_success_text') }}',
                        icon: 'success',
                        timer: 1000, // Show alert for 1 second
                        showConfirmButton: false
                    }).then(() => {
                        document.getElementById(`delete-form-${bookId}`).submit();
                    });
                }
            });
        }
    </script>
@endsection
@endsection
