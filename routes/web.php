<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SosController;
use App\Http\Controllers\Admin\SosHistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SOS Alert routes
    Route::post('/sos', [SosController::class, 'store'])->name('sos.store');
});

// Admin routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/sos-history', [SosHistoryController::class, 'index'])->name('sos.history');
});

require __DIR__.'/auth.php';
