@extends('layouts.admin')

@section('title', 'Approved Books')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Approved Books</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Book Title</th>
                        <th>Member Name</th>
                        <th>Approval Date</th>
                        <th>Invoice Number</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($approvedBooks as $approvedBook)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $approvedBook->book->title }}</td>
                            <td>{{ $approvedBook->member->name }}</td>
                            <td>{{ $approvedBook->approval_date }}</td>
                            <td>{{ $approvedBook->invoice_number }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
