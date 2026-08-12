@extends('layouts.app')

@section('title', 'Damage Requests')

@section('content')
<div class="p-3 p-md-4 p-lg-5">

    <div class="row g-3 g-lg-4">
        <!-- Submit Damage Request Form -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 bg-white sticky-top-custom">

                <div class="card-body p-3 p-md-4 p-lg-5 pt-0">
                    <form id="damageRequestForm" enctype="multipart/form-data">
                        @csrf
                        <!-- Booking Dropdown -->
                        <div class="mb-3 mb-md-4">
                            <label for="booking_id" class="form-label fw-bold mb-2">
                                <svg class="me-2 text-primary icon-inline" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                Booking Reference *
                            </label>
                            <select class="form-select form-select-lg" id="booking_id" name="booking_id" required>
                                <option value="">-- Select your booking --</option>
                                @foreach($bookings as $booking)
                                    <option value="{{ $booking->id }}">
                                        {{ e($booking->booking_reference) }} ({{ $booking->quantity }} trays, ₱{{ number_format($booking->total_amount, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text text-muted mt-2">
                                Only <strong>delivered</strong> bookings without an existing damage request are shown.
                            </div>
                            <div id="noBookingsWarning" class="alert alert-warning mt-2 d-none">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-inline">
                                    <path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                All delivered bookings already have damage requests.
                            </div>
                        </div>

                        <!-- Egg Quantity -->
                        <div class="mb-3 mb-md-4">
                            <label for="egg_quantity" class="form-label fw-bold mb-2">
                                <svg class="me-2 text-warning icon-inline" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C8.13 2 5 5.13 5 9C5 13.17 12 22 12 22C12 22 19 13.17 19 9C19 5.13 15.87 2 12 2Z" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="12" cy="9" r="3" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                Number of Damaged Eggs/Trays *
                            </label>
                            <input type="number" class="form-control form-control-lg" id="egg_quantity" name="egg_quantity" placeholder="Enter quantity" min="1" required>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3 mb-md-4">
                            <label for="damage_image" class="form-label fw-bold mb-2">
                                <svg class="me-2 text-danger icon-inline" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23 19C23 19.5304 22.7893 20.0391 22.4142 20.4142C22.0391 20.7893 21.5304 21 21 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V8C1 7.46957 1.21071 6.96086 1.58579 6.58579C1.96086 6.21071 2.46957 6 3 6H7L9 3H15L17 6H21C21.5304 6 22.0391 6.21071 22.4142 6.58579C22.7893 6.96086 23 7.46957 23 8V19Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <circle cx="12" cy="13" r="4" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                Damage Evidence * (Max 2MB)
                            </label>
                            <div class="upload-area border-2 border-dashed rounded-4 p-3 p-md-4 text-center bg-light" id="uploadArea">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-2 mb-md-3 text-muted upload-icon">
                                    <path d="M17 8V4H7V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M12 19V12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M9 15L12 12L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M4 14V19C4 19.5304 4.21071 20.0391 4.58579 20.4142C4.96086 20.7893 5.46957 21 6 21H18C18.5304 21 19.0391 20.7893 19.4142 20.4142C19.7893 20.0391 20 19.5304 20 20V14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <p class="mb-1">Click or drag image here</p>
                                <p class="text-muted small">JPG, PNG or GIF (Max 2MB)</p>
                                <input type="file" class="d-none" id="damage_image" name="damage_image" accept="image/jpeg,image/png,image/jpg,image/gif" required>
                            </div>
                            <div id="imagePreviewContainer" class="mt-3 text-center d-none">
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded-3 shadow-sm preview-image">
                                <button type="button" id="removeImageBtn" class="btn btn-sm btn-outline-danger mt-2">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-inline">
                                        <path d="M3 6H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6" stroke="currentColor" stroke-width="1.5"/>
                                    </svg>
                                    Remove
                                </button>
                            </div>
                            <div id="imageError" class="text-danger mt-2 d-none"></div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="mb-3 mb-md-4">
                            <label for="notes" class="form-label fw-bold mb-2">
                                <svg class="me-2 text-info icon-inline" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 12V18H4V12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M12 2V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M8 4L12 2L16 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M3 12H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <circle cx="7" cy="16" r="1" fill="currentColor"/>
                                    <circle cx="17" cy="16" r="1" fill="currentColor"/>
                                </svg>
                                Additional Notes (Optional)
                            </label>
                            <textarea class="form-control form-control-lg" id="notes" name="notes" rows="3" placeholder="Describe the damage condition..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg py-2 py-md-3 fw-bold" id="submitBtn">
                                <svg class="me-2 icon-inline" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 2L11 13" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                Submit Damage Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Existing Damage Requests List -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg rounded-4 bg-white">
                <div class="card-header bg-white border-0 p-3 p-md-4 p-lg-5 pb-0 d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h3 class="fw-bold text-dark mb-0">
                        <svg class="me-2 text-primary icon-inline" width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 6H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M8 12H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M8 18H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M3 6H3.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M3 12H3.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M3 18H3.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        My Damage Requests
                    </h3>
                    <button class="btn btn-outline-secondary btn-lg px-3 px-md-4 py-2" id="refreshRequestsBtn">
                        <svg class="me-2 icon-inline" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23 4V10H17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M1 20V14H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M3.51 9C5.73 5.46 9.62 3 14 3C19.24 3 23.34 6.71 23.86 11.81" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M20.49 15C18.27 18.54 14.38 21 10 21C4.76 21 0.66 17.29 0.14 12.19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Refresh
                    </button>
                </div>
                <div class="card-body p-3 p-md-4 p-lg-5">
                    <div id="requestsLoading" class="text-center py-5">
                        <div class="spinner-border text-primary spinner-custom" role="status"></div>
                        <p class="mt-3 fw-semibold">Loading your requests...</p>
                    </div>
                    <div id="requestsList" class="d-none"></div>
                    <div id="emptyRequests" class="text-center py-5 text-muted d-none">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3">
                            <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        <p class="fw-semibold">No damage requests found</p>
                        <p>Submit your first request using the form.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style nonce="{{ $csp_nonce }}">

/* ===== Custom Classes for CSP Compliance ===== */
.sticky-top-custom {
    position: sticky !important;
    top: 20px !important;
    z-index: 1 !important;
}

.icon-inline {
    display: inline-block !important;
    vertical-align: middle !important;
}

.icon-mr-1 {
    margin-right: 6px !important;
}

.preview-image {
    max-height: 180px !important;
    width: auto !important;
}

.upload-area {
    border-color: #dee2e6 !important;
    cursor: pointer !important;
    transition: border-color 0.2s, background-color 0.2s !important;
}

.upload-area.drag-over {
    border-color: #0d6efd !important;
    background-color: #e7f1ff !important;
}

.spinner-custom {
    width: 3rem !important;
    height: 3rem !important;
}

/* ============================================================
   DAMAGE REQUEST CARD – PERFECT SQUARE IMAGE
   ============================================================ */
.request-card {
    overflow: hidden !important;
}

/* The image wrapper – force square aspect ratio */
.request-card .card-body a {
    display: block !important;
    width: 100% !important;
    aspect-ratio: 1 / 1 !important;  /* makes it a perfect square */
    overflow: hidden !important;
    background: #f1f5f9 !important;  /* fallback background */
}

/* The image itself – fill the square completely */
.request-card .card-img-top-custom {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;   /* covers the square without distortion */
    display: block !important;
}

/* ===== Status Badges (used in rendered list) ===== */
.status-badge {
    display: inline-block !important;
    padding: 0.35rem 0.9rem !important;
    border-radius: 50px !important;
    font-weight: 600 !important;
    font-size: 1.25rem !important;
    text-transform: capitalize !important;
    letter-spacing: 0.02em !important;
    background-color: #f8f9fa !important;
    color: #212529 !important;
}

.status-pending {
    background-color: #fff3cd !important;
    color: #856404 !important;
}

.status-approved {
    background-color: #d4edda !important;
    color: #155724 !important;
}

.status-rejected {
    background-color: #f8d7da !important;
    color: #721c24 !important;
}

.admin-reply-red {
    font-size: 1.25rem !important;
    color: #721c24 !important;
    background-color: #f8d7da !important;
    padding: 0.5rem 0.75rem !important;
    border-radius: 0.5rem !important;
    border-left: 4px solid #dc3545 !important;
    margin-top: 0.5rem !important;
}

.form-alert-message {
    font-size: 1.5rem !important;
    padding: 0.75rem 1rem !important;
    border-radius: 0.5rem !important;
}

/* ============================================================
   RESPONSIVE FONT SIZES – white & blue theme, minimum 1.5rem on desktop
   ============================================================ */

/* Default (desktop and above) – minimum 1.5rem */
.status-badge {
    font-size: 1.5rem !important;
}
.admin-reply-red {
    font-size: 1.5rem !important;
}
.form-alert-message {
    font-size: 1.5rem !important;
}
/* The square image will scale with the card width, no max-height needed */

/* Tablets and small laptops (≤ 992px) – keep 1.5rem */
@media (max-width: 992px) {
    .status-badge {
        font-size: 1.5rem !important;
    }
    .admin-reply-red {
        font-size: 1.5rem !important;
    }
    .form-alert-message {
        font-size: 1.5rem !important;
    }
}

/* Mobile devices (≤ 768px) – reduce fonts for all elements */
@media (max-width: 768px) {
    /* Global text sizing */
    body, .card, .form-label, .form-text, .alert, .btn, .form-control, .upload-area p,
    .request-card .card-body, .admin-reply-red, .status-badge,
    .card-header, .card-body, .fw-bold, .text-muted, .small, label, input, select, textarea,
    .btn-lg, .form-select-lg, .form-control-lg, .p-3, .p-md-4, .p-lg-5 {
        font-size: 1.25rem !important;
    }
    /* Specific element overrides */
    .status-badge {
        font-size: 1.25rem !important;
        padding: 0.25rem 0.75rem !important;
    }
    .admin-reply-red {
        font-size: 1.25rem !important;
        padding: 0.4rem 0.6rem !important;
    }
    .form-alert-message {
        font-size: 1.25rem !important;
        padding: 0.6rem 0.8rem !important;
    }
    /* Inputs and buttons */
    .form-control, .form-select, .btn, .btn-lg, .form-control-lg, .form-select-lg {
        font-size: 1.25rem !important;
        padding: 0.5rem 0.75rem !important;
    }
    .btn-lg {
        padding: 0.5rem 1rem !important;
    }
    .form-label {
        font-size: 1.25rem !important;
    }
    /* Cards and containers */
    .card-body, .card-header {
        padding: 1rem !important;
    }
    .p-3, .p-md-4, .p-lg-5 {
        padding: 0.75rem !important;
    }
    .gap-3 {
        gap: 0.75rem !important;
    }
    .mb-3, .mb-md-4 {
        margin-bottom: 0.75rem !important;
    }
    .upload-area {
        padding: 1rem !important;
    }
}

/* Small phones (≤ 576px) – further reduce */
@media (max-width: 576px) {
    body, .card, .form-label, .form-text, .alert, .btn, .form-control, .upload-area p,
    .request-card .card-body, .admin-reply-red, .status-badge,
    .card-header, .card-body, .fw-bold, .text-muted, .small, label, input, select, textarea,
    .btn-lg, .form-select-lg, .form-control-lg {
        font-size: 1rem !important;
    }
    .status-badge {
        font-size: 1rem !important;
        padding: 0.2rem 0.6rem !important;
    }
    .admin-reply-red {
        font-size: 1rem !important;
        padding: 0.3rem 0.5rem !important;
    }
    .form-alert-message {
        font-size: 1rem !important;
        padding: 0.5rem 0.6rem !important;
    }
    .form-control, .form-select, .btn, .btn-lg, .form-control-lg, .form-select-lg {
        font-size: 1rem !important;
        padding: 0.4rem 0.6rem !important;
    }
    .btn-lg {
        padding: 0.4rem 0.8rem !important;
    }
    .form-label {
        font-size: 1rem !important;
    }
    .card-body, .card-header {
        padding: 0.75rem !important;
    }
    .p-3, .p-md-4, .p-lg-5 {
        padding: 0.5rem !important;
    }
    .gap-3 {
        gap: 0.5rem !important;
    }
    .mb-3, .mb-md-4 {
        margin-bottom: 0.5rem !important;
    }
    .upload-area {
        padding: 0.75rem !important;
    }
}

/* Very small phones (≤ 400px) – minimum legible size */
@media (max-width: 400px) {
    body, .card, .form-label, .form-text, .alert, .btn, .form-control, .upload-area p,
    .request-card .card-body, .admin-reply-red, .status-badge,
    .card-header, .card-body, .fw-bold, .text-muted, .small, label, input, select, textarea,
    .btn-lg, .form-select-lg, .form-control-lg {
        font-size: 0.85rem !important;
    }
    .status-badge {
        font-size: 0.85rem !important;
        padding: 0.15rem 0.5rem !important;
        border-radius: 30px !important;
    }
    .admin-reply-red {
        font-size: 0.85rem !important;
        padding: 0.2rem 0.4rem !important;
        border-left-width: 3px !important;
    }
    .form-alert-message {
        font-size: 0.85rem !important;
        padding: 0.4rem 0.5rem !important;
    }
    .preview-image {
        max-height: 120px !important;
    }
    .spinner-custom {
        width: 2rem !important;
        height: 2rem !important;
    }
    .form-control, .form-select, .btn, .btn-lg, .form-control-lg, .form-select-lg {
        font-size: 0.85rem !important;
        padding: 0.25rem 0.4rem !important;
    }
    .btn-lg {
        padding: 0.25rem 0.5rem !important;
    }
    .form-label {
        font-size: 0.85rem !important;
    }
    .card-body, .card-header {
        padding: 0.5rem !important;
    }
    .p-3, .p-md-4, .p-lg-5 {
        padding: 0.25rem !important;
    }
    .gap-3 {
        gap: 0.25rem !important;
    }
    .mb-3, .mb-md-4 {
        margin-bottom: 0.25rem !important;
    }
    .upload-area {
        padding: 0.5rem !important;
    }
}

/* ============================================================
   WHITE & BLUE THEME OVERRIDES (using !important)
   ============================================================ */
.sticky-top-custom {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 4px 16px rgba(30, 136, 229, 0.08) !important;
}

.upload-area {
    background-color: #f8fafc !important;
    border-color: #cbd5e1 !important;
}
.upload-area:hover {
    border-color: #1e88e5 !important;
    background-color: #e3f2fd !important;
}
.upload-area.drag-over {
    border-color: #1e88e5 !important;
    background-color: #e3f2fd !important;
}

.status-badge {
    background-color: #f1f5f9 !important;
    color: #1e293b !important;
}
.status-pending {
    background-color: #fff3cd !important;
    color: #856404 !important;
}
.status-approved {
    background-color: #d4edda !important;
    color: #155724 !important;
}
.status-rejected {
    background-color: #f8d7da !important;
    color: #721c24 !important;
}

.admin-reply-red {
    background-color: #fef2f2 !important;
    color: #991b1b !important;
    border-left-color: #dc2626 !important;
}

.form-alert-message {
    background-color: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04) !important;
    color: #1e293b !important;
}
.form-alert-message.alert-success {
    background-color: #ecfdf5 !important;
    border-color: #6ee7b7 !important;
    color: #065f46 !important;
}
.form-alert-message.alert-danger {
    background-color: #fef2f2 !important;
    border-color: #fca5a5 !important;
    color: #991b1b !important;
}
.form-alert-message.alert-warning {
    background-color: #fffbeb !important;
    border-color: #fcd34d !important;
    color: #92400e !important;
}
.form-alert-message.alert-info {
    background-color: #eff6ff !important;
    border-color: #93c5fd !important;
    color: #1e3a8a !important;
}
</style>
@endpush

@push('scripts')
<script nonce="{{ $csp_nonce }}">
    (function() {
        // ---- CSRF token ----
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        // ---- Route URLs (using named routes) ----
        const listUrl = '{{ route('damage-requests.list', [], false) }}';
        const storeUrl = '{{ route('damage-requests.store', [], false) }}';

        // ---- Helper functions ----
        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function sanitizeInput(str) {
            if (!str) return '';
            return escapeHtml(str.trim().replace(/<[^>]*>/g, ''));
        }

        function showAlert(message, type = 'danger') {
            const existingAlert = document.querySelector('.form-alert-message');
            if (existingAlert) existingAlert.remove();

            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} form-alert-message mt-3`;
            alertDiv.setAttribute('role', 'alert');
            alertDiv.textContent = escapeHtml(message);

            const form = document.getElementById('damageRequestForm');
            const submitBtn = document.getElementById('submitBtn');
            if (form && submitBtn) {
                form.insertBefore(alertDiv, submitBtn.closest('.d-grid'));
            }

            setTimeout(() => {
                if (alertDiv.parentNode) alertDiv.remove();
            }, 5000);
        }

        function validateImage(file) {
            const maxSize = 2 * 1024 * 1024;
            if (!file) return { valid: false, error: 'No file selected' };
            if (!file.type.startsWith('image/')) return { valid: false, error: 'Only image files are allowed' };
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type.toLowerCase())) {
                return { valid: false, error: 'Invalid image format. Only JPG, PNG, GIF allowed.' };
            }
            if (file.size > maxSize) return { valid: false, error: `Image exceeds 2MB (${(file.size / 1024 / 1024).toFixed(2)} MB)` };
            return { valid: true, error: null };
        }

        // ---- Helper to programmatically set file input ----
        function setFileInputFiles(input, file) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;
            // Dispatch change event to run existing handlers
            const event = new Event('change', { bubbles: true });
            input.dispatchEvent(event);
        }

        // ---- DOM references ----
        const form = document.getElementById('damageRequestForm');
        const bookingSelect = document.getElementById('booking_id');
        const eggQuantityInput = document.getElementById('egg_quantity');
        const imageFileInput = document.getElementById('damage_image');
        const uploadArea = document.getElementById('uploadArea');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const removeImageBtn = document.getElementById('removeImageBtn');
        const imageErrorDiv = document.getElementById('imageError');
        const submitBtn = document.getElementById('submitBtn');
        const requestsLoading = document.getElementById('requestsLoading');
        const requestsList = document.getElementById('requestsList');
        const emptyRequests = document.getElementById('emptyRequests');
        const refreshBtn = document.getElementById('refreshRequestsBtn');
        const noBookingsWarning = document.getElementById('noBookingsWarning');
        const notesTextarea = document.getElementById('notes');

        let selectedFile = null;
        let existingRequestBookingIds = [];

        // ---- File upload events ----
        function handleFileSelect(file) {
            const validation = validateImage(file);
            if (!validation.valid) {
                imageErrorDiv.classList.remove('d-none');
                imageErrorDiv.textContent = escapeHtml(validation.error);
                imagePreviewContainer.classList.add('d-none');
                selectedFile = null;
                imageFileInput.value = '';
                return false;
            }
            imageErrorDiv.classList.add('d-none');
            selectedFile = file;
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreviewContainer.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
            return true;
        }

        // ---- NativePHP support ----
        const isNative = typeof window.Native !== 'undefined' && window.Native.file;

        // Override click on upload area to use NativePHP picker if available
        uploadArea.addEventListener('click', function(e) {
            if (isNative) {
                e.preventDefault(); // prevent default file input open
                Native.file.pick({
                    type: 'image/*',
                    multiple: false
                }).then(function(file) {
                    if (!file || !file.data) {
                        showAlert('No file selected or invalid data', 'danger');
                        return;
                    }
                    // Convert base64 to Blob
                    try {
                        const byteCharacters = atob(file.data);
                        const byteNumbers = new Array(byteCharacters.length);
                        for (let i = 0; i < byteCharacters.length; i++) {
                            byteNumbers[i] = byteCharacters.charCodeAt(i);
                        }
                        const byteArray = new Uint8Array(byteNumbers);
                        const blob = new Blob([byteArray], { type: file.type });
                        const fileObj = new File([blob], file.name, { type: file.type });
                        // Set the file to the input and trigger change
                        setFileInputFiles(imageFileInput, fileObj);
                    } catch (err) {
                        showAlert('Error processing image: ' + err.message, 'danger');
                    }
                }).catch(function(error) {
                    showAlert('Error picking file: ' + error.message, 'danger');
                });
            } else {
                // Regular browser – open the file input
                imageFileInput.click();
            }
        });

        // The existing change event listener for imageFileInput will handle preview and validation
        imageFileInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                handleFileSelect(e.target.files[0]);
            }
        });

        // Drag-and-drop (unchanged)
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });
        uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            if (e.dataTransfer.files.length) {
                const file = e.dataTransfer.files[0];
                // For drop, we set the input files and trigger change manually
                // Since drop event doesn't trigger change automatically, we set files and call handleFileSelect directly
                imageFileInput.files = e.dataTransfer.files;
                handleFileSelect(file);
            }
        });

        // Remove image (unchanged)
        removeImageBtn.addEventListener('click', () => {
            selectedFile = null;
            imageFileInput.value = '';
            imagePreviewContainer.classList.add('d-none');
            imagePreview.src = '#';
            imageErrorDiv.classList.add('d-none');
        });

        // ---- Dropdown helpers (unchanged) ----
        function storeOriginalOptionTexts() {
            const options = bookingSelect.querySelectorAll('option');
            options.forEach(opt => {
                if (opt.value && !opt.hasAttribute('data-original-text')) {
                    opt.setAttribute('data-original-text', opt.textContent);
                }
            });
        }

        function updateBookingDropdown() {
            storeOriginalOptionTexts();
            let enabledCount = 0;
            const options = bookingSelect.querySelectorAll('option');
            options.forEach(opt => {
                if (!opt.value) return;
                const originalText = opt.getAttribute('data-original-text') || opt.textContent;
                if (existingRequestBookingIds.includes(parseInt(opt.value, 10))) {
                    opt.disabled = true;
                    if (!opt.textContent.includes('(Done)')) {
                        opt.textContent = originalText + ' (Done)';
                    }
                } else {
                    opt.disabled = false;
                    if (opt.textContent.includes('(Done)')) {
                        opt.textContent = originalText;
                    }
                    enabledCount++;
                }
            });
            if (enabledCount === 0 && bookingSelect.options.length > 1) {
                noBookingsWarning.classList.remove('d-none');
            } else {
                noBookingsWarning.classList.add('d-none');
            }
            if (bookingSelect.selectedOptions[0] && bookingSelect.selectedOptions[0].disabled) {
                bookingSelect.value = '';
            }
        }

       // ---- Render requests (FIXED for public/uploads) ----
function renderRequestsList(requests) {
    requestsLoading.classList.add('d-none');
    if (!requests.length) {
        requestsList.classList.add('d-none');
        emptyRequests.classList.remove('d-none');
        emptyRequests.innerHTML = `
            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3">
                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="1.5"/>
                <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            <p class="fw-semibold">No damage requests found</p>
            <p>Submit your first request using the form.</p>
        `;
        return;
    }
    emptyRequests.classList.add('d-none');
    requestsList.classList.remove('d-none');
    let html = '<div class="row g-3 g-md-4">';
    requests.forEach(req => {
        const statusClass = req.status === 'pending' ? 'status-pending' : (req.status === 'approved' ? 'status-approved' : 'status-rejected');
        const statusText = req.status ? escapeHtml(req.status.charAt(0).toUpperCase() + req.status.slice(1)) : 'Pending';
        const createdAt = req.created_at ? escapeHtml(new Date(req.created_at).toLocaleString()) : 'N/A';

        // FIXED: Use image_url from the API response (which uses the model accessor)
        let imageUrl = req.image_url || null;

        const bookingRef = req.booking_reference ? escapeHtml(req.booking_reference) : 'N/A';
        const quantity = req.egg_quantity ? escapeHtml(String(req.egg_quantity)) : '0';
        const notes = req.notes ? escapeHtml(req.notes) : '';
        const adminReply = req.admin_reply ? escapeHtml(req.admin_reply) : '';

        html += `
            <div class="col-sm-6 col-xl-6">
                <div class="card request-card h-100 shadow-sm border-0">
                    ${imageUrl ? `
                        <a href="${escapeHtml(imageUrl)}" target="_blank" rel="noopener noreferrer">
                            <img src="${escapeHtml(imageUrl)}" class="card-img-top-custom img-fluid" alt="Damage evidence" loading="lazy" onerror="this.style.display='none'">
                        </a>
                    ` : `
                        <div class="card-img-top-custom bg-light d-flex align-items-center justify-content-center text-muted" style="aspect-ratio: 1/1;">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23 19C23 19.5304 22.7893 20.0391 22.4142 20.4142C22.0391 20.7893 21.5304 21 21 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V8C1 7.46957 1.21071 6.96086 1.58579 6.58579C1.96086 6.21071 2.46957 6 3 6H7L9 3H15L17 6H21C21.5304 6 22.0391 6.21071 22.4142 6.58579C22.7893 6.96086 23 7.46957 23 8V19Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                <circle cx="12" cy="13" r="4" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            <span class="ms-2">No Image</span>
                        </div>
                    `}
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                            <h5 class="fw-bold text-primary mb-0">#${bookingRef}</h5>
                            <span class="status-badge ${statusClass}">${statusText}</span>
                        </div>
                        <div class="mb-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-inline icon-mr-1">
                                <path d="M12 2C8.13 2 5 5.13 5 9C5 13.17 12 22 12 22C12 22 19 13.17 19 9C19 5.13 15.87 2 12 2Z" stroke="#ffc107" stroke-width="1.5"/>
                                <circle cx="12" cy="9" r="3" stroke="#ffc107" stroke-width="1.5"/>
                            </svg>
                            <strong>Quantity:</strong> ${quantity} pcs/trays
                        </div>
                        <div class="mb-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-inline icon-mr-1">
                                <path d="M3 8L12 3L21 8L12 13L3 8Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M5 10V16L12 21L19 16V10" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            <strong>Submitted:</strong> ${createdAt}
                        </div>
                        ${notes ? `<div class="mb-2 bg-light p-2 rounded">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-inline icon-mr-1">
                                <path d="M20 12V18H4V12" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M12 2V8" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M8 4L12 2L16 4" stroke="currentColor" stroke-width="1.5"/>
                            </svg> ${notes}
                        </div>` : ''}
                        ${adminReply ? `<div class="admin-reply-red">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-inline icon-mr-1">
                                <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            <strong>Admin Reply:</strong> ${adminReply}
                        </div>` : ''}
                    </div>
                </div>
            </div>
        `;
    });
    html += '</div>';
    requestsList.innerHTML = html;
}

        // ---- AJAX fetch (GET) ----
        function fetchRequestsAjax() {
            requestsLoading.classList.remove('d-none');
            requestsList.classList.add('d-none');
            emptyRequests.classList.add('d-none');

            fetch(listUrl, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'include'
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (Array.isArray(data)) {
                    existingRequestBookingIds = data.map(req => req.booking_id).filter(id => id && typeof id === 'number');
                    renderRequestsList(data);
                    updateBookingDropdown();
                } else {
                    showAlert('Invalid data format');
                    requestsLoading.classList.add('d-none');
                    emptyRequests.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('AJAX error:', error);
                let msg = 'Unable to load requests.';
                if (error.message.includes('401')) msg = 'Your session has expired. Please log in again.';
                else if (error.message.includes('419')) msg = 'Security token expired. Please refresh the page.';
                showAlert(msg);
                requestsLoading.classList.add('d-none');
                emptyRequests.classList.remove('d-none');
                emptyRequests.innerHTML = `
                    <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3 text-danger">
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <p class="fw-semibold">${escapeHtml(msg)}</p>
                    <p>Please try again later.</p>
                `;
            });
        }

        // ---- Submit form (POST with file) ----
        async function submitDamageRequest(event) {
            event.preventDefault();

            const existingAlert = document.querySelector('.form-alert-message');
            if (existingAlert) existingAlert.remove();

            const bookingId = bookingSelect.value;
            if (!bookingId) {
                showAlert('Please select a booking reference');
                return;
            }

            const selectedOption = bookingSelect.selectedOptions[0];
            if (selectedOption && selectedOption.disabled) {
                showAlert('This booking already has a damage request. Please select another booking.');
                return;
            }

            const quantity = parseInt(eggQuantityInput.value, 10);
            if (!eggQuantityInput.value || isNaN(quantity) || quantity < 1) {
                showAlert('Please enter a valid quantity (minimum 1)');
                return;
            }
            if (!selectedFile) {
                showAlert('Please upload an image of the damage (max 2MB)');
                return;
            }

            let notesValue = notesTextarea ? notesTextarea.value.trim() : '';
            if (notesValue.length > 500) {
                showAlert('Notes exceed maximum length of 500 characters');
                return;
            }
            notesValue = sanitizeInput(notesValue);

            const formData = new FormData();
            formData.append('booking_id', bookingId);
            formData.append('egg_quantity', quantity);
            formData.append('damage_image', selectedFile);
            formData.append('notes', notesValue);

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Submitting...';

            try {
                const response = await fetch(storeUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData,
                    credentials: 'include'
                });

                if (response.status === 419) {
                    showAlert('Security token expired. Please refresh the page.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<svg class="me-2 icon-inline" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 2L11 13" stroke="white" stroke-width="1.5" stroke-linecap="round"/><path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/></svg> Submit Damage Request';
                    return;
                }

                const data = await response.json();
                if (response.ok && data.success !== false) {
                    showAlert('Damage request submitted successfully!', 'success');
                    form.reset();
                    selectedFile = null;
                    imageFileInput.value = '';
                    imagePreviewContainer.classList.add('d-none');
                    imagePreview.src = '#';
                    if (notesTextarea) notesTextarea.value = '';
                    fetchRequestsAjax();
                } else {
                    const errorMsg = data.message || data.error || 'Submission failed.';
                    showAlert(escapeHtml(errorMsg));
                }
            } catch (error) {
                console.error('Submission error:', error);
                showAlert('Network error. Please check your connection.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg class="me-2 icon-inline" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 2L11 13" stroke="white" stroke-width="1.5" stroke-linecap="round"/><path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/></svg> Submit Damage Request';
            }
        }

        // ---- Refresh button ----
        refreshBtn.addEventListener('click', () => {
            fetchRequestsAjax();
            showAlert('Refreshing damage requests...', 'info');
        });

        // ---- Initialise ----
        storeOriginalOptionTexts();
        fetchRequestsAjax();
        form.addEventListener('submit', submitDamageRequest);
    })();
</script>
@endpush
