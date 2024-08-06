@extends('layouts.app')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h3>ព័ត៌មានសិស្ស</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">ឈ្មោះ</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-user-graduate"></i></span>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name', $member->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="name_latin">ឈ្មោះឡាតាំង</label>
                        <input type="text" id="name_latin" name="name_latin" class="form-control"
                            value="{{ old('name_latin', $member->name_latin) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="gender">ភេទ</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-mars-and-venus"></i></span>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>
                                    ប្រុស</option>
                                <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>
                                    ស្រី</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="phone">ទូរស័ព្ទ</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                            <input type="text" id="phone" name="phone" class="form-control"
                                value="{{ old('phone', $member->phone) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="study_id">ឆ្នាំ</label>
                        <select id="study_id" name="study_id" class="form-control" required>
                            @foreach ($studies as $study)
                                <option value="{{ $study->id }}"
                                    {{ $study->id == old('study_id', $member->study_id) ? 'selected' : '' }}>
                                    {{ $study->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="category_id">ជំនាញ</label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == old('category_id', $member->category_id) ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="image">រូបភាព</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                            <input type="file" id="image" name="image" class="form-control">
                            {{-- @if ($member->image)
                        <img src="{{ asset($member->image) }}" alt="Member Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                    @endif --}}
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">រក្សាទុក</button>
            </form>
        </div>
    </div>
@endsection
