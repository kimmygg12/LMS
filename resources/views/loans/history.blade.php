@extends('layouts.app')

@section('content')
    <h1>Loan Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Book ID</th>
                <th>Member ID</th>
                <th>Loan Date</th>
                <th>Due Date</th>
                <th>Price</th>
                <th>Invoice Number</th>
                <th>Status</th>
                <th>Renew Date</th>
                <th>Fine</th>
                <th>Fine Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
                <tr>
                    <td>{{ $loan->id }}</td>
                    <td>{{ $loan->book_id }}</td>
                    <td>{{ $loan->member_id }}</td>
                    <td>{{ $loan->loan_date }}</td>
                    <td>{{ $loan->due_date }}</td>
                    <td>{{ $loan->price }}</td>
                    <td>{{ $loan->invoice_number }}</td>
                    <td>{{ $loan->status }}</td>
                    <td>{{ $loan->renew_date }}</td>
                    <td>{{ $loan->fine }}</td>
                    <td>{{ $loan->fine_reason }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('loans.index') }}">Back to Loan History</a>
@endsection
