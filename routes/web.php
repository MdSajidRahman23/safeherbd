<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SosController;
use App\Http\Controllers\Admin\SosHistoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

<<<<<<< HEAD
// forum routes
Route::middleware(['auth', 'is_woman'])->group(function () {
// Forum Index
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');

    // Post Create (GET & POST)
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');

    // Post View
    Route::get('/forum/{post}', [ForumController::class, 'show'])->name('forum.show');

    // Post Edit & Update (Model binding এর জন্য {post} ব্যবহার করুন)
    Route::get('/forum/{post}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::put('/forum/{post}', [ForumController::class, 'update'])->name('forum.update');
    
    // Post Delete
    Route::delete('/forum/{post}', [ForumController::class, 'destroy'])->name('forum.destroy');

    // Post Report
    Route::post('/forum/{post}/report', [ForumController::class, 'reportPost'])->name('forum.report.store');
    
    // Reply Store
    Route::post('/forum/{post}/reply', [ForumController::class, 'storeReply'])->name('forum.reply.store');

    // Reply Delete
    Route::delete('/replies/{reply}', [ForumController::class, 'destroyReply'])->name('forum.reply.destroy');
=======
// SOS route for authenticated users
Route::post('/sos', [SosController::class, 'store'])->middleware('auth')->name('sos.store');

// Admin area
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/sos-history', [SosHistoryController::class, 'index'])->name('sos-history');
>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c
});

require __DIR__.'/auth.php';
