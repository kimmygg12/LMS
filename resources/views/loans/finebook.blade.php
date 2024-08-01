@extends('layouts.app')
@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h2>សងសៀវភៅ</h2>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card-body ">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('loans.finebook', $loan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title">ចំណងជើង</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title', $loan->book->title) }}" readonly>

                        @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="member_id">លេខសម្គាល់និងឈ្មោះ</label>
                        <input type="text" name="member_id" id="member_id" class="form-control"
                            value="{{ old('member_id', $loan->member->memberId) }} - {{ old('member_id', $loan->member->name) }}"
                            readonly>

                        @error('member_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="loan_date">ថ្ងៃខ្ចី</label>
                        <input type="date" name="loan_date" id="loan_date" class="form-control"
                            value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}" readonly>

                        @error('loan_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-6 mb-3">
                        <label for="due_date">ថ្ងៃកំណត់សង</label>
                        <input type="date" name="due_date" id="due_date" class="form-control"
                            value="{{ old('due_date', $loan->due_date->format('Y-m-d')) }}" readonly>

                        @error('due_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="renew_date">ខ្ចីបន្តដល់ថ្ងៃ</label>
                        <input type="date" name="renew_date" id="renew_date" class="form-control"
                            value="{{ old('renew_date', $loan->renew_date ? $loan->renew_date->format('Y-m-d') : '') }}">

                        @error('renew_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="pay_date">ថ្ងៃសង</label>
                        <input type="date" name="pay_date" id="pay_date" class="form-control"
                            value="{{ old('pay_date') }}">

                        @error('pay_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="price">ប្រាក់កក់</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="{{ old('price', $loan->price) }}" readonly>

                        @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fine">ផាកពិន័យ</label>
                        <input type="number" name="fine" id="fine" class="form-control"
                            value="{{ old('fine') }}">

                        @error('fine')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="fine_reason">មូលហេតុ</label>
                        <textarea name="fine_reason" id="fine_reason" class="form-control">{{ old('fine_reason') }}</textarea>

                        @error('fine_reason')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-sm">រក្សាទុក</button>
                <a href="{{ route('loans.index') }}" class="btn btn btn-outline-success btn-sm">ត្រឡប់ក្រោយ</a>
            </form>
        </div>
    </div>

@endsection
