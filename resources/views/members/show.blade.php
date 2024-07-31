@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Student Details</h1>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <!-- Image Box -->
                    @if ($member->image)
                        <div class="text-center mb-3">
                            <img src="{{ asset($member->image) }}" alt="Student Image" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <!-- Student Details -->
                    <h5 class="card-title">{{ $member->name }}</h5>
                    <p><strong>Name Latin:</strong> {{ $member->name_latin }}</p>
                    <p><strong>Gender:</strong> {{ $member->gender }}</p>
                    <p><strong>Phone:</strong> {{ $member->phone }}</p>
                    <p><strong>Study:</strong> {{ $member->study->name }}</p>
                    <p><strong>Category:</strong> {{ $member->category->name }}</p>
                </div>
            </div>
            <a href="{{ route('members.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
@endsection
