@extends('layouts.app')

@section('content')
    <h1>Loan Details</h1>
    <p><strong>Invoice Number:</strong> {{ $loan->invoice_number }}</p>
    <p><strong>Book ID:</strong> {{ $loan->book_id }}</p>
    <p><strong>Member ID:</strong> {{ $loan->member_id }}</p>
    <p><strong>Loan Date:</strong> {{ $loan->loan_date }}</p>
    <p><strong>Due Date:</strong> {{ $loan->due_date }}</p>
    <p><strong>Status:</strong> {{ $loan->status }}</p>
    <p><strong>Renew Date:</strong> {{ $loan->renew_date }}</p>
    <p><strong>Fine:</strong> {{ $loan->fine }}</p>
    <p><strong>Fine Reason:</strong> {{ $loan->fine_reason }}</p>

    @if($loan->status == 'borrowed')
        <form action="{{ route('loans.renew', $loan->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="due_date">New Due Date</label>
                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', $loan->due_date) }}" required>
            </div>
            <div class="form-group">
                <label for="renew_date">Renew Date</label>
                <input type="date" name="renew_date" id="renew_date" class="form-control" value="{{ old('renew_date', $loan->renew_date) }}" required>
            </div>
            <div class="form-group">
                <label for="fine">Fine</label>
                <input type="number" step="0.01" name="fine" id="fine" class="form-control" value="{{ old('fine', $loan->fine) }}">
            </div>
            <div class="form-group">
                <label for="reason">Reason for Fine</label>
                <textarea name="reason" id="reason" class="form-control">{{ old('reason', $loan->fine_reason) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Renew Loan</button>
        </form>
    @endif
@endsection
