<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'booking_reference',
        'user_id',
        'truck_id',
        'truck_number',
        'product_type',
        'quantity',
        'fee_per_tray',
        'total_amount',
        'pickup_address',
        'receiver_name',
        'receiver_phone',
        'drop_location',
        'notes',
        'status',
        'batch_id'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'user_id' => 'integer',
        'truck_id' => 'integer',
        'fee_per_tray' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    protected $appends = ['payment_status'];

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class, 'truck_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }

    public function getPaymentStatusAttribute(): string
    {
        $payment = $this->payments()->latest('id')->first();
        return $payment ? $payment->status : 'unpaid';
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}
