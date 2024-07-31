{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <h2>គ្រប់គ្រប់ការខ្ចីសៀវភៅ</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('loans.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> បន្ថែម</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                {{ $message }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h5 class="card-title mb-0">Loan Records</h5>
                    </div>
                    <div class="col-md-4 text-end">
                        <form method="GET" action="{{ route('loans.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control me-2"
                                placeholder="Search by name or ID" value="{{ request()->get('search') }}">
                            <button type="submit" class="btn btn-success"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                </div>


                <!-- Table -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>វិក្កយបត្រ</th>
                                <th>សៀវភៅ</th>
                                <th>Member</th>
                                <th>ខ្ចីនៅថ្ងៃ</th>
                                <th>កាលបរិច្ឆេទ កំណត់</th>
                                <th>បន្តខ្ចី</th>
                                <th>តម្លៃ</th>
                                <th>ស្ថានភាព</th>
                                <th>Actions</th>
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
                                        <form action="{{ route('loans.destroy', $loan->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirmDelete(event)">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    event.target.submit();
                }
            });
        }

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
                                    <p><strong>Name:</strong> ${data.member_name} <strong>|</strong> ${data.memberId}</p>
                                    <p><strong>Gender:</strong> ${data.gender}</p>
                                    <p><strong>Phone:</strong> ${data.phone}</p>
                                    <p><strong>Study:</strong> ${data.study_name}</p>
                                    <p><strong>Category:</strong> ${data.category_name}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <p><strong>#${data.invoice_number}</strong></p>
                                    <p><strong>Loan Date:</strong> ${data.loan_date}</p>
                                    <p><strong>Due Date:</strong> ${data.due_date}</p>
                                    <p><strong>Renew Date:</strong> ${data.renew_date || 'N/A'}</p>
                                    <p><strong>Status:</strong> ${statusBadge}</p>
                                </div>
                            </div>
                            <hr>
                            <!-- Book Details Table -->
                            <div class="row">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">ISBN</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Fine</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>${data.isbn}</td>
                                            <td>${data.book_title}</td>
                                            <td>${data.price || 'N/A'}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p><strong>Fine:</strong> ${data.fine || 'N/A'}</p>
                        </div>
                    </div>
                `;
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
@endpush --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <h2>គ្រប់គ្រប់ការខ្ចីសៀវភៅ</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('loans.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> បន្ថែម</a>
             
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                {{ $message }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h5 class="card-title mb-0">Loan Records</h5>
                    </div>
                    <div class="col-md-4 text-end">
                        <form method="GET" action="{{ route('loans.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control me-2"
                                placeholder="ស្វែងរក..." value="{{ request()->get('search') }}">
                            <button type="submit" class="btn btn-success"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                </div>


                <!-- Table -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>វិក្កយបត្រ</th>
                                <th>សៀវភៅ</th>
                                <th>Member</th>
                                <th>ខ្ចីនៅថ្ងៃ</th>
                                <th>កាលបរិច្ឆេទ កំណត់</th>
                                <th>បន្តខ្ចី</th>
                                <th>តម្លៃ</th>
                                <th>ស្ថានភាព</th>
                                <th>ប៊ូតុង</th>
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
                                        <form action="{{ route('loans.destroy', $loan->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirmDelete(event)">
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
                    {{-- <button class="btn btn-primary" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button> --}}
                    <a id="editLoanButton" href="#" class="btn btn-success btn-sm"><i class="fa-solid fa-pen-to-square"></i> Edit</a>

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
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    event.target.submit();
                }
            });
        }

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
                                    <p><strong>ឈ្មោះ:</strong> ${data.member_name} <strong>|</strong> ${data.memberId}</p>
                                     <p><strong>ភេទ:</strong> ${genderText}</p>
                                    <p><strong>ទូរស័ព្ទ:</strong> ${data.phone}</p>
                                    <p><strong>ឆ្នាំទី:</strong> ${data.study_name}</p>
                                    <p><strong>ជំនាញ:</strong> ${data.category_name}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <p><strong>#${data.invoice_number}</strong></p>
                                    <p><strong>ថ្ងៃខ្ចី</strong> ${data.loan_date}</p>
                                    <p><strong>ថ្ងៃកំណត់សង:</strong> ${data.due_date}</p>
                                    <p><strong>បានខ្ចីបន្ត:</strong> ${data.renew_date || 'N/A'}</p>
                                    <p><strong>ស្ថានភាព:</strong> ${statusBadge}</p>
                                </div>
                            </div>
                            <hr>
                            <!-- Book Details Table -->
                            <div class="row">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">កូដ</th>
                                            <th scope="col">ចំណងជើង</th>
                                             <th scope="col">Author</th> 
                                            <th scope="col">ប្រាក់កក់</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>${data.isbn}</td>
                                            <td>${data.book_title}</td>
                                            <td>${data.author} </td>
                                            <td>${data.price || 'N/A'}</td>
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
