{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Member</h1>
    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('members.form')
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

@endsection --}}
<!-- resources/views/members/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Member</h1>

        <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="name_latin">Name Latin</label>
                <input type="text" class="form-control" id="name_latin" name="name_latin">
            </div>

            <div class="form-group">
                <label for="gender">ភេទ</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="male">ប្រុស</option>
                    <option value="female">ស្រី</option>
                </select>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob">
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <!-- SweetAlert Scripts -->
    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
