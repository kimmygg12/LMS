@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Category Details</h1>

    <div class="card">
        <div class="card-header">
            {{ $category->name }}
        </div>
    </div>

    <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Back to Categories</a>
</div>
@endsection
