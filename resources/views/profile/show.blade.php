@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $profile->first_name }} {{ $profile->last_name }}</h1>
    <p>{{ $profile->bio }}</p>
    @if ($profile->profile_picture)
        <img src="{{ asset('storage/' . $profile->profile_picture) }}" alt="Profile Picture" class="img-fluid">
    @endif
    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
</div>
@endsection
