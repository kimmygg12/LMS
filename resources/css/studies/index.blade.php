@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Studies</h1>
        <a href="{{ route('studies.create') }}" class="btn btn-primary">Create Study</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Study Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($studies as $study)
                    <tr>
                        {{-- <td>{{ $study->id }}</td> --}}
                        <td>{{ $study->study }}</td>
                        <td>
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
