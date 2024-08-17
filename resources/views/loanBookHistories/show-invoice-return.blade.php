@extends('layouts.app')

@section('content')
    <style>
        @media print {
            .print-button {
                display: none;
            }

            .action-column {
                display: none;
            }
        }

        .table-responsive {
            overflow-x: auto;
        }

        .remove-btn {
            cursor: pointer;
            color: red;
            border: none;
            background: none;
            font-size: 16px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>

    <div class="container mt-4">
        <!-- Header with Logo and University Name -->
        <div class="d-flex align-items-center justify-content-center mb-4">
            <img src="{{ asset('images/a1.jpg') }}" alt="University Logo"
                style="width: 100px; height: auto; margin-right: 15px;" />
            <div class="text-center">
                <h1 class="mb-0">ប្រព័ន្ធគ្រប់គ្រងបណ្ណាល័យ</h1>
                <h5 class="mt-2">Library Management System</h5>
            </div>
        </div>
        <div class="text-center mb-4">
            <h1>បង្កាន់ដៃសងសៀវភៅ</h1>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>ឈ្មោះ:</strong> {{ $loanHistory->member->name }} | {{ $loanHistory->member->memberId }}</p>
                <p><strong>ឆ្នាំ:</strong> {{ $loanHistory->member->study->name ?? 'N/A' }} |
                    {{ $loanHistory->member->category->name ?? 'N/A' }}</p>
                <p><strong>ភេទ:</strong> {{ $loanHistory->member->gender == 'male' ? 'ប្រុស' : 'ស្រី' }}</p>
            </div>
            <div class="col-md-6 text-end no-print">
                <form method="GET" action="{{ route('invoice.show', ['id' => $loanHistory->id ?? null]) }}"
                    class="mb-4">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-end">
                        <div class="mb-2 mb-md-0 me-md-2">
                            <input type="date" name="date" class="form-control" value="{{ old('date', $searchDate) }}"
                                placeholder="Select Date">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                            <button type="reset" class="btn btn-secondary"
                                onclick="window.location.href='{{ route('invoice.show', ['id' => $loanHistory->id ?? null]) }}'"><i
                                    class="fa-solid fa-rotate"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Combined Table for Loan Details and Other Loans -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ចំណងជើង</th>
                        <th>លេខសម្គាល់</th>
                        <th>ថ្ងៃខ្ចី</th>
                        <th>ថ្ងៃកំណត់</th>
                        @if ($loanHistory->renew_date)
                            <th>ខ្ចីបន្ត</th>
                        @endif
                        <th>ថ្ងៃសង</th>
                        <th>Status</th>
                        <th class="action-column">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($loanHistory)
                        <tr>
                            <td>{{ $loanHistory->invoice_number }}</td>
                            <td>{{ $loanHistory->book->title }}</td>
                            <td>{{ $loanHistory->book->isbn }}</td>
                            <td>{{ \Carbon\Carbon::parse($loanHistory->loan_date)->format('m/d/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($loanHistory->due_date)->format('m/d/Y') }}</td>
                            @if ($loanHistory->renew_date)
                                <td>{{ $loanHistory->renew_date->format('Y-m-d') }}</td>
                            @endif
                            <td>{{ \Carbon\Carbon::parse($loanHistory->pay_date)->format('m/d/Y') }}</td>
                            <td>
                                @if ($loanHistory->status === 'returned')
                                    <span class="badge bg-success">បានសង</span>
                                @endif
                            </td>
                            <td class="action-column"><button class="remove-btn" onclick="removeRow(this)">×</button></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="8">No return details found for this invoice.</td>
                        </tr>
                    @endif

                    @if ($searchDate)
                        @forelse ($memberLoans as $memberLoan)
                            <tr>
                                <td>{{ $memberLoan->invoice_number }}</td>
                                <td>{{ $memberLoan->book->title }}</td>
                                <td>{{ $memberLoan->book->isbn }}</td>
                                <td>{{ \Carbon\Carbon::parse($memberLoan->loan_date)->format('m/d/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($memberLoan->due_date)->format('m/d/Y') }}</td>
                                <td>{{ $memberLoan->renew_date ? $memberLoan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $memberLoan->pay_date ? \Carbon\Carbon::parse($memberLoan->pay_date)->format('m/d/Y') : 'N/A' }}
                                </td>
                                <td>
                                    @if ($memberLoan->status === 'returned')
                                        <span class="badge bg-success">បានសង</span>
                                    @endif
                                </td>
                                <td class="action-column"><button class="remove-btn" onclick="removeRow(this)">×</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No other loans found for this member.</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>

        <div class="row mt-4">
            <div class="col-6">
                <p>អ្នកសងសៀវភៅ</p>
            </div>
            <div class="col-6 text-end">
                <p>បណ្ណារក្ស</p>
            </div>
        </div>

        <button onclick="window.print();" class="btn btn-secondary mt-3 print-button mb-3"><i
                class="fas fa-print"></i></button>
    </div>

    <script>
        function removeRow(button) {
            var row = button.closest('tr');
            row.parentNode.removeChild(row);
        }
    </script>
@endsection
