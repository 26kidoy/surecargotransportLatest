@extends('admin.layouts.app')

@section('title', 'Admin Details')
@section('header', 'Admin Details')

@section('content')
<style nonce="{{ $csp_nonce }}">
  /* ============================================================
   REPORT/DETAILS PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   White & Violet Theme
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-dark: #4a148c;
    --violet-light: #d1c4e9;
    --violet-bg-light: #f3f0f7;
    --violet-bg-lighter: #e8e0f0;
    --violet-soft: #f3e5f5;
    --text-dark: #2c2c3e;
    --text-muted: #6c6c80;
    --white: #ffffff;
    --shadow-color: rgba(128, 0, 128, 0.05);
    --border-light: #f3f0f7;

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
   CHART CONTAINER
   ============================================================ */
.chart-container {
    background: var(--white);
    border-radius: 24px;
    padding: var(--sp-xl);
    box-shadow: 0 12px 30px var(--shadow-color);
    font-size: var(--font-base);
    animation: zoomFade 0.45s ease;
}

@keyframes zoomFade {
    0% { opacity: 0; transform: scale(0.97); }
    100% { opacity: 1; transform: scale(1); }
}

/* ============================================================
   TABLE
   ============================================================ */
.table-custom {
    width: 100%;
    background: var(--white);
    border-radius: 16px;
    overflow: hidden;
    font-size: var(--font-base);
    border-collapse: collapse;
}

.table-custom th {
    background: var(--violet-primary);
    color: var(--white);
    font-weight: 600;
    padding: var(--sp-md) var(--sp-lg);
    width: 200px;
    font-size: var(--font-base);
    text-align: left;
}

.table-custom td {
    padding: var(--sp-md) var(--sp-lg);
    background: var(--white);
    border-bottom: 1px solid var(--border-light);
    color: var(--text-dark);
    font-weight: 400;
    font-size: var(--font-base);
}

.table-custom tr:last-child td {
    border-bottom: none;
}

.table-custom tr:hover td {
    background-color: var(--violet-soft);
}

/* ============================================================
   BADGES
   ============================================================ */
.role-badge {
    background: var(--violet-soft);
    color: var(--violet-dark);
    padding: var(--sp-xs) var(--sp-lg);
    border-radius: 40px;
    font-weight: 600;
    display: inline-block;
    font-size: var(--font-sm);
    transition: all 0.2s ease;
}

.role-badge:hover {
    background: var(--violet-primary);
    color: var(--white);
    transform: scale(1.05);
}

.badge-status {
    padding: var(--sp-xs) var(--sp-lg);
    border-radius: 40px;
    font-weight: 600;
    font-size: var(--font-sm);
    display: inline-block;
}

.badge-active {
    background: var(--violet-primary);
    color: var(--white);
}

.badge-inactive {
    background: var(--violet-bg-light);
    color: var(--text-muted);
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-warning {
    background: var(--violet-primary);
    border: none;
    padding: var(--sp-sm) var(--sp-xl);
    border-radius: 40px;
    color: var(--white);
    font-weight: 500;
    font-size: var(--font-base);
    transition: all 0.25s ease;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-warning:hover {
    background: var(--violet-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(123, 31, 162, 0.25);
    color: var(--white);
}

.btn-warning:active {
    transform: translateY(0);
}

.btn-secondary {
    background: var(--violet-bg-light);
    color: var(--text-dark);
    border: 1px solid var(--violet-light);
    padding: var(--sp-sm) var(--sp-xl);
    border-radius: 40px;
    font-size: var(--font-base);
    transition: all 0.2s ease;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-secondary:hover {
    background: var(--violet-bg-lighter);
    transform: scale(0.98);
}

.btn-secondary:active {
    transform: scale(0.95);
}

/* ============================================================
   UTILITY
   ============================================================ */
.gap-2 {
    gap: var(--sp-lg) !important;
}

.gap-3 {
    gap: var(--sp-md) !important;
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

    .chart-container {
        padding: var(--sp-lg);
        border-radius: 20px;
    }

    .table-custom th {
        padding: var(--sp-sm) var(--sp-md);
        font-size: var(--font-sm);
        width: 160px;
    }

    .table-custom td {
        padding: var(--sp-sm) var(--sp-md);
        font-size: var(--font-sm);
    }

    .btn-warning,
    .btn-secondary {
        padding: var(--sp-sm) var(--sp-lg);
        min-height: 40px;
        font-size: var(--font-sm);
    }

    .role-badge {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-md);
    }

    .badge-status {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-md);
    }

    .gap-2 {
        gap: var(--sp-md) !important;
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

    .chart-container {
        padding: var(--sp-md);
        border-radius: 18px;
    }

    .table-custom {
        border-radius: 12px;
        font-size: var(--font-sm);
    }

    .table-custom th {
        padding: var(--sp-sm) var(--sp-md);
        font-size: var(--font-sm);
        width: 120px;
    }

    .table-custom td {
        padding: var(--sp-sm) var(--sp-md);
        font-size: var(--font-sm);
    }

    .btn-warning,
    .btn-secondary {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-lg);
        min-height: 38px;
        border-radius: 32px;
    }

    .role-badge {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 30px;
    }

    .badge-status {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 30px;
    }

    .gap-2 {
        gap: var(--sp-sm) !important;
    }

    /* Stack buttons on mobile */
    .d-flex.gap-2 {
        flex-wrap: wrap;
    }

    .d-flex.gap-2 .btn {
        flex: 1;
        min-width: 0;
        width: 100%;
    }

    .row {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .col-md-6,
    .col-lg-4 {
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

    .chart-container {
        padding: var(--sp-sm);
        border-radius: 14px;
    }

    .table-custom {
        border-radius: 10px;
        font-size: var(--font-xs);
    }

    .table-custom th {
        padding: var(--sp-xs) var(--sp-sm);
        font-size: var(--font-xs);
        width: 90px;
    }

    .table-custom td {
        padding: var(--sp-xs) var(--sp-sm);
        font-size: var(--font-xs);
    }

    .btn-warning,
    .btn-secondary {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 28px;
    }

    .role-badge {
        font-size: 0.6rem;
        padding: 0.1rem var(--sp-xs);
        border-radius: 24px;
    }

    .badge-status {
        font-size: 0.6rem;
        padding: 0.1rem var(--sp-xs);
        border-radius: 24px;
    }

    .gap-2 {
        gap: var(--sp-xs) !important;
    }

    .d-flex.gap-2 .btn {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .row {
        --bs-gutter-y: var(--sp-xs) !important;
        --bs-gutter-x: var(--sp-xs) !important;
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

    .chart-container {
        padding: var(--sp-xs);
        border-radius: 10px;
    }

    .table-custom {
        border-radius: 8px;
        font-size: 0.55rem;
    }

    .table-custom th {
        padding: 0.05rem var(--sp-xs);
        font-size: 0.55rem;
        width: 70px;
    }

    .table-custom td {
        padding: 0.05rem var(--sp-xs);
        font-size: 0.55rem;
    }

    .btn-warning,
    .btn-secondary {
        font-size: 0.55rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 30px;
        border-radius: 24px;
    }

    .role-badge {
        font-size: 0.5rem;
        padding: 0.05rem var(--sp-xs);
        border-radius: 20px;
    }

    .badge-status {
        font-size: 0.5rem;
        padding: 0.05rem var(--sp-xs);
        border-radius: 20px;
    }

    .d-flex.gap-2 .btn {
        font-size: 0.5rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 28px;
    }

    .gap-2 {
        gap: var(--sp-xs) !important;
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

    .table-custom th {
        font-size: 0.45rem;
        padding: 0.05rem var(--sp-xs);
        width: 60px;
    }

    .table-custom td {
        font-size: 0.45rem;
        padding: 0.05rem var(--sp-xs);
    }

    .btn-warning,
    .btn-secondary {
        font-size: 0.45rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 26px;
        border-radius: 20px;
    }

    .role-badge {
        font-size: 0.4rem;
        padding: 0.05rem var(--sp-xs);
    }

    .badge-status {
        font-size: 0.4rem;
        padding: 0.05rem var(--sp-xs);
    }

    .d-flex.gap-2 .btn {
        font-size: 0.4rem;
        min-height: 24px;
    }

    .chart-container {
        padding: 0.05rem;
        border-radius: 8px;
    }
}

/* ============================================================
   RESPONSIVE TABLE - SCROLL ON MOBILE
   ============================================================ */
@media (max-width: 576px) {
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0 calc(-1 * var(--sp-sm));
        padding: 0 var(--sp-sm);
    }

    .table-custom {
        min-width: 400px;
    }

    .table-custom th,
    .table-custom td {
        white-space: nowrap;
    }
}

@media (max-width: 400px) {
    .table-responsive {
        margin: 0 calc(-1 * var(--sp-xs));
        padding: 0 var(--sp-xs);
    }

    .table-custom {
        min-width: 350px;
    }
}

/* ============================================================
   TOAST NOTIFICATIONS (if used)
   ============================================================ */
.toast-container {
    z-index: 9999;
}

.toast {
    font-size: var(--font-base);
    border-radius: 12px;
}

.toast-header {
    font-size: var(--font-base);
    font-weight: 600;
}

.toast-body {
    font-size: var(--font-sm);
}

@media (max-width: 576px) {
    .toast {
        font-size: var(--font-xs);
    }
    .toast-header {
        font-size: var(--font-xs);
    }
    .toast-body {
        font-size: 0.6rem;
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

<div class="chart-container">
    <div class="row">
        <div class="col-md-8">
            <table class="table table-custom">
                <tr>
                    <th>ID</th>
                    <td>{{ $admin->id }}</td>
                </tr>
                <tr>
                    <th>Full Name</th>
                    <td>{{ $admin->name }}</td>
                </tr>
                <tr>
                    <th>Email Address</th>
                    <td>{{ $admin->email }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>
                        <span class="role-badge role-{{ $admin->role }}">
                            {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Account Status</th>
                    <td>
                        @if($admin->is_active)
                            <span class="badge-status badge-active">Active</span>
                        @else
                            <span class="badge-status badge-inactive">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Last Login</th>
                    <td>{{ $admin->last_login_at ? \Carbon\Carbon::parse($admin->last_login_at)->format('F d, Y H:i') : 'Never' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $admin->created_at->format('F d, Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-3 mt-4">
        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-warning">Edit Admin</a>
        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
