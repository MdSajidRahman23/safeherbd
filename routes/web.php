<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\SOSAlert; // <--- ১. এই লাইনটি আগে ছিল না, তাই সেভ হচ্ছিল না
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
<<<<<<< HEAD
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
=======
| Web Routes (Final Setup)
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da
|--------------------------------------------------------------------------
*/

// Redirect root URL to Login (Optional: You can change this to view('welcome') if you prefer)
Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
// User Dashboard (Normal Users)
=======
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

<<<<<<< HEAD
=======
Route::middleware(['auth', 'is_woman'])->group(function () {
    // women-only routes
});


// Admin & SOS Routes
Route::middleware(['auth', 'admin'])->group(function () {
    
    Route::get('/admin/dashboard', function () {
        $alerts = App\Models\SOSAlert::with('user')->latest()->get();
        
        return view('admin_dashboard', ['alerts' => $alerts]);
    })->name('admin.dashboard');

    // SOS Page Show
    Route::get('/safe-routes', function () {
        return view('sos'); 
    })->name('safe-routes.index');

    // SOS Data Save (REAL LOGIC)
    Route::post('/safe-routes/store', function (Request $request) {
        
        // ২. ডাটাবেজে সেভ করা হচ্ছে
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

>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da
// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Women-only 
Route::middleware(['auth', 'is_woman'])->group(function () {
    Route::get('/forum', [ForumController::class, 'index']);
    Route::post('/forum/post', [ForumController::class, 'store']);
    Route::post('/forum/{post}/reply', [ForumController::class, 'reply']);
});

<<<<<<< HEAD
require __DIR__.'/auth.php';
=======
// women-only forum routes
Route::middleware(['auth', 'is_woman'])->group(function () {
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum/store', [ForumController::class, 'store'])->name('forum.store');
    Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');
    Route::post('/forum/reply/{id}', [ForumController::class, 'storeReply'])->name('forum.reply');
    Route::post('/forum/report/{id}', [ForumController::class, 'reportPost'])->name('forum.report');
});
require __DIR__.'/auth.php';
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da
