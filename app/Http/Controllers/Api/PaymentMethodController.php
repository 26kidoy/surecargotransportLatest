<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethodConfig;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Get active payment methods for users
     * FIXED: Properly returns QR code URLs from public/uploads
     */
    public function getActiveMethods()
    {
        $methods = PaymentMethodConfig::where('is_active', true)->get();

        return response()->json($methods->map(function($method) {
            // Get QR code URL from accessor
            $qrCodeUrl = $method->qr_code_url;

            return [
                'key' => $method->method_key,
                'method_key' => $method->method_key,
                'display_name' => $method->display_name,
                'account_name' => $method->account_name,
                'reference_number' => $method->reference_number,
                'qr_code_image' => $method->qr_code_image,
                'qr_code_url' => $qrCodeUrl, // Now properly handles public/uploads
                'instructions' => $method->instructions,
                'is_active' => $method->is_active,
            ];
        }));
    }
}
