@extends('layouts.app')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h1>Create New Loan</h1>
    </div>
    <div class="card-body">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('loans.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Book ISBN Dropdown -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="isbn" class="form-label">Book ISBN</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-book-bookmark"></i></span>
                        <select id="isbn" name="isbn" class="form-control" required>
                            <option value="">Select a book by ISBN</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->isbn }}" 
                                    data-id="{{ $book->id }}"
                                    data-title="{{ $book->title }}"
                                    data-price="{{ $book->price }}">
                                    {{ $book->isbn }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Book Title -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="title">Title</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-book"></i></span>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" readonly>
                </div>
            </div>

                <!-- Member Dropdown -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="member_id" class="form-label">Member</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <select id="member_id" name="member_id" class="form-control" required>
                            <option value="">Select a member</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->memberId }} - {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Price Input -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="price">Price</label>
                    <div class="input-group">
                        <span class="input-group-text" style="width: 40px"><i class="fa-solid fa-dollar-sign"></i></span>
                        <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}">
                    </div>
                </div>

                <!-- Loan Date Input -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="loan_date">Loan Date</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input type="date" id="loan_date" name="loan_date" class="form-control" value="{{ old('loan_date') }}" required>
                    </div>
                </div>

                <!-- Due Date Input -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="due_date">Due Date</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('due_date') }}" required>
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
        // Initialize Select2 for member dropdown
        $('#member_id').select2({
            theme: 'bootstrap-5'
        });

        // Initialize Select2 for ISBN dropdown
        $('#isbn').select2({
            theme: 'bootstrap-5'
        });

        // Update title and price fields based on selected ISBN
        $('#isbn').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            $('#title').val(selectedOption.data('title'));
            $('#price').val(selectedOption.data('price'));
        });
    });
</script>
@endsection
