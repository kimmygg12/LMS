@extends('layouts.app')
@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h2>{{ __('messages.return_book') }}</h2>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card-body ">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('loans.finebook', $loan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title">{{ __('messages.title') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-book"></i>
                            </span>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title', $loan->book->title) }}" readonly>

                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="member_id">{{ __('messages.member_id') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" style="width: 40px;">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="text" name="member_id" id="member_id" class="form-control"
                                value="{{ old('member_id', $loan->member->memberId) }} - {{ old('member_id', $loan->member->name) }}"
                                readonly>

                            @error('member_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="loan_date">{{ __('messages.loan_date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                            <input type="date" name="loan_date" id="loan_date" class="form-control"
                                value="{{ old('loan_date', optional($loan->loan_date)->format('Y-m-d')) }}" readonly>
                        
                            @error('loan_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="due_date">{{ __('messages.due_date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                            <input type="date" name="due_date" id="due_date" class="form-control"
                                value="{{ old('due_date', $loan->due_date ? $loan->due_date->format('Y-m-d') : '') }}" readonly>
                    
                            @error('due_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="renew_date">{{ __('messages.renew_date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input type="date" name="renew_date" id="renew_date" class="form-control"
                            value="{{ old('renew_date', $loan->renew_date ? $loan->renew_date->format('Y-m-d') : '') }}">

                        @error('renew_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="pay_date">{{ __('messages.pay_date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input type="date" name="pay_date" id="pay_date" class="form-control"
                            value="{{ old('pay_date') }}">

                        @error('pay_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="price">{{ __('messages.price') }}</label>
                        <div class="input-group">
                            <span class="input-group-text d-flex align-items-center justify-content-center" style="width: 40px;">
                                <i class="fa-sharp fa-solid fa-dollar-sign"></i>
                            </span>
                        <input type="number" name="price" id="price" class="form-control"
                            value="{{ old('price', $loan->price) }}" readonly>

                        @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fine">{{ __('messages.fineBook') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-sharp-duotone fa-solid fa-money-bill"></i></span>
                        <input type="number" name="fine" id="fine" class="form-control"
                            value="{{ old('fine') }}">

                        @error('fine')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="fine_reason">{{ __('messages.fine_reason') }}</label>
                        <textarea name="fine_reason" id="fine_reason" class="form-control">{{ old('fine_reason') }}</textarea>

                        @error('fine_reason')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-sm">{{ __('messages.save') }}</button>
                <a href="{{ route('loans.index') }}" class="btn btn btn-outline-success btn-sm">{{ __('messages.back') }}</a>
            </form>
        </div>
    </div>
@endsection
