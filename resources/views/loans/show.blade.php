@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Loan Details</h5>
        </div>

        <div class="modal-body">
            <div class="row">
                <!-- Cover Image -->
                <div class="col-md-4 mb-3">
                    @if ($loan->book->cover_image)
                        <img src="{{ asset($loan->book->cover_image) }}" alt="Cover Image" class="img-fluid rounded-start"
                            style="width: 120px;">
                    @else
                        <img src="{{ asset('images/default-cover.jpg') }}" class="img-fluid rounded-start"
                            alt="Default Cover">
                    @endif
                </div>
                <!-- Loan and Member Details -->
                <div class="col-md-4 mb-3">
                    <p><strong>Name:</strong> {{ $loan->member->name }} <strong>|</strong> {{ $loan->member->memberId }}</p>
                    <p><strong>Phone:</strong> {{ $loan->member->gender }}</p>
                    <p><strong>Phone:</strong> {{ $loan->member->phone }}</p>
                    <p><strong>Study:</strong> {{ $loan->member->study->name }}</p>
                    <p><strong>Category:</strong> {{ $loan->member->category->name }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p><strong>#{{ $loan->invoice_number }}</strong></p>
                    <p><strong>Loan Date:</strong> {{ $loan->loan_date->format('d M Y') }}</p>
                    <p><strong>Due Date:</strong> {{ $loan->due_date->format('d M Y') }}</p>
                    <p><strong>Due Date:</strong> {{ $loan->due_pay ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ $loan->status }}</p>
                </div>
            </div>
            <hr>
            <!-- Book Details Table -->
            <div class="row">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Title</th>
                            <th scope="col">Fine</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $loan->book->isbn }}</td>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->price ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p><strong>fine:</strong> {{ $loan->fine ?? 'N/A' }}</p>
        </div>

        <div class="modal-footer">
            <a href="{{ route('loans.index') }}" class="btn btn-primary">Back to Loan List</a>
        </div>
    </div>
@endsection
