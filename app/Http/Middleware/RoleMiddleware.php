<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Check if user has the required role
        if (!$user->hasRole($role) && $role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        // If role is 'admin', check for admin or superadmin
        if ($role === 'admin' && !$user->hasRole('admin') && !$user->hasRole('superadmin')) {
            // Redirect regular users to their dashboard
            return redirect('/user/dashboard')->with('error', 'Access denied. You do not have admin privileges.');
        }

        return $next($request);
    }
}
