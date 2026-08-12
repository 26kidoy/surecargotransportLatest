<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Truck;
use App\Models\Fee;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class BookingController extends Controller
{
    // Maximum trays allowed per booking
    const MAX_TRAYS_PER_BOOKING = 2000;

    // Minimum time between bookings in minutes
    const MIN_BOOKING_INTERVAL_MINUTES = 30;

    // Helper to get or create active batch
    private function getActiveBatch()
    {
        $activeBatch = Batch::where('is_active', true)->first();
        if (!$activeBatch) {
            $activeBatch = Batch::create([
                'batch_number' => 'DEFAULT-' . now()->timestamp,
                'is_active' => true
            ]);
        }
        return $activeBatch;
    }

    public function getTrucksWithStats()
    {
        try {
            $trucks = Truck::all();
            $trucksData = [];

            foreach ($trucks as $truck) {
                $trucksData[] = [
                    'id' => $truck->id,
                    'truck_number' => $truck->truck_number,
                    'truck_name' => $truck->truck_name,
                    'driver_name' => $truck->driver_name,
                    'driver_phone' => $truck->driver_phone,
                    'truck_model' => $truck->truck_model,
                    'color' => $truck->color,
                    'image' => $truck->image,
                    'max_capacity' => $truck->max_capacity,
                    'low_stock_threshold' => $truck->low_stock_threshold,
                    'status' => $truck->status,
                    'booked' => $truck->getBookedQuantityAttribute(),
                    'remaining' => $truck->getRemainingCapacityAttribute(),
                    'percentage_used' => $truck->getPercentageUsedAttribute()
                ];
            }

            return response()->json([
                'success' => true,
                'trucks' => $trucksData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getTruckStats()
    {
        try {
            $trucks = Truck::all();
            $stats = [];

            foreach ($trucks as $truck) {
                $stats[$truck->truck_number] = [
                    'id' => $truck->id,
                    'truck_number' => $truck->truck_number,
                    'truck_name' => $truck->truck_name,
                    'driver_name' => $truck->driver_name,
                    'driver_phone' => $truck->driver_phone,
                    'truck_model' => $truck->truck_model,
                    'color' => $truck->color,
                    'image' => $truck->image,
                    'max_capacity' => $truck->max_capacity,
                    'booked' => $truck->getBookedQuantityAttribute(),
                    'remaining' => $truck->getRemainingCapacityAttribute(),
                    'percentage_used' => $truck->getPercentageUsedAttribute()
                ];
            }

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            if ($booking->user_id !== auth()->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            if (in_array($booking->status, ['cancelled', 'delivered'])) {
                return response()->json(['error' => 'This booking cannot be edited'], 400);
            }

            $oldQuantity = $booking->quantity;
            $oldPickupAddress = $booking->pickup_address;
            $oldDropLocation = $booking->drop_location;

            $validated = $request->validate([
                'receiver_name' => 'required|string|max:255',
                'receiver_phone' => 'required|string|max:20',
                'drop_location' => 'required|string',
                'quantity' => 'required|integer|min:1|max:' . self::MAX_TRAYS_PER_BOOKING,
                'pickup_address' => 'required|string',
            ]);

            // Check if updated quantity exceeds max limit
            if ($validated['quantity'] > self::MAX_TRAYS_PER_BOOKING) {
                return response()->json([
                    'error' => 'Maximum of ' . self::MAX_TRAYS_PER_BOOKING . ' trays allowed per booking'
                ], 400);
            }

            $booking->receiver_name = $validated['receiver_name'];
            $booking->receiver_phone = $validated['receiver_phone'];
            $booking->drop_location = $validated['drop_location'];
            $booking->quantity = $validated['quantity'];
            $booking->pickup_address = $validated['pickup_address'];
            $booking->total_amount = $booking->quantity * $booking->fee_per_tray;
            $booking->save();

            // Send notification for booking update
            if ($booking->user_id) {
                $changes = [];
                if ($oldQuantity != $validated['quantity']) {
                    $changes[] = "quantity from {$oldQuantity} to {$validated['quantity']}";
                }
                if ($oldPickupAddress != $validated['pickup_address']) {
                    $changes[] = "pickup address";
                }
                if ($oldDropLocation != $validated['drop_location']) {
                    $changes[] = "drop-off location";
                }

                if (!empty($changes)) {
                    NotificationHelper::sendToUser(
                        $booking->user_id,
                        'booking_updated',
                        'Booking Updated',
                        'Your booking ' . $booking->booking_reference . ' has been updated. Changes: ' . implode(', ', $changes) . '.',
                        [
                            'booking_id' => $booking->id,
                            'booking_reference' => $booking->booking_reference,
                            'old_quantity' => $oldQuantity,
                            'new_quantity' => $validated['quantity']
                        ]
                    );
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking updated successfully',
                'booking' => $booking->load('truck')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update booking: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancel(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            if ($booking->user_id !== auth()->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            if (!in_array($booking->status, ['pending', 'confirmed'])) {
                return response()->json(['error' => 'This booking cannot be cancelled'], 400);
            }

            $oldStatus = $booking->status;
            $booking->update(['status' => 'cancelled']);

            // Send notification for cancellation
            if ($booking->user_id) {
                NotificationHelper::sendToUser(
                    $booking->user_id,
                    'booking_cancelled',
                    'Booking Cancelled',
                    'Your booking ' . $booking->booking_reference . ' has been cancelled successfully.',
                    [
                        'booking_id' => $booking->id,
                        'booking_reference' => $booking->booking_reference,
                        'old_status' => $oldStatus,
                        'new_status' => 'cancelled',
                        'quantity' => $booking->quantity
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully',
                'booking' => $booking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to cancel booking: ' . $e->getMessage()
            ], 500);
        }
    }

    public function userBookings()
    {
        return view('bookings.index');
    }

    public function getUserBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('truck')
            ->orderBy('created_at', 'desc')
            ->get();

        $currentFee = Fee::getCurrentFee()->amount_per_tray;
        foreach ($bookings as $booking) {
            if (is_null($booking->fee_per_tray)) {
                $booking->fee_per_tray = $currentFee;
                $booking->total_amount = $booking->quantity * $currentFee;
            }
        }

        return response()->json($bookings);
    }

    public function getUserStats()
    {
        $user = Auth::user();

        $stats = [
            'total_trucks' => Truck::count(),
            'available_trucks' => Truck::where('status', 'available')->count(),
            'my_bookings' => Booking::where('user_id', $user->id)->count(),
            'unread_messages' => \App\Models\Message::where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count(),
            'unread_notifications' => \App\Models\Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count()
        ];

        return response()->json($stats);
    }

    public function getRecentBookings()
    {
        try {
            $bookings = Booking::with(['truck', 'user'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            return response()->json($bookings);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeBooking(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'truck_id' => 'required|exists:trucks,id',
                'quantity' => 'required|integer|min:1|max:' . self::MAX_TRAYS_PER_BOOKING,
                'pickup_address' => 'required|string|max:255',
                'receiver_name' => 'required|string|max:100',
                'receiver_phone' => 'required|string|max:20',
                'drop_location' => 'required|string|max:255',
                'notes' => 'nullable|string'
            ]);

            $user = Auth::user();

            // Check if user is authenticated
            if (!$user) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'error' => 'You must be logged in to make a booking.'
                ], 401);
            }

            // Check for existing bookings within the time limit
            $timeLimit = now()->subMinutes(self::MIN_BOOKING_INTERVAL_MINUTES);
            $recentBooking = Booking::where('user_id', $user->id)
                ->where('created_at', '>=', $timeLimit)
                ->whereNotIn('status', ['cancelled', 'delivered'])
                ->orderBy('created_at', 'desc')
                ->first();

            if ($recentBooking) {
                $minutesRemaining = now()->diffInMinutes($recentBooking->created_at->addMinutes(self::MIN_BOOKING_INTERVAL_MINUTES));
                $secondsRemaining = now()->diffInSeconds($recentBooking->created_at->addMinutes(self::MIN_BOOKING_INTERVAL_MINUTES));

                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'error' => "You can only book once every " . self::MIN_BOOKING_INTERVAL_MINUTES . " minutes. Please wait " . ceil($minutesRemaining) . " more minute(s).",
                    'time_remaining_minutes' => ceil($minutesRemaining),
                    'time_remaining_seconds' => ceil($secondsRemaining),
                    'last_booking_time' => $recentBooking->created_at->toDateTimeString(),
                    'next_available_time' => $recentBooking->created_at->addMinutes(self::MIN_BOOKING_INTERVAL_MINUTES)->toDateTimeString()
                ], 429);
            }

            $truck = Truck::lockForUpdate()->findOrFail($request->truck_id);
            $requestedQuantity = (int) $request->quantity;

            // Check if requested quantity exceeds max limit
            if ($requestedQuantity > self::MAX_TRAYS_PER_BOOKING) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'error' => 'Maximum of ' . self::MAX_TRAYS_PER_BOOKING . ' trays allowed per booking.'
                ], 400);
            }

            $remaining = $truck->getRemainingCapacityAttribute();

            if ($requestedQuantity > $remaining) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'error' => "Only {$remaining} egg trays available on {$truck->truck_name}. Cannot book {$requestedQuantity} trays.",
                    'remaining' => $remaining,
                    'truck_id' => $truck->id
                ], 400);
            }

            $currentFee = Fee::getCurrentFee();
            $feePerTray = $currentFee->amount_per_tray;
            $totalAmount = $requestedQuantity * $feePerTray;

            $bookingReference = 'SC-' . strtoupper(Str::random(8));
            while (Booking::where('booking_reference', $bookingReference)->exists()) {
                $bookingReference = 'SC-' . strtoupper(Str::random(8));
            }

            // Get active batch (creates default if none)
            $activeBatch = $this->getActiveBatch();

            $booking = Booking::create([
                'user_id' => $user->id,
                'truck_id' => $truck->id,
                'truck_number' => $truck->truck_number,
                'booking_reference' => $bookingReference,
                'product_type' => 'egg',
                'quantity' => $requestedQuantity,
                'fee_per_tray' => $feePerTray,
                'total_amount' => $totalAmount,
                'pickup_address' => $request->pickup_address,
                'receiver_name' => $request->receiver_name,
                'receiver_phone' => $request->receiver_phone,
                'drop_location' => $request->drop_location,
                'notes' => $request->notes ?? '',
                'status' => 'pending',
                'batch_id' => $activeBatch->id
            ]);

            // Send notification to user for booking creation
            if ($booking->user_id) {
                NotificationHelper::sendToUser(
                    $booking->user_id,
                    'booking_created',
                    'Booking Created',
                    ' Your booking ' . $booking->booking_reference . ' has been created successfully with ' . $booking->quantity . ' trays on ' . $truck->truck_name . '.',
                    [
                        'booking_id' => $booking->id,
                        'booking_reference' => $booking->booking_reference,
                        'quantity' => $booking->quantity,
                        'truck_name' => $truck->truck_name,
                        'truck_number' => $truck->truck_number,
                        'status' => 'pending'
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Booking created successfully on {$truck->truck_name}!",
                'booking' => $booking->load(['truck', 'user']),
                'booking_reference' => $bookingReference,
                'remaining_trays' => $truck->fresh()->getRemainingCapacityAttribute(),
                'next_booking_available_at' => now()->addMinutes(self::MIN_BOOKING_INTERVAL_MINUTES)->toDateTimeString()
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function requestPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($booking->status !== 'confirmed') {
            return response()->json(['message' => 'Payment can only be made for confirmed bookings.'], 422);
        }

        $existingPayment = $booking->payments()->where('status', 'approve')->first();
        if ($existingPayment) {
            return response()->json(['message' => 'This booking has already been paid.'], 422);
        }

        $validated = $request->validate([
            'payment_method' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0.01',
            'reference_number' => 'nullable|string|max:100', // Made optional
            'sender_name' => 'required|string|max:255',
            'user_reference' => 'nullable|string|max:100', // Made optional
            'screenshot' => 'nullable|file|image|max:5120', // 5MB max
        ]);

        $expectedAmount = $booking->total_amount ?? ($booking->quantity * Fee::getCurrentFee()->amount_per_tray);
        if (abs($validated['amount'] - $expectedAmount) > 0.01) {
            return response()->json(['message' => 'Amount does not match the booking total.'], 422);
        }

        $paymentReference = 'PAY-' . strtoupper(uniqid());

        // Handle screenshot upload
        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $filename = 'payment_' . $booking->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store in public/uploads directory
            $file->move(public_path('uploads/payments'), $filename);
            $screenshotPath = 'uploads/payments/' . $filename;
        }

        $payment = $booking->payments()->create([
            'user_id' => auth()->id(),
            'payment_reference' => $paymentReference,
            'transaction_id' => null,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
            'payment_date' => null,
            'notes' => $validated['reference_number'] ?? null,
            'sender_name' => $validated['sender_name'],
            'user_reference' => $validated['user_reference'] ?? null,
            'screenshot_path' => $screenshotPath,
        ]);

        // Send notification for payment request
        if ($booking->user_id) {
            NotificationHelper::sendToUser(
                $booking->user_id,
                'payment_requested',
                'Payment Request Submitted',
                ' Your payment request for booking ' . $booking->booking_reference . ' has been submitted. Amount: ₱' . number_format($validated['amount'], 2) . '. Awaiting admin confirmation.',
                [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'payment_id' => $payment->id,
                    'payment_reference' => $paymentReference,
                    'amount' => $validated['amount'],
                    'payment_method' => $validated['payment_method']
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment request submitted. Awaiting admin confirmation.',
            'payment' => $payment
        ], 201);
    }

    public function getTruckDetails($id)
    {
        try {
            $truck = Truck::findOrFail($id);

            return response()->json([
                'success' => true,
                'truck' => [
                    'id' => $truck->id,
                    'truck_number' => $truck->truck_number,
                    'truck_name' => $truck->truck_name,
                    'driver_name' => $truck->driver_name,
                    'driver_phone' => $truck->driver_phone,
                    'truck_model' => $truck->truck_model,
                    'color' => $truck->color,
                    'image' => $truck->image,
                    'max_capacity' => $truck->max_capacity,
                    'remaining' => $truck->getRemainingCapacityAttribute(),
                    'booked' => $truck->getBookedQuantityAttribute(),
                    'percentage_used' => $truck->getPercentageUsedAttribute()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Truck not found'
            ], 404);
        }
    }
}