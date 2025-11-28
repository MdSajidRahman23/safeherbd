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
        // চেক করবে ইউজার লগইন করা কি না এবং তার রোল 'admin' কি না
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // যদি অ্যাডমিন না হয়, তাকে ড্যাশবোর্ডে পাঠিয়ে দেবে
        return redirect('/dashboard');
    }
}