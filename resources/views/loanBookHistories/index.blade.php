@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">Loan Records</h1>
    <table id="datatablesSimpleQ" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>លេខ​វិ​ក័​យ​ប័ត្រ</th>
                <th>Book ID</th>
                <th>Member ID</th>
                <th>Price</th>
                <th>Loan Date</th>
                <th>Due Date</th>
                <th>Renew Date</th>
                <th>Pay Date</th>
                <th>Fine</th>
                <th>Fine Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loanHistory as $history)
            <tr data-href="{{ route('loanBookHistories.show', $history->id) }}">
                <td>{{ $history->invoice_number }}</td>
                <td>{{ $history->book->title }}</td>
                <td>{{ $history->member->name }}</td>
                <td>{{ $history->price }}</td>
                <td>{{ $history->loan_date }}</td>
                <td>{{ $history->due_date }}</td>
                <td>{{ $history->renew_date ?? 'N/A'}}</td>
                <td>{{ $history->pay_date }}</td>
                <td>{{ $history->fine }}</td>
                <td>{{ $history->fine_reason }}</td>
                <td>
                    <a href="{{ route('loanBookHistories.show', $history->id) }}" class="btn btn-warning btn-sm">Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datatablesSimpleQ').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endpush
