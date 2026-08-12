<?php
// app/Events/TruckLocationUpdated.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TruckLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $latitude;
    public $longitude;

    public function __construct($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function broadcastOn()
    {
        return new Channel('truck-location');
    }

    public function broadcastAs()
    {
        return 'location.updated';
    }
}
