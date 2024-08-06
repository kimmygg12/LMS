@extends('layouts.app')

@section('content')
<div class="row mt-4 mb-4">
    <div class="col">
            <h3>របាយការណ៍</h3>
        </div>
   
    </div>
    <div class="card">
        <div class="card-header">
            <h3>សៀវភៅដែលខ្ចីច្រើនជាងគេ</h3>
        </div>
        <div class="card-body">
            <!-- Form for date range selection -->
            <form method="GET" action="{{ route('loans.topBorrowedBooksReport') }}" class="mb-4">
                <div class="row">
                    <!-- Start Date Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
                        </div>
                    </div>
                    <!-- End Date Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
                        </div>
                    </div>
                    <!-- Button Column -->
                    <div class="col-md-12 d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success ">Generate Report</button>
                    </div>
                </div>
            </form>
            
            <div class="table-responsive">
            <table id="top-borrowed-books" class="table table-hover ">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Quantity</th>
                        <th>Total Borrowed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topBorrowedBooks as $item)
                        <tr>
                            <td>{{ $item['book']->title }}</td>
                            <td>{{ $item['book']->author->name ?? 'Unknown' }}</td>
                            <td>{{ $item['remaining_quantity'] }}</td>
                            <td>{{ $item['total_borrowed'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <!-- DataTables JS Initialization -->
    <script>
        $(document).ready(function() {
            $('#top-borrowed-books').DataTable({
                "paging": true,
                "searching": false, // Disable the search box
                "ordering": true,
                "info": true,
                "lengthMenu": [2, 5, 10],
                "dom": '<"top"lB>rt<"bottom"ip><"clear">', // Adjust layout
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i>',
                        title: 'Top Borrowed Books Report',
                        className: 'btn btn-secondary', // Apply Bootstrap button class
                        exportOptions: {
                            // Optional: Customize export options
                        }
                    },
                    // {
                    //     extend: 'pdfHtml5',
                    //     text: '<i class="fas fa-file-pdf"></i>',
                    //     title: 'Top Borrowed Books Report',
                    //     className: 'btn btn-danger', // Apply Bootstrap button class
                    //     exportOptions: {
                    //         // Optional: Customize export options
                    //     }
                    // },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i>',
                        className: 'btn btn-info', // Apply Bootstrap button class
                        exportOptions: {
                            // Optional: Customize export options
                        }
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

    <!-- Custom CSS for alignment -->
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

        .dataTables_paginate .paginate_button {
            padding: 0.5em 1em;
            margin: 0 0.25em;
            border: 1px solid #ddd;
            border-radius: 0.25em;
            font-size: 0.875em;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .dataTables_paginate .paginate_button.previous, 
        .dataTables_paginate .paginate_button.next {
            font-weight: bold;
        }
    </style>

@endsection
