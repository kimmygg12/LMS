@extends('layouts.app')

@section('content')
    <div class="row mt-5 mb-3">
        <div class="col-12 col-md-6">
            <h2>គ្រប់គ្រប់ការខ្ចីសៀវភៅ</h2>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            {{ $message }}
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-header">
            <i class="fa-solid fa-money-bill"></i> សងសៀវភៅដែលត្រូវសង
        </div>

        <div class="card-body">
            <div class=" mb-3">
                <form method="GET" action="{{ route('loans.indexloan') }}" class="d-flex">
                    <input type="text" class="form-control me-2" name="search" placeholder="ស្វែងរក"
                        value="{{ request()->get('search') }}">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>វិក្កយបត្រ</th>
                            <th>Book</th>
                            <th>Member</th>
                            <th>ខ្ចីនៅថ្ងៃ</th>
                            <th>កាលបរិច្ឆេទ កំណត់</th>
                            <th>បន្តខ្ចី</th>
                            <th>តម្លៃ</th>
                            <th>ស្ថានភាព</th>
                            <th>ប៊ូតុង</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loans as $loan)
                            @php
                                $dueDate = \Carbon\Carbon::parse($loan->due_date);
                                $renewDate = $loan->renew_date ? \Carbon\Carbon::parse($loan->renew_date) : null;
                                $now = \Carbon\Carbon::now();

                                $showLoan = false;

                                if (
                                    ($dueDate->isToday() || $dueDate->isToday()) &&
                                    ($renewDate && ($renewDate->isToday() || $renewDate->isTomorrow()))
                                ) {
                                    $showLoan = false;
                                }
                                if ($dueDate && ($dueDate->isToday() || $dueDate->isTomorrow())) {
                                    $showLoan = false;
                                }
                                if ($dueDate->isPast() && (!$renewDate || $renewDate->isPast())) {
                                    $showLoan = true;
                                }
                                // if ($dueDate->isToday() || $dueDate->isTomorrow()) {
                                //     $showLoan = false;
                                // }

                                // if ($renewDate && ($renewDate->isToday() || $renewDate->isTomorrow())) {
                                //     $showLoan = false;
                                // }
                            @endphp

                            @if ($showLoan)
                                <tr>
                                    <td>{{ $loan->invoice_number }}</td>
                                    <td>{{ $loan->book->title }}</td>
                                    <td>{{ $loan->member->name }}</td>
                                    <td>{{ $loan->loan_date->format('d-m-Y') }}</td>
                                    <td>{{ $loan->due_date->format('d-m-Y') }}</td>
                                    <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $loan->price }}</td>
                                    <td>
                                        @if ($loan->status === 'available')
                                            <span class="badge bg-success">Available</span>
                                        @elseif ($loan->status === 'borrowed')
                                            <span class="badge bg-warning text-dark">មិនទាន់សង</span>
                                        @elseif ($loan->status === 'reserved')
                                            <span class="badge bg-secondary">Reserved</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('loans.finebook', $loan->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-money-bill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No books found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination-wrapper">
                    {{ $loans->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
