<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login.form');
        }

        // If no specific roles are required, just allow
        if (empty($roles)) {
            return $next($request);
        }

        // Check if admin's role is in the allowed list
        if (in_array($admin->role, $roles)) {
            return $next($request);
        }

        // Unauthorized – redirect to dashboard or show 403
        abort(403, 'You do not have permission to access this page.');
    }
}
