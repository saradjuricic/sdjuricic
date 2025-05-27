<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Redirect to login with intended URL
            return redirect()->guest(route('login'));
        }

        $user = Auth::user();

        // Check if user object exists and has role property
        if (!$user || !isset($user->role)) {
            abort(403, 'User role not found.');
        }

        // Check if user has the required role
        if ($user->role !== $role) {
            // You can customize this based on the role
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            
            abort(403, "Access denied. This area requires '{$role}' role.");
        }

        return $next($request);
    }
}