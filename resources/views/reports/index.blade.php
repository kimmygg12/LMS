@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Book Report</h1>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Remaining Quantity</th>
                            <th>Quantity on Loan</th>
                            <th>Total Borrowed</th>
                            <th>Loan History</th>
                            <th>Loan History</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookRecords as $record)
                            <tr>
                                <td>{{ $record['title'] }}</td>
                                <td>{{ $record['remaining_quantity'] }}</td>
                                <td>{{ $record['quantity_on_loan'] }}</td>
                                <td>{{ $record['total_borrowed'] }}</td>
                                <td>{{ $record['loan_history_count'] }}</td>
                                <td>
                                    @foreach ($record['loan_history'] as $history)
                                        <div>
                                            <p><strong>Loan Date:</strong> {{ \Carbon\Carbon::parse($history->loan_date)->format('Y-d-m') }}</p>
                                            <p><strong>Return Date:</strong> {{ $history->returned_at ? \Carbon\Carbon::parse($history->returned_at)->format('Y-d-m') : 'Not Returned' }}</p>
                                            <p><strong>Quantity:</strong> {{ $history->quantity }}</p>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
