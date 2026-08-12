<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip middleware for login/register routes to prevent redirect loops
        $excludedRoutes = ['admin.login.form', 'admin.login', 'admin.register.form', 'admin.register', 'admin.landing'];

        if (in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }

        // Check if admin is logged in
        if (!Auth::guard('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            // Store the intended URL for admin
            session()->put('admin.url.intended', $request->url());

            return redirect()->route('admin.login.form')
                ->with('error', 'Please login to access admin panel.');
        }

        // Check if admin account is active
        $admin = Auth::guard('admin')->user();

        if (!$admin || !$admin->is_active) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Account deactivated'], 403);
            }

            session()->forget('admin.url.intended');

            return redirect()->route('admin.login.form')
                ->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}
