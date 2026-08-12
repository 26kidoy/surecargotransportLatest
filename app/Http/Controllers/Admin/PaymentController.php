<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\PaymentMethodConfig;
use Illuminate\Support\Facades\Session;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // Display main payments index (exclude archived)
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'booking'])
            ->whereNull('archived_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(15);

        $approvedStats = [
            'total_approved_amount' => Payment::where('status', 'approve')->sum('amount') ?? 0,
            'total_approved_count' => Payment::where('status', 'approve')->count(),
            'avg_approved_amount' => Payment::where('status', 'approve')->avg('amount') ?? 0,
            'highest_approved_amount' => Payment::where('status', 'approve')->max('amount') ?? 0,
        ];

        $paymentMethods = [];
        $requiredMethods = ['gcash', 'bank_transfer', 'paymaya'];

        foreach ($requiredMethods as $methodKey) {
            $config = PaymentMethodConfig::where('method_key', $methodKey)->first();
            if (!$config) {
                $config = $this->createDefaultConfig($methodKey);
            }
            $paymentMethods[$methodKey] = $config;
        }

        return view('admin.payment.index', compact('payments', 'approvedStats', 'paymentMethods'));
    }

    // Display archived payments
    public function archiveIndex(Request $request)
    {
        $archivedPayments = Payment::with(['user', 'booking'])
            ->whereNotNull('archived_at')
            ->orderBy('archived_at', 'desc')
            ->paginate(15);

        return view('admin.payment.archive', compact('archivedPayments'));
    }

    // Archive a single payment
    public function archivePayment(Payment $payment)
    {
        if ($payment->archived_at) {
            return response()->json(['success' => false, 'message' => 'Payment is already archived'], 400);
        }

        $payment->archived_at = now();
        $payment->save();

        return response()->json(['success' => true, 'message' => 'Payment archived successfully']);
    }

    // Restore an archived payment
    public function restorePayment(Payment $payment)
    {
        if (!$payment->archived_at) {
            return response()->json(['success' => false, 'message' => 'Payment is not archived'], 400);
        }

        $payment->archived_at = null;
        $payment->save();

        return response()->json(['success' => true, 'message' => 'Payment restored successfully']);
    }

    // Permanently delete a payment
    public function forceDelete(Payment $payment)
    {
        try {
            // Delete screenshot if exists
            if ($payment->screenshot_path) {
                $this->deleteScreenshot($payment->screenshot_path);
            }
            $payment->forceDelete();
            return response()->json(['success' => true, 'message' => 'Payment permanently deleted']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // Mass archive all non-archived payments
    public function massArchive(Request $request)
    {
        try {
            $count = Payment::whereNull('archived_at')->count();

            if ($count === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No payments to archive.'
                ], 400);
            }

            Payment::whereNull('archived_at')->update(['archived_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => $count . ' payment(s) have been archived.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error archiving payments: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive all (alias for massArchive)
    public function archiveAll()
    {
        try {
            $count = Payment::whereNull('archived_at')->count();
            Payment::whereNull('archived_at')->update(['archived_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => $count . ' payments archived.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function createDefaultConfig($methodKey)
    {
        $defaults = [
            'gcash' => [
                'display_name' => 'GCash',
                'account_name' => 'SureCargo Logistics',
                'reference_number' => '0999-123-4567',
                'instructions' => "1. Open GCash app\n2. Click \"Send Money\"\n3. Enter reference number: 0999-123-4567\n4. Input the exact amount\n5. Send screenshot to our support",
            ],
            'bank_transfer' => [
                'display_name' => 'Bank Transfer',
                'account_name' => 'SureCargo Logistics Inc.',
                'reference_number' => '1234-5678-9012-3456',
                'instructions' => "1. Transfer to BDO Account\n2. Account Name: SureCargo Logistics Inc.\n3. Account Number: 1234-5678-9012-3456\n4. Send deposit slip to support",
            ],
            'paymaya' => [
                'display_name' => 'PayMaya',
                'account_name' => 'SureCargo Logistics',
                'reference_number' => '0912-345-6789',
                'instructions' => "1. Open PayMaya app\n2. Click \"Send Money\"\n3. Enter PayMaya number: 0912-345-6789\n4. Confirm payment",
            ],
        ];

        $default = $defaults[$methodKey] ?? [
            'display_name' => ucfirst(str_replace('_', ' ', $methodKey)),
            'account_name' => '',
            'reference_number' => '',
            'instructions' => '',
        ];

        return PaymentMethodConfig::create([
            'method_key' => $methodKey,
            'display_name' => $default['display_name'],
            'account_name' => $default['account_name'],
            'reference_number' => $default['reference_number'],
            'instructions' => $default['instructions'],
            'is_active' => true,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,card,bank_transfer,online,gcash,paymaya',
            'status' => 'required|string|in:pending,approve,decline,refunded,cod',
            'transaction_id' => 'nullable|string|unique:payments,transaction_id',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'sender_name' => 'nullable|string|max:255',
            'user_reference' => 'nullable|string|max:255',
        ]);

        if (empty($validated['payment_date'])) {
            $validated['payment_date'] = now()->toDateString();
        }

        $validated['payment_reference'] = 'PAY-' . strtoupper(uniqid());

        $payment = Payment::create($validated);

        if ($payment->user_id) {
            NotificationHelper::sendToUser(
                $payment->user_id,
                'payment_created',
                'Payment Created',
                'A payment of ₱' . number_format($payment->amount, 2) . ' has been created. Reference: ' . $payment->payment_reference,
                [
                    'payment_id' => $payment->id,
                    'payment_reference' => $payment->payment_reference,
                    'amount' => $payment->amount,
                    'status' => $payment->status
                ],
                route('user.payments.show', $payment->id)
            );
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment created successfully.');
    }

    public function show($id)
    {
        $payment = Payment::with(['user', 'booking'])->findOrFail($id);
        return view('admin.payment.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $users = User::orderBy('name')->get();
        $bookings = Booking::orderBy('created_at', 'desc')->get();
        return view('admin.payment.edit', compact('payment', 'users', 'bookings'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $oldStatus = $payment->status;

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,card,bank_transfer,online,gcash,paymaya',
            'status' => 'required|string|in:pending,approve,decline,refunded,cod',
            'transaction_id' => 'nullable|string|unique:payments,transaction_id,' . $id,
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'sender_name' => 'nullable|string|max:255',
            'user_reference' => 'nullable|string|max:255',
        ]);

        $payment->update($validated);

        if ($oldStatus !== $validated['status'] && $payment->user_id) {
            $statusMessages = [
                'approve' => 'Your payment has been approved successfully!',
                'decline' => 'Your payment has been declined. Please contact support for assistance.',
                'refunded' => 'Your payment has been refunded.',
                'cod' => 'Your Cash on Delivery payment has been confirmed.'
            ];

            $title = 'Payment ' . ucfirst($validated['status']);
            $message = isset($statusMessages[$validated['status']])
                ? $statusMessages[$validated['status']] . ' Reference: ' . $payment->payment_reference
                : 'Your payment status has been updated to ' . ucfirst($validated['status']);

            NotificationHelper::sendToUser(
                $payment->user_id,
                'payment_' . $validated['status'],
                $title,
                $message,
                [
                    'payment_id' => $payment->id,
                    'payment_reference' => $payment->payment_reference,
                    'amount' => $payment->amount,
                    'old_status' => $oldStatus,
                    'new_status' => $validated['status']
                ],
                route('user.payments.show', $payment->id)
            );

            $statusText = $payment->status_text;
            $message = "Your payment #{$payment->payment_reference} status has been updated to: {$statusText}.";
            Session::put("payment_notification_{$payment->user_id}", $message);
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $oldStatus = $payment->status;

        $request->validate([
            'status' => 'required|in:pending,approve,decline,refunded,cod'
        ]);

        $payment->status = $request->status;
        $payment->save();

        if ($oldStatus !== $payment->status && $payment->user_id) {
            $statusMessages = [
                'approve' => 'Your payment has been approved successfully!',
                'decline' => 'Your payment has been declined. Please contact support for assistance.',
                'refunded' => 'Your payment has been refunded.',
                'cod' => 'Your Cash on Delivery payment has been confirmed.'
            ];

            $title = 'Payment ' . ucfirst($payment->status);
            $message = isset($statusMessages[$payment->status])
                ? $statusMessages[$payment->status] . ' Reference: ' . $payment->payment_reference
                : 'Your payment status has been updated to ' . ucfirst($payment->status);

            NotificationHelper::sendToUser(
                $payment->user_id,
                'payment_' . $payment->status,
                $title,
                $message,
                [
                    'payment_id' => $payment->id,
                    'payment_reference' => $payment->payment_reference,
                    'amount' => $payment->amount,
                    'old_status' => $oldStatus,
                    'new_status' => $payment->status
                ],
                null
            );

            $statusText = $payment->status_text;
            $message = "Your payment #{$payment->payment_reference} status has been updated to: {$statusText}.";
            Session::put("payment_notification_{$payment->user_id}", $message);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment status updated successfully.');
    }

    public function getActiveMethods()
    {
        $methods = PaymentMethodConfig::where('is_active', true)->get()->map(function($method) {
            return [
                'key' => $method->method_key,
                'method_key' => $method->method_key,
                'display_name' => $method->display_name,
                'account_name' => $method->account_name,
                'reference_number' => $method->reference_number,
                'qr_code_image' => $method->qr_code_image,
                'qr_code_url' => $method->qr_code_url,
                'instructions' => $method->instructions,
                'is_active' => $method->is_active,
            ];
        });
        return response()->json($methods);
    }

    /**
     * Update payment method configuration
     * FIXED: Now saves QR codes to public/uploads
     */
    public function updateMethodConfig(Request $request, $methodKey)
    {
        try {
            $validated = $request->validate([
                'display_name' => 'required|string|max:255',
                'account_name' => 'nullable|string|max:255',
                'reference_number' => 'nullable|string|max:255',
                'qr_code_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'instructions' => 'nullable|string',
                'is_active' => 'sometimes|boolean',
                'remove_qr' => 'sometimes|boolean'
            ]);

            $config = PaymentMethodConfig::where('method_key', $methodKey)->first();
            if (!$config) {
                $config = $this->createDefaultConfig($methodKey);
            }

            // Handle QR code upload - FIXED: Save to public/uploads
            if ($request->hasFile('qr_code_image')) {
                // Delete old QR if exists
                if ($config->qr_code_image) {
                    $this->deleteQrImage($config->qr_code_image);
                }

                $file = $request->file('qr_code_image');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $datePath = date('Y/m/d');
                $relativePath = "payment_qr/{$datePath}";
                $fullPath = public_path("uploads/{$relativePath}");

                // Create directory if it doesn't exist
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }

                // Move file to public/uploads directory
                $file->move($fullPath, $filename);

                // Store the path relative to public directory
                $config->qr_code_image = "uploads/{$relativePath}/{$filename}";

                \Log::info('QR code uploaded to public/uploads', [
                    'method' => $methodKey,
                    'path' => $config->qr_code_image
                ]);
            }

            // Remove QR if requested
            if ($request->input('remove_qr') == true && $config->qr_code_image) {
                $this->deleteQrImage($config->qr_code_image);
                $config->qr_code_image = null;
            }

            $config->display_name = $validated['display_name'];
            $config->account_name = $validated['account_name'] ?? null;
            $config->reference_number = $validated['reference_number'] ?? null;
            $config->instructions = $validated['instructions'] ?? null;
            if (isset($validated['is_active'])) {
                $config->is_active = $validated['is_active'];
            }
            $config->save();
            $config->refresh();

            return response()->json([
                'success' => true,
                'message' => ucfirst($methodKey) . ' configuration updated successfully!',
                'data' => [
                    'method_key' => $config->method_key,
                    'display_name' => $config->display_name,
                    'account_name' => $config->account_name,
                    'reference_number' => $config->reference_number,
                    'qr_code_image' => $config->qr_code_image,
                    'qr_code_url' => $config->qr_code_url,
                    'instructions' => $config->instructions,
                    'is_active' => $config->is_active,
                ],
                'qr_code_url' => $config->qr_code_url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper: Delete QR image from public/uploads
     */
    private function deleteQrImage($path)
    {
        if (empty($path)) {
            return;
        }

        try {
            // Check if it's a public/uploads path
            if (Str::startsWith($path, 'uploads/')) {
                $fullPath = public_path($path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    \Log::info('Deleted QR image from public/uploads', ['path' => $path]);
                    return;
                }
            }

            // Check if it's a storage path (old format)
            $cleanPath = preg_replace('/^(uploads\/|storage\/|public\/)/', '', $path);
            if (Storage::disk('public')->exists($cleanPath)) {
                Storage::disk('public')->delete($cleanPath);
                \Log::info('Deleted QR image from storage', ['path' => $cleanPath]);
                return;
            }

            // Try to delete just the filename (search in common locations)
            $filename = basename($path);
            $searchPaths = [
                'uploads/payment_qr/' . date('Y/m/d') . '/' . $filename,
                'uploads/payment_qr/' . $filename,
                'uploads/' . $filename,
                'payment_qr/' . date('Y/m/d') . '/' . $filename,
                'payment_qr/' . $filename,
            ];

            foreach ($searchPaths as $searchPath) {
                if (file_exists(public_path($searchPath))) {
                    unlink(public_path($searchPath));
                    \Log::info('Deleted QR image from public/uploads (search)', ['path' => $searchPath]);
                    return;
                }
                if (Storage::disk('public')->exists($searchPath)) {
                    Storage::disk('public')->delete($searchPath);
                    \Log::info('Deleted QR image from storage (search)', ['path' => $searchPath]);
                    return;
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to delete QR image: ' . $e->getMessage(), ['path' => $path]);
        }
    }

    /**
     * Helper: Delete screenshot from public/uploads
     */
    private function deleteScreenshot($path)
    {
        if (empty($path)) {
            return;
        }

        try {
            // Check if it's a public/uploads path
            if (Str::startsWith($path, 'uploads/')) {
                $fullPath = public_path($path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    \Log::info('Deleted screenshot from public/uploads', ['path' => $path]);
                    return;
                }
            }

            // Check if it's a storage path
            $cleanPath = preg_replace('/^(uploads\/|storage\/|public\/)/', '', $path);
            if (Storage::disk('public')->exists($cleanPath)) {
                Storage::disk('public')->delete($cleanPath);
                \Log::info('Deleted screenshot from storage', ['path' => $cleanPath]);
                return;
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to delete screenshot: ' . $e->getMessage(), ['path' => $path]);
        }
    }

    public function destroy($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            
            // Delete screenshot if exists
            if ($payment->screenshot_path) {
                $this->deleteScreenshot($payment->screenshot_path);
            }
            
            $payment->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment deleted successfully.'
                ]);
            }

            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.payments.index')
                ->with('error', 'Error deleting payment.');
        }
    }

    public function export($format)
    {
        $payments = Payment::with(['user', 'booking'])->whereNull('archived_at')->get();

        if ($format === 'csv') {
            $filename = 'payments_export_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://temp', 'w');

            fputcsv($handle, ['ID', 'Reference', 'User', 'Amount', 'Method', 'Status', 'Date', 'Sender', 'User Ref', 'Screenshot', 'Notes']);

            foreach ($payments as $payment) {
                fputcsv($handle, [
                    $payment->id,
                    $payment->payment_reference,
                    $payment->user->full_name ?? 'N/A',
                    $payment->amount,
                    $payment->payment_method,
                    $payment->status,
                    $payment->payment_date ?? $payment->created_at?->toDateString(),
                    $payment->sender_name ?? '',
                    $payment->user_reference ?? '',
                    $payment->screenshot_path ? 'Yes' : 'No',
                    $payment->notes,
                ]);
            }

            rewind($handle);
            $csvContent = stream_get_contents($handle);
            fclose($handle);

            return response($csvContent, 200)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }

        return redirect()->back()->with('error', 'Export format not supported.');
    }
}