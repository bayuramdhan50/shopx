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

        // Check if user is an admin
        if (auth()->user()->is_admin) {
            return redirect('/admin'); // Direct path to admin panel
        }

        // Redirect non-admin users to the home page
        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Check if the user was an admin
        $wasAdmin = Auth::user() && Auth::user()->is_admin;
        
        // Check if logout is initiated from admin panel
        $isFromAdmin = str_contains($request->path(), 'admin');
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // If the user was an admin or request came from admin section, redirect to login page
        if ($wasAdmin || $isFromAdmin) {
            return redirect()->route('login');
        }
        
        // Otherwise redirect to home
        return redirect('/');
    }
}
