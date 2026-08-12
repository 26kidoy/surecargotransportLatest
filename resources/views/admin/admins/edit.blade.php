@extends('admin.layouts.app')

@section('title', 'Edit Admin')
@section('header', 'Edit Admin')

@section('content')
<style nonce="{{ $csp_nonce }}">
   /* ============================================================
   ANALYTICS/REPORT PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   White & Violet Theme
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-dark: #4a148c;
    --violet-light: #d1c4e9;
    --violet-bg-light: #f3f0f7;
    --violet-bg-lighter: #e8e0f0;
    --text-dark: #2c2c3e;
    --text-muted: #6b6b80;
    --white: #ffffff;
    --shadow-color: rgba(128, 0, 128, 0.06);

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
    border-radius: 20px;
    padding: var(--sp-xl);
    box-shadow: 0 10px 30px var(--shadow-color);
    font-size: var(--font-base);
    animation: fadeInRight 0.5s ease;
}

@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

/* ============================================================
   FORM ELEMENTS
   ============================================================ */
.form-label {
    font-weight: 600;
    color: var(--violet-dark);
    font-size: var(--font-base);
    margin-bottom: var(--sp-xs);
}

.form-control,
.form-select {
    background: var(--white) !important;
    border: 1.5px solid var(--violet-light);
    border-radius: 12px;
    padding: var(--sp-md) var(--sp-lg);
    font-size: var(--font-base);
    color: var(--text-dark);
    transition: all 0.2s ease;
    font-weight: 400;
    min-height: 48px;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--violet-primary);
    box-shadow: 0 0 0 4px rgba(123, 31, 162, 0.15);
    outline: none;
    transform: translateY(-1px);
}

.form-control::placeholder {
    color: var(--text-muted);
    font-weight: 400;
}

.form-select option {
    font-size: var(--font-base);
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-primary {
    background: var(--violet-primary);
    padding: var(--sp-sm) var(--sp-xl);
    border-radius: 40px;
    font-weight: 600;
    font-size: var(--font-base);
    transition: all 0.25s ease;
    border: none;
    color: var(--white);
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-primary:hover {
    background: var(--violet-dark);
    transform: scale(1.02);
    box-shadow: 0 5px 12px rgba(123, 31, 162, 0.3);
    color: var(--white);
}

.btn-primary:active {
    transform: scale(0.98);
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
    transform: translateY(-1px);
}

.btn-secondary:active {
    transform: scale(0.98);
}

/* ============================================================
   CHECKBOXES
   ============================================================ */
.form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    margin-top: 0.2rem;
    border-radius: 5px;
    border: 1.5px solid var(--violet-primary);
    min-width: 1.2rem;
    min-height: 1.2rem;
    cursor: pointer;
}

.form-check-input:checked {
    background-color: var(--violet-primary);
    border-color: var(--violet-primary);
}

.form-check-input:focus {
    box-shadow: 0 0 0 3px rgba(123, 31, 162, 0.15);
}

.form-check-label {
    font-size: var(--font-base);
    color: var(--text-dark);
    font-weight: 400;
    margin-left: var(--sp-sm);
    cursor: pointer;
}

.form-check {
    display: flex;
    align-items: center;
    gap: var(--sp-xs);
    margin-bottom: var(--sp-xs);
}

/* ============================================================
   UTILITY
   ============================================================ */
.text-white {
    color: var(--text-dark) !important;
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
    }

    .form-control,
    .form-select {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 42px;
    }

    .btn-primary,
    .btn-secondary {
        padding: var(--sp-sm) var(--sp-lg);
        min-height: 40px;
        font-size: var(--font-sm);
    }

    .form-check-input {
        width: 1.1rem;
        height: 1.1rem;
        min-width: 1.1rem;
        min-height: 1.1rem;
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
        border-radius: 16px;
    }

    .form-label {
        font-size: var(--font-sm);
        margin-bottom: var(--sp-xs);
    }

    .form-control,
    .form-select {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        min-height: 40px;
        border-radius: 10px;
    }

    .form-select option {
        font-size: var(--font-sm);
    }

    .btn-primary,
    .btn-secondary {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-lg);
        min-height: 40px;
        border-radius: 32px;
    }

    .form-check-input {
        width: 1.1rem;
        height: 1.1rem;
        min-width: 1.1rem;
        min-height: 1.1rem;
    }

    .form-check-label {
        font-size: var(--font-sm);
        margin-left: var(--sp-xs);
    }

    .form-check {
        margin-bottom: var(--sp-xs);
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

    .form-label {
        font-size: var(--font-xs);
        margin-bottom: 0.15rem;
    }

    .form-control,
    .form-select {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 36px;
        border-radius: 8px;
        border-width: 1px;
    }

    .form-select option {
        font-size: var(--font-xs);
    }

    .btn-primary,
    .btn-secondary {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-md);
        min-height: 36px;
        border-radius: 28px;
    }

    .form-check-input {
        width: 1rem;
        height: 1rem;
        min-width: 1rem;
        min-height: 1rem;
        border-radius: 4px;
    }

    .form-check-label {
        font-size: var(--font-xs);
        margin-left: var(--sp-xs);
    }

    .form-check {
        margin-bottom: var(--sp-xs);
    }

    /* Stack buttons on small screens */
    .d-flex.gap-3 {
        gap: var(--sp-xs) !important;
        flex-wrap: wrap;
    }

    .d-flex.gap-3 .btn {
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

    .col-md-4,
    .col-md-6,
    .col-lg-3 {
        padding-left: var(--sp-xs);
        padding-right: var(--sp-xs);
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

    .form-label {
        font-size: 0.55rem;
        margin-bottom: 0.1rem;
    }

    .form-control,
    .form-select {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 32px;
        border-radius: 6px;
    }

    .form-select option {
        font-size: 0.55rem;
    }

    .btn-primary,
    .btn-secondary {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 32px;
        border-radius: 24px;
    }

    .form-check-input {
        width: 0.9rem;
        height: 0.9rem;
        min-width: 0.9rem;
        min-height: 0.9rem;
        border-radius: 3px;
    }

    .form-check-label {
        font-size: 0.55rem;
        margin-left: 0.1rem;
    }

    .form-check {
        margin-bottom: 0.05rem;
    }

    .d-flex.gap-3 .btn {
        font-size: 0.5rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 28px;
    }

    .row.g-3 {
        --bs-gutter-y: var(--sp-xs) !important;
        --bs-gutter-x: var(--sp-xs) !important;
    }

    .row.g-4 {
        --bs-gutter-y: var(--sp-xs) !important;
        --bs-gutter-x: var(--sp-xs) !important;
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

    .chart-container {
        padding: 0.1rem;
        border-radius: 8px;
    }

    .form-label {
        font-size: 0.45rem;
    }

    .form-control,
    .form-select {
        font-size: 0.45rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 28px;
        border-radius: 4px;
    }

    .btn-primary,
    .btn-secondary {
        font-size: 0.45rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 28px;
        border-radius: 20px;
    }

    .form-check-input {
        width: 0.8rem;
        height: 0.8rem;
        min-width: 0.8rem;
        min-height: 0.8rem;
    }

    .form-check-label {
        font-size: 0.45rem;
    }

    .d-flex.gap-3 .btn {
        font-size: 0.4rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 24px;
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
   TABLES (if used)
   ============================================================ */
.table {
    font-size: var(--font-base);
}

.table thead th {
    font-size: var(--font-sm);
    font-weight: 600;
    color: var(--violet-dark);
}

.table tbody td {
    font-size: var(--font-base);
}

.table-hover tbody tr:hover {
    background-color: var(--violet-bg-light);
}

@media (max-width: 576px) {
    .table {
        font-size: var(--font-xs);
    }
    .table thead th {
        font-size: var(--font-xs);
    }
    .table tbody td {
        font-size: var(--font-xs);
    }
}

/* ============================================================
   MODAL (if used)
   ============================================================ */
.modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.modal-header {
    border-bottom: 1px solid var(--violet-light);
    padding: var(--sp-md) var(--sp-lg);
}

.modal-title {
    font-size: var(--font-lg);
    font-weight: 700;
    color: var(--violet-dark);
}

.modal-body {
    padding: var(--sp-lg);
    font-size: var(--font-base);
}

.modal-footer {
    padding: var(--sp-md) var(--sp-lg);
    border-top: 1px solid var(--violet-light);
}

.modal-footer .btn {
    font-size: var(--font-base);
    min-height: 40px;
}

@media (max-width: 576px) {
    .modal-title {
        font-size: var(--font-sm);
    }
    .modal-body {
        padding: var(--sp-sm);
        font-size: var(--font-xs);
    }
    .modal-footer .btn {
        font-size: var(--font-xs);
        min-height: 34px;
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
    <form method="POST" action="{{ route('admin.admins.update', $admin->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ $admin->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $admin->email }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">New Password <span style="font-weight: normal; font-size:1.0rem;">(leave blank to keep current)</span></label>
                <input type="password" name="password" class="form-control" placeholder="Change password">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="fleet_manager" {{ $admin->role == 'fleet_manager' ? 'selected' : '' }}>Fleet Manager</option>
                <option value="auditor" {{ $admin->role == 'auditor' ? 'selected' : '' }}>Auditor</option>
                <option value="super_admin" {{ $admin->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
            </select>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" {{ $admin->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active Account</label>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Admin</button>
        </div>
    </form>
</div>
@endsection
