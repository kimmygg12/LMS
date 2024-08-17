@extends('layouts.studentbook')
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
                                <img src="{{ asset($member->image) }}" alt="Student Image" class="img-fluid rounded"
                                    style="max-width: 100%; height: auto;">
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <!-- Student Details -->
                        <p class="card-title">{{ $member->memberId }}</p>
                        <p><strong>Name:</strong> {{ $member->name }}</p>
                        <p><strong>Name Latin:</strong> {{ $member->name_latin }}</p>
                        <p><strong>Gender:</strong> {{ $member->gender }}</p>
                        <p><strong>Phone:</strong> {{ $member->phone }}</p>
                        <p><strong>Year:</strong> {{ $member->study->name }}</p>
                        <p><strong>Skills:</strong> {{ $member->category->name }}</p>
                    </div>
                </div>
                <a href="{{ route('students.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
            </div>
        </div>
    </div>
@endsection
