<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeeHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
{
    public function index()
    {
        $fee = Fee::getCurrentFee();
        $feeHistory = FeeHistory::orderBy('created_at')->get()
            ->map(fn($item) => [
                'date'   => $item->created_at->toDateString(),
                'amount' => $item->amount,
            ]);

        return view('admin.fee.index', compact('fee', 'feeHistory'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'amount_per_tray' => 'required|numeric|min:0|max:999999.99',
        ]);

        $fee = Fee::getCurrentFee();
        $oldAmount = $fee->amount_per_tray;
        $newAmount = $request->amount_per_tray;

        $fee->amount_per_tray = $newAmount;
        $fee->updated_by = Auth::id();
        $fee->save();

        // CREATE NOTIFICATIONS FOR ALL USERS ABOUT FEE UPDATE
        if ($oldAmount != $newAmount) {
            \App\Http\Controllers\NotificationController::feeUpdated($oldAmount, $newAmount);
        }

        return redirect()->route('admin.fee.index')
            ->with('success', 'Shipping fee per egg tray updated successfully.');
    }
}
