{{-- @extends('layouts.app')

@section('content')
    <div class="row mt-4 mb-4">
        <h1>របាយការណ៍</h1>

        <form method="GET" action="{{ route('reports.combined') }}">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="start_date">ចាប់ពីថ្ងៃ​:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="{{ $startDate->format('Y-m-d') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="end_date">ថ្ងៃកំណត់:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="{{ $endDate->format('Y-m-d') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="action">ជ្រើសរើស:</label>
                    <select name="action" id="action" class="form-control">
                        <option value="loan" {{ $action === 'loan' ? 'selected' : '' }}>កំពុងខ្ចី</option>
                        <option value="return" {{ $action === 'return' ? 'selected' : '' }}>បានសង</option>
                        <option value="topBorrowedBooks" {{ $action === 'topBorrowedBooks' ? 'selected' : '' }}>
                            សៀវភៅដែមានការខ្ចីច្រើន</option>
                    </select>
                </div>
                <div class="col-md-12 d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-success">ស្វែងរក</button>
                </div>
            </div>
        </form>

        @if ($action === 'loan')
            @if ($loans->isNotEmpty())
                <table id="loansTable" class="table display nowrap" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="text-center">លេខ​វិ​ក័​យ​ប័ត្រ</th>
                            <th class="text-center">កូដ</th>
                            <th class="text-center">ចំណងជើង</th>
                            <th class="text-center">ឈ្មោះ</th>
                            <th class="text-center">ឆ្នាំ</th>
                            <th class="text-center">ជំនាញ</th>
                            <th class="text-center">ប្រាក់កក់</th>
                            <th class="text-center">ថ្ងៃខ្ចី</th>
                            <th class="text-center">ថ្ងៃកំណត់</th>
                            <th class="text-center">ខ្ចីបន្ត</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td class="text-center">{{ $loan->invoice_number }}</td>
                                <td class="text-center">{{ $loan->book->isbn }}</td>
                                <td class="text-center">{{ $loan->book->title }}</td>
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
                        <th class="text-center">លេខ​វិ​ក័​យ​ប័ត្រ</th>
                        <th class="text-center">កូដ</th>
                        <th class="text-center">ចំណងជើង</th>
                        <th class="text-center">ឈ្មោះ</th>
                        <th class="text-center">ឆ្នាំ</th>
                        <th class="text-center">ជំនាញ</th>
                        <th class="text-center">ប្រាក់កក់</th>
                        <th class="text-center">ថ្ងៃខ្ចី</th>
                        <th class="text-center">ថ្ងៃកំណត់</th>
                        <th class="text-center">ខ្ចីបន្ត</th>
                        <th class="text-center">ថ្ងៃសង</th>
                        <th class="text-center">ផាកពិន័យ</th>
                        <th class="text-center">មូលហេតុ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historyData as $history)
                        <tr>
                            <td class="text-center">{{ $history->invoice_number }}</td>
                            <td class="text-center">{{ $history->book->isbn }}</td>
                            <td class="text-center">{{ $history->book ? $history->book->title : 'Deleted Book' }}</td>
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
           
            <table id="topBorrowedBooksTable" class="table display nowrap" style="width: 100%">
                <thead>
                    <tr>
                        <th class="text-center">កូដ</th>
                        <th class="text-center">ជើងសៀវភៅ</th>
                        <th class="text-center">ប្រភេទ</th>
                        <th class="text-center">ចំនួន</th>
                        <th class="text-center">កំពុងខ្ចី</th>
                        <th class="text-center">ចំនួនសង</th>
                        <th class="text-center">ខ្ចីសរុប</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topBorrowedBooks as $record)
                        <tr>
                            <td class="text-center">{{ $record['book']->isbn }}</td>
                            <td class="text-center">{{ $record['book']->title }}</td>
                            <td class="text-center">{{ $record['book']->subject->name }}</td>
                            <td class="text-center">{{ $record['remaining_quantity'] }}</td>
                            <td class="text-center">{{ $record['quantity_on_loan'] }}</td>
                            <td class="text-center">{{ $record['loanHistoryCount'] }}</td>
                            <td class="text-center">{{ $record['remainingQuantitycount'] }}</td>
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
@endsection --}}
<!-- resources/views/reports/combinedReport.blade.php -->

@extends('layouts.app') <!-- Adjust according to your layout -->

@section('content')
    <div class="row mt-4 mb-4">
        <h1>របាយការណ៍</h1>

        <form method="GET" action="{{ route('reports.combinedReport') }}">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="start_date">ចាប់ពីថ្ងៃ​:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="{{ $startDate->format('Y-m-d') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="end_date">ថ្ងៃកំណត់:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="{{ $endDate->format('Y-m-d') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="action">ជ្រើសរើស:</label>
                    <select name="action" id="action" class="form-control">
                        <option value="loan" {{ $action === 'loan' ? 'selected' : '' }}>កំពុងខ្ចី</option>
                        <option value="return" {{ $action === 'return' ? 'selected' : '' }}>បានសង</option>
                        <option value="topBorrowedBooks" {{ $action === 'topBorrowedBooks' ? 'selected' : '' }}>
                            សៀវភៅដែមានការខ្ចីច្រើន</option>
                    </select>
                </div>
                <div class="col-md-12 d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-success">ស្វែងរក</button>
                </div>
            </div>
        </form>
        @if ($action === 'loan')
            @if ($loans->isNotEmpty())
                <table id="loansTable" class="table display nowrap" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="text-center">លេខ​វិ​ក័​យ​ប័ត្រ</th>
                            <th class="text-center">កូដ</th>
                            <th class="text-center">ចំណងជើង</th>
                            <th class="text-center">ឈ្មោះ</th>
                            <th class="text-center">ឆ្នាំ</th>
                            <th class="text-center">ជំនាញ</th>
                            <th class="text-center">ប្រាក់កក់</th>
                            <th class="text-center">ថ្ងៃខ្ចី</th>
                            <th class="text-center">ថ្ងៃកំណត់</th>
                            <th class="text-center">ខ្ចីបន្ត</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td class="text-center">{{ $loan->invoice_number }}</td>
                                <td class="text-center">{{ $loan->book->isbn }}</td>
                                <td class="text-center">{{ $loan->book->title }}</td>
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
                        <th class="text-center">លេខ​វិ​ក័​យ​ប័ត្រ</th>
                        <th class="text-center">កូដ</th>
                        <th class="text-center">ចំណងជើង</th>
                        <th class="text-center">ឈ្មោះ</th>
                        <th class="text-center">ឆ្នាំ</th>
                        <th class="text-center">ជំនាញ</th>
                        <th class="text-center">ប្រាក់កក់</th>
                        <th class="text-center">ថ្ងៃខ្ចី</th>
                        <th class="text-center">ថ្ងៃកំណត់</th>
                        <th class="text-center">ខ្ចីបន្ត</th>
                        <th class="text-center">ថ្ងៃសង</th>
                        <th class="text-center">ផាកពិន័យ</th>
                        <th class="text-center">មូលហេតុ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historyData as $history)
                        <tr>
                            <td class="text-center">{{ $history->invoice_number }}</td>
                            <td class="text-center">{{$history->book ? $history->book->isbn : 'Deleted' }}</td>
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
        <!-- Display Top Borrowed Books -->
        @if ($action === 'topBorrowedBooks')
            <h2>Top Borrowed Books</h2>
            <table id="topBorrowedBooksTable" class="table display nowrap" style="width: 100%">
                <thead>
                    <tr>
                        <th class="text-center">កូដ</th>
                        <th class="text-center">ជើងសៀវភៅ</th>
                        <th class="text-center">ប្រភេទ</th>
                        <th class="text-center">ចំនួន</th>
                        <th class="text-center">Total Borrowed</th>
                        {{-- <th class="text-center">Quantity On Loan</th> --}}
                        <th class="text-center">Remaining Quantity</th>
                        <th class="text-center">Loan History Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topBorrowedBooks as $item)
                        <tr>
                            <td class="text-center">{{ $item['book']->isbn }}</td>
                            <td class="text-center">{{ $item['book']->title }}</td>
                            <td class="text-center">{{ $item['book']->subject->name }}</td>
                            <td class="text-center">{{ $item['remaining_quantity'] }}</td>
                            <td class="text-center">{{ $item['total_borrowed'] }}</td>
                            {{-- <td class="text-center">{{ $item['quantity_on_loan'] }}</td> --}}
                            <td class="text-center">{{ $item['loanHistoryCount'] }}</td>
                            <td class="text-center">{{ $item['remainingQuantitycount'] }}</td>
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