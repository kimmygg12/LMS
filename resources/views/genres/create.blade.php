@extends('layouts.app')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h2>{{ __('messages.add_new_genre') }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('genres.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">{{ __('messages.genre_name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">{{ __('messages.save') }}</button>
                <a href="{{ route('genres.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            </form>
        </div>
    </div>
@endsection
