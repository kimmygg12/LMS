@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-4">{{ __('messages.edit_study') }}</h1>
        <form action="{{ route('studies.update', $study->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">{{ __('messages.yearname') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $study->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
        </form>
    </div>
@endsection
