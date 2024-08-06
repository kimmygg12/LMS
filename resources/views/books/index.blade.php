@extends('layouts.app')

@section('content')
<div class="row mt-4 mb-4">
    <div class="col">
            <h2>គ្រប់គ្រងសៀវភៅ</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('books.create') }}" class="btn btn-success">
                <i class="fa-solid fa-plus"></i> បន្ថែម
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
                <h5 class="card-title mb-2 mb-md-0">បញ្ជីសៀវភៅ</h5>
            </div>
            <div class="col-md-5 text-end">
                <form method="GET" action="{{ route('books.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="ស្វែងរក..."
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
                            <th class="text-center">ក្រប</th>
                            <th class="text-center">ចំណងជើង</th>
                            <th class="text-center">អ្នកនិពន្ធ</th>
                            <th class="text-center">លេខកូដ</th>
                            <th class="text-center">ប្រភេទ</th>
                            <th class="text-center">បោះពុម្ពផ្សាយ</th>
                            <th class="text-center">ចំនួន</th>
                            <th class="text-center">ស្ថានភាព</th>
                            <th class="text-center">ប៊ូតុង</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <td class="text-center tdsearch">
                                    @if ($book->cover_image)
                                        <img src="{{ asset($book->cover_image) }}" alt="Cover Image"
                                            style="max-width: 50px;">
                                    @else
                                        <span>គ្មានរូបភាព</span>
                                    @endif
                                </td>
                                 <td class="text-center">{{ $book->title }}</td>
                                 <td class="text-center">{{ $book->author->name }}</td>
                                 <td class="text-center">{{ $book->isbn }}</td>
                                 <td class="text-center">{{ $book->subject->name ?? 'No Subject' }}</td>
                                 <td class="text-center">{{ $book->publication_date }}</td>
                                 <td class="text-center">{{ $book->quantity }}</td>
                                 <td class="text-center">
                                    @if ($book->status === 'available')
                                        <span class="badge bg-success">ទំនេរ</span>
                                    @elseif ($book->status === 'borrowed')
                                        <span class="badge bg-warning text-dark">មិនទំនេរ</span>
                                    @elseif ($book->status === 'reserved')
                                        <span class="badge bg-secondary">ខូចខាត</span>
                                    @endif
                                </td>
                                 <td class="text-center">
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No books found.</td>
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
                    title: 'តើ​អ្នក​ប្រាកដ​ឬ​អត់?',
                    text: 'អ្នកនឹងលុបវា?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'លុបចេញ',
                    cancelButtonText: 'បោះបង់'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show success alert and then submit the form after 1 second
                        Swal.fire({
                            title: 'បានលុប!',
                            text: 'សៀវភៅត្រូវបានលុប។',
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
