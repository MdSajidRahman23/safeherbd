<<<<<<< HEAD
<?php
=======
﻿<?php
>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

<<<<<<< HEAD
// Import the specific middleware classes (Ensure they exist at this path)
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EnsureUserIsWoman; // Added for completeness

=======
>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
<<<<<<< HEAD
        health: '/up',
    )
    
    // Consolidate all middleware registration into a single block
    ->withMiddleware(function (Middleware $middleware) {
        // Register your middleware aliases here. 
        // এইখানে আপনার মিডলওয়্যার এলিয়াসগুলো রেজিস্টার করা হলো।
        $middleware->alias([
            'admin'    => AdminMiddleware::class,
            'is_woman' => EnsureUserIsWoman::class,
        ]);
        
        // Add any global or group middleware definitions here if needed
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle your application exceptions here
    })
    
    ->create();
=======
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'is_woman' => \App\Http\Middleware\EnsureUserIsWoman::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c
