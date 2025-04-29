<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            // If we get here during a Filament request but user is logged in as admin via web guard
            // redirect to admin login
            if ($request->is('admin*')) {
                return redirect()->route('login');
            }
            
            abort(403, 'Unauthorized action. Admin access required.');
        }

        return $next($request);
    }
}
