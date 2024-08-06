@extends('layouts.app')

@section('content')
<div class="row mt-4 mb-4">
    <h1>របាយការណ៍</h1>

    <form action="{{ route('loans.combinedReport') }}" method="GET">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}" required>
            </div>
            <div class="form-group col-md-4">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}" required>
            </div>
            <div class="form-group col-md-4">
                <label for="action">Select Action:</label>
                <select name="action" id="action" class="form-control">
                    <option value="loan" {{ $action === 'loan' ? 'selected' : '' }}>កំពុងខ្ចី</option>
                    <option value="return" {{ $action === 'return' ? 'selected' : '' }}>បានសង</option>
                    <option value="topBorrowedBooks" {{ $action === 'topBorrowedBooks' ? 'selected' : '' }}>សៀវភៅដែមានការខ្ចីច្រើន</option>
                </select>
            </div>
            <div class="col-md-12 d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-success ">Generate Report</button>
            </div>
        </div>
        
    </form>

    @if($action === 'loan' || $action === 'return')
        {{-- <h2>Loan Report for Action: {{ ucfirst($action) }}</h2> --}}
        
        @if($loans->isNotEmpty())
        <h3>Loans</h3>
        <div class="table-responsive">
        <table id="loansTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
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
                    {{-- <td>{{ $loan->id }}</td> --}}
                    <td>{{ $loan->invoice_number }}</td>
                    <td>{{ $loan->book->title }}</td>
                    <td>{{ $loan->member->name }}</td>
                    <td>{{ $loan->member->study->name }}</td>
                    <td>{{ $loan->member->category->name }}</td>
                    <td>{{ number_format($loan->price) }}៛</td>
                    <td>{{ $loan->loan_date ? $loan->loan_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $loan->due_date ? $loan->due_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $loan->return_date ? $loan->return_date->format('Y-m-d') : 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @else
        {{-- <p>No loans found for the selected period.</p> --}}
        @endif
    @endif

    @if($action === 'topBorrowedBooks')
        {{-- <h3>Top Borrowed Books Report</h3> --}}
        @if($topBorrowedBooks->isNotEmpty())
        <div class="table-responsive">
        <table id="topBorrowedBooksTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Remaining Quantity</th>
                    <th>Quantity on Loan</th>
                    <th>total_borrowed</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topBorrowedBooks as $bookData)
                <tr>
                    <td>{{ $bookData['book']->title }}</td>
                    <td>{{ $bookData['remaining_quantity'] }}</td>
                    <td>{{ $bookData['quantity_on_loan'] }}</td>
                    <td>{{$bookData['total_borrowed']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @else
        <p>No top borrowed books found for the selected period.</p>
        @endif
    @endif

    @if($action === 'return')
    {{-- <h2>Total Loans by Pay Date: {{ $totalLoansByPayDate }}</h2> --}}
    
    @if($totalLoansByPayDate > 0)
        {{-- <h3>Loan Book History by Pay Date</h3> --}}
        <div class="table-responsive">
        <table id="historyTable" class="display nowrap" style="width:100%">
    
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Book Title</th>
                    <th>Member</th>
                    <th>Price</th>
                    <th>Loan Date</th>
                    <th>Due Date</th>
                    <th>Renew Date</th>
                    <th>Pay Date</th>
                    <th>Fine</th>
                    <th>Fine Reason</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historyData as $history)
                    <tr>
                        <td>{{ $history->invoice_number }}</td>
                        <td>{{ $history->book ? $history->book->title : 'Deleted Book' }}</td>
                        <td>{{ $history->member ? $history->member->name : 'Unknown Member' }}</td>
                        <td>${{ number_format($history->price, 2) }}</td>
                        <td>{{ $history->loan_date ? $history->loan_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $history->due_date ? $history->due_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $history->renew_date ? $history->renew_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $history->pay_date ? $history->pay_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>${{ number_format($history->fine, 2) }}</td>
                        <td>{{ $history->fine_reason ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @else
        <p>No returns found for the selected period.</p>
    @endif
@endif
</div>

@section('scripts')

<script>
    
    $(document).ready(function() {
        $('#loansTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [3, 10, 25],
            "dom": '<"top"lB>rt<"bottom"ip><"clear">',
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i>',
                    title: 'Loans Report',
                    className: 'btn btn-secondary',
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    className: 'btn btn-info',
                }
            ],
            "language": {
                "lengthMenu": "_MENU_",
                "search": "Filter records:",
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                }
            }
        });

        $('#topBorrowedBooksTable').DataTable({
            "paging": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "lengthMenu": [3, 10, 25],
            "dom": '<"top"lB>rt<"bottom"ip><"clear">',
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i>',
                    title: 'Top Borrowed Books Report',
                    className: 'btn btn-secondary',
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    className: 'btn btn-info',
                }
            ],
            "language": {
                "lengthMenu": "_MENU_",
                "search": "Filter records:",
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                }
            }
        });

        $('#historyTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [3, 10, 25],
            "dom": '<"top"lB>rt<"bottom"ip><"clear">',
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i>',
                    title: 'Loan Book History Report',
                    className: 'btn btn-secondary',
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    className: 'btn btn-info',
                }
            ],
            "language": {
                "lengthMenu": "_MENU_",
                "search": "Filter records:",
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                }
            }
        });
    });
</script>
<style>
    .dataTables_wrapper .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dataTables_wrapper .top .dataTables_length {
        margin-right: auto;
    }

    .dataTables_wrapper .top .dt-buttons {
        margin-left: auto;
    }

    .btn-success {
        background-color: #28a745; /* Green background */
        border-color: #28a745;
     
    }
    .btn-secondary {
        background-color: #28a745; /* Green background */
        border-color: #28a745;
        padding: 5px 10px;
        font-size: 12px;
    }

    .btn-danger {
        background-color: #dc3545; /* Red background */
        border-color: #dc3545;
        padding: 5px 10px;
        font-size: 12px;
    }

    .btn-info {
        background-color: #17a2b8; /* Blue background */
        border-color: #17a2b8;
        padding: 5px 10px;
        font-size: 12px;
    }

    .btn i {
        color: white; /* White icon color */
    }

    /* .dataTables_paginate .paginate_button {
        padding: 0.5em 1em;
        margin: 0 0.25em;
        border: 1px solid #ddd;
        border-radius: 0.25em;
        font-size: 0.875em;
    } */

    /* .dataTables_paginate .paginate_button.current {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    } */

    /* .dataTables_paginate .paginate_button.previous, 
    .dataTables_paginate .paginate_button.next {
        font-weight: bold;
    } */
</style>
@endsection
@endsection
