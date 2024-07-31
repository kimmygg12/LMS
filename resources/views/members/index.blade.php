@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h2>បង្កើតព័ត៌អ្នកខ្ចីសៀវភៅ</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('members.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> បន្ថែម</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h5>បញ្ជីឈ្មោះសិស្ស</h5>
                </div>
                <div class="col-md-4 text-end">
                    <form method="GET" action="{{ route('members.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control me-2"
                            placeholder="ស្វែងរក..." value="{{ request()->get('search') }}">
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>លេខសម្គាល់</th>
                            <th>ឈ្មោះ</th>
                            <th>ឈ្មោះឡាតាំង</th>
                            <th>ភេទ</th>
                            <th>ទូរស័ព្ទ</th>
                            <th>ឆ្នាំ</th>
                            <th>ជំនាញ</th>
                            <th>រូបភាព</th>
                            <th>ប៊ូតុង</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            <tr>
                                <td>{{ $member->memberId }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->name_latin }}</td>
                                <td>{{ $member->gender == 'male' ? 'ប្រុស' : 'ស្រី' }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>{{ $member->study->name }}</td>
                                <td>{{ $member->category->name }}</td>
                                <td>
                                    @if ($member->image)
                                        <img src="{{ asset($member->image) }}" alt="Image" style="width: 30px;">
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm btn-view" data-id="{{ $member->id }}">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button>
                                    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-success btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                        style="display:inline;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $member->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr id="noResultsRow">
                                <td colspan="9" class="text-center">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $members->links() }}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">ព័ត៌មានលម្អិតរបស់សិស្ស</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="memberDetails">
                    <!-- Member details will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ត្រឡប់មកវិញ</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const memberId = this.getAttribute('data-id');
            
            Swal.fire({
                title: 'តើ​អ្នក​ប្រាកដ​ឬ​អត់?',
                text: 'អ្នកនឹងលុបវា?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'លុបចេញ',
                cancelButtonText: 'បោះបង់'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'បានលុប!',
                        text: 'សមាសភាពត្រូវបានលុប។',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        document.querySelector(`form[action*='${memberId}']`).submit();
                    });
                }
            });
        });
    });

    document.querySelectorAll('.btn-view').forEach(button => {
    button.addEventListener('click', function() {
        const memberId = this.getAttribute('data-id');

        fetch(`/members/${memberId}`)
            .then(response => response.json())
            .then(data => {
                const genderText = data.gender === 'male' ? 'ប្រុស' : 'ស្រី';
                document.getElementById('memberDetails').innerHTML = `
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    ${data.image ? `<img src="${data.image}" alt="Image" class="img-fluid">` : ''}
                                </div>
                                <div class="col-md-8">
                                    <p><strong>ឈ្មោះ:</strong> ${data.name}</p>
                                    <p><strong>ឈ្មោះឡាតាំង:</strong> ${data.name_latin}</p>
                                    <p><strong>លេខសម្គាល់:</strong> ${data.memberId}</p>
                                      <p><strong>ភេទ:</strong> ${genderText}</p>
                                    <p><strong>ទូរស័ព្ទ:</strong> ${data.phone}</p>
                                    <p><strong>ឆ្នាំ:</strong> ${data.study_name}</p>
                                    <p><strong>ជំនាញ:</strong> ${data.category_name}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                new bootstrap.Modal(document.getElementById('memberModal')).show();
            })
            .catch(error => console.error('Error:', error));
    });
});

</script>
@endsection
@endsection
