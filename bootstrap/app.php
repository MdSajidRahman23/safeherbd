<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; D

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
       
    ->withMiddleware(function (Middleware $middleware) {
        // 'admin' নামে মিডলওয়্যারটি রেজিস্টার করা হলো
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'is_woman' => \App\Http\Middleware\EnsureUserIsWoman::class, ]);
    })


    ->withExceptions(function (Exceptions $exceptions): void {
    ->withExceptions(function (Exceptions $exceptions) {
        
    })->create();