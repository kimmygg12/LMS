@extends('layouts.app')

@section('content')
    <h1>Loan Details</h1>
    <p>Invoice Number: {{ $loan->invoice_number }}</p>
    <p>Borrowed At: {{ $loan->borrowed_at }}</p>
    <p>Returned At: {{ $loan->returned_at }}</p>
    <td>{{ $loan->member_id }}</td>
    <td>{{ $loan->book_copy_id }}</td>
    <!-- Display more details as needed -->
@endsection
