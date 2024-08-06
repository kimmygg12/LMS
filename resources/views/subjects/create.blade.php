@extends('layouts.app')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h2>Add New Subject</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Subject Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
