<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsWoman
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in AND gender = female
        if ($request->user() && $request->user()->gender === 'female') {
            return $next($request);
        }

        // Deny access for non-female or guests
        abort(403, 'Access denied. This forum is for women only.');
    }
}