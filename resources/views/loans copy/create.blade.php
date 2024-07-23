@extends('layouts.app')

@section('content')
    <h1>Borrow a Book</h1>
    <form action="{{ route('loans.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" data-toggle="modal" data-target="#exampleModal">
        </div>
        <div class="form-group">
            <label for="member_id">Member</label>
            <select name="member_id" id="member_id" class="form-control">
                @foreach($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="book_id">Book</label>
            <select name="book_id" id="book_id" class="form-control">
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="book_copy_id">Book Copy</label>
            <select name="book_copy_id" id="book_copy_id" class="form-control">
                @foreach($books as $book)
                    @foreach($book->copies as $copy)
                        <option value="{{ $copy->id }}">{{ $book->title }} - Copy {{ $copy->copy_number }}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Borrow</button>
    </form>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('members.index') }}" method="GET" class="mb-3">
                    <input type="text" name="search" value="{{ request()->input('search') }}" placeholder="Search..." class="form-control">
                    <button type="submit" class="btn btn-primary mt-2">Search</button>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
@endsection
