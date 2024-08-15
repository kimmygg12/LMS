{{-- @extends('layouts.app')

@section('content')
    <div class="row mt-4 mb-4">
        <div class="col">
            <h1>ខ្ចីសៀវភៅហួសកាលកំណត់</h1>

            <!-- No overdue books message -->
            <div id="no-overdue-books" class="alert alert-info text-center" style="display: none;">
                <p>No overdue books at the moment.</p>
            </div>

            <!-- Table container wrapped in a card -->
            <div id="table-container" class="card mt-3 mb-3">
                <div class="card-header ">
                    <h5 class="card-title mt-3 mb-3">សៀវភៅហួសកាលកំណត់</h5>
                </div>
                <div class="card-body">
                    <table id="overdue-books-table" class="table display nowrap" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="text-center">លេខ​វិ​ក័​យ​ប័ត្រ</th>
                                <th class="text-center">កូដ</th>
                                <th class="text-center">ចំណងជើង</th>
                                <th class="text-center">ឈ្មោះ</th>
                   
                                <th class="text-center">ថ្ងៃខ្ចី</th>
                                <th class="text-center">ថ្ងៃកំណត់</th>
                                <th class="text-center">ខ្ចីបន្ត</th>
                                <th class="text-center">ថ្ងៃហួសកំណត់</th>
    
                                <th class="text-center">ប៊ូតុង</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($overdueDetails as $detail)
                                <tr>
                                    <td class="text-center">{{ $detail['invoice_number'] }}</td>
                                    <td class="text-center">{{ $detail['book']->isbn }}</td>
                                    <td class="text-center">{{ $detail['book']->title ?? 'Unknown' }}</td>
                                    <td class="text-center">{{ $detail['member']->name ?? 'Unknown' }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($detail['loan_date'])->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($detail['due_date'])->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        {{ isset($detail['renew_date']) ? \Carbon\Carbon::parse($detail['renew_date'])->format('Y-m-d') : 'N/A' }}
                                    </td>
                                    <td class="text-center">{{ $detail['days_overdue'] }}</td>
                            
                                    <td class="text-center">
                                        <a href="{{ route('loans.finebook', $detail['id']) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-money-bill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No overdue books found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Check if the table has data
                if ($('#overdue-books-table tbody tr').length === 0) {
                    $('#no-overdue-books').show(); // Show no data message
                    $('#table-container').hide(); // Hide table
                } else {
                    $('#table-container').show(); // Show table
                    $('#no-overdue-books').hide(); // Hide no data message

                    // Initialize DataTable with responsiveness
                    $('#overdue-books-table').DataTable({
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
                            },
                            paginate: {
                                previous: "<i class='fas fa-chevron-left'></i> Previous",
                                next: "Next <i class='fas fa-chevron-right'></i>"
                            }
                        }
                    });
                }
            });
        </script>
        <style>
            .btn-custom {
                padding: 5px 10px;
                font-size: 12px;

            }
        </style>
    @endpush
@endsection --}}
@extends('layouts.app')

@section('content')
    <div class="row mt-4 mb-4">
        <div class="col">
            <h1>@lang('messages.overdue_books_title')</h1>

            <!-- No overdue books message -->
            <div id="no-overdue-books" class="alert alert-info text-center" style="display: none;">
                <p>@lang('messages.no_overdue_books_message')</p>
            </div>

            <!-- Table container wrapped in a card -->
            <div id="table-container" class="card mt-3 mb-3">
                <div class="card-header">
                    <h5 class="card-title mt-3 mb-3">@lang('messages.overdue_books_title')</h5>
                </div>
                <div class="card-body">
                    <table id="overdue-books-table" class="table display nowrap" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="text-center">@lang('messages.invoice_number')</th>
                                <th class="text-center">@lang('messages.code')</th>
                                <th class="text-center">@lang('messages.title')</th>
                                <th class="text-center">@lang('messages.name')</th>
                                <th class="text-center">@lang('messages.loan_date')</th>
                                <th class="text-center">@lang('messages.due_date')</th>
                                <th class="text-center">@lang('messages.renew_date')</th>
                                <th class="text-center">@lang('messages.days_overdue')</th>
                                <th class="text-center">@lang('messages.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($overdueDetails as $detail)
                                <tr>
                                    <td class="text-center">{{ $detail['invoice_number'] }}</td>
                                    <td class="text-center">{{ $detail['book']->isbn ?? 'Unknown'}}</td>
                                    <td class="text-center">{{ $detail['book']->title ?? 'Unknown' }}</td>
                                    <td class="text-center">{{ $detail['member']->name ?? 'Unknown' }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($detail['loan_date'])->format('Y-m-d') }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($detail['due_date'])->format('Y-m-d') }}</td>
                                    <td class="text-center">{{ isset($detail['renew_date']) ? \Carbon\Carbon::parse($detail['renew_date'])->format('Y-m-d') : 'N/A' }}</td>
                                    <td class="text-center">{{ $detail['days_overdue'] }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('loans.finebook', $detail['id']) }}" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-money-bill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">@lang('messages.no_overdue_books_message')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Check if the table has data
                if ($('#overdue-books-table tbody tr').length === 0) {
                    $('#no-overdue-books').show(); // Show no data message
                    $('#table-container').hide(); // Hide table
                } else {
                    $('#table-container').show(); // Show table
                    $('#no-overdue-books').hide(); // Hide no data message

                    // Initialize DataTable with responsiveness
                    $('#overdue-books-table').DataTable({
                        responsive: true,
                        dom: 'Bfrtip',
                        lengthMenu: [5, 10, 25],
                        buttons: [{
                                extend: 'excelHtml5',
                                text: '<i class="fas fa-file-excel"></i> @lang('messages.export_excel')',
                                className: 'btn btn-secondary btn-custom',
                            },
                            {
                                extend: 'print',
                                text: '<i class="fas fa-print"></i> @lang('messages.print')',
                                titleAttr: '@lang('messages.print')',
                                className: 'btn btn-secondary btn-custom'
                            }
                        ],
                        language: {
                            search: '',
                            searchPlaceholder: '@lang('messages.search_placeholder')',
                            searchBuilder: {
                                title: {
                                    _: '@lang('messages.filter')s applied:',
                                    0: '@lang('messages.no_filters')',
                                    1: '@lang('messages.one_filter')'
                                },
                                button: {
                                    0: '@lang('messages.filter')',
                                    1: '@lang('messages.filter')'
                                }
                            },
                            paginate: {
                                previous: "<i class='fas fa-chevron-left'></i> @lang('messages.previous')",
                                next: "@lang('messages.next') <i class='fas fa-chevron-right'></i>"
                            }
                        }
                    });
                }
            });
        </script>
        <style>
            .btn-custom {
                padding: 5px 10px;
                font-size: 12px;
            }
        </style>
    @endpush
@endsection
