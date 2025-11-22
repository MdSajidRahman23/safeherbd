<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SafeRouteController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/safe-routes', [SafeRouteController::class, 'index'])->name('safe-routes.index');
    Route::get('/safe-routes/create', [SafeRouteController::class, 'create'])->name('safe-routes.create');
    Route::post('/safe-routes', [SafeRouteController::class, 'store'])->name('safe-routes.store');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
