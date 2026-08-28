<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\MatchSuggestionController;
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

    Route::get('/match', [MatchSuggestionController::class, 'index'])->name('match.index');
    Route::post('/match/jalankan', [MatchSuggestionController::class, 'jalankan'])->name('match.jalankan');
    Route::post('/match/{match}/approve', [MatchSuggestionController::class, 'approve'])->name('match.approve');
    Route::post('/match/{match}/tolak', [MatchSuggestionController::class, 'tolak'])->name('match.tolak');

    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('cabang', CabangController::class);
    });
});

require __DIR__ . '/auth.php';
