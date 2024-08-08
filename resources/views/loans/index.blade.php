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
                <h5 class="card-title mb-0">{{ __('messages.book_list') }} </h5>
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
                            <th>{{ __('messages.invoice_number') }}</th>
                            <th>{{ __('messages.title') }}</th>
                            <th>{{ __('messages.member') }}</th>
                            <th>{{ __('messages.loan_date') }}</th>
                            <th>{{ __('messages.due_date') }}</th>
                            <th>{{ __('messages.renew_date') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="loanTableBody">
                        @forelse ($loans as $loan)
                            <tr>
                                <td>{{ $loan->invoice_number }}</td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->member->name }}</td>
                                <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                                <td>{{ $loan->due_date->format('Y-m-d') }}</td>
                                <td>{{ $loan->renew_date ? $loan->renew_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $loan->price }}</td>
                                <td>
                                    @if ($loan->status === 'available')
                                        <span class="badge bg-success">Available</span>
                                    @elseif ($loan->status === 'borrowed')
                                        <span class="badge bg-warning text-dark">មិនទាន់សង</span>
                                    @elseif ($loan->status === 'overdue')
                                        <span class="badge bg-secondary">Overdue</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm btn-view" data-id="{{ $loan->id }}">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button>
                                    <a href="{{ route('loans.finebook', $loan->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-money-bill"></i>
                                    </a>
                                    <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr id="noResultsRow">
                                <td colspan="9" class="text-center">No books found.</td>
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
                subject: "{{ __('messages.subject') }}",
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
                                        '<span class="badge bg-warning text-dark">មិនទាន់សង</span>';
                                    break;
                                case 'overdue':
                                    statusBadge = '<span class="badge bg-secondary">Overdue</span>';
                                    break;
                                default:
                                    statusBadge = '<span class="badge bg-light">Unknown</span>';
                            }

                            const genderText = data.gender === 'male' ? 'ប្រុស' : 'ស្រី';

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
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>${translations.isbn}</th>
                                                <th>${translations.book_title}</th>
                                                <th>${translations.author}</th>
                                                <th>${translations.subject}</th>
                                                <th>${translations.price}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>${data.isbn}</td>
                                                <td>${data.book_title}</td>
                                                <td>${data.author}</td>
                                                <td>${data.subject}</td>
                                                <td>${data.price || translations.n_a}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function() {
                const query = this.value.toLowerCase();
                document.querySelectorAll('#loanTableBody tr').forEach(row => {
                    const invoice = row.cells[0].textContent.toLowerCase();
                    const bookTitle = row.cells[1].textContent.toLowerCase();
                    if (invoice.includes(query) || bookTitle.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
