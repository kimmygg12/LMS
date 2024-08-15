@extends('layouts.member')

@section('title', 'My Loans')

@section('content')
    <div class="container mt-4">
        <h1>{{ __('messages.my_loans') }}</h1>

        @if($loans->isNotEmpty())
        <div class="table-responsive mt-4 mb-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('messages.invoice_number') }}</th>
                        <th>{{ __('messages.book_title') }}</th>
                        <th>{{ __('messages.loan_date') }}</th>
                        <th>{{ __('messages.due_date') }}</th>
                        <th>{{ __('messages.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $loan)
                        <tr>
                            <td>{{ $loan->invoice_number }}</td>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->loan_date ? $loan->loan_date->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $loan->due_date ? $loan->due_date->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                @if ($loan->status === 'available')
                                    <span class="badge bg-success">{{ __('messages.status_available') }}</span>
                                @elseif ($loan->status === 'borrowed')
                                    <span class="badge bg-warning text-dark">{{ __('messages.status_borrowed') }}</span>
                                @elseif ($loan->status === 'overdue')
                                    <span class="badge bg-secondary">{{ __('messages.status_overdue') }}</span>
                                @elseif ($loan->status === 'reserved')
                                    <span class="badge bg-info text-dark">{{ __('messages.status_reserved') }}</span>
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

        <a href="{{ route('members.dashboard') }}" class="btn btn-secondary mt-3">{{ __('messages.back_to_dashboard') }}</a>
    </div>
@endsection
