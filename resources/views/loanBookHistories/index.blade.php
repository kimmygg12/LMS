@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Loan Book History</h1>
        <table class="table">
            <thead>
                <tr>
               
                    <th>លេខ​វិ​ក័​យ​ប័ត្រ</th>
                    <th>Book ID</th>
                    <th>Member ID</th>
                    <th>Price</th>
                    <th>Loan Date</th>
                    <th>Due Date</th>
                    <th>Renew Date</th>
                    <th>Fine</th>
                    <th>Fine Reason</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loanHistory as $history)
                    <tr>
                      
                        <td>{{ $history->invoice_number }}</td>
                        <td>{{ $history->book->title }}</td>
                        <td>{{ $history->member->name }}</td>
                        <td>{{ $history->price }}</td>
                        <td>{{ $history->loan_date }}</td>
                        <td>{{ $history->due_date }}</td>
                        <td>{{ $history->renew_date }}</td>
                        <td>{{ $history->fine }}</td>
                        <td>{{ $history->fine_reason }}</td>
                        <td>
                            <a href="{{ route('loanBookHistories.show', $history->id) }}" class="btn btn-warning btn-sm">details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
