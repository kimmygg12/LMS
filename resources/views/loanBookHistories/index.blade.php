@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <div class="card mt-3 mb-3">
            <div class="card-header ">
                <h2 class="card-title mt-3 mb-3">សៀវភៅដែលបានសង</h2>
            </div>
            <div class="card-body">
                <table id="datatablesSimpleQ" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">លេខ​វិ​ក័​យ​ប័ត្រ</th>
                            <th class="text-center">កូដ</th>
                            <th class="text-center">ចំណងជើង</th>
                            <th class="text-center">ឈ្មោះ</th>
                            <th class="text-center">ប្រាក់កក់</th>
                            <th class="text-center">ថ្ងៃខ្ចី</th>
                            <th class="text-center">ថ្ងៃកំណត់</th>
                            <th class="text-center">ខ្ចីបន្ត</th>
                            <th class="text-center">ថ្ងៃសង</th>
                            <th class="text-center">ផាកពិន័យ</th>
                            <th class="text-center">មូលហេតុ</th>
                            <th class="text-center">ប៊ូតុង</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loanHistory as $history)
                            <tr>
                                <td class="text-center">{{ $history->invoice_number }}</td>
                                <td class="text-center">{{ $history->book ? $history->book->isbn : 'Deleted'}}</td>
                                <td class="text-center">{{ $history->book ? $history->book->title : 'Deleted' }}</td>
                                <td class="text-center">{{ $history->member->name }}</td>
                                <td class="text-center">{{ $history->price }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($history->loan_date)->format('Y-d-m') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($history->due_date)->format('Y-d-m') }}</td>
                                <td class="text-center">{{ $history->renew_date ? \Carbon\Carbon::parse($history->renew_date)->format('Y-d-m') : 'N/A' }}</td>
                                <td class="text-center">{{ $history->pay_date ? \Carbon\Carbon::parse($history->pay_date)->format('Y-d-m') : 'N/A' }}</td>
                                <td class="text-center">{{ $history->fine }}</td>
                                <td class="text-center">{{ $history->fine_reason }}</td>
                                <td class="text-center">
                                    <a href="{{ route('loanBookHistories.show', $history->id) }}" class="btn btn-warning btn-sm">ព័ត៌មាន</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const datatablesSimpleA = document.getElementById('datatablesSimpleQ');

            if (datatablesSimpleA) {
                $(datatablesSimpleA).DataTable({
                    dom: 'Bfrtip',
                    pageLength: 3,
                    responsive: true,
                    buttons: [
                        {
                        extend: 'excelHtml5',
                            text: '<i class="fas fa-file-excel"></i> Export Excel',
                            className: 'btn btn-secondary btn-custom',
                            
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i> Print',
                            titleAttr: 'Print',
                            className: 'btn btn-secondary btn-custom'
                        }
                    ],
                    language: {
                        search: '',
                        searchPlaceholder: 'ស្វែងរក...',
                        paginate: {
                            previous: '<i class="fas fa-chevron-left"></i> Previous',
                            next: 'Next <i class="fas fa-chevron-right"></i>'
                        }
                    }
                });
            }
        });
    </script>
    <style>
        .btn-custom {
            padding: 5px 10px;
            font-size: 12px;

        }
    </style>
@endpush
