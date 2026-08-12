<?php
// app/Http/Controllers/Admin/UserRequestController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\IprogSmsService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserRequestController extends Controller
{
    /**
     * Display a listing of user requests.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $query = UserRequest::query();

        if ($status === 'pending') {
            $query->pending();
        } elseif ($status === 'approved') {
            $query->approved();
        } elseif ($status === 'rejected') {
            $query->where('status', 'rejected');
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);

        // Count stats
        $stats = [
            'pending' => UserRequest::pending()->count(),
            'approved' => UserRequest::approved()->count(),
            'rejected' => UserRequest::where('status', 'rejected')->count(),
            'total' => UserRequest::count(),
        ];

        return view('admin.user-requests.index', compact('requests', 'stats', 'status'));
    }

    /**
     * Store a new user request (admin creation).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'know_site' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        $userRequest = UserRequest::create([
            'know_site' => $validated['know_site'],
            'message' => $validated['message'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'pending',
        ]);

        Session::put('user_request_id', $userRequest->id);

        return response()->json([
            'success' => true,
            'message' => 'Request created successfully.',
            'request_id' => $userRequest->id,
        ]);
    }

    /**
     * Display the specified request.
     */
    public function show(UserRequest $userRequest)
    {
        return view('admin.user-requests.show', compact('userRequest'));
    }

    /**
     * Remove the specified request.
     */
    public function destroy(UserRequest $userRequest)
    {
        $userRequest->delete();

        return redirect()->route('admin.user-requests.index')
            ->with('success', 'Request deleted successfully.');
    }

    /**
     * Approve a user request - FIXED: Returns JSON for AJAX
     */
    public function approve(UserRequest $userRequest)
    {
        try {
            $userRequest->approve();

            // Clear session data if this was the user's request
            if (session('user_request_id') == $userRequest->id) {
                session()->forget(['user_request_id', 'user_request_pending']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Request approved successfully.',
                'data' => $userRequest
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject a user request - FIXED: Returns JSON for AJAX
     */
    public function reject(UserRequest $userRequest)
    {
        try {
            $userRequest->reject();

            // Clear session data if this was the user's request
            if (session('user_request_id') == $userRequest->id) {
                session()->forget(['user_request_id', 'user_request_pending']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Request rejected successfully.',
                'data' => $userRequest
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk approve multiple requests - FIXED: Returns JSON for AJAX
     */
    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No requests selected.'
            ], 400);
        }

        try {
            UserRequest::whereIn('id', $ids)->each(function ($userRequest) {
                $userRequest->approve();
            });

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' requests approved successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to bulk approve: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk reject multiple requests - FIXED: Returns JSON for AJAX
     */
    public function bulkReject(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No requests selected.'
            ], 400);
        }

        try {
            UserRequest::whereIn('id', $ids)->each(function ($userRequest) {
                $userRequest->reject();
            });

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' requests rejected successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to bulk reject: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update secret code - COMPLETELY BYPASSES CACHE
     */
    public function updateSecret(Request $request)
    {
        $request->validate([
            'secret_code' => 'required|string|min:6|max:20',
        ]);

        $secretCode = $request->secret_code;

        try {
            // DIRECT DATABASE UPDATE - bypass all models and cache
            DB::table('settings')->updateOrInsert(
                ['key' => 'secret_code'],
                [
                    'value' => $secretCode,
                    'type' => 'string',
                    'group' => 'security',
                    'description' => 'Secret code for old customers to access the platform',
                    'updated_at' => now(),
                    'created_at' => DB::raw('IFNULL(created_at, NOW())')
                ]
            );

            // Clear ALL possible cache keys
            Cache::forget('setting_secret_code');
            Cache::forget('settings_all_grouped');
            Cache::flush();

            // Verify it was saved
            $verify = DB::table('settings')->where('key', 'secret_code')->first();

            return response()->json([
                'success' => true,
                'message' => 'Secret code updated successfully to: ' . $secretCode,
                'secret_code' => $secretCode,
                'verified' => $verify ? $verify->value : 'NOT FOUND'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update secret code: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the current secret code - DIRECT DATABASE QUERY, NO CACHE
     */
    public function getSecret()
    {
        try {
            // DIRECT DATABASE QUERY - bypass all caching
            $setting = DB::table('settings')->where('key', 'secret_code')->first();

            if ($setting) {
                $secretCode = $setting->value;
            } else {
                // Create default if not exists
                DB::table('settings')->insert([
                    'key' => 'secret_code',
                    'value' => '111111111',
                    'type' => 'string',
                    'group' => 'security',
                    'description' => 'Secret code for old customers to access the platform',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $secretCode = '111111111';
            }

            return response()->json([
                'secret_code' => $secretCode,
                'from_cache' => false
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'secret_code' => '111111111',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get total user count for sending notifications.
     */
    public function getUserCount()
    {
        try {
            $count = User::whereNotNull('mobile_number')
                ->where('mobile_number', '!=', '')
                ->count();
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            return response()->json(['count' => 0, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Send secret code to all users via SMS - DIRECT DB QUERY
     */
    public function sendToAllUsers(Request $request)
    {
        try {
            // Get all users with valid mobile numbers
            $users = User::whereNotNull('mobile_number')
                ->where('mobile_number', '!=', '')
                ->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Send success.'
                ], 400);
            }

            // DIRECT DATABASE QUERY - get the latest value
            $setting = DB::table('settings')->where('key', 'secret_code')->first();
            $secretCode = $setting ? $setting->value : '111111111';

            $message = "New Updated SureCargo secret code is: " . $secretCode . ". Use this to access the platform. Visit surecargotransport.com";

            $sent = [];
            $errors = [];
            $totalSent = 0;
            $totalFailed = 0;

            // Use SMS service
            $smsService = app(IprogSmsService::class);

            foreach ($users as $user) {
                $phone = $this->formatPhoneNumber($user->mobile_number);

                // Skip invalid numbers
                if (!$this->isValidPhilippineNumber($phone)) {
                    $errors[] = $user->mobile_number . ' → Invalid number format';
                    $totalFailed++;
                    continue;
                }

                try {
                    $smsService->sendSms($phone, $message);
                    $sent[] = $user->mobile_number . ' (' . $user->first_name . ' ' . $user->last_name . ')';
                    $totalSent++;
                } catch (\Exception $e) {
                    $errors[] = $user->mobile_number . ' → ' . $e->getMessage();
                    $totalFailed++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Secret code sent to {$totalSent} users. {$totalFailed} failed.",
                'total_sent' => $totalSent,
                'total_failed' => $totalFailed,
                'sent' => $sent,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sent: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format phone number for SMS (Philippines, international format).
     * Returns a string starting with +63.
     */
    private function formatPhoneNumber($number)
    {
        // Remove all non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);

        // Convert to international format with +63
        if (substr($number, 0, 1) === '0') {
            $number = '+63' . substr($number, 1);
        } elseif (substr($number, 0, 2) === '63') {
            $number = '+' . $number;
        } elseif (substr($number, 0, 1) !== '+') {
            $number = '+63' . $number;
        }

        return $number;
    }

    /**
     * Validate a Philippine mobile number.
     * Accepts numbers starting with +639 and exactly 13 characters (including +).
     */
    private function isValidPhilippineNumber($number)
    {
        // Must start with +63 and have a total length of 13 (e.g., +639123456789)
        return preg_match('/^\+63[0-9]{10}$/', $number) === 1;
    }
}