{{-- dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-5">
    {{-- Hero section (visible by default) --}}
    <div id="heroSection" class="text-center mb-5">
        <h1 class="display-4 fw-black gradient-text" style="font-size: 1.5rem; font-weight: 900; padding-bottom:-20px;">SureCargo Transport</h1>
        <p class="lead text-muted fs-5" style="font-size:1rem !important;">Select a truck and book your egg trays — fast & reliable</p>
    </div>

    <!-- Filters Centered – now using .filter-chip-group with no wrap and hidden scrollbar -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="filter-chip-group">
                <button class="filter-chip active" data-filter="all">All Trucks</button>
                <button class="filter-chip" data-filter="available">Available</button>
                <button class="filter-chip" data-filter="booked">Booked</button>
                <button class="filter-chip" data-filter="maintenance">Maintenance</button>
            </div>
        </div>
    </div>

    <!-- Trucks Grid Centered -->
    <div class="row g-4 justify-content-center" id="trucksContainer">
        <div class="col-12 text-center py-5">
            <div class="loading-spinner"></div>
            <p class="mt-3 text-muted fs-5">Loading trucks...</p>
        </div>
    </div>
</div>

{{-- Guidelines Modal --}}
<div class="modal fade guidelines-modal" id="guidelinesModal" tabindex="-1" aria-labelledby="guidelinesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fs-3 fw-bold" id="guidelinesModalLabel">
                    <i class="fas fa-info-circle me-2"></i>Booking Guidelines
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 p-lg-5">
                <ul class="guidelines-list">
                    <li><i class="fas fa-clock"></i> <strong>Booking Hours:</strong> Saturday 8:00 AM to Sunday 10:00 AM only.</li>
                    <li><i class="fas fa-exclamation-triangle"></i> <strong>Wrong Booking Requests:</strong> Please double-check all details (truck, quantity, drop location) before confirming. Incorrect bookings may incur additional fees or delays.</li>
                    <li><i class="fas fa-credit-card"></i> <strong>Payment:</strong> Payment COD (Cash on delivery) or digital payments is accepted.</li>
                    <li><i class="fas fa-undo-alt"></i> <strong>Cancellation Policy:</strong> Cancellations are only allowed while the booking status is "pending". Once confirmed or in transit, cancellation is not possible.</li>
                    <li><i class="fas fa-truck"></i> <strong>Truck Availability:</strong> Trucks shown as "Available" are ready for booking. "Booked" or "Maintenance" trucks cannot be selected.</li>
                    <li><i class="fas fa-truck"></i> <strong>Tracking:</strong> In-transit bookings have button track for real-time location updates.When delivered button vanishes.</li>
                    <li><i class="fas fa-envelope"></i> <strong>Support:</strong> For urgent issues, contact support@surecargo.com or call (63+)9482106844.</li>
                </ul>
                <div class="alert alert-info mt-4 d-flex align-items-center gap-3">
                    <i class="fas fa-mobile-alt fs-3"></i>
                    <div>Make sure your contact number is and receiver number are verified and not sim-dead.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script nonce="{{ $csp_nonce }}">
    $(document).ready(function() {
        // Load trucks if on dashboard
        if (window.location.pathname === '/dashboard') {
            if (typeof window.loadTrucks === 'function') {
                window.loadTrucks();
            }
        }

        // ---- CREATE FIXED ICONS DIRECTLY IN BODY (bypass layout issues) ----
        function createFixedIcons() {
            const iconsContainer = document.createElement('div');
            iconsContainer.id = 'fixedActionIcons';
            iconsContainer.style.cssText = `
                position: fixed !important;
                right: 20px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                z-index: 99999 !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 20px !important;
                align-items: center !important;
                justify-content: center !important;
                pointer-events: auto !important;
            `;

            // Eye icon (toggle hero)
            const eyeDiv = document.createElement('div');
            eyeDiv.className = 'icon-circle';
            eyeDiv.id = 'toggleHeroEye';
            eyeDiv.title = 'Toggle Hero Section';
            eyeDiv.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#0d6efd" width="30" height="30">
                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
            </svg>`;

            // Guidelines icon (shake + modal trigger)
            const guideDiv = document.createElement('div');
            guideDiv.className = 'icon-circle shake-every-3s';
            guideDiv.id = 'guidelinesIconWrapper';
            guideDiv.setAttribute('data-bs-toggle', 'modal');
            guideDiv.setAttribute('data-bs-target', '#guidelinesModal');
            guideDiv.title = 'Booking Guidelines';
            guideDiv.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#0d6efd" width="30" height="30">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/>
            </svg>`;

            iconsContainer.appendChild(eyeDiv);
            iconsContainer.appendChild(guideDiv);
            document.body.appendChild(iconsContainer);

            return { eyeDiv, guideDiv };
        }

        const icons = createFixedIcons();
        const eyeIcon = $(icons.eyeDiv);
        const heroSection = $('#heroSection');
        let vanishTimer = null;

        function startAutoVanishTimer() {
            if (vanishTimer) clearTimeout(vanishTimer);
            vanishTimer = setTimeout(function() {
                if (heroSection.is(':visible')) {
                    heroSection.fadeOut(400);
                }
            }, 10000);
        }

        startAutoVanishTimer();

        // Toggle hero on eye icon click
        eyeIcon.on('click', function() {
            if (heroSection.is(':visible')) {
                heroSection.fadeOut(400);
                if (vanishTimer) clearTimeout(vanishTimer);
            } else {
                heroSection.fadeIn(400);
                startAutoVanishTimer();
            }
        });
    });
</script>
@endpush