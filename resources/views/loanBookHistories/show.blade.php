@extends('layouts.app')

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
                <p class="card-text">ផាក់ពិន័យ: {{ $loanHistory->fine }}</p>
                <p class="card-text">មូលហេតុ: {{ $loanHistory->fine_reason }}</p>
                <a href="{{ route('loanBookHistories.index') }}" class="btn btn-primary">Back to Loan Book History</a>
                <a href="{{ route('loanBookHistories.print', $loanHistory->id) }}" class="btn btn-secondary">Print</a>
            </div>
        </div>
    </div>
@endsection
