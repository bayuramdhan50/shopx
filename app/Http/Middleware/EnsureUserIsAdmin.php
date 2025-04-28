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
        // First check web guard
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }
        
        // Then check filament guard if previous check failed
        if (Auth::guard('filament')->check() && Auth::guard('filament')->user()->is_admin) {
            return $next($request);
        }

        abort(403, 'Unauthorized action. Admin access required.');
    }
}
