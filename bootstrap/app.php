use App\Http\Middleware\AdminMiddleware; // এই লাইনটি যোগ করা হয়েছে
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
<<<<<<< HEAD
    ->withMiddleware(function (Middleware $middleware): void {
        // Register the 'admin' alias here
=======
    ->withMiddleware(function (Middleware $middleware) {
        // 'admin' নামে মিডলওয়্যারটি রেজিস্টার করা হলো
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da
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
        //
    })->create();
=======
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'is_woman' => \App\Http\Middleware\EnsureUserIsWoman::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
=======
use App\Http\Middleware\AdminMiddleware; // এই লাইনটি যোগ করা হয়েছে
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
<<<<<<< HEAD
    ->withMiddleware(function (Middleware $middleware): void {
        // Register the 'admin' alias here
=======
    ->withMiddleware(function (Middleware $middleware) {
        // 'admin' নামে মিডলওয়্যারটি রেজিস্টার করা হলো
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da
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
        //
    })->create();