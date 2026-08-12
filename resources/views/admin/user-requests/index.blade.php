{{-- resources/views/admin/user-requests/index.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Manage User Requests')
@section('title', 'User Requests Management')

@section('content')
<style nonce="{{ $csp_nonce }}">
/* ============================================================
   USER REQUESTS - DEEPSEEK-STYLE RESPONSIVE STYLES
   Theme: White / Violet (matching admin users page)
   ============================================================ */

:root {
    --violet-primary: #8610a3;
    --violet-light: #9a46e9;
    --violet-soft: #f3e8f7;
    --violet-dark: #4a148c;
    --violet-lighter: #faf8ff;
    --red-primary: #4e0461;
    --red-dark: #4e065c;
    --red-soft: #f8f0fa;
    --white: #FFFFFF;
    --gray-100: #F8F9FC;
    --gray-200: #E9ECF0;
    --gray-600: #5A6A72;
    --shadow-sm: 0 10px 25px -5px rgba(123, 31, 162, 0.05), 0 2px 4px -2px rgba(123, 31, 162, 0.02);
    --shadow-md: 0 20px 35px -12px rgba(123, 31, 162, 0.08);
    --radius-card: 2rem;
    --radius-btn: 3rem;

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
   RESET & BASE
   ============================================================ */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    font-size: 16px;
    -webkit-text-size-adjust: 100%;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    background: var(--white);
    color: #1A2C2A;
    font-size: var(--font-base);
    font-weight: 400;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ============================================================
   FIX: CONTAINER AND LAYOUT SPACING (MOBILE FIX)
   ============================================================ */
.container-fluid {
    padding-right: 15px !important;
    padding-left: 15px !important;
    max-width: 100% !important;
    overflow-x: hidden !important;
}

.container-fluid .row {
    margin-right: 0 !important;
    margin-left: 0 !important;
}

.container-fluid [class*="col-"] {
    padding-right: 10px !important;
    padding-left: 10px !important;
}

/* ============================================================
   TYPOGRAPHY
   ============================================================ */
p, span, li, a, label, input, select, textarea, button,
.table, .badge, .small, .text-muted, .form-text,
.modal-content, .btn, .form-label, .status-badge {
    font-size: var(--font-base) !important;
    line-height: 1.6 !important;
}

h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
    font-weight: 700 !important;
    letter-spacing: -0.02em;
    color: #0A2B25;
    line-height: 1.2;
}

h1 { font-size: var(--font-xxxl) !important; }
h2 { font-size: var(--font-xxl) !important; }
h3 { font-size: var(--font-xl) !important; }
h4 { font-size: var(--font-lg) !important; }
h5 { font-size: var(--font-md) !important; }
h6 { font-size: var(--font-base) !important; }

/* ============================================================
   CHART CONTAINER
   ============================================================ */
.chart-container {
    background: white;
    border-radius: var(--radius-card);
    padding: var(--sp-xl);
    box-shadow: var(--shadow-sm);
    font-size: var(--font-base);
    animation: fadeInUp 0.5s ease-out;
    border: 1px solid var(--gray-200);
}

.chart-container:hover {
    box-shadow: var(--shadow-md);
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

/* ============================================================
   STATS CARDS - Violet Theme
   ============================================================ */
.stat-card {
    background: white;
    border-radius: var(--radius-card);
    padding: var(--sp-xl) var(--sp-lg);
    border: 1px solid var(--gray-200);
    transition: all 0.25s;
    box-shadow: var(--shadow-sm);
}

.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-md);
    border-color: var(--violet-light);
}

.stat-icon {
    width: 72px;
    height: 72px;
    background: var(--violet-soft);
    border-radius: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-xl);
    color: var(--violet-primary);
}

.stat-card h2 {
    font-size: var(--font-xxl) !important;
    font-weight: 800;
    color: var(--violet-primary);
    margin-top: var(--sp-sm);
}

.stat-card .text-secondary {
    font-weight: 500;
    color: #3C4B46;
    font-size: var(--font-base) !important;
}

/* ============================================================
   TABLE - Violet Theme
   ============================================================ */
.table-custom {
    width: 100%;
    background: white;
    border-collapse: separate;
    border-spacing: 0;
    font-size: var(--font-base);
}

.table-custom th {
    background: var(--violet-soft);
    color: var(--violet-dark);
    font-weight: 700;
    padding: var(--sp-md) var(--sp-md);
    font-size: var(--font-sm) !important;
    border-bottom: 2px solid var(--violet-primary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-custom td {
    padding: var(--sp-md) var(--sp-md);
    vertical-align: middle;
    border-bottom: 1px solid var(--gray-200);
    color: #1A2C2A;
    font-size: var(--font-base) !important;
    transition: all 0.2s ease;
}

.table-custom tr:hover td {
    background-color: var(--violet-soft);
    transform: scale(1.01);
}

/* Row stagger animation */
.table-custom tbody tr:nth-child(1) { animation-delay: 0.02s; }
.table-custom tbody tr:nth-child(2) { animation-delay: 0.05s; }
.table-custom tbody tr:nth-child(3) { animation-delay: 0.08s; }
.table-custom tbody tr:nth-child(4) { animation-delay: 0.11s; }
.table-custom tbody tr:nth-child(5) { animation-delay: 0.14s; }
.table-custom tbody tr:nth-child(6) { animation-delay: 0.17s; }
.table-custom tbody tr:nth-child(7) { animation-delay: 0.20s; }
.table-custom tbody tr:nth-child(8) { animation-delay: 0.23s; }
.table-custom tbody tr:nth-child(9) { animation-delay: 0.26s; }
.table-custom tbody tr:nth-child(10) { animation-delay: 0.29s; }

/* ============================================================
   BUTTONS - Violet Theme
   ============================================================ */
.btn {
    border-radius: var(--radius-btn);
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    transition: all 0.2s ease;
    border: none;
    box-shadow: var(--shadow-sm);
    font-size: var(--font-base) !important;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-primary {
    background: var(--violet-primary);
    color: white;
}
.btn-primary:hover {
    background: var(--violet-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
}

.btn-success {
    background: var(--violet-primary);
    color: white;
}
.btn-success:hover {
    background: var(--violet-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
}

.btn-danger {
    background: var(--red-primary);
    border: none;
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    font-size: var(--font-base) !important;
    transition: all 0.25s ease;
    border-radius: var(--radius-btn);
    color: white;
    min-height: 44px;
}

.btn-danger:hover {
    background: var(--red-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
}

.btn-info {
    background: var(--violet-light);
    color: white;
}
.btn-info:hover {
    background: var(--violet-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
}

.btn-secondary {
    background: #6c757d;
    border-radius: 3rem;
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    color: white;
    border: none;
    min-height: 44px;
}

.btn-secondary:hover {
    transform: translateY(-2px);
    background: #5a6268;
    color: white;
}

.btn-outline-red {
    color: var(--red-primary);
    border: 2px solid var(--red-primary);
    background: transparent;
    border-radius: 3rem;
    padding: var(--sp-sm) var(--sp-lg);
    transition: all 0.25s ease;
    font-weight: 600;
    font-size: var(--font-sm) !important;
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-outline-red:hover {
    background: var(--red-primary);
    color: white;
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 8px 18px rgba(78, 4, 97, 0.3);
}

.btn-sm {
    padding: 0.25rem 0.7rem;
    font-size: 0.75rem;
    min-height: 30px;
    border-radius: 2rem;
}

/* ============================================================
   BADGES - Violet Theme
   ============================================================ */
.badge {
    font-size: var(--font-sm) !important;
    font-weight: 600 !important;
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 3rem;
    letter-spacing: 0.3px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    min-height: 32px;
    white-space: nowrap !important;
}

.badge.bg-warning {
    background: var(--violet-soft) !important;
    color: var(--violet-dark) !important;
    border: 1px solid var(--violet-primary);
}
.badge.bg-success {
    background: var(--violet-soft) !important;
    color: var(--violet-dark) !important;
    border: 1px solid var(--violet-primary);
}
.badge.bg-danger {
    background: var(--red-soft) !important;
    color: var(--red-primary) !important;
    border: 1px solid var(--red-primary);
}
.badge.bg-info {
    background: var(--violet-soft) !important;
    color: var(--violet-dark) !important;
    border: 1px solid var(--violet-primary);
}

/* ============================================================
   NAV TABS - Violet Theme
   ============================================================ */
.nav-tabs {
    border-bottom: 2px solid var(--gray-200);
    flex-wrap: wrap !important;
    gap: 4px !important;
}
.nav-tabs .nav-link {
    border: none;
    border-radius: 2rem 2rem 0 0;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    color: var(--gray-600);
    transition: all 0.2s;
    white-space: nowrap !important;
}
.nav-tabs .nav-link:hover {
    color: var(--violet-primary);
    background: var(--violet-soft);
}
.nav-tabs .nav-link.active {
    background: var(--violet-primary);
    color: #fff;
    border: none;
}

/* ============================================================
   PAGINATION - Violet Theme
   ============================================================ */
.pagination {
    gap: 6px;
    flex-wrap: wrap;
    justify-content: flex-end !important;
    margin: 0 !important;
    padding: 0 !important;
}
.pagination .page-item .page-link {
    border-radius: 3rem;
    padding: 0.4rem 0.9rem;
    color: var(--violet-primary);
    border: 1px solid var(--gray-200);
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.2s;
}
.pagination .page-item.active .page-link {
    background: var(--violet-primary);
    border-color: var(--violet-primary);
    color: #fff;
    transform: scale(1.05);
}
.pagination .page-item .page-link:hover {
    background: var(--violet-soft);
    color: var(--violet-primary);
    transform: translateY(-2px);
}

/* ============================================================
   CARD - Violet Theme
   ============================================================ */
.card {
    border-radius: 1.5rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    overflow: hidden;
    max-width: 100% !important;
}
.card-header {
    background: var(--white);
    border-bottom: 3px solid var(--violet-primary);
    padding: 1.2rem 1.5rem;
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 0.75rem !important;
}
.card-header .card-title {
    color: var(--violet-primary);
    font-weight: 700;
    font-size: 1.25rem;
}
.card-body {
    padding: 1.5rem;
    overflow-x: auto !important;
}

/* ============================================================
   MODAL - Violet Theme
   ============================================================ */
.modal-content {
    border-radius: 2.5rem !important;
    border: none !important;
    background: var(--white) !important;
    box-shadow: 0 30px 50px rgba(123, 31, 162, 0.15) !important;
    position: relative !important;
    display: flex !important;
    flex-direction: column !important;
    pointer-events: auto !important;
    width: 100% !important;
    animation: modalGlowIn 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
}

@keyframes modalGlowIn {
    from {
        opacity: 0;
        transform: scale(0.96) translateY(-15px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.modal-header {
    border-bottom: 3px solid var(--violet-primary) !important;
    padding: var(--sp-lg) var(--sp-xl) !important;
    background: var(--white) !important;
    border-radius: 2.5rem 2.5rem 0 0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
}

.modal-header .modal-title {
    font-size: var(--font-lg) !important;
    font-weight: 800 !important;
    color: var(--violet-primary) !important;
    margin: 0 !important;
    line-height: 1.2 !important;
}

.modal-header .btn-close {
    padding: var(--sp-sm) !important;
    margin: -0.5rem -0.5rem -0.5rem auto !important;
    background: transparent !important;
    font-size: var(--font-base) !important;
    opacity: 0.7 !important;
    min-height: 32px;
    min-width: 32px;
}

.modal-header .btn-close:hover {
    opacity: 1 !important;
}

.modal-body {
    padding: var(--sp-xl) var(--sp-xl) !important;
    background: var(--white) !important;
    color: #1A2C2A !important;
    font-size: var(--font-base) !important;
}

.modal-body label {
    font-weight: 600 !important;
    color: #0A2B25 !important;
    margin-bottom: var(--sp-xs) !important;
    display: block !important;
    font-size: var(--font-base) !important;
}

.modal-body p {
    background: var(--gray-100) !important;
    padding: var(--sp-sm) var(--sp-md) !important;
    border-radius: 1.2rem !important;
    margin-bottom: var(--sp-sm) !important;
    color: #1A2C2A !important;
    font-weight: 400 !important;
    font-size: var(--font-base) !important;
}

.modal-body .text-danger {
    color: var(--red-primary) !important;
    font-size: var(--font-base) !important;
}

.modal-footer {
    padding: var(--sp-lg) var(--sp-xl) !important;
    border-top: 1px solid var(--gray-200) !important;
    background: var(--white) !important;
    border-radius: 0 0 2.5rem 2.5rem !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: var(--sp-sm) !important;
}

.modal-footer .btn {
    min-width: 120px !important;
    border-radius: 3rem !important;
    padding: var(--sp-sm) var(--sp-lg) !important;
    font-size: var(--font-base) !important;
    font-weight: 600 !important;
    min-height: 40px !important;
}

.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5) !important;
}

.modal-backdrop.fade {
    opacity: 0.5 !important;
}

.modal-backdrop.show {
    opacity: 0.5 !important;
}

/* ============================================================
   FORM CONTROLS
   ============================================================ */
.form-control {
    border-radius: 2rem;
    padding: 0.6rem 1.2rem;
    border: 1px solid var(--gray-200);
    transition: all 0.2s;
    max-width: 100% !important;
    box-sizing: border-box !important;
}
.form-control:focus {
    border-color: var(--violet-primary);
    box-shadow: 0 0 0 3px rgba(134, 16, 163, 0.15);
}

/* ============================================================
   ALERTS - Violet Theme
   ============================================================ */
.alert {
    border-radius: 1.5rem;
    border: none;
    font-size: var(--font-base) !important;
    padding: var(--sp-md) var(--sp-lg);
    word-break: break-word !important;
}

.alert-info {
    background: var(--violet-soft);
    color: var(--violet-dark);
}
.alert-success-custom {
    background: var(--violet-soft);
    color: var(--violet-dark);
}
.alert-danger-custom {
    background: var(--red-soft);
    color: var(--red-primary);
}
.alert-warning {
    background: var(--violet-soft);
    color: var(--violet-dark);
}

/* Current secret display */
.secret-display {
    background: var(--violet-soft);
    border-radius: 1rem;
    padding: 0.8rem 1.2rem;
    border-left: 4px solid var(--violet-primary);
    font-weight: 600;
    color: var(--violet-primary);
    word-break: break-all !important;
    overflow-wrap: break-word !important;
}

/* ============================================================
   STATS SMALL BOXES - Violet Theme
   ============================================================ */
.small-box {
    border-radius: 0.25rem;
    box-shadow: 0 0 1px rgba(0,0,0,0.125), 0 1px 3px rgba(0,0,0,0.2);
    display: block;
    margin-bottom: 20px;
    position: relative;
    padding: 1rem;
    width: 100% !important;
    overflow: hidden !important;
}
.small-box .inner {
    padding: 10px 0;
}
.small-box h3 {
    font-size: 2.2rem;
    font-weight: 700;
    margin: 0 0 5px 0;
    white-space: nowrap;
    padding: 0;
}
.small-box p {
    font-size: 1rem;
    margin: 0;
}
.small-box .icon {
    color: rgba(0,0,0,0.15);
    position: absolute;
    right: 10px;
    top: 10px;
    z-index: 0;
    font-size: 3.5rem;
}
.small-box.bg-warning {
    background-color: var(--violet-soft) !important;
    color: var(--violet-dark) !important;
    border: 1px solid var(--violet-primary);
}
.small-box.bg-success {
    background-color: var(--violet-soft) !important;
    color: var(--violet-dark) !important;
    border: 1px solid var(--violet-primary);
}
.small-box.bg-danger {
    background-color: var(--red-soft) !important;
    color: var(--red-primary) !important;
    border: 1px solid var(--red-primary);
}
.small-box.bg-info {
    background-color: var(--violet-soft) !important;
    color: var(--violet-dark) !important;
    border: 1px solid var(--violet-primary);
}

/* ============================================================
   UTILITY
   ============================================================ */
.text-danger {
    color: var(--red-primary) !important;
    font-weight: 600;
}
.text-success {
    color: var(--violet-primary) !important;
    font-weight: 600;
}
.text-secondary {
    color: #3F5C55 !important;
}
.text-violet {
    color: var(--violet-primary) !important;
}

small, .small {
    font-weight: 400;
    color: #3F5C55 !important;
    font-size: var(--font-sm) !important;
}

.btn svg {
    width: 18px;
    height: 18px;
    vertical-align: middle;
    stroke-width: 2.5;
}

/* ============================================================
   CHECKBOX FIX
   ============================================================ */
.table-custom input[type="checkbox"] {
    transform: scale(1.1);
    accent-color: var(--violet-primary);
    min-width: 16px !important;
    min-height: 16px !important;
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

    .stat-icon {
        width: 64px;
        height: 64px;
        font-size: var(--font-lg);
    }

    .stat-card h2 {
        font-size: var(--font-xl) !important;
    }

    .table-custom th {
        padding: var(--sp-sm) var(--sp-sm);
        font-size: var(--font-xs) !important;
    }

    .table-custom td {
        padding: var(--sp-sm) var(--sp-sm);
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

    /* FIX: Container padding for mobile */
    .container-fluid {
        padding-right: 10px !important;
        padding-left: 10px !important;
    }

    .container-fluid [class*="col-"] {
        padding-right: 5px !important;
        padding-left: 5px !important;
    }

    body, .table, .btn {
        font-size: var(--font-sm) !important;
    }

    .card-header {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start !important;
        padding: 0.8rem 1rem !important;
    }

    .card-header .d-flex {
        flex-wrap: wrap !important;
        width: 100% !important;
    }

    .card-header .btn {
        width: 100% !important;
        justify-content: center !important;
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    .card-body {
        padding: 0.8rem !important;
    }

    .stat-card {
        padding: var(--sp-md);
        margin-bottom: var(--sp-md);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        font-size: var(--font-md);
        border-radius: 20px;
    }

    .stat-card h2 {
        font-size: var(--font-lg) !important;
        margin-top: var(--sp-xs);
    }

    /* FIX: Table responsive and spacing */
    .table-responsive {
        padding: 0 !important;
        margin: 0 -0.5rem !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
    }

    .table-custom {
        min-width: 500px !important;
        font-size: var(--font-xs) !important;
    }

    .table-custom th {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-xs) !important;
    }

    .table-custom td {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-xs) !important;
    }

    .table-custom .d-flex {
        gap: 3px !important;
        flex-wrap: wrap !important;
    }

    .btn {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
        border-radius: 2rem;
    }

    .btn-sm {
        padding: 0.2rem 0.5rem;
        font-size: 0.65rem;
        min-height: 26px;
    }

    .badge {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 28px;
    }

    .small-box {
        padding: 0.6rem !important;
        margin-bottom: 12px !important;
    }

    .small-box h3 {
        font-size: 1.5rem;
    }
    .small-box .icon {
        font-size: 2.5rem;
    }

    .nav-tabs .nav-link {
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
    }

    /* FIX: Bulk action buttons */
    .mt-3 .btn {
        width: 100% !important;
        margin-bottom: 6px !important;
        justify-content: center !important;
    }

    .modal-dialog {
        max-width: 95% !important;
        width: 95% !important;
        margin: 0.5rem auto !important;
    }

    .modal-header {
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    .modal-header .modal-title {
        font-size: var(--font-md) !important;
    }

    .modal-body {
        padding: var(--sp-md) !important;
        font-size: var(--font-sm) !important;
    }

    .modal-footer {
        padding: var(--sp-sm) var(--sp-md) !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
    }

    .modal-footer .btn {
        min-width: 100px !important;
        font-size: var(--font-sm) !important;
        min-height: 36px !important;
        margin: var(--sp-xs) !important;
    }

    .pagination {
        justify-content: center !important;
    }

    .pagination .page-item .page-link {
        padding: 0.2rem 0.5rem;
        font-size: 0.7rem;
    }

    /* FIX: Stats row spacing */
    .row.mb-4 {
        margin-right: -4px !important;
        margin-left: -4px !important;
    }

    .row.mb-4 [class*="col-"] {
        padding-right: 4px !important;
        padding-left: 4px !important;
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
    .container-fluid {
        padding-right: 8px !important;
        padding-left: 8px !important;
    }

    .container-fluid [class*="col-"] {
        padding-right: 4px !important;
        padding-left: 4px !important;
    }

    .card-body {
        padding: 0.6rem !important;
    }

    .small-box {
        padding: 0.5rem !important;
    }
    .small-box h3 {
        font-size: 1.2rem;
    }
    .small-box p {
        font-size: 0.75rem;
    }
    .small-box .icon {
        font-size: 2rem;
    }

    .table-custom {
        min-width: 400px !important;
    }

    .table-custom td,
    .table-custom th {
        padding: 0.25rem 0.3rem !important;
        font-size: 0.65rem !important;
    }

    .btn {
        font-size: 0.7rem;
        padding: 0.2rem 0.6rem;
        min-height: 28px;
    }
    .btn-sm {
        font-size: 0.55rem;
        padding: 0.15rem 0.4rem;
        min-height: 22px;
    }

    .modal-dialog {
        margin: 0.5rem !important;
        max-width: 98% !important;
        width: 98% !important;
    }

    .pagination .page-item .page-link {
        padding: 0.15rem 0.4rem;
        font-size: 0.65rem;
    }

    .badge {
        font-size: 0.6rem !important;
        padding: 0.1rem 0.4rem !important;
        min-height: 20px !important;
    }
}

/* ============================================================
   FIX: TOAST NOTIFICATION (Added for better mobile support)
   ============================================================ */
.toast-notification {
    position: fixed;
    bottom: 30px;
    right: 30px;
    padding: 1rem 1.5rem;
    border-radius: 1rem;
    font-weight: 600;
    z-index: 99999;
    min-width: 300px;
    max-width: 500px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    animation: slideUp 0.4s ease;
    display: flex;
    align-items: center;
    gap: 12px;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@media (max-width: 576px) {
    .toast-notification {
        bottom: 15px !important;
        right: 15px !important;
        left: 15px !important;
        min-width: auto !important;
        max-width: calc(100% - 30px) !important;
        font-size: 0.85rem !important;
        padding: 0.8rem 1rem !important;
        border-radius: 0.8rem !important;
    }
}

/* ============================================================
   FIX: PROGRESS BAR
   ============================================================ */
.progress {
    height: 25px;
    background: var(--violet-soft);
    border-radius: 12px;
    overflow: hidden;
    max-width: 100% !important;
}

/* ============================================================
   FIX: DROPDOWN/ACTION BUTTONS CONTAINER
   ============================================================ */
.d-flex.gap-2.flex-wrap {
    gap: 0.5rem !important;
}

.d-flex.gap-2.flex-wrap .btn {
    white-space: nowrap !important;
}

@media (max-width: 576px) {
    .d-flex.gap-2.flex-wrap .btn {
        white-space: normal !important;
        font-size: 0.7rem !important;
        padding: 0.2rem 0.5rem !important;
        min-height: 28px !important;
    }

    .d-flex.gap-2.flex-wrap .btn svg {
        width: 14px !important;
        height: 14px !important;
    }
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; vertical-align: middle;">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <path d="M20 8v6M23 11h-6"/>
                        </svg>
                        User Access Requests
                    </h3>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#secretModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                                <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"/>
                                <circle cx="16.5" cy="9.5" r="2.5"/>
                            </svg>
                            Update Secret Code
                        </button>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#sendAllModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                            </svg>
                            Send to All Users
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-sm-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $stats['pending'] ?? 0 }}</h3>
                                    <p>Pending Requests</p>
                                </div>
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $stats['approved'] ?? 0 }}</h3>
                                    <p>Approved</p>
                                </div>
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $stats['rejected'] ?? 0 }}</h3>
                                    <p>Rejected</p>
                                </div>
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="15" y1="9" x2="9" y2="15"/>
                                        <line x1="9" y1="9" x2="15" y2="15"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $stats['total'] ?? 0 }}</h3>
                                    <p>Total Requests</p>
                                </div>
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}"
                               href="{{ route('admin.user-requests.index', ['status' => 'pending']) }}">
                                Pending <span class="badge bg-warning ms-1">{{ $stats['pending'] ?? 0 }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'approved' ? 'active' : '' }}"
                               href="{{ route('admin.user-requests.index', ['status' => 'approved']) }}">
                                Approved <span class="badge bg-success ms-1">{{ $stats['approved'] ?? 0 }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'rejected' ? 'active' : '' }}"
                               href="{{ route('admin.user-requests.index', ['status' => 'rejected']) }}">
                                Rejected <span class="badge bg-danger ms-1">{{ $stats['rejected'] ?? 0 }}</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Requests Table -->
                    <div class="table-responsive">
                        <table class="table table-custom table-hover">
                            <thead>
                                <tr>
                                    @if($status === 'pending')
                                    <th width="40">
                                        <input type="checkbox" id="selectAll" style="transform: scale(1.2); accent-color: var(--violet-primary);">
                                    </th>
                                    @endif
                                    <th>ID</th>
                                    <th>How They Know</th>
                                    <th>Message</th>
                                    <th>IP Address</th>
                                    <th>Submitted</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $request)
                                <tr>
                                    @if($status === 'pending')
                                    <td>
                                        <input type="checkbox" class="request-checkbox" value="{{ $request->id }}" style="transform: scale(1.2); accent-color: var(--violet-primary);">
                                    </td>
                                    @endif
                                    <td><strong>#{{ $request->id }}</strong></td>
                                    <td>{{ ucfirst($request->know_site) }}</td>
                                    <td>{{ Str::limit($request->message, 50) ?: 'No message' }}</td>
                                    <td>{{ $request->ip_address ?: 'N/A' }}</td>
                                    <td>{{ $request->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if($request->status === 'pending')
                                            <span class="badge bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <polyline points="12 6 12 12 16 14"/>
                                                </svg>
                                                Pending
                                            </span>
                                        @elseif($request->status === 'approved')
                                            <span class="badge bg-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                                </svg>
                                                Approved
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <line x1="15" y1="9" x2="9" y2="15"/>
                                                    <line x1="9" y1="9" x2="15" y2="15"/>
                                                </svg>
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @if($request->isPending())
                                                <button type="button" class="btn btn-success btn-sm approve-btn"
                                                        data-id="{{ $request->id }}"
                                                        data-url="{{ route('admin.user-requests.approve', $request) }}"
                                                        title="Approve">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M20 6L9 17l-5-5"/>
                                                    </svg>
                                                    Approve
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm reject-btn"
                                                        data-id="{{ $request->id }}"
                                                        data-url="{{ route('admin.user-requests.reject', $request) }}"
                                                        title="Reject">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="18" y1="6" x2="6" y2="18"/>
                                                        <line x1="6" y1="6" x2="18" y2="18"/>
                                                    </svg>
                                                    Reject
                                                </button>
                                            @endif
                                            <a href="{{ route('admin.user-requests.show', $request) }}"
                                               class="btn btn-info btn-sm" title="View">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                                View
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    data-id="{{ $request->id }}"
                                                    data-url="{{ route('admin.user-requests.destroy', $request) }}"
                                                    data-name="Request #{{ $request->id }}"
                                                    title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5" style="font-weight: 700; color: #6c757d;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 16px; display: block;">
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                        </svg>
                                        No requests found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($status === 'pending' && $requests->count() > 0)
                    <div class="mt-3">
                        <button type="button" class="btn btn-success" id="bulkApprove">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                            Bulk Approve Selected
                        </button>
                        <button type="button" class="btn btn-danger" id="bulkReject">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            Bulk Reject Selected
                        </button>
                    </div>
                    @endif

                    <!-- Pagination -->
                    <div class="mt-4 d-flex justify-content-end">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODALS -->
<!-- ============================================================ -->

<!-- Secret Code Modal -->
<div class="modal fade" id="secretModal" tabindex="-1" aria-labelledby="secretModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="secretModalLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                        <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"/>
                        <circle cx="16.5" cy="9.5" r="2.5"/>
                    </svg>
                    Update Secret Code
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.user-requests.update-secret') }}" method="POST" id="secretForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="secret_code" class="form-label fw-bold">New Secret Code</label>
                        <input type="text" name="secret_code" id="secret_code" class="form-control"
                               placeholder="Enter new secret code" required minlength="6" maxlength="20">
                        <small class="form-text text-muted">
                            Current code: <strong id="currentSecret">Loading...</strong>
                        </small>
                        <div class="mt-2">
                            <small class="text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 4px;">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="16" x2="12" y2="12"/>
                                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                                </svg>
                                Default: 111111111
                            </small>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="12" x2="12" y2="16"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        Changing the secret code will affect all old customers trying to access the platform.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="updateSecretBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Update Secret
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send to All Users Modal -->
<div class="modal fade" id="sendAllModal" tabindex="-1" aria-labelledby="sendAllModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendAllModalLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                    Send Secret Code to All Users
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    This will send the current secret code to all registered users via SMS.
                </div>
                <div class="secret-display mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;">
                        <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"/>
                        <circle cx="16.5" cy="9.5" r="2.5"/>
                    </svg>
                    Current Secret Code: <strong id="sendAllSecretCode">Loading...</strong>
                </div>
                <div class="alert alert-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <strong>Warning:</strong> This action will send SMS to <strong id="sendAllUserCount">0</strong> users.
                    Please confirm before proceeding.
                </div>
                <div id="sendAllProgress" style="display: none;">
                    <p>Sending secret code to <strong id="sendAllProgressCount">0</strong> users...</p>
                    <div class="progress" style="height: 25px; background: var(--violet-soft); border-radius: 12px; overflow: hidden;">
                        <div id="sendAllProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; background: var(--violet-primary);" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                    <div id="sendAllLog" class="mt-3 small" style="max-height: 150px; overflow-y: auto;"></div>
                </div>
                <div id="sendAllResult" style="display: none;">
                    <div class="alert alert-success-custom" id="sendAllSuccessAlert" style="display: none;"></div>
                    <div class="alert alert-danger-custom" id="sendAllErrorAlert" style="display: none;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="sendAllCloseBtn">Close</button>
                <button type="button" class="btn btn-success" id="sendAllConfirmBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                    Send to All Users
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Approve Confirmation Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; color: #28a745;">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    Approve Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this user request?</p>
                <p class="text-muted">The user will be notified and granted access to the platform.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmApproveBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Yes, Approve
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Confirmation Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; color: #dc3545;">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    Reject Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject this user request?</p>
                <p class="text-muted">The user will be notified that their request was rejected.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmRejectBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Yes, Reject
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: var(--red-primary) !important;">
                <h5 class="modal-title" style="color: var(--red-primary);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>
                    Delete Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteItemName"></strong>?</p>
                <div class="alert alert-danger-custom mt-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    This action cannot be undone.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="bulkModalHeader">
                <h5 class="modal-title" id="bulkModalTitle">Bulk Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="bulkModalBody">
                <p>Are you sure you want to perform this action on selected requests?</p>
                <p id="bulkModalCount" class="text-muted"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="bulkForm" method="POST" style="display: inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-success" id="confirmBulkBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                        Yes, Proceed
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script nonce="{{ $csp_nonce }}">
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // ============================================================
    // VARIABLES
    // ============================================================
    var pendingAction = null;
    var pendingActionUrl = null;
    var pendingActionId = null;
    var selectedIds = [];

    // ============================================================
    // LOAD CURRENT SECRET - HARDCODED URL
    // ============================================================
    function loadCurrentSecret(callback) {
        var timestamp = new Date().getTime();
        var random = Math.random().toString(36).substring(7);
        var url = '/admin/user-requests/secret?_=' + timestamp + '&r=' + random + '&nocache=' + Date.now();

        console.log('[Secret] Fetching from URL:', url);

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache, no-store, must-revalidate, max-age=0',
                'Pragma': 'no-cache',
                'Expires': '0'
            },
            cache: 'no-store',
            credentials: 'same-origin'
        })
        .then(function(response) {
            console.log('[Secret] Response status:', response.status);
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            console.log('[Secret] Data received:', data);
            var secretCode = data.secret_code || '111111111';
            console.log('[Secret] Code from server:', secretCode);

            var currentSecretEl = document.getElementById('currentSecret');
            var sendAllSecretEl = document.getElementById('sendAllSecretCode');
            var secretInput = document.getElementById('secret_code');

            if (currentSecretEl) {
                currentSecretEl.textContent = secretCode;
                currentSecretEl.style.color = '#28a745';
                currentSecretEl.style.fontWeight = '700';
            }

            if (sendAllSecretEl) {
                sendAllSecretEl.textContent = secretCode;
                sendAllSecretEl.style.color = '#28a745';
                sendAllSecretEl.style.fontWeight = '700';
            }

            if (secretInput && !secretInput.value) {
                secretInput.placeholder = 'Current: ' + secretCode;
            }

            console.log('[Secret] UI updated successfully with:', secretCode);

            if (typeof callback === 'function') {
                callback(secretCode);
            }
        })
        .catch(function(error) {
            console.error('[Secret] Error loading:', error);
            var defaultMsg = '111111111 (default)';
            var currentSecretEl = document.getElementById('currentSecret');
            var sendAllSecretEl = document.getElementById('sendAllSecretCode');
            if (currentSecretEl) currentSecretEl.textContent = defaultMsg;
            if (sendAllSecretEl) sendAllSecretEl.textContent = defaultMsg;
            if (typeof callback === 'function') callback('111111111');
        });
    }

    // ============================================================
    // FORCE REFRESH
    // ============================================================
    function forceRefreshSecret() {
        console.log('[Secret] Forcing complete refresh...');
        if (window.localStorage) {
            try {
                Object.keys(localStorage).forEach(function(key) {
                    if (key.includes('secret') || key.includes('setting')) {
                        localStorage.removeItem(key);
                    }
                });
            } catch(e) {}
        }
        if (window.sessionStorage) {
            try {
                Object.keys(sessionStorage).forEach(function(key) {
                    if (key.includes('secret') || key.includes('setting')) {
                        sessionStorage.removeItem(key);
                    }
                });
            } catch(e) {}
        }
        loadCurrentSecret();
    }

    // ============================================================
    // LOAD USER COUNT
    // ============================================================
    function loadUserCount() {
        var timestamp = new Date().getTime();
        var random = Math.random().toString(36).substring(7);
        fetch('/admin/user-requests/user-count?_=' + timestamp + '&r=' + random, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache'
            },
            cache: 'no-store'
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            var countEl = document.getElementById('sendAllUserCount');
            if (countEl) {
                countEl.textContent = data.count || 0;
            }
        })
        .catch(function(error) {
            console.error('[UserCount] Error:', error);
            var countEl = document.getElementById('sendAllUserCount');
            if (countEl) {
                countEl.textContent = '?';
            }
        });
    }

    // ============================================================
    // INITIAL LOAD
    // ============================================================
    loadCurrentSecret();
    loadUserCount();

    // ============================================================
    // MODAL EVENTS
    // ============================================================
    var secretModal = document.getElementById('secretModal');
    if (secretModal) {
        secretModal.addEventListener('shown.bs.modal', function() {
            console.log('[Modal] Secret modal opened');
            document.getElementById('secret_code').value = '';
            setTimeout(function() {
                forceRefreshSecret();
            }, 100);
        });
    }

    var sendAllModal = document.getElementById('sendAllModal');
    if (sendAllModal) {
        sendAllModal.addEventListener('shown.bs.modal', function() {
            console.log('[Modal] Send all modal opened');
            setTimeout(function() {
                forceRefreshSecret();
                loadUserCount();
            }, 100);
        });
    }

    // ============================================================
    // SECRET CODE FORM
    // ============================================================
    document.getElementById('secretForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('updateSecretBtn');
        var originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Updating...';

        var form = this;
        var formData = new FormData(form);
        var secretCodeValue = document.getElementById('secret_code').value;

        if (!secretCodeValue || secretCodeValue.length < 6) {
            showToast('Please enter a secret code with at least 6 characters.', 'warning');
            btn.disabled = false;
            btn.innerHTML = originalText;
            return;
        }

        var timestamp = new Date().getTime();
        var random = Math.random().toString(36).substring(7);
        var url = '/admin/user-requests/update-secret?_=' + timestamp + '&r=' + random;

        console.log('[Update] Sending to:', url);
        console.log('[Update] New code:', secretCodeValue);

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache'
            }
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            console.log('[Update] Response:', data);
            btn.disabled = false;
            btn.innerHTML = originalText;
            var modal = bootstrap.Modal.getInstance(document.getElementById('secretModal'));
            if (modal) modal.hide();
            if (data.success) {
                showToast('✅ Secret code updated to: ' + secretCodeValue, 'success');
                setTimeout(function() {
                    forceRefreshSecret();
                    loadUserCount();
                }, 300);
                setTimeout(function() {
                    forceRefreshSecret();
                }, 1000);
            } else {
                showToast('❌ ' + (data.message || 'Failed to update.'), 'error');
            }
        })
        .catch(function(error) {
            console.error('[Update] Error:', error);
            btn.disabled = false;
            btn.innerHTML = originalText;
            showToast('❌ Network error. Please try again.', 'error');
        });
    });

    // ============================================================
    // SELECT ALL
    // ============================================================
    var selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.request-checkbox');
            checkboxes.forEach(function(cb) {
                cb.checked = selectAll.checked;
            });
        });
    }

    // ============================================================
    // GET SELECTED IDS
    // ============================================================
    function getSelectedIds() {
        var ids = [];
        document.querySelectorAll('.request-checkbox:checked').forEach(function(cb) {
            ids.push(cb.value);
        });
        return ids;
    }

    // ============================================================
    // BULK APPROVE
    // ============================================================
    var bulkApprove = document.getElementById('bulkApprove');
    if (bulkApprove) {
        bulkApprove.addEventListener('click', function() {
            var ids = getSelectedIds();
            if (ids.length === 0) {
                showToast('Please select at least one request.', 'warning');
                return;
            }
            selectedIds = ids;
            document.getElementById('bulkModalTitle').textContent = 'Bulk Approve Requests';
            document.getElementById('bulkModalBody').innerHTML = 'Are you sure you want to approve <strong>' + ids.length + '</strong> selected request(s)?';
            document.getElementById('bulkModalCount').textContent = 'This action cannot be undone.';
            document.getElementById('bulkModalHeader').className = 'modal-header bg-success text-white';
            document.getElementById('confirmBulkBtn').className = 'btn btn-success';
            document.getElementById('confirmBulkBtn').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;"><path d="M20 6L9 17l-5-5"/></svg> Yes, Approve All';
            document.getElementById('bulkForm').action = '{{ route("admin.user-requests.bulk-approve") }}';
            var modal = new bootstrap.Modal(document.getElementById('bulkActionModal'));
            modal.show();
        });
    }

    // ============================================================
    // BULK REJECT
    // ============================================================
    var bulkReject = document.getElementById('bulkReject');
    if (bulkReject) {
        bulkReject.addEventListener('click', function() {
            var ids = getSelectedIds();
            if (ids.length === 0) {
                showToast('Please select at least one request.', 'warning');
                return;
            }
            selectedIds = ids;
            document.getElementById('bulkModalTitle').textContent = 'Bulk Reject Requests';
            document.getElementById('bulkModalBody').innerHTML = 'Are you sure you want to reject <strong>' + ids.length + '</strong> selected request(s)?';
            document.getElementById('bulkModalCount').textContent = 'This action cannot be undone.';
            document.getElementById('bulkModalHeader').className = 'modal-header bg-danger text-white';
            document.getElementById('confirmBulkBtn').className = 'btn btn-danger';
            document.getElementById('confirmBulkBtn').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Yes, Reject All';
            document.getElementById('bulkForm').action = '{{ route("admin.user-requests.bulk-reject") }}';
            var modal = new bootstrap.Modal(document.getElementById('bulkActionModal'));
            modal.show();
        });
    }

    // ============================================================
    // BULK FORM SUBMIT
    // ============================================================
    document.getElementById('bulkForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var btn = document.getElementById('confirmBulkBtn');
        var originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Processing...';

        selectedIds.forEach(function(id) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ ids: selectedIds })
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            btn.disabled = false;
            btn.innerHTML = originalText;
            var modal = bootstrap.Modal.getInstance(document.getElementById('bulkActionModal'));
            if (modal) modal.hide();
            if (data.success) {
                showToast(data.message || 'Action completed successfully.', 'success');
                setTimeout(function() {
                    forceRefreshSecret();
                    loadUserCount();
                    location.reload();
                }, 1000);
            } else {
                showToast(data.message || 'An error occurred.', 'error');
            }
        })
        .catch(function() {
            btn.disabled = false;
            btn.innerHTML = originalText;
            showToast('Network error. Please try again.', 'error');
        });
    });

    // ============================================================
    // APPROVE BUTTON
    // ============================================================
    document.querySelectorAll('.approve-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            pendingAction = 'approve';
            pendingActionUrl = this.getAttribute('data-url');
            pendingActionId = this.getAttribute('data-id');
            var modal = new bootstrap.Modal(document.getElementById('approveModal'));
            modal.show();
        });
    });

    document.getElementById('confirmApproveBtn').addEventListener('click', function() {
        var btn = this;
        var originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Processing...';

        fetch(pendingActionUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            btn.disabled = false;
            btn.innerHTML = originalText;
            var modal = bootstrap.Modal.getInstance(document.getElementById('approveModal'));
            if (modal) modal.hide();
            if (data.success) {
                showToast(data.message || 'Request approved successfully.', 'success');
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                showToast(data.message || 'An error occurred.', 'error');
            }
        })
        .catch(function() {
            btn.disabled = false;
            btn.innerHTML = originalText;
            showToast('Network error. Please try again.', 'error');
        });
    });

    // ============================================================
    // REJECT BUTTON
    // ============================================================
    document.querySelectorAll('.reject-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            pendingAction = 'reject';
            pendingActionUrl = this.getAttribute('data-url');
            pendingActionId = this.getAttribute('data-id');
            var modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        });
    });

    document.getElementById('confirmRejectBtn').addEventListener('click', function() {
        var btn = this;
        var originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Processing...';

        fetch(pendingActionUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            btn.disabled = false;
            btn.innerHTML = originalText;
            var modal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
            if (modal) modal.hide();
            if (data.success) {
                showToast(data.message || 'Request rejected successfully.', 'success');
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                showToast(data.message || 'An error occurred.', 'error');
            }
        })
        .catch(function() {
            btn.disabled = false;
            btn.innerHTML = originalText;
            showToast('Network error. Please try again.', 'error');
        });
    });

    // ============================================================
    // DELETE BUTTON
    // ============================================================
    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = this.getAttribute('data-url');
            var name = this.getAttribute('data-name');
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteForm').action = url;
            var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });

    // ============================================================
    // SEND ALL TO USERS
    // ============================================================
    document.getElementById('sendAllConfirmBtn').addEventListener('click', function() {
        var btn = this;
        var originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Sending...';

        var progressDiv = document.getElementById('sendAllProgress');
        var progressBar = document.getElementById('sendAllProgressBar');
        var logDiv = document.getElementById('sendAllLog');
        var resultDiv = document.getElementById('sendAllResult');
        var successAlert = document.getElementById('sendAllSuccessAlert');
        var errorAlert = document.getElementById('sendAllErrorAlert');

        progressDiv.style.display = 'block';
        resultDiv.style.display = 'none';
        logDiv.innerHTML = '';
        progressBar.style.width = '0%';
        progressBar.textContent = '0%';

        var timestamp = new Date().getTime();
        var random = Math.random().toString(36).substring(7);
        fetch('/admin/user-requests/send-to-all?_=' + timestamp + '&r=' + random, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache'
            }
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            btn.disabled = false;
            btn.innerHTML = originalText;
            progressBar.style.width = '100%';
            progressBar.textContent = '100%';
            progressBar.classList.remove('progress-bar-animated');

            progressDiv.style.display = 'none';
            resultDiv.style.display = 'block';

            if (data.success) {
                successAlert.style.display = 'block';
                successAlert.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> ' + data.message;
                errorAlert.style.display = 'none';

                if (data.sent && data.sent.length) {
                    data.sent.forEach(function(entry) {
                        var div = document.createElement('div');
                        div.className = 'text-success';
                        div.textContent = '✅ ' + entry;
                        logDiv.appendChild(div);
                    });
                }
                if (data.errors && data.errors.length) {
                    data.errors.forEach(function(entry) {
                        var div = document.createElement('div');
                        div.className = 'text-danger';
                        div.textContent = '❌ ' + entry;
                        logDiv.appendChild(div);
                    });
                }
                showToast(data.message || 'Secret code sent to all users.', 'success');
                setTimeout(function() {
                    forceRefreshSecret();
                }, 500);
                document.getElementById('sendAllCloseBtn').textContent = 'Close';
            } else {
                errorAlert.style.display = 'block';
                errorAlert.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg> ' + (data.message || 'An error occurred.');
                successAlert.style.display = 'none';
                showToast(data.message || 'Failed to send secret code.', 'error');
            }

            document.getElementById('sendAllCloseBtn').disabled = false;
            btn.style.display = 'none';
        })
        .catch(function() {
            btn.disabled = false;
            btn.innerHTML = originalText;
            progressDiv.style.display = 'none';
            resultDiv.style.display = 'block';
            errorAlert.style.display = 'block';
            errorAlert.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg> Network error. Please try again.';
            successAlert.style.display = 'none';
            showToast('Network error. Please try again.', 'error');
            document.getElementById('sendAllCloseBtn').disabled = false;
            btn.style.display = 'none';
        });
    });

    // Reset send all modal on close
    document.getElementById('sendAllModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('sendAllProgress').style.display = 'none';
        document.getElementById('sendAllResult').style.display = 'none';
        document.getElementById('sendAllProgressBar').style.width = '0%';
        document.getElementById('sendAllProgressBar').textContent = '0%';
        document.getElementById('sendAllProgressBar').classList.add('progress-bar-animated');
        document.getElementById('sendAllLog').innerHTML = '';
        document.getElementById('sendAllConfirmBtn').style.display = 'inline-block';
        document.getElementById('sendAllConfirmBtn').disabled = false;
        document.getElementById('sendAllConfirmBtn').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg> Send to All Users';
        document.getElementById('sendAllCloseBtn').textContent = 'Close';
        document.getElementById('sendAllCloseBtn').disabled = false;
    });

    // ============================================================
    // TOAST NOTIFICATION
    // ============================================================
    function showToast(message, type) {
        var existingToast = document.querySelector('.toast-notification');
        if (existingToast) existingToast.remove();

        var toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.style.cssText = 'position:fixed;bottom:30px;right:30px;padding:1rem 1.5rem;border-radius:1rem;font-weight:600;z-index:99999;min-width:300px;max-width:500px;box-shadow:0 10px 40px rgba(0,0,0,0.2);animation:slideUp 0.4s ease;display:flex;align-items:center;gap:12px;';

        if (type === 'success') {
            toast.style.background = '#28a745';
            toast.style.color = '#fff';
            toast.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> ' + message;
        } else if (type === 'error') {
            toast.style.background = '#dc3545';
            toast.style.color = '#fff';
            toast.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg> ' + message;
        } else if (type === 'warning') {
            toast.style.background = '#ffc107';
            toast.style.color = '#212529';
            toast.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> ' + message;
        } else {
            toast.style.background = '#17a2b8';
            toast.style.color = '#fff';
            toast.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg> ' + message;
        }

        document.body.appendChild(toast);

        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            toast.style.transition = 'all 0.4s ease';
            setTimeout(function() {
                if (toast.parentNode) toast.remove();
            }, 400);
        }, 3500);
    }

    // ============================================================
    // ADD TOAST STYLES
    // ============================================================
    var style = document.createElement('style');
    style.textContent = '@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }';
    document.head.appendChild(style);

    // ============================================================
    // RESET MODALS ON CLOSE
    // ============================================================
    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            pendingAction = null;
            pendingActionUrl = null;
            pendingActionId = null;
        });
    });

    console.log('[Secret] System initialized - ready for real-time updates');

});
</script>
@endpush
@endsection
