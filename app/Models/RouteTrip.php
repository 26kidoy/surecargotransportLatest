<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteTrip extends Model
{
    protected $fillable = ['status', 'current_waypoint_index', 'started_at', 'current_lat', 'current_lng'];
}
