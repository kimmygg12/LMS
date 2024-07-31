@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Studies List</h1>
        <a href="{{ route('studies.create') }}" class="btn btn-primary mb-3">Add New Study</a>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($studies as $study)
                    <tr>
                        <td>{{ $study->id }}</td>
                        <td>{{ $study->name }}</td>
                        <td>
                            <a href="{{ route('studies.show', $study->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('studies.edit', $study->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('studies.destroy', $study->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
