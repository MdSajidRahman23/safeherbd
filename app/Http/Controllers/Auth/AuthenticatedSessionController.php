<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

<<<<<<< HEAD
        if ($request->user()->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
=======
        // Redirect based on role: admin -> admin dashboard, user -> dashboard
        $user = $request->user();
        if ($user && ($user->role === 'admin' || $user->is_admin)) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}