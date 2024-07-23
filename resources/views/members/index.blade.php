<!-- resources/views/members/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Members</h2>
        <form action="{{ route('members.index') }}" method="GET" class="mb-3">
            <input type="text" name="search" value="{{ request()->input('search') }}" placeholder="Search..." class="form-control">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>
        <a href="{{ route('members.create') }}" class="btn btn-primary">Add Member</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    {{-- <th>#</th> --}}
                    <th>លេខសម្គាល់</th>
                    <th>ឈ្មោះ</th>
                    <th>ឈ្មោះឡាតាំង</th>
                    <th>ភេទ</th>
                    <th>ទូរស័ព្ទ</th>
                    <th>ថ្ងៃខែ​ឆ្នាំ​កំណើត</th>
                    <th>អាស័យដ្ឋាន</th>
                    <th>រូបភាព</th>
                    <th>ប៊ូតុង</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                    <tr>
                        {{-- <td>{{ $loop->iteration }}</td> --}}
                        <td>{{ $member->memberId }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->name_latin }}</td>
                        <td>{{ $member->gender == 'male' ? 'ប្រុស' : 'ស្រី' }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->dob }}</td>
                        <td>{{ $member->address }}</td>
                        <td>
                            @if ($member->image)
                                <img src="{{ asset($member->image) }}" alt="Member Image" style="max-width: 30px;">
                            @else
                           គ្មានរូបភាព
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-success btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="{{ route('members.show', $member->id) }}" class="btn btn-info btn-sm"><i class="fa-solid fa-circle-info"></i></a>
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
