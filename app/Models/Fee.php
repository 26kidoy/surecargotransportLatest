<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FeeHistory;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = ['amount_per_tray', 'updated_by'];

    protected $casts = [
        'amount_per_tray' => 'integer',
    ];

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Helper to get the current fee (since only one row exists)
    public static function getCurrentFee(): self
    {
        return self::firstOrCreate([], ['amount_per_tray' => 0]);
    }

    // Helper to format the amount for display
    public function formattedAmount(): string
    {
        return '₱' . number_format($this->amount_per_tray, 2);
    }

    protected static function booted()
{
    static::updated(function ($fee) {
        // Only record if the amount actually changed
        if ($fee->wasChanged('amount_per_tray')) {
            FeeHistory::create([
                'amount' => $fee->amount_per_tray,
                'updated_by' => $fee->updated_by,
            ]);
        }
    });
}
}
