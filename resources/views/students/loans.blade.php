@extends('layouts.studentbook')

@section('title', 'My Loans')

@section('content')
    <div class="container mt-4">
        <h1>{{ __('messages.my_loans') }}</h1>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="loanTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="current-loans-tab" data-bs-toggle="tab" href="#current-loans" role="tab"
                    aria-controls="current-loans" aria-selected="true">
                    {{ __('messages.current_loans') }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="loan-history-tab" data-bs-toggle="tab" href="#loan-history" role="tab"
                    aria-controls="loan-history" aria-selected="false">
                    {{ __('messages.loan_history') }}
                </a>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content mt-4" id="loanTabsContent">
            <!-- Current Loans Tab -->
            <div class="tab-pane fade show active" id="current-loans" role="tabpanel" aria-labelledby="current-loans-tab">
                @if ($loans->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.invoice_number') }}</th>
                                    <th>{{ __('messages.isbn') }}</th>

                                    <th>{{ __('messages.book_title') }}</th>
                                    <th>{{ __('messages.loan_date') }}</th>
                                    <th>{{ __('messages.due_date') }}</th>
                                    <th>{{ __('messages.renew_date') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr>
                                        <td>{{ $loan->invoice_number }}</td>
                                        <td>{{ $loan->book->isbn }}</td>
                                        <td>{{ $loan->book ? $loan->book->title : 'N/A' }}</td>
                                        <td>{{ $loan->loan_date ? $loan->loan_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>{{ $loan->due_date ? $loan->due_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>
                                            @if ($loan->status === 'available')
                                                <span class="badge bg-success">{{ __('messages.status_available') }}</span>
                                            @elseif ($loan->status === 'borrowed')
                                                <span
                                                    class="badge bg-warning text-dark">{{ __('messages.status_borrowed') }}</span>
                                            @elseif ($loan->status === 'overdue')
                                                <span class="badge bg-secondary">{{ __('messages.status_overdue') }}</span>
                                            @elseif ($loan->status === 'reserved')
                                                <span
                                                    class="badge bg-info text-dark">{{ __('messages.status_reserved') }}</span>
                                            @elseif($loan->status === 'rejected')
                                                <span class="badge bg-danger">{{ __('messages.status_rejected') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>{{ __('messages.no_loans') }}</p>
                @endif
            </div>

            <!-- Loan History Tab -->
            <div class="tab-pane fade" id="loan-history" role="tabpanel" aria-labelledby="loan-history-tab">
                @if ($loanHistory->isEmpty())
                    <p>{{ __('messages.no_loan_history') }}</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('messages.invoice_number') }}</th>
                                <th>{{ __('messages.isbn') }}</th>
                                <th>{{ __('messages.book_title') }}</th>
                                <th>{{ __('messages.loan_date') }}</th>
                                <th>{{ __('messages.loan_renew') }}</th>
                                <th>{{ __('messages.return_date') }}</th>
                                <th>{{ __('messages.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loanHistory as $history)
                                <tr>
                                    <td>{{ $history->invoice_number }}</td>
                                    <td>{{ $history->book->isbn }}</td>
                                    <td>{{ $history->book->title }}</td>
                                    <td>{{ $history->loan_date->format('Y-m-d') }}</td>
                                    <td>{{ $history->renew_date ? $history->renew_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $history->pay_date ? $history->pay_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>
                                        @if ($history->status === 'borrowed')
                                            <span class="badge bg-primary">{{ __('messages.status_borrowed') }}</span>
                                        @elseif ($history->status === 'returned')
                                            <span class="badge bg-success">{{ __('messages.status_returned') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <a href="{{ route('students.dashboard') }}"
            class="btn btn-secondary mt-3">{{ __('messages.back_to_dashboard') }}</a>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var tabEl = document.querySelector('#loanTabs');
                var tab = new bootstrap.Tab(tabEl.querySelector('.nav-link.active'));
                tab.show();
            });
        </script>
    @endpush
@endsection
