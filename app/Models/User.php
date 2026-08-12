<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_number',
        'city',
        'profile_image',
        'user_type',
        'password',
        'role',
        'is_admin',
        'device_id', // Added device_id to fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Get the username for authentication (mobile number)
     */
    public function username()
    {
        return 'mobile_number';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin' || $this->is_admin === true;
    }

    // app/Models/User.php
    public function damageRequests()
    {
        return $this->hasMany(DamageRequest::class);
    }

    /**
     * Get user's full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Relationships
     */

    /**
     * Get messages sent by the user
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get messages received by the user
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get unread messages for the user
     */
    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')->where('is_read', false);
    }

    /**
     * Get bookings made by the user
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope for filtering by user type
     */
    public function scopeCustomers($query)
    {
        return $query->where('user_type', 'customer');
    }

    public function scopeDrivers($query)
    {
        return $query->where('user_type', 'driver');
    }

    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'admin');
    }

    public function scopePoultryOwners($query)
    {
        return $query->where('user_type', 'poultry_owner');
    }

    /**
     * Helper methods for user type checking
     */
    public function isCustomer()
    {
        return $this->user_type === 'customer';
    }

    public function isDriver()
    {
        return $this->user_type === 'driver';
    }

    public function isPoultryOwner()
    {
        return $this->user_type === 'poultry_owner';
    }

    /**
     * Get profile image URL with default fallback
     * FIXED: Properly handles both storage and public/uploads paths
     */
    public function getProfileImageUrlAttribute()
    {
        // Check if user has a profile image
        if (empty($this->profile_image)) {
            return $this->getDefaultAvatarAttribute();
        }

        $path = $this->profile_image;

        // If it's already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Check if it's a public/uploads path (new format)
        if (Str::startsWith($path, 'uploads/')) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) {
                return asset($path);
            }
            // If file doesn't exist, try to find it
            return $this->findExistingImage($path);
        }

        // Check if it's a storage path (old format)
        if (Str::startsWith($path, 'profile_images/') || Str::startsWith($path, 'public/')) {
            // Try storage path
            $cleanPath = preg_replace('/^(public\/|storage\/)/', '', $path);
            if (Storage::disk('public')->exists($cleanPath)) {
                return asset('storage/' . $cleanPath);
            }

            // Try public/uploads as fallback
            $uploadPath = 'uploads/' . $cleanPath;
            if (file_exists(public_path($uploadPath))) {
                return asset($uploadPath);
            }
        }

        // Try different path variations
        return $this->findExistingImage($path);
    }

    /**
     * Find existing image by trying different path variations
     */
    private function findExistingImage($path)
    {
        // Remove any leading slashes or prefixes
        $cleanPath = preg_replace('/^(public\/|storage\/|uploads\/|\/)/', '', $path);

        // Try public/uploads
        $uploadPath = 'uploads/' . $cleanPath;
        if (file_exists(public_path($uploadPath))) {
            return asset($uploadPath);
        }

        // Try storage
        if (Storage::disk('public')->exists($cleanPath)) {
            return asset('storage/' . $cleanPath);
        }

        // Try with profile_images prefix
        if (!Str::startsWith($cleanPath, 'profile_images/')) {
            $profilePath = 'profile_images/' . $cleanPath;
            if (Storage::disk('public')->exists($profilePath)) {
                return asset('storage/' . $profilePath);
            }
        }

        // If all else fails, return default avatar
        return $this->getDefaultAvatarAttribute();
    }

    /**
     * Get the default avatar URL
     */
    public function getDefaultAvatarAttribute()
    {
        $name = $this->getFullNameAttribute();
        $fallbackName = 'User';

        if (empty($name) || trim($name) === '') {
            $name = $fallbackName;
        }

        // Use a clean URL-encoded name
        $encodedName = urlencode($name);

        return "https://ui-avatars.com/api/?name={$encodedName}&background=0D8F81&color=fff&size=120&bold=true";
    }

    /**
     * Get the user's avatar (alias for profile_image_url)
     */
    public function getAvatarAttribute()
    {
        return $this->profile_image_url;
    }

    /**
     * Check if the user has a profile image
     */
    public function hasProfileImage()
    {
        if (empty($this->profile_image)) {
            return false;
        }

        $path = $this->profile_image;

        // Check if it's a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return true;
        }

        // Check public/uploads
        if (Str::startsWith($path, 'uploads/') && file_exists(public_path($path))) {
            return true;
        }

        // Check storage
        $cleanPath = preg_replace('/^(public\/|storage\/)/', '', $path);
        if (Storage::disk('public')->exists($cleanPath)) {
            return true;
        }

        return false;
    }

    /**
     * Get the absolute path to the profile image file
     */
    public function getProfileImagePathAttribute()
    {
        if (empty($this->profile_image)) {
            return null;
        }

        $path = $this->profile_image;

        // If it's a full URL, return null (can't get file path)
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return null;
        }

        // Check public/uploads
        if (Str::startsWith($path, 'uploads/')) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) {
                return $fullPath;
            }
        }

        // Check storage
        $cleanPath = preg_replace('/^(public\/|storage\/)/', '', $path);
        if (Storage::disk('public')->exists($cleanPath)) {
            return Storage::disk('public')->path($cleanPath);
        }

        return null;
    }
}
