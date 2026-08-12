<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaymentMethodConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'method_key',
        'display_name',
        'account_name',
        'reference_number',
        'qr_code_image',
        'instructions',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get QR code image URL
     * FIXED: Properly handles public/uploads paths
     */
    public function getQrCodeUrlAttribute()
    {
        if (empty($this->qr_code_image)) {
            return null;
        }

        $path = $this->qr_code_image;

        // If it's already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Remove any 'storage/' or 'public/' prefix
        $path = preg_replace('/^(storage\/|public\/)/', '', $path);

        // If path starts with 'payment_qr/', convert to 'uploads/payment_qr/'
        if (Str::startsWith($path, 'payment_qr/')) {
            $path = 'uploads/' . $path;
        }

        // If path doesn't start with 'uploads/', add it
        if (!Str::startsWith($path, 'uploads/')) {
            $path = 'uploads/' . $path;
        }

        // Check if file exists in public/uploads
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // Fallback: try storage path
        $storagePath = preg_replace('/^uploads\//', '', $path);
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
            return asset('storage/' . $storagePath);
        }

        return null;
    }

    /**
     * Get the raw QR code path for deletion
     */
    public function getQrCodePathAttribute()
    {
        return $this->qr_code_image;
    }

    /**
     * Check if QR code exists
     */
    public function hasQrCode()
    {
        if (empty($this->qr_code_image)) {
            return false;
        }

        $path = $this->qr_code_image;

        // Check public/uploads
        if (Str::startsWith($path, 'uploads/')) {
            return file_exists(public_path($path));
        }

        // Check storage
        $storagePath = preg_replace('/^(storage\/|public\/)/', '', $path);
        return \Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath);
    }

    /**
     * Delete the QR code image when the model is deleted
     */
    protected static function booted()
    {
        static::deleting(function ($paymentMethod) {
            if ($paymentMethod->qr_code_image) {
                $path = $paymentMethod->qr_code_image;

                // Try to delete from public/uploads
                if (Str::startsWith($path, 'uploads/')) {
                    $fullPath = public_path($path);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                        \Log::info('Deleted QR code image from public/uploads', ['path' => $path]);
                        return;
                    }
                }

                // Try to delete from storage
                $cleanPath = preg_replace('/^(uploads\/|storage\/|public\/)/', '', $path);
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($cleanPath);
                    \Log::info('Deleted QR code image from storage', ['path' => $cleanPath]);
                }
            }
        });
    }
}
