@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fa-solid fa-money-bill"></i>
            មួយថ្ងៃដែលត្រូវសងសៀវភៅ
        </div>

        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>លេខសម្គាល់</th>
                        <th>Book</th>
                        <th>Member</th>
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
                            if ($dueDate->isPast() && (!$renewDate || $renewDate->isPast())) {
                                $showLoan = true;
                            }
                            if (
                                ($dueDate->isToday() || $dueDate->isToday()) &&
                                ($renewDate && ($renewDate->isToday() || $renewDate->isToday()))
                            ) {
                                $showLoan = false;
                            }
                            if ($dueDate && ($dueDate->isToday() || $dueDate->isTomorrow())) {
                                $showLoan = false;
                            }
                        @endphp

                        @if ($showLoan)
                            <tr>
                                <td>{{ $loan->invoice_number }}</td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->member->name }}</td>
                                <td>{{ $loan->loan_date->format('d-m-Y') }}</td>
                                <td>{{ $loan->due_date->format('d-m-Y') }}</td>
                                <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                                {{-- <td>{{ $loan->renew_date->format('d-m-Y') ?? 'N/A' }}</td> --}}
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
