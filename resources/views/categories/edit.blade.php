@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-4">{{ __('messages.edit_category') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">{{ __('messages.nameskills') }}</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>

        <button type="submit" class="btn btn-success">{{ __('messages.update_category') }}</button>
    </form>
</div>
@endsection
