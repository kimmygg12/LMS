@extends('layouts.app')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h2>{{(__('books.subject'))}}</h2>
            <a href="{{ route('subjects.create') }}" class="btn btn-success float-end">{{__('members.Create_list')}}</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{ $subject->id }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>
                                <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-success btn-sm"> <i class="fa-solid fa-pen-to-square"></i></a>
                                @if (Auth::check() && Auth::user()->usertype === 'admin')
                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
