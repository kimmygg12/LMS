@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-4">{{ __('messages.create_category') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">{{ __('messages.nameskills') }}</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('messages.create_category_button') }}</button>
    </form>
</div>
@endsection
