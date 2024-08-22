@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Loan Details</h5>
        </div>

        <div class="modal-body">
            <div class="row">

                <div class="col-md-4 mb-3">
                    @if ($loanHistory->book && $loanHistory->book->cover_image)
                        <img src="{{ asset($loanHistory->book->cover_image) }}" alt="Cover Image"
                            class="img-fluid rounded-start" style="width: 120px;">
                    @else
                        <img src="{{ asset('images/default-cover.jpg') }}" class="img-fluid rounded-start"
                            alt="Default Cover">
                    @endif
                </div>
                <div class="col-md-4 mb-3">
                    <p><strong>{{ __('messages.name') }}:</strong> {{ $loanHistory->member->name }} <strong>|</strong>
                        {{ $loanHistory->member->memberId }}</p>
                    <p><strong>{{ __('messages.gender') }}:</strong>
                        {{ $loanHistory->member->gender == 'male' ? 'ប្រុស' : 'ស្រី' }}</p>
                    <p><strong>{{ __('messages.phone') }}:</strong> {{ $loanHistory->member->phone }}</p>
                    <p><strong>{{ __('messages.year') }}:</strong> {{ $loanHistory->member->study->name }}</p>
                    <p><strong>{{ __('messages.field') }}:</strong> {{ $loanHistory->member->category->name }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p><strong>#{{ $loanHistory->invoice_number }}</strong></p>
                    <p><strong>{{ __('messages.loan_date') }}:</strong>
                        {{ \Carbon\Carbon::parse($loanHistory->loan_date)->format('Y-m-d') }}</p>
                    <p><strong>{{ __('messages.due_date') }}:</strong>
                        {{ \Carbon\Carbon::parse($loanHistory->due_date)->format('Y-m-d') }}</p>
                    <p><strong>{{ __('messages.renew_date') }}:</strong>
                        {{ $loanHistory->renew_date ? \Carbon\Carbon::parse($loanHistory->renew_date)->format('Y-m-d') : 'N/A' }}
                    </p>
                    <p><strong>{{ __('messages.return_date') }}:</strong>
                        {{ $loanHistory->pay_date ? \Carbon\Carbon::parse($loanHistory->pay_date)->format('Y-m-d') : 'N/A' }}
                    </p>

                    </p>
                </div>
            </div>
            <hr>
            <!-- Book Details Table -->
            <div class="row">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">{{ __('messages.code') }}</th>
                            <th scope="col">{{ __('messages.title') }}</th>
                            <th scope="col">{{ __('messages.author') }}</th>
                            <th scope="col">{{ __('messages.subject_name') }}</th>
                            <th scope="col">{{ __('messages.price') }}</th>
                            <th scope="col">{{ __('messages.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $loanHistory->book ? $loanHistory->book->isbn : 'N/A' }}</td>
                            <td>{{ $loanHistory->book ? $loanHistory->book->title : 'N/A' }}</td>
                            <td>
                                @if($loanHistory->book && $loanHistory->book->authors->isNotEmpty())
                                    {{ $loanHistory->book->authors->pluck('name')->join(', ') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            
                            <td>{{ $loanHistory->book && $loanHistory->book->genre->name ? $loanHistory->book->genre->name : 'N/A' }}
                            </td>
                            </td>
                            <td>{{ $loanHistory->price ?? 'N/A' }} ៛</td>
                            <td>
                                @if ($loanHistory->status === 'returned')
                                    <span class="badge badge-success">{{ __('messages.returned') }}</span>
                                @elseif ($loanHistory->status === 'borrowed')
                                    <span class="badge badge-warning">{{ __('messages.not_returned') }}</span>
                                @elseif ($loanHistory->status === 'reserved')
                                    <span class="badge badge-secondary">{{ __('messages.reserved') }}</span>
                                @else
                                    <span class="badge badge-dark">{{ __('messages.unknown') }}</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p><strong>{{ __('messages.fineBook') }}:</strong> {{ $loanHistory->fine ?? 'N/A' }}
                <strong>{{ __('messages.fine_reason') }}:</strong>
                {{ $loanHistory->fine_reason ?? 'N/A' }}
            </p>
        </div>

        <div class="modal-footer">
            {{-- @if (isset($loanHistory->member_id))
            <a href="{{ route('member.loanHistory.details', $loanHistory ->member_id) }}" class="btn btn-warning btn-sm">
                Invoices
            </a> --}}
            {{-- <a href="{{ route('loanBookHistories.showInvoice', ['id' => $loanHistory]) }}"class="btn btn-secondary btn-sm"><i
                    class="fa-solid fa-file-invoice"></i></a> --}}

            {{-- @endif --}}
            <a href="{{ route('loanBookHistories.index') }}"
                class="btn btn-outline-success btn-sm">{{ __('messages.back') }}</a>
            <button onclick="printLoanDetails()" class="btn btn-secondary btn-sm"><i class="fa-solid fa-print"></i>
                {{ __('messages.print') }}</button>
        </div>
    </div>

    @push('scripts')
        <script>
            function printLoanDetails() {
                // Create a new window or tab
                var printWindow = window.open('', '', 'height=600,width=800');

                // Write the content of the page to the new window
                printWindow.document.write('<html><head><title>Print Loan Details</title>');
                printWindow.document.write(
                    '<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">'); // Include your CSS
                printWindow.document.write('</head><body >');
                printWindow.document.write(document.querySelector('.container').innerHTML);
                printWindow.document.write('</body></html>');

                // Close the document to finish writing
                printWindow.document.close();

                // Wait for the content to load
                printWindow.onload = function() {
                    printWindow.focus(); // Focus on the new window
                    printWindow.print(); // Trigger the print dialog
                    printWindow.close(); // Close the window after printing
                };
            }
        </script>
    @endpush
@endsection
