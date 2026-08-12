@extends('layouts.app')

@section('title', 'Live Truck Tracking')

@section('content')
<style nonce="{{ $csp_nonce }}">
    #routeMap {
        height: 550px;
        width: 100%;
        border-radius: 24px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        margin-bottom: 24px;
        z-index: 1;
    }
    .status-badge {
        background: #10B981;
        color: white;
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        animation: pulse 1.5s ease-in-out infinite;
    }
    @keyframes pulse {
        0% { opacity: 0.7; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.05); }
        100% { opacity: 0.7; transform: scale(1); }
    }
    .status-badge i {
        font-size: 10px;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .page-header h2 {
        margin: 0;
        font-weight: 800;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="page-header">
        <h2 class="fw-bold"><i class="fas fa-truck me-2 text-danger"></i>Live Tracking</h2>
        <div>
            <span class="status-badge">
                <i class="fas fa-circle"></i> Live Tracking
            </span>
        </div>
    </div>

    <div id="routeMap"></div>
</div>

<!-- Leaflet CSS (CDN allowed by CSP) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<!-- Font Awesome (already allowed) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js" nonce="{{ $csp_nonce }}"></script>

<script nonce="{{ $csp_nonce }}">
    let map, truckMarker, pollingInterval;

    function initMap() {
        map = L.map('routeMap').setView([11.1302, 123.9526], 10);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> contributors'
        }).addTo(map);

        const truckIcon = L.divIcon({
            html: '<i class="fas fa-truck" style="font-size: 28px; color: #DC2626; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></i>',
            iconSize: [30, 30],
            className: 'truck-icon'
        });
        truckMarker = L.marker([11.1302, 123.9526], { icon: truckIcon }).addTo(map);
        const tooltipDiv = document.createElement('div');
        tooltipDiv.style.background = '#1a1a2e';
        tooltipDiv.style.color = 'white';
        tooltipDiv.style.padding = '4px 10px';
        tooltipDiv.style.borderRadius = '20px';
        tooltipDiv.style.fontSize = '12px';
        tooltipDiv.style.fontWeight = 'bold';
        tooltipDiv.style.whiteSpace = 'nowrap';
        tooltipDiv.innerHTML = 'Live';
        truckMarker.bindTooltip(tooltipDiv, { permanent: true, direction: 'top', offset: [0, -15] });
    }

    function startPolling() {
        if (pollingInterval) clearInterval(pollingInterval);
        pollingInterval = setInterval(async () => {
            try {
                const response = await fetch('/tracking/latest');
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                const data = await response.json();
                // Safely parse lat/lng as floats
                const lat = parseFloat(data?.lat);
                const lng = parseFloat(data?.lng);
                if (!isNaN(lat) && !isNaN(lng)) {
                    truckMarker.setLatLng([lat, lng]);
                    map.panTo([lat, lng]);
                    truckMarker.setTooltipContent(`📍 ${lat.toFixed(4)}, ${lng.toFixed(4)}`);
                } else {
                    console.warn('Invalid coordinates received:', data);
                }
            } catch (err) {
                console.warn('Polling failed:', err);
            }
        }, 2000);
    }

    // Clean up interval when leaving the page
    window.addEventListener('beforeunload', function () {
        if (pollingInterval) clearInterval(pollingInterval);
    });

    window.addEventListener('load', () => {
        initMap();
        startPolling();
    });
</script>
@endsection
