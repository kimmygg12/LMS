@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Book</h1>
    <form method="POST" action="{{ route('books.store') }}">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <select class="form-control" id="author" name="author_id" required>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#authorModal">Add New Author</button>
        </div>
        <!-- Other book fields here -->
        <button type="submit" class="btn btn-success">Save Book</button>
    </form>
</div>

<!-- Author Modal -->
<div class="modal fade" id="authorModal" tabindex="-1" role="dialog" aria-labelledby="authorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="authorModalLabel">Add New Author</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('authors.form')
            </div>
        </div>
    </div>
</div>
@endsection
