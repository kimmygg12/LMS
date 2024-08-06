@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Authors</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAuthorModal">Add New Author</button>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
            </tr>
        </thead>
        <tbody id="authorTableBody">
            @foreach($authors as $author)
            <tr>
                <td>{{ $author->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="createAuthorModal" tabindex="-1" aria-labelledby="createAuthorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createAuthorModalLabel">Add New Author</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="createAuthorForm">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <!-- Add other fields here if needed -->
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('createAuthorForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var form = e.target;
        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var authorTableBody = document.getElementById('authorTableBody');
                var newRow = document.createElement('tr');
                var newCell = document.createElement('td');
                newCell.textContent = data.author.name;
                newRow.appendChild(newCell);
                authorTableBody.appendChild(newRow);

                var modal = new bootstrap.Modal(document.getElementById('createAuthorModal'));
                modal.hide();
                form.reset();
            } else {
                // Handle validation errors
                console.log('Error:', data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>
@endsection
@endsection
