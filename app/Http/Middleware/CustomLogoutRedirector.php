<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomLogoutRedirector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If this is a logout request, store the referer so we know where the user initiated logout from
        if ($request->is('logout') || $request->is('*/logout')) {
            // Get the referer URL
            $referer = $request->headers->get('referer');
            
            // Check if the referer contains '/admin/' to determine if logout was initiated from admin panel
            if ($referer && str_contains($referer, '/admin/')) {
                session(['logout_from_admin' => true]);
            } else {
                session(['logout_from_admin' => false]);
            }
        }
        
        return $next($request);
    }
}
