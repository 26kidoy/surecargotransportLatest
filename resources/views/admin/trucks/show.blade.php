@extends('admin.layouts.app')

@section('title', 'Truck Details')
@section('page-title', 'Truck Details')

@section('content')
<style nonce="{{ $csp_nonce }}">
/* ============================================================
   TRUCK DETAIL - DEEPSEEK-STYLE RESPONSIVE STYLES
   White & Violet Theme
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-dark: #4a148c;
    --violet-light: #d1c4e9;
    --violet-bg-light: #f3f0f7;
    --violet-bg-lighter: #e8e0f0;
    --violet-soft: #f3e5f5;
    --violet-shadow: rgba(123, 31, 162, 0.08);
    --violet-shadow-hover: rgba(123, 31, 162, 0.12);
    --violet-shadow-focus: rgba(123, 31, 162, 0.25);
    --white: #ffffff;
    --text-dark: #2c2c3e;
    --text-muted: #6c6c80;
    --gray-soft: #f8f9fa;

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
   CONTAINER
   ============================================================ */
.truck-detail-container {
    background: var(--white);
    border-radius: 2rem;
    box-shadow: 0 1.5rem 3rem var(--violet-shadow);
    padding: var(--sp-xxl);
    border-left: 8px solid var(--violet-primary);
    border-right: 8px solid #9c27b0;
    transition: all 0.3s;
}

.truck-detail-container:hover {
    box-shadow: 0 2rem 4rem var(--violet-shadow-hover);
    transform: translateY(-2px);
}

/* ============================================================
   GLOBAL FONT SIZING - DeepSeek Style
   ============================================================ */
.truck-detail-container,
.truck-detail-container .table,
.truck-detail-container .table th,
.truck-detail-container .table td,
.truck-detail-container .btn,
.truck-detail-container .badge-status {
    font-size: var(--font-base) !important;
    font-weight: 400 !important;
}

/* ============================================================
   TABLE
   ============================================================ */
.table-custom {
    width: 100%;
    background: var(--white);
    border-collapse: separate;
    border-spacing: 0;
}

.table-custom th {
    background: var(--violet-bg-light);
    color: var(--violet-dark);
    font-weight: 600;
    width: 35%;
    padding: var(--sp-md);
    border-bottom: 2px solid var(--violet-primary);
    font-size: var(--font-base) !important;
}

.table-custom td {
    padding: var(--sp-md);
    border-bottom: 1px solid var(--violet-light);
    color: var(--text-dark);
    font-size: var(--font-base) !important;
}

/* ============================================================
   BADGES
   ============================================================ */
.badge-status {
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 2rem;
    font-weight: 600;
    font-size: var(--font-sm) !important;
    display: inline-block;
    min-width: 100px;
    text-align: center;
}

.badge-active {
    background: var(--violet-soft);
    color: var(--violet-dark);
    border-left: 4px solid var(--violet-primary);
}

.badge-warning {
    background: var(--violet-soft);
    color: var(--violet-dark);
    border-left: 4px solid #9c27b0;
}

.badge-inactive {
    background: var(--violet-soft);
    color: var(--text-muted);
    border-left: 4px solid #b39ddb;
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-warning {
    background: linear-gradient(135deg, var(--violet-primary) 0%, var(--violet-dark) 100%);
    border: none;
    border-radius: 2rem;
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    font-size: var(--font-base) !important;
    color: var(--white);
    transition: all 0.25s;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-warning:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(123, 31, 162, 0.3);
    background: linear-gradient(135deg, #9c27b0 0%, var(--violet-primary) 100%);
    color: var(--white);
}

.btn-secondary {
    background: var(--violet-bg-light);
    border: 1px solid var(--violet-light);
    border-radius: 2rem;
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    font-size: var(--font-base) !important;
    color: var(--text-dark);
    transition: all 0.25s;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-secondary:hover {
    transform: translateY(-3px);
    background: var(--violet-bg-lighter);
    color: var(--text-dark);
}

.btn i {
    margin-right: 8px;
    font-size: var(--font-md);
}

/* ============================================================
   IMAGE
   ============================================================ */
.truck-image-detail {
    border-radius: 1.5rem;
    border: 3px solid var(--violet-primary);
    box-shadow: 0 0.5rem 1rem rgba(123, 31, 162, 0.1);
    transition: transform 0.3s;
    width: 100%;
    max-width: 500px;
    height: auto;
    aspect-ratio: 1 / 1;
    object-fit: cover;
}

.truck-image-detail:hover {
    transform: scale(1.02);
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

    .truck-detail-container {
        padding: var(--sp-lg);
        border-left-width: 6px;
        border-right-width: 6px;
    }

    .table-custom th {
        padding: var(--sp-sm) var(--sp-md);
        width: 30%;
    }

    .table-custom td {
        padding: var(--sp-sm) var(--sp-md);
    }

    .btn-warning,
    .btn-secondary {
        padding: var(--sp-sm) var(--sp-lg);
        min-height: 40px;
        font-size: var(--font-sm) !important;
    }

    .truck-image-detail {
        max-width: 400px;
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

    .truck-detail-container {
        padding: var(--sp-md);
        border-left-width: 4px;
        border-right-width: 4px;
        border-radius: 1.5rem;
        display: block !important;
    }

    .truck-detail-container,
    .truck-detail-container .table,
    .truck-detail-container .table th,
    .truck-detail-container .table td,
    .truck-detail-container .btn,
    .truck-detail-container .badge-status {
        font-size: var(--font-sm) !important;
    }

    .table-custom th {
        padding: var(--sp-sm) var(--sp-sm);
        width: 40%;
        font-size: var(--font-sm) !important;
    }

    .table-custom td {
        padding: var(--sp-sm) var(--sp-sm);
        font-size: var(--font-sm) !important;
    }

    .badge-status {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-width: 80px;
    }

    .btn-warning,
    .btn-secondary {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
        border-radius: 1.5rem;
    }

    .btn i {
        font-size: var(--font-base);
        margin-right: 6px;
    }

    .truck-image-detail {
        max-width: 100%;
        border-radius: 1rem;
        border-width: 2px;
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

    .truck-detail-container {
        padding: var(--sp-sm);
        border-left-width: 3px;
        border-right-width: 3px;
        border-radius: 1.2rem;
    }

    .truck-detail-container,
    .truck-detail-container .table,
    .truck-detail-container .table th,
    .truck-detail-container .table td,
    .truck-detail-container .btn,
    .truck-detail-container .badge-status {
        font-size: var(--font-xs) !important;
    }

    .table-custom th {
        padding: var(--sp-xs) var(--sp-xs);
        width: 45%;
        font-size: var(--font-xs) !important;
    }

    .table-custom td {
        padding: var(--sp-xs) var(--sp-xs);
        font-size: var(--font-xs) !important;
    }

    .badge-status {
        font-size: 0.6rem !important;
        padding: 0.1rem var(--sp-xs);
        min-width: 60px;
    }

    .btn-warning,
    .btn-secondary {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 1.2rem;
    }

    .btn i {
        font-size: var(--font-sm);
        margin-right: 4px;
    }

    .truck-image-detail {
        border-width: 2px;
        border-radius: 0.8rem;
        max-width: 100%;
    }

    .d-flex.gap-2 .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
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

    .truck-detail-container {
        padding: var(--sp-xs);
        border-left-width: 2px;
        border-right-width: 2px;
        border-radius: 1rem;
    }

    .truck-detail-container,
    .truck-detail-container .table,
    .truck-detail-container .table th,
    .truck-detail-container .table td,
    .truck-detail-container .btn,
    .truck-detail-container .badge-status {
        font-size: 0.55rem !important;
    }

    .table-custom th {
        font-size: 0.55rem !important;
        padding: 0.05rem var(--sp-xs);
        width: 40%;
    }

    .table-custom td {
        font-size: 0.55rem !important;
        padding: 0.05rem var(--sp-xs);
    }

    .badge-status {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-width: 50px;
    }

    .btn-warning,
    .btn-secondary {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        border-radius: 1rem;
    }

    .btn i {
        font-size: 0.55rem;
    }

    .truck-image-detail {
        border-width: 1.5px;
        border-radius: 0.6rem;
    }

    .d-flex.gap-2 .btn {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 28px;
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

    .truck-detail-container {
        padding: 0.05rem;
        border-radius: 0.8rem;
    }

    .table-custom th {
        font-size: 0.45rem !important;
        padding: 0.05rem var(--sp-xs);
        width: 35%;
    }

    .table-custom td {
        font-size: 0.45rem !important;
        padding: 0.05rem var(--sp-xs);
    }

    .badge-status {
        font-size: 0.4rem !important;
        padding: 0.05rem var(--sp-xs);
        min-width: 40px;
    }

    .btn-warning,
    .btn-secondary {
        font-size: 0.45rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 26px;
        border-radius: 0.8rem;
    }

    .d-flex.gap-2 .btn {
        font-size: 0.4rem !important;
        min-height: 24px;
    }

    .truck-image-detail {
        border-width: 1px;
        border-radius: 0.4rem;
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

<div class="truck-detail-container">
    <div class="row">
        <div class="col-md-6">
            <table class="table-custom">
                <tr>
                    <th>Truck ID</th>
                    <td>{{ $truck->id }}</td>
                </tr>
                <tr>
                    <th>Truck Name</th>
                    <td>{{ $truck->truck_name }}</td>
                </tr>
                <tr>
                    <th>Truck Number</th>
                    <td>{{ $truck->truck_number }}</td>
                </tr>
                <tr>
                    <th>Driver Name</th>
                    <td>{{ $truck->driver_name }}</td>
                </tr>
                <tr>
                    <th>Driver Phone</th>
                    <td>{{ $truck->driver_phone }}</td>
                </tr>
                <tr>
                    <th>Truck Model</th>
                    <td>{{ $truck->truck_model }}</td>
                </tr>
                <tr>
                    <th>Color</th>
                    <td>{{ $truck->color }}</td>
                </tr>
                <tr>
                    <th>Max Capacity</th>
                    <td>{{ number_format($truck->max_capacity) }} trays</td>
                </tr>
                <tr>
                    <th>Low Stock Threshold</th>
                    <td>{{ number_format($truck->low_stock_threshold ?? 500) }} trays</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge-status
                            @if($truck->status == 'available') badge-active
                            @elseif($truck->status == 'booked') badge-warning
                            @else badge-inactive
                            @endif">
                            {{ ucfirst($truck->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $truck->created_at->format('F d, Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Last Updated</th>
                    <td>{{ $truck->updated_at->format('F d, Y H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 text-center">
            @if($truck->image)
                <img src="{{ asset($truck->image) }}" class="truck-image-detail" alt="{{ $truck->truck_name }}" style="max-height: 300px;">
            @else
                <div class="bg-light rounded-4 p-5 text-center">
                    <i class="fas fa-truck fa-5x text-secondary mb-3"></i>
                    <p class="text-muted">No image uploaded</p>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-end gap-3 mt-4">
        <a href="{{ route('admin.trucks.edit', $truck->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit Truck
        </a>
        <a href="{{ route('admin.trucks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>
</div>
@endsection
