<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Carbon\Carbon;

class MfaController extends Controller
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
        // Set the correct timezone
        date_default_timezone_set(config('app.timezone', 'Asia/Manila'));
    }

    // ------------------------------------------------------------------
    // MFA Setup & Enable
    // ------------------------------------------------------------------

    public function showSetupForm()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin->mfa_enabled) {
            return redirect()->route('admin.dashboard')->with('info', 'MFA is already enabled.');
        }

        if (!$admin->google2fa_secret) {
            $secret = $this->google2fa->generateSecretKey();
            $admin->google2fa_secret = $secret;

            $plainCodes = [];
            $hashedCodes = [];
            for ($i = 0; $i < 8; $i++) {
                $plain = strtoupper(substr(md5(uniqid()), 0, 16));
                $plainCodes[] = $plain;
                $hashedCodes[] = Hash::make($plain);
            }
            $admin->recovery_codes = $hashedCodes;
            $admin->save();

            session()->flash('recovery_codes', $plainCodes);
            Log::info('MFA setup: new secret and recovery codes generated for admin', ['admin_id' => $admin->id]);
        } else {
            session()->flash('warning', 'Recovery codes were already generated. If you lost them, contact a super admin.');
        }

        $secret = $admin->google2fa_secret;
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(config('app.name'), $admin->email, $secret);

        $renderer = new ImageRenderer(new RendererStyle(200), new SvgImageBackEnd());
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($qrCodeUrl);

        return view('admin.auth.mfa-setup', [
            'qrCode'       => $qrCode,
            'secret'       => $secret,
            'recoveryCodes' => session()->get('recovery_codes', [])
        ]);
    }

    public function enableMfa(Request $request)
    {
        $request->validate(['verify_code' => 'required|string|size:6']);
        $admin = Auth::guard('admin')->user();

        if ($admin->mfa_enabled) {
            return redirect()->route('admin.dashboard')->with('info', 'MFA is already enabled.');
        }

        $secret = $admin->google2fa_secret;
        if (!$secret) {
            Log::warning('MFA enable failed: no secret found for admin', ['admin_id' => $admin->id]);
            return redirect()->route('admin.mfa.setup')->withErrors(['verify_code' => 'No secret key found. Please refresh the page.']);
        }

        $valid = $this->google2fa->verifyKey($secret, $request->verify_code);
        if (!$valid) {
            $valid = $this->google2fa->verifyKey($secret, $request->verify_code, 1);
        }

        if (!$valid) {
            Log::warning('MFA enable failed: invalid code', [
                'admin_id' => $admin->id,
                'input_code' => $request->verify_code,
                'expected_current' => $this->google2fa->getCurrentOtp($secret)
            ]);
            return back()->withErrors(['verify_code' => 'Invalid code. Make sure your authenticator app time is synced.']);
        }

        $admin->mfa_enabled = true;
        $admin->save();

        session()->put('admin_mfa_verified', true);
        $request->session()->regenerate();

        Log::info('MFA enabled successfully', ['admin_id' => $admin->id]);

        return redirect()->route('admin.dashboard')->with('success', 'MFA enabled successfully! Next time you log in, you will need to enter a code from your authenticator app.');
    }

    // ------------------------------------------------------------------
    // MFA Challenge & Lockout Logic
    // ------------------------------------------------------------------

    protected function mfaAttemptsKey($adminId)
    {
        return 'mfa_attempts_' . $adminId;
    }

    protected function mfaLockoutKey($adminId)
    {
        return 'mfa_lockout_' . $adminId;
    }

    protected function isMfaLockedOut($adminId)
    {
        $lockoutUntil = Cache::get($this->mfaLockoutKey($adminId));
        return $lockoutUntil && Carbon::now()->lessThan($lockoutUntil);
    }

    protected function getMfaRemainingAttempts($adminId)
    {
        $attempts = Cache::get($this->mfaAttemptsKey($adminId), 0);
        return max(0, 3 - $attempts);
    }

    protected function recordFailedMfaAttempt($adminId)
    {
        $attemptsKey = $this->mfaAttemptsKey($adminId);
        $attempts = Cache::get($attemptsKey, 0);
        $attempts++;

        if ($attempts >= 3) {
            Cache::put($this->mfaLockoutKey($adminId), Carbon::now()->addMinutes(30), 30);
            Cache::forget($attemptsKey);
            Log::warning('MFA lockout triggered', ['admin_id' => $adminId]);
            return true;
        }

        Cache::put($attemptsKey, $attempts, now()->addMinutes(30));
        return false;
    }

    protected function resetMfaAttempts($adminId)
    {
        Cache::forget($this->mfaAttemptsKey($adminId));
        Cache::forget($this->mfaLockoutKey($adminId));
    }

    // ------------------------------------------------------------------
    // Show Challenge Form
    // ------------------------------------------------------------------

    public function showChallengeForm()
    {
        if (!session('mfa_pending_admin_id')) {
            return redirect()->route('admin.login.form');
        }

        $adminId = session('mfa_pending_admin_id');
        $lockoutEnd = Cache::get($this->mfaLockoutKey($adminId));
        $remainingAttempts = $this->getMfaRemainingAttempts($adminId);

        return view('admin.auth.mfa-challenge', [
            'lockoutEnd'        => $lockoutEnd,
            'remainingAttempts' => $remainingAttempts,
        ]);
    }

    // ------------------------------------------------------------------
    // Verify OTP - FIXED with timezone handling
    // ------------------------------------------------------------------

    public function verifyOtp(Request $request)
    {
        $request->validate(['one_time_password' => 'required|string|size:6']);
        $adminId = session('mfa_pending_admin_id');
        if (!$adminId) {
            Log::error('MFA verify: no pending admin ID in session');
            return redirect()->route('admin.login.form');
        }

        if ($this->isMfaLockedOut($adminId)) {
            $lockoutEnd = Cache::get($this->mfaLockoutKey($adminId));
            $minutesRemaining = Carbon::now()->diffInMinutes($lockoutEnd);
            Log::warning('MFA verify blocked by lockout', ['admin_id' => $adminId, 'minutes_remaining' => $minutesRemaining]);
            return back()->with('error', "Too many failed attempts. Please wait {$minutesRemaining} minutes before trying again.");
        }

        $admin = Admin::findOrFail($adminId);
        $secret = $admin->google2fa_secret;

        if (empty($secret)) {
            Log::error('MFA verify: no secret found for admin', ['admin_id' => $adminId]);
            return back()->with('error', 'MFA not set up correctly. Please contact support.');
        }

        // Get current time in Manila timezone
        $manilaTime = Carbon::now('Asia/Manila');

        Log::info('MFA verification attempt', [
            'admin_id' => $adminId,
            'input_otp' => $request->one_time_password,
            'secret_preview' => substr($secret, 0, 6) . '...',
            'server_time' => Carbon::now()->toDateTimeString(),
            'manila_time' => $manilaTime->toDateTimeString(),
            'timezone' => config('app.timezone'),
            'server_timezone' => date_default_timezone_get(),
        ]);

        // Try verification with timezone adjustment
        $valid = false;
        $windowUsed = 0;

        // Try with default
        $valid = $this->google2fa->verifyKey($secret, $request->one_time_password);

        // If failed, try with wider window
        if (!$valid) {
            $valid = $this->google2fa->verifyKey($secret, $request->one_time_password, 1);
            $windowUsed = 1;
        }

        if (!$valid) {
            $valid = $this->google2fa->verifyKey($secret, $request->one_time_password, 2);
            $windowUsed = 2;
        }

        // Additional check: try with timestamp offset (for timezone issues)
        if (!$valid) {
            // Try with current timestamp in Manila timezone
            $timestamp = $manilaTime->timestamp;
            $valid = $this->verifyKeyWithTimestamp($secret, $request->one_time_password, $timestamp);
            if ($valid) {
                $windowUsed = 3;
                Log::info('MFA verified using Manila timezone timestamp', ['admin_id' => $adminId]);
            }
        }

        $currentOtp = $this->google2fa->getCurrentOtp($secret);
        $previousOtp = $this->google2fa->getCurrentOtp($secret, -1);
        $nextOtp = $this->google2fa->getCurrentOtp($secret, 1);

        Log::debug('Server OTP values', [
            'current_step' => $currentOtp,
            'previous_step' => $previousOtp,
            'next_step' => $nextOtp
        ]);

        if (!$valid) {
            $lockoutTriggered = $this->recordFailedMfaAttempt($adminId);
            $remaining = $this->getMfaRemainingAttempts($adminId);

            Log::warning('MFA verification failed', [
                'admin_id' => $adminId,
                'input_otp' => $request->one_time_password,
                'expected_current' => $currentOtp,
                'window_tried' => $windowUsed,
                'remaining_attempts' => $remaining,
                'lockout_triggered' => $lockoutTriggered,
                'server_timezone' => date_default_timezone_get(),
                'manila_time' => Carbon::now('Asia/Manila')->toDateTimeString(),
            ]);

            if ($lockoutTriggered || $remaining == 0) {
                return back()->with('error', 'Account locked for 30 minutes due to too many failed attempts.');
            }

            $errorMsg = "Invalid authentication code. You have {$remaining} attempt(s) remaining.";
            if (abs((int)$request->one_time_password - (int)$currentOtp) < 50000) {
                $errorMsg .= " Tip: Make sure your authenticator app time is synced (Google Authenticator → Settings → Time correction).";
            }
            return back()->with('error', $errorMsg);
        }

        $this->resetMfaAttempts($adminId);

        Auth::guard('admin')->login($admin);
        $admin->update(['last_login_at' => now()]);
        session()->put('admin_mfa_verified', true);
        session()->forget('mfa_pending_admin_id');

        $intended = session()->pull('mfa_intended_url', route('admin.dashboard'));
        $request->session()->regenerate();

        Log::info('MFA verification successful', ['admin_id' => $adminId, 'window_used' => $windowUsed]);

        return redirect()->to($intended);
    }

    /**
     * Verify key with custom timestamp (for timezone issues)
     */
    protected function verifyKeyWithTimestamp($secret, $otp, $timestamp)
    {
        try {
            // Create a Google2FA instance with specific timestamp
            $google2fa = new Google2FA();
            $google2fa->setTimestamp($timestamp);
            return $google2fa->verifyKey($secret, $otp, 2);
        } catch (\Exception $e) {
            Log::error('verifyKeyWithTimestamp error', ['error' => $e->getMessage()]);
            return false;
        }
    }

    // ------------------------------------------------------------------
    // Use Recovery Code
    // ------------------------------------------------------------------

    public function useRecoveryCode(Request $request)
    {
        $request->validate(['recovery_code' => 'required|string']);
        $adminId = session('mfa_pending_admin_id');
        if (!$adminId) {
            return redirect()->route('admin.login.form');
        }

        if ($this->isMfaLockedOut($adminId)) {
            $lockoutEnd = Cache::get($this->mfaLockoutKey($adminId));
            $minutesRemaining = Carbon::now()->diffInMinutes($lockoutEnd);
            return back()->with('error', "Too many failed attempts. Please wait {$minutesRemaining} minutes before trying again.");
        }

        $admin = Admin::findOrFail($adminId);
        $codes = $admin->recovery_codes ?? [];

        $valid = false;
        foreach ($codes as $index => $hashed) {
            if (Hash::check($request->recovery_code, $hashed)) {
                unset($codes[$index]);
                $admin->recovery_codes = array_values($codes);
                $admin->save();
                $valid = true;
                Log::info('Recovery code used successfully', ['admin_id' => $adminId]);
                break;
            }
        }

        if (!$valid) {
            $lockoutTriggered = $this->recordFailedMfaAttempt($adminId);
            $remaining = $this->getMfaRemainingAttempts($adminId);

            Log::warning('Invalid recovery code attempt', [
                'admin_id' => $adminId,
                'remaining_attempts' => $remaining
            ]);

            if ($lockoutTriggered || $remaining == 0) {
                return back()->with('error', 'Account locked for 30 minutes due to too many failed attempts.');
            }

            return back()->with('error', "Invalid recovery code. You have {$remaining} attempt(s) remaining.");
        }

        $this->resetMfaAttempts($adminId);

        Auth::guard('admin')->login($admin);
        $admin->update(['last_login_at' => now()]);
        session()->put('admin_mfa_verified', true);
        session()->forget('mfa_pending_admin_id');

        $intended = session()->pull('mfa_intended_url', route('admin.dashboard'));
        $request->session()->regenerate();

        return redirect()->to($intended);
    }
}
