{{-- @extends('layouts.app')

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
            <img src="{{ asset('images/a1.jpg') }}" alt="University Logo" style="width: 100px; height: auto; margin-right: 15px;" />
            <div class="text-center">
                <h1 class="mb-0">សាកលវិទ្យាល័យជាតិមានជ័យ</h1>
                <h5 class="mt-2">NMU-National Meanchey University</h5>
            </div>
        </div>
        
        <div class="text-center mb-4">
            <h1>វិក័យប័ត្រខ្ចីសៀវភៅ</h1>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>ឈ្មោះ:</strong> {{ $loan->member->name }} | {{ $loan->member->memberId }}</p>
                <p><strong>ឆ្នាំ:</strong> {{ $loan->member->study->name ?? 'N/A' }} |  {{ $loan->member->category->name ?? 'N/A' }}</p>
                <p><strong>ភេទ:</strong> {{ $loan->member->gender == 'male' ? 'ប្រុស' : 'ស្រី' }}</p>
            </div>
            <div class="col-md-6 text-md-right">
                <p><strong>#</strong> {{ $loan->invoice_number }}</p>
            </div>
        </div>

        @if (!$loan)
            <p>No loan details found for this invoice.</p>
        @else
            @php
                $hasRenewDate = !is_null($loan->renew_date);
            @endphp

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ចំណងជើង</th>
                            <th>លេខសម្គាល់</th>
                            <th>ថ្ងៃខ្ចី</th>
                            <th>ថ្ងៃកំណត់</th>
                            @if ($hasRenewDate)
                                <th>ខ្ចីបន្ត</th>
                            @endif
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->book->isbn }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('m/d/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->due_date)->format('m/d/Y') }}</td>
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
                    </tbody>
                </table>
            </div>
        @endif
        
        <div class="row mt-4">
            <div class="col-6">
                <p>អ្នកខ្ចីសៀវភៅ</p>
            </div>
            <div class="col-6 text-end">
                <p>បណ្ណារក្ស</p>
            </div>
        </div>

        <button onclick="window.print();" class="btn btn-secondary mt-3 print-button mb-3"><i class="fas fa-print"></i></button>
    </div>
@endsection --}}

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
        <div class="text-center mb-4">
            <div class="d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/a1.jpg') }}" alt="University Logo"
                    style="width: 100px; height: auto; margin-right: 15px;" />
                <div>
                    <h1 class="mb-0">សាកលវិទ្យាល័យជាតិមានជ័យ</h1>
                    <h5 class="mt-2">NMU-National Meanchey University</h5>
                </div>
            </div>
        </div>

        <div class="text-center mb-4">
            <h1>វិក័យប័ត្រខ្ចីសៀវភៅ</h1>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>ឈ្មោះ:</strong> {{ $loan->member->name }} | {{ $loan->member->memberId }}</p>
                <p><strong>ឆ្នាំ:</strong> {{ $loan->member->study->name ?? 'N/A' }} |
                    {{ $loan->member->category->name ?? 'N/A' }}</p>
                <p><strong>ភេទ:</strong> {{ $loan->member->gender == 'male' ? 'ប្រុស' : 'ស្រី' }}</p>
            </div>
            <div class="col-md-6 text-end no-print">
                <form method="GET" action="{{ route('loans.showInvoice', ['id' => $loan->id ?? null]) }}" class="mb-4">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-end">
                        <div class="mb-2 mb-md-0 me-md-2">
                            <input type="date" name="date" class="form-control" value="{{ old('date', $searchDate) }}"
                                placeholder="Select Date">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                            <button type="reset" class="btn btn-secondary"
                                onclick="window.location.href='{{ route('loans.showInvoice', ['id' => $loan->id ?? null]) }}'"><i
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
                        @if (($memberLoans->isNotEmpty() && $memberLoans->contains(fn($item) => $item->renew_date)) || $loan->renew_date)
                            <th>ខ្ចីបន្ត</th>
                        @endif
                        <th>Status</th>
                        <th class="action-column">Action</th> <!-- Add Action Column -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Current Loan Details -->
                    @if ($loan)
                        <tr>
                            <td>{{ $loan->invoice_number }}</td>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->book->isbn }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('m/d/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->due_date)->format('m/d/Y') }}</td>
                            @if (($memberLoans->isNotEmpty() && $memberLoans->contains(fn($item) => $item->renew_date)) || $loan->renew_date)
                                <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                            @endif
                            <td>
                                @if ($loan->status === 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif ($loan->status === 'borrowed')
                                    <span class="badge bg-warning text-dark">បានខ្ចី</span>
                                @endif
                            </td>
                            <td class="action-column"><button class="remove-btn" onclick="removeRow(this)">×</button></td>
                            <!-- Remove Button -->
                        </tr>
                    @else
                        <tr>
                            <td
                                colspan="{{ ($memberLoans->isNotEmpty() && $memberLoans->contains(fn($item) => $item->renew_date)) || $loan->renew_date ? 8 : 7 }}">
                                No loan details found for this invoice.</td>
                        </tr>
                    @endif

                    <!-- Other Loans by Member -->
                    @if ($searchDate)
                        @forelse ($memberLoans as $memberLoan)
                            <tr>
                                <td>{{ $memberLoan->invoice_number }}</td>
                                <td>{{ $memberLoan->book->title }}</td>
                                <td>{{ $memberLoan->book->isbn }}</td>
                                <td>{{ \Carbon\Carbon::parse($memberLoan->loan_date)->format('m/d/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($memberLoan->due_date)->format('m/d/Y') }}</td>
                                @if (($memberLoans->isNotEmpty() && $memberLoans->contains(fn($item) => $item->renew_date)) || $loan->renew_date)
                                    <td>{{ $memberLoan->renew_date ? $memberLoan->renew_date->format('Y-m-d') : 'N/A' }}
                                    </td>
                                @endif
                                <td>
                                    @if ($memberLoan->status === 'available')
                                        <span class="badge bg-success">Available</span>
                                    @elseif ($memberLoan->status === 'borrowed')
                                        <span class="badge bg-warning text-dark">បានខ្ចី</span>
                                    @endif
                                </td>
                                <td class="action-column"><button class="remove-btn" onclick="removeRow(this)">×</button>
                                </td> <!-- Remove Button -->
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="{{ ($memberLoans->isNotEmpty() && $memberLoans->contains(fn($item) => $item->renew_date)) || $loan->renew_date ? 8 : 7 }}">
                                    No other loans found for this member.</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>


        <div class="row mt-4">
            <div class="col-6">
                <p>អ្នកខ្ចីសៀវភៅ</p>
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
