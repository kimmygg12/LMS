{{-- 

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Approve Loan</h1>

        <div class="card">
            <div class="card-header">
                Loan Details
            </div>
            <div class="card-body">
                <p><strong>Book:</strong> {{ $loan->book->title }}</p>
                <p><strong>Isbn:</strong> {{ $loan->book->isbn }}</p>
                <p><strong>Member:</strong> {{ $loan->member->name }}</p>
                <p><strong>Reserved on:</strong> {{ $loan->created_at->format('Y-m-d') }}</p>
                <!-- Form to Approve the Loan -->
                <form action="{{ route('loans.approve', $loan->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <!-- Price Input -->
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" id="price" class="form-control" value="{{ old('price') }}">
                        @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Approve Button -->
                    <button type="submit" class="btn btn-primary">Approve</button>
                </form>
                <!-- Reject Button -->
                <form action="{{ route('loans.reject', $loan->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            </div>
        </div>
    </div>
@endsection --}}
@extends('layouts.app')

@section('content')
    <div class="container mt-3 mb-3">
        <h1>{{ __('messages.approve_borrower') }}</h1>
        <div class="card">
            <div class="card-body">
                <!-- Cover Image and Loan Details -->
                <div class="row mb-3">
                    <div class="col-md-4 d-flex align-items-center">
                        @if ($loan->book->cover_image)
                            <img src="{{ asset($loan->book->cover_image) }}" style="width: 200px;" alt="Cover Image" class="img-fluid">
                        @else
                            <img src="{{ asset('images/default-cover.jpg') }}" style="width: 120px;" alt="Default Cover" class="img-fluid">
                        @endif
                    </div>
                    
                    <!-- Loan and Member Details -->
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p><strong>{{ __('messages.name') }}:</strong> {{ $loan->member->name }} <strong>|</strong> {{ $loan->member->id }}</p>
                                <p><strong>{{ __('messages.gender') }}:</strong> {{ $loan->member->gender }}</p>
                                <p><strong>{{ __('messages.phone') }}:</strong> {{ $loan->member->phone }}</p>
                                <p><strong>{{ __('messages.year') }}:</strong> {{ $loan->member->study->name }}</p>
                                <p><strong>{{ __('messages.category') }}:</strong> {{ $loan->member->category->name }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>#{{ $loan->invoice_number }}</strong></p>
                                <p><strong>{{ __('messages.status') }}:</strong>
                                    @if ($loan->status === 'available')
                                        <span class="badge bg-success">{{ __('messages.status_available') }}</span>
                                    @elseif ($loan->status === 'borrowed')
                                        <span class="badge bg-warning text-dark">{{ __('messages.status_borrowed') }}</span>
                                    @elseif ($loan->status === 'overdue')
                                        <span class="badge bg-secondary">{{ __('messages.status_overdue') }}</span>
                                    @elseif ($loan->status === 'reserved')
                                        <span class="badge bg-info text-dark">{{ __('messages.status_reserved') }}</span>
                                    @elseif ($loan->status === 'rejected')
                                        <span class="badge bg-danger">{{ __('messages.status_rejected') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book Details Table -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('loans.approve', $loan->id) }}" method="POST" class="w-100">
                            @csrf
                            @method('POST')
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>{{ __('messages.isbn') }}</th>
                                            <th>{{ __('messages.book_title') }}</th>
                                            <th>{{ __('messages.author') }}</th>
                                            <th>{{ __('messages.subject') }}</th>
                                            <th>{{ __('messages.price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $loan->book->isbn }}</td>
                                            <td>{{ $loan->book->title }}</td>
                                            <td>{{ $loan->book->author->name }}</td>
                                            <td>{{ $loan->book->subject->name }}</td>
                                            <td>
                                                <input type="text" name="price" id="price" class="form-control">
                                                @error('price')
                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">{{ __('messages.approve') }}</button>
                            </div>
                        </form>
                        
                        <!-- Reject Button -->
                        <form action="{{ route('loans.reject', $loan->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger">{{ __('messages.reject') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
