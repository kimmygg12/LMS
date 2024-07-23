@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Study</h1>
        <form action="{{ route('studies.update', $study->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="study">Study Year</label>
                <input type="number" name="study" id="study" class="form-control" value="{{ old('study', $study->study) }}" required>
                @error('study')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
