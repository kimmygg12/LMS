@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2>{{ __('members.create_member') }}</h2>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">

                    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">{{ __('members.name') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user-graduate"></i></span>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name_latin">{{ __('members.name_latin') }}</label>
                                <input type="text" id="name_latin" name="name_latin" class="form-control"
                                    value="{{ old('name_latin') }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="gender">{{ __('members.gender') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-mars-and-venus"></i></span>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                            {{ __('members.male') }}</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                            {{ __('members.female') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">{{ __('members.phone') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" id="phone" name="phone" class="form-control"
                                        value="{{ old('phone') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="study_id">{{ __('members.study') }}</label>
                                <select id="study_id" name="study_id" class="form-control" required>
                                    <option value="">{{ __('members.select') }}</option>
                                    @foreach ($studies as $study)
                                        <option value="{{ $study->id }}">{{ $study->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="category_id">{{ __('members.category') }}</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <option value="">{{ __('members.select') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="image">{{ __('members.image') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                                    <input type="file" id="image" name="image" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">{{ __('members.save') }}</button>
                        <a href="{{ route('members.index') }}" class="btn btn-outline-success">{{ __('members.cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <script>
            $(document).ready(function() {
                toastr.success('{{ session('success') }}', 'Success');
            });
        </script>
    @elseif (session('error'))
        <script>
            $(document).ready(function() {
                toastr.error('{{ session('error') }}', 'Error');
            });
        </script>
    @endif
@endsection
