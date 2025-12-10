<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\SafeRouteController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\SOSAlert;
use Illuminate\Http\Request;

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
    Route::resource('safe-routes', SafeRouteController::class)->names([
        'index' => 'admin.safe-routes.index',
        'create' => 'admin.safe-routes.create',
        'store' => 'admin.safe-routes.store',
        'edit' => 'admin.safe-routes.edit',
        'update' => 'admin.safe-routes.update',
        'destroy' => 'admin.safe-routes.destroy',
    ]);
});

/*
|--------------------------------------------------------------------------
| Public & User Routes
|--------------------------------------------------------------------------
*/

// Redirect root URL to Login
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'is_woman'])->group(function () {
    // women-only routes
});

// SOS Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $alerts = App\Models\SOSAlert::with('user')->latest()->get();
        return view('admin_dashboard', ['alerts' => $alerts]);
    })->name('admin.dashboard');

    Route::get('/safe-routes', function () {
        return view('sos'); 
    })->name('safe-routes.index');

    Route::post('/safe-routes/store', function (Request $request) {
        SOSAlert::create([
            'user_id' => auth()->id(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'pending',
            'message' => 'Emergency Alert!',
        ]);
        return response()->json(['success' => true]);
    })->name('safe-routes.store');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Women-only forum routes
Route::middleware(['auth', 'is_woman'])->group(function () {
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum/store', [ForumController::class, 'store'])->name('forum.store');
    Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');
    Route::post('/forum/reply/{id}', [ForumController::class, 'storeReply'])->name('forum.reply');
    Route::post('/forum/report/{id}', [ForumController::class, 'reportPost'])->name('forum.report');
});

require __DIR__.'/auth.php';
