@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Edit Member</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $member->name) }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="name_latin">Name Latin</label>
                        <input type="text" id="name_latin" name="name_latin" class="form-control" value="{{ old('name_latin', $member->name_latin) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control" required>
                            <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>ប្រុស</option>
                            <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>ស្រី</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $member->phone) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="study_id">Study</label>
                        <select id="study_id" name="study_id" class="form-control" required>
                            @foreach ($studies as $study)
                            <option value="{{ $study->id }}" {{ $study->id == old('study_id', $member->study_id) ? 'selected' : '' }}>{{ $study->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="category_id">Category</label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == old('category_id', $member->category_id) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image" class="form-control">
                    {{-- @if($member->image)
                        <img src="{{ asset($member->image) }}" alt="Member Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                    @endif --}}
                </div>

                <button type="submit" class="btn btn-primary">Update Member</button>
            </form>
        </div>
    </div>
</div>
@endsection
