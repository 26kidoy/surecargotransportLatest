<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DamageRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'booking_id', 'booking_reference', 'egg_quantity',
        'image_path', 'notes', 'status', 'admin_reply', 'replied_at'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the full URL for the damage image
     * FIXED: Properly handles public/uploads paths
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image_path)) {
            return null;
        }

        $path = $this->image_path;

        // If it's already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Remove any 'storage/' or 'public/' prefix
        $path = preg_replace('/^(storage\/|public\/)/', '', $path);

        // If path starts with 'damage-images/', convert to 'uploads/damage-images/'
        if (Str::startsWith($path, 'damage-images/')) {
            $path = 'uploads/' . $path;
        }

        // If path doesn't start with 'uploads/', add it
        if (!Str::startsWith($path, 'uploads/')) {
            $path = 'uploads/' . $path;
        }

        return asset($path);
    }

    /**
     * Get the raw image path (for deletion)
     */
    public function getImagePathAttribute($value)
    {
        return $value;
    }
}
