@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create a New Book</h1>
    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <form id="bookForm">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author_id">Author</label>
                <select class="form-control select2" id="author_id" name="author_id" required></select>
            </div>
            <div class="form-group">
                <label for="other_authors">Other Authors</label>
                <select class="form-control select2" id="other_authors" name="other_authors[]" multiple="multiple"></select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="authorModal" tabindex="-1" aria-labelledby="authorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="authorModalLabel">Add New Author</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="authorForm">
                            <div class="form-group">
                                <label for="author_name">Author Name</label>
                                <input type="text" class="form-control" id="author_name" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                ajax: {
                    url: '/authors',
                    processResults: function (data) {
                        return {
                            results: data.map(function(author) {
                                return { id: author.id, text: author.name };
                            })
                        };
                    }
                }
            });

            $('#bookForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/books',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Book saved successfully!');
                        $('#bookForm')[0].reset();
                        $('.select2').val(null).trigger('change');
                    },
                    error: function(error) {
                        alert('Error saving book.');
                    }
                });
            });

            $('#authorForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/authors',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Author saved successfully!');
                        $('#authorModal').modal('hide');
                        $('#authorForm')[0].reset();
                    },
                    error: function(error) {
                        alert('Error saving author.');
                    }
                });
            });
        });
    </script>

@endsection
