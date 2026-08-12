<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouteTrip;
use Illuminate\Http\Request;

class AdminRouteController extends Controller
{
    public function index()
    {
        $trip = RouteTrip::first();
        if (!$trip) {
            $trip = RouteTrip::create([
                'status' => 'stopped',
                'direction' => 'forward'
            ]);
        }
        return view('admin.route.index', compact('trip'));
    }

    public function start()
    {
        $trip = RouteTrip::first();
        $trip->update([
            'status' => 'moving',
            'started_at' => now(),
            'current_waypoint_index' => 0
        ]);
        return response()->json(['success' => true]);
    }

    public function stop()
    {
        $trip = RouteTrip::first();
        $trip->update(['status' => 'stopped']);
        return response()->json(['success' => true]);
    }

    public function reset()
    {
        $trip = RouteTrip::first();
        $trip->update([
            'status' => 'stopped',
            'current_waypoint_index' => 0,
            'started_at' => null
        ]);
        return response()->json(['success' => true]);
    }

    public function toggleDirection()
    {
        $trip = RouteTrip::first();
        $newDirection = $trip->direction === 'forward' ? 'backward' : 'forward';
        $trip->update([
            'direction' => $newDirection,
            'status' => 'stopped',
            'started_at' => null,
            'current_waypoint_index' => 0
        ]);
        return response()->json(['success' => true, 'direction' => $newDirection]);
    }

    public function setPosition(Request $request)
    {
        $request->validate(['waypoint_index' => 'required|integer|min:0']);
        $trip = RouteTrip::first();
        // For simplicity, when jumping to a waypoint we reset the trip and set started_at
        // to simulate elapsed time equal to that waypoint's cumulative time.
        // We'll compute the needed elapsed minutes based on the current direction's cumulative array.
        // Since frontend handles the waypoint order, we just reset and set a specific started_at.
        // But easier: set started_at to now() minus the cumulative minutes of that waypoint.
        // Need the cumulative minutes for the requested waypoint - but we don't have the waypoints list here.
        // Alternative: we set status to stopped, set a special flag. For full accuracy, we'd need to recalc.
        // For demonstration, we reset the trip to start and then the frontend will jump visually.
        // But the requirement says "force to go exact location" - we'll set started_at accordingly.
        // We'll compute using the same baseWaypoints order ignoring direction for now.
        // Simpler: just reset and let frontend handle the jump via map marker? But server must store correct progress.
        // We'll set started_at = now() - (cumulative minutes of that waypoint in current direction).
        // Since we don't have the array here, we'll store a placeholder and let frontend adjust.
        // Actually, to keep it working, we'll implement a logic that sets started_at based on waypoint index.
        // I'll compute cumulative minutes for baseWaypoints (forward) - for backward we reverse.
        $baseWaypoints = [
            ["name"=>"Mohon","durationMinutes"=>0],
            ["name"=>"Santa Fe Port","durationMinutes"=>45],
            ["name"=>"Hagnaya Port","durationMinutes"=>40],
            ["name"=>"Tabuelan Port","durationMinutes"=>60],
            ["name"=>"Escalante","durationMinutes"=>65],
            ["name"=>"Sagay City","durationMinutes"=>35],
            ["name"=>"Cadiz City","durationMinutes"=>40],
            ["name"=>"Manapla City","durationMinutes"=>45],
            ["name"=>"Victorias City","durationMinutes"=>25],
            ["name"=>"Bata (Hama Moto)","durationMinutes"=>50],
            ["name"=>"Galo","durationMinutes"=>30],
            ["name"=>"Libertad","durationMinutes"=>20],
            ["name"=>"Breedco","durationMinutes"=>25]
        ];
        // compute cumulative forward
        $cumulative = 0;
        $forwardCumulative = [];
        foreach ($baseWaypoints as $i => $wp) {
            $cumulative += $wp['durationMinutes'];
            $forwardCumulative[$i] = $cumulative;
        }
        if ($trip->direction === 'forward') {
            $elapsedMinutes = $forwardCumulative[$request->waypoint_index];
        } else {
            // backward: index from end
            $revIndex = count($baseWaypoints) - 1 - $request->waypoint_index;
            $elapsedMinutes = $forwardCumulative[$revIndex];
        }
        $startedAt = now()->subMinutes($elapsedMinutes);
        $trip->update([
            'status' => 'stopped',
            'started_at' => $startedAt,
            'current_waypoint_index' => $request->waypoint_index
        ]);
        return response()->json(['success' => true]);
    }

    public function status()
    {
        $trip = RouteTrip::first();
        return response()->json($trip);
    }
}
