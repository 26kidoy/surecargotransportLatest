@extends('admin.layouts.app')

@section('title', 'Edit Truck')
@section('page-title', 'Edit Truck')

@section('content')
<style nonce="{{ $csp_nonce }}">
  /* ============================================================
   TRUCK UPDATE FORM - DEEPSEEK-STYLE RESPONSIVE STYLES
   White & Violet Theme
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-dark: #4a148c;
    --violet-light: #d1c4e9;
    --violet-bg-light: #f3f0f7;
    --violet-bg-lighter: #e8e0f0;
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
   FORM CONTAINER
   ============================================================ */
.truck-form-container {
    background: var(--white);
    border-radius: 2rem;
    box-shadow: 0 1.5rem 3rem var(--violet-shadow);
    padding: var(--sp-xxl);
    border-left: 8px solid var(--violet-primary);
    border-right: 8px solid #9c27b0;
    transition: all 0.3s ease;
}

.truck-form-container:hover {
    box-shadow: 0 2rem 4rem var(--violet-shadow-hover);
    transform: translateY(-3px);
}

/* ============================================================
   GLOBAL FONT SIZING - DeepSeek Style
   ============================================================ */
.truck-form-container,
.truck-form-container label,
.truck-form-container input,
.truck-form-container select,
.truck-form-container button,
.truck-form-container .btn,
.truck-form-container small,
.truck-form-container .form-text,
.truck-form-container .invalid-feedback,
.truck-form-container .form-label {
    font-size: var(--font-base) !important;
    font-weight: 400 !important;
}

/* ============================================================
   FORM CONTROLS
   ============================================================ */
.truck-form-container .form-control,
.truck-form-container .form-select {
    font-size: var(--font-base) !important;
    font-weight: 400;
    padding: var(--sp-sm) var(--sp-md);
    border-radius: 1.5rem;
    border: 2px solid var(--violet-light);
    background: var(--white) !important;
    color: var(--text-dark) !important;
    transition: all 0.25s;
    min-height: 44px;
}

.truck-form-container .form-control:focus,
.truck-form-container .form-select:focus {
    border-color: var(--violet-primary);
    box-shadow: 0 0 0 0.3rem var(--violet-shadow-focus);
    transform: scale(1.01);
    outline: none;
}

.truck-form-container .form-control::placeholder {
    font-weight: 400;
    color: #a0a0b0;
}

/* ============================================================
   ERROR STYLING WITH SHAKE ANIMATION
   ============================================================ */
.truck-form-container .is-invalid {
    border-color: var(--violet-primary) !important;
    animation: shakeError 0.4s ease-in-out;
}

@keyframes shakeError {
    0% { transform: translateX(0); }
    25% { transform: translateX(-6px); }
    50% { transform: translateX(6px); }
    75% { transform: translateX(-3px); }
    100% { transform: translateX(0); }
}

.invalid-feedback {
    color: var(--violet-primary) !important;
    font-size: var(--font-sm) !important;
    font-weight: 500;
    margin-top: var(--sp-xs);
}

/* ============================================================
   LABELS
   ============================================================ */
.form-label {
    font-weight: 600;
    color: var(--violet-dark);
    font-size: var(--font-base) !important;
    margin-bottom: var(--sp-xs);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.text-danger {
    color: var(--violet-primary) !important;
    font-size: var(--font-base) !important;
    font-weight: 600;
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-update {
    background: linear-gradient(135deg, var(--violet-primary) 0%, var(--violet-dark) 100%);
    border: none;
    border-radius: 3rem;
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    font-size: var(--font-base) !important;
    color: var(--white);
    transition: all 0.25s;
    box-shadow: 0 0.5rem 1rem rgba(123, 31, 162, 0.3);
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-update:hover {
    transform: translateY(-3px) scale(1.02);
    background: linear-gradient(135deg, #9c27b0 0%, var(--violet-primary) 100%);
    box-shadow: 0 1rem 2rem rgba(123, 31, 162, 0.4);
    color: var(--white);
}

.btn-secondary {
    background: var(--violet-bg-light);
    border: 1px solid var(--violet-light);
    border-radius: 3rem;
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
   STAGGERED FADE-IN ANIMATION
   ============================================================ */
.row .mb-3 {
    animation: fadeSlideUp 0.4s backwards;
}

@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Stagger delays */
.row .mb-3:nth-child(1) { animation-delay: 0.02s; }
.row .mb-3:nth-child(2) { animation-delay: 0.05s; }
.row .mb-3:nth-child(3) { animation-delay: 0.08s; }
.row .mb-3:nth-child(4) { animation-delay: 0.11s; }
.row .mb-3:nth-child(5) { animation-delay: 0.14s; }
.row .mb-3:nth-child(6) { animation-delay: 0.17s; }
.row .mb-3:nth-child(7) { animation-delay: 0.20s; }
.row .mb-3:nth-child(8) { animation-delay: 0.23s; }
.row .mb-3:nth-child(9) { animation-delay: 0.26s; }
.row .mb-3:nth-child(10) { animation-delay: 0.29s; }

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

    .truck-form-container {
        padding: var(--sp-lg);
        border-left-width: 6px;
        border-right-width: 6px;
    }

    .truck-form-container .form-control,
    .truck-form-container .form-select {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 40px;
        border-radius: 1.2rem;
    }

    .btn-update,
    .btn-secondary {
        padding: var(--sp-sm) var(--sp-lg);
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

    .truck-form-container {
        padding: var(--sp-md);
        border-left-width: 4px;
        border-right-width: 4px;
        border-radius: 1.5rem;
    }

    .truck-form-container .form-control,
    .truck-form-container .form-select {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
        border-radius: 1rem;
        border-width: 1.5px;
    }

    .form-label {
        font-size: var(--font-sm) !important;
        margin-bottom: var(--sp-xs);
    }

    .btn-update,
    .btn-secondary {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
        border-radius: 2rem;
    }

    .btn i {
        font-size: var(--font-base);
        margin-right: 6px;
    }

    .invalid-feedback {
        font-size: var(--font-xs) !important;
    }

    .text-danger {
        font-size: var(--font-sm) !important;
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

    .truck-form-container .text-muted {
        font-size: var(--font-xs) !important;
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

    .truck-form-container {
        padding: var(--sp-sm);
        border-left-width: 3px;
        border-right-width: 3px;
        border-radius: 1.2rem;
    }

    .truck-form-container .form-control,
    .truck-form-container .form-select {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 0.8rem;
        border-width: 1.5px;
    }

    .form-label {
        font-size: var(--font-xs) !important;
        margin-bottom: 0.1rem;
    }

    .btn-update,
    .btn-secondary {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 1.5rem;
    }

    .btn i {
        font-size: var(--font-sm);
        margin-right: 4px;
    }

    .invalid-feedback {
        font-size: 0.6rem !important;
    }

    .text-danger {
        font-size: var(--font-xs) !important;
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

    .truck-form-container {
        padding: var(--sp-xs);
        border-left-width: 2px;
        border-right-width: 2px;
        border-radius: 1rem;
    }

    .truck-form-container .form-control,
    .truck-form-container .form-select {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        border-radius: 0.6rem;
        border-width: 1px;
    }

    .form-label {
        font-size: 0.55rem !important;
    }

    .btn-update,
    .btn-secondary {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        border-radius: 1.2rem;
    }

    .btn i {
        font-size: 0.55rem;
    }

    .invalid-feedback {
        font-size: 0.5rem !important;
    }

    .text-danger {
        font-size: 0.55rem !important;
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

    .truck-form-container {
        padding: 0.05rem;
        border-radius: 0.8rem;
    }

    .truck-form-container .form-control,
    .truck-form-container .form-select {
        font-size: 0.45rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 26px;
        border-radius: 0.4rem;
    }

    .form-label {
        font-size: 0.45rem !important;
    }

    .btn-update,
    .btn-secondary {
        font-size: 0.45rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 26px;
        border-radius: 1rem;
    }

    .d-flex.gap-2 .btn {
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

<div class="truck-form-container">
    <form action="{{ route('admin.trucks.update', $truck->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Truck Name <span class="text-danger">*</span></label>
                <input type="text" name="truck_name" class="form-control @error('truck_name') is-invalid @enderror" value="{{ old('truck_name', $truck->truck_name) }}" required>
                @error('truck_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Truck Number <span class="text-danger">*</span></label>
                <input type="text" name="truck_number" class="form-control @error('truck_number') is-invalid @enderror" value="{{ old('truck_number', $truck->truck_number) }}" required>
                @error('truck_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Driver Name <span class="text-danger">*</span></label>
                <input type="text" name="driver_name" class="form-control @error('driver_name') is-invalid @enderror" value="{{ old('driver_name', $truck->driver_name) }}" required>
                @error('driver_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Driver Phone <span class="text-danger">*</span></label>
                <input type="text" name="driver_phone" class="form-control @error('driver_phone') is-invalid @enderror" value="{{ old('driver_phone', $truck->driver_phone) }}" required>
                @error('driver_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Truck Model <span class="text-danger">*</span></label>
                <input type="text" name="truck_model" class="form-control @error('truck_model') is-invalid @enderror" value="{{ old('truck_model', $truck->truck_model) }}" required>
                @error('truck_model')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Color <span class="text-danger">*</span></label>
                <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $truck->color) }}" required>
                @error('color')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Max Capacity (trays) <span class="text-danger">*</span></label>
                <input type="number" name="max_capacity" class="form-control @error('max_capacity') is-invalid @enderror" value="{{ old('max_capacity', $truck->max_capacity) }}" required>
                @error('max_capacity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Low Stock Threshold (trays)</label>
                <input type="number" name="low_stock_threshold" class="form-control @error('low_stock_threshold') is-invalid @enderror" value="{{ old('low_stock_threshold', $truck->low_stock_threshold) }}">
                @error('low_stock_threshold')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="available" {{ $truck->status == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ $truck->status == 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="maintenance" {{ $truck->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Current Image</label>
                @if($truck->image)
                    <div class="mb-3">
                        <img src="{{ asset($truck->image) }}" width="150" class="rounded shadow-sm" style="border: 2px solid #28a745;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small class="text-muted">Leave empty to keep current image. Max 2MB.</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mt-4 d-flex gap-3">
            <button type="submit" class="btn btn-update">
                <i class="fas fa-save me-2"></i>Update Truck
            </button>
            <a href="{{ route('admin.trucks.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Cancel
            </a>
        </div>
    </form>
</div>
@endsection
