<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Services\IprogSmsService;

class ProfileController extends Controller
{
    protected $smsService;

    public function __construct(IprogSmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function index()
    {
        return view('profile.index');
    }

    /**
     * Send OTP for profile mobile number change.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|string|regex:/^09[0-9]{9}$/',
        ]);

        $user = Auth::user();
        $mobile = $request->mobile_number;

        // Check if mobile is same as current
        if ($mobile === $user->mobile_number) {
            return response()->json(['error' => 'Mobile number is the same as current. No change needed.'], 422);
        }

        // Check if mobile already taken by another user
        if (User::where('mobile_number', $mobile)->where('id', '!=', $user->id)->exists()) {
            return response()->json(['error' => 'This mobile number is already in use by another account.'], 422);
        }

        try {
            $otp = $this->smsService->sendOtp($mobile, null, 5);
            Cache::put('profile_otp_' . $mobile, $otp, now()->addMinutes(5));
            Log::info('Profile OTP sent', ['user' => $user->id, 'mobile' => $mobile]);
        } catch (\Exception $e) {
            Log::error('Profile OTP send failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send OTP. Please try again.'], 500);
        }

        return response()->json(['message' => 'OTP sent successfully']);
    }

    /**
     * Verify OTP for profile mobile number change.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|string|regex:/^09[0-9]{9}$/',
            'otp' => 'required|string|size:6',
        ]);

        $mobile = $request->mobile_number;
        $otpKey = 'profile_otp_' . $mobile;
        $cachedOtp = Cache::get($otpKey);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['error' => 'Invalid or expired OTP'], 422);
        }

        // Mark as verified in session with the new mobile number
        session(['profile_otp_verified' => $mobile]);

        // Remove OTP from cache to prevent reuse
        Cache::forget($otpKey);

        return response()->json(['message' => 'OTP verified successfully']);
    }

    /**
     * Update user profile
     * FIXED: Now saves profile images to public/uploads directory
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $newMobile = $request->mobile_number;

        // Build validation rules
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'city' => 'required|in:bantayan,escalante,sagay,cadiz,victorias,silay,bata,bacolod,libertad',
            'user_type' => 'required|in:customer,driver,poultry_owner',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];

        // If mobile is being changed, add validation and OTP check
        if ($request->has('mobile_number') && $newMobile !== $user->mobile_number) {
            $rules['mobile_number'] = 'required|string|max:11|unique:users,mobile_number,' . $user->id . '|regex:/^09[0-9]{9}$/';

            // Check OTP verification
            if (session('profile_otp_verified') !== $newMobile) {
                return response()->json([
                    'success' => false,
                    'error' => 'Mobile number change requires OTP verification. Please verify your new mobile number.'
                ], 422);
            }
        } else {
            // If mobile not changed, just validate format if present
            $rules['mobile_number'] = 'nullable|string|max:11|regex:/^09[0-9]{9}$/';
        }

        $request->validate($rules);

        try {
            // Update user information
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            if ($request->has('mobile_number')) {
                $user->mobile_number = $request->mobile_number;
            }
            $user->city = $request->city;
            $user->user_type = $request->user_type;
            $user->save();

            // Handle profile image upload - FIXED: Save to public/uploads
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');

                // Delete old image if exists (from either storage or public/uploads)
                if ($user->profile_image) {
                    $this->deleteProfileImage($user->profile_image);
                }

                // Generate unique filename
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Create directory structure
                $datePath = date('Y/m/d');
                $relativePath = "profile_images/{$datePath}";
                $fullPath = public_path("uploads/{$relativePath}");

                try {
                    // Create directory if it doesn't exist
                    if (!file_exists($fullPath)) {
                        mkdir($fullPath, 0755, true);
                    }

                    // Move file to public/uploads directory
                    $file->move($fullPath, $filename);

                    // Store the path relative to public directory
                    $path = "uploads/{$relativePath}/{$filename}";

                    $user->profile_image = $path;
                    $user->save();

                    Log::info('Profile image uploaded to public/uploads', [
                        'user_id' => $user->id,
                        'path' => $path
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to store profile image: ' . $e->getMessage(), [
                        'user_id' => $user->id
                    ]);
                    return response()->json([
                        'success' => false,
                        'error' => 'Failed to store image. Please check permissions.'
                    ], 500);
                }
            }

            // Clear OTP verification session after successful update
            session()->forget('profile_otp_verified');

            $user->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'full_name' => $user->full_name,
                    'mobile_number' => $user->mobile_number,
                    'city' => $user->city,
                    'user_type' => $user->user_type,
                    'profile_image' => $user->profile_image,
                    'profile_image_url' => $user->profile_image_url,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper: Delete profile image from public/uploads
     */
    private function deleteProfileImage($path)
    {
        if (empty($path)) {
            return;
        }

        try {
            // Check if it's a storage path (old format)
            if (strpos($path, 'profile_images') !== false && !str_starts_with($path, 'uploads/')) {
                // Try to delete from storage (for backward compatibility)
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                    Log::info('Deleted old profile image from storage', ['path' => $path]);
                    return;
                }
            }

            // Delete from public/uploads
            $fullPath = public_path($path);
            if (file_exists($fullPath)) {
                unlink($fullPath);
                Log::info('Deleted profile image from public/uploads', ['path' => $path]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to delete profile image: ' . $e->getMessage(), ['path' => $path]);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'error' => 'Current password is incorrect'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        Log::info('Password changed for user', ['user_id' => $user->id]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }
}
