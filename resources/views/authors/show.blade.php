@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Author Details</h1>
    <p><strong>Name:</strong> {{ $author->name }}</p>
    <a href="{{ route('authors.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
