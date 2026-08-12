<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TruckLocationUpdated;
use App\Models\TruckLocation;
use Illuminate\Support\Facades\Log;

class TrackingController extends Controller
{
    public function updateLocation(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        // Store location
        $location = TruckLocation::create([
            'latitude' => $request->lat,
            'longitude' => $request->lng,
            'recorded_at' => now(),
        ]);

        Log::info('GPS saved', ['id' => $location->id, 'lat' => $request->lat, 'lng' => $request->lng]);

        // Keep only last 10 minutes
        TruckLocation::where('created_at', '<', now()->subMinutes(10))->delete();

        // Optional broadcast
        broadcast(new TruckLocationUpdated($request->lat, $request->lng));

        return response()->json(['status' => 'ok']);
    }
}
