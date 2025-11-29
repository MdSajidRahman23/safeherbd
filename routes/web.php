<?php

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

// Admin & SOS Routes
Route::middleware(['auth', 'admin'])->group(function () {
    
    Route::get('/admin/dashboard', function () {
        return view('dashboard'); 
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

require __DIR__.'/auth.php';
