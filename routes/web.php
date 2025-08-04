<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LitmasController;

// Halaman welcome
Route::get('/', function () {
    return view('welcome');
});

// Auth bawaan Laravel
Auth::routes();

// Dashboard utama setelah login
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Semua fitur butuh login
Route::middleware(['auth'])->group(function() {
    // CRUD litmas (index, create, store, edit, update, delete)
    Route::resource('litmas', LitmasController::class);

    // Input capaian luaran
    Route::get('litmas/{id}/edit-luaran', [LitmasController::class, 'editLuaran'])->name('litmas.editLuaran');
    Route::post('litmas/{id}/update-luaran', [LitmasController::class, 'updateLuaran'])->name('litmas.updateLuaran');

    // Monitoring, filter, rekap Litmas
    Route::get('monitoring-litmas', [LitmasController::class, 'monitoring'])->name('litmas.monitoring');

    // Verifikasi capaian (VALIDASI PPM)
    Route::post('litmas/{id}/verifikasi', [LitmasController::class, 'verifikasi'])->name('litmas.verifikasi');
    // Dashboard grafik/statistik capaian Litmas
    Route::get('dashboard-litmas', [LitmasController::class, 'dashboard'])->name('litmas.dashboard');



});

// (Opsional) Halaman khusus role PPM
Route::get('/admin-area', function () {
    return 'Ini hanya bisa diakses role PPM';
})->middleware(['auth', 'role:ppm']);
