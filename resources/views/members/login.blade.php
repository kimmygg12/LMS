@extends('layouts.homestudent')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center mt-5">Student Login</h2>
            <form method="POST" action="{{ route('member.login') }}">
                @csrf
                <div class="form-group">
                    <label for="memberId">Student ID</label>
                    <input type="text" id="memberId" name="memberId" class="form-control" placeholder="Member ID" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                        required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection
