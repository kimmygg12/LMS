@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Total Loan Report</h1>
    <p>Total number of loans: {{ $totalLoans }}</p>
</div>
@endsection
