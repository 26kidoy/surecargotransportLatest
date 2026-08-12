<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckLocation extends Model
{
    protected $table = 'truck_locations';

    protected $fillable = [
        'latitude',
        'longitude',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];
}
