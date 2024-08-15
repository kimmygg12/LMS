
@extends('layouts.app')

@section('content')
<div class="row mt-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ __('messages.borrow_book') }}</h1>
        <button type="button" id="add-book" class="btn btn-success">
            <i class="fa-solid fa-plus"></i> {{ __('messages.add') }}
        </button>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('loans.store') }}" method="POST">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered" id="books-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Book</th>
                        <th style="width: 20%;">Member</th>
                        <th style="width: 15%;">Price</th>
                        <th style="width: 15%;">Loan Date</th>
                        <th style="width: 15%;">Due Date</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="book-row" data-index="0">
                        <td>
                            <select name="books[0][book_id]" class="form-control book-select select2" required>
                                <option value="">Select a book</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}" {{ old('books.0.book_id') == $book->id ? 'selected' : '' }} 
                                        data-title="{{ $book->title }}" 
                                        data-price="{{ $book->price }}">
                                        {{ $book->isbn }} - {{ $book->title }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="books[0][member_id]" class="form-control select2" required>
                                <option value="">Select a member</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="books[0][price]" class="form-control" min="1" required>
                        </td>
                        <td>
                            <input type="date" name="books[0][loan_date]" class="form-control" required>
                        </td>
                        <td>
                            <input type="date" name="books[0][due_date]" class="form-control" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-book">Remove</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-success mt-3">{{ __('books.save') }}</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let bookIndex = 1;

        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap-5'
        });

        // Add new book row
        $('#add-book').on('click', function() {
            const newRowHtml = `
                <tr class="book-row" data-index="${bookIndex}">
                    <td>
                        <select name="books[${bookIndex}][book_id]" class="form-control book-select select2" required>
                            <option value="">Select a book</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}" 
                                    data-title="{{ $book->title }}" 
                                    data-price="{{ $book->price }}">
                                    {{ $book->isbn }} - {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="books[${bookIndex}][member_id]" class="form-control select2" required>
                            <option value="">Select a member</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="books[${bookIndex}][price]" class="form-control" min="1" required>
                    </td>
                    <td>
                        <input type="date" name="books[${bookIndex}][loan_date]" class="form-control" required>
                    </td>
                    <td>
                        <input type="date" name="books[${bookIndex}][due_date]" class="form-control" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-book">Remove</button>
                    </td>
                </tr>
            `;

            $('#books-table tbody').append(newRowHtml);

            // Reinitialize Select2 for newly added elements
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            bookIndex++;
        });

        // Handle changes to the book selection
        $(document).on('change', '.book-select', function() {
            let index = $(this).closest('.book-row').data('index');
            let selectedOption = $(this).find('option:selected');
            $(`input[name="books[${index}][price]"]`).val(selectedOption.data('price'));
        });

        // Remove book row
        $(document).on('click', '.remove-book', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
@endsection
