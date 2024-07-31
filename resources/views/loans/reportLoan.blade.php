@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Loan Reports</h1>
        <ul class="nav nav-tabs" id="reportTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="daily-tab" data-bs-toggle="tab" href="#daily" role="tab"
                    aria-controls="daily" aria-selected="true">Daily</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="weekly-tab" data-bs-toggle="tab" href="#weekly" role="tab"
                    aria-controls="weekly" aria-selected="false">Weekly</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="monthly-tab" data-bs-toggle="tab" href="#monthly" role="tab"
                    aria-controls="monthly" aria-selected="false">Monthly</a>
            </li>
        </ul>
        <div class="tab-content" id="reportTabsContent">
            <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab">
                <h3>Daily Report</h3>
                <p>Total Issued: {{ $totalIssued }}</p>
                <p>Total Returned: {{ $totalLoanHistory }}</p>
            </div>
            <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                <h3>Weekly Report</h3>
                <p>Total Issued: {{ $totalIssued }}</p>
                <p>Total Returned: {{ $totalLoanHistory }}</p>
            </div>
            <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                <h3>Monthly Report</h3>
                <p>Total Issued: {{ $totalIssued }}</p>
                <p>Total Returned: {{ $totalLoanHistory }}</p>

            </div>
        </div>
    </div>

    </div>
@endsection
