<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\IprogSmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    protected $smsService;

    public function __construct(IprogSmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Send OTP for password reset.
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|regex:/^09[0-9]{9}$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid mobile number format.'], 422);
        }

        $mobile = $request->mobile_number;

        // Check if mobile exists in users table
        $user = User::where('mobile_number', $mobile)->first();
        if (!$user) {
            return response()->json(['error' => 'This mobile number is not registered.'], 422);
        }

        try {
            // Send OTP using the same service as registration
            $otp = $this->smsService->sendOtp($mobile, null, 5); // 5 minutes expiry
            // Store OTP in cache with key 'reset_otp_' . mobile
            Cache::put('reset_otp_' . $mobile, $otp, now()->addMinutes(5));

            Log::info('Password reset OTP sent', ['mobile' => $mobile]);

            return response()->json(['message' => 'OTP sent successfully.']);
        } catch (\Exception $e) {
            Log::error('Password reset OTP send failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send OTP. Please try again later.'], 500);
        }
    }

    /**
     * Verify OTP for password reset.
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|regex:/^09[0-9]{9}$/',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input.'], 422);
        }

        $mobile = $request->mobile_number;
        $otp = $request->otp;

        $cachedOtp = Cache::get('reset_otp_' . $mobile);

        if (!$cachedOtp || $cachedOtp != $otp) {
            return response()->json(['error' => 'Invalid or expired OTP.'], 422);
        }

        // Mark as verified in session
        session(['reset_password_verified' => $mobile]);

        // Remove OTP from cache to prevent reuse
        Cache::forget('reset_otp_' . $mobile);

        return response()->json(['message' => 'OTP verified successfully.']);
    }

    /**
     * Reset password after OTP verification.
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|regex:/^09[0-9]{9}$/',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mobile = $request->mobile_number;

        // Check OTP verification status from session
        if (session('reset_password_verified') !== $mobile) {
            return response()->json(['error' => 'OTP verification required before resetting password.'], 422);
        }

        $user = User::where('mobile_number', $mobile)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear verification session
        session()->forget('reset_password_verified');

        return response()->json(['message' => 'Password reset successfully. You can now log in.']);
    }
}
