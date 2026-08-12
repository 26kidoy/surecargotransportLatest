@extends('admin.layouts.app') {{-- Adjust to your admin layout name --}}

@section('title', 'Manage Shipping Fee')
@section('page-title', 'Shipping Fee Management')

@section('content')
<style nonce="{{ $csp_nonce }}">
/* ============================================================
   SHIPPING FEE PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   Theme: White / Red / Green
   ============================================================ */

:root {
    --green-primary: #28a745;
    --green-dark: #1e7e34;
    --green-light: #34ce57;
    --green-soft: #e8f5e9;
    --red-primary: #dc3545;
    --red-dark: #b91d2c;
    --red-soft: #f0fdf4;
    --violet-primary: #6c0985;
    --violet-dark: #490477;
    --violet-light: #5e0886;
    --violet-soft: #f8fafc;
    --white: #ffffff;
    --gray-100: #f8fafc;
    --gray-200: #eef2f0;
    --gray-300: #e2e8f0;
    --gray-600: #6c757d;
    --text-dark: #1f2d3d;
    --text-muted: #4a5568;
    --shadow-sm: 0 15px 35px -10px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 25px 40px -12px rgba(40, 167, 69, 0.15);
    --shadow-lg: 0 14px 22px rgba(220, 53, 69, 0.3);
    --radius-card: 2rem;
    --radius-btn: 3rem;

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
   CONTAINER - FIXED PADDING
   ============================================================ */
.shipping-fee-container {
    min-height: 100vh;
    padding: var(--sp-xl) var(--sp-md);
    position: relative;
    max-width: 100% !important;
    overflow-x: hidden !important;
}

/* FIX: Container row to prevent overflow */
.shipping-fee-container .row {
    margin-right: 0 !important;
    margin-left: 0 !important;
}

/* FIX: Container columns to prevent right padding */
.shipping-fee-container [class*="col-"] {
    padding-right: 10px !important;
    padding-left: 10px !important;
}

.shipping-fee-container,
.shipping-fee-container * {
    font-size: var(--font-base) !important;
    font-weight: 400 !important;
    line-height: 1.6;
}

.shipping-fee-container i,
.shipping-fee-container .fas,
.shipping-fee-container .far {
    font-size: var(--font-base) !important;
    line-height: 1;
}

.shipping-fee-container h4.fw-bold {
    font-size: var(--font-lg) !important;
    font-weight: 800 !important;
}

/* ============================================================
   PREMIUM CARD - FIXED OVERFLOW
   ============================================================ */
.premium-card {
    background: var(--white);
    border-radius: var(--radius-card);
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    overflow: hidden;
    max-width: 100% !important;
}

.premium-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
    border-color: rgba(40, 167, 69, 0.19);
}

.card-header.white-header {
    background: var(--white);
    border-bottom: 3px solid var(--violet-dark);
    padding: var(--sp-lg) var(--sp-xl) var(--sp-sm) var(--sp-xl);
}

.card-body {
    padding: var(--sp-xl) var(--sp-xl) var(--sp-xl) !important;
}

/* ============================================================
   FORM ELEMENTS - FIXED
   ============================================================ */
.form-label {
    color: var(--text-dark) !important;
    font-weight: 600 !important;
    margin-bottom: var(--sp-sm);
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-label i {
    color: var(--violet-primary);
}

.input-group {
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    max-width: 100% !important;
}

.input-group-text {
    background: var(--gray-100);
    border: 1px solid var(--gray-300);
    border-right: none;
    font-weight: 600;
    color: var(--violet-primary) !important;
    padding: 0 var(--sp-lg);
    font-size: var(--font-base) !important;
    border-radius: 1.5rem 0 0 1.5rem;
    min-height: 44px;
}

.form-control-lg {
    border: 1px solid var(--gray-300);
    border-left: none;
    background: var(--white);
    padding: var(--sp-sm) var(--sp-md) !important;
    font-size: var(--font-base) !important;
    border-radius: 0 1.5rem 1.5rem 0;
    transition: all 0.2s ease;
    font-weight: 400;
    min-height: 44px;
    max-width: 100% !important;
    box-sizing: border-box !important;
}

.form-control-lg:focus {
    border-color: var(--violet-light);
    box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.2);
    background: #fff;
    outline: none;
}

.form-control-lg::placeholder {
    font-weight: 400;
    color: var(--gray-600);
}

.is-invalid {
    border-color: var(--violet-primary) !important;
    border-left: none;
    animation: invalidShake 0.4s ease;
}

@keyframes invalidShake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-6px); }
    50% { transform: translateX(6px); }
    75% { transform: translateX(-3px); }
    100% { transform: translateX(0); }
}

.invalid-feedback {
    color: var(--red-primary) !important;
    font-weight: 600;
    margin-top: var(--sp-sm);
    display: block;
    font-size: var(--font-sm) !important;
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-green {
    background: linear-gradient(105deg, var(--violet-primary), var(--violet-dark));
    border: none;
    border-radius: var(--radius-btn);
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    color: white !important;
    transition: all 0.25s ease;
    box-shadow: 0 6px 14px rgba(40, 167, 69, 0.25);
    letter-spacing: 0.3px;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
    font-size: var(--font-base) !important;
}

.btn-green:hover {
    background: linear-gradient(105deg, var(--red-primary), var(--red-dark));
    transform: scale(1.02) translateY(-3px);
    box-shadow: var(--shadow-lg);
    color: white;
}

.btn-green:active {
    transform: scale(0.98) translateY(0);
}

.btn-green i {
    margin-right: var(--sp-xs);
}

/* ============================================================
   LAST UPDATED BADGE
   ============================================================ */
.last-updated-badge {
    background: var(--red-soft);
    border-left: 5px solid var(--violet-primary);
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: var(--radius-btn);
    color: var(--text-dark);
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.2s;
    min-height: 44px;
}

.last-updated-badge:hover {
    background: #fff0f0;
    border-left-color: var(--red-primary);
    transform: scale(1.01);
}

/* ============================================================
   CHART CARD - FIXED
   ============================================================ */
.chart-card {
    background: var(--white);
    border-radius: var(--radius-card);
    border: 1px solid var(--gray-200);
    transition: all 0.3s;
    margin-bottom: var(--sp-xl);
    overflow: hidden;
    max-width: 100% !important;
}

.chart-card:hover {
    border-color: var(--violet-primary);
    box-shadow: 0 12px 22px rgba(40, 167, 69, 0.08);
}

.chart-header {
    background: var(--white);
    border-bottom: 2px solid var(--gray-200);
    padding: var(--sp-lg) var(--sp-xl);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--sp-md);
}

.chart-title {
    font-weight: 800 !important;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: var(--font-md) !important;
}

.chart-title i {
    color: var(--red-primary);
}

.export-btn {
    background: white;
    border: 2px solid var(--violet-primary);
    border-radius: var(--radius-btn);
    padding: var(--sp-xs) var(--sp-lg);
    font-weight: 600;
    color: var(--violet-primary);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: var(--font-sm) !important;
    min-height: 38px;
}

.export-btn:hover {
    background: var(--green-primary);
    color: white;
    border-color: var(--violet-primary);
    transform: translateY(-2px);
}

.chart-container {
    padding: var(--sp-lg);
    position: relative;
    height: 400px;
    width: 100% !important;
    overflow: hidden !important;
}

canvas#feeHistoryChart {
    max-height: 350px;
    width: 100% !important;
}

.no-data-message {
    text-align: center;
    padding: var(--sp-xxl);
    color: var(--gray-600);
    font-size: var(--font-base) !important;
}

/* ============================================================
   INFO CARD - FIXED TEXT SIZES FOR MOBILE
   ============================================================ */
.info-card {
    background: var(--white);
    border-radius: var(--radius-card);
    border: 1px solid var(--gray-200);
    transition: all 0.3s;
    padding: var(--sp-lg);
    max-width: 100% !important;
    overflow: hidden !important;
}

.info-card:hover {
    border-color: var(--violet-primary);
    box-shadow: 0 12px 22px rgba(40, 167, 69, 0.08);
}

.info-icon {
    color: var(--red-primary);
    transition: transform 0.2s;
    font-size: var(--font-xl) !important;
}

.info-card:hover .info-icon {
    transform: scale(1.05);
    color: var(--green-primary);
}

.info-title {
    font-weight: 800 !important;
    color: var(--text-dark);
    font-size: var(--font-md) !important;
}

.info-text {
    color: var(--text-muted);
    line-height: 1.6;
    font-size: var(--font-base) !important;
}

/* ============================================================
   ALERT
   ============================================================ */
.alert-success-custom {
    background: var(--green-soft);
    border-left: 6px solid var(--green-primary);
    border-radius: 1.2rem;
    padding: var(--sp-md) var(--sp-lg);
    font-weight: 600;
    color: #1e4620;
    animation: slideDown 0.4s ease;
    transition: opacity 0.5s ease;
    font-size: var(--font-base) !important;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ============================================================
   PDF MODAL PREVIEW
   ============================================================ */
#pdfExportPreview {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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

    .shipping-fee-container {
        padding: var(--sp-lg) var(--sp-md);
    }

    .shipping-fee-container [class*="col-"] {
        padding-right: 8px !important;
        padding-left: 8px !important;
    }

    .chart-container {
        height: 350px;
    }

    .card-header.white-header {
        padding: var(--sp-md) var(--sp-lg) var(--sp-xs) var(--sp-lg);
    }

    .card-body {
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

        --sp-xs: 0.2rem;
        --sp-sm: 0.4rem;
        --sp-md: 0.8rem;
        --sp-lg: 1.2rem;
        --sp-xl: 1.5rem;
        --sp-xxl: 2rem;
    }

    /* FIX: Container padding for mobile */
    .shipping-fee-container {
        padding: var(--sp-md) 8px !important;
    }

    .shipping-fee-container [class*="col-"] {
        padding-right: 5px !important;
        padding-left: 5px !important;
    }

    .shipping-fee-container,
    .shipping-fee-container * {
        font-size: var(--font-sm) !important;
    }

    .shipping-fee-container i,
    .shipping-fee-container .fas,
    .shipping-fee-container .far {
        font-size: var(--font-sm) !important;
    }

    .shipping-fee-container h4.fw-bold {
        font-size: var(--font-md) !important;
    }

    /* FIX: Info card on mobile - text size reduced */
    .info-card {
        padding: var(--sp-sm) !important;
        border-radius: 1.2rem;
    }

    .info-title {
        font-size: var(--font-sm) !important;
    }

    .info-text {
        font-size: var(--font-xs) !important;
    }

    .info-icon {
        font-size: var(--font-md) !important;
    }

    .card-header.white-header {
        padding: var(--sp-sm) var(--sp-md) var(--sp-xs) var(--sp-md);
    }

    .card-body {
        padding: var(--sp-md) !important;
    }

    .form-label {
        font-size: var(--font-sm) !important;
        margin-bottom: var(--sp-xs);
    }

    .input-group-text {
        font-size: var(--font-sm) !important;
        padding: 0 var(--sp-md);
        min-height: 38px;
    }

    .form-control-lg {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 38px;
    }

    .btn-green {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
        border-radius: 2rem;
    }

    .last-updated-badge {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
    }

    .chart-header {
        flex-direction: column;
        align-items: flex-start;
        padding: var(--sp-sm) var(--sp-md);
    }

    .chart-title {
        font-size: var(--font-sm) !important;
    }

    .export-btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .chart-container {
        height: 300px;
        padding: var(--sp-sm);
    }

    canvas#feeHistoryChart {
        max-height: 280px;
    }

    .no-data-message {
        font-size: var(--font-sm) !important;
        padding: var(--sp-lg);
    }

    .alert-success-custom {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        border-radius: 1rem;
        border-left-width: 4px;
    }

    .invalid-feedback {
        font-size: var(--font-xs) !important;
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

    /* FIX: Extra small screen container */
    .shipping-fee-container {
        padding: var(--sp-sm) 6px !important;
    }

    .shipping-fee-container [class*="col-"] {
        padding-right: 4px !important;
        padding-left: 4px !important;
    }

    .shipping-fee-container,
    .shipping-fee-container * {
        font-size: var(--font-xs) !important;
    }

    .shipping-fee-container h4.fw-bold {
        font-size: var(--font-sm) !important;
    }

    /* FIX: Info card text size for small phones */
    .info-card {
        padding: var(--sp-xs) !important;
        border-radius: 1rem;
    }

    .info-title {
        font-size: var(--font-xs) !important;
    }

    .info-text {
        font-size: 0.6rem !important;
    }

    .info-icon {
        font-size: var(--font-sm) !important;
    }

    .premium-card {
        border-radius: 1.2rem;
    }

    .card-header.white-header {
        padding: var(--sp-xs) var(--sp-sm) var(--sp-xs) var(--sp-sm);
        border-bottom-width: 2px;
    }

    .card-body {
        padding: var(--sp-sm) !important;
    }

    .form-label {
        font-size: var(--font-xs) !important;
    }

    .input-group-text {
        font-size: var(--font-xs) !important;
        padding: 0 var(--sp-sm);
        min-height: 34px;
        border-radius: 1rem 0 0 1rem;
    }

    .form-control-lg {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-xs) !important;
        min-height: 34px;
        border-radius: 0 1rem 1rem 0;
    }

    .btn-green {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 1.5rem;
        width: 100%;
    }

    .last-updated-badge {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 2rem;
        width: 100%;
        justify-content: center;
    }

    .chart-header {
        padding: var(--sp-xs) var(--sp-sm);
        gap: var(--sp-xs);
    }

    .chart-title {
        font-size: var(--font-xs) !important;
    }

    .export-btn {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
    }

    .chart-container {
        height: 250px;
        padding: var(--sp-xs);
    }

    canvas#feeHistoryChart {
        max-height: 230px;
    }

    .no-data-message {
        font-size: var(--font-xs) !important;
        padding: var(--sp-md);
    }

    .alert-success-custom {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 0.8rem;
        border-left-width: 3px;
    }

    .invalid-feedback {
        font-size: 0.55rem !important;
    }

    .d-flex.gap-2 {
        gap: var(--sp-xs) !important;
        flex-wrap: wrap;
    }

    .d-flex.gap-2 .btn {
        width: 100%;
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

    .shipping-fee-container {
        padding: var(--sp-xs) 4px !important;
    }

    .shipping-fee-container [class*="col-"] {
        padding-right: 3px !important;
        padding-left: 3px !important;
    }

    .shipping-fee-container,
    .shipping-fee-container * {
        font-size: 0.55rem !important;
    }

    .shipping-fee-container h4.fw-bold {
        font-size: 0.65rem !important;
    }

    /* FIX: Info card very small phones */
    .info-title {
        font-size: 0.55rem !important;
    }

    .info-text {
        font-size: 0.5rem !important;
    }

    .info-icon {
        font-size: 0.6rem !important;
    }

    .input-group-text {
        font-size: 0.55rem !important;
        min-height: 30px;
        padding: 0 var(--sp-xs);
    }

    .form-control-lg {
        font-size: 0.55rem !important;
        min-height: 30px;
        padding: 0.05rem var(--sp-xs) !important;
    }

    .btn-green {
        font-size: 0.55rem !important;
        min-height: 30px;
    }

    .last-updated-badge {
        font-size: 0.55rem !important;
        min-height: 30px;
    }

    .chart-container {
        height: 200px;
    }

    canvas#feeHistoryChart {
        max-height: 180px;
    }

    .chart-title {
        font-size: 0.55rem !important;
    }

    .export-btn {
        font-size: 0.5rem !important;
        min-height: 26px;
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

    .shipping-fee-container {
        padding: var(--sp-xs) 3px !important;
    }

    .shipping-fee-container,
    .shipping-fee-container * {
        font-size: 0.45rem !important;
    }

    .info-title {
        font-size: 0.45rem !important;
    }

    .info-text {
        font-size: 0.4rem !important;
    }

    .input-group-text {
        font-size: 0.45rem !important;
        min-height: 26px;
    }

    .form-control-lg {
        font-size: 0.45rem !important;
        min-height: 26px;
    }

    .btn-green {
        font-size: 0.45rem !important;
        min-height: 26px;
    }

    .chart-container {
        height: 180px;
    }

    canvas#feeHistoryChart {
        max-height: 160px;
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

<div class="shipping-fee-container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
            {{-- MAIN CARD --}}
            <div class="premium-card mb-4">
                <div class="card-header white-header">
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-hand-holding-usd me-3" style="color: #dc3545;"></i>
                        Shipping Fee per Egg Tray
                    </h4>
                    <p class="mt-3 mb-0" style="color: #4b5563; font-weight: 500 !important;">
                        Set the fee charged for each egg tray shipped.
                    </p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert-success-custom mb-4 d-flex align-items-center justify-content-between">
                            <span><i class="fas fa-check-circle me-2" style="color: #28a745;"></i> {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0) invert(0);"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.fee.update', $fee->id) }}" method="POST" id="feeUpdateForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <label for="amount_per_tray" class="form-label">
                                <i class="fas fa-coins me-1"></i> Amount per Tray (PHP)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number"
                                       step="0.01"
                                       min="0"
                                       name="amount_per_tray"
                                       id="amount_per_tray"
                                       class="form-control form-control-lg @error('amount_per_tray') is-invalid @enderror"
                                       value="{{ old('amount_per_tray', $fee->amount_per_tray) }}"
                                       required>
                                @error('amount_per_tray')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text mt-3" style="font-size: 1.5rem !important; font-weight: 500; color: #2c5530;">
                                <i class="fas fa-info-circle me-1"></i> This fee will be applied to every egg tray in an order.
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-center align-items-center">

                            <button type="submit" class="btn btn-green" id="saveFeeBtn">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- CHART CARD: Historical Fee Trends --}}
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">
                        <i class="fas fa-chart-line" style="font-size: 1.8rem;"></i>
                        <span>Historical Shipping Fee Trends</span>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <button id="maximizeChartBtn" class="export-btn">
                            <i class="fas fa-expand"></i> Maximize Chart
                        </button>
                        <button id="exportChartPDF" class="export-btn">
                            <i class="fas fa-file-pdf"></i> Export as PDF
                        </button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="feeHistoryChart" style="width:100%; height:100%;"></canvas>
                </div>
            </div>

            {{-- INFO CARD --}}
            <div class="info-card p-4">
                <div class="d-flex align-items-center gap-4 flex-wrap flex-md-nowrap">
                    <i class="fas fa-info-circle info-icon" style="font-size: 3rem !important;"></i>
                    <div>
                        <div class="info-title mb-1" style="font-size: 1.8rem !important;">How it works</div>
                        <div class="info-text" style="font-size: 1.5rem !important;">
                            When a booking is created, the system will automatically multiply this fee by the number of egg trays selected and add it to the total price.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal for Maximized Chart --}}
<div class="modal fade" id="chartMaximizeModal" tabindex="-1" aria-labelledby="chartMaximizeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chartMaximizeModalLabel">
                    <i class="fas fa-chart-line me-2"></i>Shipping Fee Trend (Maximized View)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background: #ffffff; padding: 1.5rem;">
                <canvas id="maximizedChartCanvas" style="width:100%; height: auto; min-height: 550px;"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- NEW PDF EXPORT MODAL --}}
<div class="modal fade" id="pdfExportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Export Chart as PDF</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <p class="text-secondary mb-2" style="font-size: 1.4rem; font-weight: 500;">Chart: <span id="pdfExportChartTitle" class="fw-bold text-dark">Shipping Fee Trends</span></p>
                    </div>
                    <div class="col-12">
                        <div class="border rounded p-3 bg-light text-center">
                            <img id="pdfExportPreview" src="" alt="Chart Preview" class="img-fluid" style="max-height: 350px; width: auto; margin: 0 auto;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size: 1.2rem;">Page Orientation</label>
                        <select id="pdfOrientation" class="form-select form-select-lg">
                            <option value="landscape">Landscape</option>
                            <option value="portrait">Portrait</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size: 1.2rem;">Page Size</label>
                        <select id="pdfPageSize" class="form-select form-select-lg">
                            <option value="a4">A4</option>
                            <option value="letter">Letter</option>
                            <option value="legal">Legal</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-lg btn-danger" id="pdfDownloadBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-right: 6px;">
                        <path d="M12 16V4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 12L12 16L16 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 20H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script nonce="{{ $csp_nonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        // --- AUTO-HIDE SUCCESS ALERT AFTER 3 SECONDS ---
        const successAlert = document.querySelector('.alert-success-custom');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                setTimeout(() => {
                    if (successAlert.parentNode) successAlert.remove();
                }, 500);
            }, 3000);
        }

        // --- Input animation ---
        const amountInput = document.getElementById('amount_per_tray');
        if (amountInput) {
            amountInput.addEventListener('focus', () => {
                amountInput.style.transform = 'scale(1.01)';
                amountInput.style.transition = '0.1s';
            });
            amountInput.addEventListener('blur', () => {
                amountInput.style.transform = 'scale(1)';
            });
        }

                // --- Chart data from backend ---
        let historyData = @json($feeHistory ?? []);
        let chartLabels = [];
        let chartAmounts = [];

        if (historyData.length > 0) {
            historyData.sort((a, b) => new Date(a.date) - new Date(b.date));
            chartLabels = historyData.map(item => {
                let date = new Date(item.date);
                return date.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
            });
            chartAmounts = historyData.map(item => parseFloat(item.amount));
        } else {
            // Fallback: show current fee as single point
            chartLabels = [new Date().toLocaleDateString()];
            chartAmounts = [parseFloat(@json($fee->amount_per_tray ?? 0))];
        }

        // ==================== RESPONSIVE FONT HELPER ====================
        function getFeeChartFontSizes() {
            const width = window.innerWidth;

            let sizes = {
                tooltipTitle: 20,
                tooltipBody: 18,
                legend: 24,
                yTitle: 24,
                yTick: 20,
                xTitle: 24,
                xTick: 18,
                pointRadius: 7,
                pointHoverRadius: 11,
                borderWidth: 4,
                stepSize: 10,
                padding: 20
            };

            // Tablet (769px - 1024px)
            if (width >= 769 && width <= 1024) {
                sizes.tooltipTitle = 16;
                sizes.tooltipBody = 14;
                sizes.legend = 18;
                sizes.yTitle = 18;
                sizes.yTick = 15;
                sizes.xTitle = 18;
                sizes.xTick = 14;
                sizes.pointRadius = 6;
                sizes.pointHoverRadius = 9;
                sizes.borderWidth = 3;
                sizes.stepSize = 10;
                sizes.padding = 15;
            }
            // Mobile (≤ 768px)
            else if (width <= 768) {
                sizes.tooltipTitle = 12;
                sizes.tooltipBody = 11;
                sizes.legend = 13;
                sizes.yTitle = 13;
                sizes.yTick = 11;
                sizes.xTitle = 13;
                sizes.xTick = 10;
                sizes.pointRadius = 5;
                sizes.pointHoverRadius = 7;
                sizes.borderWidth = 2.5;
                sizes.stepSize = 10;
                sizes.padding = 12;
            }
            // Small phones (≤ 576px)
            else if (width <= 576) {
                sizes.tooltipTitle = 10;
                sizes.tooltipBody = 9;
                sizes.legend = 11;
                sizes.yTitle = 11;
                sizes.yTick = 9;
                sizes.xTitle = 11;
                sizes.xTick = 8;
                sizes.pointRadius = 4;
                sizes.pointHoverRadius = 6;
                sizes.borderWidth = 2;
                sizes.stepSize = 10;
                sizes.padding = 8;
            }
            // Very small phones (≤ 400px)
            else if (width <= 400) {
                sizes.tooltipTitle = 8;
                sizes.tooltipBody = 7;
                sizes.legend = 9;
                sizes.yTitle = 9;
                sizes.yTick = 7;
                sizes.xTitle = 9;
                sizes.xTick = 7;
                sizes.pointRadius = 3;
                sizes.pointHoverRadius = 5;
                sizes.borderWidth = 1.5;
                sizes.stepSize = 10;
                sizes.padding = 6;
            }
            // Extra small (≤ 350px)
            else if (width <= 350) {
                sizes.tooltipTitle = 7;
                sizes.tooltipBody = 6;
                sizes.legend = 8;
                sizes.yTitle = 8;
                sizes.yTick = 6;
                sizes.xTitle = 8;
                sizes.xTick = 6;
                sizes.pointRadius = 2.5;
                sizes.pointHoverRadius = 4;
                sizes.borderWidth = 1.5;
                sizes.stepSize = 10;
                sizes.padding = 4;
            }

            return sizes;
        }

        // ==================== BUILD RESPONSIVE CHART OPTIONS ====================
        function getFeeChartOptions() {
            const sizes = getFeeChartFontSizes();
            const isMobile = window.innerWidth < 576;
            const isVerySmall = window.innerWidth < 400;

            return {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    tooltip: {
                        backgroundColor: '#1f2d3d',
                        titleColor: '#ffffff',
                        bodyColor: '#eef2f0',
                        borderColor: '#28a745',
                        borderWidth: Math.max(1, sizes.borderWidth * 0.5),
                        titleFont: {
                            size: sizes.tooltipTitle,
                            weight: 'bold',
                            family: "'Inter', 'Segoe UI', sans-serif"
                        },
                        bodyFont: {
                            size: sizes.tooltipBody,
                            family: "'Inter', 'Segoe UI', sans-serif"
                        },
                        padding: Math.max(6, sizes.padding * 0.6),
                        cornerRadius: Math.max(6, sizes.padding * 0.5),
                        callbacks: {
                            label: function(context) {
                                return `₱ ${context.parsed.y.toFixed(2)} per tray`;
                            }
                        }
                    },
                    legend: {
                        labels: {
                            font: {
                                size: sizes.legend,
                                weight: 'bold',
                                family: "'Inter', 'Segoe UI', sans-serif"
                            },
                            color: '#1f2d3d',
                            usePointStyle: true,
                            boxWidth: Math.max(10, sizes.legend * 0.7),
                            padding: Math.max(8, sizes.padding * 0.8)
                        },
                        position: isMobile ? 'bottom' : 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: window.innerWidth > 400,
                            text: 'Amount (PHP)',
                            font: {
                                size: sizes.yTitle,
                                weight: 'bold',
                                family: "'Inter', 'Segoe UI', sans-serif"
                            },
                            color: '#dc3545',
                            padding: { bottom: Math.max(4, sizes.yTitle * 0.3) }
                        },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000) {
                                    return '₱' + (value / 1000).toFixed(1) + 'k';
                                }
                                return '₱' + value.toFixed(2);
                            },
                            font: {
                                size: sizes.yTick,
                                weight: 'bold',
                                family: "'Inter', 'Segoe UI', sans-serif"
                            },
                            stepSize: sizes.stepSize,
                            maxTicksLimit: isVerySmall ? 4 : (isMobile ? 5 : 8)
                        },
                        grid: { color: '#e9ecef', lineWidth: Math.max(0.5, sizes.borderWidth * 0.4) }
                    },
                    x: {
                        title: {
                            display: window.innerWidth > 400,
                            text: 'Date',
                            font: {
                                size: sizes.xTitle,
                                weight: 'bold',
                                family: "'Inter', 'Segoe UI', sans-serif"
                            },
                            color: '#28a745',
                            padding: { top: Math.max(4, sizes.xTitle * 0.3) }
                        },
                        ticks: {
                            font: {
                                size: sizes.xTick,
                                weight: 'bold',
                                family: "'Inter', 'Segoe UI', sans-serif"
                            },
                            maxRotation: isVerySmall ? 60 : (isMobile ? 45 : 35),
                            minRotation: isVerySmall ? 45 : (isMobile ? 30 : 25),
                            autoSkip: true,
                            autoSkipPadding: isVerySmall ? 5 : (isMobile ? 8 : 15),
                            maxTicksLimit: isVerySmall ? 4 : (isMobile ? 6 : 12)
                        },
                        grid: { display: false }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                elements: {
                    line: {
                        borderJoin: 'round',
                        borderWidth: Math.max(1.5, sizes.borderWidth)
                    },
                    point: {
                        radius: sizes.pointRadius,
                        hoverRadius: sizes.pointHoverRadius,
                        borderWidth: Math.max(1, sizes.borderWidth * 0.5)
                    }
                }
            };
        }

        // ==================== GET RESPONSIVE DATASET ====================
        function getResponsiveDataset() {
            const sizes = getFeeChartFontSizes();
            return {
                label: 'Shipping Fee (PHP per tray)',
                data: chartAmounts,
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.05)',
                borderWidth: Math.max(1.5, sizes.borderWidth),
                pointRadius: sizes.pointRadius,
                pointHoverRadius: sizes.pointHoverRadius,
                pointBackgroundColor: '#28a745',
                pointBorderColor: '#ffffff',
                pointBorderWidth: Math.max(1, sizes.borderWidth * 0.5),
                tension: 0.2,
                fill: true,
                pointStyle: 'circle'
            };
        }

        // ==================== INITIALIZE MAIN CHART ====================
        const ctx = document.getElementById('feeHistoryChart').getContext('2d');
        let feeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [getResponsiveDataset()]
            },
            options: getFeeChartOptions()
        });

        // ==================== WINDOW RESIZE HANDLER ====================
        let feeResizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(feeResizeTimeout);
            feeResizeTimeout = setTimeout(() => {
                if (feeChart) {
                    const newSizes = getFeeChartFontSizes();
                    const isMobile = window.innerWidth < 576;
                    const isVerySmall = window.innerWidth < 400;

                    // Update dataset
                    feeChart.data.datasets[0].borderWidth = Math.max(1.5, newSizes.borderWidth);
                    feeChart.data.datasets[0].pointRadius = newSizes.pointRadius;
                    feeChart.data.datasets[0].pointHoverRadius = newSizes.pointHoverRadius;
                    feeChart.data.datasets[0].pointBorderWidth = Math.max(1, newSizes.borderWidth * 0.5);

                    // Update options
                    feeChart.options.plugins.tooltip.titleFont.size = newSizes.tooltipTitle;
                    feeChart.options.plugins.tooltip.bodyFont.size = newSizes.tooltipBody;
                    feeChart.options.plugins.tooltip.borderWidth = Math.max(1, newSizes.borderWidth * 0.5);
                    feeChart.options.plugins.tooltip.padding = Math.max(6, newSizes.padding * 0.6);
                    feeChart.options.plugins.tooltip.cornerRadius = Math.max(6, newSizes.padding * 0.5);

                    feeChart.options.plugins.legend.labels.font.size = newSizes.legend;
                    feeChart.options.plugins.legend.labels.boxWidth = Math.max(10, newSizes.legend * 0.7);
                    feeChart.options.plugins.legend.labels.padding = Math.max(8, newSizes.padding * 0.8);
                    feeChart.options.plugins.legend.position = isMobile ? 'bottom' : 'top';

                    feeChart.options.scales.y.title.font.size = newSizes.yTitle;
                    feeChart.options.scales.y.title.display = window.innerWidth > 400;
                    feeChart.options.scales.y.ticks.font.size = newSizes.yTick;
                    feeChart.options.scales.y.ticks.stepSize = newSizes.stepSize;
                    feeChart.options.scales.y.ticks.maxTicksLimit = isVerySmall ? 4 : (isMobile ? 5 : 8);
                    feeChart.options.scales.y.grid.lineWidth = Math.max(0.5, newSizes.borderWidth * 0.4);

                    feeChart.options.scales.x.title.font.size = newSizes.xTitle;
                    feeChart.options.scales.x.title.display = window.innerWidth > 400;
                    feeChart.options.scales.x.ticks.font.size = newSizes.xTick;
                    feeChart.options.scales.x.ticks.maxRotation = isVerySmall ? 60 : (isMobile ? 45 : 35);
                    feeChart.options.scales.x.ticks.minRotation = isVerySmall ? 45 : (isMobile ? 30 : 25);
                    feeChart.options.scales.x.ticks.autoSkipPadding = isVerySmall ? 5 : (isMobile ? 8 : 15);
                    feeChart.options.scales.x.ticks.maxTicksLimit = isVerySmall ? 4 : (isMobile ? 6 : 12);

                    feeChart.options.elements.line.borderWidth = Math.max(1.5, newSizes.borderWidth);
                    feeChart.options.elements.point.radius = newSizes.pointRadius;
                    feeChart.options.elements.point.hoverRadius = newSizes.pointHoverRadius;
                    feeChart.options.elements.point.borderWidth = Math.max(1, newSizes.borderWidth * 0.5);

                    feeChart.update('none');
                }
            }, 300);
        });

        // ==================== MAXIMIZE CHART MODAL LOGIC ====================
        const maximizeBtn = document.getElementById('maximizeChartBtn');
        const modalElement = document.getElementById('chartMaximizeModal');
        let maximizeChart = null;

        if (maximizeBtn && modalElement) {
            const modal = new bootstrap.Modal(modalElement);

            maximizeBtn.addEventListener('click', () => {
                modal.show();
            });

            // When modal is shown, create a new chart in the modal canvas
            modalElement.addEventListener('shown.bs.modal', function() {
                const modalCanvas = document.getElementById('maximizedChartCanvas');
                if (!modalCanvas) return;

                // Destroy previous chart instance if exists
                if (maximizeChart) {
                    maximizeChart.destroy();
                }

                const modalCtx = modalCanvas.getContext('2d');

                // Get modal-specific font sizes (larger for better visibility)
                function getModalFontSizes() {
                    const width = window.innerWidth;
                    if (width < 576) {
                        return {
                            tooltipTitle: 14,
                            tooltipBody: 12,
                            legend: 16,
                            yTitle: 16,
                            yTick: 14,
                            xTitle: 16,
                            xTick: 13,
                            pointRadius: 6,
                            pointHoverRadius: 9,
                            borderWidth: 2.5,
                            stepSize: 10,
                            padding: 12
                        };
                    } else if (width < 768) {
                        return {
                            tooltipTitle: 18,
                            tooltipBody: 16,
                            legend: 20,
                            yTitle: 20,
                            yTick: 17,
                            xTitle: 20,
                            xTick: 16,
                            pointRadius: 8,
                            pointHoverRadius: 12,
                            borderWidth: 3,
                            stepSize: 10,
                            padding: 16
                        };
                    } else {
                        return {
                            tooltipTitle: 24,
                            tooltipBody: 22,
                            legend: 28,
                            yTitle: 28,
                            yTick: 24,
                            xTitle: 28,
                            xTick: 22,
                            pointRadius: 10,
                            pointHoverRadius: 15,
                            borderWidth: 4,
                            stepSize: 10,
                            padding: 20
                        };
                    }
                }

                const modalSizes = getModalFontSizes();
                const isMobile = window.innerWidth < 576;

                // Create maximized chart options with larger fonts
                const maximizedOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        tooltip: {
                            backgroundColor: '#1f2d3d',
                            titleColor: '#ffffff',
                            bodyColor: '#eef2f0',
                            borderColor: '#28a745',
                            borderWidth: Math.max(1, modalSizes.borderWidth * 0.5),
                            titleFont: {
                                size: modalSizes.tooltipTitle,
                                weight: 'bold',
                                family: "'Inter', 'Segoe UI', sans-serif"
                            },
                            bodyFont: {
                                size: modalSizes.tooltipBody,
                                family: "'Inter', 'Segoe UI', sans-serif"
                            },
                            padding: Math.max(8, modalSizes.padding * 0.6),
                            cornerRadius: Math.max(8, modalSizes.padding * 0.5),
                            callbacks: {
                                label: function(context) {
                                    return `₱ ${context.parsed.y.toFixed(2)} per tray`;
                                }
                            }
                        },
                        legend: {
                            labels: {
                                font: {
                                    size: modalSizes.legend,
                                    weight: 'bold',
                                    family: "'Inter', 'Segoe UI', sans-serif"
                                },
                                color: '#1f2d3d',
                                usePointStyle: true,
                                boxWidth: Math.max(12, modalSizes.legend * 0.7),
                                padding: Math.max(10, modalSizes.padding * 0.8)
                            },
                            position: isMobile ? 'bottom' : 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: window.innerWidth > 400,
                                text: 'Amount (PHP)',
                                font: {
                                    size: modalSizes.yTitle,
                                    weight: 'bold',
                                    family: "'Inter', 'Segoe UI', sans-serif"
                                },
                                color: '#dc3545',
                                padding: { bottom: Math.max(6, modalSizes.yTitle * 0.3) }
                            },
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000) {
                                        return '₱' + (value / 1000).toFixed(1) + 'k';
                                    }
                                    return '₱' + value.toFixed(2);
                                },
                                font: {
                                    size: modalSizes.yTick,
                                    weight: 'bold',
                                    family: "'Inter', 'Segoe UI', sans-serif"
                                },
                                stepSize: modalSizes.stepSize,
                                maxTicksLimit: isMobile ? 5 : 8
                            },
                            grid: { color: '#e9ecef', lineWidth: Math.max(0.5, modalSizes.borderWidth * 0.4) }
                        },
                        x: {
                            title: {
                                display: window.innerWidth > 400,
                                text: 'Date',
                                font: {
                                    size: modalSizes.xTitle,
                                    weight: 'bold',
                                    family: "'Inter', 'Segoe UI', sans-serif"
                                },
                                color: '#28a745',
                                padding: { top: Math.max(6, modalSizes.xTitle * 0.3) }
                            },
                            ticks: {
                                font: {
                                    size: modalSizes.xTick,
                                    weight: 'bold',
                                    family: "'Inter', 'Segoe UI', sans-serif"
                                },
                                maxRotation: isMobile ? 45 : 35,
                                minRotation: isMobile ? 30 : 25,
                                autoSkip: true,
                                autoSkipPadding: isMobile ? 8 : 15,
                                maxTicksLimit: isMobile ? 6 : 12
                            },
                            grid: { display: false }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    elements: {
                        line: {
                            borderJoin: 'round',
                            borderWidth: Math.max(2, modalSizes.borderWidth)
                        },
                        point: {
                            radius: modalSizes.pointRadius,
                            hoverRadius: modalSizes.pointHoverRadius,
                            borderWidth: Math.max(1.5, modalSizes.borderWidth * 0.5)
                        }
                    }
                };

                const modalDataset = {
                    label: 'Shipping Fee (PHP per tray)',
                    data: chartAmounts,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.05)',
                    borderWidth: Math.max(2, modalSizes.borderWidth),
                    pointRadius: modalSizes.pointRadius,
                    pointHoverRadius: modalSizes.pointHoverRadius,
                    pointBackgroundColor: '#28a745',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: Math.max(1.5, modalSizes.borderWidth * 0.5),
                    tension: 0.2,
                    fill: true,
                    pointStyle: 'circle'
                };

                maximizeChart = new Chart(modalCtx, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [modalDataset]
                    },
                    options: maximizedOptions
                });
            });

            // Destroy modal chart on close
            modalElement.addEventListener('hidden.bs.modal', function() {
                if (maximizeChart) {
                    maximizeChart.destroy();
                    maximizeChart = null;
                }
            });


            // Clean up when modal is hidden
            modalElement.addEventListener('hidden.bs.modal', function() {
                if (maximizeChart) {
                    maximizeChart.destroy();
                    maximizeChart = null;
                }
            });
        }

        // ================================================================
        // ================ NEW PDF EXPORT MODAL LOGIC ====================
        // ================================================================

        let pdfExportDataURL = null;

        function generatePDFFromDataURL(dataURL, fileName, orientation = 'landscape', pageSize = 'a4') {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF({
                orientation: orientation,
                unit: 'mm',
                format: pageSize
            });
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const margin = 10;
            const maxWidth = pageWidth - 2 * margin;
            const maxHeight = pageHeight - 2 * margin;
            const img = new Image();
            img.onload = function() {
                let imgWidth = img.width;
                let imgHeight = img.height;
                const ratio = Math.min(maxWidth / imgWidth, maxHeight / imgHeight);
                imgWidth = imgWidth * ratio;
                imgHeight = imgHeight * ratio;
                const x = (pageWidth - imgWidth) / 2;
                const y = (pageHeight - imgHeight) / 2;
                pdf.addImage(dataURL, 'PNG', x, y, imgWidth, imgHeight);
                pdf.save(fileName + '.pdf');
            };
            img.src = dataURL;
        }

        // Handle Export PDF button click -> open modal
        const exportBtn = document.getElementById('exportChartPDF');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                const chartCanvas = document.getElementById('feeHistoryChart');
                if (!chartCanvas) {
                    alert('Chart not found.');
                    return;
                }
                // Generate data URL from canvas
                const dataURL = chartCanvas.toDataURL('image/png');
                pdfExportDataURL = dataURL;

                // Set preview
                document.getElementById('pdfExportPreview').src = dataURL;
                document.getElementById('pdfExportChartTitle').textContent = 'Shipping Fee Trends';

                // Reset orientation & page size to defaults
                document.getElementById('pdfOrientation').value = 'landscape';
                document.getElementById('pdfPageSize').value = 'a4';

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('pdfExportModal'));
                modal.show();
            });
        }

        // Handle download button inside PDF modal
        document.getElementById('pdfDownloadBtn')?.addEventListener('click', function() {
            const dataURL = pdfExportDataURL;
            const fileName = 'shipping_fee_trends';
            const orientation = document.getElementById('pdfOrientation').value;
            const pageSize = document.getElementById('pdfPageSize').value;
            if (!dataURL) {
                alert('No chart data available. Please try again.');
                return;
            }
            generatePDFFromDataURL(dataURL, fileName, orientation, pageSize);
            // Optionally close modal after download
            // bootstrap.Modal.getInstance(document.getElementById('pdfExportModal')).hide();
        });

        // Clean up PDF modal when hidden
        document.getElementById('pdfExportModal')?.addEventListener('hidden.bs.modal', function() {
            pdfExportDataURL = null;
            document.getElementById('pdfExportPreview').src = '';
        });

        // --- Form submit spinner (unchanged) ---
        const feeForm = document.getElementById('feeUpdateForm');
        if (feeForm) {
            feeForm.addEventListener('submit', function() {
                const submitBtn = document.getElementById('saveFeeBtn');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Saving...';
                    submitBtn.disabled = true;
                }
            });
        }
    });
</script>
@endpush
@endsection
