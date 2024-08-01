{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Loan Book History Details</h1>
        <div class="card">
            <div class="card-header">
                Invoice Number: {{ $loanHistory->invoice_number }}
            </div>
            <div class="card-body">
                <h5 class="card-title">ចំណងជើង: {{ $loanHistory->book->title }}</h5>
                <p class="card-text">ឈ្មោះ: {{ $loanHistory->member->name }}</p>
                <p class="card-text">តម្លៃ: {{ $loanHistory->price }}</p>
                <p class="card-text">ថ្ងៃខ្ចី: {{ $loanHistory->loan_date }}</p>
                <p class="card-text">កំណត់សងថ្ងៃ: {{ $loanHistory->due_date ?? 'N/A'}}</p>
                <p class="card-text">ខ្ចីបន្តដល់ថ្ងៃ: {{ $loanHistory->renew_date ?? 'N/A'}}</p>
                <p class="card-text">សងនៅថ្ងៃ: {{ $loanHistory->pay_date}}</p>
                <p class="card-text">ផាក់ពិន័យ: {{ $loanHistory->fine }}</p>
                <p class="card-text">មូលហេតុ: {{ $loanHistory->fine_reason }}</p>
                <p class="card-text">មូលហេតុ: {{ $loanHistory->status }}</p>
                <a href="{{ route('loanBookHistories.index') }}" class="btn btn-primary">Back to Loan Book History</a>
                <a href="{{ route('loanBookHistories.print', $loanHistory->id) }}" class="btn btn-secondary">Print</a>
            </div>
        </div>
    </div>
@endsection --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Loan Details</h5>
        </div>

        <div class="modal-body">
            <div class="row">

                <div class="col-md-4 mb-3">
                    {{-- @if ($loanHistory->book->cover_image)
                        <img src="{{ asset($loanHistory->book->cover_image) }}" alt="Cover Image" class="img-fluid rounded-start"
                            style="width: 120px;">
                    @else
                        <img src="{{ asset('images/default-cover.jpg') }}" class="img-fluid rounded-start"
                            alt="Default Cover">
                    @endif --}}
                    @if ($loanHistory->book && $loanHistory->book->cover_image)
                        <img src="{{ asset($loanHistory->book->cover_image) }}" alt="Cover Image" class="img-fluid rounded-start"
                            style="width: 120px;">
                    @else
                        <img src="{{ asset('images/default-cover.jpg') }}" class="img-fluid rounded-start"
                            alt="Default Cover">
                    @endif
                </div>
                <!-- loanHistory and Member Details -->
                <div class="col-md-4 mb-3">
                    <p><strong>Name:</strong> {{ $loanHistory->member->name }} <strong>|</strong>
                        {{ $loanHistory->member->memberId }}</p>
                    <p><strong>Gender:</strong> {{ $loanHistory->member->gender == 'male' ? 'ប្រុស' : 'ស្រី' }}</p>
                    <p><strong>Phone:</strong> {{ $loanHistory->member->phone }}</p>
                    <p><strong>Study:</strong> {{ $loanHistory->member->study->name }}</p>
                    <p><strong>Category:</strong> {{ $loanHistory->member->category->name }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p><strong>#{{ $loanHistory->invoice_number }}</strong></p>
                    <p><strong>Loan Date:</strong> {{ $loanHistory->loan_date }}</p>
                    <p><strong>Due Date:</strong> {{ $loanHistory->due_date }}</p>
                    <p><strong>Due Pay:</strong> {{ $loanHistory->due_pay ?? 'N/A' }}</p>
                    <p><strong>Status:</strong>
                        @if ($loanHistory->status === 'returned')
                            <span class="badge badge-success">Returned</span>
                        @elseif ($loanHistory->status === 'borrowed')
                            <span class="badge badge-warning">Not Returned</span>
                        @elseif ($loanHistory->status === 'reserved')
                            <span class="badge badge-secondary">Reserved</span>
                        @else
                            <span class="badge badge-dark">Unknown</span>
                        @endif
                    </p>
                </div>
            </div>
            <hr>
            <!-- Book Details Table -->
            <div class="row">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            {{-- <td>{{ $loanHistory->book->isbn }}</td>
                            <td>{{ $loanHistory->book->title }}</td>
                            <td>{{ $loanHistory->book->author->name }}</td>
                            <td>{{ $loanHistory->price ?? 'N/A' }} ៛</td> --}}
                            <td>{{ $loanHistory->book ? $loanHistory->book->isbn : 'N/A' }}</td>
                            <td>{{ $loanHistory->book ? $loanHistory->book->title : 'N/A' }}</td>
                            <td>{{ $loanHistory->book && $loanHistory->book->author->name ? $loanHistory->book->author->name : 'N/A' }}
                            </td>
                            <td>{{ $loanHistory->price ?? 'N/A' }} ៛</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p><strong>Fine:</strong> {{ $loanHistory->fine ?? 'N/A' }} <strong>Fine Reason:</strong>
                {{ $loanHistory->fine_reason ?? 'N/A' }}</p>
        </div>

        <div class="modal-footer">
            <a href="{{ route('loanBookHistories.index') }}" class="btn btn-outline-success btn-sm">ត្រឡប់ក្រោយ</a>
            <button onclick="printLoanDetails()" class="btn btn-secondary btn-sm"><i class="fa-solid fa-print"></i></button>
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
