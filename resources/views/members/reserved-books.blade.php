@extends('layouts.member')

@section('content')
    <div class="container">
        <h1>Reserved Books</h1>

        @if($reservedBooks->isEmpty())
            <p>You have no reserved books.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Reservation Date</th>
                        <th>Invoice Number</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservedBooks as $reservation)
                        <tr>
                            <td>{{ $reservation->book->title }}</td>
                            <td>{{ $reservation->book->author }}</td>
                            <td>{{ $reservation->reservation_date }}</td>
                            <td>{{ $reservation->invoice_number }}</td>
                            <td>{{ $reservation->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
