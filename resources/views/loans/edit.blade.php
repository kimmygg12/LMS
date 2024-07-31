@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Loan</h1>
    <form action="{{ route('loans.update', $loan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="book_id">Book</label>
            <select name="book_id" id="book_id" class="form-control" required>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ $loan->book_id == $book->id ? 'selected' : '' }}>
                        {{ $book->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="member_id">Member</label>
            <select name="member_id" id="member_id" class="form-control" required>
                @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ $loan->member_id == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $loan->price }}" required>
        </div>
        <div class="form-group">
            <label for="loan_date">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date" class="form-control" value="{{ $loan->loan_date->format('Y-m-d') }}" required>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $loan->due_date->format('Y-m-d') }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
