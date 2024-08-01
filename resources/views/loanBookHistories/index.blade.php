@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Loan Records</h1>
            </div>
            <div class="card-body">
                <table id="datatablesSimpleQ" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>លេខ​វិ​ក័​យ​ប័ត្រ</th>
                            <th>Book ID</th>
                            <th>Member ID</th>
                            <th>Price</th>
                            <th>Loan Date</th>
                            <th>Due Date</th>
                            <th>Renew Date</th>
                            <th>Pay Date</th>
                            <th>Fine</th>
                            <th>Fine Reason</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loanHistory as $history)
                            <tr data-href="{{ route('loanBookHistories.show', $history->id) }}">
                                <td>{{ $history->invoice_number }}</td>
                                <td>{{ $history->book ? $history->book->title : 'Deleted Book' }}</td>
                                <td>{{ $history->member->name }}</td>
                                <td>{{ $history->price }}</td>
                                <td>{{ $history->loan_date }}</td>
                                <td>{{ $history->due_date }}</td>
                                <td>{{ $history->renew_date ?? 'N/A' }}</td>
                                <td>{{ $history->pay_date }}</td>
                                <td>{{ $history->fine }}</td>
                                <td>{{ $history->fine_reason }}</td>
                                <td>
                                    <a href="{{ route('loanBookHistories.show', $history->id) }}"
                                        class="btn btn-warning btn-sm">Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script>
    $(document).ready(function() {
        $('#datatablesSimpleQ').DataTable({
            dom: 'Bfrtip',
            pageLength: 5,
            responsive: true, // Enable responsive extension
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    titleAttr: 'Export to Excel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    titleAttr: 'Export to PDF',
                    className: 'btn btn-danger'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    titleAttr: 'Print',
                    className: 'btn btn-primary'
                }
            ]
        });
    });
</script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const datatablesSimpleA = document.getElementById('datatablesSimpleQ');

            if (datatablesSimpleA) {
                $(datatablesSimpleA).DataTable({
                    dom: 'Bfrtip',
                    pageLength: 3,
                    responsive: true,
                    buttons: [

                        {
                            extend: 'excelHtml5',
                            text: '<i class="fas fa-file-excel"></i> Excel',
                            titleAttr: 'Export to Excel',
                            className: 'btn btn-success'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fas fa-file-pdf"></i> PDF',
                            titleAttr: 'Export to PDF',
                            className: 'btn btn-danger'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i> Print',
                            titleAttr: 'Print',
                            className: 'btn btn-primary'
                        }

                    ],
                    language: {
                        search: "Search:", // Custom text for the search input
                        searchPlaceholder: "Type to search..." // Placeholder text
                    },
                    language: {
                        paginate: {
                            previous: '<i class="fas fa-chevron-left"></i> Previous',
                            next: 'Next <i class="fas fa-chevron-right"></i>'
                        }
                    }

                });

            }
        });
    </script>
@endpush
