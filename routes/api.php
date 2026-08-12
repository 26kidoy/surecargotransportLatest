<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\DamageRequestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Add this test route
Route::get('/test', function () {
    return response()->json([
        'message' => 'CORS test successful!',
        'timestamp' => now(),
        'status' => 'working'
    ]);
});

// Authenticated API routes (requires Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/damage-requests', [DamageRequestController::class, 'getUserDamageRequests']);
    Route::post('/damage-requests', [DamageRequestController::class, 'store']);
    Route::get('/user/bookings', [DamageRequestController::class, 'getUserBookings']);

     // NEW: AJAX endpoints for damage requests
    Route::get('/damage-requests/list', [DamageRequestController::class, 'getRequestsJson'])->name('damage-requests.list');
    Route::post('/damage-requests/store', [DamageRequestController::class, 'storeJson'])->name('damage-requests.store');
});

// Public API routes (no authentication required)
Route::get('/remaining-eggs', [BookingController::class, 'getRemainingEggs']);
Route::get('/remaining-eggs/{truckId}', [BookingController::class, 'getRemainingEggs']);
Route::get('/recent-bookings', [BookingController::class, 'getRecentBookings']);
Route::get('/recent-bookings/{truckId}', [BookingController::class, 'getRecentBookings']);
Route::post('/book', [BookingController::class, 'storeBooking']);
Route::get('/truck-stats', [BookingController::class, 'getTruckStats']);
Route::get('/payment-methods/active', [PaymentMethodController::class, 'getActiveMethods']);
