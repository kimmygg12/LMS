@extends('layouts.app')

@section('content')
    <h1>Overdue Books Report</h1>

    @if($overdueDetails->isEmpty())
        <p>No overdue books at the moment.</p>
    @else
        <table id="overdue-books-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Member Name</th>
                    <th>Book Title</th>
                    <th>Due Date</th>
                    <th>Days Overdue</th>
                    <th>Fine</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overdueDetails as $detail)
                    <tr>
                        <td>{{ $detail['member']->name }}</td>
                        <td>{{ $detail['book']->title }}</td>
                        <td>{{ $detail['due_date'] }}</td>
                        <td>{{ $detail['days_overdue'] }}</td>
                        <td>{{ number_format($detail['fine'], 2) }}៛</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- <script>
        $(document).ready(function() {
            $('#overdue-books-table').DataTable({
                // dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: 'Overdue Books Report',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });
        });
    </script> --}} <script>
        $(document).ready(function() {
            $('#overdue-books-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: 'Overdue Books Report',
                        className: 'btn btn-success'
                      
                    },
                    'searchBuilder' // This will add the search functionality
                ],
                language: {
                    searchBuilder: {
                        title: {
                            _: 'Filter(s) applied:',
                            0: 'No filters applied',
                            1: '1 filter applied'
                        },
                        button: {
                            0: 'Filter',
                            1: 'Filter'
                        }
                    }
                }
            });
        });
    </script>
@endsection
