<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Adjust this to your actual Booking model

class TrackValidateController extends Controller
{
    public function index()
    {
        return view('trackvalidate.index');
    }

    public function checkBooking(Request $request)
    {
        $request->validate([
            'booking_reference' => 'required|string'
        ]);

        // Find the booking - adjust this query based on your actual database structure
        $booking = Booking::where('booking_reference', $request->booking_reference)
            ->orWhere('id', $request->booking_reference)
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking reference not found. Please check and try again.'
            ], 404);
        }

        // Check if status is 'in_transit'
        $isInTransit = ($booking->status === 'in_transit');

        // Also check if payment is approved (optional - adjust as needed)
        $canTrack = $isInTransit && ($booking->payment_status === 'approve' || $booking->payment_status === 'cod');

        return response()->json([
            'success' => true,
            'data' => [
                'booking_reference' => $booking->booking_reference,
                'status' => $booking->status,
                'is_in_transit' => $isInTransit,
                'can_track' => $canTrack,
                'redirect_url' => $canTrack ? url('/viewroute') : null,
                'message' => $isInTransit ? 'Booking is in transit! Redirecting to tracking page...' : 'Booking is ' . str_replace('_', ' ', $booking->status) . '. Tracking is only available for "In Transit" shipments.'
            ]
        ]);
    }
}
