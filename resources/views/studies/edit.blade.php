@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Study</h1>
        <form action="{{ route('studies.update', $study->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $study->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
