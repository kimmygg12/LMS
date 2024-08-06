@extends('layouts.app')

@section('content')
<div class="row mt-4 mb-4">
    <div class="col">
        <h2>បង្កើតព័ត៌អ្នកខ្ចីសៀវភៅ</h2>
    </div>
    <div class="col text-end">
        <a href="{{ route('members.create') }}" class="btn btn-success">
            <i class="fa-solid fa-plus"></i> បន្ថែម
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card mb-4">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="col-md-7">
        <h5 class="card-title mb-2 mb-md-0">បញ្ជីឈ្មោះសិស្ស</h5>   </div>
        <div class="col-md-5 text-end">
        <form method="GET" action="{{ route('members.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="ស្វែងរក..."
                value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>
</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">លេខសម្គាល់</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ឈ្មោះ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ឈ្មោះឡាតាំង</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ភេទ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ទូរស័ព្ទ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ឆ្នាំ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ជំនាញ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">រូបភាព</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($members as $member)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $member->memberId }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $member->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $member->name_latin }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $member->gender == 'male' ? 'ប្រុស' : 'ស្រី' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $member->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $member->study->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $member->category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($member->image)
                                    <img src="{{ asset($member->image) }}" alt="Image" style="width: 30px;">
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button type="button" class="btn btn-info btn-sm btn-view" data-id="{{ $member->id }}">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-form="{{ $member->id }}">
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

<!-- Modal -->
<div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">ព័ត៌មានលម្អិតរបស់សិស្ស</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="memberDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ត្រឡប់មកវិញ</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Modals and Confirmation Dialogs -->
<script>
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

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
