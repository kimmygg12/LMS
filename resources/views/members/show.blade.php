@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Member Details</h1>
    <div class="card">
        <div class="card-body">
            {{-- <h5 class="card-title">{{ $member->name }}</h5> --}}
            <p class="card-text"><strong>លេខសម្គាល់:</strong> {{ $member->memberId }}</p>
            <p class="card-text"><strong>Name:</strong> {{ $member->name }}</p>
            <p class="card-text"><strong>Name Latin:</strong> {{ $member->name_latin }}</p>
            <p class="card-text"><strong>Gender:</strong> {{ $member->gender }}</p>
            <p class="card-text"><strong>Phone:</strong> {{ $member->phone }}</p>
            <p class="card-text"><strong>Address:</strong> {{ $member->address }}</p>
            <p class="card-text"><strong>Date of Birth:</strong> {{ $member->dob }}</p>
            @if ($member->image)
                <img src="{{ asset( $member->image) }}" alt="Member Image" width="150">
                {{-- <img src="{{ asset('storage/' . $member->image) }}" alt="Member Image" width="150"> --}}
            @endif
            <a href="{{ route('members.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
@endsection