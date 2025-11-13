<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfRole
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role !== $role) {
            return redirect('/'); // অথবা অন্য কোন পেজ
        }

        return $next($request);
    }
}

