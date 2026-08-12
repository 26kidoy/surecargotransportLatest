@extends('layouts.app')

@section('content')
<div class="p-2 p-md-4 p-lg-5">
    <div class="row g-2 g-lg-4">
        <!-- Left Column: Filters (Sticky) -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 bg-white sticky-top-custom">
                <div class="card-body p-2 p-md-4 p-lg-5">
                    <!-- Status tabs: horizontal scroll -->
                    <div class="status-tabs-wrapper" id="statusTabs">
                        <button class="btn status-tab active" data-status="all">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="1.5"/></svg>
                            All <span class="status-count-badge">0</span>
                        </button>
                        <button class="btn status-tab" data-status="pending">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><path d="M12 8v4l3 3" stroke="currentColor" stroke-linecap="round"/></svg>
                            Pending <span class="status-count-badge">0</span>
                        </button>
                        <button class="btn status-tab" data-status="confirmed">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Confirmed <span class="status-count-badge">0</span>
                        </button>
                        <button class="btn status-tab" data-status="in_transit">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 15h18M5 9h14M7 3h10M5 21h2M17 21h2" stroke="currentColor" stroke-width="1.5"/><circle cx="7" cy="18" r="2" fill="currentColor"/><circle cx="17" cy="18" r="2" fill="currentColor"/></svg>
                            In Transit <span class="status-count-badge">0</span>
                        </button>
                        <button class="btn status-tab" data-status="delivered">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="currentColor" stroke-width="1.5"/><path d="M22 4L12 14.01l-3-3" stroke="currentColor" stroke-linecap="round"/></svg>
                            Delivered <span class="status-count-badge">0</span>
                        </button>
                        <button class="btn status-tab" data-status="cancelled">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.5"/></svg>
                            Cancelled <span class="status-count-badge">0</span>
                        </button>
                    </div>

                    <!-- Search -->
                    <div class="input-group input-group-lg mt-3">
                        <span class="input-group-text bg-transparent border-end-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: #0a58ca;"><path d="M21 21l-4.35-4.35M19 11a8 8 0 1 0-16 0 8 8 0 0 0 16 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" id="searchBooking" placeholder="Search by ref, truck, receiver...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Bookings List -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg rounded-4 bg-white">
                <div class="card-header bg-white border-0 p-2 p-md-4 p-lg-5 pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h3 class="fw-bold text-dark mb-0" style="font-size: clamp(1.1rem, 2.5vw, 1.8rem);">
                        <svg class="me-2 text-primary icon-inline" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        My Bookings
                    </h3>
                    <button class="btn btn-outline-secondary btn-lg px-2 px-md-4 py-1 py-md-2" id="refreshBookingsBtn" style="font-size: clamp(0.75rem, 1.2vw, 1rem);">
                        <svg class="me-1 icon-inline" width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23 4V10H17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M1 20V14H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M3.51 9C5.73 5.46 9.62 3 14 3C19.24 3 23.34 6.71 23.86 11.81" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M20.49 15C18.27 18.54 14.38 21 10 21C4.76 21 0.66 17.29 0.14 12.19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Refresh
                    </button>
                </div>
                <div class="card-body p-2 p-md-4 p-lg-5">
                    <!-- Bookings Grid -->
                    <div class="bookings-grid" id="bookingsGrid">
                        <div class="text-center py-5" id="loadingIndicator">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
                            <p class="mt-3 fw-semibold" style="font-size: clamp(1rem, 2vw, 1.5rem);">Loading bookings...</p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center p-2 p-lg-4 mt-3 mt-lg-5 flex-wrap gap-2 pagination-wrapper">
                        <div class="text-muted fw-medium" id="paginationInfo" style="font-size: clamp(0.75rem, 1.2vw, 1rem);"></div>
                        <nav><ul class="pagination mb-0" id="pagination"></ul></nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="editBookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-xl bg-white modal-card">
            <div class="modal-header bg-primary text-white p-2 p-lg-4">
                <h5 class="modal-title fw-bold" style="font-size: clamp(1rem, 2vw, 1.6rem);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: white; margin-right: 10px;"><path d="M12 20h9M16.5 3.5L20 7l-9 9-4 1 1-4 9-9z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                    Edit Booking
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2 p-lg-5" id="editBookingBody"><div class="text-center py-5"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div></div></div>
            <div class="modal-footer p-2 p-lg-4 border-0">
                <button type="button" class="btn btn-secondary btn-lg px-3 px-lg-5" data-bs-dismiss="modal" style="font-size: clamp(0.85rem, 1.2vw, 1.1rem);">Cancel</button>
                <button type="button" class="btn btn-primary btn-lg px-3 px-lg-5" id="saveBookingChangesBtn" style="font-size: clamp(0.85rem, 1.2vw, 1.1rem);">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bookingDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-xl bg-white modal-card">
            <div class="modal-header bg-primary text-white p-2 p-lg-4">
                <h5 class="modal-title fw-bold" style="font-size: clamp(1rem, 2vw, 1.6rem);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: white; margin-right: 10px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="1.5"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" stroke="currentColor" stroke-linecap="round"/></svg>
                    Booking Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2 p-lg-5" id="bookingDetailBody"></div>
            <div class="modal-footer p-2 p-lg-4 border-0 gap-2">
                <button type="button" class="btn btn-secondary btn-lg px-3 px-lg-5" data-bs-dismiss="modal" style="font-size: clamp(0.85rem, 1.2vw, 1.1rem);">Close</button>
                <button type="button" class="btn btn-danger btn-lg px-3 px-lg-5" id="cancelBookingBtn" style="display: none; font-size: clamp(0.85rem, 1.2vw, 1.1rem);">Cancel Booking</button>
                <button type="button" class="btn btn-primary btn-lg px-3 px-lg-5" id="editFromDetailBtn" style="display: none; font-size: clamp(0.85rem, 1.2vw, 1.1rem);">Edit Booking</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-xl bg-white modal-card">
            <div class="modal-header bg-success text-white p-2 p-lg-4">
                <h5 class="modal-title fw-bold" style="font-size: clamp(1rem, 2vw, 1.6rem);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: white; margin-right: 10px;"><rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M22 10H2" stroke="currentColor"/><circle cx="18" cy="14" r="1" fill="white"/></svg>
                    Complete Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2 p-lg-5" id="paymentModalBody"><div class="text-center py-5"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div><p class="mt-3" style="font-size: clamp(1rem, 2vw, 1.4rem);">Loading payment methods...</p></div></div>
        </div>
    </div>
</div>

<div class="modal fade" id="codNameModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-xl bg-white modal-card">
            <div class="modal-header bg-primary text-white p-2 p-lg-4">
                <h5 class="modal-title fw-bold" style="font-size: clamp(1rem, 2vw, 1.6rem);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: white; margin-right: 10px;"><path d="M3 15h18M5 9h14M7 3h10M5 21h2M17 21h2" stroke="currentColor" stroke-width="1.5"/><circle cx="7" cy="18" r="2" fill="white"/><circle cx="17" cy="18" r="2" fill="white"/></svg>
                    Cash on Delivery
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2 p-lg-5">
                <p class="fw-medium mb-3" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Please enter your full name to confirm the COD order.</p>
                <input type="text" class="form-control form-control-lg py-2" id="codSenderName" placeholder="Your full name" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">
                <div class="mt-3 text-muted" style="font-size: clamp(0.75rem, 1.2vw, 1rem);">You will pay the exact amount in cash when your items are delivered.</div>
            </div>
            <div class="modal-footer p-2 p-lg-4 border-0 gap-2">
                <button type="button" class="btn btn-secondary btn-lg px-3 px-lg-5" data-bs-dismiss="modal" style="font-size: clamp(0.85rem, 1.2vw, 1.1rem);">Cancel</button>
                <button type="button" class="btn btn-primary btn-lg px-3 px-lg-5" id="confirmCodBtn" style="font-size: clamp(0.85rem, 1.2vw, 1.1rem);">Confirm COD</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editNotAllowedModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-xl bg-white modal-card">
            <div class="modal-header bg-danger text-white p-2 p-lg-4">
                <h5 class="modal-title fw-bold" style="font-size: clamp(1rem, 2vw, 1.6rem);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: white; margin-right: 10px;"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.5"/></svg>
                    Cannot Edit Booking
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2 p-lg-5">
                <p id="editNotAllowedMessage" class="mb-0" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">This booking cannot be edited because it has already been confirmed by the admin.</p>
            </div>
            <div class="modal-footer p-2 p-lg-4 border-0">
                <button type="button" class="btn btn-secondary btn-lg px-3 px-lg-5" data-bs-dismiss="modal" style="font-size: clamp(0.85rem, 1.2vw, 1.1rem);">Got it</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script nonce="{{ $csp_nonce }}">
(function() {
    'use strict';

    // ==================== CSRF Token ====================
    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    // ==================== CLICK SOUND SYSTEM (CSP-friendly, non-blocking) ====================
    var clickAudio = null;
    var audioLoaded = false;

    function initClickAudio() {
        try {
            clickAudio = new Audio('{{ asset("audio/click.mp3") }}');
            clickAudio.preload = 'auto';
            clickAudio.volume = 0.5;
            clickAudio.load();
            audioLoaded = true;
        } catch(e) {
            console.log('Audio not available');
        }
    }

    function playClick() {
        if (clickAudio && audioLoaded) {
            try {
                clickAudio.currentTime = 0;
                clickAudio.play().catch(function() {});
            } catch(e) {}
        }
    }

    var audioInitialized = false;
    function ensureAudioInitialized() {
        if (!audioInitialized) {
            initClickAudio();
            audioInitialized = true;
        }
    }

    document.addEventListener('click', function(e) {
        var target = e.target.closest('a, button, .status-tab, .view-booking, .edit-booking, .pay-now-btn, .page-link, .payment-method-item, .btn, [href], [role="button"]');
        if (target) {
            ensureAudioInitialized();
            requestAnimationFrame(function() {
                playClick();
            });
        }
    });

    // ==================== HELPERS ====================
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function getSvgIcon(iconName, size, color) {
        size = size || 20;
        color = color || '#0d6efd';
        var safeIconName = String(iconName).replace(/[^a-z-]/gi, '');
        var safeColor = String(color).replace(/[^#0-9a-f]/gi, '');
        var icons = {
            eye: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor"/></svg>',
            edit: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><path d="M12 20h9M16.5 3.5L20 7l-9 9-4 1 1-4 9-9z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>',
            truck: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><path d="M3 15h18M5 9h14M7 3h10M5 21h2M17 21h2" stroke="currentColor" stroke-width="1.5"/><circle cx="7" cy="18" r="2" fill="currentColor" fill-opacity="0.8"/><circle cx="17" cy="18" r="2" fill="currentColor" fill-opacity="0.8"/></svg>',
            'credit-card': '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M22 10H2" stroke="currentColor"/><circle cx="18" cy="14" r="1" fill="currentColor"/></svg>',
            map: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="10" r="3" stroke="currentColor"/></svg>',
            box: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="currentColor" stroke-width="1.5"/><path d="M12 22V12M3.3 7L12 12l8.7-5" stroke="currentColor"/></svg>',
            money: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><path d="M2 8h20M6 16h4M14 16h2M12 6v12" stroke="currentColor" stroke-width="1.5"/><rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor"/></svg>',
            user: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="7" r="4" stroke="currentColor"/></svg>',
            location: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><path d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" stroke="currentColor"/><path d="M12 22c4-4 8-7.5 8-12a8 8 0 0 0-16 0c0 4.5 4 8 8 12z" stroke="currentColor"/></svg>',
            'check-circle': '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><circle cx="12" cy="12" r="9" stroke="currentColor"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-linecap="round"/></svg>',
            'times-circle': '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><circle cx="12" cy="12" r="9" stroke="currentColor"/><path d="m15 9-6 6m0-6 6 6" stroke="currentColor"/></svg>',
            calendar: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor"/><path d="M8 2v4M16 2v4M3 10h18" stroke="currentColor"/></svg>',
            info: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><circle cx="12" cy="12" r="9" stroke="currentColor"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-linecap="round"/></svg>',
            download: '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: ' + safeColor + ';"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" stroke="currentColor" stroke-width="1.5"/></svg>'
        };
        return icons[safeIconName] || icons.info;
    }

    function showToast(message, type) {
        type = type || 'success';
        var safeMessage = escapeHtml(message);
        var safeType = String(type).replace(/[^a-z]/gi, '');
        var bgColor = safeType === 'success' ? 'bg-success' :
                     (safeType === 'danger' ? 'bg-danger' :
                     (safeType === 'warning' ? 'bg-warning' :
                     (safeType === 'primary' ? 'bg-primary' : 'bg-info')));
        var icon = getSvgIcon('info', 24, 'white');
        if (safeType === 'success') icon = getSvgIcon('check-circle', 24, 'white');
        else if (safeType === 'danger') icon = getSvgIcon('times-circle', 24, 'white');

        var toast = $('<div class="toast-notification ' + bgColor + ' text-white p-3 p-lg-4 rounded-4 shadow-lg d-flex align-items-center gap-2 gap-lg-3" style="font-size: clamp(0.8rem, 1.2vw, 1rem);">' + icon + ' <span class="fw-semibold">' + safeMessage + '</span></div>');
        $('body').append(toast);
        setTimeout(function() { toast.fadeOut(300, function() { toast.remove(); }); }, 5000);
    }

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        try {
            var date = new Date(dateString);
            if (isNaN(date.getTime())) return 'N/A';
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        } catch(e) { return 'N/A'; }
    }

    function getStatusBadgeClass(status) {
        var safeStatus = String(status || '').toLowerCase();
        var classes = {
            'pending': 'bg-warning text-dark',
            'confirmed': 'bg-info text-dark',
            'in_transit': 'bg-primary text-white',
            'delivered': 'bg-success text-white',
            'cancelled': 'bg-danger text-white'
        };
        return classes[safeStatus] || 'bg-secondary text-white';
    }

    function getPaymentStatusBadgeClass(status) {
        var safeStatus = String(status || '').toLowerCase();
        var classes = {
            'pending': 'bg-warning text-dark',
            'approve': 'bg-success text-white',
            'decline': 'bg-danger text-white',
            'refunded': 'bg-info text-white',
            'cod': 'bg-primary text-white'
        };
        return classes[safeStatus] || 'bg-secondary text-white';
    }

    function getStatusText(status) {
        if (!status) return 'Unknown';
        var safeStatus = String(status).toLowerCase();
        if (safeStatus === 'cod') return 'Cash on Delivery';
        if (safeStatus === 'in_transit') return 'In Transit';
        return safeStatus.replace('_', ' ').split(' ').map(function(word) { return word.charAt(0).toUpperCase() + word.slice(1); }).join(' ');
    }

    // ==================== GLOBALS ====================
    var allBookings = [];
    var currentPage = 1;
    var itemsPerPage = 10;
    var currentBookingId = null;
    var selectedMethod = null;
    var cachedPaymentMethods = null;
    var previousPaymentStatuses = {};
    var previousBookingStatuses = {};
    var isLoading = false;
    var pollingInterval = null;
    var selectedStatus = 'all';
    var codBookingPending = null;
    var codAmountPending = null;
    var lastApiCall = 0;
    var minApiInterval = 1000;

    // ==================== LOAD BOOKINGS ====================
    function loadBookings(showNotificationOnChange, silent) {
        showNotificationOnChange = (showNotificationOnChange !== undefined) ? showNotificationOnChange : true;
        silent = silent || false;

        if (isLoading) return;
        if (silent && (Date.now() - lastApiCall < minApiInterval)) return;

        isLoading = true;
        lastApiCall = Date.now();

        if (!silent) {
            $('#bookingsGrid').html('<div class="text-center py-5"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div><p class="mt-3 fw-semibold" style="font-size: clamp(1rem, 2vw, 1.5rem);">Loading bookings...</p></div>');
        }

        $.ajax({
            url: '/api/my-bookings?_=' + Date.now(),
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Cache-Control': 'no-cache, no-store, must-revalidate'
            },
            success: function(response) {
                var newBookings = Array.isArray(response) ? response : (response.data || []);

                var sanitizedBookings = newBookings.map(function(booking) {
                    return {
                        ...booking,
                        booking_reference: escapeHtml(booking.booking_reference || ''),
                        receiver_name: escapeHtml(booking.receiver_name || ''),
                        drop_location: escapeHtml(booking.drop_location || ''),
                        pickup_address: escapeHtml(booking.pickup_address || ''),
                        receiver_phone: escapeHtml(booking.receiver_phone || ''),
                        truck_name: escapeHtml(booking.truck_name || ''),
                        truck_number: escapeHtml(booking.truck_number || '')
                    };
                });

                if (showNotificationOnChange && Object.keys(previousBookingStatuses).length > 0) {
                    for (var i = 0; i < sanitizedBookings.length; i++) {
                        var b = sanitizedBookings[i];
                        var oldStatus = previousBookingStatuses[b.id];
                        var newStatus = b.status;
                        if (oldStatus && oldStatus !== newStatus && newStatus) {
                            var statusText = getStatusText(newStatus);
                            var toastType = 'info';
                            if (newStatus === 'confirmed') toastType = 'success';
                            else if (newStatus === 'in_transit') toastType = 'primary';
                            else if (newStatus === 'delivered') toastType = 'success';
                            else if (newStatus === 'cancelled') toastType = 'danger';
                            showToast('Booking #' + b.booking_reference + ' status updated to ' + statusText + '.', toastType);
                        }
                    }
                }

                previousBookingStatuses = {};
                for (var j = 0; j < sanitizedBookings.length; j++) {
                    previousBookingStatuses[sanitizedBookings[j].id] = sanitizedBookings[j].status;
                }

                allBookings = sanitizedBookings;
                updateStatusBadges();
                renderBookings(silent);
                loadPaymentMethods();
            },
            error: function(xhr) {
                if (!silent) {
                    var errorMsg = xhr.status === 401 ? 'Please login to view your bookings.' : 'Failed to load bookings.';
                    $('#bookingsGrid').html('<div class="text-center py-5 text-danger fw-bold" style="font-size: clamp(1rem, 2vw, 1.5rem);">' + escapeHtml(errorMsg) + '<br><button class="btn btn-primary btn-lg mt-4 px-4 px-lg-5 py-2 py-lg-3" onclick="location.reload()" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Retry</button></div>');
                }
            },
            complete: function() {
                isLoading = false;
            }
        });
    }

    function loadPaymentMethods() {
        return new Promise(function(resolve, reject) {
            if (cachedPaymentMethods) {
                resolve(cachedPaymentMethods);
                return;
            }
            $.ajax({
                url: '/api/payment-methods/active?_=' + Date.now(),
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Cache-Control': 'no-cache'
                },
                success: function(response) {
                    var methods = [];
                    if (Array.isArray(response)) methods = response;
                    else if (response.data && Array.isArray(response.data)) methods = response.data;
                    else if (response.methods && Array.isArray(response.methods)) methods = response.methods;

                    methods = methods.map(function(m) {
                        return {
                            ...m,
                            display_name: escapeHtml(m.display_name || m.method_key || m.key || ''),
                            account_name: escapeHtml(m.account_name || ''),
                            instructions: escapeHtml(m.instructions || ''),
                            reference_number: escapeHtml(m.reference_number || '')
                        };
                    });

                    var hasCod = methods.some(function(m) { return (m.method_key || m.key) === 'cod'; });
                    if (!hasCod) {
                        methods.push({
                            method_key: 'cod',
                            key: 'cod',
                            display_name: 'Cash on Delivery',
                            account_name: null,
                            reference_number: null,
                            instructions: 'Pay the exact amount in cash when your items are delivered.',
                            qr_code_url: null,
                            qr_code_image: null,
                            is_active: true
                        });
                    }
                    if (methods.length) cachedPaymentMethods = methods;
                    resolve(methods);
                },
                error: function() { resolve([]); }
            });
        });
    }

    // ==================== UI RENDERING ====================
    function updateStatusBadges() {
        var statuses = ['all', 'pending', 'confirmed', 'in_transit', 'delivered', 'cancelled'];
        for (var i = 0; i < statuses.length; i++) {
            var status = statuses[i];
            var count = 0;
            if (status === 'all') count = allBookings.length;
            else count = allBookings.filter(function(b) { return b.status === status; }).length;
            var button = $('.status-tab[data-status="' + status + '"]');
            button.find('.status-count-badge').text(count);
        }
    }

    function renderBookings(silent) {
        silent = silent || false;
        var searchTerm = $('#searchBooking').val().toLowerCase();
        var safeSearchTerm = escapeHtml(searchTerm || '');

        var filtered = allBookings.filter(function(b) {
            var match = true;
            if (selectedStatus !== 'all') match = b.status === selectedStatus;
            if (match && safeSearchTerm) {
                match = (b.booking_reference && b.booking_reference.toLowerCase().indexOf(safeSearchTerm) !== -1) ||
                        (b.truck && b.truck.truck_name && b.truck.truck_name.toLowerCase().indexOf(safeSearchTerm) !== -1) ||
                        (b.receiver_name && b.receiver_name.toLowerCase().indexOf(safeSearchTerm) !== -1) ||
                        (b.drop_location && b.drop_location.toLowerCase().indexOf(safeSearchTerm) !== -1);
            }
            return match;
        });

        filtered.sort(function(a, b) { return new Date(b.created_at) - new Date(a.created_at); });
        var totalItems = filtered.length;
        var totalPages = Math.ceil(totalItems / itemsPerPage);
        var start = (currentPage - 1) * itemsPerPage;
        var paginated = filtered.slice(start, start + itemsPerPage);

        if (currentPage > totalPages && totalPages > 0) {
            currentPage = totalPages;
            renderBookings(silent);
            return;
        }

        if (!paginated.length) {
            if (!silent || $('#bookingsGrid .booking-card').length === 0) {
                $('#bookingsGrid').html('<div class="text-center py-5 text-muted fw-semibold" style="font-size: clamp(1rem, 2vw, 1.5rem);">No bookings found</div>');
            }
            $('#paginationInfo').text('Showing 0 entries');
            $('#pagination').empty();
            return;
        }

        var cardsHtml = '<div class="row g-2 g-lg-4 booking-row">';
        for (var i = 0; i < paginated.length; i++) {
            var booking = paginated[i];
            var truckName = booking.truck ? booking.truck.truck_name : (booking.truck_name || 'N/A');
            var statusClass = getStatusBadgeClass(booking.status);
            var statusText = getStatusText(booking.status);
            var isConfirmed = booking.status === 'confirmed';
            var paymentStatus = booking.payment_status || 'pending';
            var paymentBadgeClass = getPaymentStatusBadgeClass(paymentStatus);
            var paymentStatusText = getStatusText(paymentStatus);
            var canEdit = booking.status === 'pending';

            var buttonsHtml = '<div class="d-flex gap-1 gap-lg-3 mt-2 mt-lg-4 flex-wrap booking-actions">' +
                '<button class="btn btn-outline-info view-booking flex-fill py-1 py-lg-3 fw-semibold rounded-3" data-id="' + escapeHtml(String(booking.id)) + '" style="font-size: clamp(0.7rem, 1vw, 0.9rem);">' + getSvgIcon('eye',16) + ' View</button>';

            if (booking.status === 'in_transit') {
                buttonsHtml += '<a href="/viewroute" class="btn btn-info flex-fill py-1 py-lg-3 fw-semibold rounded-3 text-white" style="font-size: clamp(0.7rem, 1vw, 0.9rem);">' + getSvgIcon('map',16) + ' Track</a>';
            }

            buttonsHtml += '<button class="btn btn-outline-primary edit-booking flex-fill py-1 py-lg-3 fw-semibold rounded-3" data-id="' + escapeHtml(String(booking.id)) + '" ' + (!canEdit ? 'disabled' : '') + ' style="font-size: clamp(0.7rem, 1vw, 0.9rem);">' + getSvgIcon('edit',16) + ' Edit</button>';

            if (isConfirmed) {
                if (paymentStatus === 'pending') {
                    buttonsHtml += '<button class="btn btn-secondary flex-fill py-1 py-lg-3 fw-semibold rounded-3" disabled style="font-size: clamp(0.7rem, 1vw, 0.9rem);"><div class="spinner-border spinner-border-sm me-1"></div> Wait..</button>';
                } else if (paymentStatus !== 'approve' && paymentStatus !== 'cod') {
                    buttonsHtml += '<button class="btn btn-success pay-now-btn flex-fill py-1 py-lg-3 fw-semibold rounded-3" data-id="' + escapeHtml(String(booking.id)) + '" style="font-size: clamp(0.7rem, 1vw, 0.9rem);">' + getSvgIcon('credit-card',16) + ' Pay</button>';
                }
            }
            buttonsHtml += '</div>';

            cardsHtml += '<div class="col-12 col-sm-6 col-lg-4 booking-col"><div class="card h-100 shadow-lg rounded-4 border-0 booking-card" data-booking-id="' + escapeHtml(String(booking.id)) + '"><div class="card-body p-2 p-lg-5"><div class="d-flex justify-content-between align-items-start mb-2 mb-lg-4 flex-wrap gap-1"><h5 class="fw-bold text-primary mb-0 booking-ref" style="font-size: clamp(0.9rem, 1.5vw, 1.2rem);">' + escapeHtml(booking.booking_reference) + '</h5><span class="badge ' + statusClass + ' px-2 px-lg-4 py-1 py-lg-2 fw-semibold rounded-pill" style="font-size: clamp(0.6rem, 0.9vw, 0.8rem);">' + statusText + '</span></div>' +
                '<div class="mb-1 mb-lg-3 booking-detail" style="font-size: clamp(0.75rem, 1.1vw, 0.95rem);"><i class="text-muted me-1 me-lg-3">' + getSvgIcon('truck',14) + '</i> <strong>Truck:</strong> ' + escapeHtml(truckName) + '</div>' +
                '<div class="mb-1 mb-lg-3 booking-detail" style="font-size: clamp(0.75rem, 1.1vw, 0.95rem);"><i class="text-muted me-1 me-lg-3">' + getSvgIcon('box',14) + '</i> <strong>Qty:</strong> ' + escapeHtml(String(booking.quantity || 0)) + ' trays</div>' +
                '<div class="mb-1 mb-lg-3 booking-detail" style="font-size: clamp(0.75rem, 1.1vw, 0.95rem);"><i class="text-muted me-1 me-lg-3">' + getSvgIcon('money',14) + '</i> <strong>Total:</strong> ₱' + parseFloat(booking.total_amount || 0).toFixed(2) + '</div>' +
                '<div class="mb-1 mb-lg-3 booking-detail" style="font-size: clamp(0.75rem, 1.1vw, 0.95rem);"><i class="text-muted me-1 me-lg-3">' + getSvgIcon('user',14) + '</i> <strong>Receiver:</strong> ' + escapeHtml(booking.receiver_name) + '</div>' +
                '<div class="mb-1 mb-lg-3 booking-detail" style="font-size: clamp(0.75rem, 1.1vw, 0.95rem);"><i class="text-muted me-1 me-lg-3">' + getSvgIcon('location',14) + '</i> <strong>Drop:</strong> ' + escapeHtml(booking.drop_location) + '</div>' +
                '<div class="mb-2 mb-lg-4 booking-detail" style="font-size: clamp(0.75rem, 1.1vw, 0.95rem);"><i class="text-muted me-1 me-lg-3">' + getSvgIcon('credit-card',14) + '</i> <strong>Payment:</strong> <span class="badge ' + paymentBadgeClass + ' ms-1 ms-lg-2 px-2 px-lg-3 py-1 py-lg-2 rounded-pill" style="font-size: clamp(0.6rem, 0.9vw, 0.8rem);">' + paymentStatusText + '</span></div>' +
                buttonsHtml + '</div></div></div>';
        }
        cardsHtml += '</div>';
        $('#bookingsGrid').html(cardsHtml);

        $('#paginationInfo').text('Showing ' + (start+1) + ' to ' + Math.min(start+itemsPerPage, totalItems) + ' of ' + totalItems + ' entries');

        var pagHtml = '';
        if (totalPages > 1) {
            pagHtml += '<li class="page-item ' + (currentPage===1?'disabled':'') + '"><a class="page-link px-2 px-lg-4 py-1 py-lg-2" href="#" data-page="' + (currentPage-1) + '" style="font-size: clamp(0.75rem, 1.1vw, 0.95rem);">&laquo;</a></li>';
            for (var p = Math.max(1, currentPage-2); p <= Math.min(totalPages, currentPage+2); p++) {
                pagHtml += '<li class="page-item ' + (currentPage===p?'active':'') + '"><a class="page-link px-2 px-lg-4 py-1 py-lg-2 fw-semibold" href="#" data-page="' + p + '" style="font-size: clamp(0.75rem, 1.1vw, 0.95rem);">' + p + '</a></li>';
            }
            pagHtml += '<li class="page-item ' + (currentPage===totalPages?'disabled':'') + '"><a class="page-link px-2 px-lg-4 py-1 py-lg-2" href="#" data-page="' + (currentPage+1) + '" style="font-size: clamp(0.75rem, 1.1vw, 0.95rem);">&raquo;</a></li>';
        }
        $('#pagination').html(pagHtml);
    }

    // ==================== MODAL ACTIONS ====================
    function viewBooking(bookingId) {
        var safeId = parseInt(bookingId, 10);
        if (isNaN(safeId)) return;
        var booking = allBookings.find(function(b) { return b.id === safeId; });
        if (!booking) return;
        currentBookingId = safeId;

        var html = '<div class="mb-3 mb-lg-4"><div class="row"><div class="col-6"><small class="text-muted" style="font-size: clamp(0.7rem, 1vw, 0.85rem);">Reference:</small><br><strong style="font-size: clamp(1rem, 1.8vw, 1.4rem);">' + escapeHtml(booking.booking_reference) + '</strong></div><div class="col-6 text-end"><small class="text-muted" style="font-size: clamp(0.7rem, 1vw, 0.85rem);">Status:</small><br><span class="badge ' + getStatusBadgeClass(booking.status) + ' px-2 px-lg-3 py-1 py-lg-2" style="font-size: clamp(0.7rem, 1.1vw, 0.9rem);">' + getStatusText(booking.status) + '</span></div></div></div>' +
            '<hr class="my-3 my-lg-4"><div class="mb-3 mb-lg-4"><h6 class="fw-bold mb-2 mb-lg-3" style="font-size: clamp(1rem, 1.8vw, 1.4rem);">' + getSvgIcon('money',20) + ' Pricing</h6><p style="font-size: clamp(0.85rem, 1.3vw, 1.1rem);"><strong>Fee per tray:</strong> ₱' + parseFloat(booking.fee_per_tray || 0).toFixed(2) + '<br><strong>Total amount:</strong> ₱' + parseFloat(booking.total_amount || 0).toFixed(2) + '</p></div>' +
            '<hr class="my-3 my-lg-4"><div class="mb-3 mb-lg-4"><h6 class="fw-bold mb-2 mb-lg-3" style="font-size: clamp(1rem, 1.8vw, 1.4rem);">' + getSvgIcon('truck',20) + ' Truck Information</h6><p style="font-size: clamp(0.85rem, 1.3vw, 1.1rem);"><strong>Name:</strong> ' + escapeHtml(booking.truck?.truck_name || booking.truck_name || 'N/A') + '<br><strong>Number:</strong> ' + escapeHtml(booking.truck?.truck_number || booking.truck_number) + '<br><strong>Driver:</strong> ' + escapeHtml(booking.truck?.driver_name) + '<br><strong>Contact:</strong> ' + escapeHtml(booking.truck?.driver_phone) + '</p></div>' +
            '<hr class="my-3 my-lg-4"><div class="mb-3 mb-lg-4"><h6 class="fw-bold mb-2 mb-lg-3" style="font-size: clamp(1rem, 1.8vw, 1.4rem);">' + getSvgIcon('box',20) + ' Booking Details</h6><p style="font-size: clamp(0.85rem, 1.3vw, 1.1rem);"><strong>Quantity:</strong> ' + escapeHtml(String(booking.quantity || 0)) + ' trays<br><strong>Pickup:</strong> ' + escapeHtml(booking.pickup_address) + '<br><strong>Drop-off:</strong> ' + escapeHtml(booking.drop_location) + '</p></div>' +
            '<hr class="my-3 my-lg-4"><div class="mb-3 mb-lg-4"><h6 class="fw-bold mb-2 mb-lg-3" style="font-size: clamp(1rem, 1.8vw, 1.4rem);">' + getSvgIcon('user',20) + ' Receiver</h6><p style="font-size: clamp(0.85rem, 1.3vw, 1.1rem);"><strong>Name:</strong> ' + escapeHtml(booking.receiver_name) + '<br><strong>Phone:</strong> ' + escapeHtml(booking.receiver_phone) + '</p></div>' +
            '<hr class="my-3 my-lg-4"><div class="mb-3 mb-lg-4"><h6 class="fw-bold mb-2 mb-lg-3" style="font-size: clamp(1rem, 1.8vw, 1.4rem);">' + getSvgIcon('calendar',20) + ' Timeline</h6><p style="font-size: clamp(0.85rem, 1.3vw, 1.1rem);"><strong>Created:</strong> ' + formatDate(booking.created_at) + '<br><strong>Updated:</strong> ' + formatDate(booking.updated_at) + '</p></div>';

        $('#bookingDetailBody').html(html);
        $('#cancelBookingBtn').toggle(booking.status === 'pending');
        $('#editFromDetailBtn').toggle(booking.status !== 'cancelled');
        $('#bookingDetailModal').modal('show');
    }

    // ==================== EVENT BINDINGS ====================
    function startPolling() {
        if (pollingInterval) clearInterval(pollingInterval);
        pollingInterval = setInterval(function() {
            if (document.visibilityState === 'visible') loadBookings(true, true);
        }, 15000);
    }

    $(document).ready(function() {
        // Load bookings on page load
        loadBookings(false, false);
        startPolling();

        // Status tabs
        $('.status-tab').on('click', function() {
            $('.status-tab').removeClass('active');
            $(this).addClass('active');
            selectedStatus = $(this).data('status');
            currentPage = 1;
            renderBookings();
        });

        // Search
        $('#searchBooking').on('input', function() {
            currentPage = 1;
            renderBookings();
        });

        // View booking
        $(document).on('click', '.view-booking', function() {
            viewBooking($(this).data('id'));
        });

        // Edit booking
        $(document).on('click', '.edit-booking', function() {
            var bookingId = $(this).data('id');
            var booking = allBookings.find(function(b) { return b.id == bookingId; });
            if (!booking) return;
            if (booking.status !== 'pending') {
                $('#editNotAllowedMessage').text('This booking has been ' + getStatusText(booking.status) + ' and cannot be edited.');
                $('#editNotAllowedModal').modal('show');
                return;
            }
            currentBookingId = bookingId;
            var editHtml = '<form id="inlineEditForm"><div class="mb-3 mb-lg-4"><label class="fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Booking Reference</label><input type="text" class="form-control form-control-lg py-2" value="' + escapeHtml(booking.booking_reference) + '" disabled style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);"></div><div class="row"><div class="col-md-6 mb-3 mb-lg-4"><label class="fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Receiver Name *</label><input type="text" class="form-control form-control-lg py-2" id="editReceiverName" value="' + escapeHtml(booking.receiver_name) + '" required maxlength="255" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);"></div><div class="col-md-6 mb-3 mb-lg-4"><label class="fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Receiver Phone *</label><input type="text" class="form-control form-control-lg py-2" id="editReceiverPhone" value="' + escapeHtml(booking.receiver_phone) + '" required maxlength="50" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);"></div></div><div class="mb-3 mb-lg-4"><label class="fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Drop Location *</label><textarea class="form-control form-control-lg py-2" id="editDropLocation" rows="2" required maxlength="1000" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">' + escapeHtml(booking.drop_location) + '</textarea></div><div class="mb-3 mb-lg-4"><label class="fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Quantity (trays) *</label><input type="number" class="form-control form-control-lg py-2" id="editQuantity" value="' + escapeHtml(String(booking.quantity)) + '" min="1" max="10000" required style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);"></div><div class="mb-3 mb-lg-4"><label class="fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Pickup Address *</label><textarea class="form-control form-control-lg py-2" id="editPickupAddress" rows="2" required maxlength="1000" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">' + escapeHtml(booking.pickup_address) + '</textarea></div><div class="alert alert-info p-2 p-lg-4" style="font-size: clamp(0.85rem, 1.3vw, 1.1rem);">' + getSvgIcon('info',18) + ' Status cannot be changed here. Contact admin for updates.</div></form>';
            $('#editBookingBody').html(editHtml);
            $('#editBookingModal').modal('show');
        });

        // Save booking changes
        $('#saveBookingChangesBtn').on('click', function() {
            if (!currentBookingId) return;
            var receiverName = $('#editReceiverName').val().trim();
            var receiverPhone = $('#editReceiverPhone').val().trim();
            var dropLocation = $('#editDropLocation').val().trim();
            var quantity = parseInt($('#editQuantity').val(), 10);
            var pickupAddress = $('#editPickupAddress').val().trim();

            if (!receiverName || !receiverPhone || !dropLocation || !pickupAddress || isNaN(quantity) || quantity < 1) {
                showToast('Please fill all fields correctly', 'danger');
                return;
            }

            var data = {
                receiver_name: receiverName.substring(0, 255),
                receiver_phone: receiverPhone.substring(0, 50),
                drop_location: dropLocation.substring(0, 1000),
                quantity: quantity,
                pickup_address: pickupAddress.substring(0, 1000)
            };

            var $btn = $(this);
            $btn.prop('disabled', true).html('<div class="spinner-border spinner-border-sm me-2"></div> Saving...');
            $.ajax({
                url: '/bookings/' + currentBookingId,
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                data: JSON.stringify(data),
                success: function() {
                    showToast('Booking updated!', 'success');
                    $('#editBookingModal').modal('hide');
                    loadBookings(false);
                },
                error: function(xhr) {
                    var errMsg = xhr.responseJSON?.message || 'Update failed';
                    showToast(escapeHtml(errMsg), 'danger');
                },
                complete: function() { $btn.prop('disabled', false).html('Save Changes'); }
            });
        });

        // Pay now with screenshot upload
        $(document).on('click', '.pay-now-btn', function() {
            var bookingId = $(this).data('id');
            var booking = allBookings.find(function(b) { return b.id == bookingId; });
            if (!booking) return;
            currentBookingId = bookingId;
            var amount = parseFloat(booking.total_amount) || 0;
            $('#paymentModalBody').html('<div class="text-center py-5"><div class="spinner-border text-success" style="width: 3rem; height: 3rem;"></div><p class="mt-3" style="font-size: clamp(1rem, 2vw, 1.4rem);">Loading payment methods...</p></div>');
            $('#paymentModal').modal('show');

            loadPaymentMethods().then(function(methods) {
                if (!methods || !methods.length) {
                    $('#paymentModalBody').html('<div class="mb-4 mb-lg-5"><div class="alert alert-danger p-3 p-lg-4" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">No payment methods available</div></div><button class="btn btn-secondary btn-lg w-100 py-2 py-lg-3" data-bs-dismiss="modal" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Close</button>');
                    return;
                }
                var html = '<div class="mb-4 mb-lg-5"><div class="alert alert-info p-3 p-lg-4" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);"><strong>Booking:</strong> ' + escapeHtml(booking.booking_reference) + '<br><strong>Amount Due:</strong> <span class="fw-bold text-success" style="font-size: clamp(1.2rem, 2.5vw, 1.8rem);">₱' + amount.toFixed(2) + '</span></div></div><div class="mb-3 mb-lg-4"><label class="form-label fw-bold mb-2 mb-lg-3" style="font-size: clamp(1rem, 1.8vw, 1.4rem);">Select Payment Method</label><div class="list-group" id="paymentMethodList">';
                methods.forEach(function(method) {
                    var methodKey = method.method_key || method.key;
                    var displayName = method.display_name || methodKey;
                    var accountName = method.account_name || '';
                    var icon = methodKey === 'gcash' ? getSvgIcon('credit-card',22) : (methodKey === 'cod' ? getSvgIcon('truck',22) : getSvgIcon('credit-card',22));
                    html += '<div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center payment-method-item p-3 p-lg-4 mb-2 mb-lg-3 rounded-4 shadow-sm" data-method-key="' + escapeHtml(methodKey) + '" data-display-name="' + escapeHtml(displayName) + '" data-account-name="' + escapeHtml(accountName) + '" data-reference-number="' + escapeHtml(method.reference_number || '') + '" data-instructions="' + escapeHtml(method.instructions || '') + '" data-qr-code-url="' + escapeHtml(method.qr_code_url || '') + '" style="cursor: pointer;"><div>' + icon + '<strong class="ms-2 ms-lg-3" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">' + escapeHtml(displayName) + '</strong><div class="small text-muted mt-1" style="font-size: clamp(0.7rem, 1vw, 0.85rem);">' + escapeHtml(accountName) + '</div></div><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="stroke: #6c757d;"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2"/></svg></div>';
                });
                html += '</div></div><div id="methodConfigContainer" class="mt-3 mt-lg-4" style="display: none;"></div>';
                $('#paymentModalBody').html(html);

                $('.payment-method-item').on('click', function() {
                    var methodData = {
                        key: $(this).data('method-key'),
                        display_name: $(this).data('display-name'),
                        account_name: $(this).data('account-name'),
                        reference_number: $(this).data('reference-number'),
                        instructions: $(this).data('instructions'),
                        qr_code_url: $(this).data('qr-code-url')
                    };
                    if (methodData.key === 'cod') {
                        codBookingPending = booking;
                        codAmountPending = amount;
                        $('#paymentModal').modal('hide');
                        $('#codSenderName').val('');
                        $('#codNameModal').modal('show');
                    } else {
                        displayPaymentMethodConfig(methodData, booking, amount);
                    }
                });
            });
        });

        function displayPaymentMethodConfig(method, booking, amount) {
            selectedMethod = method;

            var qrCodeUrl = method.qr_code_url || method.qr_code_url || null;
            var qrHtml = '';
            if (qrCodeUrl && qrCodeUrl !== 'null' && qrCodeUrl !== '') {
                var safeQrUrl = escapeHtml(qrCodeUrl);
                qrHtml = '<div class="mb-3 mb-lg-4 text-center qr-code-container">' +
                    '<label class="form-label fw-bold mb-2 mb-lg-3" style="font-size: clamp(1rem, 1.8vw, 1.4rem);">QR Code</label><br>' +
                    '<img src="' + safeQrUrl + '" alt="QR Code" class="qr-code-image" style="max-width: 100%; max-height: 280px; border-radius: 16px; border: 2px solid #e9ecef; padding: 10px; background: white; object-fit: contain;" onerror="this.onerror=null; this.style.display=\'none\'; this.parentElement.innerHTML=\'<div class=\\\'alert alert-secondary\\\' style=\\\'font-size: clamp(0.85rem, 1.3vw, 1.1rem);\\\'>QR Code not available</div>\'">' +
                    '</div>';
            } else {
                qrHtml = '<div class="mb-3 mb-lg-4 text-center"><div class="alert alert-secondary p-2 p-lg-3" style="font-size: clamp(0.85rem, 1.3vw, 1.1rem);">No QR code available for this payment method.</div></div>';
            }

            var configHtml = '<div class="card border-success mb-3 mb-lg-4 shadow-lg rounded-4"><div class="card-header bg-success text-white p-2 p-lg-4 fw-bold rounded-top-4" style="font-size: clamp(1rem, 1.8vw, 1.4rem);">Payment Details - ' + escapeHtml(method.display_name) + '</div><div class="card-body p-3 p-lg-5">' + qrHtml + 
                '<div class="mb-3 mb-lg-4"><label class="form-label fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Account Name</label><div class="form-control bg-light py-2 py-lg-3" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">' + escapeHtml(method.account_name || 'N/A') + '</div></div>' +
                '<div class="mb-3 mb-lg-4"><label class="form-label fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Reference Number</label><div class="form-control bg-light py-2 py-lg-3" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">' + escapeHtml(method.reference_number || 'N/A') + '</div></div>' +
                '<div class="mb-3 mb-lg-4"><label class="form-label fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Your Name <span class="text-danger">*</span></label><input type="text" class="form-control form-control-lg py-2" id="senderName" placeholder="Enter your full name" required style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);"></div>' +
                '<div class="mb-3 mb-lg-4"><label class="form-label fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Reference Number <span class="text-muted">(Optional)</span></label><input type="text" class="form-control form-control-lg py-2" id="userReferenceNumber" placeholder="Enter your payment reference (optional)" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);"></div>' +
                '<div class="mb-3 mb-lg-4"><label class="form-label fw-bold mb-1 mb-lg-2" style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);">Screenshot Evidence <span class="text-danger">*</span></label><input type="file" class="form-control form-control-lg py-2" id="screenshotInput" accept="image/*" required style="font-size: clamp(0.9rem, 1.5vw, 1.3rem);"><small class="text-muted" style="font-size: clamp(0.7rem, 1vw, 0.85rem);">Upload a screenshot of your payment (max 5MB, JPG/PNG)</small></div>' +
                '<div id="screenshotPreview" class="mb-3 mb-lg-4" style="display: none;"><img id="screenshotPreviewImg" src="#" alt="Screenshot preview" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #ddd; padding: 5px;"></div>' +
                '<div class="alert alert-warning p-2 p-lg-4 mb-3 mb-lg-4" style="font-size: clamp(0.85rem, 1.3vw, 1.1rem);">Amount: <strong>₱' + amount.toFixed(2) + '</strong></div>' +
                '<button class="btn btn-success w-100 py-2 py-lg-4 fw-bold rounded-3" id="submitPaymentRequestBtn" style="font-size: clamp(1rem, 1.8vw, 1.4rem);">Submit Payment</button></div></div>';

            $('#methodConfigContainer').html(configHtml).slideDown(300);

            // Screenshot preview
            $('#screenshotInput').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#screenshotPreviewImg').attr('src', e.target.result);
                        $('#screenshotPreview').show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#screenshotPreview').hide();
                }
            });

            $('#submitPaymentRequestBtn').off('click').on('click', function() {
                var senderName = $('#senderName').val().trim();
                var userRef = $('#userReferenceNumber').val().trim();
                var screenshotFile = $('#screenshotInput')[0].files[0];

                if (!senderName) {
                    showToast('Please enter your full name', 'danger');
                    return;
                }

                if (!screenshotFile) {
                    showToast('Please upload a screenshot of your payment', 'danger');
                    return;
                }

                // Validate file type
                var validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(screenshotFile.type)) {
                    showToast('Please upload a valid image file (JPG, PNG, GIF, WEBP)', 'danger');
                    return;
                }

                // Validate file size (5MB)
                if (screenshotFile.size > 5 * 1024 * 1024) {
                    showToast('File size must be less than 5MB', 'danger');
                    return;
                }

                var formData = new FormData();
                formData.append('payment_method', selectedMethod.key);
                formData.append('amount', amount);
                formData.append('sender_name', senderName.substring(0, 255));
                formData.append('user_reference', userRef || null);
                formData.append('screenshot', screenshotFile);

                var $btn = $(this);
                $btn.prop('disabled', true).html('<div class="spinner-border spinner-border-sm me-2"></div> Submitting...');
                
                $.ajax({
                    url: '/bookings/' + currentBookingId + '/payment-request',
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        showToast(escapeHtml(res.message || 'Payment submitted!'), 'success');
                        $('#paymentModal').modal('hide');
                        loadBookings(false);
                    },
                    error: function(xhr) {
                        var errMsg = xhr.responseJSON?.message || 'Payment failed';
                        showToast(escapeHtml(errMsg), 'danger');
                    },
                    complete: function() { 
                        $btn.prop('disabled', false).html('Submit Payment'); 
                        // Reset file input
                        $('#screenshotInput').val('');
                        $('#screenshotPreview').hide();
                    }
                });
            });
        }

        // COD confirmation
        $('#confirmCodBtn').on('click', function() {
            var senderName = $('#codSenderName').val().trim();
            if (!senderName) {
                showToast('Please enter your full name', 'danger');
                return;
            }
            $('#codNameModal').modal('hide');
            if (codBookingPending && codAmountPending !== null) {
                var payload = {
                    payment_method: 'cod',
                    amount: codAmountPending,
                    reference_number: '',
                    user_reference: 'COD',
                    sender_name: senderName.substring(0, 255),
                    booking_id: codBookingPending.id
                };
                $.ajax({
                    url: '/bookings/' + codBookingPending.id + '/payment-request',
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    data: JSON.stringify(payload),
                    success: function(res) {
                        showToast(escapeHtml(res.message || 'COD confirmed!'), 'success');
                        loadBookings(false);
                    },
                    error: function(xhr) {
                        var errMsg = xhr.responseJSON?.message || 'COD failed';
                        showToast(escapeHtml(errMsg), 'danger');
                    }
                });
                codBookingPending = null;
                codAmountPending = null;
            }
        });

        // Cancel booking
        $('#cancelBookingBtn').on('click', function() {
            if (!currentBookingId) return;
            if (!confirm('Cancel this booking?')) return;
            var $btn = $(this);
            $btn.prop('disabled', true).html('<div class="spinner-border spinner-border-sm me-2"></div>');
            $.ajax({
                url: '/bookings/' + currentBookingId + '/cancel',
                method: 'PUT',
                success: function(res) {
                    showToast(escapeHtml(res.message || 'Cancelled'), 'success');
                    $('#bookingDetailModal').modal('hide');
                    loadBookings(false);
                },
                error: function(xhr) {
                    var errMsg = xhr.responseJSON?.message || 'Cancel failed';
                    showToast(escapeHtml(errMsg), 'danger');
                },
                complete: function() { $btn.prop('disabled', false).html('Cancel Booking'); }
            });
        });

        // Edit from detail
        $('#editFromDetailBtn').on('click', function() {
            if (currentBookingId) {
                $('#bookingDetailModal').modal('hide');
                $('.edit-booking[data-id="' + currentBookingId + '"]').click();
            }
        });

        // Pagination
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            var p = $(this).data('page');
            if (p && p !== currentPage && p >= 1) {
                currentPage = p;
                renderBookings();
            }
        });

        // Refresh button
        $('#refreshBookingsBtn').on('click', function() {
            loadBookings(false);
            showToast('Refreshing bookings...', 'info');
        });

        // Modal cleanup
        $('#editBookingModal').on('hidden.bs.modal', function() {
            $('#editBookingBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div></div>');
        });
        $('#paymentModal').on('hidden.bs.modal', function() {
            selectedMethod = null;
            $('#methodConfigContainer').empty().hide();
            $('#screenshotInput').val('');
            $('#screenshotPreview').hide();
        });

        // Visibility change
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') loadBookings(true, true);
        });
    });
})();
</script>
@endpush

@push('styles')
<style nonce="{{ $csp_nonce }}">
/* ============================================================
   BOOKING PAGE
   ============================================================ */

:root {
    --font-xs: 0.75rem;
    --font-sm: 0.875rem;
    --font-base: 1rem;
    --font-md: 1.125rem;
    --font-lg: 1.25rem;
    --font-xl: 1.5rem;
    --font-xxl: 1.75rem;
    --sp-xs: 0.25rem;
    --sp-sm: 0.5rem;
    --sp-md: 1rem;
    --sp-lg: 1.5rem;
    --sp-xl: 2rem;
}

/* ============================================================
   STATUS TABS
   ============================================================ */
.status-tabs-wrapper {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
    gap: 0.5rem !important;
    padding-bottom: 0.5rem !important;
    scrollbar-width: thin !important;
    scroll-snap-type: x mandatory !important;
    width: 100% !important;
}

.status-tab {
    flex: 0 0 auto !important;
    scroll-snap-align: start !important;
    white-space: nowrap !important;
    font-weight: 600 !important;
    font-size: var(--font-sm) !important;
    border-radius: 60px !important;
    transition: all 0.2s ease !important;
    background: transparent !important;
    border: 1px solid #d4dce6 !important;
    color: #1e2a3e !important;
    cursor: pointer !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.4rem !important;
    box-shadow: none !important;
    text-decoration: none !important;
    padding: 0.4rem 1rem !important;
    min-height: 38px !important;
}

.status-tab svg {
    stroke: #0d6efd !important;
    flex-shrink: 0 !important;
    width: 18px !important;
    height: 18px !important;
}

.status-tab.active {
    background-color: #0d6efd !important;
    color: white !important;
    border-color: #0d6efd !important;
}
.status-tab.active svg {
    stroke: white !important;
}

.status-tab .status-count-badge {
    background-color: rgba(0,0,0,0.08) !important;
    border-radius: 40px !important;
    padding: 0.1rem 0.5rem !important;
    font-weight: 600 !important;
    margin-left: 0.15rem !important;
    font-size: var(--font-xs) !important;
}

.status-tabs-wrapper::-webkit-scrollbar {
    height: 4px !important;
}
.status-tabs-wrapper::-webkit-scrollbar-track {
    background: #e2e8f0 !important;
    border-radius: 10px !important;
}
.status-tabs-wrapper::-webkit-scrollbar-thumb {
    background: #94a3b8 !important;
    border-radius: 10px !important;
}

/* ============================================================
   BOOKING CARDS
   ============================================================ */
.booking-card {
    transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1), box-shadow 0.3s ease !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    background: white !important;
    animation: fadeInUp 0.4s ease-out !important;
    border-radius: 1.25rem !important;
    overflow: hidden !important;
    height: 100% !important;
}

.booking-card:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 16px 24px rgba(0,0,0,0.08) !important;
    border-color: rgba(13, 110, 253, 0.2) !important;
}

.booking-card .card-body {
    padding: var(--sp-md) !important;
}

.booking-ref {
    font-size: var(--font-base) !important;
    font-weight: 600 !important;
}

.booking-detail {
    font-size: var(--font-sm) !important;
    color: #6b7280 !important;
}

.booking-actions .btn {
    font-size: var(--font-sm) !important;
    padding: 0.3rem 0.6rem !important;
    min-height: 34px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.3rem !important;
}

.booking-actions .btn svg {
    width: 16px !important;
    height: 16px !important;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

.sticky-top-custom {
    position: sticky !important;
    top: 20px !important;
    z-index: 1 !important;
}

.icon-inline {
    display: inline-block !important;
    vertical-align: middle !important;
}

/* ============================================================
   PAGINATION
   ============================================================ */
.pagination-wrapper {
    background: transparent !important;
}

.input-group-lg .form-control,
.input-group-lg .input-group-text {
    font-size: var(--font-base) !important;
    padding: 0.4rem 0.8rem !important;
}
.input-group-lg .form-control {
    height: auto !important;
    min-height: 42px !important;
}

.page-link {
    font-size: var(--font-sm) !important;
    padding: 0.3rem 0.6rem !important;
    min-height: 32px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

#paginationInfo {
    font-size: var(--font-sm) !important;
}

/* ============================================================
   PAYMENT MODAL - QR CODE RESPONSIVE FIXES
   ============================================================ */

#paymentModal .modal-body,
.payment-modal .modal-body,
.modal-content .modal-body {
    overflow: visible !important;
}

#paymentModal .modal-body .text-center,
.payment-modal .modal-body .text-center,
.modal-body .text-center {
    overflow: hidden !important;
    max-width: 100% !important;
}

#paymentModal .qr-code-container,
.payment-modal .qr-code-container,
.modal-content .qr-code-container,
#paymentModal .qr-wrapper,
.payment-modal .qr-wrapper,
div[class*="qr"] {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    width: 100% !important;
    max-width: 100% !important;
    overflow: hidden !important;
    padding: 0.5rem !important;
    margin: 0 auto !important;
}

#paymentModal img[src*="qr"],
#paymentModal img[src*="QR"],
.payment-modal img[src*="qr"],
.payment-modal img[src*="QR"],
.modal-content img[src*="qr"],
.modal-content img[src*="QR"],
#paymentModal .qr-code-image,
.payment-modal .qr-code-image,
.qr-payment-image,
#qrPaymentImage,
img.qr-code,
img#qrCode,
img[alt*="QR"],
img[alt*="qr"] {
    max-width: 100% !important;
    width: auto !important;
    height: auto !important;
    max-height: 320px !important;
    object-fit: contain !important;
    display: block !important;
    margin: 0 auto !important;
    padding: 0 !important;
    border: none !important;
    background: transparent !important;
}

#paymentModal .modal-body img,
.payment-modal .modal-body img,
.modal-body img {
    max-width: 100% !important;
    height: auto !important;
    max-height: 320px !important;
    object-fit: contain !important;
    display: block !important;
    margin: 0 auto !important;
}

#paymentModal .modal-dialog {
    max-width: 500px !important;
    margin: 1.75rem auto !important;
}

#paymentModal .modal-content {
    overflow: hidden !important;
    border-radius: 1rem !important;
}

#paymentModal .modal-body {
    padding: var(--sp-lg) !important;
    overflow: hidden !important;
}

#paymentModal .modal-body .row,
#paymentModal .modal-body .col-12,
#paymentModal .modal-body .col-md-6 {
    overflow: hidden !important;
    max-width: 100% !important;
}

#paymentModal .payment-details,
.payment-modal .payment-details,
div[class*="payment"] {
    overflow: hidden !important;
    word-wrap: break-word !important;
}

/* Screenshot preview styling */
#screenshotPreviewImg {
    max-width: 100% !important;
    max-height: 200px !important;
    border-radius: 8px !important;
    border: 2px solid #28a745 !important;
    padding: 5px !important;
}

/* ============================================================
   MODAL TYPOGRAPHY
   ============================================================ */
.modal-header .modal-title {
    font-size: var(--font-lg) !important;
    font-weight: 700 !important;
}

.modal-header .modal-title svg {
    width: 24px !important;
    height: 24px !important;
    margin-right: 8px !important;
}

.modal-footer .btn {
    font-size: var(--font-base) !important;
    padding: 0.4rem 1rem !important;
    min-height: 38px !important;
}

.form-control-lg {
    font-size: var(--font-base) !important;
    padding: 0.4rem 0.8rem !important;
}

.card-header h3 {
    font-size: var(--font-lg) !important;
    font-weight: 700 !important;
}

.card-header h3 svg {
    width: 20px !important;
    height: 20px !important;
}

#refreshBookingsBtn {
    font-size: var(--font-sm) !important;
    padding: 0.3rem 0.8rem !important;
    min-height: 34px !important;
}

#refreshBookingsBtn svg {
    width: 16px !important;
    height: 16px !important;
}

/* ============================================================
   RESPONSIVE BREAKPOINTS
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
        --sp-xs: 0.25rem;
        --sp-sm: 0.5rem;
        --sp-md: 0.9rem;
        --sp-lg: 1.3rem;
        --sp-xl: 1.7rem;
    }

    .status-tab {
        font-size: var(--font-sm) !important;
        padding: 0.35rem 0.9rem !important;
    }

    .booking-ref {
        font-size: var(--font-base) !important;
    }

    .booking-detail {
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
        --sp-xs: 0.2rem;
        --sp-sm: 0.4rem;
        --sp-md: 0.8rem;
        --sp-lg: 1.2rem;
        --sp-xl: 1.5rem;
    }

    #paymentModal img[src*="qr"],
    #paymentModal img[src*="QR"],
    .payment-modal img[src*="qr"],
    .payment-modal img[src*="QR"],
    .modal-content img[src*="qr"],
    .modal-content img[src*="QR"],
    #paymentModal .qr-code-image,
    .payment-modal .qr-code-image,
    .qr-payment-image,
    #qrPaymentImage,
    #paymentModal .modal-body img,
    .payment-modal .modal-body img,
    .modal-body img {
        max-height: 260px !important;
    }

    #paymentModal .modal-body {
        padding: var(--sp-md) !important;
    }

    #paymentModal .qr-code-container,
    .payment-modal .qr-code-container,
    .modal-content .qr-code-container {
        padding: 0.25rem !important;
    }

    .status-tab {
        font-size: var(--font-sm) !important;
        padding: 0.3rem 0.8rem !important;
        min-height: 34px !important;
    }

    .status-tab svg {
        width: 16px !important;
        height: 16px !important;
    }

    .booking-card .card-body {
        padding: var(--sp-sm) !important;
    }

    .booking-ref {
        font-size: var(--font-base) !important;
    }

    .booking-detail {
        font-size: var(--font-sm) !important;
    }

    .booking-actions .btn {
        font-size: var(--font-sm) !important;
        padding: 0.25rem 0.5rem !important;
        min-height: 32px !important;
    }

    .booking-actions .btn svg {
        width: 14px !important;
        height: 14px !important;
    }

    .page-link {
        font-size: var(--font-sm) !important;
        padding: 0.25rem 0.5rem !important;
        min-height: 30px !important;
    }

    #paginationInfo {
        font-size: var(--font-sm) !important;
    }

    .modal-header .modal-title {
        font-size: var(--font-md) !important;
    }

    .modal-header .modal-title svg {
        width: 20px !important;
        height: 20px !important;
        margin-right: 6px !important;
    }

    .modal-footer .btn {
        font-size: var(--font-sm) !important;
        padding: 0.3rem 0.8rem !important;
        min-height: 34px !important;
    }

    .form-control-lg {
        font-size: var(--font-sm) !important;
        padding: 0.3rem 0.6rem !important;
    }

    .input-group-lg .form-control,
    .input-group-lg .input-group-text {
        font-size: var(--font-sm) !important;
        padding: 0.3rem 0.5rem !important;
        min-height: 36px !important;
    }

    .card-header h3 {
        font-size: var(--font-md) !important;
    }

    .card-header h3 svg {
        width: 18px !important;
        height: 18px !important;
    }

    #refreshBookingsBtn {
        font-size: var(--font-sm) !important;
        padding: 0.25rem 0.6rem !important;
        min-height: 32px !important;
    }

    #refreshBookingsBtn svg {
        width: 14px !important;
        height: 14px !important;
    }

    .status-tabs-wrapper {
        gap: 0.4rem !important;
        padding-bottom: 0.3rem !important;
    }

    .modal-dialog {
        margin: 0.5rem !important;
    }

    .modal-content {
        border-radius: 0.8rem !important;
    }

    .booking-card {
        border-radius: 0.8rem !important;
    }

    .sticky-top-custom {
        position: relative !important;
        top: 0 !important;
    }

    .pagination-wrapper {
        flex-direction: column !important;
        align-items: center !important;
        gap: 0.5rem !important;
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
        --sp-xs: 0.15rem;
        --sp-sm: 0.3rem;
        --sp-md: 0.6rem;
        --sp-lg: 1rem;
        --sp-xl: 1.2rem;
    }

    #paymentModal img[src*="qr"],
    #paymentModal img[src*="QR"],
    .payment-modal img[src*="qr"],
    .payment-modal img[src*="QR"],
    .modal-content img[src*="qr"],
    .modal-content img[src*="QR"],
    #paymentModal .qr-code-image,
    .payment-modal .qr-code-image,
    .qr-payment-image,
    #qrPaymentImage,
    #paymentModal .modal-body img,
    .payment-modal .modal-body img,
    .modal-body img {
        max-height: 220px !important;
        width: 80% !important;
    }

    #paymentModal .modal-body {
        padding: var(--sp-sm) !important;
    }

    #paymentModal .modal-dialog {
        margin: 0.5rem !important;
        max-width: 95% !important;
    }

    #paymentModal .qr-code-container,
    .payment-modal .qr-code-container,
    .modal-content .qr-code-container {
        padding: 0.15rem !important;
    }

    .status-tab {
        font-size: var(--font-sm) !important;
        padding: 0.25rem 0.6rem !important;
        min-height: 30px !important;
        gap: 0.25rem !important;
    }

    .status-tab svg {
        width: 14px !important;
        height: 14px !important;
    }

    .status-tab .status-count-badge {
        font-size: var(--font-xs) !important;
        padding: 0.05rem 0.35rem !important;
    }

    .booking-card .card-body {
        padding: var(--sp-sm) !important;
    }

    .booking-ref {
        font-size: var(--font-sm) !important;
    }

    .booking-detail {
        font-size: var(--font-xs) !important;
    }

    .booking-actions .btn {
        font-size: var(--font-xs) !important;
        padding: 0.2rem 0.4rem !important;
        min-height: 28px !important;
    }

    .booking-actions .btn svg {
        width: 12px !important;
        height: 12px !important;
    }

    .page-link {
        font-size: var(--font-xs) !important;
        padding: 0.2rem 0.4rem !important;
        min-height: 28px !important;
    }

    #paginationInfo {
        font-size: var(--font-xs) !important;
    }

    .modal-header .modal-title {
        font-size: var(--font-sm) !important;
    }

    .modal-header .modal-title svg {
        width: 18px !important;
        height: 18px !important;
        margin-right: 4px !important;
    }

    .modal-footer .btn {
        font-size: var(--font-sm) !important;
        padding: 0.25rem 0.6rem !important;
        min-height: 30px !important;
    }

    .form-control-lg {
        font-size: var(--font-sm) !important;
        padding: 0.25rem 0.5rem !important;
    }

    .input-group-lg .form-control,
    .input-group-lg .input-group-text {
        font-size: var(--font-sm) !important;
        padding: 0.25rem 0.4rem !important;
        min-height: 32px !important;
    }

    .card-header h3 {
        font-size: var(--font-sm) !important;
    }

    .card-header h3 svg {
        width: 16px !important;
        height: 16px !important;
    }

    #refreshBookingsBtn {
        font-size: var(--font-xs) !important;
        padding: 0.2rem 0.5rem !important;
        min-height: 28px !important;
    }

    #refreshBookingsBtn svg {
        width: 12px !important;
        height: 12px !important;
    }

    .status-tabs-wrapper {
        gap: 0.3rem !important;
        padding-bottom: 0.3rem !important;
    }

    .modal-dialog {
        margin: 0.3rem !important;
    }

    .modal-content {
        border-radius: 0.8rem !important;
    }

    .booking-card {
        border-radius: 0.8rem !important;
    }

    .sticky-top-custom {
        position: relative !important;
        top: 0 !important;
    }

    .pagination-wrapper {
        flex-direction: column !important;
        align-items: center !important;
        gap: 0.5rem !important;
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
        --sp-xs: 0.1rem;
        --sp-sm: 0.25rem;
        --sp-md: 0.5rem;
        --sp-lg: 0.8rem;
        --sp-xl: 1rem;
    }

    #paymentModal img[src*="qr"],
    #paymentModal img[src*="QR"],
    .payment-modal img[src*="qr"],
    .payment-modal img[src*="QR"],
    .modal-content img[src*="qr"],
    .modal-content img[src*="QR"],
    #paymentModal .qr-code-image,
    .payment-modal .qr-code-image,
    .qr-payment-image,
    #qrPaymentImage,
    #paymentModal .modal-body img,
    .payment-modal .modal-body img,
    .modal-body img {
        max-height: 170px !important;
        width: 75% !important;
    }

    #paymentModal .modal-body {
        padding: var(--sp-xs) !important;
    }

    #paymentModal .modal-dialog {
        margin: 0.25rem !important;
        max-width: 98% !important;
    }

    #paymentModal .modal-content {
        border-radius: 0.5rem !important;
    }

    .status-tab {
        padding: 0.2rem 0.5rem !important;
        font-size: var(--font-xs) !important;
        min-height: 26px !important;
        gap: 0.2rem !important;
    }

    .status-tab svg {
        width: 12px !important;
        height: 12px !important;
    }

    .status-tab .status-count-badge {
        font-size: 0.5rem !important;
        padding: 0.05rem 0.3rem !important;
    }

    .booking-card .card-body {
        padding: var(--sp-xs) !important;
    }

    .booking-ref {
        font-size: var(--font-xs) !important;
    }

    .booking-detail {
        font-size: 0.6rem !important;
    }

    .booking-actions .btn {
        font-size: 0.6rem !important;
        padding: 0.15rem 0.3rem !important;
        min-height: 24px !important;
    }

    .booking-actions .btn svg {
        width: 10px !important;
        height: 10px !important;
    }

    .page-link {
        font-size: 0.6rem !important;
        padding: 0.15rem 0.3rem !important;
        min-height: 24px !important;
    }

    #paginationInfo {
        font-size: 0.6rem !important;
    }

    .modal-header .modal-title {
        font-size: var(--font-xs) !important;
    }

    .modal-header .modal-title svg {
        width: 16px !important;
        height: 16px !important;
        margin-right: 4px !important;
    }

    .modal-footer .btn {
        font-size: var(--font-xs) !important;
        padding: 0.2rem 0.5rem !important;
        min-height: 26px !important;
    }

    .form-control-lg {
        font-size: var(--font-xs) !important;
        padding: 0.2rem 0.4rem !important;
    }

    .input-group-lg .form-control,
    .input-group-lg .input-group-text {
        font-size: var(--font-xs) !important;
        padding: 0.2rem 0.35rem !important;
        min-height: 28px !important;
    }

    .card-header h3 {
        font-size: var(--font-xs) !important;
    }

    .card-header h3 svg {
        width: 14px !important;
        height: 14px !important;
    }

    #refreshBookingsBtn {
        font-size: 0.6rem !important;
        padding: 0.15rem 0.4rem !important;
        min-height: 24px !important;
    }

    #refreshBookingsBtn svg {
        width: 10px !important;
        height: 10px !important;
    }

    .status-tabs-wrapper {
        gap: 0.25rem !important;
        padding-bottom: 0.25rem !important;
    }

    .modal-dialog {
        margin: 0.15rem !important;
    }

    .modal-content {
        border-radius: 0.5rem !important;
    }

    .booking-card {
        border-radius: 0.5rem !important;
    }
}

/* --- Extra Small (≤ 350px) --- */
@media (max-width: 350px) {
    #paymentModal img[src*="qr"],
    #paymentModal img[src*="QR"],
    .payment-modal img[src*="qr"],
    .payment-modal img[src*="QR"],
    .modal-content img[src*="qr"],
    .modal-content img[src*="QR"],
    #paymentModal .qr-code-image,
    .payment-modal .qr-code-image,
    .qr-payment-image,
    #qrPaymentImage,
    #paymentModal .modal-body img,
    .payment-modal .modal-body img,
    .modal-body img {
        max-height: 130px !important;
        width: 65% !important;
    }

    #paymentModal .modal-body {
        padding: 0.2rem !important;
    }

    #paymentModal .modal-dialog {
        margin: 0.1rem !important;
        max-width: 100% !important;
    }

    .status-tab {
        padding: 0.15rem 0.35rem !important;
        font-size: 0.5rem !important;
        min-height: 22px !important;
    }

    .status-tab svg {
        width: 10px !important;
        height: 10px !important;
    }

    .status-tab .status-count-badge {
        font-size: 0.45rem !important;
        padding: 0.05rem 0.2rem !important;
    }

    .booking-card .card-body {
        padding: 0.2rem !important;
    }

    .booking-ref {
        font-size: 0.55rem !important;
    }

    .booking-detail {
        font-size: 0.5rem !important;
    }

    .booking-actions .btn {
        font-size: 0.5rem !important;
        padding: 0.1rem 0.2rem !important;
        min-height: 20px !important;
    }

    .booking-actions .btn svg {
        width: 8px !important;
        height: 8px !important;
    }

    .page-link {
        font-size: 0.5rem !important;
        padding: 0.1rem 0.25rem !important;
        min-height: 20px !important;
    }

    #paginationInfo {
        font-size: 0.5rem !important;
    }

    .modal-footer .btn {
        font-size: 0.5rem !important;
        padding: 0.15rem 0.35rem !important;
        min-height: 22px !important;
    }

    .form-control-lg {
        font-size: 0.5rem !important;
        padding: 0.15rem 0.3rem !important;
    }
}

/* ============================================================
   HIDDEN AUDIO
   ============================================================ */
#clickAudio {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
    user-select: none;
}

/* Screenshot upload styles */
#screenshotInput {
    padding: 0.5rem !important;
}

#screenshotPreview {
    border: 2px dashed #28a745;
    border-radius: 8px;
    padding: 10px;
    background: #f8fff8;
}
</style>
@endpush