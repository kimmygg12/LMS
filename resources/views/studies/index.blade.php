@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-4">{{ __('members.year') }}</h1>

        <!-- Add New Study Button -->
        <a href="{{ route('studies.create') }}" class="btn btn-success mb-3">{{ __('members.Create_list') }}</a>
        <!-- Success Message -->
        {{-- @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif --}}

        <!-- Table Container -->
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studies as $study)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $study->name }}</td>
                            <td>
                                <!-- Action Buttons -->
                                {{-- <a href="{{ route('studies.show', $study->id) }}" class="btn btn-info btn-sm">View</a> --}}
                                <a href="{{ route('studies.edit', $study->id) }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>

                                <!-- Delete Form -->
                                <form action="{{ route('studies.destroy', $study->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    background: '#d4edda',
                    iconColor: '#28a745'
                });
            });
        </script>
    @endif
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent the form from submitting immediately
                    const form = e.target;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        iconHtml: '<i class="fas fa-exclamation-triangle"></i>' // Custom icon
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        });
    </script>
@endpush
