<?php

use App\Http\Controllers\Auth\MemberAuthController;
use App\Http\Controllers\BookReservationController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanBookController;
use App\Http\Controllers\LoanBookHistoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\SubjectController;
use App\Models\Author;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home_student');
// });

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
// });

Route::get('/home-student', [BookController::class, 'homeStudent'])->name('home.student');
Route::get('/search-books', [BookController::class, 'searchBooks'])->name('search.books');


Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('books', BookController::class);
    Route::post('authors', function (Request $request) {
        $author = Author::create($request->all());
        return response()->json($author);
    })->name('authors.store');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/overdue-books-report', [LoanBookController::class, 'overdueBooksReport'])->name('loans.overdueBooksReport');
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::get('/loans/top-borrowed-books', [LoanBookController::class, 'topBorrowedBooksReport'])->name('loans.topBorrowedBooksReport');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
    Route::resource('books', BookController::class)->only(['create', 'store']);

    Route::resource('books', BookController::class);
    Route::get('books/{id}', [BookController::class, 'show'])->name('books.show');
    Route::get('/loans/{id}/invoice', [LoanBookController::class, 'showInvoice'])->name('loans.show-invoice');
    Route::get('/loans/{id}/invoice', [LoanBookController::class, 'showInvoice'])->name('loans.showInvoice');

    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::resource('subjects', SubjectController::class);
    Route::resource('studies', StudyController::class);
    Route::get('loans', [LoanBookController::class, 'index'])->name('loans.index');
    Route::get('/loans/{id}/edit', [LoanBookController::class, 'edit'])->name('loans.edit');
    Route::put('/loans/{id}', [LoanBookController::class, 'update'])->name('loans.update');

    Route::get('loans/create', [LoanBookController::class, 'create'])->name('loans.create');
    Route::post('loans', [LoanBookController::class, 'store'])->name('loans.store');
    Route::resource('loans', LoanBookController::class);
    Route::resource('loans', LoanBookController::class);
    Route::resource('members', MemberController::class);
    Route::get('/dashboard/payments', [DashboardController::class, 'Payments'])->name('dashboard.Payments');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('loans/reports/tab', [LoanBookController::class, 'indexReport'])->name('loans.reports');
    Route::get('loans/report/total', [LoanBookController::class, 'reportTotalLoan'])->name('loans.report.total');
    Route::get('/loans', [LoanBookController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanBookController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanBookController::class, 'store'])->name('loans.store');
    Route::post('/loans/return', [LoanBookController::class, 'return'])->name('loans.return');
    Route::get('/loans-history', [LoanBookController::class, 'history'])->name('loans.history');
    Route::get('loan-book-history', [LoanBookController::class, 'history'])->name('loanBookHistory.index');

    Route::get('borrow/{id}/renew', [LoanBookController::class, 'showRenewForm'])->name('loans.renew.form');
    Route::put('borrow/{id}/renew', [LoanBookController::class, 'renew'])->name('loans.renew');

    Route::resource('categories', CategoryController::class);
    Route::resource('loans', LoanBookController::class);

    Route::put('/borrow/{id}/finebook', [LoanBookController::class, 'fineBook'])->name('loans.finebook');
    Route::get('/borrow/{id}/finebook', [LoanBookController::class, 'showFinebookForm'])->name('loans.finebook.form');
    Route::resource('authors', AuthorController::class);
    Route::get('/loanBookHistories', [LoanBookHistoryController::class, 'index'])->name('loanBookHistories.index');
    Route::get('/loanBookHistories/{id}', [LoanBookHistoryController::class, 'show'])->name('loanBookHistories.show');
    Route::get('/loanBookHistories/{id}/print', [LoanBookHistoryController::class, 'print'])->name('loanBookHistories.print');

    Route::get('/invoice/{id}', [LoanBookHistoryController::class, 'showInvoice'])->name('invoice.show');

    Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
    Route::get('members/invoice/{invoice}', [MemberController::class, 'searchInvoice'])->name('members.searchInvoice');
    Route::get('/members/search', [MemberController::class, 'search'])->name('members.search');
    Route::get('/combined-report', [LoanBookController::class, 'combinedReport'])->name('loans.combinedReport');

    Route::get('/studies', [StudyController::class, 'index'])->name('studies.index');
    Route::get('/studies/create', [StudyController::class, 'create'])->name('studies.create');
    Route::post('/studies', [StudyController::class, 'store'])->name('studies.store');
    Route::get('/studies/{study}', [StudyController::class, 'show'])->name('studies.show');
    Route::get('/studies/{study}/edit', [StudyController::class, 'edit'])->name('studies.edit');
    Route::put('/studies/{study}', [StudyController::class, 'update'])->name('studies.update');
    Route::delete('/studies/{study}', [StudyController::class, 'destroy'])->name('studies.destroy');

    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
    Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::put('/authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/combined', [ReportController::class, 'combinedReport'])->name('reports.combined');
    Route::get('/reports/combined', [ReportController::class, 'combinedReport'])->name('reports.combinedReport');
    Route::get('/reports/new-books', [ReportController::class, 'newBooks'])->name('reports.new_books');

    Route::get('locale/{locale}', [LocaleController::class, 'set'])->name('locale.set');
    Route::get('member-borrow/{memberId}', [LoanBookController::class, 'memberLoanDetails'])->name('member.loans.details');
    Route::get('member/{memberId}/borrow-history', [LoanBookHistoryController::class, 'memberLoanDetails'])->name('member.loanHistory.details');
    Route::get('/member/{id}/borrow', [LoanBookController::class, 'memberLoanDetails'])->name('member.loanDetails');
    Route::get('borrow/{id}/invoice', [LoanBookController::class, 'showInvoice'])->name('loan.invoice.show');
    Route::get('/borrow-book-history/{id}', [LoanBookHistoryController::class, 'showInvoice'])->name('loanBookHistories.showInvoice');

});

Route::get('/member/register', [MemberAuthController::class, 'showRegisterForm'])
    ->name('member.register');
Route::post('/member/register', [MemberAuthController::class, 'register']);

Route::get('/member/login', [MemberAuthController::class, 'showLoginForm'])
    ->name('member.login');
Route::post('/member/login', [MemberAuthController::class, 'login']);
Route::post('/member/logout', [MemberAuthController::class, 'logout'])
    ->name('member.logout');
Route::get('/member/dashboard', [HomeController::class, 'index'])
    ->name('member.dashboard')
    ->middleware('auth:member');
Route::get('/member/{id}', [MemberController::class, 'showmember'])
    ->name('members.showmember')
    ->middleware('auth:member');
Route::middleware('auth:member')->group(function () {
    Route::get('/members/{id}/loans', [MemberController::class, 'showLoans'])->name('members.showLoans');

});
Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('members.dashboard');
Route::get('/members/bookss/{id}', [MemberController::class, 'showBook'])->name('members.books.show');
Route::get('/members/books/{id}', [MemberController::class, 'showBookDetails'])->name('members.books.details');
Route::post('/reservations/reserve', [ReservationController::class, 'reserve'])->name('reservations.reserve');
Route::post('/loans/{loan}/approve', [LoanBookController::class, 'approve'])->name('loans.approve');
Route::get('/loans/{loan}/approve', [LoanBookController::class, 'showApproveForm'])->name('loans.approve.form');

Route::get('/members/reserved-books', [ReservationController::class, 'showReservedBooks'])->name('reservations.show');
Route::post('/loans/reject/{id}', [LoanBookController::class, 'rejectReservation'])->name('loans.reject');
Route::post('/loans/{id}/reapprove', [LoanBookController::class, 'reApproveReservation'])->name('loans.reApprove');
Route::get('/members/student-book/{book}', [BookController::class, 'showBook'])->name('members.student-book');


require __DIR__ . '/auth.php';
