@extends('layouts.app')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h2>{{ __('messages.edit_genre') }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('genres.update', $genre->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="name">{{ __('messages.genre_name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $genre->name }}" required>
                </div>

                <button type="submit" class="btn btn-success">{{ __('messages.update') }}</button>
                <a href="{{ route('genres.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            </form>
        </div>
    </div>
@endsection
