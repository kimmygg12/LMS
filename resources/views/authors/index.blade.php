@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Authors</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAuthorModal">Add New Author</button>

        <table class="table mt-3" id="authorsTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($authors as $author)
                    <tr data-id="{{ $author->id }}">
                        <td class="author-name">{{ $author->name }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal"
                                data-bs-target="#editAuthorModal">Edit</button>
                            <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Author Modal -->
    <div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAuthorModalLabel">Add New Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAuthorForm" method="POST" action="{{ route('authors.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="authorName" class="form-label">Author Name</label>
                            <input type="text" class="form-control" id="authorName" name="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Author Modal -->
    <div class="modal fade" id="editAuthorModal" tabindex="-1" aria-labelledby="editAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAuthorModalLabel">Edit Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAuthorForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit-authorName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-authorName" name="name" required>
                        </div>
                        <input type="hidden" id="edit-author-id" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add Author
            document.getElementById('addAuthorForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                const name = document.getElementById('authorName').value;

                fetch('{{ route('authors.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.id) {
                        const tableBody = document.querySelector('#authorsTable tbody');
                        const newRow = document.createElement('tr');
                        newRow.dataset.id = data.id;
                        newRow.innerHTML = `
                            <td class="author-name">${data.name}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editAuthorModal">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                            </td>
                        `;
                        tableBody.appendChild(newRow);

                        form.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addAuthorModal'));
                        modal.hide();
                        document.querySelector('.modal-backdrop').remove(); // Properly removes the backdrop
                    } else {
                        alert('Error: ' + (data.errors ? data.errors.name[0] : 'Unknown error'));
                    }
                })
                .catch(error => console.error('Error:', error));
            });

            // Edit Author
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('edit-btn')) {
                    const row = e.target.closest('tr');
                    const id = row.dataset.id;

                    fetch(`{{ url('authors') }}/${id}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit-authorName').value = data.name;
                        document.getElementById('edit-author-id').value = data.id;
                        document.getElementById('editAuthorForm').action = `{{ url('authors') }}/${data.id}`;
                    })
                    .catch(error => console.error('Error:', error));
                }

                // Delete Author
                if (e.target.classList.contains('delete-btn')) {
                    const row = e.target.closest('tr');
                    const id = row.dataset.id;

                    if(confirm("Are you sure you want to delete this author?")) {
                        fetch(`{{ url('authors') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                row.remove();
                            } else {
                                alert('Error deleting author');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                }
            });

            // Update Author
            document.getElementById('editAuthorForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.id) {
                        const row = document.querySelector(`tr[data-id="${data.id}"]`);
                        row.querySelector('.author-name').textContent = data.name;

                        form.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editAuthorModal'));
                        modal.hide();
                        document.querySelector('.modal-backdrop').remove(); // Properly removes the backdrop
                    } else {
                        alert('Error: ' + (data.errors ? data.errors.name[0] : 'Unknown error'));
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
