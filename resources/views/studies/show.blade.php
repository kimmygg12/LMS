@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Study Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $study->name }}</h5>
                <a href="{{ route('studies.index') }}" class="btn btn-secondary mt-3">Back to List</a>
            </div>
        </div>
    </div>
@endsection
