@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2>បង្កើតព័ត៌អ្នកខ្ចីសៀវភៅ</h2>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">

                    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">ឈ្មោះ</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user-graduate"></i></span>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name_latin">ឈ្មោះជាឡាតាំង</label>
                                <input type="text" id="name_latin" name="name_latin" class="form-control"
                                    value="{{ old('name_latin') }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="gender">ភេទ</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-mars-and-venus"></i></span>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ប្រុស
                                        </option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>ស្រី
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="phone">លេខទូរស័ព្ទ </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" id="phone" name="phone" class="form-control"
                                        value="{{ old('phone') }}">
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="study_id">ឆ្នាំសិក្សា</label>
                                <select id="study_id" name="study_id" class="form-control" required>
                                    <option value="">ជ្រើសរើស</option>
                                    @foreach ($studies as $study)
                                        <option value="{{ $study->id }}">{{ $study->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="category_id">ជំនាញ</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <option value="">ជ្រើសរើស</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">រក្សាទុក</button>
                        <a href="{{ route('members.index') }}" class="btn btn-outline-success">បោះបង់</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
