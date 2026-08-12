
@extends('admin.layouts.app')

@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking')

@section('content')
<style nonce="{{ $csp_nonce }}">
/* ============================================================
   FORM/CONTAINER PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   White & Violet Theme - Professional & Smooth
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-dark: #4a148c;
    --violet-light: #d1c4e9;
    --violet-bg-light: #f3f0f7;
    --violet-bg-soft: #faf8ff;
    --violet-shadow: rgba(123, 31, 162, 0.2);
    --violet-shadow-hover: rgba(123, 31, 162, 0.25);
    --violet-shadow-focus: rgba(123, 31, 162, 0.2);
    --white: #ffffff;
    --text-dark: #2c2c3e;
    --text-muted: #6c6c80;
    --placeholder-color: #94a3b8;

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
   FORM CONTAINER
   ============================================================ */
.form-container {
    background: var(--white);
    border-radius: 32px;
    padding: var(--sp-xl);
    box-shadow: 0 25px 45px -12px var(--violet-shadow), 0 2px 6px rgba(123, 31, 162, 0.05);
    transition: all 0.3s ease;
    animation: fadeInScale 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1);
}

.form-container:hover {
    box-shadow: 0 30px 55px -12px var(--violet-shadow-hover);
}

@keyframes fadeInScale {
    0% {
        opacity: 0;
        transform: scale(0.97) translateY(15px);
    }
    100% {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* ============================================================
   LABELS with SVG icon alignment - Violet
   ============================================================ */
.form-label {
    font-size: var(--font-base) !important;
    font-weight: 600 !important;
    color: var(--violet-dark);
    margin-bottom: var(--sp-sm);
    letter-spacing: -0.2px;
    display: flex;
    align-items: center;
    gap: var(--sp-xs);
    background: linear-gradient(135deg, var(--violet-dark) 0%, var(--violet-primary) 100%);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    text-shadow: none;
}

.form-label svg {
    width: 1.6rem;
    height: 1.6rem;
    flex-shrink: 0;
}

/* ============================================================
   INPUTS, SELECTS, TEXTAREA - Violet theme
   ============================================================ */
.form-control,
.form-select,
textarea.form-control {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-md) !important;
    border: 2px solid var(--violet-light);
    border-radius: 20px;
    background-color: var(--white);
    color: var(--text-dark);
    font-weight: 400;
    transition: all 0.25s ease-in-out;
    box-shadow: 0 1px 2px rgba(123, 31, 162, 0.03);
    min-height: 44px;
}

.form-control:focus,
.form-select:focus,
textarea.form-control:focus {
    border-color: var(--violet-primary) !important;
    box-shadow: 0 0 0 4px var(--violet-shadow-focus), 0 2px 8px rgba(123, 31, 162, 0.05);
    outline: none;
    transform: translateY(-1px);
}

.form-control:hover,
.form-select:hover,
textarea.form-control:hover {
    border-color: #9c27b0;
    background-color: var(--violet-bg-soft);
    box-shadow: 0 8px 18px rgba(123, 31, 162, 0.05);
}

/* disabled / readonly fields */
.form-control:read-only,
.form-control[disabled],
input:disabled {
    background-color: var(--violet-bg-light);
    opacity: 0.85;
    font-style: italic;
    border-color: var(--violet-light);
    cursor: not-allowed;
    color: var(--text-muted);
}

/* ============================================================
   PLACEHOLDERS
   ============================================================ */
.form-control::placeholder,
.form-select::placeholder {
    font-size: var(--font-base);
    color: var(--placeholder-color);
    font-weight: 400;
}

/* ============================================================
   SELECT - custom arrow - Violet
   ============================================================ */
.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%237b1fa2' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    appearance: none;
    padding-right: 3rem !important;
    background-position: right 1rem center;
    background-repeat: no-repeat;
    background-size: 1.2rem;
}

.form-select option {
    font-size: var(--font-base);
    padding: var(--sp-sm);
}

/* ============================================================
   BUTTONS
   ============================================================ */
/* Primary button - Violet Gradient */
.btn-green {
    background: linear-gradient(105deg, var(--violet-primary), var(--violet-dark));
    border: none;
    padding: var(--sp-sm) var(--sp-xl);
    font-size: var(--font-base) !important;
    font-weight: 600;
    border-radius: 60px;
    color: var(--white);
    transition: all 0.3s ease;
    box-shadow: 0 8px 18px rgba(123, 31, 162, 0.25);
    letter-spacing: 0.3px;
    display: inline-flex;
    align-items: center;
    gap: var(--sp-xs);
    min-height: 44px;
    min-width: 140px;
    justify-content: center;
}

.btn-green:hover {
    background: linear-gradient(105deg, var(--violet-dark), #380e6b);
    transform: translateY(-3px);
    box-shadow: 0 16px 28px -8px rgba(123, 31, 162, 0.4);
    color: var(--white);
}

.btn-green:active {
    transform: translateY(1px);
}

/* Secondary button - Light Violet */
.btn-outline-red {
    background: transparent;
    border: 2px solid var(--violet-primary);
    color: var(--violet-primary);
    padding: var(--sp-sm) var(--sp-xl);
    font-size: var(--font-base) !important;
    font-weight: 600;
    border-radius: 60px;
    transition: all 0.25s ease;
    box-shadow: 0 2px 6px rgba(123, 31, 162, 0.1);
    display: inline-flex;
    align-items: center;
    gap: var(--sp-xs);
    min-height: 44px;
    min-width: 140px;
    justify-content: center;
}

.btn-outline-red:hover {
    background: var(--violet-primary);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 12px 22px -8px rgba(123, 31, 162, 0.4);
}

.btn-outline-red:active {
    transform: translateY(1px);
}

/* ============================================================
   TEXTAREA
   ============================================================ */
textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

/* ============================================================
   SPACING & ANIMATIONS
   ============================================================ */
.row {
    margin-bottom: var(--sp-sm);
}

.mb-3,
.row > [class*="col-"] {
    animation: slideUpFade 0.45s ease backwards;
}

@keyframes slideUpFade {
    from {
        opacity: 0;
        transform: translateY(18px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* generate delays for each row and element */
.row:nth-child(1) .mb-3,
.row:nth-child(1) > div { animation-delay: 0.05s; }
.row:nth-child(2) .mb-3,
.row:nth-child(2) > div { animation-delay: 0.1s; }
.row:nth-child(3) .mb-3,
.row:nth-child(3) > div { animation-delay: 0.15s; }
.row:nth-child(4) .mb-3,
.row:nth-child(4) > div { animation-delay: 0.2s; }
.row:nth-child(5) .mb-3,
.row:nth-child(5) > div { animation-delay: 0.25s; }
.mb-3:not(.row) { animation-delay: 0.1s; }

/* ============================================================
   BUTTONS CONTAINER
   ============================================================ */
.d-flex.gap-2 {
    gap: var(--sp-md) !important;
    margin-top: var(--sp-xl);
    padding-top: var(--sp-sm);
    flex-wrap: wrap;
}

.d-flex.gap-2 .btn,
.d-flex.gap-2 .btn-green,
.d-flex.gap-2 .btn-outline-red {
    flex: 0 1 auto;
}

/* ============================================================
   CHART CONTAINER BASE
   ============================================================ */
.chart-container {
    width: 100%;
}

/* ============================================================
   BUTTON BASE
   ============================================================ */
button, .btn {
    font-family: inherit;
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

    .form-container {
        padding: var(--sp-lg);
        border-radius: 28px;
    }

    .form-control,
    .form-select,
    textarea.form-control {
        padding: var(--sp-sm) var(--sp-md) !important;
        min-height: 40px;
        border-radius: 16px;
    }

    .btn-green,
    .btn-outline-red {
        padding: var(--sp-sm) var(--sp-lg);
        min-height: 40px;
        min-width: 120px;
        font-size: var(--font-sm) !important;
    }

    .form-label {
        font-size: var(--font-sm) !important;
    }

    .form-label svg {
        width: 1.4rem;
        height: 1.4rem;
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

    .form-container {
        padding: var(--sp-md);
        border-radius: 24px;
    }

    .form-label {
        font-size: var(--font-sm) !important;
        margin-bottom: var(--sp-xs);
    }

    .form-label svg {
        width: 1.4rem;
        height: 1.4rem;
    }

    .form-control,
    .form-select,
    textarea.form-control {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md) !important;
        min-height: 38px;
        border-radius: 14px;
        border-width: 1.5px;
    }

    .form-control::placeholder,
    .form-select::placeholder {
        font-size: var(--font-sm);
    }

    .form-select option {
        font-size: var(--font-sm);
    }

    .btn-green,
    .btn-outline-red {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
        min-width: 100px;
        border-radius: 40px;
    }

    textarea.form-control {
        min-height: 100px;
    }

    .d-flex.gap-2 {
        gap: var(--sp-sm) !important;
        margin-top: var(--sp-md);
        flex-wrap: wrap;
    }

    .d-flex.gap-2 .btn-green,
    .d-flex.gap-2 .btn-outline-red {
        flex: 1;
        min-width: 0;
        width: 100%;
    }

    .row {
        margin-bottom: var(--sp-xs);
    }

    .mb-3 {
        margin-bottom: var(--sp-sm) !important;
    }

    .form-select {
        padding-right: 2.5rem !important;
        background-position: right 0.7rem center;
        background-size: 1rem;
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

    .form-container {
        padding: var(--sp-sm);
        border-radius: 20px;
    }

    .form-label {
        font-size: var(--font-xs) !important;
        margin-bottom: 0.1rem;
    }

    .form-label svg {
        width: 1.2rem;
        height: 1.2rem;
    }

    .form-control,
    .form-select,
    textarea.form-control {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 34px;
        border-radius: 12px;
        border-width: 1.5px;
    }

    .form-control::placeholder,
    .form-select::placeholder {
        font-size: var(--font-xs);
    }

    .form-select option {
        font-size: var(--font-xs);
    }

    .btn-green,
    .btn-outline-red {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        min-width: 80px;
        border-radius: 30px;
    }

    textarea.form-control {
        min-height: 80px;
    }

    .d-flex.gap-2 {
        gap: var(--sp-xs) !important;
        margin-top: var(--sp-sm);
    }

    .d-flex.gap-2 .btn-green,
    .d-flex.gap-2 .btn-outline-red {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
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

    .form-select {
        padding-right: 2rem !important;
        background-position: right 0.5rem center;
        background-size: 0.9rem;
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

    .form-container {
        padding: var(--sp-xs);
        border-radius: 16px;
    }

    .form-label {
        font-size: 0.55rem !important;
    }

    .form-label svg {
        width: 1rem;
        height: 1rem;
    }

    .form-control,
    .form-select,
    textarea.form-control {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs) !important;
        min-height: 30px;
        border-radius: 10px;
        border-width: 1px;
    }

    .btn-green,
    .btn-outline-red {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        min-width: 70px;
        border-radius: 24px;
    }

    textarea.form-control {
        min-height: 60px;
    }

    .d-flex.gap-2 .btn-green,
    .d-flex.gap-2 .btn-outline-red {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 28px;
    }

    .form-select {
        padding-right: 1.8rem !important;
        background-position: right 0.4rem center;
        background-size: 0.8rem;
    }

    .row.g-3 {
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

    .form-container {
        padding: 0.05rem;
        border-radius: 12px;
    }

    .form-label {
        font-size: 0.45rem !important;
    }

    .form-label svg {
        width: 0.8rem;
        height: 0.8rem;
    }

    .form-control,
    .form-select,
    textarea.form-control {
        font-size: 0.45rem !important;
        padding: 0.05rem var(--sp-xs) !important;
        min-height: 26px;
        border-radius: 8px;
    }

    .btn-green,
    .btn-outline-red {
        font-size: 0.45rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 26px;
        min-width: 60px;
        border-radius: 20px;
    }

    textarea.form-control {
        min-height: 50px;
    }

    .d-flex.gap-2 .btn-green,
    .d-flex.gap-2 .btn-outline-red {
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

<div class="chart-container">
    <div class="form-container">
        <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 6L12 13L2 6" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Booking Reference
                    </label>
                    <input type="text" class="form-control" value="{{ $booking->booking_reference }}" readonly disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21V19C20 16.8 18.2 15 16 15H8C5.8 15 4 16.8 4 19V21" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="7" r="4" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        User (Optional)
                    </label>
                    <select name="user_id" id="user_id" class="form-select">
                        <option value="">Select User (Optional)</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ ($booking->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }} - {{ $user->mobile_number }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 15H21" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M7 9H17" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M5 3H19C20.1 3 21 3.9 21 5V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3Z" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="7" cy="18" r="1.5" fill="#DC2626" stroke="#DC2626" stroke-width="1"/>
                            <circle cx="17" cy="18" r="1.5" fill="#DC2626" stroke="#DC2626" stroke-width="1"/>
                        </svg>
                        Truck
                    </label>
                    <select name="truck_id" class="form-select" required>
                        <option value="">Select Truck</option>
                        @foreach($trucks as $truck)
                            <option value="{{ $truck->id }}" {{ ($booking->truck_id ?? '') == $truck->id ? 'selected' : '' }}>
                                {{ $truck->truck_number }} - {{ $truck->truck_name }} ({{ $truck->driver_name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="7" width="20" height="14" rx="2" stroke="#DC2626" stroke-width="1.5"/>
                            <path d="M16 21V5C16 3.9 15.1 3 14 3H10C8.9 3 8 3.9 8 5V21" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 11H12.01" stroke="#DC2626" stroke-width="2" stroke-linecap="round"/>
                            <path d="M12 15H12.01" stroke="#DC2626" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Quantity (Trays)
                    </label>
                    <input type="number" name="quantity" class="form-control" value="{{ $booking->quantity ?? 0 }}" min="1" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 12V18H4V12" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 2V8" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M8 4L12 2L16 4" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 12H21" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="7" cy="16" r="1" fill="#DC2626" stroke="#DC2626" stroke-width="1"/>
                            <circle cx="17" cy="16" r="1" fill="#DC2626" stroke="#DC2626" stroke-width="1"/>
                        </svg>
                        Receiver Name
                    </label>
                    <input type="text" name="receiver_name" id="receiver_name" class="form-control" value="{{ $booking->receiver_name ?? '' }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 16.92V19C22 20.1 21.1 21 20 21H4C2.9 21 2 20.1 2 19V16.92" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 6L12 13L2 6" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="2" y="4" width="20" height="14" rx="2" stroke="#DC2626" stroke-width="1.5"/>
                        </svg>
                        Receiver Phone
                    </label>
                    <input type="tel" name="receiver_phone" id="receiver_phone" class="form-control" value="{{ $booking->receiver_phone ?? '' }}" placeholder="09XXXXXXXXX" maxlength="11" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C8.13 2 5 5.13 5 9C5 13.17 12 22 12 22C12 22 19 13.17 19 9C19 5.13 15.87 2 12 2Z" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="9" r="3" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Pickup Address
                    </label>
                    <input type="text" name="pickup_address" class="form-control" value="{{ $booking->pickup_address ?? '' }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C8.13 2 5 5.13 5 9C5 13.17 12 22 12 22C12 22 19 13.17 19 9C19 5.13 15.87 2 12 2Z" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="9" r="3" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 9L12 15" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Drop Location
                    </label>
                    <input type="text" name="drop_location" class="form-control" value="{{ $booking->drop_location ?? '' }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8V12L15 15" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round"/>
                        <circle cx="12" cy="12" r="9" stroke="#DC2626" stroke-width="1.5"/>
                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#DC2626" stroke-width="1.5"/>
                    </svg>
                    Status
                </label>
                <select name="status" class="form-select" required>
                    <option value="pending" {{ ($booking->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ ($booking->status ?? '') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="in_transit" {{ ($booking->status ?? '') == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="delivered" {{ ($booking->status ?? '') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ ($booking->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-red">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 6L18 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn btn-green">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 14.66V20C20 21.1 19.1 22 18 22H4C2.9 22 2 21.1 2 20V4C2 2.9 2.9 2 4 2H14" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 2L22 6L12 16H8V12L18 2Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Update Booking
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script nonce="{{ $csp_nonce }}">
    // Preserve original user auto-fill functionality
    const users = @json($users);

    document.getElementById('user_id').addEventListener('change', function() {
        const userId = this.value;
        if (userId) {
            const user = users.find(u => u.id == userId);
            if (user) {
                document.getElementById('receiver_name').value = user.first_name + ' ' + user.last_name;
                document.getElementById('receiver_phone').value = user.mobile_number;
            }
        }
    });
</script>
@endpush
@endsection

