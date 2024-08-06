@extends('layouts.app')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h1>កែប្រែការខ្ចីសៀវភៅ</h1>
    </div>
    <div class="card-body">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('loans.update', $loan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Book Dropdown -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="book_id" class="form-label">សៀវភៅ</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-book"></i></span>
                        <select id="book_id" name="book_id" class="form-control" required>
                            <option value="">ជ្រើសរើសសៀវភៅ</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}"
                                    {{ $book->id == $loan->book_id ? 'selected' : '' }}>
                                    {{ $book->title }} ({{ $book->isbn }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Member Dropdown -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="member_id" class="form-label">សិស្ស</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <select id="member_id" name="member_id" class="form-control" required>
                            <option value="">ID សិស្ស</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ $member->id == $loan->member_id ? 'selected' : '' }}>
                                    {{ $member->memberId }} - {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Price Input -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="price">ប្រាក់កក់</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-sharp fa-solid fa-dollar-sign"></i></span>
                        <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $loan->price) }}" required>
                    </div>
                </div>

                <!-- Loan Date Input -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="loan_date">ខ្ចីនៅថ្ងៃ</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input type="date" id="loan_date" name="loan_date" class="form-control" value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <!-- Due Date Input -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="due_date">ថ្ងៃកំណត់</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('due_date', $loan->due_date->format('Y-m-d')) }}" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">រក្សាទុក</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2 for book dropdown
        $('#book_id').select2({
            theme: 'bootstrap-5'
        });

        // Initialize Select2 for member dropdown
        $('#member_id').select2({
            theme: 'bootstrap-5'
        });
    });
</script>
@endsection
