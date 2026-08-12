<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['batch_number', 'is_active'];
    public $timestamps = false;

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
