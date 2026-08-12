<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\TruckController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\AdminRouteController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\AboutController;
use App\Models\TruckLocation;
use App\Http\Controllers\Admin\MfaController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\DamageRequestController;
use App\Http\Controllers\TrackValidateController;
use App\Http\Controllers\UserRequestController as PublicUserRequestController;
use App\Http\Controllers\Admin\UserRequestController as AdminUserRequestController;

// ============================================================
// PUBLIC ROUTES - No authentication required
// ============================================================

Route::get('/user-request/check-status', [PublicUserRequestController::class, 'checkStatus'])->name('user-request.check-status');

// User request submission from the onboarding modal
Route::post('/user-request', [PublicUserRequestController::class, 'store'])->name('user-request.store');

// Verify secret code for old customers
Route::post('/user-request/verify-secret', [PublicUserRequestController::class, 'verifySecret'])->name('user-request.verify-secret');

// Track & Validate Routes
Route::get('/track-validate', [TrackValidateController::class, 'index'])->name('track-validate.index');
Route::post('/track-validate/check', [TrackValidateController::class, 'checkBooking'])->name('track-validate.check');

Log::info('Loading routes...');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/find', [MapController::class, 'showFind'])->name('find');
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');

Route::post('/api/chat-ai', function (Request $request) {
    $userMessage = $request->input('message');

    $systemPrompt = "
You are SureCargo AI, an expert assistant for the SureCargo egg tray transport system.

IMPORTANT RULES:
- Respond in the same language as the user (English, Tagalog, Bisaya).
- Keep answers concise, friendly, and under 200 words.
- Use bullet points for steps.
- Never make up features; if unsure, say 'I will connect you with support'.

KNOWLEDGE BASE:

1. BOOKING:
   - Go to Dashboard → choose an AVAILABLE truck → fill in quantity (egg trays), pickup address, receiver name/phone, drop-off location.
   - Admin approval takes up to 24 hours. Status becomes 'confirmed'.
   - Only 'pending' bookings can be edited or cancelled.

2. PAYMENT:
   - GCash: After confirmation, click 'Pay' → scan QR → send exact amount → upload reference number. Admin verifies → status 'approve'.
   - COD (Cash on Delivery): Select COD at booking, provide full name. Pay exact cash upon delivery.

3. TRACKING:
   - When status changes to 'in_transit', a 'Track' button appears in My Bookings.
   - Uses Reverb WebSockets + Leaflet maps to show driver GPS live.

4. TRUCK CAPACITY:
   - Each truck holds 800 to 1,500 egg trays. Dashboard shows 'Available Egg Trays' in real-time.

5. DRIVER MESSAGING:
   - Go to 'Messages' in sidebar → chat with assigned driver or admin.

6. PROFILE:
   - Update photo, mobile number, city, user type, or password via Profile page.

7. SUPPORT:
   - Email: support@surecargo.com | Hotline: +1 (800) 555-1234 | In-app chat with admin.

8. CAPSTONE:
   - Developed by 3rd year IT students, Madridejos Community College. Tech: Laravel 13, Reverb, MySQL.

Always offer further help.
";

    try {
        $response = Http::withToken(env('PUTER_AUTH_TOKEN'))
            ->timeout(15)
            ->post('https://api.puter.com/puterai/openai/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userMessage]
                ],
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);

        if ($response->successful()) {
            return response()->json([
                'reply' => $response->json('choices.0.message.content')
            ]);
        }

        \Log::error('Puter AI error', ['status' => $response->status(), 'body' => $response->body()]);
        return response()->json(['error' => 'AI unavailable'], 500);
    } catch (\Exception $e) {
        \Log::error('Puter AI exception: ' . $e->getMessage());
        return response()->json(['error' => 'Connection failed'], 500);
    }
})->middleware('web');

// ============================================================
// AUTH ROUTES
// ============================================================
Route::post('/send-otp', [RegisterController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::post('/profile/send-otp', [ProfileController::class, 'sendOtp'])->middleware('auth');
Route::post('/profile/verify-otp', [ProfileController::class, 'verifyOtp'])->middleware('auth');

Route::post('/password/forgot', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendOtp'])->name('password.forgot');
Route::post('/password/verify-otp', [App\Http\Controllers\Auth\PasswordResetController::class, 'verifyOtp'])->name('password.verify-otp');
Route::post('/password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.reset');

// ============================================================
// PUBLIC ROUTES - User verification
// ============================================================
Route::post('/user/find-by-mobile', function (Request $request) {
    $mobile = $request->input('mobile_number');
    $user = \App\Models\User::where('mobile_number', $mobile)->first();
    if ($user) {
        return response()->json([
            'success' => true,
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'mobile_number' => $user->mobile_number
            ]
        ]);
    }
    return response()->json(['success' => false, 'error' => 'User not found'], 404);
})->name('user.find-by-mobile');

Route::post('/user/verify-identity', function (Request $request) {
    $firstName = $request->input('first_name');
    $lastName = $request->input('last_name');

    $user = \App\Models\User::where('first_name', $firstName)
        ->where('last_name', $lastName)
        ->first();

    if ($user) {
        return response()->json([
            'success' => true,
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'mobile_number' => $user->mobile_number
            ]
        ]);
    }
    return response()->json([
        'success' => false,
        'error' => 'No account found with this name. Please check your spelling.'
    ], 404);
})->name('user.verify-identity');

// ============================================================
// ANNOUNCEMENTS
// ============================================================
Route::get('/announcements', [App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'show'])->name('announcements.show');

// ============================================================
// TRACKING ROUTES
// ============================================================
Route::get('/tracking/latest', function () {
    $latest = TruckLocation::latest()->first();
    if ($latest) {
        return response()->json([
            'lat' => $latest->latitude,
            'lng' => $latest->longitude,
        ]);
    }
    return response()->json(null);
})->name('tracking.latest');

Route::post('/tracking/update', [TrackingController::class, 'updateLocation'])->name('tracking.update');
Route::get('/driver/track', function () {
    return view('driver.track');
})->name('driver.track');

Route::get('/viewroute', function () {
    return view('viewroute.index');
})->name('viewroute.index');

Route::get('/tracking', function () {
    return view('viewroute.index');
})->name('tracking.user');

// ============================================================
// WELCOME PAGE
// ============================================================
Route::get('/', function () {
    return view('layouts.welcome');
})->name('welcome');

// ============================================================
// USER AUTH ROUTES
// ============================================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('user.register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

Route::post('/logout', [LoginController::class, 'logout'])->name('user.logout');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================================
// PUBLIC API ROUTES
// ============================================================
Route::get('/api/truck-stats', [BookingController::class, 'getTruckStats']);
Route::get('/api/recent-bookings', [BookingController::class, 'getRecentBookings']);
Route::post('/api/book', [BookingController::class, 'storeBooking']);
Route::get('/api/trucks-with-stats', [BookingController::class, 'getTrucksWithStats']);
Route::get('/api/truck/{id}', [BookingController::class, 'getTruckDetails']);

// ============================================================
// ADMIN ROUTES
// ============================================================
Route::prefix('admin')->name('admin.')->group(function () {

    Route::resource('announcements', App\Http\Controllers\Admin\AnnouncementController::class);
    
    // ========== MFA CHALLENGE ROUTES (NO AUTH REQUIRED) ==========
    Route::get('mfa/challenge', [MfaController::class, 'showChallengeForm'])->name('mfa.challenge');
    Route::post('mfa/verify', [MfaController::class, 'verifyOtp'])->name('mfa.verify');
    Route::post('mfa/recovery', [MfaController::class, 'useRecoveryCode'])->name('mfa.recovery');

    // Guest routes (login, register)
    Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('landing');
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register');

    // Admin route management
    Route::get('/route', [AdminRouteController::class, 'index'])->name('route.index');
    Route::post('/route/start', [AdminRouteController::class, 'start'])->name('route.start');
    Route::post('/route/stop', [AdminRouteController::class, 'stop'])->name('route.stop');
    Route::post('/route/reset', [AdminRouteController::class, 'reset'])->name('route.reset');
    Route::post('/route/toggle-direction', [AdminRouteController::class, 'toggleDirection'])->name('route.toggleDirection');
    Route::post('/route/set-position', [AdminRouteController::class, 'setPosition'])->name('route.setPosition');
    Route::get('/route/status', [AdminRouteController::class, 'status'])->name('route.status');

    // ============================================================
    // USER REQUESTS ROUTES - CORRECT ORDER (STATIC ROUTES FIRST!)
    // ============================================================
    
    // Index & Store (no {parameter} so these are safe)
    Route::get('user-requests', [AdminUserRequestController::class, 'index'])->name('user-requests.index');
    Route::post('user-requests', [AdminUserRequestController::class, 'store'])->name('user-requests.store');
    
    // ========== STATIC ROUTES FIRST (BEFORE {userRequest}) ==========
    // These routes MUST come before the dynamic {userRequest} route
    Route::post('user-requests/update-secret', [AdminUserRequestController::class, 'updateSecret'])->name('user-requests.update-secret');
    Route::get('user-requests/secret', [AdminUserRequestController::class, 'getSecret'])->name('user-requests.secret');
    Route::get('user-requests/user-count', [AdminUserRequestController::class, 'getUserCount'])->name('user-requests.user-count');
    Route::post('user-requests/send-to-all', [AdminUserRequestController::class, 'sendToAllUsers'])->name('user-requests.send-to-all');
    Route::post('user-requests/bulk-approve', [AdminUserRequestController::class, 'bulkApprove'])->name('user-requests.bulk-approve');
    Route::post('user-requests/bulk-reject', [AdminUserRequestController::class, 'bulkReject'])->name('user-requests.bulk-reject');
    
    // ========== DYNAMIC ROUTES LAST (WITH {userRequest}) ==========
    Route::get('user-requests/{userRequest}', [AdminUserRequestController::class, 'show'])->name('user-requests.show');
    Route::delete('user-requests/{userRequest}', [AdminUserRequestController::class, 'destroy'])->name('user-requests.destroy');
    Route::post('user-requests/{userRequest}/approve', [AdminUserRequestController::class, 'approve'])->name('user-requests.approve');
    Route::post('user-requests/{userRequest}/reject', [AdminUserRequestController::class, 'reject'])->name('user-requests.reject');

    // ========== AUTHENTICATED ADMIN ROUTES (require login, but MFA may not yet be enabled) ==========
    Route::middleware(['admin'])->group(function () {
        // MFA setup routes (accessible only after login, before MFA is enabled)
        Route::get('/mfa/setup', [MfaController::class, 'showSetupForm'])->name('mfa.setup');
        Route::post('/mfa/enable', [MfaController::class, 'enableMfa'])->name('mfa.enable');
    });

    // ========== MFA PROTECTED ADMIN ROUTES (require login AND MFA enabled) ==========
    Route::middleware(['admin', \App\Http\Middleware\EnsureAdminMfaEnabled::class])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // Resource controllers
        Route::resource('trucks', TruckController::class)->parameters(['trucks' => 'truck']);
        Route::resource('users', UserController::class)->parameters(['users' => 'user']);
        Route::resource('admins', AdminManagementController::class)->parameters(['admins' => 'admin']);
        Route::resource('bookings', AdminBookingController::class)->parameters(['bookings' => 'booking']);
        Route::patch('bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
        Route::patch('trucks/{id}/status', [TruckController::class, 'updateStatus'])->name('trucks.status');
        Route::post('/bookings/send-sms', [AdminBookingController::class, 'sendSms'])->name('bookings.send-sms');
        Route::post('batches/{batch}/send-all-sms', [AdminBookingController::class, 'sendAllSms'])->name('batches.send-all-sms');

        // ========== CUSTOM PAYMENT ROUTES ==========
        Route::patch('payments/{id}/status', [PaymentController::class, 'updateStatus'])->name('payments.update-status');
        Route::get('payments/export/{type}', [PaymentController::class, 'export'])->name('payments.export');
        Route::post('/payments/mass-archive', [PaymentController::class, 'massArchive'])->name('payments.mass-archive');
        Route::post('/payments/archive-all', [PaymentController::class, 'archiveAll'])->name('payments.archive-all');
        Route::get('/payments/archive', [PaymentController::class, 'archiveIndex'])->name('payments.archive.index');
        Route::patch('/payments/{payment}/archive', [PaymentController::class, 'archivePayment'])->name('payments.archive');
        Route::patch('/payments/{payment}/restore', [PaymentController::class, 'restorePayment'])->name('payments.restore');
        Route::delete('/payments/{payment}/force-delete', [PaymentController::class, 'forceDelete'])->name('payments.force-delete');

        // ========== PAYMENT RESOURCE ==========
        Route::resource('payments', PaymentController::class)->parameters(['payments' => 'payment']);

        // Payment methods configuration
        Route::get('payment-methods', [PaymentController::class, 'getPaymentMethodsConfig'])->name('payment-methods.index');
        Route::post('payment-methods/{methodKey}/update', [PaymentController::class, 'updateMethodConfig'])->name('payment-methods.update');

        // Batch routes
        Route::post('/batches/store', [BatchController::class, 'store'])->name('batches.store');
        Route::post('/batches/set-active', [BatchController::class, 'setActive'])->name('batches.set-active');
        Route::post('/batches/archive', [BatchController::class, 'archive'])->name('batches.archive');
        Route::post('/batches/restore', [BatchController::class, 'restore'])->name('batches.restore');
        Route::get('/batches/archived', [BatchController::class, 'archived'])->name('batches.archived');
        Route::delete('/batches/destroy', [BatchController::class, 'destroy'])->name('batches.destroy');

        // Fee configuration
        Route::resource('fee', FeeController::class)->only(['index', 'update']);

        // ========== DAMAGE REQUESTS (Admin) ==========
        Route::get('/damage-requests', [DamageRequestController::class, 'adminIndex'])->name('damage-requests.index');
        Route::patch('/damage-requests/{damageRequest}/status', [DamageRequestController::class, 'updateStatus'])->name('damage-requests.status');
        Route::put('/damage-requests/{damageRequest}/reply', [DamageRequestController::class, 'reply'])->name('damage-requests.reply');
        Route::get('/damage-requests/chart-data', [DamageRequestController::class, 'chartData'])->name('admin.damage-requests.chart-data');
        Route::delete('/damage-requests/{damageRequest}', [DamageRequestController::class, 'destroy'])->name('damage-requests.destroy');
    });
});

// ============================================================
// USER AUTHENTICATED ROUTES
// ============================================================
Route::middleware(['auth'])->group(function () {
    Route::put('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');
    Route::put('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/payment-request', [BookingController::class, 'requestPayment'])->name('bookings.payment-request');
});

// Notifications routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/clear-all', [App\Http\Controllers\NotificationController::class, 'clearAll'])->name('notifications.clear-all');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
});

Route::middleware(['auth'])->get('/debug-image', function() {
    $user = Auth::user();
    $debug = [
        'profile_image_db_value' => $user->profile_image,
        'storage_path_check' => storage_path('app/public/' . $user->profile_image),
        'file_exists_in_storage' => $user->profile_image ? file_exists(storage_path('app/public/' . $user->profile_image)) : false,
        'public_path_check' => $user->profile_image ? public_path('storage/' . $user->profile_image) : null,
        'symlink_exists' => file_exists(public_path('storage')),
        'is_symlink' => is_link(public_path('storage')) || is_dir(public_path('storage')),
        'all_files_in_profile_images' => Storage::disk('public')->files('profile_images'),
        'profile_image_url' => $user->profile_image_url,
    ];
    return response()->json($debug);
});

Route::patch('/admin/payments/{payment}/complete', [PaymentController::class, 'markComplete'])->name('admin.payments.complete');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('user.dashboard');
    Route::get('/bookings', [BookingController::class, 'userBookings'])->name('user.bookings');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/damage-requests', [DamageRequestController::class, 'index'])->name('damage-requests.index');
    
    // API routes for authenticated users
    Route::get('/api/payment-methods/active', [PaymentController::class, 'getActiveMethods']);
    Route::get('/api/users', [MessageController::class, 'getUsers']);
    Route::get('/api/messages/{userId}', [MessageController::class, 'getMessages']);
    Route::post('/api/messages/send', [MessageController::class, 'sendMessage']);
    Route::post('/api/messages/mark-read/{senderId}', [MessageController::class, 'markAsRead']);
    Route::get('/api/messages/unread-count', [MessageController::class, 'getUnreadCount']);
    Route::get('/api/my-bookings', [BookingController::class, 'getUserBookings']);
    Route::get('/api/stats', [BookingController::class, 'getUserStats']);
    Route::post('/api/update-profile', [ProfileController::class, 'update']);
    Route::post('/api/change-password', [ProfileController::class, 'changePassword']);

    // Damage Requests AJAX
    Route::get('/api/damage-requests/list', [DamageRequestController::class, 'getRequestsJson'])->name('damage-requests.list');
    Route::post('/api/damage-requests/store', [DamageRequestController::class, 'storeJson'])->name('damage-requests.store');
});

Route::delete('/admin/payments/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'destroy'])->name('admin.payments.destroy');

Route::post('/csp-report', function (Request $request) {
    \Log::warning('CSP Violation', $request->all());
    return response('', 204);
})->name('csp-report');