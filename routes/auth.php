<?php

use Illuminate\Support\Facades\Route;

// Authentication Routes (Simplified for Laravel Breeze)
Route::middleware('guest')->group(function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('register', function () {
        return view('auth.register');
    })->name('register');

    Route::get('forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::get('reset-password/{request}', function ($request) {
        return view('auth.reset-password', ['request' => $request]);
    })->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');
});
