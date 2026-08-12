@extends('admin.layouts.app')

@section('title', 'Add Booking')
@section('page-title', 'Add New Booking')

@push('styles')
<style nonce="{{ $csp_nonce }}">
/* ============================================================
   REPORTS/CHARTS PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   White & Violet Theme - Professional & Smooth
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-dark: #4a148c;
    --violet-light: #d1c4e9;
    --violet-bg-light: #f3f0f7;
    --violet-bg-lighter: #e8e0f0;
    --violet-bg-soft: #faf8ff;
    --violet-shadow: rgba(123, 31, 162, 0.1);
    --violet-shadow-hover: rgba(123, 31, 162, 0.15);
    --violet-shadow-focus: rgba(123, 31, 162, 0.2);
    --white: #ffffff;
    --text-dark: #2c2c3e;
    --text-muted: #6c6c80;

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
    box-shadow: 0 15px 35px var(--violet-shadow);
    animation: fadeSlideUp 0.6s ease-out;
}

@keyframes fadeSlideUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ============================================================
   GLOBAL FONT SIZING - DeepSeek Style
   ============================================================ */
body .chart-container,
.chart-container .form-label,
.chart-container .form-control,
.chart-container .btn,
.chart-container select,
.chart-container input,
.chart-container textarea,
.chart-container small,
.chart-container .text-muted,
.chart-container option,
.chart-container .form-text {
    font-size: var(--font-base) !important;
    line-height: 1.6;
    font-weight: 400;
}

/* ============================================================
   LABELS - Deep Violet
   ============================================================ */
.chart-container .form-label {
    font-weight: 600;
    color: var(--violet-dark);
    margin-bottom: var(--sp-xs);
    letter-spacing: -0.3px;
    display: block;
}

/* ============================================================
   INPUTS, SELECTS, TEXTAREA BASE
   ============================================================ */
.chart-container .form-control {
    background-color: var(--white);
    border: 2px solid var(--violet-light);
    border-radius: 16px;
    padding: var(--sp-sm) var(--sp-md);
    color: var(--text-dark);
    transition: all 0.25s ease-in-out;
    box-shadow: 0 1px 2px rgba(123, 31, 162, 0.02);
    min-height: 44px;
    font-weight: 400;
}

/* Focus interactive animation (violet glow) */
.chart-container .form-control:focus {
    border-color: var(--violet-primary);
    outline: none;
    box-shadow: 0 0 0 4px var(--violet-shadow-focus), 0 0 0 2px #9c27b0 inset;
    transform: scale(1.01);
    background-color: var(--violet-bg-soft);
}

.chart-container .form-control::placeholder {
    color: #a0a0b0;
    font-weight: 400;
}

/* Select custom arrow + hover - Violet */
.chart-container select.form-control {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%237b1fa2' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'></polyline></svg>");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1.8rem;
    padding-right: 3.5rem;
}

/* Textarea hover + transition */
.chart-container textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

/* Disabled readonly input */
.chart-container input:disabled,
.chart-container input[readonly] {
    background-color: var(--violet-bg-soft);
    border-color: var(--violet-light);
    color: #5e503f;
    cursor: not-allowed;
    opacity: 0.9;
}

/* ============================================================
   BUTTONS - Violet gradient primary / Light Violet secondary
   ============================================================ */
.chart-container .btn {
    font-weight: 600;
    padding: var(--sp-sm) var(--sp-xl);
    border-radius: 60px;
    transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    border: none;
    letter-spacing: 0.3px;
    min-width: 140px;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
    font-size: var(--font-base) !important;
}

/* Primary button - Violet Gradient */
.chart-container .btn-danger {
    background: linear-gradient(105deg, var(--violet-primary), var(--violet-dark));
    box-shadow: 0 5px 12px rgba(123, 31, 162, 0.3);
    color: var(--white);
}

.chart-container .btn-danger:hover {
    background: linear-gradient(105deg, var(--violet-dark), #380e6b);
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 12px 22px rgba(123, 31, 162, 0.4);
    color: var(--white);
}

.chart-container .btn-danger:active {
    transform: translateY(2px);
}

/* Secondary button - Light Violet */
.chart-container .btn-secondary {
    background: var(--violet-bg-light);
    border: 1px solid var(--violet-light);
    color: var(--text-dark);
    box-shadow: 0 5px 12px rgba(123, 31, 162, 0.08);
}

.chart-container .btn-secondary:hover {
    background: var(--violet-bg-lighter);
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 12px 22px rgba(123, 31, 162, 0.15);
    color: var(--text-dark);
}

.chart-container .btn-secondary:active {
    transform: translateY(2px);
}

/* ============================================================
   SMALL HELPER TEXT - Violet theme
   ============================================================ */
.chart-container small.text-muted {
    display: inline-block;
    margin-top: var(--sp-xs);
    color: var(--text-muted) !important;
    font-weight: 400;
    letter-spacing: -0.2px;
    background: var(--violet-bg-light);
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 40px;
    font-size: var(--font-sm) !important;
}

/* ============================================================
   SPACING & LAYOUT
   ============================================================ */
.chart-container .row {
    margin-bottom: var(--sp-sm);
}

.chart-container .mb-3 {
    margin-bottom: var(--sp-lg) !important;
}

/* Divider and custom accents - Violet */
.chart-container hr {
    border-top: 2px dashed var(--violet-light);
    margin: var(--sp-lg) 0;
}

/* Interactive hover for all form groups */
.chart-container .form-group {
    transition: all 0.2s ease;
}

/* Button group spacing */
.chart-container .d-flex {
    gap: var(--sp-lg);
    margin-top: var(--sp-xl);
    flex-wrap: wrap;
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
        border-radius: 18px;
    }

    .chart-container .form-control {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 40px;
        border-radius: 14px;
    }

    .chart-container .btn {
        padding: var(--sp-sm) var(--sp-lg);
        min-height: 40px;
        min-width: 120px;
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

    .chart-container {
        padding: var(--sp-md);
        border-radius: 16px;
    }

    .chart-container .form-label {
        font-size: var(--font-sm) !important;
        margin-bottom: var(--sp-xs);
    }

    .chart-container .form-control {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
        border-radius: 12px;
        border-width: 1.5px;
    }

    .chart-container select.form-control {
        background-size: 1.5rem;
        padding-right: 3rem;
    }

    .chart-container textarea.form-control {
        min-height: 80px;
    }

    .chart-container .btn {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
        min-width: 100px;
        border-radius: 40px;
    }

    .chart-container small.text-muted {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
    }

    .chart-container .mb-3 {
        margin-bottom: var(--sp-md) !important;
    }

    .chart-container .d-flex {
        gap: var(--sp-sm);
        margin-top: var(--sp-md);
        flex-wrap: wrap;
    }

    .chart-container .d-flex .btn {
        flex: 1;
        min-width: 0;
        width: 100%;
    }

    .chart-container .row {
        margin-bottom: var(--sp-xs);
    }

    .chart-container hr {
        margin: var(--sp-md) 0;
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

    .chart-container .form-label {
        font-size: var(--font-xs) !important;
        margin-bottom: 0.1rem;
    }

    .chart-container .form-control {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 10px;
        border-width: 1px;
    }

    .chart-container select.form-control {
        background-size: 1.2rem;
        padding-right: 2.5rem;
        background-position: right 0.7rem center;
    }

    .chart-container textarea.form-control {
        min-height: 60px;
    }

    .chart-container .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        min-width: 80px;
        border-radius: 30px;
    }

    .chart-container small.text-muted {
        font-size: 0.6rem !important;
        padding: 0.1rem var(--sp-xs);
    }

    .chart-container .mb-3 {
        margin-bottom: var(--sp-sm) !important;
    }

    .chart-container .d-flex {
        gap: var(--sp-xs);
        margin-top: var(--sp-sm);
    }

    .chart-container .d-flex .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .chart-container hr {
        margin: var(--sp-sm) 0;
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

    .chart-container .form-label {
        font-size: 0.55rem !important;
        margin-bottom: 0.05rem;
    }

    .chart-container .form-control {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        border-radius: 8px;
    }

    .chart-container select.form-control {
        background-size: 1rem;
        padding-right: 2rem;
        background-position: right 0.5rem center;
    }

    .chart-container textarea.form-control {
        min-height: 50px;
    }

    .chart-container .btn {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        min-width: 70px;
        border-radius: 24px;
    }

    .chart-container small.text-muted {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
    }

    .chart-container .d-flex .btn {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 28px;
    }

    .chart-container .mb-3 {
        margin-bottom: var(--sp-xs) !important;
    }

    .chart-container hr {
        margin: var(--sp-xs) 0;
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

    .chart-container {
        padding: 0.05rem;
        border-radius: 8px;
    }

    .chart-container .form-label {
        font-size: 0.45rem !important;
    }

    .chart-container .form-control {
        font-size: 0.45rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 26px;
        border-radius: 6px;
    }

    .chart-container .btn {
        font-size: 0.45rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 26px;
        min-width: 60px;
        border-radius: 20px;
    }

    .chart-container small.text-muted {
        font-size: 0.4rem !important;
    }

    .chart-container .d-flex .btn {
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

@section('content')
<div class="chart-container">
    <form method="POST" action="{{ route('admin.bookings.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">User (Optional)</label>
                <select name="user_id" class="form-control">
                    <option value="">Select User (Optional)</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} - {{ $user->mobile_number }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Selecting a user will auto-fill receiver info</small>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Truck <span class="text-danger">*</span></label>
                <select name="truck_id" class="form-control" required>
                    <option value="">Select Truck</option>
                    @foreach($trucks as $truck)
                        <option value="{{ $truck->id }}">{{ $truck->truck_number }} - {{ $truck->truck_name }} ({{ $truck->driver_name }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Receiver Name <span class="text-danger">*</span></label>
                <input type="text" name="receiver_name" id="receiver_name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Receiver Phone <span class="text-danger">*</span></label>
                <input type="tel" name="receiver_phone" id="receiver_phone" class="form-control" placeholder="09XXXXXXXXX" maxlength="11" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Quantity (Trays) <span class="text-danger">*</span></label>
                <input type="number" name="quantity" class="form-control" min="1" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Product Type</label>
                <input type="text" class="form-control" value="Egg" readonly disabled>
                <input type="hidden" name="product_type" value="egg">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Pickup Address <span class="text-danger">*</span></label>
                <input type="text" name="pickup_address" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Drop Location <span class="text-danger">*</span></label>
                <input type="text" name="drop_location" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes (Optional)</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Any special instructions..."></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="in_transit">In Transit</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-danger">Create Booking</button>
        </div>
    </form>
</div>

@push('scripts')
<script nonce="{{ $csp_nonce }}">
    // Auto-fill receiver info when user is selected (preserved & interactive)
    document.querySelector('select[name="user_id"]').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            let fullText = selectedOption.text;
            // Split using ' - ' pattern: "FirstName LastName - 09XXXXXXXXX"
            let parts = fullText.split(' - ');
            let userName = parts[0] || '';
            let userPhone = parts[1] || '';
            document.getElementById('receiver_name').value = userName.trim();
            document.getElementById('receiver_phone').value = userPhone.trim();
        } else {
            document.getElementById('receiver_name').value = '';
            document.getElementById('receiver_phone').value = '';
        }
    });
</script>
@endpush
@endsection

