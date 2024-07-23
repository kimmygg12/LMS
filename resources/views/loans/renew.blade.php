@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Renew Loan</h1>
    <form action="{{ route('loans.renew', $loan->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="renew_date">Renew Date</label>
            <input type="date" name="renew_date" id="renew_date" class="form-control">
        </div>
        <div class="form-group">
            <label for="fine">Fine (if any)</label>
            <input type="number" name="fine" id="fine" class="form-control">
        </div>
        <div class="form-group">
            <label for="reason">Reason</label>
            <input type="text" name="reason" id="reason" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Renew Loan</button>
    </form>
</div>
@endsection
