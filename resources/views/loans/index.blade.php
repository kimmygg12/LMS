@extends('layouts.app')

@section('content')
    <div class="row mt-4 mb-4">
        <div class="col">
            <h2>{{ __('messages.all_book_loans') }}</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('loans.create') }}" class="btn btn-success"> <i class="fa-solid fa-plus"></i>
                {{ __('messages.add') }}</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            {{ $message }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="col-md-8">
                <h5 class="card-title mb-0">{{ __('messages.book_list') }}</h5>
            </div>
            <div class="col-md-4 text-end">
                <form method="GET" action="{{ route('loans.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2"
                        placeholder="{{ __('messages.search_placeholder') }}" value="{{ request()->get('search') }}">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">{{ __('messages.invoice_number') }}</th>
                            <th class="text-center">{{ __('messages.title') }}</th>
                            <th class="text-center">{{ __('messages.member') }}</th>
                            <th class="text-center">{{ __('messages.loan_date') }}</th>
                            <th class="text-center">{{ __('messages.due_date') }}</th>
                            <th class="text-center">{{ __('messages.renew_date') }}</th>
                            <th class="text-center">{{ __('messages.price') }}</th>
                            <th class="text-center">{{ __('messages.status') }}</th>
                            <th class="text-center">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="loanTableBody">
                        @forelse ($loans as $loan)
                            <tr class="{{ $loan->id === $newLoan->id ? 'bg-green-100' : 'hover:bg-gray-100' }}">
                                <td class="text-center">
                                    @if ($loan->status !== 'reserved' && $loan->status !== 'rejected')
                                        <a href="{{ route('loan.invoice.show', ['id' => $loan->id]) }}"
                                            class="btn btn-secondary btn-sm"><i class="fa-solid fa-file-invoice"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">{{ $loan->invoice_number }}</td>
                                <td class="text-center">{{ $loan->book->title ?? 'Default Title' }}</td>
                                <td class="text-center">{{ $loan->member->name }}</td>
                                <td class="text-center">{{ $loan->loan_date ? $loan->loan_date->format('Y-m-d') : 'N/A' }}
                                </td>
                                <td class="text-center">{{ $loan->due_date ? $loan->due_date->format('Y-m-d') : 'N/A' }}
                                </td>
                                <td class="text-center">
                                    {{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                                <td class="text-center">៛{{ $loan->price }}</td>
                                <td class="text-center">
                                    @if ($loan->status === 'available')
                                        <span class="badge bg-success">{{ __('messages.status_available') }}</span>
                                    @elseif ($loan->status === 'borrowed')
                                        <span
                                            class="badge bg-warning text-dark">{{ __('messages.status_borrowed') }}</span>
                                    @elseif ($loan->status === 'overdue')
                                        <span class="badge bg-secondary">{{ __('messages.status_overdue') }}</span>
                                    @elseif ($loan->status === 'reserved')
                                        <span class="badge bg-info text-dark">{{ __('messages.status_reserved') }}</span>
                                    @elseif($loan->status === 'rejected')
                                        <span class="badge bg-danger">{{ __('messages.status_rejected') }}</span>
                                    @endif

                                </td>
                                <td class="text-center">
                                    @if ($loan->status !== 'reserved' && $loan->status !== 'rejected')
                                        <button class="btn btn-info btn-sm btn-view" data-id="{{ $loan->id }}">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>
                                    @endif

                                    @if ($loan->status === 'reserved')
                                        <a href="{{ route('loans.approve.form', $loan->id) }}" class="btn btn-info btn-sm">
                                            <i class="fa-solid fa-check"></i> Approve
                                        </a>
                                    @endif

                                    @if ($loan->status === 'rejected')
                                        <form action="{{ route('loans.reApprove', $loan->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirmReApprove(event)">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="fa-solid fa-redo"></i> Re-approve
                                            </button>
                                        </form>
                                    @endif

                                    @if ($loan->status !== 'reserved' && $loan->status !== 'rejected')
                                        <a href="{{ route('loans.finebook', $loan->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-money-bill"></i>
                                        </a>
                                    @endif

                                    @if (Auth::check() && Auth::user()->usertype === 'admin')
                                        <form action="{{ route('loans.destroy', $loan->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr id="noResultsRow">
                                <td colspan="10" class="text-center">No loans found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="pagination-container">
                {{ $loans->links() }}
            </div>
        </div>
    </div>

    <!-- Loan Details Modal -->
    <div class="modal fade" id="loanModal" tabindex="-1" aria-labelledby="loanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loanModalLabel">Loan Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loanDetails">
                    <!-- Loan details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <a id="editLoanButton" href="#" class="btn btn-success btn-sm"><i
                            class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Prevent form submission

            Swal.fire({
                title: '@lang('messages.delete_confirm')',
                text: '@lang('messages.delete_warning')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang('messages.delete')',
                cancelButtonText: '@lang('messages.cancel')'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show success alert and then submit the form after the alert is shown
                    Swal.fire({
                        title: '@lang('messages.delete_success')',
                        text: '@lang('messages.delete_text')',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        event.target.submit(); // Submit the form
                    });
                }
            });
        }


        const translations = {
            name: "{{ __('messages.name') }}",
            id: "{{ __('messages.id') }}",
            gender: "{{ __('messages.gender') }}",
            phone: "{{ __('messages.phone') }}",
            year: "{{ __('messages.year') }}",
            category: "{{ __('messages.category') }}",
            invoice_number: "{{ __('messages.invoice_number') }}",
            loan_date: "{{ __('messages.loan_date') }}",
            due_date: "{{ __('messages.due_date') }}",
            renew_date: "{{ __('messages.renew_date') }}",
            status: "{{ __('messages.status') }}",
            isbn: "{{ __('messages.isbn') }}",
            book_title: "{{ __('messages.book_title') }}",
            author: "{{ __('messages.author') }}",
            genre: "{{ __('messages.genre') }}",
            price: "{{ __('messages.price') }}",
            n_a: "{{ __('messages.n/a') }}"
        };

        document.querySelectorAll('.btn-view').forEach(button => {
            button.addEventListener('click', function() {
                const loanId = this.getAttribute('data-id');

                fetch(`/loans/${loanId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Determine badge class based on status
                        let statusBadge;
                        switch (data.status) {
                            case 'available':
                                statusBadge = '<span class="badge bg-success">Available</span>';
                                break;
                            case 'borrowed':
                                statusBadge =
                                    '<span class="badge bg-warning text-dark">Borrowed</span>';
                                break;
                            case 'overdue':
                                statusBadge = '<span class="badge bg-secondary">Overdue</span>';
                                break;
                            case 'reserved':
                                statusBadge = '<span class="badge bg-info text-dark">Reserved</span>';
                                break;
                            default:
                                statusBadge = '<span class="badge bg-light">Unknown</span>';
                        }

                        const genderText = data.gender === 'male' ? 'Male' : 'Female';

                        document.getElementById('loanDetails').innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Cover Image -->
                            <div class="col-md-4 mb-3">
                               ${data.cover_image ? `<img src="${data.cover_image}" style="width: 120px;" alt="Image" class="img-fluid">` : ''}
                            </div>
                            <!-- Loan and Member Details -->
                            <div class="col-md-4 mb-3">
                                <p><strong>${translations.name}:</strong> ${data.member_name} <strong>|</strong> ${data.memberId}</p>
                                <p><strong>${translations.gender}:</strong> ${genderText}</p>
                                <p><strong>${translations.phone}:</strong> ${data.phone}</p>
                                <p><strong>${translations.year}:</strong> ${data.study_name}</p>
                                <p><strong>${translations.category}:</strong> ${data.category_name}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p><strong>#${data.invoice_number}</strong></p>
                                <p><strong>${translations.loan_date}:</strong> ${data.loan_date}</p>
                                <p><strong>${translations.due_date}:</strong> ${data.due_date}</p>
                                <p><strong>${translations.renew_date}:</strong> ${data.renew_date || translations.n_a}</p>
                                <p><strong>${translations.status}:</strong> ${statusBadge}</p>
                            </div>
                        </div>
                        <hr>
                        <!-- Book Details Table -->
                        <div class="row">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>${translations.isbn}</th>
                    <th>${translations.book_title}</th>
                    <th>${translations.author}</th>
                    <th>${translations.genre}</th>
                    <th>${translations.price}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>${data.isbn}</td>
                    <td>${data.book_title}</td>
                    <td>${data.author}</td>
                    <td>${data.genre}</td>
                    <td>${data.price || translations.n_a}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

                    </div>
                </div>
            `;

                        document.getElementById('editLoanButton').href = `/loans/${loanId}/edit`;
                        new bootstrap.Modal(document.getElementById('loanModal')).show();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endpush
