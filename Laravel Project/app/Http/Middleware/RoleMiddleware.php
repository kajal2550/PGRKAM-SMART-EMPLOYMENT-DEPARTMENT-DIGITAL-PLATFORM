<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * RoleMiddleware – checks if the authenticated user has the required role.
 *
 * Usage in routes:  Route::middleware('role:admin')
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || $request->user()->role !== $role) {
            // API requests get JSON, web requests get redirect
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Forbidden – insufficient permissions'], 403);
            }
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
