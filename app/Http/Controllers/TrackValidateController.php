<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class TrackValidateController extends Controller
{
    public function index()
    {
        return view('trackvalidate.index');
    }

    public function checkBooking(Request $request)
    {
        $request->validate([
            'booking_reference' => 'required|string|max:255'
        ]);

        // Find the booking
        $booking = Booking::where('booking_reference', $request->booking_reference)
            ->orWhere('id', $request->booking_reference)
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking reference not found. Please check and try again.'
            ], 404);
        }

        // Check if booking belongs to authenticated user (optional)
        // if (auth()->check() && $booking->user_id !== auth()->id()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'You do not have permission to track this booking.'
        //     ], 403);
        // }

        // ✅ UPDATED: Only check if status is 'in_transit' - payment status is ignored
        $isInTransit = ($booking->status === 'in_transit');
        
        // ✅ Can track if status is 'in_transit' regardless of payment
        $canTrack = $isInTransit;

        // ✅ UPDATED: Build appropriate message
        if ($canTrack) {
            $message = '✅ Shipment is in transit! Redirecting to tracking page...';
        } else {
            $statusDisplay = str_replace('_', ' ', $booking->status);
            $message = '⚠️ Booking status is "' . ucfirst($statusDisplay) . '". Tracking is only available for "In Transit" shipments.';
        }

        // Log the action
        Log::info('Booking tracking request:', [
            'reference' => $booking->booking_reference,
            'status' => $booking->status,
            'payment_status' => $booking->payment_status,
            'can_track' => $canTrack
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'booking_reference' => $booking->booking_reference,
                'status' => $booking->status,
                'payment_status' => $booking->payment_status,
                'is_in_transit' => $isInTransit,
                'can_track' => $canTrack,
                'redirect_url' => $canTrack ? url('/viewroute') : null,
                'message' => $message
            ]
        ]);
    }
}
