<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\MatchSuggestionController;
use App\Http\Controllers\KomoditiController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('penawaran', PenawaranController::class);
    Route::resource('permintaan', PermintaanController::class);
    Route::patch('/penawaran/{penawaran}/status', [PenawaranController::class, 'updateStatus'])->name('penawaran.updateStatus');
    Route::patch('/permintaan/{permintaan}/status', [PermintaanController::class, 'updateStatus'])->name('permintaan.updateStatus');

    Route::get('/komoditi/usulkan', [KomoditiController::class, 'usulkan'])->name('komoditi.usulkan');
    Route::post('/komoditi/usulkan', [KomoditiController::class, 'simpanUsulan'])->name('komoditi.simpanUsulan');

    Route::get('/match', [MatchSuggestionController::class, 'index'])->name('match.index');
    Route::post('/match/jalankan', [MatchSuggestionController::class, 'jalankan'])->name('match.jalankan');
    Route::post('/match/{match}/approve', [MatchSuggestionController::class, 'approve'])->name('match.approve');
    Route::post('/match/{match}/tolak', [MatchSuggestionController::class, 'tolak'])->name('match.tolak');

    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('cabang', CabangController::class);
    });

    // Khusus Pusat/Admin - kelola master data
    Route::middleware(['role:Pusat|Admin'])->group(function () {
        Route::get('/komoditi', [KomoditiController::class, 'index'])->name('komoditi.index');
        Route::post('/komoditi', [KomoditiController::class, 'store'])->name('komoditi.store');
        Route::patch('/komoditi/{komoditi}/approve', [KomoditiController::class, 'approve'])->name('komoditi.approve');
        Route::patch('/komoditi/{komoditi}/tolak', [KomoditiController::class, 'tolak'])->name('komoditi.tolak');
    });
});

require __DIR__ . '/auth.php';
