@extends('layouts.app')

@section('content')
    <div class="row mt-4 mb-4">
        <h1>{{ __('messages.report') }}</h1>

        <form method="GET" action="{{ route('reports.combinedReport') }}">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="start_date">{{ __('messages.start_date') }}</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="{{ $startDate->format('Y-m-d') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="end_date">{{ __('messages.end_date') }}</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="{{ $endDate->format('Y-m-d') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="action">{{ __('messages.select') }}</label>
                    <select name="action" id="action" class="form-control">
                        <option value="loan" {{ $action === 'loan' ? 'selected' : '' }}>
                            {{ __('messages.action_loan') }}
                        </option>
                        <option value="return" {{ $action === 'return' ? 'selected' : '' }}>
                            {{ __('messages.action_return') }}
                        </option>
                        <option value="topBorrowedBooks" {{ $action === 'topBorrowedBooks' ? 'selected' : '' }}>
                            {{ __('messages.action_top_borrowed_books') }}
                        </option>
                    </select>
                </div>
                <div class="col-md-12 d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-success">{{ __('messages.searchs') }}</button>
                </div>
            </div>
        </form>
        @if ($action === 'loan')
            @if ($loans->isNotEmpty())
                <table id="loansTable" class="table display nowrap" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="text-center">{{ __('messages.invoice_number') }}</th>
                            <th class="text-center">{{ __('messages.code') }}</th>
                            <th class="text-center">{{ __('messages.title') }}</th>
                            <th class="text-center">{{ __('messages.name') }}</th>
                            <th class="text-center">{{ __('messages.year') }}</th>
                            <th class="text-center">{{ __('messages.skill') }}</th>
                            <th class="text-center">{{ __('messages.price') }}</th>
                            <th class="text-center">{{ __('messages.loan_date') }}</th>
                            <th class="text-center">{{ __('messages.due_date') }}</th>
                            <th class="text-center">{{ __('messages.renew_date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td class="text-center">{{ $loan->invoice_number }}</td>
                                <td class="text-center">{{ $loan->member ? $loan->member->name : 'No Member' }}</td>
                                <td class="text-center">{{ $loan->book ? $loan->book->title : 'No Book' }}</td>
                                
                                <td class="text-center">{{ $loan->member->name }}</td>
                                <td class="text-center">{{ $loan->member->study->name }}</td>
                                <td class="text-center">{{ $loan->member->category->name }}</td>
                                <td class="text-center">{{ number_format($loan->price) }}៛</td>
                                <td class="text-center">{{ $loan->loan_date ? $loan->loan_date->format('Y-m-d') : 'N/A' }}
                                </td>
                                <td class="text-center">{{ $loan->due_date ? $loan->due_date->format('Y-m-d') : 'N/A' }}
                                </td>
                                <td class="text-center">
                                    {{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endif
        @if ($action === 'return')
            <table id="historyTable" class="table display nowrap" style="width: 100%">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('messages.invoice_number') }}</th>
                        <th class="text-center">{{ __('messages.code') }}</th>
                        <th class="text-center">{{ __('messages.title') }}</th>
                        <th class="text-center">{{ __('messages.name') }}</th>
                        <th class="text-center">{{ __('messages.year') }}</th>
                        <th class="text-center">{{ __('messages.skill') }}</th>
                        <th class="text-center">{{ __('messages.price') }}</th>
                        <th class="text-center">{{ __('messages.loan_date') }}</th>
                        <th class="text-center">{{ __('messages.due_date') }}</th>
                        <th class="text-center">{{ __('messages.renew_date') }}</th>
                        <th class="text-center">{{ __('messages.return_date') }}</th>
                        <th class="text-center">{{ __('messages.fineBook') }}</th>
                        <th class="text-center">{{ __('messages.fine_reason') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historyData as $history)
                        <tr>
                            <td class="text-center">{{ $history->invoice_number }}</td>
                            <td class="text-center">{{ $history->book ? $history->book->isbn : 'Deleted' }}</td>
                            <td class="text-center">{{ $history->book ? $history->book->title : 'Deleted' }}</td>
                            <td class="text-center">{{ $history->member ? $history->member->name : 'Unknown Member' }}</td>
                            <td class="text-center">{{ $history->member ? $history->member->study->name : 'Unknown' }}</td>
                            <td class="text-center">{{ $history->member ? $history->member->category->name : 'Unknown' }}
                            </td>
                            <td class="text-center">{{ number_format($history->price) }}៛</td>
                            <td class="text-center">
                                {{ $history->loan_date ? $history->loan_date->format('Y-m-d') : 'N/A' }}</td>
                            <td class="text-center">{{ $history->due_date ? $history->due_date->format('Y-m-d') : 'N/A' }}
                            </td>
                            <td class="text-center">
                                {{ $history->renew_date ? $history->renew_date->format('Y-m-d') : 'N/A' }}</td>
                            <td class="text-center">{{ $history->pay_date ? $history->pay_date->format('Y-m-d') : 'N/A' }}
                            </td>
                            <td class="text-center">
                                {{ $history->fine !== null ? number_format($history->fine) . '៛' : 'N/A' }}
                            </td>
                            <td class="text-center">{{ $history->fine_reason ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if ($action === 'topBorrowedBooks')
            {{-- <h2>Top Borrowed Books</h2> --}}
            <table id="topBorrowedBooksTable" class="table display nowrap" style="width: 100%">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('messages.code') }}</th>
                        <th class="text-center">{{ __('messages.book_title') }}</th>
                        <th class="text-center">{{ __('messages.type') }}</th>
                        <th class="text-center">{{ __('messages.quantity') }}</th>
                        <th class="text-center">{{ __('messages.total_borrowed') }}</th>
                        <th class="text-center">{{ __('messages.remaining_quantity') }}</th>
                        <th class="text-center">{{ __('messages.loan_history_count') }}</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($topBorrowedBooks as $item)
                        <tr>
                            <td class="text-center">{{ $item['book']->isbn }}</td>
                            <td class="text-center">{{ $item['book']->title }}</td>
                            <td class="text-center">{{ $item['book']->subject->name }}</td>
                            <td class="text-center">{{ $item['remaining_quantity'] }} {{ __('messages.Total') }}</td>
                            <td class="text-center">{{ $item['total_borrowed'] }} {{ __('messages.Total') }}</td>
                            {{-- <td class="text-center">{{ $item['quantity_on_loan'] }}</td> --}}
                            <td class="text-center">{{ $item['loanHistoryCount'] }} {{ __('messages.Total') }}</td>
                            <td class="text-center">{{ $item['remainingQuantitycount'] }} {{ __('messages.Total') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // DataTable for loans
            $('#loansTable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [5, 10, 25],
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Export Excel',
                        className: 'btn btn-secondary btn-custom',

                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        titleAttr: 'Print',
                        className: 'btn btn-secondary btn-custom'
                    }
                ],
                paging: true,
                searching: true,
                language: {
                    search: '',
                    searchPlaceholder: 'ស្វែងរក...',

                }
            });
            $('#historyTable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [5, 10, 25],
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Export Excel',
                        className: 'btn btn-secondary btn-custom',

                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        titleAttr: 'Print',
                        className: 'btn btn-secondary btn-custom'
                    }
                ],
                language: {
                    search: '',
                    searchPlaceholder: 'ស្វែងរក...',

                }
            });
            $('#topBorrowedBooksTable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [5, 10, 25],
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Export Excel',
                        className: 'btn btn-secondary btn-custom',

                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        titleAttr: 'Print',
                        className: 'btn btn-secondary btn-custom'
                    }
                ],
                language: {
                    search: '',
                    searchPlaceholder: 'ស្វែងរក...',

                }
            });
        });
    </script>
    <style>
        .btn-custom {
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
@endsection
