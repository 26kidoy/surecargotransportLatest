<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // Lockout configuration
    const MAX_ATTEMPTS = 3;
    const LOCKOUT_MINUTES = 30;

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // Force HTTPS for form actions
        if (request()->secure() ||
            request()->server('HTTP_X_FORWARDED_PROTO') === 'https' ||
            request()->server('HTTP_X_FORWARDED_SSL') === 'on') {
            URL::forceScheme('https');
        }

        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        // Log the login attempt for debugging
        Log::info('Login attempt', [
            'mobile' => $request->input('mobile_number'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => session()->getId(),
            'secure' => $request->secure(),
            'server_proto' => $request->server('HTTP_X_FORWARDED_PROTO'),
        ]);

        // 1. Validate input
        $credentials = $request->validate([
            'mobile_number' => 'required|string|regex:/^09[0-9]{9}$/',
            'password'      => 'required|string',
        ]);

        $mobile = $credentials['mobile_number'];
        $attemptsKey = $this->getAttemptsKey($mobile);
        $lockoutKey = $this->getLockoutKey($mobile);

        // 2. Check if account is locked
        $lockoutUntil = Cache::get($lockoutKey);
        if ($lockoutUntil && Carbon::now()->timestamp < $lockoutUntil) {
            $remainingSeconds = $lockoutUntil - Carbon::now()->timestamp;
            return back()
                ->withErrors(['locked' => 'Too many failed attempts. Account is locked for ' . self::LOCKOUT_MINUTES . ' minutes.'])
                ->with('lockout_remaining', $remainingSeconds)
                ->with('last_login_mobile', $mobile)
                ->onlyInput('mobile_number');
        }

        // If lockout expired but stale attempts exist, clean them
        if (Cache::has($attemptsKey) && Cache::get($attemptsKey) >= self::MAX_ATTEMPTS) {
            Cache::forget($attemptsKey);
        }

        // 3. Attempt authentication
        if (Auth::attempt(
            ['mobile_number' => $mobile, 'password' => $credentials['password']],
            $request->filled('remember')
        )) {
            // Successful login – clear attempts and lockout
            Cache::forget($attemptsKey);
            Cache::forget($lockoutKey);
            $request->session()->regenerate();

            Log::info('Login successful', ['user' => $mobile, 'user_id' => Auth::id()]);

            return redirect()->intended(route('user.dashboard'));
        }

        // 4. Failed login – increment attempts
        $attempts = Cache::get($attemptsKey, 0);
        $attempts++;
        Cache::put($attemptsKey, $attempts, Carbon::now()->addMinutes(self::LOCKOUT_MINUTES));

        Log::warning('Login failed', ['mobile' => $mobile, 'attempts' => $attempts]);

        // 5. Check if lockout should be activated
        if ($attempts >= self::MAX_ATTEMPTS) {
            $lockoutUntil = Carbon::now()->addMinutes(self::LOCKOUT_MINUTES)->timestamp;
            Cache::put($lockoutKey, $lockoutUntil, Carbon::now()->addMinutes(self::LOCKOUT_MINUTES));
            Cache::forget($attemptsKey); // Clean attempts, lockout is enough

            Log::warning('Account locked', ['mobile' => $mobile]);

            return back()
                ->withErrors(['locked' => 'Too many failed attempts. Account locked for ' . self::LOCKOUT_MINUTES . ' minutes.'])
                ->with('lockout_remaining', self::LOCKOUT_MINUTES * 60)
                ->with('last_login_mobile', $mobile)
                ->onlyInput('mobile_number');
        }

        // 6. Warning for last attempt remaining (attempts == 2)
        $remainingAttempts = self::MAX_ATTEMPTS - $attempts;
        if ($remainingAttempts === 1) {
            return back()
                ->withErrors(['mobile_number' => 'The provided credentials do not match our records.'])
                ->with('last_attempt_warning', '⚠️ You have only 1 attempt left before your account is locked for 30 minutes.')
                ->with('last_login_mobile', $mobile)
                ->onlyInput('mobile_number');
        }

        // 7. Normal failure (attempts 1)
        return back()
            ->withErrors(['mobile_number' => 'The provided credentials do not match our records.'])
            ->with('last_login_mobile', $mobile)
            ->onlyInput('mobile_number');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Cache key for failed attempts.
     */
    private function getAttemptsKey($mobile)
    {
        return 'login_attempts_' . $mobile;
    }

    /**
     * Cache key for lockout timestamp.
     */
    private function getLockoutKey($mobile)
    {
        return 'login_lockout_' . $mobile;
    }
}
