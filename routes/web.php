<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SafeRouteController;

/*
|--------------------------------------------------------------------------
| Admin Routes (My Main Work)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // 1. Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // 2. User Management
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
    Route::patch('/users/{id}/block', [AdminController::class, 'toggleBlock'])->name('admin.users.block');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.delete');

    // 3. Safe Route Management (Zahin's Feature, managed by Admin)
    Route::get('/safe-routes', [SafeRouteController::class, 'index'])->name('admin.routes.index');
    Route::get('/safe-routes/create', [SafeRouteController::class, 'create'])->name('safe-routes.create');
    Route::post('/safe-routes', [SafeRouteController::class, 'store'])->name('safe-routes.store');
});

/*
|--------------------------------------------------------------------------
| Public & User Routes
|--------------------------------------------------------------------------
*/

// Redirect root URL to Login (Optional: You can change this to view('welcome') if you prefer)
Route::get('/', function () {
    return view('welcome');
});

// User Dashboard (Normal Users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';