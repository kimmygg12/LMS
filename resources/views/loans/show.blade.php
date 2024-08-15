@extends('layouts.app')

@section('title', 'Loan Details')

@section('content')
    <h1>Loan Details</h1>
    <p>Book: {{ $loan->book->title }}</p>
    <p>Member: {{ $loan->member->name }}</p>
    <p>Loan Date: {{ $loan->loan_date->format('Y-m-d') }}</p>
    <p>Due Date: {{ $loan->due_date->format('Y-m-d') }}</p>
    <p>Status: {{ ucfirst($loan->status) }}</p>
    @if($loan->status === 'pending')
        <form method="POST" action="{{ route('loans.approve', $loan->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">Approve</button>
        </form>
    @endif
@endsection
