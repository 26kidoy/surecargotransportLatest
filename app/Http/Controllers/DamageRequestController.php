<?php

namespace App\Http\Controllers;

use App\Models\DamageRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DamageRequestController extends Controller
{
    /**
     * Show user form + only DELIVERED bookings
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        $bookings = Booking::where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'booking_reference', 'quantity', 'total_amount']);

        $damageRequests = DamageRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('damage-requests.index', compact('bookings', 'damageRequests'));
    }

    /**
     * Web AJAX: get user's damage requests (JSON)
     * Uses session authentication only (no token).
     * FIXED: Uses model accessor for image_url
     */
    public function getRequestsJson(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $requests = DamageRequest::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            // Transform to include image_url from accessor
            $requests->transform(function ($req) {
                return [
                    'id' => $req->id,
                    'booking_id' => $req->booking_id,
                    'booking_reference' => $req->booking_reference,
                    'egg_quantity' => $req->egg_quantity,
                    'image_path' => $req->image_path,
                    'image_url' => $req->image_url, // Uses accessor
                    'notes' => $req->notes,
                    'status' => $req->status,
                    'admin_reply' => $req->admin_reply,
                    'replied_at' => $req->replied_at,
                    'created_at' => $req->created_at,
                    'updated_at' => $req->updated_at,
                ];
            });

            return response()->json($requests)
                ->header('X-Content-Type-Options', 'nosniff')
                ->header('X-Frame-Options', 'DENY');
        } catch (\Exception $e) {
            Log::error('Error fetching damage requests: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch requests'], 500);
        }
    }

    /**
     * Web AJAX: store new damage request
     * Uses session authentication only (no token).
     * FIXED: Now saves to public/uploads directory with consistent path
     */
    public function storeJson(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'booking_id'    => 'required|integer|exists:bookings,id',
            'egg_quantity'  => 'required|integer|min:1|max:10000',
            'damage_image'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=50,min_height=50,max_width=8000,max_height=8000',
            'notes'         => 'nullable|string|max:500',
        ], [
            'damage_image.dimensions' => 'Image dimensions must be between 50x50 and 8000x8000 pixels',
            'egg_quantity.max' => 'Egg quantity cannot exceed 10,000',
            'notes.max' => 'Notes cannot exceed 500 characters',
        ]);

        $booking = Booking::where('id', $validated['booking_id'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$booking) {
            Log::warning('Unauthorized attempt to access booking', [
                'user_id' => Auth::id(),
                'booking_id' => $validated['booking_id']
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid booking selection'
            ], 403);
        }

        $existingRequest = DamageRequest::where('booking_id', $booking->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'A damage request already exists for this booking'
            ], 409);
        }

        $file = $request->file('damage_image');

        if (!$file->isValid()) {
            Log::error('Invalid file upload attempt', [
                'user_id' => Auth::id(),
                'error' => $file->getError()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid file upload'
            ], 400);
        }

        $originalExtension = $file->getClientOriginalExtension();
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];

        if (!in_array(strtolower($originalExtension), $allowedExtensions)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file extension'
            ], 400);
        }

        // FIXED: Save directly to public/uploads directory with clean path
        $secureFilename = Str::random(40) . '_' . time() . '.' . $originalExtension;
        $datePath = Carbon::now()->format('Y/m/d');
        $relativePath = "damage-images/{$datePath}";
        $fullPath = public_path("uploads/{$relativePath}");

        try {
            // Create directory if it doesn't exist
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            // Move file to public/uploads directory
            $file->move($fullPath, $secureFilename);

            // Store the path relative to public directory (clean, without 'public/' prefix)
            $path = "uploads/{$relativePath}/{$secureFilename}";

            Log::info('File uploaded to public/uploads', [
                'path' => $path,
                'user_id' => Auth::id()
            ]);
        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'booking_id' => $booking->id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image. Please try again.'
            ], 500);
        }

        $sanitizedNotes = $this->sanitizeInput($validated['notes'] ?? null);

        try {
            $damageRequest = DamageRequest::create([
                'user_id'           => Auth::id(),
                'booking_id'        => $booking->id,
                'booking_reference' => $booking->booking_reference,
                'egg_quantity'      => $validated['egg_quantity'],
                'image_path'        => $path,
                'notes'             => $sanitizedNotes,
                'status'            => 'pending',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            Log::info('Damage request created with public/uploads image', [
                'request_id' => $damageRequest->id,
                'user_id' => Auth::id(),
                'booking_id' => $booking->id,
                'image_path' => $path
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Damage request submitted successfully.',
                'data' => [
                    'id' => $damageRequest->id,
                    'status' => $damageRequest->status,
                    'image_url' => $damageRequest->image_url
                ]
            ]);
        } catch (\Exception $e) {
            // Delete the uploaded file if database insert fails
            if (isset($path) && file_exists(public_path($path))) {
                unlink(public_path($path));
                Log::warning('Deleted uploaded file due to database error', ['path' => $path]);
            }

            Log::error('Failed to create damage request: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'booking_id' => $booking->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit request. Please try again.'
            ], 500);
        }
    }

    /**
     * Security Helper: Sanitize user input
     */
    private function sanitizeInput($input)
    {
        if (empty($input)) {
            return null;
        }

        $sanitized = strip_tags($input);
        $sanitized = htmlspecialchars($sanitized, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $sanitized = preg_replace('/on\w+="[^"]*"/i', '', $sanitized);
        $sanitized = preg_replace("/on\w+='[^']*'/i", '', $sanitized);

        return Str::limit($sanitized, 500);
    }

    // ------------------- ADMIN METHODS (NO redundant auth checks) -------------------

    public function adminIndex()
    {
        // Middleware already ensures admin access; no need to check again.
        $requests = DamageRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.damage-requests.index', compact('requests'));
    }

    public function destroy(DamageRequest $damageRequest)
    {
        // Middleware ensures admin.
        // FIXED: Delete file from public/uploads
        if ($damageRequest->image_path && file_exists(public_path($damageRequest->image_path))) {
            unlink(public_path($damageRequest->image_path));
            Log::info('Deleted image file from public/uploads', [
                'request_id' => $damageRequest->id,
                'admin_id' => Auth::id(),
                'path' => $damageRequest->image_path
            ]);
        }

        $damageRequest->delete();

        Log::info('Damage request deleted', [
            'request_id' => $damageRequest->id,
            'deleted_by' => Auth::id()
        ]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Damage request deleted permanently.']);
        }

        return redirect()->back()->with('success', 'Damage request deleted permanently.');
    }

    public function updateStatus(Request $request, DamageRequest $damageRequest)
    {
        // Middleware ensures admin.
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $oldStatus = $damageRequest->status;
        $damageRequest->update([
            'status' => $validated['status'],
            'updated_at' => now()
        ]);

        // Notify user (ensure NotificationController exists)
        if (class_exists(\App\Http\Controllers\NotificationController::class)) {
            \App\Http\Controllers\NotificationController::damageRequestStatusUpdated(
                $damageRequest,
                $oldStatus,
                $validated['status']
            );
        }

        Log::info('Damage request status updated', [
            'request_id' => $damageRequest->id,
            'old_status' => $oldStatus,
            'new_status' => $validated['status'],
            'updated_by' => Auth::id()
        ]);

        return back()->with('success', 'Status updated successfully.');
    }

    public function reply(Request $request, DamageRequest $damageRequest)
    {
        // Middleware ensures admin.
        $validated = $request->validate([
            'reply' => 'required|string|max:2000'
        ]);

        $sanitizedReply = htmlspecialchars(
            strip_tags($validated['reply']),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );
        $sanitizedReply = \Illuminate\Support\Str::limit($sanitizedReply, 2000);

        $damageRequest->update([
            'admin_reply' => $sanitizedReply,
            'replied_at'  => now(),
            'updated_at'  => now()
        ]);

        if (class_exists(\App\Http\Controllers\NotificationController::class)) {
            \App\Http\Controllers\NotificationController::damageRequestReplied($damageRequest, $sanitizedReply);
        }

        Log::info('Admin reply added', [
            'request_id' => $damageRequest->id,
            'admin_id' => Auth::id(),
            'admin_email' => Auth::user()->email
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Reply sent successfully.',
                'data' => ['reply' => $sanitizedReply]
            ]);
        }

        return redirect()->back()->with('success', 'Reply sent to user successfully.');
    }

    public function chartData(Request $request)
    {
        // Middleware ensures admin.
        $period = $request->get('period', 'week');
        $allowedPeriods = ['week', 'month', 'year'];

        if (!in_array($period, $allowedPeriods)) {
            return response()->json(['error' => 'Invalid period parameter'], 400);
        }

        try {
            $query = DamageRequest::query();

            if ($period == 'week') {
                $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
                $endOfWeek   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

                $rawData = $query->selectRaw('DAYNAME(created_at) as day, COUNT(*) as total')
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->groupBy('day')
                    ->orderByRaw('FIELD(day, "Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday")')
                    ->pluck('total', 'day');

                $labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $counts = array_map(function($day) use ($rawData) {
                    return $rawData[$day] ?? 0;
                }, $labels);
            }
            elseif ($period == 'month') {
                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth   = Carbon::now()->endOfMonth();

                $rawData = $query->selectRaw(
                        'FLOOR((DAYOFMONTH(created_at) - 1) / 7) + 1 as week_num, COUNT(*) as total'
                    )
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->groupBy('week_num')
                    ->orderBy('week_num')
                    ->pluck('total', 'week_num');

                $weeksInMonth = (int) ceil($startOfMonth->daysInMonth / 7);
                $labels = [];
                for ($i = 1; $i <= $weeksInMonth; $i++) {
                    $labels[] = "Week $i";
                }
                $counts = array_map(function($week) use ($rawData) {
                    return $rawData[$week] ?? 0;
                }, range(1, $weeksInMonth));
            }
            else {
                $year = Carbon::now()->year;

                $rawData = $query->selectRaw('MONTH(created_at) as month_num, COUNT(*) as total')
                    ->whereYear('created_at', $year)
                    ->groupBy('month_num')
                    ->orderBy('month_num')
                    ->pluck('total', 'month_num');

                $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $counts = array_map(function($month) use ($rawData) {
                    return $rawData[$month] ?? 0;
                }, range(1, 12));
            }

            return response()->json([
                'labels' => $labels,
                'counts' => $counts
            ])->header('X-Content-Type-Options', 'nosniff');

        } catch (\Exception $e) {
            Log::error('Chart data retrieval error: ' . $e->getMessage());
            // Return fallback data to prevent frontend breakage
            if ($period === 'week') {
                return response()->json([
                    'labels' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
                    'counts' => [0,0,0,0,0,0,0]
                ]);
            } elseif ($period === 'month') {
                return response()->json([
                    'labels' => ['Week 1','Week 2','Week 3','Week 4'],
                    'counts' => [0,0,0,0]
                ]);
            } else {
                return response()->json([
                    'labels' => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                    'counts' => array_fill(0, 12, 0)
                ]);
            }
        }
    }
}
