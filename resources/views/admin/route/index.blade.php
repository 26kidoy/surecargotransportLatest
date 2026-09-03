@extends('admin.layouts.app')

@section('title', 'Live Truck Tracking')

@section('content')
<style nonce="{{ $csp_nonce }}">
    /* ============================================================
       LIVE TRUCK TRACKING - FULL SCREEN MAP
       FIXED: NO API KEY REQUIRED, FULL SPACE ON ALL DEVICES
    ============================================================ */
    
    /* Reset & Full Height - OCCUPY FULL SPACE */
    html, body {
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        width: 100% !important;
    }

    .tracking-wrapper {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        z-index: 1 !important;
        background: #0a0f1f !important;
    }

    /* Header - Overlay on top of map */
    .tracking-header {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 1000 !important;
        padding: 16px 24px !important;
        background: linear-gradient(180deg, rgba(10, 15, 31, 0.92) 0%, rgba(10, 15, 31, 0.4) 70%, transparent 100%) !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        pointer-events: none !important;
    }

    .tracking-header > * {
        pointer-events: auto !important;
    }

    .tracking-header h2 {
        margin: 0 !important;
        font-weight: 800 !important;
        color: white !important;
        font-size: clamp(1rem, 2.5vw, 1.8rem) !important;
        text-shadow: 0 2px 8px rgba(0,0,0,0.5) !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
    }

    .tracking-header h2 i {
        color: #ef4444 !important;
        font-size: clamp(0.9rem, 2vw, 1.4rem) !important;
    }

    .status-badge {
        background: rgba(16, 185, 129, 0.9) !important;
        backdrop-filter: blur(8px) !important;
        color: white !important;
        padding: 6px 16px !important;
        border-radius: 50px !important;
        font-weight: 700 !important;
        font-size: clamp(0.7rem, 1.2vw, 0.95rem) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
        border: 1px solid rgba(255,255,255,0.15) !important;
    }

    .status-badge .pulse-dot {
        display: inline-block !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 50% !important;
        background: #10B981 !important;
        animation: pulse-dot 1.5s ease-in-out infinite !important;
    }

    @keyframes pulse-dot {
        0% { opacity: 0.6; transform: scale(0.9); }
        50% { opacity: 1; transform: scale(1.3); }
        100% { opacity: 0.6; transform: scale(0.9); }
    }

    /* Map Container - Full Space */
    #routeMap {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100% !important;
        height: 100% !important;
        z-index: 1 !important;
        background: #1a1a2e !important;
    }

    /* Truck Icon Fix */
    .truck-icon {
        filter: drop-shadow(0 4px 8px rgba(220, 38, 38, 0.5)) !important;
        transition: all 0.3s ease !important;
    }

    .truck-icon i {
        font-size: 32px !important;
        color: #DC2626 !important;
        text-shadow: 0 0 20px rgba(220, 38, 38, 0.3) !important;
    }

    /* Leaflet Custom Styles */
    .leaflet-popup-content {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        font-size: 14px !important;
        min-width: 150px !important;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 12px !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2) !important;
    }

    .leaflet-tooltip {
        background: rgba(26, 26, 46, 0.9) !important;
        backdrop-filter: blur(8px) !important;
        color: white !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 20px !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        padding: 4px 14px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
    }

    .leaflet-tooltip::before {
        border-top-color: rgba(26, 26, 46, 0.9) !important;
    }

    /* ============================================================
       PERSISTENT LOCATION POPUP - BOTTOM MIDDLE
       TRANSPARENT BACKGROUND, FLEX ROW, CLICKABLE
    ============================================================ */
    .location-flash-popup {
        position: fixed !important;
        bottom: 30px !important;
        left: 50% !important;
        transform: translateX(-50%) translateY(20px) !important;
        background: rgba(26, 35, 50, 0.85) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        color: white !important;
        padding: 12px 20px !important;
        border-radius: 16px !important;
        box-shadow: 0 8px 32px rgba(0,0,0,0.5) !important;
        z-index: 99999 !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        min-width: 280px !important;
        max-width: 95% !important;
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 12px !important;
        flex-wrap: wrap !important;
        pointer-events: auto !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        opacity: 0 !important;
        user-select: none !important;
    }

    .location-flash-popup:hover {
        background: rgba(26, 35, 50, 0.95) !important;
        border-color: rgba(59, 130, 246, 0.3) !important;
        transform: translateX(-50%) translateY(-2px) !important;
        box-shadow: 0 12px 48px rgba(0,0,0,0.7) !important;
    }

    .location-flash-popup.show {
        opacity: 1 !important;
        transform: translateX(-50%) translateY(0) !important;
        pointer-events: auto !important;
        animation: popupFadeUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards !important;
    }

    @keyframes popupFadeUp {
        0% { opacity: 0; transform: translateX(-50%) translateY(20px); }
        100% { opacity: 1; transform: translateX(-50%) translateY(0); }
    }

    .location-flash-popup .popup-item {
        display: flex !important;
        align-items: center !important;
        gap: 4px !important;
        font-size: 0.85rem !important;
        white-space: nowrap !important;
    }

    .location-flash-popup .popup-item .label {
        color: rgba(255,255,255,0.5) !important;
        font-size: 0.6rem !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    .location-flash-popup .popup-item .value {
        font-weight: 700 !important;
        font-family: 'Courier New', monospace !important;
        font-size: 0.85rem !important;
    }

    .location-flash-popup .popup-item .value.lat {
        color: #f472b6 !important;
    }

    .location-flash-popup .popup-item .value.lng {
        color: #60a5fa !important;
    }

    .location-flash-popup .popup-item .value.accuracy {
        color: #34d399 !important;
    }

    .location-flash-popup .popup-item .value.time {
        color: #fbbf24 !important;
    }

    .location-flash-popup .popup-divider {
        width: 1px !important;
        height: 24px !important;
        background: rgba(255,255,255,0.1) !important;
        flex-shrink: 0 !important;
    }

    .location-flash-popup .popup-icon-small {
        font-size: 0.7rem !important;
        margin-right: 2px !important;
        opacity: 0.6 !important;
    }

    .location-flash-popup .popup-click-hint {
        font-size: 0.55rem !important;
        color: rgba(255,255,255,0.3) !important;
        margin-left: 4px !important;
        animation: pulse-hint 2s ease-in-out infinite !important;
    }

    @keyframes pulse-hint {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 0.7; }
    }

    /* ============================================================
       LOGS MODAL
    ============================================================ */
    .logs-modal-overlay {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background: rgba(0,0,0,0.7) !important;
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
        z-index: 100000 !important;
        display: none !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 20px !important;
        animation: modalOverlayIn 0.3s ease !important;
    }

    .logs-modal-overlay.active {
        display: flex !important;
    }

    @keyframes modalOverlayIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    .logs-modal {
        background: #1a2332 !important;
        border-radius: 24px !important;
        max-width: 600px !important;
        width: 100% !important;
        max-height: 80vh !important;
        box-shadow: 0 24px 80px rgba(0,0,0,0.8) !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
        display: flex !important;
        flex-direction: column !important;
        animation: modalSlideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        overflow: hidden !important;
    }

    @keyframes modalSlideUp {
        0% { opacity: 0; transform: translateY(30px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .logs-modal-header {
        padding: 16px 24px !important;
        border-bottom: 1px solid rgba(255,255,255,0.06) !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        flex-shrink: 0 !important;
    }

    .logs-modal-header h3 {
        margin: 0 !important;
        font-weight: 700 !important;
        color: white !important;
        font-size: 1.1rem !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
    }

    .logs-modal-header h3 i {
        color: #60a5fa !important;
    }

    .logs-modal-close {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
        color: white !important;
        width: 36px !important;
        height: 36px !important;
        border-radius: 10px !important;
        cursor: pointer !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s ease !important;
        font-size: 18px !important;
        padding: 0 !important;
    }

    .logs-modal-close:hover {
        background: rgba(239, 68, 68, 0.2) !important;
        border-color: rgba(239, 68, 68, 0.3) !important;
    }

    .logs-modal-body {
        padding: 16px 24px !important;
        overflow-y: auto !important;
        flex: 1 !important;
        max-height: 50vh !important;
    }

    .logs-modal-body::-webkit-scrollbar {
        width: 4px !important;
    }

    .logs-modal-body::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.05) !important;
        border-radius: 10px !important;
    }

    .logs-modal-body::-webkit-scrollbar-thumb {
        background: rgba(59, 130, 246, 0.3) !important;
        border-radius: 10px !important;
    }

    .log-entry {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 8px 12px !important;
        border-radius: 10px !important;
        margin-bottom: 4px !important;
        background: rgba(255,255,255,0.02) !important;
        font-size: 0.8rem !important;
        font-family: 'Courier New', monospace !important;
        transition: background 0.2s ease !important;
    }

    .log-entry:hover {
        background: rgba(255,255,255,0.05) !important;
    }

    .log-entry .log-time {
        color: #6b7280 !important;
        font-size: 0.7rem !important;
        min-width: 70px !important;
    }

    .log-entry .log-coords {
        color: #60a5fa !important;
        font-weight: 600 !important;
    }

    .log-entry .log-accuracy {
        color: #34d399 !important;
        font-size: 0.7rem !important;
    }

    .log-entry .log-index {
        color: rgba(255,255,255,0.2) !important;
        font-size: 0.6rem !important;
        min-width: 24px !important;
    }

    .log-entry.latest {
        background: rgba(16, 185, 129, 0.08) !important;
        border-left: 2px solid #10b981 !important;
    }

    .logs-modal-footer {
        padding: 12px 24px !important;
        border-top: 1px solid rgba(255,255,255,0.06) !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        flex-shrink: 0 !important;
        font-size: 0.7rem !important;
        color: #6b7280 !important;
    }

    .logs-modal-footer .log-count {
        font-weight: 600 !important;
        color: #9ca3af !important;
    }

    .logs-no-data {
        text-align: center !important;
        padding: 40px 20px !important;
        color: #6b7280 !important;
    }

    .logs-no-data i {
        font-size: 2rem !important;
        margin-bottom: 12px !important;
        display: block !important;
        opacity: 0.3 !important;
    }

    /* ============================================================
       RESPONSIVE - FULL SPACE ON ALL DEVICES
    ============================================================ */

    /* --- Mobile Devices (≤ 768px) --- */
    @media (max-width: 768px) {
        .tracking-header {
            padding: 12px 16px !important;
        }

        .tracking-header h2 {
            font-size: clamp(0.85rem, 2.5vw, 1.1rem) !important;
        }

        .tracking-header h2 i {
            font-size: clamp(0.75rem, 2vw, 0.9rem) !important;
        }

        .status-badge {
            padding: 4px 12px !important;
            font-size: clamp(0.6rem, 1.5vw, 0.75rem) !important;
        }

        .status-badge .pulse-dot {
            width: 8px !important;
            height: 8px !important;
        }

        .truck-icon i {
            font-size: 26px !important;
        }

        .leaflet-tooltip {
            font-size: 10px !important;
            padding: 3px 10px !important;
        }

        .leaflet-popup-content {
            font-size: 12px !important;
            min-width: 120px !important;
        }

        .location-flash-popup {
            bottom: 20px !important;
            padding: 10px 16px !important;
            min-width: 200px !important;
            gap: 8px !important;
            border-radius: 14px !important;
        }

        .location-flash-popup .popup-item {
            font-size: 0.75rem !important;
        }

        .location-flash-popup .popup-item .value {
            font-size: 0.75rem !important;
        }

        .location-flash-popup .popup-item .label {
            font-size: 0.5rem !important;
        }

        .location-flash-popup .popup-divider {
            height: 18px !important;
        }

        .location-flash-popup .popup-click-hint {
            display: none !important;
        }

        .logs-modal {
            max-width: 100% !important;
            max-height: 90vh !important;
            border-radius: 16px !important;
        }

        .logs-modal-header {
            padding: 14px 16px !important;
        }

        .logs-modal-body {
            padding: 12px 16px !important;
        }

        .log-entry {
            font-size: 0.7rem !important;
            padding: 6px 10px !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
        }

        .log-entry .log-time {
            font-size: 0.6rem !important;
            min-width: 60px !important;
        }

        .log-entry .log-coords {
            font-size: 0.7rem !important;
        }
    }

    /* --- Small Phones (≤ 576px) --- */
    @media (max-width: 576px) {
        .tracking-header {
            padding: 10px 12px !important;
        }

        .tracking-header h2 {
            font-size: clamp(0.7rem, 2vw, 0.9rem) !important;
            gap: 6px !important;
        }

        .tracking-header h2 i {
            font-size: clamp(0.65rem, 1.8vw, 0.8rem) !important;
        }

        .status-badge {
            padding: 3px 10px !important;
            font-size: clamp(0.5rem, 1.2vw, 0.65rem) !important;
            gap: 4px !important;
        }

        .status-badge .pulse-dot {
            width: 6px !important;
            height: 6px !important;
        }

        .truck-icon i {
            font-size: 22px !important;
        }

        .leaflet-tooltip {
            font-size: 8px !important;
            padding: 2px 8px !important;
        }

        .leaflet-popup-content {
            font-size: 10px !important;
            min-width: 100px !important;
        }

        .location-flash-popup {
            bottom: 16px !important;
            padding: 8px 12px !important;
            min-width: 160px !important;
            gap: 6px !important;
            border-radius: 12px !important;
        }

        .location-flash-popup .popup-item {
            font-size: 0.65rem !important;
            gap: 2px !important;
        }

        .location-flash-popup .popup-item .value {
            font-size: 0.65rem !important;
        }

        .location-flash-popup .popup-item .label {
            font-size: 0.45rem !important;
            letter-spacing: 0.3px !important;
        }

        .location-flash-popup .popup-divider {
            height: 16px !important;
        }

        .location-flash-popup .popup-icon-small {
            font-size: 0.55rem !important;
        }

        .logs-modal-header h3 {
            font-size: 0.95rem !important;
        }

        .logs-modal-body {
            padding: 10px 12px !important;
        }

        .log-entry {
            font-size: 0.6rem !important;
            padding: 5px 8px !important;
        }

        .log-entry .log-time {
            font-size: 0.55rem !important;
            min-width: 50px !important;
        }

        .log-entry .log-coords {
            font-size: 0.6rem !important;
        }

        .log-entry .log-accuracy {
            font-size: 0.55rem !important;
        }
    }

    /* --- Very Small Phones (≤ 400px) --- */
    @media (max-width: 400px) {
        .tracking-header {
            padding: 8px 10px !important;
        }

        .tracking-header h2 {
            font-size: clamp(0.6rem, 1.8vw, 0.75rem) !important;
            gap: 4px !important;
        }

        .tracking-header h2 i {
            font-size: clamp(0.55rem, 1.5vw, 0.7rem) !important;
        }

        .status-badge {
            padding: 2px 8px !important;
            font-size: clamp(0.45rem, 1vw, 0.55rem) !important;
            gap: 3px !important;
        }

        .status-badge .pulse-dot {
            width: 5px !important;
            height: 5px !important;
        }

        .truck-icon i {
            font-size: 18px !important;
        }

        .leaflet-tooltip {
            font-size: 7px !important;
            padding: 2px 6px !important;
        }

        .leaflet-popup-content {
            font-size: 9px !important;
            min-width: 80px !important;
        }

        .location-flash-popup {
            bottom: 12px !important;
            padding: 6px 10px !important;
            min-width: 140px !important;
            gap: 4px !important;
            border-radius: 10px !important;
        }

        .location-flash-popup .popup-item {
            font-size: 0.55rem !important;
            gap: 2px !important;
        }

        .location-flash-popup .popup-item .value {
            font-size: 0.55rem !important;
        }

        .location-flash-popup .popup-item .label {
            font-size: 0.4rem !important;
            letter-spacing: 0.2px !important;
        }

        .location-flash-popup .popup-divider {
            height: 14px !important;
        }

        .location-flash-popup .popup-icon-small {
            font-size: 0.5rem !important;
        }

        .logs-modal {
            max-height: 95vh !important;
            border-radius: 12px !important;
        }

        .logs-modal-header h3 {
            font-size: 0.85rem !important;
        }

        .logs-modal-body {
            padding: 8px 10px !important;
        }

        .log-entry {
            font-size: 0.55rem !important;
            padding: 4px 6px !important;
        }

        .log-entry .log-time {
            font-size: 0.5rem !important;
            min-width: 45px !important;
        }

        .log-entry .log-coords {
            font-size: 0.55rem !important;
        }

        .log-entry .log-accuracy {
            font-size: 0.5rem !important;
        }

        .log-entry .log-index {
            font-size: 0.5rem !important;
            min-width: 20px !important;
        }

        .logs-modal-footer {
            font-size: 0.6rem !important;
            padding: 8px 12px !important;
        }
    }

    /* Hide scrollbar on body */
    body::-webkit-scrollbar {
        display: none !important;
    }
    body {
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
    }
</style>

<!-- FULL SCREEN WRAPPER -->
<div class="tracking-wrapper">
    <!-- Map Container -->
    <div id="routeMap"></div>

    <!-- Header Overlay -->
    <div class="tracking-header">
        <h2>
            <i class="fas fa-truck"></i>
            <span>Live Tracking</span>
        </h2>
        <div>
            <span class="status-badge">
                <span class="pulse-dot"></span>
                Live
            </span>
        </div>
    </div>
</div>

<!-- ============================================================
     PERSISTENT LOCATION POPUP - CLICKABLE
    ============================================================ -->
<div id="locationFlashPopup" class="location-flash-popup">
    <div class="popup-item">
        <span class="popup-icon-small">📍</span>
        <span class="label">Lat</span>
        <span class="value lat" id="flashLat">0.000000</span>
    </div>
    <div class="popup-divider"></div>
    <div class="popup-item">
        <span class="popup-icon-small">📍</span>
        <span class="label">Lng</span>
        <span class="value lng" id="flashLng">0.000000</span>
    </div>
    <div class="popup-divider"></div>
    <div class="popup-item">
        <span class="popup-icon-small">🎯</span>
        <span class="label">Acc</span>
        <span class="value accuracy" id="flashAccuracy">0m</span>
    </div>
    <div class="popup-divider"></div>
    <div class="popup-item">
        <span class="popup-icon-small">🕐</span>
        <span class="label">Time</span>
        <span class="value time" id="flashTime">--:--:--</span>
    </div>
    <span class="popup-click-hint">▼ click for logs</span>
</div>

<!-- ============================================================
     LOGS MODAL
    ============================================================ -->
<div id="logsModal" class="logs-modal-overlay">
    <div class="logs-modal">
        <div class="logs-modal-header">
            <h3>
                <i class="fas fa-history"></i>
                Location Logs
            </h3>
            <button class="logs-modal-close" id="logsModalClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="logs-modal-body" id="logsModalBody">
            <!-- Logs will be rendered here -->
        </div>
        <div class="logs-modal-footer">
            <span class="log-count" id="logCount">0 entries</span>
            <span>Last 50 records</span>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Leaflet JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js" nonce="{{ $csp_nonce }}"></script>

<script nonce="{{ $csp_nonce }}">
    (function() {
        'use strict';

        // ============================================================
        // GLOBALS
        // ============================================================
        let map = null;
        let truckMarker = null;
        let truckCircle = null;
        let pollingInterval = null;
        let currentLat = 11.1302;
        let currentLng = 123.9526;
        let isMapReady = false;
        let locationLogs = [];
        const MAX_LOGS = 50;
        let isFirstLoad = true;
        let retryCount = 0;
        const MAX_RETRIES = 5;

        // ============================================================
        // UPDATE POPUP - PERSISTENT (does not vanish)
        // ============================================================
        function updateLocationPopup(lat, lng, accuracy) {
            const popup = document.getElementById('locationFlashPopup');
            const latEl = document.getElementById('flashLat');
            const lngEl = document.getElementById('flashLng');
            const accuracyEl = document.getElementById('flashAccuracy');
            const timeEl = document.getElementById('flashTime');

            // Update content
            latEl.textContent = lat.toFixed(6);
            lngEl.textContent = lng.toFixed(6);
            accuracyEl.textContent = Math.round(accuracy) + 'm';
            timeEl.textContent = new Date().toLocaleTimeString();

            // Show popup if not already visible
            if (!popup.classList.contains('show')) {
                popup.classList.add('show');
            }
        }

        // ============================================================
        // LOGS MANAGEMENT
        // ============================================================
        function addLogEntry(lat, lng, accuracy) {
            const timestamp = new Date();
            locationLogs.unshift({
                lat: lat,
                lng: lng,
                accuracy: accuracy,
                time: timestamp
            });

            // Keep only last MAX_LOGS
            if (locationLogs.length > MAX_LOGS) {
                locationLogs = locationLogs.slice(0, MAX_LOGS);
            }
        }

        function renderLogs() {
            const body = document.getElementById('logsModalBody');
            const count = document.getElementById('logCount');

            if (locationLogs.length === 0) {
                body.innerHTML = `
                    <div class="logs-no-data">
                        <i class="fas fa-map-pin"></i>
                        No location data yet
                    </div>
                `;
                count.textContent = '0 entries';
                return;
            }

            count.textContent = locationLogs.length + ' entries';

            let html = '';
            for (let i = 0; i < locationLogs.length; i++) {
                const log = locationLogs[i];
                const isLatest = i === 0;
                const timeStr = log.time.toLocaleTimeString();
                const dateStr = log.time.toLocaleDateString();

                html += `
                    <div class="log-entry ${isLatest ? 'latest' : ''}">
                        <span class="log-index">#${locationLogs.length - i}</span>
                        <span class="log-time">${dateStr} ${timeStr}</span>
                        <span class="log-coords">${log.lat.toFixed(6)}, ${log.lng.toFixed(6)}</span>
                        <span class="log-accuracy">±${Math.round(log.accuracy)}m</span>
                    </div>
                `;
            }

            body.innerHTML = html;

            // Scroll to top (latest entry)
            body.scrollTop = 0;
        }

        // ============================================================
        // LOGS MODAL CONTROLS
        // ============================================================
        function openLogsModal() {
            const modal = document.getElementById('logsModal');
            renderLogs();
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLogsModal() {
            const modal = document.getElementById('logsModal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        // ============================================================
        // INIT MAP - NO API KEY REQUIRED
        // ============================================================
        function initMap() {
            try {
                // Create map with default center
                map = L.map('routeMap', {
                    center: [currentLat, currentLng],
                    zoom: 12,
                    zoomControl: true,
                    fadeAnimation: true,
                    attributionControl: true
                });

                // ✅ FIXED: Using free OpenStreetMap tiles - NO API KEY REQUIRED!
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    minZoom: 6,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors'
                }).addTo(map);

                // ============================================================
                // CUSTOM TRUCK ICON
                // ============================================================
                const truckIcon = L.divIcon({
                    html: '<i class="fas fa-truck"></i>',
                    iconSize: [40, 40],
                    className: 'truck-icon',
                    popupAnchor: [0, -20]
                });

                // ============================================================
                // ADD TRUCK MARKER
                // ============================================================
                truckMarker = L.marker([currentLat, currentLng], {
                    icon: truckIcon,
                    zIndexOffset: 1000
                }).addTo(map);

                // ============================================================
                // ADD GLOW CIRCLE AROUND TRUCK
                // ============================================================
                truckCircle = L.circleMarker([currentLat, currentLng], {
                    radius: 25,
                    color: '#ef4444',
                    weight: 2,
                    opacity: 0.4,
                    fillColor: '#ef4444',
                    fillOpacity: 0.1,
                    className: 'truck-glow'
                }).addTo(map);

                // ============================================================
                // TOOLTIP
                // ============================================================
                const tooltipContent = document.createElement('div');
                tooltipContent.style.display = 'flex';
                tooltipContent.style.alignItems = 'center';
                tooltipContent.style.gap = '6px';
                tooltipContent.innerHTML = '📍 <span id="coordDisplay">Loading...</span>';
                
                truckMarker.bindTooltip(tooltipContent, {
                    permanent: true,
                    direction: 'top',
                    offset: [0, -20],
                    className: 'custom-tooltip'
                });

                // ============================================================
                // POPUP
                // ============================================================
                truckMarker.bindPopup(`
                    <div style="font-family: 'Inter', sans-serif; padding: 4px 0;">
                        <strong style="font-size: 16px; color: #1a1a2e;">🚚 Live Truck</strong>
                        <br>
                        <span style="font-size: 13px; color: #666;">Status: <span style="color: #10B981; font-weight: 600;">● Online</span></span>
                        <br>
                        <span style="font-size: 12px; color: #888;" id="popupCoords">${currentLat.toFixed(5)}, ${currentLng.toFixed(5)}</span>
                    </div>
                `);

                // ============================================================
                // MAP EVENT LISTENERS
                // ============================================================
                map.on('load', function() {
                    isMapReady = true;
                    console.log('✅ Map loaded successfully - NO API KEY REQUIRED!');
                    // Force resize to ensure full space
                    setTimeout(function() {
                        map.invalidateSize();
                    }, 100);
                });

                map.on('error', function(e) {
                    console.warn('Map error:', e);
                });

                // Fix map resize on orientation change
                setTimeout(function() {
                    map.invalidateSize();
                }, 300);

                // ============================================================
                // ADD ZOOM CONTROLS IN BOTTOM RIGHT (Mobile Friendly)
                // ============================================================
                map.zoomControl.setPosition('bottomright');

                console.log('🗺️ Map initialized with OpenStreetMap tiles (free, no API key)');

            } catch (error) {
                console.error('Failed to initialize map:', error);
                document.getElementById('routeMap').innerHTML = `
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white; z-index: 10;">
                        <div style="color: #ef4444; font-size: 2rem; margin-bottom: 12px;">⚠️</div>
                        <p style="font-size: clamp(0.8rem, 1.5vw, 1.1rem); font-weight: 500; color: #ef4444;">Failed to load map</p>
                        <button onclick="location.reload()" style="margin-top: 12px; padding: 8px 24px; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Retry</button>
                    </div>
                `;
            }
        }

        // ============================================================
        // UPDATE TRUCK POSITION
        // ============================================================
        function updateTruckPosition(lat, lng, accuracy) {
            if (!truckMarker || !truckCircle || !map) return;

            // Validate coordinates
            if (isNaN(lat) || isNaN(lng) || lat < -90 || lat > 90 || lng < -180 || lng > 180) {
                console.warn('Invalid coordinates received:', lat, lng);
                return;
            }

            currentLat = lat;
            currentLng = lng;

            // Add to logs
            addLogEntry(lat, lng, accuracy || 15);

            // Update marker position
            truckMarker.setLatLng([lat, lng]);
            
            // Update glow circle
            truckCircle.setLatLng([lat, lng]);

            // Update tooltip
            const coordDisplay = document.getElementById('coordDisplay');
            if (coordDisplay) {
                coordDisplay.textContent = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
            }

            // Update popup
            const popupCoords = document.getElementById('popupCoords');
            if (popupCoords) {
                popupCoords.textContent = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
            }

            // 🎯 UPDATE PERSISTENT BOTTOM POPUP (does not vanish)
            updateLocationPopup(lat, lng, accuracy || 15);

            // Pan map smoothly
            map.panTo([lat, lng], {
                duration: 0.5,
                easeLinearity: 0.25
            });

            // Reset retry count on success
            retryCount = 0;
        }

        // ============================================================
        // POLLING - FETCH LATEST LOCATION (with retry logic)
        // ============================================================
        async function fetchLatestLocation() {
            try {
                const response = await fetch('/tracking/latest', {
                    headers: {
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache, no-store, must-revalidate',
                        'Pragma': 'no-cache',
                        'Expires': '0'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();
                
                // Try different data structures
                let lat = parseFloat(data?.lat);
                let lng = parseFloat(data?.lng);
                let accuracy = parseFloat(data?.accuracy) || 15;
                
                // Fallback: try location object
                if (isNaN(lat) && data?.location) {
                    lat = parseFloat(data.location.lat);
                    lng = parseFloat(data.location.lng);
                    accuracy = parseFloat(data.location.accuracy) || 15;
                }

                // Fallback: try data from nested response
                if (isNaN(lat) && data?.data?.lat) {
                    lat = parseFloat(data.data.lat);
                    lng = parseFloat(data.data.lng);
                    accuracy = parseFloat(data.data.accuracy) || 15;
                }

                if (!isNaN(lat) && !isNaN(lng)) {
                    updateTruckPosition(lat, lng, accuracy);
                    if (isFirstLoad) {
                        isFirstLoad = false;
                        console.log('✅ First location received!');
                    }
                } else {
                    console.warn('Invalid data received:', data);
                    // Try again with retry
                    if (retryCount < MAX_RETRIES) {
                        retryCount++;
                        console.log(`Retry ${retryCount}/${MAX_RETRIES}...`);
                        setTimeout(fetchLatestLocation, 1000);
                    }
                }

            } catch (error) {
                // Silent fail - don't spam console
                if (error.message !== 'HTTP 404') {
                    console.debug('Polling failed:', error.message);
                }
                
                // Retry logic
                if (retryCount < MAX_RETRIES) {
                    retryCount++;
                    console.log(`Retry ${retryCount}/${MAX_RETRIES}...`);
                    setTimeout(fetchLatestLocation, 1000);
                }
            }
        }

        // ============================================================
        // START POLLING
        // ============================================================
        function startPolling() {
            if (pollingInterval) {
                clearInterval(pollingInterval);
            }

            // Fetch immediately
            fetchLatestLocation();

            // Then every 2 seconds
            pollingInterval = setInterval(fetchLatestLocation, 2000);
            console.log('🔄 Polling started (every 2s)');
        }

        // ============================================================
        // HANDLE VISIBILITY CHANGE (Pause polling when tab hidden)
        // ============================================================
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Tab is hidden - slow down polling
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                    pollingInterval = setInterval(fetchLatestLocation, 5000);
                }
            } else {
                // Tab is visible - resume normal polling
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }
                pollingInterval = setInterval(fetchLatestLocation, 2000);
                fetchLatestLocation(); // Immediate refresh
            }
        });

        // ============================================================
        // CLEANUP ON PAGE UNLOAD
        // ============================================================
        window.addEventListener('beforeunload', function() {
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
            }
            if (map) {
                map.remove();
                map = null;
            }
        });

        // ============================================================
        // HANDLE RESIZE - Ensure full space
        // ============================================================
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                if (map) {
                    map.invalidateSize();
                }
            }, 200);
        });

        // ============================================================
        // HANDLE ORIENTATION CHANGE
        // ============================================================
        window.addEventListener('orientationchange', function() {
            setTimeout(function() {
                if (map) {
                    map.invalidateSize();
                }
            }, 400);
        });

        // ============================================================
        // EVENT BINDINGS - CLICKABLE POPUP & MODAL
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            // Click on popup to open logs
            const popup = document.getElementById('locationFlashPopup');
            if (popup) {
                popup.addEventListener('click', function(e) {
                    // Don't open if modal is already open
                    if (document.getElementById('logsModal').classList.contains('active')) {
                        return;
                    }
                    openLogsModal();
                });
            }

            // Close modal with close button
            const closeBtn = document.getElementById('logsModalClose');
            if (closeBtn) {
                closeBtn.addEventListener('click', closeLogsModal);
            }

            // Close modal by clicking overlay
            const modal = document.getElementById('logsModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeLogsModal();
                    }
                });
            }

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && document.getElementById('logsModal').classList.contains('active')) {
                    closeLogsModal();
                }
            });
        });

        // ============================================================
        // INIT ON PAGE LOAD
        // ============================================================
        function init() {
            // Wait for DOM
            if (document.readyState === 'complete') {
                initMap();
                setTimeout(startPolling, 500);
            } else {
                window.addEventListener('load', function() {
                    initMap();
                    setTimeout(startPolling, 500);
                });
            }
        }

        // Start everything
        init();

    })();
</script>
@endsection
