@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Student</h1>
        <form method="POST" action="{{ route('students.update', $student->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $student->name }}" required>
            </div>
            <div class="form-group">
                <label for="name_latin">Name (Latin)</label>
                <input type="text" name="name_latin" class="form-control" id="name_latin" value="{{ $student->name_latin }}">
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" class="form-control" id="gender" required>
                    <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" id="phone" value="{{ $student->phone }}">
            </div>
            <div class="form-group">
                <label for="study_id">Study</label>
                <select name="study_id" class="form-control" id="study_id" required>
                    @foreach ($studies as $study)
                        <option value="{{ $study->id }}" {{ $student->study_id == $study->id ? 'selected' : '' }}>
                            {{ $study->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control" id="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $student->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                @if ($student->image)
                    <div>
                        <img src="{{ asset($student->image) }}" width="100">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" id="image">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
