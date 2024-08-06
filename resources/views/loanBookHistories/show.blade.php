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
                    <p><strong>ឈ្មោះ:</strong> {{ $loanHistory->member->name }} <strong>|</strong>
                        {{ $loanHistory->member->memberId }}</p>
                    <p><strong>ភេទ:</strong> {{ $loanHistory->member->gender == 'male' ? 'ប្រុស' : 'ស្រី' }}</p>
                    <p><strong>ទូរស័ព្ទ:</strong> {{ $loanHistory->member->phone }}</p>
                    <p><strong>ឆ្នាំ:</strong> {{ $loanHistory->member->study->name }}</p>
                    <p><strong>ជំនាញ:</strong> {{ $loanHistory->member->category->name }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p><strong>#{{ $loanHistory->invoice_number }}</strong></p>
                    <p><strong>ថ្ងៃខ្ចី:</strong> {{ \Carbon\Carbon::parse($loanHistory->loan_date)->format('Y-m-d') }}</p>
                    <p><strong>ថ្ងៃកំណត់សង:</strong> {{ \Carbon\Carbon::parse($loanHistory->due_date)->format('Y-m-d') }}</p>
                    <p><strong>បានខ្ចីបន្ត:</strong> {{ $loanHistory->renew_date ? \Carbon\Carbon::parse($loanHistory->renew_date)->format('Y-m-d') : 'N/A' }}</p>
                    <p><strong>ថ្ងៃសង:</strong> {{ $loanHistory->pay_date ? \Carbon\Carbon::parse($loanHistory->pay_date)->format('Y-m-d') : 'N/A' }}</p>                    
                    {{-- <p><strong>ស្ថានភាព:</strong> --}}
                       
                    </p>
                </div>
            </div>
            <hr>
            <!-- Book Details Table -->
            <div class="row">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">កូដ</th>
                            <th scope="col">ចំណងជើង</th>
                            <th scope="col">អ្នកនិពន្ធ</th>
                            <th scope="col">ប្រភេទ</th>
                            <th scope="col">ប្រាក់កក់</th>
                            <th scope="col">ស្ថានភាព</th>
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
                            <td>{{ $loanHistory->book && $loanHistory->book->subject->name ? $loanHistory->book->subject->name : 'N/A' }}</td>
                            </td>
                            <td>{{ $loanHistory->price ?? 'N/A' }} ៛</td>
                            <td>
                                @if ($loanHistory->status === 'returned')
                                <span class="badge badge-success">បានសង</span>
                            @elseif ($loanHistory->status === 'borrowed')
                                <span class="badge badge-warning">Not Returned</span>
                            @elseif ($loanHistory->status === 'reserved')
                                <span class="badge badge-secondary">Reserved</span>
                            @else
                                <span class="badge badge-dark">Unknown</span>
                            @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p><strong>ផាកពិន័យ:</strong> {{ $loanHistory->fine ?? 'N/A' }} <strong>មូលហេតុ:</strong>
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
