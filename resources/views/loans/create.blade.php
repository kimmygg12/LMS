{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Loan</h1>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('loans.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="book_id">Book</label>
                <select id="book_id" name="book_id" class="form-control select2" required>
                    <option value="">Select a book</option>
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="member_id">Member</label>
                <select id="member_id" name="member_id" class="form-control select2" required>
                    <option value="">Select a member</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->memberId }} - {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="loan_date">Loan Date</label>
                <input type="date" id="loan_date" name="loan_date" class="form-control" value="{{ old('loan_date') }}"
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="due_date">Due Date</label>
                <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('due_date') }}"
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}">
            </div>
            <button type="submit" class="btn btn-primary">Create Loan</button>
        </form>
    </div>
    
@endsection


    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Create New Loan</h1>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('loans.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="isbn" class="form-label">Book ISBN</label>
                            <div class="input-group">
                            <select id="isbn" name="isbn" class="form-control" required>
                                <option value="">Select a book by ISBN</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->isbn }}" 
                                        data-id="{{ $book->id }}"
                                        data-title="{{ $book->title }}"
                                        data-price="{{ $book->price }}">
                                        {{ $book->isbn }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="title" >Title</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" readonly>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="member_id "class="form-label">Member</label>
                            <div class="input-group">
                            <select id="member_id" name="member_id" class="form-control" required>
                                <option value="">Select a member</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->memberId }} - {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="price">Price</label>
                            <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}">
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="loan_date">Loan Date</label>
                            <input type="date" id="loan_date" name="loan_date" class="form-control" value="{{ old('loan_date') }}" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="due_date">Due Date</label>
                            <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('due_date') }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Loan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
      $(document).ready(function() {
            $('#member_id').select2({
                theme: 'bootstrap-5'
            });
        });
</script>
    <script>
        $(document).ready(function() {
            $('#isbn').select2({
                theme: 'bootstrap-5'
            });
      

            $('#isbn').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                $('#title').val(selectedOption.data('title'));
            });
        });
    </script>
@endsection


