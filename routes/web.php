<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookBorrowController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogPeminjamanController;
use App\Http\Controllers\LogPeminjamController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PublicController::class, 'index']);
Route::get('/book-list-detail/{slug}', [PublicController::class, 'showSinopsis']);

Route::middleware('OnlyGuest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticating']);
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'register_proses']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::middleware('OnlyPeminjam')->group(function () {
        Route::get('/book-borrow', [BookBorrowController::class, 'index']);
        Route::post('/book-borrow', [BookBorrowController::class, 'store']);
        Route::get('/log-peminjaman-anggota', [UserController::class, 'profile']);
        Route::get('/profile', [UserController::class, 'showProfile']);
        Route::put('/profile', [UserController::class, 'updateProfile']);
    });

    Route::middleware('OnlyAdmin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/books', [BookController::class, 'index']);
        // Route::get('/books/search', [BookController::class, 'search'])->name('book.search');
        Route::get('/books-add', [BookController::class, 'addData']);
        Route::post('/books-add', [BookController::class, 'store']);
        Route::get('/books-edit/{slug}', [BookController::class, 'edit']);
        Route::post('/books-edit/{slug}', [BookController::class, 'update']);
        Route::get('/books-destroy/{slug}', [BookController::class, 'destroy']);
        Route::get('/books-detail/{slug}', [BookController::class, 'show']);
        Route::get('/export-pdf', [BookController::class, 'exportPdf']);
        Route::get('/cetak-laporan-buku', [BookController::class, 'printLaporan']);

        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/category-add', [CategoryController::class, 'addData']);
        Route::post('/category-add', [CategoryController::class, 'store']);
        Route::get('/category-edit/{slug}', [CategoryController::class, 'edit']);
        Route::put('/category-edit/{slug}', [CategoryController::class, 'update']);
        Route::get('/category-delete/{slug}', [CategoryController::class, 'delete']);

        Route::get('/anggota', [UserController::class, 'index']);
        Route::get('/registered-anggota', [UserController::class, 'registeredAnggota']);
        Route::get('/detail-anggota/{slug}', [UserController::class, 'show']);
        Route::get('/approve-anggota/{slug}', [UserController::class, 'approve']);
        Route::get('/block-anggota/{slug}', [UserController::class, 'block']);
        Route::get('/blocked-anggota', [UserController::class, 'blockedAnggota']);
        Route::get('/unblock-anggota/{slug}', [UserController::class, 'unblockAnggota']);
        
        Route::get('/pengguna', [UserController::class, 'pengguna']);
        Route::get('/pengguna-add', [UserController::class, 'addPengguna']);
        Route::post('/pengguna-add', [UserController::class, 'prosesAddPengguna']);
        Route::get('/pengguna-destroy/{slug}', [UserController::class, 'destroyPengguna']);
        Route::get('/pengguna-edit/{slug}', [UserController::class, 'editPengguna']);
        Route::put('/pengguna-edit/{slug}', [UserController::class, 'updatePengguna']);

        Route::get('/log-peminjaman', [LogPeminjamanController::class, 'index']);
        Route::get('/export-laporan', [LogPeminjamanController::class, 'exportPdf']);
        Route::get('/cetak-laporan-peminjaman', [LogPeminjamanController::class, 'printLaporan']);
        Route::get('/cetak-laporan-pengembalian', [LogPeminjamanController::class, 'printLaporanPengembalian']);
        Route::get('/peminjaman-sudah-kembali', [LogPeminjamanController::class, 'pinjamKembali']);
        Route::get('/export-laporan-pengembalian', [LogPeminjamanController::class, 'exportPdfPengembalian']);

        Route::get('/book-return', [BookBorrowController::class, 'returnBook']);
        Route::post('/book-return', [BookBorrowController::class, 'storeReturnBook']);
    });

    // Route::middleware('OnlyPetugas')->group(function () {
    //     Route::get('/dashboard', [DashboardController::class, 'index']);
    //     Route::get('/books', [BookController::class, 'index']);
    //     Route::get('/books-add', [BookController::class, 'addData']);
    //     Route::post('/books-add', [BookController::class, 'store']);
    //     Route::get('/books-edit/{slug}', [BookController::class, 'edit']);
    //     Route::post('/books-edit/{slug}', [BookController::class, 'update']);
    //     Route::get('/books-destroy/{slug}', [BookController::class, 'destroy']);
    //     Route::get('/export-pdf', [BookController::class, 'exportPdf']);

    //     Route::get('/categories', [CategoryController::class, 'index']);
    //     Route::get('/category-add', [CategoryController::class, 'addData']);
    //     Route::post('/category-add', [CategoryController::class, 'store']);
    //     Route::get('/category-edit/{slug}', [CategoryController::class, 'edit']);
    //     Route::put('/category-edit/{slug}', [CategoryController::class, 'update']);
    //     Route::get('/category-delete/{slug}', [CategoryController::class, 'delete']);

    //     Route::get('/anggota', [UserController::class, 'index']);
    //     Route::get('/registered-anggota', [UserController::class, 'registeredAnggota']);
    //     Route::get('/detail-anggota/{slug}', [UserController::class, 'show']);
    //     Route::get('/approve-anggota/{slug}', [UserController::class, 'approve']);
    //     Route::get('/block-anggota/{slug}', [UserController::class, 'block']);
    //     Route::get('/blocked-anggota', [UserController::class, 'blockedAnggota']);
    //     Route::get('/unblock-anggota/{slug}', [UserController::class, 'unblockAnggota']);

    //     Route::get('/log-peminjaman', [LogPeminjamanController::class, 'index']);
    //     Route::get('/export-laporan', [LogPeminjamanController::class, 'exportPdf']);

    //     Route::get('/book-return', [BookBorrowController::class, 'returnBook']);
    //     Route::post('/book-return', [BookBorrowController::class, 'storeReturnBook']);
    // });
});
