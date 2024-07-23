@extends('layouts.app')

@section('content')
    {{-- <div class="container">
        <h1>Loans</h1>
        <a href="{{ route('loans.create') }}" class="btn btn-primary">Create Loan</a>
        @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first('invoice_number') }}
        </div>
    @endif
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Book Copy ID</th>
                    <th>Borrowed At</th>
                    <th>Returned At</th>
                    <th>Invoice Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                    <tr>
                        <td>{{ $loan->book_copy_id }}</td>
                        <td>{{ $loan->borrowed_at }}</td>
                        <td>{{ $loan->returned_at }}</td>
                        <td>{{ $loan->invoice_number }}</td>
                        <td>
                            @if (!$loan->returned_at)
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#returnModal"
                                    data-loan-id="{{ $loan->id }}">Return Book</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
    <div class="container">
        <h1>Loans</h1>
        <a href="{{ route('loans.create') }}" class="btn btn-primary">Create Loan</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Member</th>
                    <th>Book</th>
                    <th>Book Copy</th>
                    <th>Borrowed At</th>
                    <th>Returned At</th>
                    <th>Invoice Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                <tr>
                    <td>{{ $loan->id }}</td>
                    <td>{{ $loan->member->name }}</td>
                    <td>{{ optional($loan->book)->title }}</td>
                    <td>{{ optional($loan->bookCopy)->copy_number }}</td>
                    <td>{{ $loan->borrowed_at }}</td>
                    <td>{{ $loan->returned_at }}</td>
                    <td>{{ $loan->invoice_number }}</td>
                    <td>
                        @if (!$loan->returned_at)
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#returnModal"
                            data-loan-id="{{ $loan->id }}">Return Book</button>
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Return Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="" id="returnForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnModalLabel">Return Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="invoice_number" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_number" name="invoice_number" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Return Book</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        var returnModal = document.getElementById('returnModal');
        returnModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var loanId = button.getAttribute('data-loan-id');
            var form = document.getElementById('returnForm');
            form.action = '/loans/' + loanId + '/return';
        });
    </script>
@endsection
