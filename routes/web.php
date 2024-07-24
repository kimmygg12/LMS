<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCopyController;
use App\Http\Controllers\LoanBookController;
use App\Http\Controllers\LoanBookHistoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\SubjectController;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('authors', AuthorController::class);
Route::resource('books', BookController::class);
Route::post('authors', function (Request $request) {
    $author = Author::create($request->all());
    return response()->json($author);
})->name('authors.store');

Route::get('/authors/search', [AuthorController::class, 'search'])->name('authors.search');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
Route::resource('books', BookController::class)->only(['create', 'store']);
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');

Route::resource('books', BookController::class);
Route::get('books/{id}', [BookController::class, 'show'])->name('books.show');
Route::resource('book_copies', BookCopyController::class);
Route::resource('members', MemberController::class);
Route::resource('subjects', SubjectController::class);
// Route::resource('loans', LoanBookController::class);
Route::resource('studies', StudyController::class);
Route::get('search-members', [MemberController::class, 'search'])->name('search-members');
Route::get('members/search', [MemberController::class, 'search'])->name('members.search');
Route::get('loans', [LoanBookController::class, 'index'])->name('loans.index');
Route::get('loans/create', [LoanBookController::class, 'create'])->name('loans.create');
Route::post('loans', [LoanBookController::class, 'store'])->name('loans.store');
Route::resource('loans', LoanBookController::class);

Route::get('/loans', [LoanBookController::class, 'index'])->name('loans.index');
Route::get('/loans/create', [LoanBookController::class, 'create'])->name('loans.create');
Route::post('/loans', [LoanBookController::class, 'store'])->name('loans.store');
Route::post('/loans/renew/{id}', [LoanBookController::class, 'renew'])->name('loans.renew');
Route::post('/loans/return', [LoanBookController::class, 'return'])->name('loans.return');
Route::get('/loans-history', [LoanBookController::class, 'history'])->name('loans.history');
Route::get('loan-book-history', [LoanBookController::class, 'history'])->name('loanBookHistory.index');

// Route::post('/loans/finebook{id}', [LoanBookController::class, 'finebook'])->name('loans.finebook');
Route::put('/loans/{id}/finebook', [LoanBookController::class, 'finebook'])->name('loans.finebook');
Route::get('/loans/{id}/finebook', [LoanBookController::class, 'showFinebookForm'])->name('loans.showFinebookForm');

Route::get('/loanBookHistories', [LoanBookHistoryController::class, 'index'])->name('loanBookHistories.index');
Route::get('/loanBookHistories/{id}', [LoanBookHistoryController::class, 'show'])->name('loanBookHistories.show');
// Route::get('/loanBookHistories/{id}', [LoanBookHistoryController::class, 'show']);
Route::get('/loanBookHistories/{id}/print', [LoanBookHistoryController::class, 'print'])->name('loanBookHistories.print');


Route::get('students/search', [LoanBookController::class, 'searchStudent'])->name('students.search');
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
Route::get('members/invoice/{invoice}', [MemberController::class, 'searchInvoice'])->name('members.searchInvoice');
