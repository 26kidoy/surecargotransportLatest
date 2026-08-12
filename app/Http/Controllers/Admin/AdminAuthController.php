<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class AdminAuthController extends Controller
{
    // Lockout settings
    protected $maxAttempts = 3;
    protected $lockoutMinutes = 30;

    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            if ($admin->role === 'fleet_manager') {
                return redirect()->route('admin.bookings.index');
            }
            return redirect()->route('admin.dashboard');
        }

        // Check for active lockout and pass remaining seconds to view
        $email = old('email');
        $lockoutRemaining = null;
        if ($email && $this->isLockedOut($email)) {
            $lockoutRemaining = $this->getLockoutRemaining($email);
        }

        return view('admin.auth.login', compact('lockoutRemaining'));
    }

    /**
     * Show the admin registration form.
     */
    public function showRegisterForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.register');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $email = $credentials['email'];

        // Clear any old session warnings
        session()->forget(['last_attempt_warning', 'lockout_remaining']);

        // 1. Check if the account is locked out
        if ($this->isLockedOut($email)) {
            $remainingSeconds = $this->getLockoutRemaining($email);
            session()->put('lockout_remaining', $remainingSeconds);
            return back()->withErrors([
                'email' => "Too many failed attempts. Please try again after {$this->lockoutMinutes} minutes."
            ])->onlyInput('email');
        }

        // 2. Attempt authentication
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            /** @var Admin $admin */
            $admin = Auth::guard('admin')->user();

            // Clear failed attempts on successful password verification
            $this->clearLoginAttempts($email);
            session()->forget(['last_attempt_warning', 'lockout_remaining']);

            // ✅ MFA enabled → store pending ID, logout partially, redirect to challenge
            if ($admin->mfa_enabled) {
                $intendedUrl = $admin->role === 'fleet_manager'
                    ? route('admin.bookings.index')
                    : route('admin.dashboard');

                Auth::guard('admin')->logout();
                session()->put('mfa_pending_admin_id', $admin->id);
                session()->put('mfa_intended_url', $intendedUrl);
                return redirect()->route('admin.mfa.challenge');
            }

            // No MFA → complete login normally
            $admin->update(['last_login_at' => now()]);
            session()->put('admin_mfa_verified', true);
            $request->session()->regenerate();

            if ($admin->role === 'fleet_manager') {
                return redirect()->route('admin.bookings.index');
            }

            $intendedUrl = session()->pull('admin.url.intended');
            return $intendedUrl ? redirect()->to($intendedUrl) : redirect()->route('admin.dashboard');
        }

        // 3. Authentication failed → increment failed attempts
        $this->incrementLoginAttempts($email);
        $remainingAttempts = $this->getRemainingAttempts($email);

        // 4. Set last attempt warning if only 1 attempt left
        if ($remainingAttempts === 1) {
            session()->flash('last_attempt_warning', '⚠️ Warning: This is your last attempt before a 30-minute lockout!');
        }

        // 5. Check if lockout has been triggered
        if ($this->hasReachedMaxAttempts($email)) {
            $this->lockout($email);
            $remainingSeconds = $this->getLockoutRemaining($email);
            session()->put('lockout_remaining', $remainingSeconds);
            return back()->withErrors([
                'email' => "Too many failed attempts. Your account is locked for {$this->lockoutMinutes} minutes."
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => "Invalid credentials. You have {$remainingAttempts} attempt(s) remaining before a {$this->lockoutMinutes}-minute lockout."
        ])->onlyInput('email');
    }

    /**
     * Handle admin registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_active'=> true,
            'role'     => 'admin',
        ]);

        Auth::guard('admin')->login($admin);
        $admin->update(['last_login_at' => now()]);
        session()->put('admin_mfa_verified', true);
        session()->forget(['last_attempt_warning', 'lockout_remaining']);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Logout the admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget(['admin_mfa_verified', 'mfa_pending_admin_id', 'mfa_intended_url', 'admin.url.intended', 'last_attempt_warning', 'lockout_remaining']);
        return redirect()->route('admin.login.form');
    }

    // ------------------------------------------------------------------
    // Lockout helper methods
    // ------------------------------------------------------------------

    protected function attemptsCacheKey($email)
    {
        return 'admin_login_attempts_' . strtolower($email);
    }

    protected function lockoutCacheKey($email)
    {
        return 'admin_login_lockout_' . strtolower($email);
    }

    protected function isLockedOut($email)
    {
        return Cache::has($this->lockoutCacheKey($email));
    }

    protected function incrementLoginAttempts($email)
    {
        $key = $this->attemptsCacheKey($email);
        $attempts = Cache::get($key, 0);
        Cache::put($key, $attempts + 1, now()->addMinutes($this->lockoutMinutes));
    }

    protected function clearLoginAttempts($email)
    {
        Cache::forget($this->attemptsCacheKey($email));
    }

    protected function hasReachedMaxAttempts($email)
    {
        $attempts = Cache::get($this->attemptsCacheKey($email), 0);
        return $attempts >= $this->maxAttempts;
    }

    protected function getRemainingAttempts($email)
    {
        $attempts = Cache::get($this->attemptsCacheKey($email), 0);
        return max(0, $this->maxAttempts - $attempts);
    }

    protected function lockout($email)
    {
        Cache::put($this->lockoutCacheKey($email), true, now()->addMinutes($this->lockoutMinutes));
    }

    protected function getLockoutRemaining($email)
    {
        $lockoutUntil = Cache::get($this->lockoutCacheKey($email));
        if (!$lockoutUntil) return 0;
        // Since we store a simple boolean, we need to calculate from the TTL
        $cacheStore = Cache::store();
        $ttl = $cacheStore->ttl($this->lockoutCacheKey($email));
        return max(0, $ttl);
    }
}
