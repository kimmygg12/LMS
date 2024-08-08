@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-4">{{ __('messages.create_study') }}</h1>
        <form action="{{ route('studies.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('messages.name') }}</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
        </form>
    </div>
@endsection
