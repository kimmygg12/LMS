{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Loan</h1>
    <form action="{{ route('loans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="book_id" class="form-label">Book</label>
            <select name="book_id" id="book_id" class="form-select" required>
                <option value="">Select a book</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="member_id" class="form-label">Member</label>
            <select name="member_id" id="member_id" class="form-select" required>
                <option value="">Select a member</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="loan_date" class="form-label">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Loan</button>
    </form>
</div>

@endsection --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Loan</h1>

    <form action="{{ route('loans.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="book_id">Book</label>
            <select id="book_id" name="book_id" class="form-control" required>
                @foreach ($books as $book)
                <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="member_id">Member</label>
            <select id="member_id" name="member_id" class="form-control" required>
                @foreach ($members as $member)
                <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="loan_date">Loan Date</label>
            <input type="date" id="loan_date" name="loan_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="price">price</label>
            <input type="text" id="price" name="price" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Create Loan</button>
    </form>
</div>
@endsection
