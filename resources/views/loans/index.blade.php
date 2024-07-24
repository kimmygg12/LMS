@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- <a href="{{ route('loans.history') }}" class="btn btn-secondary">View Loan History</a> --}}
        <a href="{{ route('loanBookHistories.index') }}" class="btn btn-secondary">View Loan History</a>
            <a href="{{ route('loans.create') }}" class="btn btn-primary">Add Book</a>
            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-2">
                    {{ $message }}
                </div>
            @endif
        <h1>Loan Records</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>លេខសម្គាល់</th>
                    <th>Book</th>
                    <th>Member</th>
                    <th>ខ្ចីនៅថ្ញៃ</th>
                    <th>កាលបរិច្ឆេទ កំណត់</th>
                    <th>បន្តខ្ចី</th>
                    <th>តម្លៃ</th>
                    <th>ផាកពិន័យ</th>
                    <th>មូលហេតុ</th>
                    <th>ស្ថានភាទ</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                    <tr>
                        <td>{{ $loan->invoice_number }}</td>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->member->name }}</td>
                        <td>{{ $loan->loan_date }}</td>
                        <td>{{ $loan->due_date }}</td>
                        <td>{{ $loan->renew_date }}</td>
                        <td>{{ $loan->price }}</td>
                        <td>{{ $loan->fine ?? 0 }}</td>
                        <td>{{ $loan->fine_reason ?? 'N/A' }}</td>

                        <td>
                            @if ($loan->status === 'available')
                                <span class="badge badge-success">Available</span>
                            @elseif ($loan->status === 'borrowed')
                                <span class="badge badge-warning">មិនទាន់សង</span>
                            @elseif ($loan->status === 'reserved')
                                <span class="badge badge-secondary">Reserved</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('loans.show', $loan->id) }}" class="btn btn-info btn-sm">renew</a>
                            <a href="{{ route('loans.showFinebookForm', $loan->id) }}" class="btn btn-warning">Fine Book</a>
                            @if ($loan->status === 'borrowed')
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#returnBookModal"
                                    data-invoice="{{ $loan->invoice_number }}">
                                    Return Book
                                </button>
                            @endif
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Return Book Modal -->
    <div class="modal fade" id="returnBookModal" tabindex="-1" role="dialog" aria-labelledby="returnBookModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnBookModalLabel">Return Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('loans.return') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="invoice_number">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_number" name="invoice_number" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Return Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#returnBookModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var invoiceNumber = button.data('invoice');
            var modal = $(this);
            modal.find('#invoice_number').val(invoiceNumber);
        });
    </script>
@endsection
