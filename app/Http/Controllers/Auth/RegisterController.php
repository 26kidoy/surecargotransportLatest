<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\IprogSmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    protected $smsService;

    public function __construct(IprogSmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function showRegistrationForm(Request $request)
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        // Generate or retrieve device ID from cookie
        $deviceId = $request->cookie('device_id');
        if (!$deviceId) {
            $deviceId = (string) Str::uuid();
            // Set cookie: 5 years expiration, httpOnly, secure, sameSite strict
            Cookie::queue('device_id', $deviceId, 60 * 24 * 365 * 5, '/', null, true, true, false, 'Strict');
        }

        return view('auth.register', compact('deviceId'));
    }

    /**
     * Send OTP using IPROG's dedicated OTP endpoint.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|string|regex:/^09[0-9]{9}$/',
        ]);

        $mobile = $request->mobile_number;

        try {
            $otp = $this->smsService->sendOtp($mobile, null, 5);
            Cache::put('otp_' . $mobile, $otp, now()->addMinutes(5));
            Log::info('OTP sent via IPROG OTP endpoint', ['mobile' => $mobile]);
        } catch (\Exception $e) {
            Log::error("IPROG OTP sending failed: " . $e->getMessage());
            return response()->json([
                'error' => 'Failed to send OTP. Please try again.'
            ], 500);
        }

        return response()->json(['message' => 'OTP sent successfully']);
    }

    /**
     * Verify OTP and mark it as used.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|string|regex:/^09[0-9]{9}$/',
            'otp' => 'required|string|size:6',
        ]);

        $mobile = $request->mobile_number;
        $otpKey = 'otp_' . $mobile;
        $usedKey = 'otp_used_' . $mobile;

        $cachedOtp = Cache::get($otpKey);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['error' => 'Invalid or expired OTP'], 422);
        }

        if (!Cache::add($usedKey, true, now()->addMinutes(10))) {
            return response()->json(['error' => 'This OTP has already been used.'], 422);
        }

        return response()->json(['message' => 'OTP verified']);
    }

    /**
     * Final registration – enforces one account per device.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|unique:users,mobile_number|regex:/^09[0-9]{9}$/',
            'city' => 'required|in:bantayan,escalante,sagay,cadiz,victorias,silay,bata,bacolod,libertad',
            'user_type' => 'required|in:poultry_owner,customer',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'otp' => 'required|string|size:6',
            'device_id' => 'required|string|size:36', // UUID format
        ]);

        $deviceId = $validated['device_id'];

        // Check if this device already has a user
        $existingUser = User::where('device_id', $deviceId)->first();
        if ($existingUser) {
            return back()->withErrors([
                'device' => 'This device already has a registered account. Only one account per device is allowed.'
            ])->withInput();
        }

        $mobile = $validated['mobile_number'];
        $otpKey = 'otp_' . $mobile;
        $usedKey = 'otp_used_' . $mobile;

        if (!Cache::get($usedKey)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP. Please request a new code.'])->withInput();
        }

        Cache::forget($otpKey);
        Cache::forget($usedKey);

        $user = User::create([
            'device_id' => $deviceId,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'mobile_number' => $validated['mobile_number'],
            'city' => $validated['city'],
            'user_type' => $validated['user_type'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'is_admin' => false,
        ]);

        $request->session()->regenerate();
        Auth::login($user, true);

        if (!Auth::check()) {
            Log::error('Registration failed: User not logged in after Auth::login()', ['user_id' => $user->id]);
            return redirect('/login')->withErrors(['error' => 'Registration failed. Please try logging in manually.']);
        }

        return redirect('/dashboard')->with('success', 'Registration successful!');
    }
}