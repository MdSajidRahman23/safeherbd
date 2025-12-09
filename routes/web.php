<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\SOSAlert; // <--- ১. এই লাইনটি আগে ছিল না, তাই সেভ হচ্ছিল না
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes (Final Setup)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
