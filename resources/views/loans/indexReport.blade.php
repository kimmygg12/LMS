@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Loan Book Report</h3>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="borrowed-tab" data-bs-toggle="tab" href="#borrowed" role="tab" aria-controls="borrowed" aria-selected="true">Borrowed Reports</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="return-tab" data-bs-toggle="tab" href="#return" role="tab" aria-controls="return" aria-selected="false">Returned Reports</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3" id="myTabContent">
        <!-- Borrowed Reports -->
        <div class="tab-pane fade show active" id="borrowed" role="tabpanel" aria-labelledby="borrowed-tab">
            <form method="GET" action="{{ route('loans.indexReport') }}" class="mb-4">
                <div class="row">
                    <!-- Start Date Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate->toDateString() }}">
                        </div>
                    </div>
                    <!-- End Date Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate->toDateString() }}">
                        </div>
                    </div>
                    <!-- Button Column -->
                    <div class="col-md-12 d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success">Generate Report</button>
                    </div>
                </div>
            </form>

            <!-- Report Table -->
            <table class="table table-hover">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowedReports as $loan)
                        <tr>
                            <td>{{ $loan->id }}</td>
                            <td>{{ $loan->invoice_number }}</td>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->member->name }}</td>
                            <td>{{ $loan->member->study->name }}</td>
                            <td>{{ $loan->member->category->name }}</td>
                            <td>{{ $loan->price }}</td>
                            <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                            <td>{{ $loan->due_date->format('Y-m-d') }}</td>
                            <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Returned Reports -->
        <div class="tab-pane fade" id="return" role="tabpanel" aria-labelledby="return-tab">
            <form method="GET" action="{{ route('loans.indexReport') }}" class="mb-4">
                <div class="row">
                    <!-- Start Date Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate->toDateString() }}">
                        </div>
                    </div>
                    <!-- End Date Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate->toDateString() }}">
                        </div>
                    </div>
                    <!-- Button Column -->
                    <div class="col-md-12 d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success">Generate Report</button>
                    </div>
                </div>
            </form>

            <!-- Report Table -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Invoice Number</th>
                        <th>Book Title</th>
                        <th>Member</th>
                        <th>Loan Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Fine</th>
                        <th>Fine Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($returnedReports as $loan)
                        <tr>
                            <td>{{ $loan->id }}</td>
                            <td>{{ $loan->invoice_number }}</td>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->member->name }}</td>
                            <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                            <td>{{ $loan->due_date->format('Y-m-d') }}</td>
                            <td>{{ $loan->returned_at ? $loan->returned_at->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $loan->fine ?? 'N/A' }}</td>
                            <td>{{ $loan->fine_reason ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
