<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        // Check if it's an admin route
        if ($request->is('admin/*') || $request->is('admin')) {
            if ($request->expectsJson()) {
                return null;
            }
            // Store intended URL for redirect after login
            session()->put('admin.url.intended', $request->url());
            return route('admin.login.form'); // This points to your admin login view
        }

        // Default to user login for non-admin routes
        return $request->expectsJson() ? null : route('login');
    }
}
