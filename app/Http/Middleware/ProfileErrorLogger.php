<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ProfileErrorLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply to profile-related routes
        $routeName = Route::currentRouteName();
        if (in_array($routeName, ['profile.edit', 'profile.update'])) {
            // Log the request for profile routes
            if ($routeName === 'profile.update') {
                Log::info('Profile update request received', [
                    'user_id' => $request->user()->id,
                    'route' => $routeName,
                    'method' => $request->method(),
                    'fields' => array_keys($request->except(['_token', '_method', 'password', 'current_password', 'password_confirmation']))
                ]);
            }
        }
        
        // Process the request
        $response = $next($request);
        
        // Check if there were validation errors in the profile update
        if ($routeName === 'profile.update' && $response->isRedirection() && session()->has('errors')) {
            Log::warning('Profile update validation failed', [
                'user_id' => $request->user()->id,
                'errors' => session()->get('errors')->getBag('default')->toArray()
            ]);
        }
        
        return $response;
    }
}
