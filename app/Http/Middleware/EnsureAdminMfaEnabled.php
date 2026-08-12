<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminMfaEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = Auth::guard('admin')->user();

        // Not logged in – let auth middleware handle it
        if (!$admin) {
            return $next($request);
        }

        // MFA not enabled for this admin – allow access
        if (!$admin->mfa_enabled) {
            return $next($request);
        }

        // MFA enabled AND already verified in this session – allow
        if (session()->has('admin_mfa_verified') && session('admin_mfa_verified') === true) {
            return $next($request);
        }

        // MFA required but not verified – store pending and redirect to challenge
        if (!session('mfa_pending_admin_id')) {
            session()->put('mfa_pending_admin_id', $admin->id);
            session()->put('mfa_intended_url', $request->url());
        }

        // Logout the partially authenticated admin to avoid inconsistent state
        Auth::guard('admin')->logout();

        return redirect()->route('admin.mfa.challenge');
    }
}
