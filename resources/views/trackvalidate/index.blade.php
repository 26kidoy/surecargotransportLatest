@extends('layouts.app')

@section('title', 'Track & Validate - SureCargo')

@section('content')
<div class="track-validate-container">
    <div class="container py-5">
        <!-- Hero Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-3">Track Your Shipment</h1>
            <p class="lead text-muted fs-3">Enter your booking reference to track your cargo in real-time</p>
        </div>

        <!-- Search Card -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="track-card shadow-lg rounded-4 border-0 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <label class="form-label fw-bold fs-3 mb-3">
                                <i class="fas fa-truck me-2 text-primary"></i>
                                Booking Reference
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0 rounded-start-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 21l-4.35-4.35M19 11a8 8 0 1 0-16 0 8 8 0 0 0 16 0z" stroke="#2563EB" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <input type="text"
                                       class="form-control border-start-0 fs-3 py-4 rounded-end-4"
                                       id="bookingReference"
                                       placeholder="Enter your booking reference (e.g., SC-2024-001)"
                                       autocomplete="off">
                            </div>
                            <div class="form-text text-muted fs-5 mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Enter the booking reference you received via SMS
                            </div>
                        </div>

                        <div class="d-grid gap-3">
                            <button class="btn btn-primary btn-lg py-4 fs-2 fw-bold rounded-4" id="trackButton">
                                <i class="fas fa-search me-2"></i>
                                Track Shipment
                            </button>
                            <button class="btn btn-outline-secondary btn-lg py-3 fs-4 rounded-4" id="clearButton">
                                <i class="fas fa-eraser me-2"></i>
                                Clear
                            </button>
                        </div>

                        <!-- Loading Indicator -->
                        <div id="loadingIndicator" class="text-center mt-4" style="display: none;">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 fs-4 text-muted">Verifying booking reference...</p>
                        </div>

                        <!-- Result Alert -->
                        <div id="resultAlert" class="mt-4" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style nonce="{{ $csp_nonce }}">
/* ============================================================
   TRACK & VALIDATE - CLEAN VERSION
   ============================================================ */

:root {
    --primary-color: #2563EB;
    --primary-dark: #1D4ED8;
    --text-dark: #111827;
    --text-muted: #6B7280;
    --border-light: #E5E7EB;

    --font-xs: 0.75rem;
    --font-sm: 0.875rem;
    --font-base: 1rem;
    --font-md: 1.125rem;
    --font-lg: 1.25rem;
    --font-xl: 1.5rem;
    --font-xxl: 1.75rem;
    --font-xxxl: 2.25rem;
    --font-xxxxl: 3rem;

    --sp-xs: 0.25rem;
    --sp-sm: 0.5rem;
    --sp-md: 1rem;
    --sp-lg: 1.5rem;
    --sp-xl: 2rem;
    --sp-xxl: 3rem;
}

/* ============================================================
   GLOBAL STYLES
   ============================================================ */
html {
    font-size: 16px;
    -webkit-text-size-adjust: 100%;
}

body {
    font-size: var(--font-base);
    font-weight: 400;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: var(--text-dark);
}
.text-center {
    margin-top: -50px;
    
}

/* ============================================================
   CONTAINER
   ============================================================ */
.track-validate-container {
    min-height: calc(100vh - 200px);
    padding: var(--sp-lg);
}

/* ============================================================
   CARDS
   ============================================================ */
.track-card {
    background: white;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    animation: fadeInUp 0.5s ease-out;
    border-radius: 1.25rem;
    border: 1px solid var(--border-light);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    margin-top: -30px;
}

.track-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
}

.track-card .card-body {
    padding: var(--sp-xl) !important;
}

/* ============================================================
   ANIMATIONS
   ============================================================ */
.track-icon {
    animation: pulse 2s infinite;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* ============================================================
   FORM ELEMENTS
   ============================================================ */
.form-control {
    font-size: var(--font-base);
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    border: 1.5px solid var(--border-light);
    transition: all 0.3s ease;
    min-height: 48px;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
}

.form-control::placeholder {
    color: var(--text-muted);
    font-weight: 400;
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-primary {
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
    border: none;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: var(--font-base);
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    min-height: 48px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
    background: linear-gradient(135deg, #1D4ED8 0%, #1E3A8A 100%);
}

.btn-primary:active {
    transform: translateY(0);
}

.btn-primary i {
    margin-right: 0.5rem;
}

.btn-lg {
    font-size: var(--font-base);
    padding: 0.75rem 2rem;
    min-height: 48px;
}

/* ============================================================
   TYPOGRAPHY
   ============================================================ */
h1.display-4 {
    font-size: var(--font-xxxxl) !important;
    font-weight: 800 !important;
    letter-spacing: -0.02em !important;
    line-height: 1.1 !important;
    margin-bottom: var(--sp-md) !important;
}

.lead.fs-3 {
    font-size: var(--font-lg) !important;
    font-weight: 400 !important;
    color: var(--text-muted) !important;
    line-height: 1.6 !important;
}

.fs-2 {
    font-size: var(--font-xl) !important;
    font-weight: 700 !important;
}

.fs-3 {
    font-size: var(--font-lg) !important;
    font-weight: 600 !important;
}

.fs-4 {
    font-size: var(--font-md) !important;
    font-weight: 500 !important;
}

.fs-5 {
    font-size: var(--font-base) !important;
    font-weight: 400 !important;
}

/* ============================================================
   ALERTS
   ============================================================ */
.alert {
    animation: slideInRight 0.4s ease-out;
    border-radius: 0.75rem;
    font-size: var(--font-base);
    padding: var(--sp-md) var(--sp-lg);
    border: none;
    border-left: 4px solid;
}

.alert-success {
    background: #F0FDF4;
    border-left-color: #22C55E;
    color: #166534;
}

.alert-danger {
    background: #FEF2F2;
    border-left-color: #EF4444;
    color: #991B1B;
}

.alert-warning {
    background: #FFFBEB;
    border-left-color: #F59E0B;
    color: #92400E;
}

.alert-info {
    background: #EFF6FF;
    border-left-color: #3B82F6;
    color: #1E40AF;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */

/* --- Tablets (769px - 1024px) --- */
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
        --font-xxxxl: 2.5rem;

        --sp-xs: 0.25rem;
        --sp-sm: 0.5rem;
        --sp-md: 0.9rem;
        --sp-lg: 1.3rem;
        --sp-xl: 1.7rem;
        --sp-xxl: 2.5rem;
    }

    .track-validate-container {
        padding: var(--sp-md);
    }

    .track-card .card-body {
        padding: var(--sp-lg) !important;
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
        --font-xxxxl: 2rem;

        --sp-xs: 0.2rem;
        --sp-sm: 0.4rem;
        --sp-md: 0.8rem;
        --sp-lg: 1.2rem;
        --sp-xl: 1.5rem;
        --sp-xxl: 2rem;
    }

    .track-validate-container {
        padding: var(--sp-sm);
        min-height: calc(100vh - 150px);
    }

    .track-card {
        border-radius: 1rem;
    }

    .track-card .card-body {
        padding: var(--sp-md) !important;
    }

    h1.display-4 {
        font-size: var(--font-xxxl) !important;
    }

    .lead.fs-3 {
        font-size: var(--font-base) !important;
    }

    .fs-2 {
        font-size: var(--font-lg) !important;
    }

    .fs-3 {
        font-size: var(--font-md) !important;
    }

    .fs-4 {
        font-size: var(--font-base) !important;
    }

    .fs-5 {
        font-size: var(--font-sm) !important;
    }

    .form-control {
        font-size: var(--font-sm);
        padding: 0.6rem 0.8rem;
        min-height: 42px;
        border-radius: 0.6rem;
    }

    .btn-primary {
        font-size: var(--font-sm);
        padding: 0.6rem 1.2rem;
        min-height: 42px;
        border-radius: 0.6rem;
    }

    .btn-lg {
        font-size: var(--font-sm);
        padding: 0.6rem 1.2rem;
        min-height: 42px;
    }

    .alert {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        border-radius: 0.6rem;
    }
}

/* --- Small Phones (≤ 480px) --- */
@media (max-width: 480px) {
    :root {
        --font-xs: 0.65rem;
        --font-sm: 0.75rem;
        --font-base: 0.85rem;
        --font-md: 0.95rem;
        --font-lg: 1.05rem;
        --font-xl: 1.15rem;
        --font-xxl: 1.3rem;
        --font-xxxl: 1.5rem;
        --font-xxxxl: 1.8rem;

        --sp-xs: 0.15rem;
        --sp-sm: 0.3rem;
        --sp-md: 0.6rem;
        --sp-lg: 1rem;
        --sp-xl: 1.2rem;
        --sp-xxl: 1.5rem;
    }

    .track-validate-container {
        padding: var(--sp-xs);
    }

    .track-card {
        border-radius: 0.75rem;
        padding: var(--sp-md);
    }

    .track-card .card-body {
        padding: var(--sp-sm) !important;
    }

    h1.display-4 {
        font-size: var(--font-xxl) !important;
    }

    .lead.fs-3 {
        font-size: var(--font-sm) !important;
    }

    .fs-2 {
        font-size: var(--font-md) !important;
    }

    .fs-3 {
        font-size: var(--font-base) !important;
    }

    .fs-4 {
        font-size: var(--font-sm) !important;
    }

    .fs-5 {
        font-size: var(--font-xs) !important;
    }

    .form-control {
        font-size: var(--font-xs);
        padding: 0.4rem 0.6rem;
        min-height: 36px;
        border-radius: 0.5rem;
        border-width: 1px;
    }

    .btn-primary {
        font-size: var(--font-xs);
        padding: 0.4rem 0.8rem;
        min-height: 36px;
        border-radius: 0.5rem;
    }

    .btn-lg {
        font-size: var(--font-xs);
        padding: 0.4rem 0.8rem;
        min-height: 36px;
    }

    .alert {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 0.5rem;
        border-left-width: 3px;
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
        --font-xxxxl: 1.6rem;

        --sp-xs: 0.1rem;
        --sp-sm: 0.25rem;
        --sp-md: 0.5rem;
        --sp-lg: 0.8rem;
        --sp-xl: 1rem;
        --sp-xxl: 1.2rem;
    }

    .track-validate-container {
        padding: 0.1rem;
    }

    .track-card {
        border-radius: 0.5rem;
    }

    .track-card .card-body {
        padding: var(--sp-xs) !important;
    }

    h1.display-4 {
        font-size: var(--font-xl) !important;
    }

    .lead.fs-3 {
        font-size: var(--font-xs) !important;
    }

    .fs-2 {
        font-size: var(--font-sm) !important;
    }

    .fs-3 {
        font-size: var(--font-xs) !important;
    }

    .fs-4 {
        font-size: var(--font-xs) !important;
    }

    .fs-5 {
        font-size: 0.55rem !important;
    }

    .form-control {
        font-size: 0.6rem;
        padding: 0.3rem 0.4rem;
        min-height: 32px;
        border-radius: 0.4rem;
    }

    .btn-primary {
        font-size: 0.6rem;
        padding: 0.3rem 0.6rem;
        min-height: 32px;
        border-radius: 0.4rem;
    }

    .btn-lg {
        font-size: 0.6rem;
        padding: 0.3rem 0.6rem;
        min-height: 32px;
    }

    .alert {
        font-size: 0.6rem;
        padding: 0.2rem 0.4rem;
        border-radius: 0.4rem;
        border-left-width: 2px;
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
        --font-xxxxl: 1.4rem;

        --sp-xs: 0.05rem;
        --sp-sm: 0.2rem;
        --sp-md: 0.4rem;
        --sp-lg: 0.6rem;
        --sp-xl: 0.8rem;
        --sp-xxl: 1rem;
    }

    h1.display-4 {
        font-size: var(--font-lg) !important;
    }

    .lead.fs-3 {
        font-size: 0.55rem !important;
    }

    .form-control {
        font-size: 0.5rem;
        padding: 0.2rem 0.3rem;
        min-height: 28px;
    }

    .btn-primary {
        font-size: 0.5rem;
        padding: 0.2rem 0.4rem;
        min-height: 28px;
    }

    .btn-lg {
        font-size: 0.5rem;
        padding: 0.2rem 0.4rem;
        min-height: 28px;
    }

    .alert {
        font-size: 0.5rem;
        padding: 0.15rem 0.3rem;
    }
}
</style>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script nonce="{{ $csp_nonce }}">
$(document).ready(function() {
    const $bookingRef = $('#bookingReference');
    const $trackButton = $('#trackButton');
    const $clearButton = $('#clearButton');
    const $loadingIndicator = $('#loadingIndicator');
    const $resultAlert = $('#resultAlert');

    // Track button click handler
    $trackButton.on('click', function() {
        const bookingReference = $bookingRef.val().trim();

        // Validate input
        if (!bookingReference) {
            showAlert('Please enter a booking reference number.', 'warning');
            $bookingRef.focus();
            return;
        }

        // Show loading, hide previous alerts
        $loadingIndicator.show();
        $resultAlert.hide();
        $trackButton.prop('disabled', true);

        // Make AJAX request
        $.ajax({
            url: '{{ route("track-validate.check") }}',
            method: 'POST',
            data: {
                booking_reference: bookingReference,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $loadingIndicator.hide();
                $trackButton.prop('disabled', false);

                if (response.success) {
                    if (response.data.can_track && response.data.redirect_url) {
                        // Show success message
                        showAlert(response.data.message, 'success');

                        // Redirect after 1.5 seconds
                        setTimeout(function() {
                            window.location.href = response.data.redirect_url;
                        }, 1500);
                    } else {
                        // Show status message but no redirect
                        showAlert(response.data.message, 'warning');
                    }
                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function(xhr) {
                $loadingIndicator.hide();
                $trackButton.prop('disabled', false);

                let errorMessage = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 404) {
                    errorMessage = 'Booking reference not found. Please check and try again.';
                } else if (xhr.status === 422) {
                    errorMessage = 'Invalid booking reference format.';
                } else if (xhr.status === 403) {
                    errorMessage = 'You do not have permission to track this booking.';
                }

                showAlert(errorMessage, 'danger');
            }
        });
    });

    // Clear button handler
    $clearButton.on('click', function() {
        $bookingRef.val('');
        $resultAlert.hide();
        $bookingRef.focus();
    });

    // Enter key press handler
    $bookingRef.on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            $trackButton.click();
        }
    });

    // Auto-focus on page load
    $bookingRef.focus();

    // Helper function to show alerts
    function showAlert(message, type) {
        const alertClass = type === 'success' ? 'alert-success' :
                          (type === 'danger' ? 'alert-danger' :
                          (type === 'warning' ? 'alert-warning' : 'alert-info'));

        const icon = type === 'success' ? 'fa-check-circle' :
                    (type === 'danger' ? 'fa-exclamation-circle' :
                    (type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'));

        const title = type.charAt(0).toUpperCase() + type.slice(1);

        $resultAlert.html(`
            <div class="alert ${alertClass} alert-dismissible fade show rounded-4" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas ${icon} fs-2 me-3 mt-1"></i>
                    <div class="flex-grow-1">
                        <strong class="fs-4">${title}!</strong>
                        <p class="mb-0 fs-5 mt-1">${message}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        `);
        $resultAlert.show();

        // Auto-hide after 8 seconds for success messages
        if (type === 'success') {
            setTimeout(function() {
                $resultAlert.fadeOut(500);
            }, 8000);
        }
    }
});
</script>
@endpush
