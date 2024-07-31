@extends('layouts.app')
@section('content')
    <h2 class="mt-4">ផ្ទាំងគ្រប់គ្រង</h2>
    <ol class="breadcrumb mb-4">
        {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
    </ol>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">សៀវភៅ</h6>
                        <h2 class="text-right"><i class="fa fa-book f-left"></i><span>{{ $bookCount }}</span></h2>
                        <a href="{{ route('books.index') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">ចំនួនសិស្ស</h6>
                        <h2 class="text-right"><i class="fa-solid fa-user f-left"></i><span>{{ $memberCount }}</span></h2>
                        <a href="{{ route('members.index') }}" class="stretched-link"></a>

                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-yellow order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">អ្នកខ្ចីសៀវភៅ</h6>
                        <h2 class="text-right"> <i
                                class="fa-solid fa-book-open-reader f-left"></i><span>{{ $loanBookCount }}</span></h2>
                        <a href="{{ route('loans.index') }}" class="stretched-link"></a>

                    </div>
                </div>
            </div>



            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-pink order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">កំណត់សង</h6>
                        <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>{{$totalOverdueBooks}}</span></h2>
                        <a href="{{ route('loans.indexloan') }}" class="stretched-link"></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fa-solid fa-money-bill"></i>
            មួយថ្ងៃដែលត្រូវសងសៀវភៅ
        </div>

        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>វិក្កយបត្រ</th>
                        <th>ចំណងជើង</th>
                        <th>ឈ្មោះ</th>
                        <th>ខ្ចីនៅថ្ញៃ</th>
                        <th>កាលបរិច្ឆេទ កំណត់</th>
                        <th>បន្តខ្ចី</th>
                        <th>តម្លៃ</th>
                        <th>ស្ថានភាទ</th>
                    </tr>
                <tbody>
                    @foreach ($loans as $loan)
                        @php
                            $dueDate = \Carbon\Carbon::parse($loan->due_date);
                            $renewDate = $loan->renew_date ? \Carbon\Carbon::parse($loan->renew_date) : null;
                            $now = \Carbon\Carbon::now();
                            $showLoan = false;
                            // $hideLoan = false;

                            if ($dueDate && ($dueDate->isToday() || $dueDate->isTomorrow())) {
                                $showLoan = true;
                            }
                            if ($renewDate && ($renewDate->isToday() || !$renewDate->isTomorrow())) {
                                $showLoan = true;
                            }
                            if ($renewDate && (!$renewDate->isToday() || !$renewDate->isTomorrow())) {
                                $showLoan = false;
                            }
                            if ($renewDate && ($renewDate->isToday() || $renewDate->isTomorrow())) {
                                $showLoan = true;
                            }
                         
                        @endphp

                        @if ($showLoan)
                            <tr>
                                <td>{{ $loan->invoice_number }}</td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->member->name }}</td>
                                <td>{{ $loan->loan_date->format('d-m-Y') }}</td>
                                <td>{{ $loan->due_date->format('d-m-Y') }}</td>
                                <td>{{ $loan->renew_date ? $loan->renew_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $loan->price }}</td>

                                <td>
                                    @if ($loan->status === 'available')
                                        <span class="badge badge-success">Available</span>
                                    @elseif ($loan->status === 'borrowed')
                                        <span class="badge badge-warning">មិនទាន់សង</span>
                                    @elseif ($loan->status === 'reserved')
                                        <span class="badge badge-secondary">Reserved</span>
                                    @endif
                                </td>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
