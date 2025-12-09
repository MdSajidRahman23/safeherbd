<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SosController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->post('/sos/alert', [SosController::class, 'store'])->name('sos.store');

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [SosController::class, 'index'])->name('admin.dashboard');

});

Route::middleware(['auth', 'role:user'])->get('/dashboard', function () {
    return view('dashboard');
})->name('user.dashboard');