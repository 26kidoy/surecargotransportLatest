
@extends('admin.layouts.app')

@section('page-title', 'Archived Batches')

@section('content')
@php
    // Controller must pass $archivedBatches (only batches where archived = true)
    $archivedBatches = $archivedBatches ?? collect();
@endphp

<div class="chart-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h5 class="text-white mb-0"><i class="fas fa-archive me-2"></i> Archived Batches</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-secondary btn-sm" id="exportAllBtn">
                <i class="fas fa-file-csv me-2"></i> Export All CSV
            </button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left me-2"></i> Back to Active Batches
            </a>
        </div>
    </div>

    @if($archivedBatches->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
            No archived batches found.
        </div>
    @else
        <div id="archivedBatchesContainer">
            @foreach($archivedBatches as $batch)
                @php
                    $validStatuses = ['confirmed', 'in_transit', 'delivered'];
                    $validBookings = $batch->bookings->whereIn('status', $validStatuses);
                    $validQuantity = $validBookings->sum('quantity');
                    $validTotalAmount = $validBookings->sum('total_amount');
                    $validCount = $validBookings->count();
                @endphp
                <div class="batch-card mb-4 archived-batch" data-batch-id="{{ $batch->id }}" data-batch-number="{{ $batch->batch_number }}">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <i class="fas fa-box-archive me-2 text-secondary"></i>
                            <strong>Batch #{{ $batch->batch_number }}</strong>
                            <span class="batch-date ms-2 small">
                                <i class="far fa-calendar-alt me-1"></i> Created: {{ \Carbon\Carbon::parse($batch->created_at)->format('M d, Y H:i') }}
                            </span>
                            <span class="badge bg-secondary ms-2">ARCHIVED</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-info export-batch-btn" data-batch-id="{{ $batch->id }}" data-batch-number="{{ $batch->batch_number }}">
                                <i class="fas fa-file-csv me-1"></i> Export CSV
                            </button>
                            <button class="btn btn-sm btn-outline-success restore-batch-btn" data-batch-id="{{ $batch->id }}" data-batch-name="{{ $batch->batch_number }}">
                                <i class="fas fa-trash-restore me-1"></i> Restore
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-batch-btn" data-batch-id="{{ $batch->id }}" data-batch-number="{{ $batch->batch_number }}">
                                <i class="fas fa-trash-alt me-1"></i> Delete
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-custom table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Booking Ref</th>
                                        <th>User</th>
                                        <th>Receiver</th>
                                        <th>Quantity</th>
                                        <th>Fee/Tray</th>
                                        <th>Total Amount</th>
                                        <th>Pickup</th>
                                        <th>Drop</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($batch->bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->id }}</td>
                                            <td>{{ $booking->booking_reference ?? 'N/A' }}</td>
                                            <td>
                                                @if($booking->user)
                                                    {{ $booking->user->first_name }}<br><small>{{ $booking->user->mobile_number }}</small>
                                                @else
                                                    Guest
                                                @endif
                                            </td>
                                            <td>{{ $booking->receiver_name ?? 'N/A' }}</td>
                                            <td>{{ $booking->quantity ?? 0 }} trays</td>
                                            <td>₱{{ number_format($booking->fee_per_tray ?? 0, 2) }}</td>
                                            <td>₱{{ number_format($booking->total_amount ?? 0, 2) }}</td>
                                            <td>{{ Str::limit($booking->pickup_address ?? 'N/A', 20) }}</td>
                                            <td>{{ Str::limit($booking->drop_location ?? 'N/A', 20) }}</td>
                                            <td>
                                                <span class="badge-status
                                                    @if($booking->status == 'pending') badge-pending
                                                    @elseif($booking->status == 'confirmed') badge-warning
                                                    @elseif($booking->status == 'in_transit') badge-info
                                                    @elseif($booking->status == 'delivered') badge-active
                                                    @else badge-cancelled
                                                    @endif">
                                                    {{ ucfirst($booking->status ?? 'Unknown') }}
                                                </span>
                                            </td>
                                            <td><span class="date-visible">{{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y') }}</span></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-outline-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    {{-- EDIT BUTTON REMOVED FOR ARCHIVED BOOKINGS --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center py-3">
                                                No bookings in this archived batch.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="batch-summary bg-light p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <span class="fw-semibold text-dark">
                                    <i class="fas fa-chart-simple me-1"></i> Summary (Confirmed / In Transit / Delivered):
                                </span>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-boxes me-1"></i> Total Quantity: <strong>{{ $validQuantity }}</strong> trays
                                </span>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                    <i class="fas fa-dollar-sign me-1"></i> Total Amount: <strong>₱{{ number_format($validTotalAmount, 2) }}</strong>
                                </span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                    <i class="fas fa-clipboard-list me-1"></i> Bookings Count: <strong>{{ $validCount }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Warning Modal for CSV Export --}}
<div class="modal fade" id="exportWarningModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Confirm Export</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>You are about to export booking data as a CSV file.</p>
                <p class="mb-0"><strong>Please ensure that sensitive information is handled responsibly.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="confirmExportBtn">Confirm Export</button>
            </div>
        </div>
    </div>
</div>

{{-- Restore Confirmation Modal --}}
<div class="modal fade" id="restoreConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-trash-restore me-2"></i> Restore Batch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to restore batch <strong id="restoreBatchName"></strong>?</p>
                <p class="mb-0">It will reappear in the active batches list.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmRestoreBtn">Restore Batch</button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Delete Batch Permanently</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <strong class="text-danger">permanently delete</strong> batch <strong id="deleteBatchName"></strong>?</p>
                <p class="mb-0 text-danger"><strong>Warning:</strong> This action cannot be undone. All bookings within this batch will also be permanently deleted from the database.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Permanently Delete</button>
            </div>
        </div>
    </div>
</div>

{{-- Success Toast --}}
<div id="successToast" class="success-toast" style="display: none;">
    <i class="fas fa-check-circle me-2"></i> <span id="toastMessage"></span>
</div>

@push('styles')
<style nonce="{{ $csp_nonce }}">
/* =============================================
   PROFESSIONAL ADMIN DASHBOARD STYLES
   Theme: White / Violet
   Optimized Font Sizes
   ============================================= */

@import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap');

/* ============================================================
   BATCHES LIST - DEEPSEEK-STYLE RESPONSIVE STYLES
   Theme: White / Violet
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-light: #9c27b0;
    --violet-soft: #f3e5f5;
    --violet-dark: #4a148c;
    --white: #FFFFFF;
    --gray-100: #F8F9FC;
    --gray-200: #E9ECF0;
    --gray-600: #5A6A72;
    --shadow-sm: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
    --shadow-md: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
    --radius-card: 2rem;
    --radius-btn: 3rem;

    /* DEEPSEEK-STYLE FONT SIZES */
    --font-xs: 0.75rem;
    --font-sm: 0.875rem;
    --font-base: 1rem;
    --font-md: 1.125rem;
    --font-lg: 1.25rem;
    --font-xl: 1.5rem;
    --font-xxl: 1.75rem;
    --font-xxxl: 2.25rem;

    --sp-xs: 0.25rem;
    --sp-sm: 0.5rem;
    --sp-md: 1rem;
    --sp-lg: 1.5rem;
    --sp-xl: 2rem;
    --sp-xxl: 2.5rem;
}

/* ============================================================
   RESET & BASE
   ============================================================ */
* {
    font-family: 'Inter', 'Poppins', system-ui, sans-serif !important;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    font-size: 16px;
    -webkit-text-size-adjust: 100%;
}

body {
    font-family: 'Inter', 'Poppins', sans-serif !important;
    background: var(--white);
    color: #1A2C2A;
    font-size: var(--font-base) !important;
    font-weight: 400;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

body, html, .chart-container, .card, .table, .btn, .badge, .modal-content {
    font-family: 'Inter', 'Poppins', sans-serif !important;
    font-size: var(--font-base) !important;
}

/* ============================================================
   TYPOGRAPHY
   ============================================================ */
h1, h2, h3, h4, h5, h6, .page-title, .section-title {
    font-weight: 800 !important;
    letter-spacing: -0.02em !important;
    line-height: 1.2;
}

h1 { font-size: var(--font-xxxl) !important; }
h2 { font-size: var(--font-xxl) !important; }
h3 { font-size: var(--font-xl) !important; }
h4 { font-size: var(--font-lg) !important; }
h5 { font-size: var(--font-md) !important; font-weight: 800 !important; color: var(--violet-dark) !important; }
h6 { font-size: var(--font-base) !important; }

p, span, li, a, label, input, select, textarea, button,
.table, .badge, .small, .text-muted, .form-text,
.modal-content, .btn, .form-label, .status-badge {
    font-size: var(--font-base) !important;
    line-height: 1.6 !important;
}

/* ============================================================
   TABLE
   ============================================================ */
.table-custom td,
.table-custom th {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-sm) !important;
}

.table-custom th {
    background: var(--violet-soft);
    color: var(--violet-dark);
    font-weight: 700;
    border-bottom: 2px solid var(--violet-primary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-custom td {
    background: white;
    border-bottom: 1px solid var(--gray-200);
    color: #1A2C2A;
}

.table-custom tr:hover td {
    background-color: var(--violet-soft) !important;
    transition: all 0.3s ease;
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn, .btn-sm {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-md) !important;
    border-radius: 2.5rem !important;
    font-weight: 600 !important;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

/* Outline Success - Violet */
.btn-outline-success {
    border-color: var(--violet-primary);
    color: var(--violet-primary);
    background: transparent;
}

.btn-outline-success:hover {
    background-color: var(--violet-primary);
    color: white;
    border-color: var(--violet-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

/* Outline Info - Violet */
.btn-outline-info {
    border-color: var(--violet-primary);
    color: var(--violet-primary);
    background: transparent;
}

.btn-outline-info:hover {
    background-color: var(--violet-primary);
    color: white;
    border-color: var(--violet-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

/* Outline Danger - Violet */
.btn-outline-danger {
    border-color: var(--violet-primary);
    color: var(--violet-primary);
    background: transparent;
}

.btn-outline-danger:hover {
    background-color: var(--violet-primary);
    color: white;
    border-color: var(--violet-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

/* Primary Button - Violet */
.btn-primary {
    background-color: var(--violet-primary);
    border-color: var(--violet-primary);
    color: white;
}

.btn-primary:hover {
    background-color: var(--violet-light);
    border-color: var(--violet-light);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

/* Success Button - Violet */
.btn-success {
    background-color: var(--violet-primary);
    border-color: var(--violet-primary);
    color: white;
}

.btn-success:hover {
    background-color: var(--violet-light);
    border-color: var(--violet-light);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

/* ============================================================
   BADGES
   ============================================================ */
.badge-status,
.batch-date,
.date-visible {
    font-size: var(--font-sm) !important;
    padding: var(--sp-xs) var(--sp-md) !important;
    font-weight: 600 !important;
    border-radius: 2.5rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.batch-summary .badge {
    font-size: var(--font-sm) !important;
    padding: var(--sp-xs) var(--sp-md) !important;
    border-radius: 2.5rem;
    font-weight: 600;
}

/* Badge Active - Violet */
.badge-active {
    background: var(--violet-soft);
    color: var(--violet-dark);
    border-left: 4px solid var(--violet-primary);
}

/* Badge Pending - Violet */
.badge-pending {
    background: var(--violet-soft);
    color: var(--violet-dark);
    border-left: 4px solid var(--violet-primary);
}

/* Badge Info - Violet */
.badge-info {
    background: var(--violet-soft);
    color: var(--violet-dark);
    border-left: 4px solid var(--violet-primary);
}

/* Badge Warning - Violet */
.badge-warning {
    background: var(--violet-soft);
    color: var(--violet-dark);
    border-left: 4px solid var(--violet-primary);
}

/* Badge Success - Violet */
.badge-success {
    background: var(--violet-soft);
    color: var(--violet-dark);
    border-left: 4px solid var(--violet-primary);
}

/* Badge Danger - Violet */
.badge-danger {
    background: var(--violet-soft);
    color: var(--violet-dark);
    border-left: 4px solid var(--violet-primary);
}

/* ============================================================
   TOAST NOTIFICATION
   ============================================================ */
.success-toast {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-lg) !important;
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--violet-primary);
    color: white;
    border-radius: 2.5rem;
    z-index: 1100;
    display: none;
    align-items: center;
    box-shadow: var(--shadow-md);
    font-weight: 600;
    animation: slideUp 0.3s ease-out;
    min-height: 44px;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

/* ============================================================
   BATCH CARD
   ============================================================ */
.batch-card {
    background: #ffffff;
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-sm);
    margin-bottom: var(--sp-lg);
    border: 1px solid var(--gray-200);
    overflow: hidden;
    transition: all 0.3s ease;
}

.batch-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.batch-card[data-active="true"] {
    border-left: 6px solid var(--violet-primary);
}

.batch-card[data-active="false"] {
    border-left: 6px solid var(--violet-primary);
    opacity: 0.7;
}

.card-header {
    background: var(--gray-100);
    border-bottom: 2px solid var(--gray-200);
    padding: var(--sp-md) var(--sp-lg);
}

.card-header h5 {
    color: var(--violet-dark);
    font-weight: 800 !important;
    font-size: var(--font-md) !important;
    margin: 0;
}

/* ============================================================
   BATCH SUMMARY
   ============================================================ */
.batch-summary {
    background: var(--violet-soft) !important;
    border-top: 2px solid var(--violet-primary);
    border-radius: 0 0 var(--radius-card) var(--radius-card);
    padding: var(--sp-sm) var(--sp-lg);
}

.batch-summary .fw-semibold {
    font-weight: 600 !important;
    color: var(--violet-dark);
}

/* ============================================================
   MODAL
   ============================================================ */
.modal-content {
    border-radius: 2rem;
    border: none;
    box-shadow: 0 30px 50px rgba(0, 0, 0, 0.25);
    background: #ffffff;
    font-family: 'Inter', 'Poppins', sans-serif !important;
    font-size: var(--font-base) !important;
}

.modal-header {
    border-bottom: 3px solid var(--violet-primary);
    padding: var(--sp-md) var(--sp-lg);
    background: #ffffff;
    border-radius: 2rem 2rem 0 0;
}

.modal-title {
    color: var(--violet-primary) !important;
    font-weight: 800 !important;
    font-size: var(--font-lg) !important;
}

.modal-body {
    padding: var(--sp-lg);
    color: #1A2C2A;
    font-size: var(--font-base) !important;
}

.modal-footer {
    border-top: 1px solid var(--gray-200);
    padding: var(--sp-md) var(--sp-lg);
    border-radius: 0 0 2rem 2rem;
}

.modal-footer .btn {
    font-size: var(--font-base) !important;
    min-height: 40px;
}

/* ============================================================
   CHART CONTAINER
   ============================================================ */
.chart-container {
    background: #ffffff;
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-sm);
    padding: var(--sp-lg);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    font-family: 'Inter', 'Poppins', sans-serif !important;
    font-size: var(--font-base) !important;
}

.chart-container:hover {
    box-shadow: var(--shadow-md);
}

/* ============================================================
   PAGINATION
   ============================================================ */
.pagination {
    margin-top: var(--sp-lg);
    justify-content: center;
    gap: 4px;
    flex-wrap: wrap;
}

.pagination .page-link {
    font-size: var(--font-base) !important;
    font-weight: 600;
    border-radius: 2.5rem;
    padding: var(--sp-sm) var(--sp-md);
    color: var(--violet-primary);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    background: #ffffff;
    min-height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.pagination .page-link:hover {
    background: var(--violet-soft);
    border-color: var(--violet-primary);
    transform: translateY(-2px);
}

.pagination .active .page-link {
    background: var(--violet-primary);
    border-color: var(--violet-primary);
    color: #ffffff;
}

/* ============================================================
   STATS CARDS
   ============================================================ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--sp-md);
    margin-bottom: var(--sp-lg);
}

.stat-card {
    background: #ffffff;
    border-radius: 1.5rem;
    padding: var(--sp-md) var(--sp-lg);
    border: 1px solid var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--violet-primary);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--violet-primary);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--violet-soft);
    color: var(--violet-primary);
    font-size: var(--font-xl);
}

.stat-info h4 {
    font-size: var(--font-xs) !important;
    font-weight: 600 !important;
    color: var(--gray-600);
    margin-bottom: var(--sp-xs) !important;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.stat-number {
    font-size: var(--font-xl) !important;
    font-weight: 800 !important;
    color: var(--violet-dark);
}

/* ============================================================
   UTILITY CLASSES
   ============================================================ */
i.fa, i.fas, i.far {
    color: inherit;
    margin-right: 4px;
    font-size: var(--font-md);
}

.text-danger {
    color: var(--violet-primary) !important;
    font-weight: 600;
}

.text-success {
    color: var(--violet-primary) !important;
    font-weight: 600;
}

.text-violet {
    color: var(--violet-primary) !important;
    font-weight: 600;
}

.text-secondary {
    color: var(--gray-600) !important;
}

small, .small {
    font-weight: 400;
    color: var(--gray-600) !important;
    font-size: var(--font-sm) !important;
}

/* ============================================================
   RESPONSIVE - DEEPSEEK STYLE
   ============================================================ */

/* --- Tablets & Small Desktops (769px - 1024px) --- */
@media (min-width: 769px) and (max-width: 1024px) {
    :root {
        --font-xs: 0.75rem;
        --font-sm: 0.85rem;
        --font-base: 0.95rem;
        --font-md: 1.05rem;
        --font-lg: 1.15rem;
        --font-xl: 1.3rem;
        --font-xxl: 1.5rem;
        --font-xxxl: 1.8rem;

        --sp-xs: 0.25rem;
        --sp-sm: 0.5rem;
        --sp-md: 0.9rem;
        --sp-lg: 1.3rem;
        --sp-xl: 1.7rem;
        --sp-xxl: 2.2rem;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        font-size: var(--font-lg);
    }

    .stat-number {
        font-size: var(--font-lg) !important;
    }

    .batch-card {
        border-radius: 1.5rem;
    }
}

/* --- Mobile Devices (≤ 768px) --- */
@media (max-width: 768px) {
    :root {
        --font-xs: 0.7rem;
        --font-sm: 0.8rem;
        --font-base: 0.9rem;
        --font-md: 1rem;
        --font-lg: 1.1rem;
        --font-xl: 1.2rem;
        --font-xxl: 1.4rem;
        --font-xxxl: 1.6rem;

        --sp-xs: 0.2rem;
        --sp-sm: 0.4rem;
        --sp-md: 0.8rem;
        --sp-lg: 1.2rem;
        --sp-xl: 1.5rem;
        --sp-xxl: 2rem;
    }

    body, html, .chart-container, .card, .table, .btn, .badge, .modal-content {
        font-size: var(--font-sm) !important;
    }

    .table-custom td,
    .table-custom th {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-xs) !important;
    }

    .btn, .btn-sm {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 36px;
        border-radius: 2rem !important;
    }

    .badge-status,
    .batch-date,
    .date-visible {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    .batch-summary .badge {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    .modal-content {
        border-radius: 1.5rem;
    }

    .modal-header {
        padding: var(--sp-sm) var(--sp-md);
    }

    .modal-title {
        font-size: var(--font-md) !important;
    }

    .modal-body {
        padding: var(--sp-md);
        font-size: var(--font-sm) !important;
    }

    .modal-footer {
        padding: var(--sp-sm) var(--sp-md);
    }

    .modal-footer .btn {
        font-size: var(--font-sm) !important;
        min-height: 36px;
    }

    .chart-container {
        padding: var(--sp-md);
    }

    .success-toast {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md) !important;
        width: 90%;
        text-align: center;
        min-height: 38px;
    }

    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: var(--sp-sm);
    }

    .stat-card {
        padding: var(--sp-sm) var(--sp-md);
        border-radius: 1.2rem;
    }

    .stat-number {
        font-size: var(--font-lg) !important;
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        font-size: var(--font-base);
        border-radius: 1.5rem;
    }

    .stat-info h4 {
        font-size: 0.6rem !important;
    }

    h5 {
        font-size: var(--font-sm) !important;
    }

    .card-header {
        padding: var(--sp-sm) var(--sp-md);
    }

    .card-header h5 {
        font-size: var(--font-sm) !important;
    }

    .batch-summary {
        padding: var(--sp-xs) var(--sp-md);
    }

    .pagination .page-link {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .row.g-3 {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .row.g-4 {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .col-md-4,
    .col-md-6,
    .col-lg-3 {
        padding-left: var(--sp-xs);
        padding-right: var(--sp-xs);
    }
}

/* --- Small Phones (≤ 576px) --- */
@media (max-width: 576px) {
    :root {
        --font-xs: 0.65rem;
        --font-sm: 0.75rem;
        --font-base: 0.85rem;
        --font-md: 0.95rem;
        --font-lg: 1.05rem;
        --font-xl: 1.15rem;
        --font-xxl: 1.3rem;
        --font-xxxl: 1.5rem;

        --sp-xs: 0.15rem;
        --sp-sm: 0.3rem;
        --sp-md: 0.6rem;
        --sp-lg: 1rem;
        --sp-xl: 1.2rem;
        --sp-xxl: 1.5rem;
    }

    body, html, .chart-container, .card, .table, .btn, .badge, .modal-content {
        font-size: var(--font-xs) !important;
    }

    .table-custom td,
    .table-custom th {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-xs) !important;
    }

    .btn, .btn-sm {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 32px;
        border-radius: 1.5rem !important;
    }

    .badge-status,
    .batch-date,
    .date-visible {
        font-size: 0.6rem !important;
        padding: 0.1rem var(--sp-xs) !important;
    }

    .batch-summary .badge {
        font-size: 0.6rem !important;
        padding: 0.1rem var(--sp-xs) !important;
    }

    h5 {
        font-size: var(--font-sm) !important;
    }

    .modal-title {
        font-size: var(--font-sm) !important;
    }

    .modal-body {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm);
    }

    .modal-footer .btn {
        font-size: var(--font-xs) !important;
        min-height: 32px;
    }

    .pagination .page-link {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-xs);
        min-height: 30px;
    }

    .success-toast {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 34px;
        border-radius: 2rem;
    }

    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: var(--sp-xs);
    }

    .stat-card {
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 1rem;
    }

    .stat-number {
        font-size: var(--font-sm) !important;
    }

    .stat-icon {
        width: 32px;
        height: 32px;
        font-size: var(--font-sm);
        border-radius: 1rem;
    }

    .stat-info h4 {
        font-size: 0.5rem !important;
    }

    .card-header {
        padding: var(--sp-xs) var(--sp-sm);
    }

    .card-header h5 {
        font-size: var(--font-xs) !important;
    }

    .batch-card {
        border-radius: 1.2rem;
        margin-bottom: var(--sp-sm);
    }

    .batch-summary {
        padding: var(--sp-xs) var(--sp-sm);
    }

    .chart-container {
        padding: var(--sp-sm);
        border-radius: 1.2rem;
    }
}

/* --- Very Small Phones (≤ 400px) --- */
@media (max-width: 400px) {
    :root {
        --font-xs: 0.6rem;
        --font-sm: 0.7rem;
        --font-base: 0.8rem;
        --font-md: 0.9rem;
        --font-lg: 1rem;
        --font-xl: 1.1rem;
        --font-xxl: 1.2rem;
        --font-xxxl: 1.4rem;

        --sp-xs: 0.1rem;
        --sp-sm: 0.25rem;
        --sp-md: 0.5rem;
        --sp-lg: 0.8rem;
        --sp-xl: 1rem;
        --sp-xxl: 1.2rem;
    }

    .table-custom td,
    .table-custom th {
        font-size: 0.5rem !important;
        padding: 0.05rem 0.1rem !important;
    }

    .btn, .btn-sm {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs) !important;
        min-height: 28px;
    }

    .badge-status,
    .batch-date,
    .date-visible {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs) !important;
    }

    .batch-summary .badge {
        font-size: 0.5rem !important;
    }

    .stat-number {
        font-size: var(--font-xs) !important;
    }

    .stat-icon {
        width: 26px;
        height: 26px;
        font-size: 0.6rem;
        border-radius: 0.8rem;
    }

    .stat-info h4 {
        font-size: 0.4rem !important;
    }

    .modal-title {
        font-size: var(--font-xs) !important;
    }

    .modal-footer .btn {
        font-size: 0.5rem !important;
        min-height: 28px;
    }

    .pagination .page-link {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 24px;
    }

    .success-toast {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs) !important;
        min-height: 30px;
    }
}

/* --- Extra Small (≤ 350px) --- */
@media (max-width: 350px) {
    :root {
        --font-xs: 0.5rem;
        --font-sm: 0.6rem;
        --font-base: 0.7rem;
        --font-md: 0.8rem;
        --font-lg: 0.9rem;
        --font-xl: 1rem;
        --font-xxl: 1.1rem;
        --font-xxxl: 1.2rem;

        --sp-xs: 0.05rem;
        --sp-sm: 0.2rem;
        --sp-md: 0.4rem;
        --sp-lg: 0.6rem;
        --sp-xl: 0.8rem;
        --sp-xxl: 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 0.05rem;
    }

    .stat-card {
        padding: 0.05rem var(--sp-xs);
    }

    .stat-number {
        font-size: 0.6rem !important;
    }

    .stat-icon {
        width: 22px;
        height: 22px;
        font-size: 0.5rem;
    }

    .btn, .btn-sm {
        font-size: 0.4rem !important;
        min-height: 24px;
    }

    .modal-footer .btn {
        font-size: 0.4rem !important;
        min-height: 24px;
    }
}

/* ============================================================
   HIDDEN AUDIO
   ============================================================ */
#bgAudio {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
    user-select: none;
}
</style>
@endpush

@push('scripts')
<script nonce="{{ $csp_nonce }}">
    // ---------- Toast ----------
    function showSuccessMessage(message) {
        const toast = document.getElementById('successToast');
        const toastMsg = document.getElementById('toastMessage');
        if (!toast || !toastMsg) return;
        toastMsg.innerText = message;
        toast.style.display = 'flex';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 2000);
    }

    // ---------- Restore Batch with Modal ----------
    let pendingRestore = { id: null, number: null };

    function showRestoreModal(batchId, batchNumber) {
        pendingRestore = { id: batchId, number: batchNumber };
        const batchNameSpan = document.getElementById('restoreBatchName');
        if (batchNameSpan) batchNameSpan.innerText = batchNumber;
        const restoreModal = new bootstrap.Modal(document.getElementById('restoreConfirmModal'));
        restoreModal.show();
    }

    function confirmRestore() {
        if (!pendingRestore.id) return;
        const batchId = pendingRestore.id;
        const batchNumber = pendingRestore.number;

        fetch('{{ route("admin.batches.restore") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ batch_id: batchId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showSuccessMessage(`Batch ${batchNumber} restored!`);
                const batchCard = document.querySelector(`.archived-batch[data-batch-id="${batchId}"]`);
                if (batchCard) batchCard.remove();
                if (document.querySelectorAll('.archived-batch').length === 0) {
                    location.reload();
                }
            } else {
                alert('Error: ' + (data.message || 'Could not restore batch'));
            }
        })
        .catch(() => alert('Network error while restoring batch'))
        .finally(() => {
            pendingRestore = { id: null, number: null };
            const modalEl = document.getElementById('restoreConfirmModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });
    }

    function attachRestoreHandlers() {
        document.querySelectorAll('.restore-batch-btn').forEach(btn => {
            btn.removeEventListener('click', handleRestoreClick);
            btn.addEventListener('click', handleRestoreClick);
        });
    }

    function handleRestoreClick(e) {
        const btn = e.currentTarget;
        const batchId = btn.getAttribute('data-batch-id');
        const batchName = btn.getAttribute('data-batch-name');
        if (batchId && batchName) {
            showRestoreModal(batchId, batchName);
        }
    }

    // ---------- Delete Batch (Permanent) with Modal ----------
    let pendingDelete = { id: null, number: null };

    function showDeleteModal(batchId, batchNumber) {
        pendingDelete = { id: batchId, number: batchNumber };
        const batchNameSpan = document.getElementById('deleteBatchName');
        if (batchNameSpan) batchNameSpan.innerText = batchNumber;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        deleteModal.show();
    }

    function confirmDelete() {
        if (!pendingDelete.id) return;
        const batchId = pendingDelete.id;
        const batchNumber = pendingDelete.number;

        fetch('{{ route("admin.batches.destroy") }}', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ batch_id: batchId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showSuccessMessage(`Batch ${batchNumber} permanently deleted!`);
                const batchCard = document.querySelector(`.archived-batch[data-batch-id="${batchId}"]`);
                if (batchCard) batchCard.remove();
                if (document.querySelectorAll('.archived-batch').length === 0) {
                    location.reload();
                }
            } else {
                alert('Error: ' + (data.message || 'Could not delete batch'));
            }
        })
        .catch(() => alert('Network error while deleting batch'))
        .finally(() => {
            pendingDelete = { id: null, number: null };
            const modalEl = document.getElementById('deleteConfirmModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });
    }

    function attachDeleteHandlers() {
        document.querySelectorAll('.delete-batch-btn').forEach(btn => {
            btn.removeEventListener('click', handleDeleteClick);
            btn.addEventListener('click', handleDeleteClick);
        });
    }

    function handleDeleteClick(e) {
        const btn = e.currentTarget;
        const batchId = btn.getAttribute('data-batch-id');
        const batchNumber = btn.getAttribute('data-batch-number');
        if (batchId && batchNumber) {
            showDeleteModal(batchId, batchNumber);
        }
    }

    // ---------- CSV Export Logic (pure frontend) ----------
    let pendingExportTarget = null; // 'all' or batchId

    function showExportModal(target) {
        pendingExportTarget = target;
        const modalEl = document.getElementById('exportWarningModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }

    function escapeCsvField(field) {
        if (field === null || field === undefined) return '';
        let str = String(field);
        str = str.replace(/\n/g, ' ');
        if (str.includes(',') || str.includes('"')) {
            str = '"' + str.replace(/"/g, '""') + '"';
        }
        return str;
    }

    function exportToCSV() {
        if (!pendingExportTarget) return;

        let csvRows = [];
        let filename = '';

        if (pendingExportTarget === 'all') {
            const batches = document.querySelectorAll('.archived-batch');
            if (batches.length === 0) {
                alert('No archived batches to export.');
                return;
            }
            const headers = ['Batch Number', 'ID', 'Booking Ref', 'User', 'Receiver', 'Quantity', 'Fee/Tray', 'Total Amount', 'Pickup', 'Drop', 'Status', 'Created'];
            csvRows.push(headers.map(h => escapeCsvField(h)).join(','));

            batches.forEach(batchCard => {
                const batchNumber = batchCard.getAttribute('data-batch-number') || 'N/A';
                const table = batchCard.querySelector('table');
                if (!table) return;
                const tbody = table.querySelector('tbody');
                const rows = tbody.querySelectorAll('tr');
                rows.forEach(row => {
                    if (row.querySelector('td[colspan]')) return;
                    const tds = row.querySelectorAll('td');
                    if (tds.length === 0) return;
                    const dataTds = Array.from(tds).slice(0, -1);
                    if (dataTds.length === 0) return;
                    const rowData = [batchNumber];
                    dataTds.forEach(td => {
                        let cellText = td.innerText.trim().replace(/\n/g, ' ');
                        rowData.push(cellText);
                    });
                    csvRows.push(rowData.map(cell => escapeCsvField(cell)).join(','));
                });
            });
            filename = `all_archived_batches_export.csv`;
        } else {
            const batchCard = document.querySelector(`.archived-batch[data-batch-id="${pendingExportTarget}"]`);
            if (!batchCard) {
                alert('Batch not found.');
                return;
            }
            const batchNumber = batchCard.getAttribute('data-batch-number') || 'N/A';
            const headers = ['ID', 'Booking Ref', 'User', 'Receiver', 'Quantity', 'Fee/Tray', 'Total Amount', 'Pickup', 'Drop', 'Status', 'Created'];
            csvRows.push(headers.map(h => escapeCsvField(h)).join(','));

            const table = batchCard.querySelector('table');
            if (table) {
                const tbody = table.querySelector('tbody');
                const rows = tbody.querySelectorAll('tr');
                rows.forEach(row => {
                    if (row.querySelector('td[colspan]')) return;
                    const tds = row.querySelectorAll('td');
                    if (tds.length === 0) return;
                    const dataTds = Array.from(tds).slice(0, -1);
                    if (dataTds.length === 0) return;
                    const rowData = [];
                    dataTds.forEach(td => {
                        let cellText = td.innerText.trim().replace(/\n/g, ' ');
                        rowData.push(cellText);
                    });
                    csvRows.push(rowData.map(cell => escapeCsvField(cell)).join(','));
                });
            }
            filename = `batch_${batchNumber}_bookings.csv`;
        }

        const csvString = csvRows.join('\n');
        const blob = new Blob(["\uFEFF" + csvString], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.href = url;
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);

        showSuccessMessage(`Exported to ${filename}`);
        pendingExportTarget = null;
    }

    function attachExportHandlers() {
        const exportAllBtn = document.getElementById('exportAllBtn');
        if (exportAllBtn) {
            exportAllBtn.removeEventListener('click', handleExportAll);
            exportAllBtn.addEventListener('click', handleExportAll);
        }

        document.querySelectorAll('.export-batch-btn').forEach(btn => {
            btn.removeEventListener('click', handleExportBatch);
            btn.addEventListener('click', handleExportBatch);
        });
    }

    function handleExportAll() {
        showExportModal('all');
    }

    function handleExportBatch(e) {
        const btn = e.currentTarget;
        const batchId = btn.getAttribute('data-batch-id');
        if (batchId) {
            showExportModal(batchId);
        }
    }

    function setupModalConfirm() {
        const confirmExportBtn = document.getElementById('confirmExportBtn');
        if (confirmExportBtn) {
            confirmExportBtn.removeEventListener('click', onConfirmExport);
            confirmExportBtn.addEventListener('click', onConfirmExport);
        }

        const confirmRestoreBtn = document.getElementById('confirmRestoreBtn');
        if (confirmRestoreBtn) {
            confirmRestoreBtn.removeEventListener('click', onConfirmRestore);
            confirmRestoreBtn.addEventListener('click', onConfirmRestore);
        }

        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        if (confirmDeleteBtn) {
            confirmDeleteBtn.removeEventListener('click', onConfirmDelete);
            confirmDeleteBtn.addEventListener('click', onConfirmDelete);
        }
    }

    function onConfirmExport() {
        const modalEl = document.getElementById('exportWarningModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        exportToCSV();
    }

    function onConfirmRestore() {
        confirmRestore();
    }

    function onConfirmDelete() {
        confirmDelete();
    }

    // Initialize everything on page load
    document.addEventListener('DOMContentLoaded', function() {
        attachRestoreHandlers();
        attachDeleteHandlers();
        attachExportHandlers();
        setupModalConfirm();
    });
</script>
@endpush
@endsection

