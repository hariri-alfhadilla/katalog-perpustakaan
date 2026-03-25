<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Group khusus Admin (Wajib Login & Role Admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('buku', BukuController::class);
    Route::resource('anggota', AnggotaController::class)->only(['index', 'destroy']);
    Route::get('/admin/peminjaman', [PeminjamanController::class, 'adminIndex'])->name('admin.peminjaman');
    Route::put('/admin/peminjaman/{id}/terima', [App\Http\Controllers\PeminjamanController::class, 'terima'])->name('peminjaman.terima');
    Route::put('/admin/peminjaman/{id}/tolak', [App\Http\Controllers\PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');  
});

// Group Khusus Peminjaman (Bisa diakses User/Siswa)
Route::middleware(['auth'])->group(function () {
    Route::post('/pinjam/{id}', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    // Halaman Peminjaman Saya
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    
    // Aksi Kembalikan Buku
    Route::post('/kembalikan/{id}', [PeminjamanController::class, 'returnBook'])->name('peminjaman.return');
});

require __DIR__.'/auth.php';