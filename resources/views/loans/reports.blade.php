@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Loan Reports</h1>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="weekly-tab" data-bs-toggle="tab" href="#weekly" role="tab" aria-controls="weekly" aria-selected="true">Weekly Reports</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="monthly-tab" data-bs-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Monthly Reports</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="total-tab" data-bs-toggle="tab" href="#total" role="tab" aria-controls="total" aria-selected="false">Total Reports</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Weekly Reports -->
        <div class="tab-pane fade show active" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
            <h2>Weekly Reports</h2>
            @if ($weeklyReports->isNotEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Book Title</th>
                            <th>Member Name</th>
                            <th>Loan Date</th>
                            <th>Due Date</th>
                            <th>Renew Date</th> <!-- Added column -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($weeklyReports as $loan)
                            <tr>
                                <td>{{ $loan->invoice_number }}</td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->member->name }}</td>
                                <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                                <td>{{ $loan->due_date->format('Y-m-d') }}</td>
                                <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td> <!-- Display renew_date -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No loans this week.</p>
            @endif
        </div>

        <!-- Monthly Reports -->
        <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
            <h2>Monthly Reports</h2>
            @if ($monthlyReports->isNotEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Book Title</th>
                            <th>Member Name</th>
                            <th>Loan Date</th>
                            <th>Due Date</th>
                            <th>Renew Date</th> <!-- Added column -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyReports as $loan)
                            <tr>
                                <td>{{ $loan->invoice_number }}</td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->member->name }}</td>
                                <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                                <td>{{ $loan->due_date->format('Y-m-d') }}</td>
                                <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td> <!-- Display renew_date -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No loans this month.</p>
            @endif
        </div>

        <!-- Total Reports -->
        <div class="tab-pane fade" id="total" role="tabpanel" aria-labelledby="total-tab">
            <h2>Total Reports</h2>
            @if ($totalReports->isNotEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Book Title</th>
                            <th>Member Name</th>
                            <th>Loan Date</th>
                            <th>Due Date</th>
                            <th>Renew Date</th> <!-- Added column -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($totalReports as $loan)
                            <tr>
                                <td>{{ $loan->invoice_number }}</td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->member->name }}</td>
                                <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                                <td>{{ $loan->due_date->format('Y-m-d') }}</td>
                                <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td> <!-- Display renew_date -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No loans available.</p>
            @endif
        </div>
    </div>
</div>
@endsection
