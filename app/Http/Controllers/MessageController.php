<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function index()
    {
        return view('messages.index');
    }

    public function getUsers(Request $request)
    {
        try {
            $currentUser = Auth::user();

            if (!$currentUser) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $users = User::where('id', '!=', $currentUser->id)
                ->whereIn('user_type', ['poultry_owner', 'customer'])
                ->get()
                ->map(function ($user) use ($currentUser) {
                    $fullName = trim($user->first_name . ' ' . $user->last_name);
                    if (empty($fullName)) {
                        $fullName = $user->email ?? 'User';
                    }

                    $lastMessage = Message::where(function ($query) use ($currentUser, $user) {
                        $query->where('sender_id', $currentUser->id)
                              ->where('receiver_id', $user->id);
                    })->orWhere(function ($query) use ($currentUser, $user) {
                        $query->where('sender_id', $user->id)
                              ->where('receiver_id', $currentUser->id);
                    })->latest()->first();

                    $unreadCount = Message::where('sender_id', $user->id)
                        ->where('receiver_id', $currentUser->id)
                        ->where('is_read', false)
                        ->count();

                    $profileImage = $user->profile_image_url;
                    if (!$profileImage || $profileImage === '') {
                        $profileImage = 'https://ui-avatars.com/api/?name=' . urlencode($fullName) . '&background=0D8F81&color=fff&size=48&bold=true';
                    }

                    return [
                        'id' => $user->id,
                        'name' => $fullName,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'phone' => $user->mobile_number,
                        'city' => $user->city ?? 'Not set',
                        'user_type' => $user->user_type,
                        'profile_image_url' => $profileImage,
                        'last_message' => $lastMessage ? [
                            'message' => strlen($lastMessage->message) > 50 ? substr($lastMessage->message, 0, 47) . '...' : $lastMessage->message,
                            'time' => $lastMessage->created_at->diffForHumans(),
                            'is_sent' => $lastMessage->sender_id == $currentUser->id,
                            'timestamp' => $lastMessage->created_at->timestamp
                        ] : null,
                        'last_message_timestamp' => $lastMessage ? $lastMessage->created_at->timestamp : 0,
                        'unread_count' => $unreadCount
                    ];
                })
                ->sortByDesc(function ($user) {
                    return ($user['unread_count'] > 0 ? 1 : 0) . $user['last_message_timestamp'];
                })
                ->values();

            return response()->json($users);

        } catch (\Exception $e) {
            Log::error('Error in getUsers: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch users'], 500);
        }
    }

    public function getMessages($userId)
    {
        try {
            $currentUserId = Auth::id();
            if (!$currentUserId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $messages = Message::where(function ($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $currentUserId)
                      ->where('receiver_id', $userId);
            })->orWhere(function ($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $currentUserId);
            })->orderBy('created_at', 'asc')->get();

            $messagesWithFormatting = $messages->map(function ($message) use ($currentUserId) {
                return [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'message' => $message->message,
                    'is_read' => $message->is_read,
                    'read_at' => $message->read_at,
                    'created_at' => $message->created_at,
                    'time_formatted' => $message->created_at->format('g:i A'),
                    'date_formatted' => $message->created_at->format('M d, Y'),
                    'is_sent_by_me' => $message->sender_id == $currentUserId,
                    'is_recent' => $message->created_at->diffInMinutes() < 5
                ];
            });

            return response()->json($messagesWithFormatting);

        } catch (\Exception $e) {
            Log::error('Error in getMessages: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch messages'], 500);
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'message' => 'required|string|max:1000'
            ]);

            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'is_read' => false
            ]);

            // CREATE NOTIFICATION FOR RECEIVER
            $sender = Auth::user();
            \App\Http\Controllers\NotificationController::newMessageReceived($message, $sender);

            $messageData = [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'message' => $message->message,
                'is_read' => false,
                'read_at' => null,
                'created_at' => $message->created_at,
                'time_formatted' => $message->created_at->format('g:i A'),
                'date_formatted' => $message->created_at->format('M d, Y'),
                'is_sent_by_me' => true,
                'is_recent' => true
            ];

            return response()->json([
                'success' => true,
                'message' => $messageData
            ]);

        } catch (\Exception $e) {
            Log::error('Error in sendMessage: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to send message'], 500);
        }
    }

    public function markAsRead($senderId)
    {
        try {
            $updated = Message::where('sender_id', $senderId)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'updated_count' => $updated
            ]);

        } catch (\Exception $e) {
            Log::error('Error in markAsRead: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to mark as read'], 500);
        }
    }

    public function getUnreadCount()
    {
        try {
            $count = Message::where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->count();

            return response()->json(['count' => $count]);

        } catch (\Exception $e) {
            Log::error('Error in getUnreadCount: ' . $e->getMessage());
            return response()->json(['count' => 0], 500);
        }
    }
}
