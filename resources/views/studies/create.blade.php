@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Study</h1>
        <form action="{{ route('studies.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="study">Study Year</label>
                <input type="number" name="study" id="study" class="form-control" value="{{ old('study') }}" required>
                @error('study')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
