@extends('layouts.app')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h2>Edit Subject</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="name">Subject Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $subject->name }}" required>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
