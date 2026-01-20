<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin');
Route::post('/login/siswa', [AuthController::class, 'loginSiswa'])->name('login.siswa');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Buku
    Route::get('/buku', [AdminController::class, 'indexBuku'])->name('buku');
    Route::get('/buku/create', [AdminController::class, 'createBuku'])->name('buku.create');
    Route::post('/buku', [AdminController::class, 'storeBuku'])->name('buku.store');
    Route::get('/buku/{id}/edit', [AdminController::class, 'editBuku'])->name('buku.edit');
    Route::put('/buku/{id}', [AdminController::class, 'updateBuku'])->name('buku.update');
    Route::delete('/buku/{id}', [AdminController::class, 'destroyBuku'])->name('buku.destroy');

    // Anggota
    Route::get('/anggota', [AdminController::class, 'indexAnggota'])->name('anggota');
    Route::get('/anggota/create', [AdminController::class, 'createAnggota'])->name('anggota.create');
    Route::post('/anggota', [AdminController::class, 'storeAnggota'])->name('anggota.store');
    Route::get('/anggota/{id}/edit', [AdminController::class, 'editAnggota'])->name('anggota.edit');
    Route::put('/anggota/{id}', [AdminController::class, 'updateAnggota'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AdminController::class, 'destroyAnggota'])->name('anggota.destroy');

    // Transaksi
    Route::get('/transaksi', [AdminController::class, 'indexTransaksi'])->name('transaksi');
    Route::get('/transaksi/create', [AdminController::class, 'createTransaksi'])->name('transaksi.create');
    Route::post('/transaksi', [AdminController::class, 'storeTransaksi'])->name('transaksi.store');
    Route::get('/transaksi/{id}/edit', [AdminController::class, 'editTransaksi'])->name('transaksi.edit');
    Route::put('/transaksi/{id}', [AdminController::class, 'updateTransaksi'])->name('transaksi.update');
    Route::delete('/transaksi/{id}', [AdminController::class, 'destroyTransaksi'])->name('transaksi.destroy');
});

Route::middleware(['auth:anggota'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    
    // Peminjaman
    Route::get('/peminjaman', [SiswaController::class, 'indexPeminjaman'])->name('peminjaman');
    Route::post('/peminjaman', [SiswaController::class, 'storePeminjaman'])->name('peminjaman.store');

    // Pengembalian
    Route::get('/pengembalian', [SiswaController::class, 'indexPengembalian'])->name('pengembalian');
    Route::post('/pengembalian', [SiswaController::class, 'storePengembalian'])->name('pengembalian.store');
});
