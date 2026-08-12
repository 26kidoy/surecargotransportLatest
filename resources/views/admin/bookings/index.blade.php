@extends('admin.layouts.app')

@section('title', 'Manage Bookings')
@section('page-title', 'Bookings Management')

@section('content')
@php
    // Only non-archived batches should be passed from controller (for display)
    $batches = $batches ?? collect();
    $bookingsCollection = $bookings ?? collect();

    // --- Calculate chart data from ALL batches (including archived) ---
    $allBatchesChartLabels = [];
    $allBatchesChartData = [];

    // --- Calculate global stats for ALL batches (including archived) ---
    // Total Sales = SUM of total_amount WHERE status = 'delivered'
    // Pending, Confirmed, Delivered, Cancelled = COUNT of bookings with each status
    $globalStats = [
        'total_sales' => 0,      // Only delivered bookings total amount
        'pending' => 0,
        'confirmed' => 0,
        'delivered' => 0,
        'cancelled' => 0,
    ];

    try {
        $allBatches = \App\Models\Batch::with('bookings')->get();
        foreach ($allBatches as $batch) {
            $deliveredAmount = $batch->bookings->where('status', 'delivered')->sum('total_amount');
            if ($deliveredAmount > 0) {
                $allBatchesChartLabels[] = 'Batch #' . $batch->batch_number;
                $allBatchesChartData[] = $deliveredAmount;
            }

            // Accumulate global stats from ALL bookings in this batch (including archived)
            foreach ($batch->bookings as $booking) {
                // Total Sales only counts delivered bookings
                if ($booking->status === 'delivered') {
                    $globalStats['total_sales'] += $booking->total_amount ?? 0;
                }

                // Count bookings by status
                switch ($booking->status) {
                    case 'pending':
                        $globalStats['pending']++;
                        break;
                    case 'confirmed':
                        $globalStats['confirmed']++;
                        break;
                    case 'delivered':
                        $globalStats['delivered']++;
                        break;
                    case 'cancelled':
                        $globalStats['cancelled']++;
                        break;
                }
            }
        }
    } catch (\Exception $e) {
        $allBatchesChartLabels = [];
        $allBatchesChartData = [];
        $globalStats = ['total_sales' => 0, 'pending' => 0, 'confirmed' => 0, 'delivered' => 0, 'cancelled' => 0];
    }
@endphp

<div class="chart-container">
    {{-- Top Stats Flex Row --}}
    <div class="top-stats-row mb-4">
        <div class="stats-flex-container">
            <div class="stat-card stat-total-sales">
                <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                    <polyline points="17 6 23 6 23 12" />
                    </svg></i></div>
                <div class="stat-details">
                    <span class="stat-label">Total Sales (Delivered Only)</span>
                    <span class="stat-value">₱{{ number_format($globalStats['total_sales'], 2) }}</span>
                </div>
            </div>
            <div class="stat-card stat-pending">
                <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg></i></div>
                <div class="stat-details">
                    <span class="stat-label">Pending</span>
                    <span class="stat-value">{{ $globalStats['pending'] }}</span>
                </div>
            </div>
            <div class="stat-card stat-confirmed">
                <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 12l2 2 4-4" />
                </svg></i></div>
                <div class="stat-details">
                    <span class="stat-label">Confirmed</span>
                    <span class="stat-value">{{ $globalStats['confirmed'] }}</span>
                </div>
            </div>
            <div class="stat-card stat-delivered">
                <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 16l4-4-4-4" />
                    <path d="M8 8l-4 4 4 4" />
                    <path d="M12 12h.01" />
                </svg></i></div>
                <div class="stat-details">
                    <span class="stat-label">Delivered</span>
                    <span class="stat-value">{{ $globalStats['delivered'] }}</span>
                </div>
            </div>
            <div class="stat-card stat-cancelled">
                <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="16" />
                </svg></i></div>
                <div class="stat-details">
                    <span class="stat-label">Cancelled</span>
                    <span class="stat-value">{{ $globalStats['cancelled'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Collapsible Total Sales Chart Section --}}
    <div class="card mb-4 bg-white border-0 shadow-sm chart-wrapper-card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h5 class="mb-0">
                <i class="fas fa-chart-line text-success me-2"></i>
                Total Sales (Delivered Bookings) – All Batches (Archived Included)
            </h5>
            <div class="d-flex gap-2">
                <button id="toggleChartBtn" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chart-simple me-1"></i> Hide Chart
                </button>
                <a href="{{ route('admin.batches.archived') }}" class="btn btn-secondary btn-sm me-2">
                    <i class="fas fa-archive me-2"></i> View Archived Batches
                </a>
                <button id="exportPdfBtn" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf me-2"></i> Export as PDF
                </button>
            </div>
        </div>
        <div class="card-body p-4" id="chartBody">
            <div class="chart-canvas-wrapper">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h5 class="text-white mb-0">All Active Batches</h5>
        <div class="d-flex gap-2">
            <button type="button" id="doneBookingsBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDoneModal">
                <i class="fas fa-check-circle me-1"></i> Done Bookings?
            </button>
            <a href="{{ route('admin.bookings.create') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-plus me-2"></i>Add New Booking (to active batch)
            </a>
        </div>
    </div>

    <div id="batchesContainer">
        @foreach($batches as $batch)
            @php
                $validStatuses = ['confirmed', 'in_transit', 'delivered'];
                $validBookings = $batch->bookings->whereIn('status', $validStatuses);
                $validQuantity = $validBookings->sum('quantity');
                $validTotalAmount = $validBookings->sum('total_amount');
                $validCount = $validBookings->count();
                $batchDeliveredAmount = $batch->bookings->where('status', 'delivered')->sum('total_amount');
                // Count in_transit bookings (eligible for SMS sending)
                $inTransitCount = $batch->bookings->where('status', 'in_transit')->count();
            @endphp
            <div class="batch-card mb-4" data-batch-id="{{ $batch->id }}" data-active="{{ $batch->is_active ? 'true' : 'false' }}" data-batch-delivered="{{ $batchDeliveredAmount }}">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <i class="fas fa-archive me-2 text-{{ $batch->is_active ? 'success' : 'secondary' }}"></i>
                        <strong>Batch #{{ $batch->batch_number }}</strong>
                        <span class="batch-date ms-2 small">
                            <i class="far fa-calendar-alt me-1"></i> Created: {{ \Carbon\Carbon::parse($batch->created_at)->format('M d, Y H:i') }}
                        </span>
                        @if($batch->is_active)
                            <span class="badge bg-success ms-2">ACTIVE (new bookings go here)</span>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        {{-- Send All button --}}
                        <button class="btn btn-sm btn-primary send-all-sms-btn"
                                data-batch-id="{{ $batch->id }}"
                                data-batch-name="{{ $batch->batch_number }}"
                                data-in-transit-count="{{ $inTransitCount }}"
                                {{ $inTransitCount == 0 ? 'disabled' : '' }}
                                title="{{ $inTransitCount == 0 ? 'No in-transit bookings to send' : 'Send tracking SMS to all in-transit bookings' }}">
                            <i class="fas fa-paper-plane"></i> Send All
                        </button>
                        <button class="btn btn-sm btn-outline-info export-batch-csv" data-batch-id="{{ $batch->id }}" data-batch-name="{{ $batch->batch_number }}">
                            <i class="fas fa-file-csv"></i> Export CSV
                        </button>
                        @if(!$batch->is_active)
                            <button class="btn btn-sm btn-outline-primary set-active-batch" data-id="{{ $batch->id }}" data-batch-name="{{ $batch->batch_number }}">
                                <i class="fas fa-play"></i> Set as active
                            </button>
                        @endif
                        {{-- Archive button triggers custom warning modal --}}
                        <button class="btn btn-sm btn-outline-danger archive-batch-trigger-btn"
                                data-batch-id="{{ $batch->id }}"
                                data-batch-name="{{ $batch->batch_number }}"
                                data-batch-delivered-amount="{{ $batchDeliveredAmount }}"
                                data-bs-toggle="modal"
                                data-bs-target="#archiveWarningModal">
                            <i class="fas fa-box-archive"></i> Archive
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0 batch-table" data-batch-id="{{ $batch->id }}">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Booking Ref</th>
                                    <th>User</th>
                                    <th>Receiver Name</th>
                                    <th>Receiver Number</th>
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
                                        <td>{{ $booking->receiver_phone ?? 'N/A' }}</td>
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
                                                {{-- SEND BUTTON - changes to checkmark after success --}}
                                                <button class="btn btn-outline-success send-sms-btn {{ $booking->status !== 'in_transit' ? 'disabled' : '' }}"
                                                        data-booking-id="{{ $booking->id }}"
                                                        data-receiver-number="{{ $booking->receiver_phone }}"
                                                        data-booking-ref="{{ $booking->booking_reference ?? 'N/A' }}"
                                                        title="Send tracking instructions to receiver"
                                                        {{ $booking->status !== 'in_transit' ? 'disabled' : '' }}>
                                                    {{-- SVG Paper Plane Icon --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                                                    </svg>
                                                </button>
                                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-outline-info" title="View">
                                                    {{-- SVG Eye Icon --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                        <circle cx="12" cy="12" r="3"/>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-outline-warning" title="Edit">
                                                    {{-- SVG Edit Icon (Pencil) --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                                    </svg>
                                                </a>
                                                <button class="btn btn-outline-danger delete-booking-btn" data-booking-id="{{ $booking->id }}" title="Delete">
                                                    {{-- SVG Trash Icon --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center py-3">
                                            No bookings in this batch yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="batch-summary bg-light p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-semibold text-dark">
                                <i class="fas fa-chart-simple me-1"></i> Active Bookings Summary (Confirmed / In Transit / Delivered):
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

    <div id="bookingsPagination" class="mt-4 d-flex justify-content-center">
        {{ $bookings->links() }}
    </div>
</div>

{{-- Hidden element to store chart data from all batches (including archived) for JS --}}
<div id="allBatchesChartData" class="d-none" data-labels='@json($allBatchesChartLabels)' data-values='@json($allBatchesChartData)'></div>

{{-- Success Toast --}}
<div id="successToast" class="success-toast">
    <i class="fas fa-check-circle me-2"></i> <span id="toastMessage"></span>
</div>

{{-- MODALS --}}
<div class="modal fade" id="confirmDoneModal" tabindex="-1" aria-labelledby="confirmDoneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Confirm New Batch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to finish the current active batch and create a new batch?</p>
                <p class="mb-0"><strong>Note:</strong> All new bookings will be added to the newly created batch. The current active batch will be marked as completed.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmCreateBatchBtn"><i class="fas fa-check-circle me-1"></i> Yes, create new batch</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteBookingModal" tabindex="-1" aria-labelledby="deleteBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-trash-alt me-2"></i> Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this booking?</p>
                <p class="mb-0 text-muted">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><i class="fas fa-trash me-1"></i> Yes, Delete</button>
            </div>
        </div>
    </div>
</div>

{{-- Archive Warning Modal --}}
<div class="modal fade" id="archiveWarningModal" tabindex="-1" aria-labelledby="archiveWarningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Archive Batch Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to archive this batch?</p>
                <div class="alert alert-info mt-2">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Important Note:</strong> Archiving a batch will remove it from the active list, but it <strong>will NOT affect</strong> the statistics displayed at the top. All data from archived batches remains permanently counted.
                </div>
                <p class="mb-0 text-muted">The batch will be moved to the Archived Batches section, where you can still view its data.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="confirmArchiveBtn"><i class="fas fa-box-archive me-1"></i> Yes, Archive Batch</button>
            </div>
        </div>
    </div>
</div>

{{-- Set As Active Warning Modal --}}
<div class="modal fade" id="setActiveModal" tabindex="-1" aria-labelledby="setActiveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-exchange-alt me-2"></i> Set Active Batch</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to set batch <strong id="setActiveBatchNameDisplay"></strong> as the active batch?</p>
                <p class="mb-0 text-muted">Future bookings will be assigned to this batch. The previously active batch will be marked as inactive.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmSetActiveBtn"><i class="fas fa-check-circle me-1"></i> Yes, Set as Active</button>
            </div>
        </div>
    </div>
</div>

{{-- Export CSV Warning Modal --}}
<div class="modal fade" id="exportCsvModal" tabindex="-1" aria-labelledby="exportCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-file-csv me-2"></i> Export CSV</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Export bookings for batch <strong id="exportBatchNameDisplay"></strong> to CSV file?</p>
                <p class="mb-0 text-muted">The file will include all bookings currently in this batch, including their status and amounts.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" id="confirmExportCsvBtn"><i class="fas fa-download me-1"></i> Yes, Export CSV</button>
            </div>
        </div>
    </div>
</div>

{{-- Send SMS Confirmation Modal --}}
<div class="modal fade" id="sendSmsModal" tabindex="-1" aria-labelledby="sendSmsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-paper-plane me-2"></i> Send Tracking Instructions</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Send tracking SMS to <strong id="smsReceiverNumber"></strong>?</p>
                <div class="alert alert-info mt-2">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Message Preview:</strong><br>
                    <span id="smsPreview">Your booking ref is [REF] to track you must go:
                        1.Go to surecargo.com 2.Register/Login 3. Click 3 dots 4.In side bar click "Track validate" 5. Paste or Input your booking reference.</span>
                </div>
                <p class="mb-0 text-muted">This will send an SMS to the receiver's mobile number with tracking instructions.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmSendSmsBtn"><i class="fas fa-paper-plane me-1"></i> Send SMS</button>
            </div>
        </div>
    </div>
</div>

{{-- Send All SMS Confirmation & Progress Modal (with warning) --}}
<div class="modal fade" id="sendAllSmsModal" tabindex="-1" aria-labelledby="sendAllSmsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-paper-plane me-2"></i> Send All SMS</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{-- WARNING SECTION (initially visible) --}}
                <div id="sendAllWarning">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> You are about to send SMS to <strong id="sendAllCountWarning"></strong> in‑transit booking(s) in batch <strong id="sendAllBatchNameWarning"></strong>.
                    </div>
                    <p class="mb-0 text-muted">Each receiver will receive a tracking instruction SMS. This action may incur charges. Please confirm before proceeding.</p>
                </div>

                {{-- PROGRESS SECTION (initially hidden) --}}
                <div id="sendAllProgress" style="display: none;">
                    <p>Sending tracking SMS to <strong id="sendAllCount"></strong> in‑transit booking(s) in batch <strong id="sendAllBatchName"></strong>.</p>
                    <div class="progress" style="height: 25px;">
                        <div id="sendAllProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                    <div id="sendAllLog" class="mt-3 small" style="max-height: 200px; overflow-y: auto;"></div>
                </div>

                {{-- RESULT SECTION (initially hidden) --}}
                <div id="sendAllResult" style="display: none;">
                    <div class="alert alert-success" id="sendAllSuccessAlert"></div>
                    <div class="alert alert-danger" id="sendAllErrorAlert"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="sendAllCloseBtn">Close</button>
                <button type="button" class="btn btn-primary" id="sendAllStartBtn"><i class="fas fa-paper-plane me-1"></i> Confirm & Send</button>
            </div>
        </div>
    </div>
</div>

{{-- PDF Export Modal --}}
<div class="modal fade" id="pdfExportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Export Chart as PDF</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <p class="text-secondary mb-2" style="font-size: 1.4rem; font-weight: 500;">Chart: <span id="pdfExportChartTitle" class="fw-bold text-dark">Total Sales (Delivered)</span></p>
                    </div>
                    <div class="col-12">
                        <div class="border rounded p-3 bg-light text-center">
                            <img id="pdfExportPreview" src="" alt="Chart Preview" class="img-fluid" style="max-height: 350px; width: auto; margin: 0 auto;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size: 1.2rem;">Page Orientation</label>
                        <select id="pdfOrientation" class="form-select form-select-lg">
                            <option value="landscape">Landscape</option>
                            <option value="portrait">Portrait</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size: 1.2rem;">Page Size</label>
                        <select id="pdfPageSize" class="form-select form-select-lg">
                            <option value="a4">A4</option>
                            <option value="letter">Letter</option>
                            <option value="legal">Legal</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-lg btn-danger" id="pdfDownloadBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-right: 6px;">
                        <path d="M12 16V4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 12L12 16L16 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 20H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@push('styles')
<style nonce="{{ $csp_nonce }}">
@import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap');

/* ============================================================
   SALES DASHBOARD - DEEPSEEK-STYLE RESPONSIVE STYLES
   Theme: White / Violet
   FIXED: Mobile responsiveness, chart sizing, padding issues
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-light: #9c27b0;
    --violet-soft: #f3e5f5;
    --violet-dark: #4a148c;
    --violet-lighter: #faf8ff;
    --white: #FFFFFF;
    --gray-100: #F8F9FC;
    --gray-200: #E9ECF0;
    --gray-600: #5A6A72;
    --shadow-sm: 0 10px 25px -5px rgba(123, 31, 162, 0.05), 0 2px 4px -2px rgba(123, 31, 162, 0.02);
    --shadow-md: 0 20px 35px -12px rgba(123, 31, 162, 0.08);
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
    overflow-x: hidden;
    width: 100%;
}

body, .card, .table, .btn, .form-select, .form-control, .pagination, .modal-content, label, input, select, textarea {
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
h5 { font-size: var(--font-md) !important; }
h6 { font-size: var(--font-base) !important; }

p, span, li, a, label, input, select, textarea, button,
.table, .badge, .small, .text-muted, .form-text,
.modal-content, .btn, .form-label, .status-badge {
    font-size: var(--font-base) !important;
    line-height: 1.6 !important;
}

.chart-container h5,
.card-header h5,
.modal-title {
    font-size: var(--font-md) !important;
    font-weight: 700 !important;
    color: var(--violet-dark) !important;
}

.top-stats-row .stat-value {
    font-size: var(--font-xl) !important;
}

/* ============================================================
   TABLE
   ============================================================ */
.table-custom td,
.table-custom th {
    font-size: var(--font-base) !important;
    padding: var(--sp-md) var(--sp-md) !important;
    font-weight: 400 !important;
}

.table-custom th {
    background: var(--violet-soft);
    color: var(--violet-dark);
    font-weight: 700 !important;
    border-bottom: 2px solid var(--violet-primary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-custom td {
    background: white;
    border-bottom: 1px solid var(--gray-200);
}

.table-custom tr:hover td {
    background-color: var(--violet-soft) !important;
    transition: all 0.3s ease;
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn,
.btn-sm {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-lg) !important;
    border-radius: 3rem !important;
    font-weight: 600 !important;
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
    transition: all 0.3s ease;
}

.btn-success {
    background-color: var(--violet-primary) !important;
    border-color: var(--violet-dark) !important;
    color: white !important;
}
.btn-success:hover {
    background-color: var(--violet-light) !important;
    border-color: var(--violet-primary) !important;
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
    color: white !important;
}

.btn-danger {
    background-color: var(--violet-primary) !important;
    border-color: var(--violet-dark) !important;
    color: white !important;
}
.btn-danger:hover {
    background-color: var(--violet-light) !important;
    border-color: var(--violet-primary) !important;
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
    color: white !important;
}

.btn-outline-primary {
    border-color: var(--violet-primary) !important;
    color: var(--violet-primary) !important;
}
.btn-outline-primary:hover {
    background-color: var(--violet-primary) !important;
    color: white !important;
    transform: translateY(-2px);
}

/* ============================================================
   BADGES - Violet Theme
   ============================================================ */
.badge-status,
.batch-date,
.date-visible {
    font-size: var(--font-sm) !important;
    padding: var(--sp-xs) var(--sp-md) !important;
    font-weight: 600 !important;
}

.batch-summary .badge {
    font-size: var(--font-sm) !important;
    padding: var(--sp-xs) var(--sp-sm) !important;
}

.batch-summary .fw-semibold {
    font-size: var(--font-base) !important;
}

.badge-active {
    background: var(--violet-soft) !important;
    color: var(--violet-dark) !important;
    border: 1px solid var(--violet-primary);
    border-left: 4px solid var(--violet-primary);
}
.badge-warning {
    background: var(--violet-soft) !important;
    color: var(--violet-dark) !important;
    border: 1px solid var(--violet-primary);
    border-left: 4px solid var(--violet-primary);
}
.badge-info {
    background: var(--violet-soft) !important;
    color: var(--violet-dark) !important;
    border: 1px solid var(--violet-primary);
    border-left: 4px solid var(--violet-primary);
}
.badge-pending {
    background: var(--violet-soft) !important;
    color: var(--violet-dark) !important;
    border: 1px solid var(--violet-primary);
    border-left: 4px solid var(--violet-primary);
}

/* ============================================================
   TOAST NOTIFICATION
   ============================================================ */
.success-toast {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-lg) !important;
    display: none;
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: var(--violet-primary);
    color: white;
    border-radius: 48px;
    box-shadow: 0 8px 24px rgba(123, 31, 162, 0.15);
    z-index: 9999;
    font-weight: 600;
    align-items: center;
    animation: slideIn 0.3s ease-out;
    min-height: 44px;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* ============================================================
   LAYOUT & STYLING
   ============================================================ */
.chart-container {
    padding-top: var(--sp-md);
}

.chart-canvas-wrapper {
    position: relative;
    height: 550px;
    width: 100%;
    background: #ffffff;
    border-radius: 1rem;
    padding: var(--sp-sm);
}

/* FIX: Chart responsiveness */
#salesChart {
    display: block;
    width: 100% !important;
    height: 100% !important;
    max-width: 100%;
}

.chart-container canvas {
    width: 100% !important;
    height: 100% !important;
    max-width: 100%;
}

.d-none {
    display: none !important;
}

/* ============================================================
   TOP STATS FLEX ROW STYLES - FIXED
   ============================================================ */
.top-stats-row {
    width: 100%;
    margin-bottom: var(--sp-xl);
}

.stats-flex-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: var(--sp-lg);
    padding: var(--sp-md);
}

.stat-card {
    flex: 1;
    min-width: 160px;
    background: white;
    border-radius: 1.5rem;
    padding: var(--sp-md) var(--sp-lg);
    display: flex;
    align-items: center;
    gap: var(--sp-md);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 6px;
    height: 100%;
    border-radius: 1.5rem 0 0 1.5rem;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--violet-primary);
}

.stat-icon {
    font-size: var(--font-xl);
    width: 56px;
    text-align: center;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 28px;
    background: var(--violet-soft);
    flex-shrink: 0;
}

.stat-details {
    flex: 1;
    min-width: 0;
}

.stat-label {
    display: block;
    font-size: var(--font-sm);
    font-weight: 600;
    color: var(--gray-600);
    margin-bottom: var(--sp-xs);
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.stat-value {
    display: block;
    font-size: var(--font-xl);
    font-weight: 800;
    line-height: 1.2;
    color: var(--violet-dark);
    word-break: break-word;
}

/* Individual stat card colors - Violet theme */
.stat-total-sales .stat-icon { background: var(--violet-soft); color: var(--violet-primary); }
.stat-total-sales .stat-value { color: var(--violet-dark); }

.stat-pending .stat-icon { background: var(--violet-soft); color: var(--violet-primary); }
.stat-pending .stat-value { color: var(--violet-dark); }

.stat-confirmed .stat-icon { background: var(--violet-soft); color: var(--violet-primary); }
.stat-confirmed .stat-value { color: var(--violet-dark); }

.stat-delivered .stat-icon { background: var(--violet-soft); color: var(--violet-primary); }
.stat-delivered .stat-value { color: var(--violet-dark); }

.stat-cancelled .stat-icon { background: var(--violet-soft); color: var(--violet-primary); }
.stat-cancelled .stat-value { color: var(--violet-dark); }

/* ============================================================
   BATCH CARD - Violet Theme
   ============================================================ */
.batch-card {
    background: #ffffff;
    border-radius: 1.5rem;
    box-shadow: var(--shadow-sm);
    margin-bottom: var(--sp-lg);
    border: 1px solid var(--gray-200);
    overflow: hidden;
}

.batch-card[data-active="true"] {
    border-left: 6px solid var(--violet-primary);
    background: #fefefe;
}
.batch-card[data-active="false"] {
    border-left: 6px solid var(--violet-primary);
}

.card-header {
    background: var(--violet-soft);
    border-bottom: 2px solid var(--violet-primary);
    padding: var(--sp-md) var(--sp-lg);
}

/* ============================================================
   BATCH SUMMARY - Violet Theme
   ============================================================ */
.batch-summary {
    background: var(--violet-soft) !important;
    border-top: 2px solid var(--violet-primary);
    border-radius: 0 0 1.5rem 1.5rem;
    padding: var(--sp-md) var(--sp-lg);
}

/* ============================================================
   MODAL - Violet Theme - FIXED
   ============================================================ */
.modal-content {
    border-radius: 2.5rem;
    border: none;
    box-shadow: 0 30px 50px rgba(123, 31, 162, 0.15);
    background: #ffffff;
    font-family: 'Inter', 'Poppins', sans-serif !important;
    font-size: var(--font-base) !important;
    max-width: 100%;
}

.modal-header {
    border-bottom: 3px solid var(--violet-primary);
    padding: var(--sp-lg) var(--sp-xl);
    background: #ffffff;
    border-radius: 2.5rem 2.5rem 0 0;
}

.modal-title {
    color: var(--violet-primary) !important;
    font-weight: 800 !important;
    font-size: var(--font-lg) !important;
}

.modal-body {
    padding: var(--sp-xl);
    color: #2c2c3e;
    font-size: var(--font-base) !important;
}

.modal-body p {
    font-size: var(--font-base) !important;
}

.modal-footer {
    border-top: 1px solid var(--gray-200);
    padding: var(--sp-lg) var(--sp-xl);
    border-radius: 0 0 2.5rem 2.5rem;
}

.modal-footer .btn {
    font-size: var(--font-base) !important;
    min-height: 40px;
}

/* ============================================================
   CHART WRAPPER CARD - FIXED
   ============================================================ */
.chart-wrapper-card {
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    background: white;
    border: 1px solid var(--gray-200);
    transition: box-shadow 0.2s ease;
}

.chart-wrapper-card:hover {
    box-shadow: var(--shadow-md);
}

.chart-wrapper-card .card-header {
    background: #ffffff;
    border-bottom: 2px solid var(--violet-primary);
    padding: var(--sp-md) var(--sp-lg);
}

.chart-wrapper-card .card-header h5 {
    color: var(--violet-dark);
    font-weight: 700 !important;
    font-size: var(--font-md) !important;
}

.chart-wrapper-card .card-body {
    padding: var(--sp-lg) !important;
}

/* ============================================================
   SVG ICONS
   ============================================================ */
svg {
    width: 1.4rem;
    height: 1.4rem;
}

/* ============================================================
   UTILITY CLASSES - Violet Theme
   ============================================================ */
i.fa, i.fas, i.far {
    color: inherit;
    margin-right: 6px;
    font-size: var(--font-md);
}

.text-danger {
    color: var(--violet-primary) !important;
    font-weight: 600;
}

.text-success {
    color: var(--violet-dark) !important;
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
   RESPONSIVE - FIXED AND IMPROVED
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
        width: 48px;
        height: 48px;
        font-size: var(--font-lg);
    }

    .stat-value {
        font-size: var(--font-lg) !important;
    }

    .stat-label {
        font-size: var(--font-xs) !important;
    }

    .chart-canvas-wrapper {
        height: 400px;
    }

    .stats-flex-container {
        gap: var(--sp-md);
        padding: var(--sp-sm);
    }

    .stat-card {
        padding: var(--sp-sm) var(--sp-md);
        min-width: 140px;
    }

    .modal-content {
        border-radius: 2rem;
    }
}

/* --- Mobile Devices (≤ 768px) - FIXED --- */
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

    /* Base font sizing */
    body, .card, .table, .btn, .form-select, .form-control, .pagination, .modal-content, label, input, select, textarea {
        font-size: var(--font-sm) !important;
    }

    p, span, li, a, label, input, select, textarea, button,
    .table, .badge, .small, .text-muted, .form-text,
    .modal-content, .btn, .form-label, .status-badge {
        font-size: var(--font-sm) !important;
    }

    /* Table adjustments */
    .table-custom td,
    .table-custom th {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-xs) !important;
        white-space: normal !important;
        word-break: break-word !important;
    }

    /* Buttons - bigger touch targets */
    .btn,
    .btn-sm {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md) !important;
        min-height: 38px !important;
        border-radius: 2rem !important;
    }

    /* Badges */
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

    .batch-summary .fw-semibold {
        font-size: var(--font-sm) !important;
    }

    /* Headings */
    .chart-container h5,
    .card-header h5,
    .modal-title {
        font-size: var(--font-md) !important;
    }

    .top-stats-row .stat-value {
        font-size: var(--font-lg) !important;
    }

    /* Stats - Stack vertically on mobile */
    .stats-flex-container {
        flex-direction: column !important;
        gap: var(--sp-sm) !important;
        padding: var(--sp-xs) !important;
    }

    .stat-card {
        min-width: auto !important;
        width: 100% !important;
        padding: var(--sp-sm) var(--sp-md) !important;
        border-radius: 1.2rem !important;
        flex: 0 0 auto !important;
    }

    .stat-icon {
        font-size: var(--font-lg);
        width: 44px;
        height: 44px;
        border-radius: 22px;
        flex-shrink: 0;
    }

    .stat-value {
        font-size: var(--font-lg) !important;
    }

    .stat-label {
        font-size: var(--font-xs) !important;
    }

    /* Chart - FIXED responsive height */
    .chart-canvas-wrapper {
        height: 300px !important;
        padding: var(--sp-xs) !important;
    }

    .chart-wrapper-card .card-header {
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    .chart-wrapper-card .card-body {
        padding: var(--sp-sm) !important;
    }

    /* Modal - FIXED */
    .modal-content {
        border-radius: 1.5rem !important;
        margin: 0.5rem !important;
    }

    .modal-header {
        padding: var(--sp-sm) var(--sp-md) !important;
        border-radius: 1.5rem 1.5rem 0 0 !important;
    }

    .modal-title {
        font-size: var(--font-md) !important;
    }

    .modal-body {
        padding: var(--sp-md) !important;
        font-size: var(--font-sm) !important;
    }

    .modal-footer {
        padding: var(--sp-sm) var(--sp-md) !important;
        flex-wrap: wrap !important;
        gap: 0.5rem !important;
    }

    .modal-footer .btn {
        font-size: var(--font-sm) !important;
        min-height: 38px !important;
        flex: 1 !important;
        min-width: 80px !important;
    }

    /* Toast notification */
    .success-toast {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md) !important;
        min-height: 38px;
        bottom: 20px;
        right: 20px;
        left: 20px;
        max-width: calc(100% - 40px);
    }

    /* Card headers */
    .card-header {
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    /* Batch cards */
    .batch-card {
        border-radius: 1.2rem !important;
        margin-bottom: var(--sp-sm) !important;
    }

    .batch-summary {
        padding: var(--sp-xs) var(--sp-md) !important;
    }

    /* Grid spacing */
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
        padding-left: var(--sp-xs) !important;
        padding-right: var(--sp-xs) !important;
    }

    /* SVG icons */
    svg {
        width: 1.2rem !important;
        height: 1.2rem !important;
    }

    i.fa, i.fas, i.far {
        font-size: var(--font-sm);
        margin-right: 4px;
    }
}

/* --- Small Phones (≤ 576px) - FIXED --- */
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

    body, .card, .table, .btn, .form-select, .form-control, .pagination, .modal-content, label, input, select, textarea {
        font-size: var(--font-xs) !important;
    }

    .table-custom td,
    .table-custom th {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-xs) !important;
    }

    .btn,
    .btn-sm {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 34px !important;
        border-radius: 1.5rem !important;
    }

    .badge-status,
    .batch-date,
    .date-visible {
        font-size: 0.6rem !important;
        padding: 0.1rem var(--sp-xs) !important;
    }

    .chart-container h5,
    .card-header h5,
    .modal-title {
        font-size: var(--font-sm) !important;
    }

    .top-stats-row .stat-value {
        font-size: var(--font-md) !important;
    }

    .stat-card {
        padding: var(--sp-xs) var(--sp-sm) !important;
        border-radius: 1rem !important;
        gap: var(--sp-xs) !important;
    }

    .stat-icon {
        font-size: var(--font-base);
        width: 36px !important;
        height: 36px !important;
        border-radius: 18px !important;
    }

    .stat-value {
        font-size: var(--font-md) !important;
    }

    .stat-label {
        font-size: 0.6rem !important;
    }

    /* Chart - FIXED even smaller height */
    .chart-canvas-wrapper {
        height: 250px !important;
        padding: var(--sp-xs) !important;
    }

    .modal-body {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) !important;
    }

    .modal-footer .btn {
        font-size: var(--font-xs) !important;
        min-height: 34px !important;
    }

    .success-toast {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 34px;
        border-radius: 32px;
        bottom: 15px;
        right: 15px;
        left: 15px;
        max-width: calc(100% - 30px);
    }

    .stats-flex-container {
        gap: var(--sp-xs) !important;
        padding: var(--sp-xs) !important;
    }

    .batch-card {
        border-radius: 1rem !important;
    }

    .batch-summary {
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    svg {
        width: 1rem !important;
        height: 1rem !important;
    }

    i.fa, i.fas, i.far {
        font-size: var(--font-sm);
        margin-right: 3px;
    }

    /* Modal on small phones */
    .modal-content {
        border-radius: 1rem !important;
        margin: 0.25rem !important;
    }

    .modal-header {
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    .modal-body {
        padding: var(--sp-sm) !important;
    }

    .modal-footer {
        padding: var(--sp-xs) var(--sp-sm) !important;
        flex-direction: column !important;
    }

    .modal-footer .btn {
        width: 100% !important;
        min-width: auto !important;
    }
}

/* --- Very Small Phones (≤ 400px) - FIXED --- */
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

    .btn,
    .btn-sm {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs) !important;
        min-height: 30px !important;
        border-radius: 1rem !important;
    }

    .stat-icon {
        width: 30px !important;
        height: 30px !important;
        font-size: 0.7rem !important;
        border-radius: 14px !important;
    }

    .stat-value {
        font-size: var(--font-sm) !important;
    }

    .stat-label {
        font-size: 0.5rem !important;
    }

    /* Chart - FIXED */
    .chart-canvas-wrapper {
        height: 200px !important;
        padding: 0.1rem !important;
    }

    .modal-footer .btn {
        font-size: 0.5rem !important;
        min-height: 30px !important;
        padding: 0.2rem 0.3rem !important;
    }

    .success-toast {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs) !important;
        min-height: 30px;
        border-radius: 24px;
        bottom: 10px;
        right: 10px;
        left: 10px;
        max-width: calc(100% - 20px);
    }

    .card-header {
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    .batch-card {
        border-radius: 0.8rem !important;
    }

    .modal-header {
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    .modal-title {
        font-size: var(--font-xs) !important;
    }

    .modal-body {
        padding: var(--sp-xs) !important;
    }

    .modal-footer {
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    .stats-flex-container {
        gap: 0.15rem !important;
        padding: 0.1rem !important;
    }

    .stat-card {
        padding: 0.15rem 0.3rem !important;
        border-radius: 0.6rem !important;
        gap: 0.2rem !important;
    }
}

/* --- Extra Small (≤ 350px) - FIXED --- */
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

    .stat-icon {
        width: 24px !important;
        height: 24px !important;
        font-size: 0.5rem !important;
        border-radius: 12px !important;
    }

    .stat-value {
        font-size: 0.6rem !important;
    }

    .stat-label {
        font-size: 0.4rem !important;
    }

    /* Chart - FIXED */
    .chart-canvas-wrapper {
        height: 180px !important;
        padding: 0.05rem !important;
    }

    .btn,
    .btn-sm {
        font-size: 0.4rem !important;
        min-height: 26px !important;
    }

    .modal-footer .btn {
        font-size: 0.4rem !important;
        min-height: 26px !important;
    }

    .success-toast {
        font-size: 0.4rem !important;
        min-height: 26px;
        border-radius: 20px;
        padding: 0.1rem 0.3rem !important;
    }

    .stat-card {
        padding: 0.1rem 0.2rem !important;
        border-radius: 0.5rem !important;
    }

    .modal-content {
        border-radius: 0.8rem !important;
    }

    .modal-body {
        padding: 0.15rem !important;
    }

    .card-header {
        padding: 0.1rem 0.2rem !important;
    }
}

/* ============================================================
   FIX: Better table scrolling on mobile
   ============================================================ */
@media (max-width: 768px) {
    .table-responsive {
        border: none !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
    }

    .table-custom {
        min-width: 500px !important;
        width: 100% !important;
    }
}

/* ============================================================
   FIX: Chart container for mobile
   ============================================================ */
.chart-wrapper-card .card-body {
    overflow: hidden !important;
}

.chart-wrapper-card .card-body canvas {
    max-width: 100% !important;
    height: auto !important;
}

/* ============================================================
   FIX: Modal body scrolling
   ============================================================ */
.modal-body {
    max-height: 70vh !important;
    overflow-y: auto !important;
    -webkit-overflow-scrolling: touch !important;
}

@media (max-width: 576px) {
    .modal-body {
        max-height: 60vh !important;
    }
}

/* ============================================================
   FIX: Prevent horizontal scroll
   ============================================================ */
.container,
.container-fluid,
.row {
    max-width: 100% !important;
    overflow-x: hidden !important;
}

.col-12,
.col-sm-6,
.col-md-4,
.col-lg-3 {
    max-width: 100% !important;
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

.batch-summary {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
}
.batch-summary .d-flex {
    flex-wrap: nowrap !important;
    min-width: max-content !important;
}

/* ============================================================
   CHART FONT SIZE CONTROLS
   ============================================================ */

/* Chart canvas container */
.chart-canvas-wrapper {
    position: relative;
    width: 100% !important;
    max-width: 100% !important;
    height: 550px;
    background: #ffffff;
    border-radius: 1rem;
    padding: var(--sp-sm);
    overflow: hidden !important;
}

/* Force chart canvas to be responsive */
#salesChart {
    display: block !important;
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;
}

/* Chart.js specific overrides */
.chart-container canvas {
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;
}

/* Legend text size control */
.chart-container .chartjs-legend {
    font-size: var(--font-sm) !important;
}

.chart-container .chartjs-legend li {
    font-size: var(--font-sm) !important;
}

/* Tooltip text size */
.chart-container .chartjs-tooltip {
    font-size: var(--font-sm) !important;
}

/* --- Mobile font size overrides --- */
@media (max-width: 768px) {
    .chart-canvas-wrapper {
        height: 300px !important;
        padding: var(--sp-xs) !important;
    }

    /* Chart.js text sizes on mobile */
    .chart-container .chartjs-legend {
        font-size: 0.6rem !important;
    }

    .chart-container .chartjs-legend li {
        font-size: 0.6rem !important;
    }

    /* Override Chart.js internal styles */
    .chart-container canvas + div {
        font-size: 0.6rem !important;
    }
}

@media (max-width: 576px) {
    .chart-canvas-wrapper {
        height: 250px !important;
        padding: var(--sp-xs) !important;
    }

    .chart-container .chartjs-legend {
        font-size: 0.5rem !important;
    }

    .chart-container .chartjs-legend li {
        font-size: 0.5rem !important;
        padding: 2px 4px !important;
    }
}

@media (max-width: 400px) {
    .chart-canvas-wrapper {
        height: 200px !important;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script nonce="{{ $csp_nonce }}">
    // --- GLOBAL CHART CONFIGURATION ---
    Chart.defaults.font.family = 'Inter, Poppins, "Segoe UI", system-ui, -apple-system, sans-serif';
    Chart.defaults.font.weight = '700';

    let salesChart = null;
    let autoRefreshInterval = null;
    let isRefreshing = false;
    let bookingToDelete = null;
    let archiveBatchId = null;
    let archiveBatchName = null;
    let chartVisible = true;

    // Variables for modals
    let setActiveBatchId = null;
    let setActiveBatchName = null;
    let exportBatchId = null;
    let exportBatchName = null;

    // Variables for Send SMS
    let pendingSmsBookingId = null;
    let pendingSmsReceiverNumber = null;
    let pendingSmsBookingRef = null;
    let pendingSmsButton = null;

    // Variables for PDF export
    let pdfExportDataURL = null;

    // Variables for Send All
    let sendAllBatchId = null;
    let sendAllBatchName = null;
    let sendAllButton = null;   // store reference to the Send All button

    // ===== PERSIST SENT STATES =====
    let sentBookings = [];        // array of booking IDs that have been sent
    let sentBatches = [];         // array of batch IDs that have been sent (Send All)

    function showSuccessMessage(message) {
        const toast = document.getElementById('successToast');
        const toastMsg = document.getElementById('toastMessage');
        if (!toast || !toastMsg) return;
        toastMsg.innerText = message;
        toast.style.display = 'flex';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }

    function getChartDataFromDOM() {
        const chartDiv = document.getElementById('allBatchesChartData');
        if (!chartDiv) return { labels: [], data: [] };
        let labels = [];
        let values = [];
        try {
            labels = JSON.parse(chartDiv.getAttribute('data-labels') || '[]');
            values = JSON.parse(chartDiv.getAttribute('data-values') || '[]');
        } catch(e) {
            console.warn('Failed to parse chart data', e);
        }
        return { labels, data: values };
    }

   function updateChartFromAllBatches() {
    if (!chartVisible) return;

    const canvas = document.getElementById('salesChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const { labels, data } = getChartDataFromDOM();
    const displayLabels = labels.length ? labels : ['No delivered bookings'];
    const displayData = labels.length ? data : [0];

    if (salesChart) {
        salesChart.destroy();
    }

    // ==================== RESPONSIVE FONT SIZES ====================
    function getResponsiveFontSizes() {
        const width = window.innerWidth;

        // Base sizes that scale down on mobile
        let sizes = {
            tooltipBody: 26,
            tooltipTitle: 28,
            legend: 28,
            xTicks: 24,
            xTitle: 30,
            yTicks: 24,
            yTitle: 30,
            barRadius: 16,
            padding: { top: 24, bottom: 16, left: 12, right: 12 }
        };

        // Tablet (769px - 1024px)
        if (width >= 769 && width <= 1024) {
            sizes.tooltipBody = 18;
            sizes.tooltipTitle = 20;
            sizes.legend = 18;
            sizes.xTicks = 16;
            sizes.xTitle = 20;
            sizes.yTicks = 16;
            sizes.yTitle = 20;
            sizes.barRadius = 12;
            sizes.padding = { top: 16, bottom: 12, left: 10, right: 10 };
        }
        // Mobile (≤ 768px)
        else if (width <= 768) {
            sizes.tooltipBody = 12;
            sizes.tooltipTitle = 14;
            sizes.legend = 12;
            sizes.xTicks = 10;
            sizes.xTitle = 14;
            sizes.yTicks = 10;
            sizes.yTitle = 14;
            sizes.barRadius = 8;
            sizes.padding = { top: 10, bottom: 8, left: 6, right: 6 };
        }
        // Small phones (≤ 576px)
        else if (width <= 576) {
            sizes.tooltipBody = 10;
            sizes.tooltipTitle = 11;
            sizes.legend = 10;
            sizes.xTicks = 8;
            sizes.xTitle = 11;
            sizes.yTicks = 8;
            sizes.yTitle = 11;
            sizes.barRadius = 6;
            sizes.padding = { top: 6, bottom: 6, left: 4, right: 4 };
        }
        // Very small phones (≤ 400px)
        else if (width <= 400) {
            sizes.tooltipBody = 8;
            sizes.tooltipTitle = 9;
            sizes.legend = 8;
            sizes.xTicks = 7;
            sizes.xTitle = 9;
            sizes.yTicks = 7;
            sizes.yTitle = 9;
            sizes.barRadius = 4;
            sizes.padding = { top: 4, bottom: 4, left: 2, right: 2 };
        }
        // Extra small (≤ 350px)
        else if (width <= 350) {
            sizes.tooltipBody = 7;
            sizes.tooltipTitle = 8;
            sizes.legend = 7;
            sizes.xTicks = 6;
            sizes.xTitle = 8;
            sizes.yTicks = 6;
            sizes.yTitle = 8;
            sizes.barRadius = 3;
            sizes.padding = { top: 3, bottom: 3, left: 2, right: 2 };
        }

        return sizes;
    }

    const fontSizes = getResponsiveFontSizes();

    // ==================== CHART OPTIONS ====================
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false,
            mode: 'index'
        },
        plugins: {
            tooltip: {
                bodyFont: {
                    size: fontSizes.tooltipBody,
                    weight: '600',
                    family: Chart.defaults.font.family
                },
                titleFont: {
                    size: fontSizes.tooltipTitle,
                    weight: '700',
                    family: Chart.defaults.font.family
                },
                titleColor: '#0F172A',
                bodyColor: '#1E293B',
                backgroundColor: '#FFFFFF',
                borderColor: '#E2E8F0',
                borderWidth: 1,
                padding: Math.max(6, fontSizes.tooltipBody * 0.5),
                cornerRadius: Math.max(6, fontSizes.tooltipBody * 0.4),
                callbacks: {
                    label: function(context) {
                        return '₱' + context.raw.toFixed(2);
                    }
                }
            },
            legend: {
                labels: {
                    font: {
                        size: fontSizes.legend,
                        weight: '700',
                        family: Chart.defaults.font.family
                    },
                    color: '#0F172A',
                    usePointStyle: true,
                    boxWidth: Math.max(10, fontSizes.legend * 0.6),
                    padding: Math.max(8, fontSizes.legend * 0.7),
                },
                position: 'top',
                align: 'center',
            }
        },
        scales: {
            x: {
                ticks: {
                    font: {
                        size: fontSizes.xTicks,
                        weight: '700',
                        family: Chart.defaults.font.family
                    },
                    color: '#0F172A',
                    autoSkip: true,
                    maxTicksLimit: window.innerWidth < 576 ? 6 : 12,
                    maxRotation: window.innerWidth < 576 ? 45 : 30,
                    minRotation: window.innerWidth < 576 ? 30 : 20,
                    padding: Math.max(4, fontSizes.xTicks * 0.3),
                },
                title: {
                    display: window.innerWidth > 400, // Hide on very small screens
                    text: 'Batch',
                    font: {
                        size: fontSizes.xTitle,
                        weight: '800',
                        family: Chart.defaults.font.family
                    },
                    color: '#0F172A',
                    padding: {
                        top: Math.max(8, fontSizes.xTitle * 0.5),
                        bottom: Math.max(4, fontSizes.xTitle * 0.3)
                    },
                },
                grid: {
                    color: '#CBD5E1',
                    drawBorder: true,
                    borderColor: '#CBD5E1',
                    tickWidth: Math.max(1, fontSizes.xTicks * 0.08),
                }
            },
            y: {
                ticks: {
                    font: {
                        size: fontSizes.yTicks,
                        weight: '700',
                        family: Chart.defaults.font.family
                    },
                    color: '#0F172A',
                    padding: Math.max(4, fontSizes.yTicks * 0.4),
                    callback: function(value) {
                        if (value >= 1000000) {
                            return '₱' + (value / 1000000).toFixed(1) + 'M';
                        } else if (value >= 1000) {
                            return '₱' + (value / 1000).toFixed(1) + 'k';
                        }
                        return '₱' + value.toFixed(0);
                    },
                    maxTicksLimit: window.innerWidth < 576 ? 5 : 8,
                },
                title: {
                    display: window.innerWidth > 400, // Hide on very small screens
                    text: 'Total Sales (₱)',
                    font: {
                        size: fontSizes.yTitle,
                        weight: '800',
                        family: Chart.defaults.font.family
                    },
                    color: '#0F172A',
                    padding: {
                        bottom: Math.max(8, fontSizes.yTitle * 0.4),
                        top: Math.max(4, fontSizes.yTitle * 0.3)
                    },
                },
                grid: {
                    color: '#CBD5E1',
                    tickWidth: Math.max(1, fontSizes.yTicks * 0.08),
                    drawBorder: true,
                    borderColor: '#CBD5E1',
                }
            }
        },
        elements: {
            bar: {
                borderRadius: fontSizes.barRadius,
                borderSkipped: false,
            }
        },
        layout: {
            padding: fontSizes.padding
        },
        hover: {
            mode: 'index',
            intersect: false,
            animationDuration: 150,
        },
        animation: {
            duration: 800,
            easing: 'easeOutQuart',
        },
        datasets: {
            bar: {
                borderRadius: fontSizes.barRadius,
                barPercentage: window.innerWidth < 576 ? 0.5 : 0.7,
                categoryPercentage: window.innerWidth < 576 ? 0.7 : 0.85,
            }
        }
    };

    // Create the chart
    salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: displayLabels,
            datasets: [{
                label: 'Total Sales (₱) - Delivered Only (All Batches)',
                data: displayData,
                backgroundColor: 'rgba(22, 163, 74, 0.85)',
                borderColor: '#15803D',
                borderWidth: Math.max(1, fontSizes.barRadius * 0.15),
                borderRadius: fontSizes.barRadius,
                hoverBackgroundColor: '#16A34A',
                hoverBorderColor: '#166534',
                hoverBorderWidth: Math.max(1.5, fontSizes.barRadius * 0.2),
                barPercentage: window.innerWidth < 576 ? 0.5 : 0.7,
                categoryPercentage: window.innerWidth < 576 ? 0.7 : 0.85,
            }]
        },
        options: chartOptions
    });
}

// ==================== WINDOW RESIZE HANDLER ====================
let resizeTimeout;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
        if (salesChart && chartVisible) {
            // Only update font sizes, don't reload data
            const fontSizes = getResponsiveFontSizes();

            // Update chart options with new sizes
            if (salesChart.options) {
                salesChart.options.plugins.tooltip.bodyFont.size = fontSizes.tooltipBody;
                salesChart.options.plugins.tooltip.titleFont.size = fontSizes.tooltipTitle;
                salesChart.options.plugins.legend.labels.font.size = fontSizes.legend;
                salesChart.options.scales.x.ticks.font.size = fontSizes.xTicks;
                salesChart.options.scales.x.title.font.size = fontSizes.xTitle;
                salesChart.options.scales.y.ticks.font.size = fontSizes.yTicks;
                salesChart.options.scales.y.title.font.size = fontSizes.yTitle;
                salesChart.options.elements.bar.borderRadius = fontSizes.barRadius;
                salesChart.options.layout.padding = fontSizes.padding;

                // Adjust bar sizing for mobile
                const isMobile = window.innerWidth < 576;
                salesChart.options.datasets.bar.barPercentage = isMobile ? 0.5 : 0.7;
                salesChart.options.datasets.bar.categoryPercentage = isMobile ? 0.7 : 0.85;

                // Hide axis titles on very small screens
                salesChart.options.scales.x.title.display = window.innerWidth > 400;
                salesChart.options.scales.y.title.display = window.innerWidth > 400;

                // Adjust max ticks based on screen width
                salesChart.options.scales.x.ticks.maxTicksLimit = window.innerWidth < 576 ? 6 : 12;
                salesChart.options.scales.y.ticks.maxTicksLimit = window.innerWidth < 576 ? 5 : 8;

                // Adjust rotation for mobile
                salesChart.options.scales.x.ticks.maxRotation = window.innerWidth < 576 ? 45 : 30;
                salesChart.options.scales.x.ticks.minRotation = window.innerWidth < 576 ? 30 : 20;

                salesChart.update('none');
            }
        }
    }, 300);
});

// Helper function to get responsive font sizes (for reuse)
function getResponsiveFontSizes() {
    const width = window.innerWidth;

    let sizes = {
        tooltipBody: 26,
        tooltipTitle: 28,
        legend: 28,
        xTicks: 24,
        xTitle: 30,
        yTicks: 24,
        yTitle: 30,
        barRadius: 16,
        padding: { top: 24, bottom: 16, left: 12, right: 12 }
    };

    if (width >= 769 && width <= 1024) {
        sizes.tooltipBody = 18;
        sizes.tooltipTitle = 20;
        sizes.legend = 18;
        sizes.xTicks = 16;
        sizes.xTitle = 20;
        sizes.yTicks = 16;
        sizes.yTitle = 20;
        sizes.barRadius = 12;
        sizes.padding = { top: 16, bottom: 12, left: 10, right: 10 };
    }
    else if (width <= 768) {
        sizes.tooltipBody = 12;
        sizes.tooltipTitle = 14;
        sizes.legend = 12;
        sizes.xTicks = 10;
        sizes.xTitle = 14;
        sizes.yTicks = 10;
        sizes.yTitle = 14;
        sizes.barRadius = 8;
        sizes.padding = { top: 10, bottom: 8, left: 6, right: 6 };
    }
    else if (width <= 576) {
        sizes.tooltipBody = 10;
        sizes.tooltipTitle = 11;
        sizes.legend = 10;
        sizes.xTicks = 8;
        sizes.xTitle = 11;
        sizes.yTicks = 8;
        sizes.yTitle = 11;
        sizes.barRadius = 6;
        sizes.padding = { top: 6, bottom: 6, left: 4, right: 4 };
    }
    else if (width <= 400) {
        sizes.tooltipBody = 8;
        sizes.tooltipTitle = 9;
        sizes.legend = 8;
        sizes.xTicks = 7;
        sizes.xTitle = 9;
        sizes.yTicks = 7;
        sizes.yTitle = 9;
        sizes.barRadius = 4;
        sizes.padding = { top: 4, bottom: 4, left: 2, right: 2 };
    }
    else if (width <= 350) {
        sizes.tooltipBody = 7;
        sizes.tooltipTitle = 8;
        sizes.legend = 7;
        sizes.xTicks = 6;
        sizes.xTitle = 8;
        sizes.yTicks = 6;
        sizes.yTitle = 8;
        sizes.barRadius = 3;
        sizes.padding = { top: 3, bottom: 3, left: 2, right: 2 };
    }

    return sizes;
}
    function toggleChart() {
        const chartBody = document.getElementById('chartBody');
        const toggleBtn = document.getElementById('toggleChartBtn');

        if (chartVisible) {
            chartBody.style.display = 'none';
            chartVisible = false;
            toggleBtn.innerHTML = '<i class="fas fa-chart-simple me-1"></i> Show Chart';
            if (salesChart) {
                salesChart.destroy();
                salesChart = null;
            }
        } else {
            chartBody.style.display = 'block';
            chartVisible = true;
            toggleBtn.innerHTML = '<i class="fas fa-chart-simple me-1"></i> Hide Chart';
            setTimeout(() => {
                updateChartFromAllBatches();
            }, 100);
        }
    }

    function performExport(batchId, batchName) {
        const batchCard = document.querySelector(`.batch-card[data-batch-id="${batchId}"]`);
        if (!batchCard) {
            alert('Batch card not found');
            return;
        }
        const table = batchCard.querySelector('.batch-table');
        if (!table) {
            alert('Table not found');
            return;
        }
        const rows = table.querySelectorAll('tbody tr');
        if (!rows.length || (rows.length === 1 && rows[0].innerText.includes('No bookings'))) {
            alert('No bookings available to export in this batch.');
            return;
        }
        const headers = ['ID', 'Booking Ref', 'User Name', 'User Mobile', 'Receiver Name', 'Receiver Number', 'Quantity (trays)', 'Fee per Tray', 'Total Amount', 'Pickup Address', 'Drop Location', 'Status', 'Created Date'];
        const csvRows = [headers];
        rows.forEach(row => {
            if (row.innerText.includes('No bookings in this batch yet')) return;
            const cols = row.querySelectorAll('td');
            if (cols.length < 13) return;
            const id = cols[0]?.innerText.trim() || '';
            const bookingRef = cols[1]?.innerText.trim() || '';
            const userCell = cols[2];
            const userName = userCell?.innerText.split('\n')[0]?.trim() || '';
            const userMobile = userCell?.querySelector('small')?.innerText.trim() || '';
            const receiverName = cols[3]?.innerText.trim() || '';
            const receiverNumber = cols[4]?.innerText.trim() || '';
            const quantity = cols[5]?.innerText.replace('trays', '').trim() || '';
            const feePerTray = cols[6]?.innerText.trim() || '';
            const totalAmount = cols[7]?.innerText.trim() || '';
            const pickup = cols[8]?.innerText.trim() || '';
            const drop = cols[9]?.innerText.trim() || '';
            const status = cols[10]?.innerText.trim() || '';
            const created = cols[11]?.innerText.trim() || '';
            csvRows.push([id, bookingRef, userName, userMobile, receiverName, receiverNumber, quantity, feePerTray, totalAmount, pickup, drop, status, created]);
        });
        const csvContent = csvRows.map(row => row.map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(',')).join('\n');
        const blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.href = url;
        link.setAttribute('download', `batch_${batchName}_bookings.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
        showSuccessMessage(`CSV for Batch ${batchName} exported!`);
    }

    function performSetActive(batchId) {
        fetch('{{ route("admin.batches.set-active") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ batch_id: batchId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showSuccessMessage('Active batch updated! Refreshing data...');
                setTimeout(() => silentRefresh(), 800);
            } else {
                alert('Error: ' + (data.message || ''));
            }
        })
        .catch(() => alert('Request failed'));
    }

    // ========== APPLY SENT STATES AFTER REFRESH ==========
    function applySentStates() {
        // Individual send buttons
        document.querySelectorAll('.send-sms-btn').forEach(btn => {
            const bookingId = btn.getAttribute('data-booking-id');
            if (sentBookings.includes(bookingId)) {
                btn.disabled = true;
                btn.classList.add('disabled', 'btn-sms-sent');
                btn.innerHTML = '<i class="fas fa-check-circle"></i> Sent';
                btn.title = 'SMS sent';
                btn.removeAttribute('data-original-icon');
            }
        });

        // Send All buttons
        document.querySelectorAll('.send-all-sms-btn').forEach(btn => {
            const batchId = btn.getAttribute('data-batch-id');
            if (sentBatches.includes(batchId)) {
                btn.disabled = true;
                btn.classList.add('btn-sms-sent');
                btn.innerHTML = '<i class="fas fa-check-circle"></i> Sent';
                btn.title = 'All SMS sent';
            }
        });
    }

    // ========== SEND SMS LOGIC - Button changes to checkmark ==========
    function performSendSms(bookingId, receiverNumber, bookingRef, buttonElement) {
        if (!receiverNumber || receiverNumber === 'N/A') {
            alert('No valid receiver number available for this booking.');
            return;
        }

        // Disable and show loading state
        if (buttonElement) {
            buttonElement.disabled = true;
            buttonElement.classList.add('disabled');
            const originalIcon = buttonElement.innerHTML;
            buttonElement.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Sending...';
            buttonElement.setAttribute('data-original-icon', originalIcon);
        }

        const message = `Your booking ref is ${bookingRef}. To track, you must go:
        1. Go to chrome and type surecargotransport.com
        2.Click old/trusted customer
        3. Enter Secret Code (Ask secret code for your seller, Humingi ng secret code sa seller mo)
        4. Register/login
        5. Click 3 dots in left top corner
        6. In sidebar click track validate
        7. Input your booking ref and submit
        8. You will see the real-time truck location!`;

        fetch('{{ route("admin.bookings.send-sms") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,
                receiver_number: receiverNumber,
                message: message,
                booking_ref: bookingRef
            })
        })
        .then(res => res.json())
        .then(data => {
            const isSuccess = data.success || (data.message && (data.message.includes('successfully') || data.message.includes('queued')));
            if (isSuccess) {
                showSuccessMessage(`SMS sent successfully to ${receiverNumber}!`);

                // Add to sent list
                if (!sentBookings.includes(bookingId)) {
                    sentBookings.push(bookingId);
                }

                // Change button to checkmark icon
                if (buttonElement) {
                    buttonElement.disabled = true;
                    buttonElement.classList.add('disabled', 'btn-sms-sent');
                    buttonElement.innerHTML = '<i class="fas fa-check-circle"></i> Sent';
                    buttonElement.title = 'SMS sent';
                    buttonElement.removeAttribute('data-original-icon');
                }
            } else {
                // On error, re-enable the button but show error
                if (buttonElement) {
                    buttonElement.disabled = false;
                    buttonElement.classList.remove('disabled');
                    const originalIcon = buttonElement.getAttribute('data-original-icon');
                    if (originalIcon) buttonElement.innerHTML = originalIcon;
                }
                alert('Error: ' + (data.message || 'Could not send SMS. Please check if the number is valid.'));
            }
        })
        .catch((error) => {
            console.error('SMS error:', error);
            if (buttonElement) {
                buttonElement.disabled = false;
                buttonElement.classList.remove('disabled');
                const originalIcon = buttonElement.getAttribute('data-original-icon');
                if (originalIcon) buttonElement.innerHTML = originalIcon;
            }
            alert('Network error while sending SMS. Please try again.');
        });
    }

    function handleSendSmsClick(e) {
        const btn = e.currentTarget;
        if (btn.classList.contains('disabled') || btn.disabled) {
            return;
        }
        pendingSmsBookingId = btn.getAttribute('data-booking-id');
        pendingSmsReceiverNumber = btn.getAttribute('data-receiver-number');
        pendingSmsBookingRef = btn.getAttribute('data-booking-ref');
        pendingSmsButton = btn;

        if (!pendingSmsReceiverNumber || pendingSmsReceiverNumber === 'N/A') {
            alert('No valid receiver number available for this booking.');
            return;
        }

        const receiverSpan = document.getElementById('smsReceiverNumber');
        const previewSpan = document.getElementById('smsPreview');
        if (receiverSpan) receiverSpan.innerText = pendingSmsReceiverNumber;
        if (previewSpan) {
            previewSpan.innerHTML = `Your booking ref is ${pendingSmsBookingRef}.To track, you must go:
        1. Go to chrome and type surecargotransport.com
        2.Click old/trusted customer
        3. Enter Secret Code (Ask secret code for your seller, Humingi ng secret code sa seller mo)
        4. Register/login
        5. Click 3 dots in left top corner
        6. In sidebar click track validate
        7. Input your booking ref and submit
        8. You will see the real-time truck location!`;

        }

        new bootstrap.Modal(document.getElementById('sendSmsModal')).show();
    }

    // ========== SEND ALL LOGIC (with warning) ==========
    function handleSendAllClick(e) {
        const btn = e.currentTarget;
        if (btn.disabled) return;

        sendAllBatchId = btn.getAttribute('data-batch-id');
        sendAllBatchName = btn.getAttribute('data-batch-name');
        sendAllButton = btn; // store reference to update later
        const inTransitCount = parseInt(btn.getAttribute('data-in-transit-count') || '0');

        if (inTransitCount === 0) {
            alert('No in-transit bookings in this batch to send SMS to.');
            return;
        }

        // Set warning and progress elements
        document.getElementById('sendAllCountWarning').textContent = inTransitCount;
        document.getElementById('sendAllBatchNameWarning').textContent = '#' + sendAllBatchName;
        document.getElementById('sendAllCount').textContent = inTransitCount;
        document.getElementById('sendAllBatchName').textContent = '#' + sendAllBatchName;

        document.getElementById('sendAllWarning').style.display = 'block';
        document.getElementById('sendAllProgress').style.display = 'none';
        document.getElementById('sendAllResult').style.display = 'none';

        document.getElementById('sendAllProgressBar').style.width = '0%';
        document.getElementById('sendAllProgressBar').textContent = '0%';
        document.getElementById('sendAllProgressBar').classList.remove('bg-danger');
        document.getElementById('sendAllProgressBar').classList.add('progress-bar-striped', 'progress-bar-animated');
        document.getElementById('sendAllLog').innerHTML = '';

        const startBtn = document.getElementById('sendAllStartBtn');
        startBtn.disabled = false;
        startBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Confirm & Send';
        startBtn.style.display = 'inline-block';
        document.getElementById('sendAllCloseBtn').disabled = false;

        new bootstrap.Modal(document.getElementById('sendAllSmsModal')).show();
    }

    function performSendAll() {
        const startBtn = document.getElementById('sendAllStartBtn');
        const progressBar = document.getElementById('sendAllProgressBar');
        const logDiv = document.getElementById('sendAllLog');
        const warningDiv = document.getElementById('sendAllWarning');
        const progressDiv = document.getElementById('sendAllProgress');
        const resultDiv = document.getElementById('sendAllResult');
        const successAlert = document.getElementById('sendAllSuccessAlert');
        const errorAlert = document.getElementById('sendAllErrorAlert');

        startBtn.disabled = true;
        startBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Sending...';
        document.getElementById('sendAllCloseBtn').disabled = true;

        warningDiv.style.display = 'none';
        progressDiv.style.display = 'block';
        resultDiv.style.display = 'none';

        logDiv.innerHTML = '';

        const url = '{{ route("admin.batches.send-all-sms", ["batch" => "__BATCH_ID__"]) }}'.replace('__BATCH_ID__', sendAllBatchId);

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ batch_id: sendAllBatchId })
        })
        .then(response => response.json())
        .then(data => {
            const isSuccess = data.success || (data.message && (data.message.includes('successfully') || data.message.includes('queued')));
            if (isSuccess) {
                progressBar.style.width = '100%';
                progressBar.textContent = '100%';
                progressBar.classList.remove('progress-bar-animated');

                progressDiv.style.display = 'none';
                resultDiv.style.display = 'block';

                errorAlert.style.display = 'none';

                if (data.total_sent > 0) {
                    let successMsg = `<i class="fas fa-check-circle me-2"></i> Successfully sent ${data.total_sent} SMS.`;
                    if (data.total_failed > 0) {
                        successMsg += ` (${data.total_failed} failed - see log)`;
                    }
                    successAlert.innerHTML = successMsg;
                    successAlert.style.display = 'block';
                } else {
                    successAlert.innerHTML = `<i class="fas fa-info-circle me-2"></i> Sent successfully.`;
                    successAlert.style.display = 'block';
                }

                if (data.sent && data.sent.length) {
                    data.sent.forEach(ref => {
                        const entry = document.createElement('div');
                        entry.className = 'log-entry log-success';
                        entry.textContent = `✅ ${ref}`;
                        logDiv.appendChild(entry);
                    });
                }
                if (data.errors && data.errors.length) {
                    data.errors.forEach(err => {
                        const entry = document.createElement('div');
                        entry.className = 'log-entry log-error';
                        entry.textContent = `❌ ${err}`;
                        logDiv.appendChild(entry);
                    });
                }

                document.getElementById('sendAllCloseBtn').disabled = false;
                startBtn.style.display = 'none';

                showSuccessMessage(`Bulk SMS completed: ${data.total_sent} sent, ${data.total_failed} failed.`);

                // Mark batch as sent
                if (sendAllBatchId && !sentBatches.includes(sendAllBatchId)) {
                    sentBatches.push(sendAllBatchId);
                }

                // Update the Send All button
                if (sendAllButton) {
                    sendAllButton.disabled = true;
                    sendAllButton.classList.add('btn-sms-sent');
                    sendAllButton.innerHTML = '<i class="fas fa-check-circle"></i> Sent';
                    sendAllButton.title = 'All SMS sent';
                }

            } else {
                progressBar.classList.remove('progress-bar-animated');
                progressBar.style.width = '100%';
                progressBar.textContent = 'Error';
                progressBar.classList.add('bg-danger');
                progressDiv.style.display = 'none';
                resultDiv.style.display = 'block';
                successAlert.style.display = 'none';
                errorAlert.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i> ${data.message || 'An error occurred while sending SMS.'}`;
                errorAlert.style.display = 'block';
                document.getElementById('sendAllCloseBtn').disabled = false;
                startBtn.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Send All error:', error);
            progressBar.classList.remove('progress-bar-animated');
            progressBar.style.width = '100%';
            progressBar.textContent = 'Error';
            progressBar.classList.add('bg-danger');
            progressDiv.style.display = 'none';
            resultDiv.style.display = 'block';
            successAlert.style.display = 'none';
            errorAlert.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i> Network error. Please check your connection and try again.`;
            errorAlert.style.display = 'block';
            document.getElementById('sendAllCloseBtn').disabled = false;
            startBtn.style.display = 'none';
        });
    }

    // ========== MODAL TRIGGER HANDLERS ==========
    function handleSetActiveModalTrigger(e) {
        const btn = e.currentTarget;
        setActiveBatchId = btn.getAttribute('data-id');
        setActiveBatchName = btn.getAttribute('data-batch-name');
        document.getElementById('setActiveBatchNameDisplay').innerText = `#${setActiveBatchName}`;
        new bootstrap.Modal(document.getElementById('setActiveModal')).show();
    }

    function handleExportModalTrigger(e) {
        const btn = e.currentTarget;
        exportBatchId = btn.getAttribute('data-batch-id');
        exportBatchName = btn.getAttribute('data-batch-name');
        document.getElementById('exportBatchNameDisplay').innerText = `#${exportBatchName}`;
        new bootstrap.Modal(document.getElementById('exportCsvModal')).show();
    }

    function handleArchiveTrigger(e) {
        const btn = e.currentTarget;
        archiveBatchId = btn.getAttribute('data-batch-id');
        archiveBatchName = btn.getAttribute('data-batch-name');
        const modalBody = document.querySelector('#archiveWarningModal .modal-body');
        if (modalBody && archiveBatchName) {
            const pElement = modalBody.querySelector('p:first-of-type');
            if (pElement) {
                pElement.innerHTML = `Are you sure you want to archive batch <strong>${archiveBatchName}</strong>?`;
            }
        }
    }

    function attachEventHandlers() {
        document.querySelectorAll('.delete-booking-btn').forEach(btn => {
            btn.removeEventListener('click', handleDeleteClick);
            btn.addEventListener('click', handleDeleteClick);
        });

        document.querySelectorAll('.send-sms-btn').forEach(btn => {
            btn.removeEventListener('click', handleSendSmsClick);
            btn.addEventListener('click', handleSendSmsClick);
        });

        document.querySelectorAll('.export-batch-csv').forEach(btn => {
            btn.removeEventListener('click', handleExportModalTrigger);
            btn.addEventListener('click', handleExportModalTrigger);
        });

        document.querySelectorAll('.set-active-batch').forEach(btn => {
            btn.removeEventListener('click', handleSetActiveModalTrigger);
            btn.addEventListener('click', handleSetActiveModalTrigger);
        });

        document.querySelectorAll('.archive-batch-trigger-btn').forEach(btn => {
            btn.removeEventListener('click', handleArchiveTrigger);
            btn.addEventListener('click', handleArchiveTrigger);
        });

        document.querySelectorAll('.send-all-sms-btn').forEach(btn => {
            btn.removeEventListener('click', handleSendAllClick);
            btn.addEventListener('click', handleSendAllClick);
        });

        // Apply sent states after attaching events
        applySentStates();
    }

    function handleDeleteClick(e) {
        bookingToDelete = e.currentTarget.getAttribute('data-booking-id');
        new bootstrap.Modal(document.getElementById('deleteBookingModal')).show();
    }

    function performArchive() {
        if (!archiveBatchId) return;
        fetch('{{ route("admin.batches.archive") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ batch_id: archiveBatchId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showSuccessMessage(`Batch ${archiveBatchName} archived successfully!`);
                const modal = bootstrap.Modal.getInstance(document.getElementById('archiveWarningModal'));
                if (modal) modal.hide();
                setTimeout(() => silentRefresh(), 500);
            } else {
                alert('Error: ' + (data.message || 'Could not archive batch'));
            }
        })
        .catch(() => alert('Network error while archiving batch'))
        .finally(() => {
            archiveBatchId = null;
            archiveBatchName = null;
        });
    }

    async function silentRefresh() {
        if (isRefreshing) return;
        if (document.querySelector('.modal.show')) return;
        isRefreshing = true;
        try {
            const response = await fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!response.ok) throw new Error('Network error');
            const htmlText = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(htmlText, 'text/html');

            const newBatchesContainer = doc.getElementById('batchesContainer');
            const currentBatchesContainer = document.getElementById('batchesContainer');
            if (newBatchesContainer && currentBatchesContainer) {
                currentBatchesContainer.innerHTML = newBatchesContainer.innerHTML;
            }
            const newPagination = doc.getElementById('bookingsPagination');
            const currentPagination = document.getElementById('bookingsPagination');
            if (newPagination && currentPagination) {
                currentPagination.innerHTML = newPagination.innerHTML;
            }

            const newStatsContainer = doc.querySelector('.top-stats-row');
            const currentStatsContainer = document.querySelector('.top-stats-row');
            if (newStatsContainer && currentStatsContainer) {
                currentStatsContainer.innerHTML = newStatsContainer.innerHTML;
            }

            const newChartDataDiv = doc.getElementById('allBatchesChartData');
            const currentChartDataDiv = document.getElementById('allBatchesChartData');
            if (newChartDataDiv && currentChartDataDiv) {
                currentChartDataDiv.setAttribute('data-labels', newChartDataDiv.getAttribute('data-labels'));
                currentChartDataDiv.setAttribute('data-values', newChartDataDiv.getAttribute('data-values'));
            }

            attachEventHandlers(); // this calls applySentStates inside
            if (chartVisible) {
                updateChartFromAllBatches();
            }
        } catch (error) {
            console.error('Silent refresh failed:', error);
        } finally {
            isRefreshing = false;
        }
    }

    function startAutoRefresh() {
        if (autoRefreshInterval) clearInterval(autoRefreshInterval);
        autoRefreshInterval = setInterval(() => {
            silentRefresh();
        }, 5000);
    }

    // ========== PDF EXPORT MODAL LOGIC ==========
    function generatePDFFromDataURL(dataURL, fileName, orientation = 'landscape', pageSize = 'a4') {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF({
            orientation: orientation,
            unit: 'mm',
            format: pageSize
        });
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const margin = 10;
        const maxWidth = pageWidth - 2 * margin;
        const maxHeight = pageHeight - 2 * margin;
        const img = new Image();
        img.onload = function() {
            let imgWidth = img.width;
            let imgHeight = img.height;
            const ratio = Math.min(maxWidth / imgWidth, maxHeight / imgHeight);
            imgWidth = imgWidth * ratio;
            imgHeight = imgHeight * ratio;
            const x = (pageWidth - imgWidth) / 2;
            const y = (pageHeight - imgHeight) / 2;
            pdf.addImage(dataURL, 'PNG', x, y, imgWidth, imgHeight);
            pdf.save(fileName + '.pdf');
        };
        img.src = dataURL;
    }

    document.getElementById('exportPdfBtn')?.addEventListener('click', function() {
        const chartCanvas = document.getElementById('salesChart');
        if (!chartCanvas) {
            alert('Chart is currently hidden. Please show the chart first to export.');
            return;
        }
        const dataURL = chartCanvas.toDataURL('image/png');
        pdfExportDataURL = dataURL;
        document.getElementById('pdfExportPreview').src = dataURL;
        document.getElementById('pdfExportChartTitle').textContent = 'Total Sales (Delivered)';
        document.getElementById('pdfOrientation').value = 'landscape';
        document.getElementById('pdfPageSize').value = 'a4';
        const modal = new bootstrap.Modal(document.getElementById('pdfExportModal'));
        modal.show();
    });

    document.getElementById('pdfDownloadBtn')?.addEventListener('click', function() {
        const dataURL = pdfExportDataURL;
        const fileName = 'total_sales_delivered';
        const orientation = document.getElementById('pdfOrientation').value;
        const pageSize = document.getElementById('pdfPageSize').value;
        if (!dataURL) {
            alert('No chart data available. Please try again.');
            return;
        }
        generatePDFFromDataURL(dataURL, fileName, orientation, pageSize);
    });

    document.getElementById('pdfExportModal')?.addEventListener('hidden.bs.modal', function() {
        pdfExportDataURL = null;
        document.getElementById('pdfExportPreview').src = '';
    });

    document.getElementById('toggleChartBtn')?.addEventListener('click', toggleChart);

    document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
        if (bookingToDelete) {
            let form = document.getElementById('deleteForm');
            form.action = '/admin/bookings/' + bookingToDelete;
            form.submit();
        }
        bootstrap.Modal.getInstance(document.getElementById('deleteBookingModal'))?.hide();
    });

    document.getElementById('confirmSendSmsBtn')?.addEventListener('click', function() {
        if (pendingSmsBookingId && pendingSmsReceiverNumber && pendingSmsBookingRef && pendingSmsButton) {
            performSendSms(pendingSmsBookingId, pendingSmsReceiverNumber, pendingSmsBookingRef, pendingSmsButton);
            bootstrap.Modal.getInstance(document.getElementById('sendSmsModal'))?.hide();
        } else {
            alert('Missing booking information. Please try again.');
        }
        pendingSmsBookingId = null;
        pendingSmsReceiverNumber = null;
        pendingSmsBookingRef = null;
        pendingSmsButton = null;
    });

    const confirmCreateBtn = document.getElementById('confirmCreateBatchBtn');
    if (confirmCreateBtn) {
        confirmCreateBtn.addEventListener('click', function() {
            confirmCreateBtn.disabled = true;
            confirmCreateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Creating...';
            fetch('{{ route("admin.batches.store") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('confirmDoneModal'))?.hide();
                    showSuccessMessage('New batch created! Refreshing...');
                    setTimeout(() => silentRefresh(), 500);
                } else {
                    alert('Error: ' + (data.message || 'Unknown error'));
                    confirmCreateBtn.disabled = false;
                    confirmCreateBtn.innerHTML = '<i class="fas fa-check-circle me-1"></i> Yes, create new batch';
                }
            })
            .catch(() => {
                alert('Network error');
                confirmCreateBtn.disabled = false;
                confirmCreateBtn.innerHTML = '<i class="fas fa-check-circle me-1"></i> Yes, create new batch';
            });
        });
    }

    document.getElementById('confirmArchiveBtn')?.addEventListener('click', function() {
        performArchive();
    });

    document.getElementById('confirmSetActiveBtn')?.addEventListener('click', function() {
        if (setActiveBatchId) {
            performSetActive(setActiveBatchId);
            bootstrap.Modal.getInstance(document.getElementById('setActiveModal'))?.hide();
            setActiveBatchId = null;
            setActiveBatchName = null;
        }
    });

    document.getElementById('confirmExportCsvBtn')?.addEventListener('click', function() {
        if (exportBatchId && exportBatchName) {
            performExport(exportBatchId, exportBatchName);
            bootstrap.Modal.getInstance(document.getElementById('exportCsvModal'))?.hide();
            exportBatchId = null;
            exportBatchName = null;
        }
    });

    document.getElementById('sendAllStartBtn')?.addEventListener('click', function() {
        performSendAll();
    });

    document.getElementById('sendAllSmsModal')?.addEventListener('hidden.bs.modal', function() {
        document.getElementById('sendAllWarning').style.display = 'block';
        document.getElementById('sendAllProgress').style.display = 'none';
        document.getElementById('sendAllResult').style.display = 'none';
        document.getElementById('sendAllProgressBar').style.width = '0%';
        document.getElementById('sendAllProgressBar').textContent = '0%';
        document.getElementById('sendAllProgressBar').classList.remove('bg-danger');
        document.getElementById('sendAllProgressBar').classList.add('progress-bar-striped', 'progress-bar-animated');
        document.getElementById('sendAllLog').innerHTML = '';
        document.getElementById('sendAllStartBtn').disabled = false;
        document.getElementById('sendAllStartBtn').innerHTML = '<i class="fas fa-paper-plane me-1"></i> Confirm & Send';
        document.getElementById('sendAllStartBtn').style.display = 'inline-block';
        document.getElementById('sendAllCloseBtn').disabled = false;
        sendAllBatchId = null;
        sendAllBatchName = null;
        sendAllButton = null;
    });

    document.addEventListener('DOMContentLoaded', function() {
        updateChartFromAllBatches();
        attachEventHandlers(); // apply sent states on initial load
        startAutoRefresh();

        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('show.bs.modal', () => {
                if (autoRefreshInterval) clearInterval(autoRefreshInterval);
            });
            modal.addEventListener('hidden.bs.modal', () => {
                startAutoRefresh();
                silentRefresh();
            });
        });
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                if (autoRefreshInterval) clearInterval(autoRefreshInterval);
            } else {
                startAutoRefresh();
                silentRefresh();
            }
        });
    });
</script>
@endpush
@endsection
