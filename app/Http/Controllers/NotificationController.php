<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\DamageRequest;
use App\Models\Message;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user
     */
    public function index()
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'error' => 'User not authenticated'
                ], 401);
            }

            $notifications = Notification::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'type' => $notification->type,
                        'is_read' => (bool) $notification->is_read,
                        'read_at' => $notification->read_at,
                        'data' => $notification->data,
                        'created_at' => $notification->created_at,
                        'created_at_human' => $notification->created_at->diffForHumans(),
                        'created_at_formatted' => $notification->created_at->format('M d, Y g:i A'),
                    ];
                });

            $unreadCount = Notification::where('user_id', $userId)
                ->where('is_read', false)
                ->count();

            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            Log::error('Notification index error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch notifications'
            ], 500);
        }
    }

    /**
     * Get unread notification count
     */
    public function getUnreadCount()
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json(['count' => 0]);
            }

            $count = Notification::where('user_id', $userId)
                ->where('is_read', false)
                ->count();

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error('Unread count error: ' . $e->getMessage());
            return response()->json(['count' => 0]);
        }
    }

    /**
     * Mark a single notification as read
     */
    public function markAsRead($id)
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
            }

            $notification = Notification::where('user_id', $userId)
                ->where('id', $id)
                ->first();

            if (!$notification) {
                return response()->json(['success' => false, 'error' => 'Notification not found'], 404);
            }

            $notification->is_read = true;
            $notification->read_at = now();
            $notification->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Mark as read error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to mark as read'], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
            }

            $updatedCount = Notification::where('user_id', $userId)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'updated_count' => $updatedCount
            ]);
        } catch (\Exception $e) {
            Log::error('Mark all as read error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to mark all as read'], 500);
        }
    }

    /**
     * Clear all notifications for the user
     */
    public function clearAll(Request $request)
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'error' => 'User not authenticated'
                ], 401);
            }

            $deletedCount = Notification::where('user_id', $userId)->delete();

            Log::info('User cleared all notifications', [
                'user_id' => $userId,
                'deleted_count' => $deletedCount
            ]);

            return response()->json([
                'success' => true,
                'deleted_count' => $deletedCount,
                'message' => 'All notifications cleared successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Clear all error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to clear notifications: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a single notification
     */
    public function destroy($id)
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
            }

            $notification = Notification::where('user_id', $userId)
                ->where('id', $id)
                ->first();

            if (!$notification) {
                return response()->json(['success' => false, 'error' => 'Notification not found'], 404);
            }

            $notification->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Delete notification error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to delete'], 500);
        }
    }

    // ========== HELPER METHODS TO CREATE NOTIFICATIONS ==========

    /**
     * Create a notification for damage request status update
     */
    public static function damageRequestStatusUpdated($damageRequest, $oldStatus, $newStatus)
    {
        try {
            $statusMessages = [
                'approved' => 'approved and verified',
                'rejected' => 'reviewed and rejected',
                'pending' => 'updated'
            ];

            $actionMessage = $statusMessages[$newStatus] ?? 'updated';

            $notification = Notification::create([
                'user_id' => $damageRequest->user_id,
                'title' => 'Damage Request ' . ucfirst($newStatus),
                'message' => 'Your damage request for booking #' . $damageRequest->booking_reference . ' has been ' . $actionMessage . '.',
                'type' => 'damage_request',
                'data' => json_encode([
                    'damage_request_id' => $damageRequest->id,
                    'booking_id' => $damageRequest->booking_id,
                    'status' => $newStatus,
                    'old_status' => $oldStatus
                ]),
                'is_read' => false
            ]);

            Log::info('Notification created for damage request status update', [
                'user_id' => $damageRequest->user_id,
                'damage_request_id' => $damageRequest->id,
                'new_status' => $newStatus
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create damage request notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a notification for admin reply to damage request
     */
    public static function damageRequestReplied($damageRequest, $reply)
    {
        try {
            $notification = Notification::create([
                'user_id' => $damageRequest->user_id,
                'title' => 'New Reply on Your Damage Request',
                'message' => 'Admin has replied to your damage request for booking #' . $damageRequest->booking_reference . '.',
                'type' => 'damage_request_reply',
                'data' => json_encode([
                    'damage_request_id' => $damageRequest->id,
                    'booking_id' => $damageRequest->booking_id,
                    'reply_preview' => substr($reply, 0, 100)
                ]),
                'is_read' => false
            ]);

            Log::info('Notification created for damage request reply', [
                'user_id' => $damageRequest->user_id,
                'damage_request_id' => $damageRequest->id
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create damage request reply notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a notification for new message received
     */
    public static function newMessageReceived($message, $sender)
    {
        try {
            $notification = Notification::create([
                'user_id' => $message->receiver_id,
                'title' => 'New Message Received',
                'message' => 'You have a new message from ' . ($sender->first_name ?? 'User') . ' ' . ($sender->last_name ?? ''),
                'type' => 'message',
                'data' => json_encode([
                    'message_id' => $message->id,
                    'sender_id' => $sender->id,
                    'sender_name' => trim($sender->first_name . ' ' . $sender->last_name),
                    'message_preview' => substr($message->message, 0, 100)
                ]),
                'is_read' => false
            ]);

            Log::info('Notification created for new message', [
                'user_id' => $message->receiver_id,
                'sender_id' => $sender->id,
                'message_id' => $message->id
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create message notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a notification for booking status update
     */
    public static function bookingStatusUpdated($booking, $oldStatus, $newStatus)
    {
        try {
            $statusMessages = [
                'confirmed' => 'confirmed',
                'dispatched' => 'dispatched',
                'delivered' => 'delivered',
                'cancelled' => 'cancelled'
            ];

            $actionMessage = $statusMessages[$newStatus] ?? 'updated';

            $notification = Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking ' . ucfirst($actionMessage),
                'message' => 'Your booking #' . $booking->booking_reference . ' has been ' . $actionMessage . '.',
                'type' => 'booking',
                'data' => json_encode([
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'status' => $newStatus,
                    'old_status' => $oldStatus
                ]),
                'is_read' => false
            ]);

            Log::info('Notification created for booking status update', [
                'user_id' => $booking->user_id,
                'booking_id' => $booking->id,
                'new_status' => $newStatus
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create booking notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a notification for fee update (admin to all users)
     */
    public static function feeUpdated($oldAmount, $newAmount)
    {
        try {
            // Get all customer and poultry owner users
            $users = \App\Models\User::whereIn('user_type', ['customer', 'poultry_owner'])->get();

            $createdCount = 0;
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'Shipping Fee Updated',
                    'message' => 'The shipping fee per egg tray has been updated from $' . number_format($oldAmount, 2) . ' to $' . number_format($newAmount, 2) . '.',
                    'type' => 'fee_update',
                    'data' => json_encode([
                        'old_amount' => $oldAmount,
                        'new_amount' => $newAmount
                    ]),
                    'is_read' => false
                ]);
                $createdCount++;
            }

            Log::info('Fee update notifications sent', [
                'recipient_count' => $createdCount,
                'old_amount' => $oldAmount,
                'new_amount' => $newAmount
            ]);

            return $createdCount;
        } catch (\Exception $e) {
            Log::error('Failed to create fee update notifications: ' . $e->getMessage());
            return 0;
        }
    }
}
