<?php

use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// --- Halaman Publik ---
Route::get('/', [PublicController::class, 'beranda'])->name('beranda');
Route::get('/kegiatan', [PublicController::class, 'kegiatanIndex'])->name('kegiatan.index');
Route::get('/kegiatan/{kegiatan:slug}', [PublicController::class, 'kegiatanShow'])->name('kegiatan.show');

// --- Portal Warga ---
Route::get('/dashboard', [LayananController::class, 'dashboard'])
    ->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/layanan/keuangan', [LayananController::class, 'keuangan'])->name('layanan.keuangan');
    Route::get('/layanan/nomor-darurat', [LayananController::class, 'nomorDarurat'])->name('layanan.nomor-darurat');
    Route::get('/layanan/data-keluarga', [LayananController::class, 'dataKeluarga'])->name('layanan.data-keluarga');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
