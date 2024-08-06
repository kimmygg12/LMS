@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Loan Payments Report</h1>

    <form action="{{ route('dashboard.Payments') }}" method="GET">
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="action">Select Action:</label>
            <select name="action" id="action" class="form-control">
                <option value="loan" {{ $action === 'loan' ? 'selected' : '' }}>Loan</option>
                <option value="return" {{ $action === 'return' ? 'selected' : '' }}>Return</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

    <h2>Report for Action: {{ ucfirst($action) }}</h2>
    <p>Total Loans by Loan Date: {{ $totalLoansByLoanDate }}</p>
    <p>Total Loans by Pay Date: {{ $totalLoansByPayDate }}</p>

    @if($loans->isNotEmpty())
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice Number</th>
                <th>Book Title</th>
                <th>Member</th>
                <th>Study</th>
                <th>Category</th>
                <th>Price</th>
                <th>Loan Date</th>
                <th>Due Date</th>
                <th>Renew Date</th>
                <th>Return Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td>{{ $loan->id }}</td>
                <td>{{ $loan->invoice_number }}</td>
                <td>{{ $loan->book->title }}</td>
                <td>{{ $loan->member->name }}</td>
                <td>{{ $loan->member->study->name }}</td>
                <td>{{ $loan->member->category->name }}</td>
                <td>${{ number_format($loan->price, 2) }}</td>
                <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                <td>{{ $loan->due_date->format('Y-m-d') }}</td>
                <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                <td>{{ $loan->return_date ? $loan->return_date->format('Y-m-d') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No loans found for the selected period and action.</p>
    @endif
</div>
@endsection
