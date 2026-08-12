@extends('admin.layouts.app')

@section('title', 'Booking Details')
@section('page-title', 'Booking Details')

@section('content')
<div class="booking-details-container">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-white border-bottom-0 py-4 px-5">
            <h3 class="mb-0 fw-bold text-dark">
                <i class="fas fa-clipboard-list me-2 text-success"></i> Booking Information
            </h3>
        </div>
        <div class="card-body p-4 p-lg-5">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-details">
                            <tbody>
                                <tr>
                                    <th class="bg-light">Booking ID:</th>
                                    <td><strong class="text-success">#{{ $booking->id }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Booking Reference:</th>
                                    <td><strong class="text-dark">{{ $booking->booking_reference ?? 'N/A' }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">User (Booked By):</th>
                                    <td>
                                        @if($booking->user)
                                            <strong class="text-success">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</strong>
                                            <br><span class="text-secondary d-inline-block mt-1">📞 Phone: {{ $booking->user->mobile_number }}</span>
                                            <br><span class="text-secondary">🏙️ City: {{ ucfirst($booking->user->city ?? 'N/A') }}</span>
                                        @else
                                            <span class="text-muted">Guest User (Not logged in)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Truck:</th>
                                    <td>{{ $booking->truck_name ?? $booking->truck_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Truck Number:</th>
                                    <td>{{ $booking->truck_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Product Type:</th>
                                    <td><span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">{{ ucfirst($booking->product_type ?? 'egg') }}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Quantity:</th>
                                    <td><span class="fw-bold text-dark">{{ $booking->quantity ?? 0 }} trays</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Receiver Name:</th>
                                    <td>{{ $booking->receiver_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Receiver Phone:</th>
                                    <td>{{ $booking->receiver_phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Pickup Address:</th>
                                    <td class="text-primary">{{ $booking->pickup_address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Drop Location:</th>
                                    <td class="text-danger">{{ $booking->drop_location ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Notes:</th>
                                    <td><em>{{ $booking->notes ?? 'No notes' }}</em></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status:</th>
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
                                </tr>
                                <tr>
                                    <th class="bg-light">Created At:</th>
                                    <td>{{ $booking->created_at ? $booking->created_at->format('F d, Y H:i') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Updated At:</th>
                                    <td>{{ $booking->updated_at ? $booking->updated_at->format('F d, Y H:i') : 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0 py-4 px-5 d-flex justify-content-end gap-3">
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-success btn-lg px-4">
                <i class="fas fa-edit me-2"></i>Edit Booking
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-danger btn-lg px-4">
                <i class="fas fa-arrow-left me-2"></i>Back to Bookings
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style nonce="{{ $csp_nonce }}">
/* ============================================================
   BOOKING DETAILS - DEEPSEEK-STYLE RESPONSIVE STYLES
   White & Violet Theme - Professional & Smooth
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-light: #9c27b0;
    --violet-soft: #f3e5f5;
    --violet-dark: #4a148c;
    --violet-lighter: #faf8ff;
    --violet-bg-light: #f3f0f7;
    --violet-border: #d1c4e9;
    --violet-shadow: rgba(123, 31, 162, 0.08);
    --violet-shadow-hover: rgba(123, 31, 162, 0.3);
    --white: #FFFFFF;
    --gray-200: #E9ECF0;
    --gray-600: #5A6A72;
    --text-dark: #2c2c3e;
    --text-muted: #6c6c80;
    --shadow-sm: 0 10px 25px -5px rgba(123, 31, 162, 0.05), 0 2px 4px -2px rgba(123, 31, 162, 0.02);
    --shadow-md: 0 20px 35px -12px rgba(123, 31, 162, 0.08);

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
   BOOKING DETAILS CONTAINER
   ============================================================ */
.booking-details-container,
.booking-details-container * {
    font-size: var(--font-base);
    font-family: 'Inter', 'Poppins', system-ui, sans-serif;
}

/* ============================================================
   HEADINGS
   ============================================================ */
.booking-details-container h3 {
    font-size: var(--font-lg) !important;
    font-weight: 800 !important;
    color: var(--violet-dark);
    letter-spacing: -0.02em;
}

.booking-details-container .card-header h3 {
    font-size: var(--font-lg) !important;
    font-weight: 800 !important;
    color: var(--violet-dark);
    margin: 0;
}

/* ============================================================
   CARD
   ============================================================ */
.booking-details-container .card {
    background: var(--white);
    border-radius: 2rem;
    overflow: hidden;
    box-shadow: 0 1rem 2rem var(--violet-shadow);
    border: 1px solid var(--violet-border);
    transition: all 0.3s ease;
}

.booking-details-container .card:hover {
    box-shadow: 0 1.5rem 3rem var(--violet-shadow);
}

.booking-details-container .card-header {
    background: var(--white);
    border-bottom: 3px solid var(--violet-primary);
    padding: var(--sp-md) var(--sp-lg);
}

/* ============================================================
   TABLE
   ============================================================ */
.table-details th,
.table-details td {
    font-size: var(--font-base) !important;
    padding: var(--sp-md) var(--sp-md) !important;
    vertical-align: middle !important;
    border-bottom: 1px solid var(--violet-bg-light) !important;
}

.table-details th {
    width: 220px;
    background-color: var(--violet-bg-light) !important;
    color: var(--violet-dark) !important;
    font-weight: 700 !important;
    border-right: 2px solid var(--violet-bg-light);
}

.table-details td {
    background-color: var(--white) !important;
    color: var(--text-dark) !important;
    font-weight: 400;
}

/* ============================================================
   BADGES
   ============================================================ */
.badge-status {
    display: inline-block;
    padding: var(--sp-xs) var(--sp-lg) !important;
    border-radius: 2rem !important;
    font-size: var(--font-sm) !important;
    font-weight: 600 !important;
    text-align: center;
    min-width: 80px;
}

/* Status colors - Violet theme */
.badge-pending {
    background: var(--violet-soft);
    color: var(--violet-primary);
    border: 1px solid #ce93d8;
}

.badge-warning {
    background: var(--violet-soft);
    color: var(--text-muted);
    border: 1px solid #b39ddb;
}

.badge-active {
    background: var(--violet-soft);
    color: var(--violet-dark);
    border: 1px solid var(--violet-primary);
}

.badge-info {
    background: var(--violet-bg-light);
    color: var(--text-muted);
    border: 1px solid var(--violet-border);
}

.badge-cancelled {
    background: var(--violet-bg-light);
    color: var(--text-muted);
    border: 1px solid #b39ddb;
}

/* ============================================================
   BUTTONS
   ============================================================ */
.booking-details-container .btn {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-lg) !important;
    border-radius: 1rem !important;
    font-weight: 600 !important;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
    transition: all 0.3s ease;
}

/* Primary button - Violet */
.btn-success {
    background: linear-gradient(105deg, var(--violet-primary), var(--violet-dark)) !important;
    border-color: var(--violet-dark) !important;
    color: var(--white) !important;
    box-shadow: 0 4px 12px rgba(123, 31, 162, 0.2);
}

.btn-success:hover {
    background: linear-gradient(105deg, var(--violet-dark), #380e6b) !important;
    border-color: #380e6b !important;
    color: var(--white) !important;
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem var(--violet-shadow-hover);
}

/* Secondary button - Light Violet */
.btn-outline-danger {
    border-color: var(--violet-primary) !important;
    color: var(--violet-primary) !important;
    background: transparent !important;
}

.btn-outline-danger:hover {
    background-color: var(--violet-primary) !important;
    color: var(--white) !important;
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem var(--violet-shadow-hover);
}

/* ============================================================
   TEXT COLORS - Violet
   ============================================================ */
.text-success {
    color: var(--violet-dark) !important;
    font-weight: 600;
}

.text-danger {
    color: var(--violet-primary) !important;
    font-weight: 600;
}

.text-primary {
    color: var(--violet-dark) !important;
    font-weight: 600;
}

.bg-success.bg-opacity-10 {
    background-color: rgba(123, 31, 162, 0.1) !important;
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

    .booking-details-container,
    .booking-details-container * {
        font-size: var(--font-sm);
    }

    .booking-details-container h3 {
        font-size: var(--font-md) !important;
    }

    .table-details th {
        width: 180px;
    }

    .table-details th,
    .table-details td {
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    .booking-details-container .btn {
        padding: var(--sp-sm) var(--sp-md) !important;
        min-height: 40px;
        font-size: var(--font-sm) !important;
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

    .booking-details-container,
    .booking-details-container * {
        font-size: var(--font-sm) !important;
    }

    .booking-details-container h3 {
        font-size: var(--font-md) !important;
    }

    .booking-details-container .card-header h3 {
        font-size: var(--font-md) !important;
    }

    .booking-details-container .card {
        border-radius: 1.5rem;
    }

    .booking-details-container .card-header {
        padding: var(--sp-sm) var(--sp-md);
    }

    .table-details th,
    .table-details td {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-sm) !important;
    }

    .table-details th {
        width: 140px;
        font-weight: 700 !important;
    }

    .badge-status {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-width: 60px;
    }

    .booking-details-container .btn {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md) !important;
        min-height: 38px;
        border-radius: 0.8rem !important;
    }

    /* Stack buttons on mobile */
    .d-flex.gap-2 {
        gap: var(--sp-sm) !important;
        flex-wrap: wrap;
    }

    .d-flex.gap-2 .btn {
        flex: 1;
        min-width: 0;
        width: 100%;
    }

    .row.g-3 {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .row.g-4 {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .col-md-6 {
        padding-left: var(--sp-xs);
        padding-right: var(--sp-xs);
    }

    .text-success,
    .text-danger,
    .text-primary {
        font-size: var(--font-sm) !important;
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

    .booking-details-container,
    .booking-details-container * {
        font-size: var(--font-xs) !important;
    }

    .booking-details-container h3 {
        font-size: var(--font-sm) !important;
    }

    .booking-details-container .card-header h3 {
        font-size: var(--font-sm) !important;
    }

    .booking-details-container .card {
        border-radius: 1.2rem;
    }

    .booking-details-container .card-header {
        padding: var(--sp-xs) var(--sp-sm);
    }

    .table-details th,
    .table-details td {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-xs) !important;
    }

    .table-details th {
        width: 100px;
        font-weight: 700 !important;
        font-size: var(--font-xs) !important;
    }

    .table-details td {
        font-size: var(--font-xs) !important;
    }

    .badge-status {
        font-size: 0.6rem !important;
        padding: 0.1rem var(--sp-xs) !important;
        min-width: 50px;
        border-radius: 1.5rem !important;
    }

    .booking-details-container .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 34px;
        border-radius: 0.6rem !important;
    }

    .d-flex.gap-2 .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .row.g-3 {
        --bs-gutter-y: var(--sp-xs) !important;
        --bs-gutter-x: var(--sp-xs) !important;
    }

    .text-success,
    .text-danger,
    .text-primary {
        font-size: var(--font-xs) !important;
    }

    .bg-success.bg-opacity-10 {
        padding: var(--sp-xs) !important;
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

    .booking-details-container,
    .booking-details-container * {
        font-size: 0.55rem !important;
    }

    .booking-details-container h3 {
        font-size: 0.65rem !important;
    }

    .booking-details-container .card-header h3 {
        font-size: 0.65rem !important;
    }

    .booking-details-container .card {
        border-radius: 1rem;
    }

    .booking-details-container .card-header {
        padding: 0.05rem var(--sp-xs);
    }

    .table-details th,
    .table-details td {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs) !important;
    }

    .table-details th {
        width: 80px;
        font-size: 0.5rem !important;
    }

    .badge-status {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs) !important;
        min-width: 40px;
    }

    .booking-details-container .btn {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs) !important;
        min-height: 30px;
        border-radius: 0.4rem !important;
    }

    .d-flex.gap-2 .btn {
        font-size: 0.45rem !important;
        min-height: 28px;
    }

    .text-success,
    .text-danger,
    .text-primary {
        font-size: 0.5rem !important;
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

    .booking-details-container,
    .booking-details-container * {
        font-size: 0.45rem !important;
    }

    .booking-details-container h3 {
        font-size: 0.55rem !important;
    }

    .table-details th {
        width: 60px;
        font-size: 0.4rem !important;
    }

    .table-details td {
        font-size: 0.4rem !important;
    }

    .badge-status {
        font-size: 0.4rem !important;
        min-width: 30px;
    }

    .booking-details-container .btn {
        font-size: 0.4rem !important;
        min-height: 24px;
    }

    .d-flex.gap-2 .btn {
        font-size: 0.35rem !important;
        min-height: 22px;
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
