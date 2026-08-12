<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Truck extends Model
{
    protected $table = 'trucks';

    protected $fillable = [
        'truck_number',
        'truck_name',
        'driver_name',
        'driver_phone',
        'truck_model',
        'color',
        'max_capacity',
        'low_stock_threshold',
        'image',
        'status'
    ];

    protected $casts = [
        'max_capacity' => 'integer',
        'low_stock_threshold' => 'integer'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'truck_number', 'truck_number');
    }

    public function getBookedQuantityAttribute()
    {
        return $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('quantity');
    }

    public function getRemainingCapacityAttribute()
    {
        $booked = $this->getBookedQuantityAttribute();
        return max(0, $this->max_capacity - $booked);
    }

    public function getPercentageUsedAttribute()
    {
        if ($this->max_capacity == 0) return 0;
        $booked = $this->getBookedQuantityAttribute();
        return round(($booked / $this->max_capacity) * 100, 2);
    }
}
