

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Fine Book</h1>
    <form action="{{ route('loans.finebook', $loan->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $loan->due_date) }}" required>
        </div>

        <div class="form-group">
            <label for="renew_date">Renew Date</label>
            <input type="date" name="renew_date" class="form-control" value="{{ old('renew_date', $loan->renew_date) }}" required>
        </div>

        <div class="form-group">
            <label for="fine">Fine (optional)</label>
            <input type="number" step="0.01" name="fine" class="form-control" value="{{ old('fine', $loan->fine) }}">
        </div>

        <div class="form-group">
            <label for="fine_reason">Fine Reason (optional)</label>
            <textarea name="fine_reason" class="form-control">{{ old('fine_reason', $loan->fine_reason) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
