<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_id',
        'payment_reference',
        'transaction_id',
        'amount',
        'payment_method',
        'status',
        'payment_date',
        'notes',
        'sender_name',
        'user_reference',
        'screenshot_path', // Added
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the booking associated with the payment.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get status badge color (for UI).
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'approve' => 'success',
            'decline' => 'danger',
            'refunded' => 'info',
            'cod' => 'primary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Get human-readable status text.
     */
    public function getStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Pending',
            'approve' => 'Approved',
            'decline' => 'Declined',
            'refunded' => 'Refunded',
            'cod' => 'Cash on Delivery',
        ];

        return $texts[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get payment method icon.
     */
    public function getPaymentMethodIconAttribute()
    {
        $icons = [
            'cash' => 'fa-money-bill-wave',
            'card' => 'fa-credit-card',
            'bank_transfer' => 'fa-university',
            'online' => 'fa-globe',
            'gcash' => 'fa-mobile-alt',
            'paymaya' => 'fa-credit-card',
            'cod' => 'fa-money-bill',
        ];

        return $icons[$this->payment_method] ?? 'fa-receipt';
    }

    /**
     * Get display date (fallback to created_at if payment_date is null)
     */
    public function getDisplayDateAttribute()
    {
        if ($this->payment_date) {
            return $this->payment_date->format('Y-m-d');
        }
        return $this->created_at ? $this->created_at->format('Y-m-d') : 'N/A';
    }

    /**
     * Get screenshot URL
     */
    public function getScreenshotUrlAttribute()
    {
        if (empty($this->screenshot_path)) {
            return null;
        }

        $path = $this->screenshot_path;

        // If it's already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Remove any 'storage/' or 'public/' prefix
        $path = preg_replace('/^(storage\/|public\/)/', '', $path);

        // If path doesn't start with 'uploads/', add it
        if (!str_starts_with($path, 'uploads/')) {
            $path = 'uploads/' . $path;
        }

        // Check if file exists in public/uploads
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // Fallback: try storage path
        $storagePath = preg_replace('/^uploads\//', '', $path);
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
            return asset('storage/' . $storagePath);
        }

        return null;
    }

    // app/Models/Payment.php

    public function scopeNotArchived($query)
    {
        return $query->whereNull('archived_at');
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function archive()
    {
        $this->archived_at = now();
        $this->save();
    }

    public function restore()
    {
        $this->archived_at = null;
        $this->save();
    }

    protected $dates = ['created_at', 'updated_at', 'archived_at'];
}