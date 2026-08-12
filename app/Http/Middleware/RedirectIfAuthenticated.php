<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // Handle admin guard
            if ($guard === 'admin' && Auth::guard('admin')->check()) {
                // If admin is already logged in and trying to access admin auth pages
                if ($request->routeIs('admin.login.form') ||
                    $request->routeIs('admin.register.form') ||
                    $request->routeIs('admin.login') ||
                    $request->routeIs('admin.register') ||
                    $request->routeIs('admin.landing')) {
                    return redirect()->route('admin.dashboard');
                }
                // For other admin routes, allow access
                return $next($request);
            }

            // Handle default user guard
            if ($guard === null && Auth::guard('web')->check()) {
                // If user is logged in and trying to access user auth pages
                if ($request->routeIs('login') ||
                    $request->routeIs('register') ||
                    $request->routeIs('user.login.form') ||
                    $request->routeIs('user.register.form')) {
                    return redirect()->route('user.dashboard');
                }
                // For other user routes, allow access
                return $next($request);
            }
        }

        return $next($request);
    }
}
