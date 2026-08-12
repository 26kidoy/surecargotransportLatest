<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Batch;
use Illuminate\Support\Facades\Log;
use App\Helpers\NotificationHelper;
use App\Services\IprogSmsService;

class AdminBookingController extends Controller
{
    protected $smsService;

    /**
     * Inject the IPROG SMS service.
     */
    public function __construct(IprogSmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Display a listing of bookings with user details and batches.
     */
    public function index(Request $request)
    {
        try {
            // Fetch non-archived batches with their bookings
            $batches = Batch::with('bookings')
                ->where('archived', false)
                ->orderBy('created_at', 'desc')
                ->get();

            // Original booking query (unchanged)
            $query = Booking::with(['user', 'truck']);

            // Filter by status if provided
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            // Search by booking reference, receiver name, or user name
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('booking_reference', 'like', "%{$search}%")
                      ->orWhere('receiver_name', 'like', "%{$search}%")
                      ->orWhere('receiver_phone', 'like', "%{$search}%")
                      ->orWhereHas('user', function($userQuery) use ($search) {
                          $userQuery->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%")
                                    ->orWhere('mobile_number', 'like', "%{$search}%");
                      });
                });
            }

            $bookings = $query->orderBy('created_at', 'desc')->paginate(20);

            // Add truck details to each booking
            foreach ($bookings as $booking) {
                $truck = Truck::where('truck_number', $booking->truck_number)->first();
                $booking->truck_name = $truck ? $truck->truck_name : $booking->truck_number;
                $booking->truck_image = $truck ? $truck->image : null;
            }

            // Pass both $batches and $bookings to the view
            return view('admin.bookings.index', compact('batches', 'bookings'));

        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        $trucks = Truck::all();
        $users = User::all();
        return view('admin.bookings.create', compact('trucks', 'users'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'user_id' => 'nullable|exists:users,id',
                'truck_id' => 'required|exists:trucks,id',
                'quantity' => 'required|integer|min:1',
                'pickup_address' => 'required|string|max:255',
                'receiver_name' => 'required|string|max:100',
                'receiver_phone' => 'required|string|max:20',
                'drop_location' => 'required|string|max:255',
                'notes' => 'nullable|string',
                'status' => 'nullable|in:pending,confirmed,in_transit,delivered,cancelled'
            ]);

            $truck = Truck::lockForUpdate()->findOrFail($request->truck_id);
            $requestedQuantity = (int) $request->quantity;

            $remaining = $truck->getRemainingCapacityAttribute();

            if ($requestedQuantity > $remaining) {
                DB::rollBack();
                return redirect()->back()->with('error', "Only {$remaining} egg trays available on {$truck->truck_name}. Cannot book {$requestedQuantity} trays.");
            }

            // Generate unique booking reference
            $bookingReference = 'SC-' . strtoupper(Str::random(8));
            while (Booking::where('booking_reference', $bookingReference)->exists()) {
                $bookingReference = 'SC-' . strtoupper(Str::random(8));
            }

            // Find the active batch for this booking
            $activeBatch = Batch::where('is_active', true)->first();

            // If no active batch exists, create one
            if (!$activeBatch) {
                $lastBatch = Batch::orderBy('batch_number', 'desc')->first();
                $newBatchNumber = $lastBatch ? $lastBatch->batch_number + 1 : 1;
                $activeBatch = Batch::create([
                    'batch_number' => $newBatchNumber,
                    'is_active' => true,
                    'archived' => false,
                ]);
            }

            // If user is selected, get user details for receiver info if not provided
            $user = null;
            if ($request->user_id) {
                $user = User::find($request->user_id);
            }

            // Create booking
            $booking = Booking::create([
                'user_id' => $request->user_id ?? null,
                'truck_id' => $truck->id,
                'truck_number' => $truck->truck_number,
                'booking_reference' => $bookingReference,
                'product_type' => 'egg',
                'quantity' => $requestedQuantity,
                'pickup_address' => $request->pickup_address,
                'receiver_name' => $request->receiver_name ?? ($user ? $user->first_name . ' ' . $user->last_name : null),
                'receiver_phone' => $request->receiver_phone ?? ($user ? $user->mobile_number : null),
                'drop_location' => $request->drop_location,
                'notes' => $request->notes ?? '',
                'status' => $request->status ?? 'pending',
                'batch_id' => $activeBatch->id
            ]);

            // ✅ SEND NOTIFICATION to user if assigned
            if ($booking->user_id) {
                NotificationHelper::sendToUser(
                    $booking->user_id,
                    'booking_created',
                    'New Booking Created',
                    'Your booking ' . $booking->booking_reference . ' has been created successfully with ' . $booking->quantity . ' trays on ' . $truck->truck_name . '.',
                    [
                        'booking_id' => $booking->id,
                        'booking_reference' => $booking->booking_reference,
                        'quantity' => $booking->quantity,
                        'truck_name' => $truck->truck_name,
                        'status' => $booking->status
                    ]
                );
            }

            DB::commit();

            return redirect()->route('admin.bookings.index')->with('success', "Booking created successfully on {$truck->truck_name}!");

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        try {
            $booking = Booking::with(['user', 'truck'])->findOrFail($id);
            $truck = Truck::where('truck_number', $booking->truck_number)->first();
            $booking->truck_name = $truck ? $truck->truck_name : $booking->truck_number;

            return view('admin.bookings.show', compact('booking'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found');
        }
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit($id)
    {
        try {
            $booking = Booking::with('user')->findOrFail($id);
            $trucks = Truck::all();
            $users = User::all();
            $truck = Truck::where('truck_number', $booking->truck_number)->first();
            $booking->truck_name = $truck ? $truck->truck_name : $booking->truck_number;

            return view('admin.bookings.edit', compact('booking', 'trucks', 'users'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found');
        }
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $booking = Booking::findOrFail($id);
            $oldStatus = $booking->status;
            $oldQuantity = $booking->quantity;

            $validated = $request->validate([
                'user_id' => 'nullable|exists:users,id',
                'truck_id' => 'required|exists:trucks,id',
                'quantity' => 'required|integer|min:1',
                'pickup_address' => 'required|string|max:255',
                'receiver_name' => 'required|string|max:100',
                'receiver_phone' => 'required|string|max:20',
                'drop_location' => 'required|string|max:255',
                'notes' => 'nullable|string',
                'status' => 'required|in:pending,confirmed,in_transit,delivered,cancelled'
            ]);

            $truck = Truck::findOrFail($request->truck_id);

            // Check capacity if quantity changed
            if ($request->quantity != $booking->quantity) {
                $currentBooked = Booking::where('truck_number', $truck->truck_number)
                    ->where('id', '!=', $id)
                    ->where('status', '!=', 'cancelled')
                    ->sum('quantity');

                $remaining = $truck->max_capacity - $currentBooked;

                if ($request->quantity > $remaining) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Only {$remaining} egg trays available on this truck. Cannot update to {$request->quantity} trays.")->withInput();
                }
            }

            // If user is selected, update receiver info
            $user = null;
            if ($request->user_id) {
                $user = User::find($request->user_id);
            }

            $booking->update([
                'user_id' => $request->user_id ?? null,
                'truck_id' => $truck->id,
                'truck_number' => $truck->truck_number,
                'quantity' => $request->quantity,
                'pickup_address' => $request->pickup_address,
                'receiver_name' => $request->receiver_name ?? ($user ? $user->first_name . ' ' . $user->last_name : $booking->receiver_name),
                'receiver_phone' => $request->receiver_phone ?? ($user ? $user->mobile_number : $booking->receiver_phone),
                'drop_location' => $request->drop_location,
                'notes' => $request->notes ?? '',
                'status' => $request->status
            ]);

            // ✅ SEND NOTIFICATION if status changed
            if ($oldStatus !== $request->status && $booking->user_id) {
                $statusMessages = [
                    'confirmed' => 'Your booking has been confirmed and is ready for processing.',
                    'in_transit' => 'Your booking is now on the way to the destination.',
                    'delivered' => 'Your booking has been successfully delivered!',
                    'cancelled' => 'Your booking has been cancelled. Please contact support for more information.',
                    'pending' => 'Your booking is pending review.'
                ];

                $title = 'Booking ' . ucfirst($request->status);
                $message = isset($statusMessages[$request->status])
                    ? $statusMessages[$request->status] . ' Reference: ' . $booking->booking_reference
                    : 'Your booking status has been updated to ' . ucfirst($request->status);

                NotificationHelper::sendToUser(
                    $booking->user_id,
                    'booking_' . $request->status,
                    $title,
                    $message,
                    [
                        'booking_id' => $booking->id,
                        'booking_reference' => $booking->booking_reference,
                        'old_status' => $oldStatus,
                        'new_status' => $request->status,
                        'quantity' => $booking->quantity
                    ]
                );
            }

            // ✅ SEND NOTIFICATION if quantity changed significantly
            if ($oldQuantity != $request->quantity && $booking->user_id && $request->status != 'cancelled') {
                NotificationHelper::sendToUser(
                    $booking->user_id,
                    'booking_updated',
                    'Booking Updated',
                    'Your booking ' . $booking->booking_reference . ' has been updated. Quantity changed from ' . $oldQuantity . ' to ' . $request->quantity . ' trays.',
                    [
                        'booking_id' => $booking->id,
                        'booking_reference' => $booking->booking_reference,
                        'old_quantity' => $oldQuantity,
                        'new_quantity' => $request->quantity
                    ]
                );
            }

            DB::commit();

            return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update booking status only.
     */
    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,confirmed,in_transit,delivered,cancelled'
            ]);

            $booking = Booking::findOrFail($id);
            $oldStatus = $booking->status;
            $newStatus = $validated['status'];
            $booking->status = $newStatus;
            $booking->save();

            // ✅ SEND NOTIFICATION to user
            if ($booking->user_id && $oldStatus !== $newStatus) {
                $statusMessages = [
                    'confirmed' => 'Your booking has been confirmed and is ready for processing.',
                    'in_transit' => 'Your booking is now on the way to the destination.',
                    'delivered' => 'Your booking has been successfully delivered! Thank you for choosing SureCargo.',
                    'cancelled' => 'Your booking has been cancelled. Please contact support for more information.',
                    'pending' => 'Your booking status has been set to pending.'
                ];

                $title = 'Booking ' . ucfirst($newStatus);
                $message = isset($statusMessages[$newStatus])
                    ? $statusMessages[$newStatus] . ' Reference: ' . $booking->booking_reference
                    : 'Your booking status has been updated to ' . ucfirst($newStatus);

                NotificationHelper::sendToUser(
                    $booking->user_id,
                    'booking_' . $newStatus,
                    $title,
                    $message,
                    [
                        'booking_id' => $booking->id,
                        'booking_reference' => $booking->booking_reference,
                        'old_status' => $oldStatus,
                        'new_status' => $newStatus,
                        'quantity' => $booking->quantity,
                        'truck_number' => $booking->truck_number
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Booking status updated from {$oldStatus} to {$booking->status}",
                'data' => $booking
            ]);

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

    /**
     * Remove the specified booking.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $booking = Booking::findOrFail($id);
            $bookingReference = $booking->booking_reference;

            // ✅ SEND NOTIFICATION to user before deletion
            if ($booking->user_id) {
                NotificationHelper::sendToUser(
                    $booking->user_id,
                    'booking_deleted',
                    'Booking Deleted',
                    '⚠️ Your booking ' . $bookingReference . ' has been deleted by administrator. If you have questions, please contact support.',
                    [
                        'booking_id' => $booking->id,
                        'booking_reference' => $bookingReference,
                        'quantity' => $booking->quantity
                    ]
                );
            }

            $booking->delete();

            DB::commit();

            return redirect()->route('admin.bookings.index')->with('success', "Booking {$bookingReference} deleted successfully");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.bookings.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Get booking statistics for dashboard.
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'total' => Booking::count(),
                'pending' => Booking::where('status', 'pending')->count(),
                'confirmed' => Booking::where('status', 'confirmed')->count(),
                'in_transit' => Booking::where('status', 'in_transit')->count(),
                'delivered' => Booking::where('status', 'delivered')->count(),
                'cancelled' => Booking::where('status', 'cancelled')->count(),
                'total_quantity' => Booking::where('status', '!=', 'cancelled')->sum('quantity')
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send SMS to booking receiver using IPROG (token-based).
     */
    public function sendSms(Request $request)
    {
        try {
            $validated = $request->validate([
                'booking_id'      => 'required|exists:bookings,id',
                'receiver_number' => 'required|string',
                'message'         => 'required|string',
                'booking_ref'     => 'required|string'
            ]);

            $booking = Booking::findOrFail($validated['booking_id']);

            // Format phone number to international format (+63...)
            $phoneNumber = $this->formatPhoneNumber($validated['receiver_number']);

            // Validate that we have a proper number
            if (!$this->isValidPhilippineNumber($phoneNumber)) {
                throw new \Exception("Invalid phone number format: {$validated['receiver_number']}");
            }

            // Send via IPROG service
            $this->smsService->sendSms($phoneNumber, $validated['message']);

            Log::info('SMS sent successfully via IPROG', [
                'booking_id'       => $booking->id,
                'booking_reference'=> $booking->booking_reference,
                'receiver_number'  => $phoneNumber,
                'receiver_name'    => $booking->receiver_name
            ]);

            return response()->json([
                'success' => true,
                'message' => "SMS sent successfully to {$phoneNumber}"
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        } catch (\Exception $e) {
            Log::error('IPROG SMS sending failed', [
                'error'      => $e->getMessage(),
                'booking_id' => $request->booking_id ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send tracking SMS to all in-transit bookings of a batch (Bulk Send).
     */
    public function sendAllSms(Request $request, $batchId)
    {
        try {
            $batch = Batch::with('bookings')->findOrFail($batchId);

            // Get all in-transit bookings with a valid receiver phone
            $bookings = $batch->bookings
                ->where('status', 'in_transit')
                ->filter(function ($booking) {
                    return !empty($booking->receiver_phone) && $booking->receiver_phone !== 'N/A';
                });

            if ($bookings->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No in-transit bookings with valid receiver numbers found in this batch.'
                ], 400);
            }

            $sent = [];
            $errors = [];
            $totalSent = 0;
            $totalFailed = 0;

            // Single-line message (mobile-friendly)
            $messageTemplate = "Your booking ref is %s. To track: 1) Go to surecargo.com 2) Register/login 3) Click the 3 dots (top-left) 4) In the sidebar, tap 'Track validate' 5) Enter your booking ref and submit 6) See the real-time truck location!";

            foreach ($bookings as $booking) {
                $phone = $this->formatPhoneNumber($booking->receiver_phone);
                $ref   = $booking->booking_reference ?? 'N/A';

                // Skip invalid numbers
                if (!$this->isValidPhilippineNumber($phone)) {
                    $errors[] = "{$ref} → Invalid phone number: {$booking->receiver_phone}";
                    $totalFailed++;
                    continue;
                }

                $message = sprintf($messageTemplate, $ref);

                try {
                    $this->smsService->sendSms($phone, $message);
                    $sent[] = "{$ref} → {$booking->receiver_phone}";
                    $totalSent++;
                } catch (\Exception $e) {
                    $errors[] = "{$ref} → " . $e->getMessage();
                    $totalFailed++;
                }
            }

            return response()->json([
                'success'      => true,
                'total_sent'   => $totalSent,
                'total_failed' => $totalFailed,
                'sent'         => $sent,
                'errors'       => $errors
            ]);

        } catch (\Exception $e) {
            Log::error('Batch SMS sending failed', [
                'batch_id' => $batchId,
                'error'    => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send SMS: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format phone number for IPROG (Philippines, international format).
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
