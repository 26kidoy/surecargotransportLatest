<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Create a new batch and set it as active (deactivate previous active).
     */
    public function store(Request $request)
    {
        // Deactivate current active batch
        Batch::where('is_active', true)->update(['is_active' => false]);

        // Create new batch
        $batch = Batch::create([
            'batch_number' => 'BATCH-' . now()->timestamp,
            'is_active' => true
        ]);

        return response()->json(['success' => true, 'batch' => $batch]);
    }

    /**
     * Set a specific batch as active, deactivate others.
     */
    public function setActive(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,id'
        ]);

        Batch::where('is_active', true)->update(['is_active' => false]);
        Batch::where('id', $request->batch_id)->update(['is_active' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Archive a batch (soft delete by setting archived flag)
     */
    public function archive(Request $request)
    {
        try {
            $request->validate([
                'batch_id' => 'required|exists:batches,id'
            ]);

            $batch = Batch::findOrFail($request->batch_id);
            $batch->archived = true;
            $batch->save();

            return response()->json(['success' => true, 'message' => 'Batch archived successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Restore an archived batch
     */
    public function restore(Request $request)
    {
        try {
            $request->validate([
                'batch_id' => 'required|exists:batches,id'
            ]);

            $batch = Batch::findOrFail($request->batch_id);
            $batch->archived = false;
            $batch->save();

            return response()->json(['success' => true, 'message' => 'Batch restored successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display archived batches page
     */
    public function archived()
    {
        $archivedBatches = Batch::with('bookings')
            ->where('archived', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.bookings.archive', compact('archivedBatches'));
    }

    /**
 * Permanently delete a batch and all its bookings
 */
public function destroy(Request $request)
{
    try {
        $request->validate([
            'batch_id' => 'required|exists:batches,id'
        ]);

        $batch = Batch::findOrFail($request->batch_id);

        // Delete all bookings in this batch first
        $batch->bookings()->delete();

        // Then delete the batch
        $batch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Batch permanently deleted successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete batch: ' . $e->getMessage()
        ], 500);
    }
}
}
