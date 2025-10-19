<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated AND has the 'admin' role
        // *** ADJUST THE CONDITION BELOW based on your User model ***
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // If not an admin, redirect them or show an error
            abort(403, 'Unauthorized access.'); // 403 Forbidden is standard
            // Or redirect: return redirect('/')->with('error', 'Access Denied.');
        }

        // If user is admin, allow the request to proceed
        return $next($request);
    }
}