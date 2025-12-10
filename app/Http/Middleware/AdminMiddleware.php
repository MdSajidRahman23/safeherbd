<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
<<<<<<< HEAD
        // Check if user is logged in AND is an admin
=======
        // চেক করবে ইউজার লগইন করা কি না এবং তার রোল 'admin' কি না
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

<<<<<<< HEAD
        // If not admin, redirect to home with error
        return redirect('/')->with('error', 'You do not have admin access.');
=======
        // যদি অ্যাডমিন না হয়, তাকে ড্যাশবোর্ডে পাঠিয়ে দেবে
        return redirect('/dashboard');
>>>>>>> 54195fc8fc0e0078b24d4161d9e0e322fa93f6da
    }
}