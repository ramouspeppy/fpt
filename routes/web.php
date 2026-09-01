<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\MatchSuggestionController;
use App\Http\Controllers\KomoditiController;
use App\Http\Controllers\KomoditiSizeController;
use App\Http\Controllers\ProjectController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
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

    // Usulan size - bisa diakses semua role (termasuk Cabang), sama polanya dengan usulan komoditi
    Route::get('/komoditi/{komoditi}/size/usulkan', [KomoditiSizeController::class, 'usulkan'])->name('komoditi.size.usulkan');
    Route::post('/komoditi/{komoditi}/size/usulkan', [KomoditiSizeController::class, 'simpanUsulan'])->name('komoditi.size.simpanUsulan');

    Route::get('/match', [MatchSuggestionController::class, 'index'])->name('match.index');
    Route::get('/match/{match}', [MatchSuggestionController::class, 'show'])->name('match.show');
    Route::post('/match/jalankan', [MatchSuggestionController::class, 'jalankan'])->name('match.jalankan');
    // v9: approve/tolak diganti "pilih" - Pusat/Admin memilih kandidat jadi Project.
    // Berlaku untuk SEMUA match (Lokal & Ekspor), tidak ada beda jalur lagi.
    Route::post('/match/{match}/pilih', [MatchSuggestionController::class, 'pilih'])
        ->middleware('role:Pusat|Admin')->name('match.pilih');

    // v9: menu Project - semua role bisa akses, tapi isinya difilter per role di controller
    Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');
    Route::patch('/project/{project}/status', [ProjectController::class, 'updateStatus'])->name('project.updateStatus');
    Route::post('/project/{project}/catatan', [ProjectController::class, 'storeCatatan'])->name('project.storeCatatan');

    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('cabang', CabangController::class);
    });

    // Khusus Pusat/Admin - kelola master data
    Route::middleware(['role:Pusat|Admin'])->group(function () {
        Route::get('/komoditi', [KomoditiController::class, 'index'])->name('komoditi.index');
        Route::post('/komoditi', [KomoditiController::class, 'store'])->name('komoditi.store');
        Route::patch('/komoditi/{komoditi}/approve', [KomoditiController::class, 'approve'])->name('komoditi.approve');
        Route::patch('/komoditi/{komoditi}/tolak', [KomoditiController::class, 'tolak'])->name('komoditi.tolak');

        // v9: kelola daftar size per komoditi
        Route::get('/komoditi/{komoditi}/size', [KomoditiSizeController::class, 'index'])->name('komoditi.size.index');
        Route::post('/komoditi/{komoditi}/size', [KomoditiSizeController::class, 'store'])->name('komoditi.size.store');
        Route::patch('/komoditi/{komoditi}/size/{size}/approve', [KomoditiSizeController::class, 'approve'])->name('komoditi.size.approve');
        Route::patch('/komoditi/{komoditi}/size/{size}/tolak', [KomoditiSizeController::class, 'tolak'])->name('komoditi.size.tolak');
    });
});

require __DIR__ . '/auth.php';
