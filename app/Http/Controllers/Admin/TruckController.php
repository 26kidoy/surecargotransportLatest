<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.trucks.index', compact('trucks'));
    }

    public function create()
    {
        return view('admin.trucks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'truck_number' => 'required|unique:trucks|max:50',
            'truck_name' => 'required|max:100',
            'driver_name' => 'required|max:100',
            'driver_phone' => 'required|max:20',
            'truck_model' => 'required|max:100',
            'color' => 'required|max:50',
            'max_capacity' => 'required|integer|min:1',
            'low_stock_threshold' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,booked,maintenance'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->truck_name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/trucks'), $imageName);
            $validated['image'] = 'uploads/trucks/' . $imageName;
        }

        Truck::create($validated);

        return redirect()->route('admin.trucks.index')
            ->with('success', 'Truck added successfully!');
    }

    public function show(Truck $truck)
    {
        $bookings = $truck->bookings()->latest()->paginate(10);
        return view('admin.trucks.show', compact('truck', 'bookings'));
    }

    public function edit(Truck $truck)
    {
        return view('admin.trucks.edit', compact('truck'));
    }

    public function update(Request $request, Truck $truck)
    {
        $validated = $request->validate([
            'truck_number' => 'required|max:50|unique:trucks,truck_number,' . $truck->id,
            'truck_name' => 'required|max:100',
            'driver_name' => 'required|max:100',
            'driver_phone' => 'required|max:20',
            'truck_model' => 'required|max:100',
            'color' => 'required|max:50',
            'max_capacity' => 'required|integer|min:1',
            'low_stock_threshold' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,booked,maintenance'
        ]);

        if ($request->hasFile('image')) {
            if ($truck->image && file_exists(public_path($truck->image))) {
                unlink(public_path($truck->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->truck_name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/trucks'), $imageName);
            $validated['image'] = 'uploads/trucks/' . $imageName;
        }

        $truck->update($validated);

        return redirect()->route('admin.trucks.index')
            ->with('success', 'Truck updated successfully!');
    }

    public function destroy(Truck $truck)
    {
        if ($truck->image && file_exists(public_path($truck->image))) {
            unlink(public_path($truck->image));
        }

        $truck->delete();

        return redirect()->route('admin.trucks.index')
            ->with('success', 'Truck deleted successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $truck = Truck::findOrFail($id);
        $truck->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
}
