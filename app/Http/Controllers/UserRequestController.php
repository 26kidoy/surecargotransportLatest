<?php
// app/Http/Controllers/UserRequestController.php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserRequestController extends Controller
{
    /**
     * Store a new user request from the onboarding modal.
     */
    public function store(Request $request)
    {
        // Check if user already submitted a request in this session
        if (Session::has('user_request_id')) {
            $existingRequest = UserRequest::find(Session::get('user_request_id'));
            if ($existingRequest && $existingRequest->isPending()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have a pending request. Please wait for admin approval.',
                ], 422);
            }
        }

        // Check if IP has a pending request (prevent spam)
        $existingRequest = UserRequest::where('ip_address', $request->ip())
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending request from this IP. Please wait for admin approval.',
            ], 422);
        }

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

        // Store the request ID in session and for frontend
        Session::put('user_request_id', $userRequest->id);
        Session::put('user_request_pending', true);

        return response()->json([
            'success' => true,
            'message' => 'Your request has been submitted successfully! Admin will review and approve your access shortly.',
            'request_id' => $userRequest->id,
        ]);
    }

    /**
     * Verify secret code for old customers.
     */
    public function verifySecret(Request $request)
    {
        $request->validate([
            'secret_code' => 'required|string',
        ]);

        // Get secret code from settings using your existing Setting model
        $secretCode = Setting::getValue('secret_code', '111111111');

        if ($request->secret_code === $secretCode) {
            // Store in session that user is verified
            Session::put('surecargo_verified', true);
            Session::put('surecargo_onboarding_done', true);
            
            return response()->json([
                'success' => true,
                'message' => 'Access granted! Welcome back.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid secret code. Please try again.',
        ], 422);
    }

    /**
     * Check the status of a user request (for polling).
     * Uses request_id from query parameter instead of session for reliability.
     */
    public function checkStatus(Request $request)
    {
        // Get request_id from query parameter (sent by frontend)
        $requestId = $request->query('request_id');
        
        // If not provided, try session
        if (!$requestId) {
            $requestId = Session::get('user_request_id');
        }
        
        if (!$requestId) {
            return response()->json([
                'status' => 'none',
                'message' => 'No request found.',
            ]);
        }

        $userRequest = UserRequest::find($requestId);
        
        if (!$userRequest) {
            return response()->json([
                'status' => 'none',
                'message' => 'Request not found.',
            ]);
        }

        // If the request is no longer pending, clear session
        if ($userRequest->status !== 'pending') {
            Session::forget('user_request_pending');
        }

        return response()->json([
            'status' => $userRequest->status,
            'message' => $userRequest->status === 'approved' 
                ? 'Your request has been approved! Welcome to SureCargo.' 
                : ($userRequest->status === 'rejected' 
                    ? 'Your request was rejected. Please try again.' 
                    : 'Your request is still pending. Please wait for admin approval.'),
            'request_id' => $userRequest->id,
        ]);
    }
}