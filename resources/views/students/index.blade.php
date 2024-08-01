@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Students</h1>
        <form method="GET" action="{{ route('students.index') }}">
            <input type="text" name="search" placeholder="Search..." value="{{ request()->input('search') }}">
            <button type="submit">Search</button>
        </form>
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Student ID</th>
                    <th>Gender</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->studentId }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $students->links() }}
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this student!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Display success message before form submission
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The student has been deleted.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                form.submit(); // Submit the form after showing the success message
                            });
                        }
                    });
                });
            });
        </script>
    @endsection
@endsection
