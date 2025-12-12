<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SosController;
use App\Http\Controllers\Admin\SosHistoryController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Admin\SafeRouteController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-dashboard', function () {
    return '<!DOCTYPE html><html><head><title>Test</title></head><body><h1>Test Dashboard</h1><p>Basic HTML works.</p></body></html>';
})->name('test-dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Forum routes - Women only
Route::middleware(['auth', 'is_woman'])->group(function () {
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::get('/forum/{post}', [ForumController::class, 'show'])->name('forum.show');
    Route::get('/forum/{post}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::put('/forum/{post}', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{post}', [ForumController::class, 'destroy'])->name('forum.destroy');
    Route::post('/forum/{post}/report', [ForumController::class, 'reportPost'])->name('forum.report.store');
    Route::post('/forum/{post}/reply', [ForumController::class, 'storeReply'])->name('forum.reply.store');
    Route::delete('/replies/{reply}', [ForumController::class, 'destroyReply'])->name('forum.reply.destroy');
});

// Chatbot routes - Authenticated users
Route::middleware('auth')->prefix('chatbot')->name('chatbot.')->group(function () {
    Route::get('/', [ChatbotController::class, 'index'])->name('index');
    Route::post('/send-message', [ChatbotController::class, 'sendMessage'])->name('send-message');
    Route::get('/history', [ChatbotController::class, 'getHistory'])->name('history');
    Route::post('/clear-history', [ChatbotController::class, 'clearHistory'])->name('clear-history');
});

// Safe Routes - Public view, admin management
Route::middleware('auth')->prefix('safe-routes')->name('safe-routes.')->group(function () {
    Route::get('/', [RouteController::class, 'index'])->name('index');
    Route::post('/report', [RouteController::class, 'reportUnsafeSpot'])->name('report');
});

// SOS route for authenticated users
Route::post('/sos', [SosController::class, 'store'])->middleware('auth')->name('sos.store');

// User SOS History
Route::get('/my-sos-history', [SosController::class, 'history'])->middleware('auth')->name('my-sos-history');

// Admin area



Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'usersIndex'])->name('index');
        Route::post('/{id}/block', [AdminController::class, 'blockUser'])->name('block');
        Route::post('/{id}/unblock', [AdminController::class, 'unblockUser'])->name('unblock');
        Route::delete('/{id}', [AdminController::class, 'destroyUser'])->name('destroy');
    });

    // SOS History
    Route::get('/sos-history', [SosHistoryController::class, 'index'])->name('sos-history');
    Route::post('/alerts/{id}/update-status', function ($id) {
        $alert = \App\Models\SosAlert::find($id);
        if ($alert && request('status')) {
            $alert->update(['status' => request('status')]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    })->name('alerts.update-status');

    // Safe Routes Management (Alternative AdminController method)
    Route::prefix('safe-routes')->name('safe-routes.')->group(function () {

        Route::get('/', [SafeRouteController::class, 'index'])->name('index');
        Route::get('/create', [SafeRouteController::class, 'create'])->name('create');
        Route::post('/', [SafeRouteController::class, 'store'])->name('store');
        Route::get('/{safeRoute}/edit', [SafeRouteController::class, 'edit'])->name('edit');
        Route::put('/{safeRoute}', [SafeRouteController::class, 'update'])->name('update');
        Route::delete('/{safeRoute}', [SafeRouteController::class, 'destroy'])->name('destroy');
    });

    // Reports Management
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [AdminController::class, 'reportsIndex'])->name('index');
        Route::post('/{id}/update-status', [AdminController::class, 'updateReportStatus'])->name('update-status');
        Route::delete('/{id}', [AdminController::class, 'destroyReport'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
