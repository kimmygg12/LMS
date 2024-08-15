@extends('layouts.app')

@section('content')
    <style>
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>

    <div class="container mt-4">
        <div class="d-flex align-items-center justify-content-center mb-4">
            <img src="{{ asset('images/a1.jpg') }}" alt="University Logo"
                style="width: 100px; height: auto; margin-right: 15px;" />
            <div class="text-center">
                <h1 class="mb-0">សាកលវិទ្យាល័យជាតិមានជ័យ</h1>
                <h5 class="mt-2">NMU-National Meanchey University</h5>
            </div>
        </div>
        
        <div class="text-center mb-4">
            <h1>Loan Book</h1>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Name:</strong> {{ $member->name }} | {{ $member->memberId }} </p>
                <p><strong>Year:</strong> {{ $member->study->name }} | <strong>Skill:</strong> {{ $member->category->name }}</p>
                <p><strong>Gender:</strong> {{ $member->gender == 'male' ? 'ប្រុស' : 'ស្រី' }}</p>
            </div>
            <div class="col-md-6 text-md-right">
                <p><strong>Total Loans:</strong> {{ $loanCount }}</p>
            </div>
        </div>

        @if ($loans->isEmpty())
            <p>No loans found for this member.</p>
        @else
            @php
                $hasRenewDate = $loans->contains(function($loan) {
                    return $loan->renew_date !== null;
                });
            @endphp

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Book Title</th>
                            <th>Loan Date</th>
                            <th>Due Date</th>
                            @if ($hasRenewDate)
                                <th>Renew Date</th>
                            @endif
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td>{{ $loan->invoice_number }}</td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->loan_date->format('m/d/Y') }}</td>
                                <td>{{ $loan->due_date->format('m/d/Y') }}</td>
                                @if ($hasRenewDate)
                                    <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                                @endif
                                <td>
                                    @if ($loan->status === 'available')
                                        <span class="badge bg-success">Available</span>
                                    @elseif ($loan->status === 'borrowed')
                                        <span class="badge bg-warning text-dark">Borrowed</span>
                                    @elseif ($loan->status === 'overdue')
                                        <span class="badge bg-secondary">Overdue</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        
        <div class="row mt-4">
            <div class="col-6">
                <p>Member Loan Date</p>
            </div>
            <div class="col-6 text-end">
                <p>Librarian</p>
            </div>
        </div>

        <button onclick="window.print();" class="btn btn-secondary mt-3 print-button mb-3"><i class="fas fa-print"></i></button>
    </div>
@endsection
