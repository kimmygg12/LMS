<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanBookController;
use App\Http\Controllers\LoanBookHistoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\SubjectController;
use App\Models\Author;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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

Auth::routes();
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('books', BookController::class);
Route::post('authors', function (Request $request) {
    $author = Author::create($request->all());
    return response()->json($author);
})->name('authors.store');

Route::middleware(['auth'])->group(function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::get('/loans/reportLoan', [LoanBookController::class, 'reportLoan'])->name('loans.reportLoan');
Route::get('/overdue-books-report', [LoanBookController::class, 'overdueBooksReport'])->name('loans.overdueBooksReport');

Route::get('/books/search', [BookController::class, 'search'])->name('books.search');


Route::get('/authors/search', [AuthorController::class, 'search'])->name('authors.search');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
Route::resource('books', BookController::class)->only(['create', 'store']);
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
Route::resource('books', BookController::class);
Route::get('books/{id}', [BookController::class, 'show'])->name('books.show');

Route::resource('subjects', SubjectController::class);
Route::resource('studies', StudyController::class);
Route::get('loans', [LoanBookController::class, 'index'])->name('loans.index');
Route::get('/loans/{id}/edit', [LoanBookController::class, 'edit'])->name('loans.edit');
Route::put('/loans/{id}', [LoanBookController::class, 'update'])->name('loans.update');
Route::get('indexloan', [LoanBookController::class, 'indexloan'])->name('loans.indexloan');
Route::get('loans/create', [LoanBookController::class, 'create'])->name('loans.create');
Route::post('loans', [LoanBookController::class, 'store'])->name('loans.store');
Route::resource('loans', LoanBookController::class);




Route::resource('loans', LoanBookController::class);
Route::resource('members', MemberController::class);



Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::get('loans/reports/tab', [LoanBookController::class, 'indexReport'])->name('loans.reports');
Route::get('loans/report/total', [LoanBookController::class, 'reportTotalLoan'])->name('loans.report.total');


Route::get('/loans', [LoanBookController::class, 'index'])->name('loans.index');
Route::get('/loans/create', [LoanBookController::class, 'create'])->name('loans.create');
Route::post('/loans', [LoanBookController::class, 'store'])->name('loans.store');
Route::post('/loans/return', [LoanBookController::class, 'return'])->name('loans.return');
Route::get('/loans-history', [LoanBookController::class, 'history'])->name('loans.history');
Route::get('loan-book-history', [LoanBookController::class, 'history'])->name('loanBookHistory.index');

Route::get('loans/{id}/renew', [LoanBookController::class, 'showRenewForm'])->name('loans.renew.form');
Route::put('loans/{id}/renew', [LoanBookController::class, 'renew'])->name('loans.renew');
Route::resource('students', StudentController::class);
Route::resource('categories', CategoryController::class);
Route::resource('loans', LoanBookController::class);

Route::put('/loans/{id}/finebook', [LoanBookController::class, 'fineBook'])->name('loans.finebook');
Route::get('/loans/{id}/finebook', [LoanBookController::class, 'showFinebookForm'])->name('loans.finebook.form');

Route::get('/loanBookHistories', [LoanBookHistoryController::class, 'index'])->name('loanBookHistories.index');
Route::get('/loanBookHistories/{id}', [LoanBookHistoryController::class, 'show'])->name('loanBookHistories.show');
// Route::get('/loanBookHistories/{id}', [LoanBookHistoryController::class, 'show']);
Route::get('/loanBookHistories/{id}/print', [LoanBookHistoryController::class, 'print'])->name('loanBookHistories.print');

Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
Route::get('members/invoice/{invoice}', [MemberController::class, 'searchInvoice'])->name('members.searchInvoice');
Route::get('/members/search', [MemberController::class, 'search'])->name('members.search');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');