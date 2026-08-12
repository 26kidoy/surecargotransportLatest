@extends('admin.layouts.app')

@section('page-title', 'Manage Users')
@section('header', 'Manage Users')

@section('content')
<style nonce="{{ $csp_nonce }}">
 /* ============================================================
   USERS/STAFF LIST - DEEPSEEK-STYLE RESPONSIVE STYLES
   Theme: White / Purple / Green / Red
   ============================================================ */

:root {
    --green-primary: #8610a3;
    --green-light: #9a46e9;
    --green-soft: #E6F4EF;
    --red-primary: #4e0461;
    --red-dark: #4e065c;
    --red-soft: #FEF3F2;
    --white: #FFFFFF;
    --gray-100: #F8F9FC;
    --gray-200: #E9ECF0;
    --gray-600: #5A6A72;
    --shadow-sm: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
    --shadow-md: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
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
   STATS CARDS
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
    border-color: var(--green-light);
}

.stat-icon {
    width: 72px;
    height: 72px;
    background: var(--green-soft);
    border-radius: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-xl);
    color: var(--green-primary);
}

.stat-card h2 {
    font-size: var(--font-xxl) !important;
    font-weight: 800;
    color: var(--green-primary);
    margin-top: var(--sp-sm);
}

.stat-card .text-secondary {
    font-weight: 500;
    color: #3C4B46;
    font-size: var(--font-base) !important;
}

/* ============================================================
   TABLE
   ============================================================ */
.table-custom {
    width: 100%;
    background: white;
    border-collapse: separate;
    border-spacing: 0;
    font-size: var(--font-base);
}

.table-custom th {
    background: #F4F8F6;
    color: #0A4D3E;
    font-weight: 700;
    padding: var(--sp-md) var(--sp-md);
    font-size: var(--font-sm) !important;
    border-bottom: 2px solid var(--gray-200);
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
    background-color: var(--green-soft);
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
   BUTTONS
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

/* ============================================================
   BADGES
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
}

.badge.bg-danger {
    background: var(--red-primary) !important;
}
.badge.bg-success {
    background: var(--green-primary) !important;
}
.badge.bg-info {
    background: #0dcaf0 !important;
    color: #1a1a1a;
}
.badge.bg-warning {
    background: #ffc107 !important;
    color: #1a1a1a;
}
.badge.bg-secondary {
    background: #6c757d !important;
}

/* ============================================================
   PAGINATION
   ============================================================ */
.pagination {
    margin-top: var(--sp-lg);
    justify-content: center;
    gap: 6px;
    flex-wrap: wrap;
    font-size: var(--font-base);
}

.pagination .page-item .page-link {
    font-size: var(--font-base) !important;
    font-weight: 600;
    padding: var(--sp-sm) var(--sp-md);
    border-radius: 3rem;
    color: var(--green-primary);
    border: 1px solid var(--gray-200);
    transition: all 0.2s;
    min-height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.pagination .page-item.active .page-link {
    background: var(--green-primary);
    border-color: var(--green-primary);
    color: white;
    transform: scale(1.05);
}

.pagination .page-item .page-link:hover {
    background: var(--green-soft);
    color: var(--green-primary);
    transform: translateY(-2px);
}

/* ============================================================
   ALERTS
   ============================================================ */
.alert {
    border-radius: 1.5rem;
    border: none;
    font-size: var(--font-base) !important;
    padding: var(--sp-md) var(--sp-lg);
}

.alert-success {
    background: #E0F2E9;
    color: #0C6E4E;
}

.alert-danger {
    background: #FEF3F2;
    color: var(--red-primary);
}

.alert .btn-close {
    font-size: var(--font-base);
}

/* ============================================================
   MODAL - DEEPSEEK STYLE
   ============================================================ */
.modal {
    text-align: center !important;
    padding: 0 !important;
}

.modal:before {
    content: '' !important;
    display: inline-block !important;
    height: 100% !important;
    vertical-align: middle !important;
    margin-right: -4px !important;
}

.modal-dialog {
    display: inline-block !important;
    text-align: left !important;
    vertical-align: middle !important;
    max-width: 550px !important;
    width: 90% !important;
    margin: 1.75rem auto !important;
    position: relative !important;
    top: auto !important;
    bottom: auto !important;
    left: auto !important;
    right: auto !important;
    transform: none !important;
}

.modal-dialog-centered {
    display: inline-block !important;
    text-align: left !important;
    vertical-align: middle !important;
    max-width: 550px !important;
    width: 90% !important;
    margin: 1.75rem auto !important;
    min-height: auto !important;
    position: relative !important;
    top: auto !important;
    bottom: auto !important;
    left: auto !important;
    right: auto !important;
    transform: none !important;
}

.modal.fade .modal-dialog {
    transform: none !important;
    transition: none !important;
}

.modal.show .modal-dialog {
    transform: none !important;
}

.modal-content {
    border-radius: 2.5rem !important;
    border: none !important;
    background: var(--white) !important;
    box-shadow: 0 30px 50px rgba(0, 0, 0, 0.25) !important;
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
    border-bottom: 3px solid var(--green-primary) !important;
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
    color: var(--green-primary) !important;
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

.modal-open {
    overflow: hidden !important;
}

.modal-open .modal {
    overflow-x: hidden !important;
    overflow-y: auto !important;
}

.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out !important;
}

.modal.show .modal-dialog {
    transform: none !important;
}

/* ============================================================
   PROFILE IMAGE
   ============================================================ */
.profile-image-thumb {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--green-primary);
}

.profile-image-thumb:hover {
    transform: scale(1.1);
    transition: transform 0.2s;
}

/* ============================================================
   UTILITY
   ============================================================ */
.text-danger {
    color: var(--red-primary) !important;
    font-weight: 600;
}

.text-success {
    color: var(--green-primary) !important;
    font-weight: 600;
}

.text-secondary {
    color: #3F5C55 !important;
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

i.fa, i.fas, i.far {
    color: inherit;
    margin-right: 6px;
    font-size: var(--font-md);
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

    .chart-container {
        padding: var(--sp-lg);
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

    body, .table, .btn, .status-filter-select {
        font-size: var(--font-sm) !important;
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

    .chart-container {
        padding: var(--sp-md);
        border-radius: 1.5rem;
    }

    .table-custom th {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-xs);
    }

    .table-custom td {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-xs);
    }

    .btn {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
        border-radius: 2rem;
    }

    .btn-danger {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
    }

    .btn-outline-red {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .btn-secondary {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
    }

    .badge {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 28px;
    }

    .pagination .page-item .page-link {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .alert {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md);
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

    .modal-body label {
        font-size: var(--font-sm) !important;
    }

    .modal-body p {
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

    .profile-image-thumb {
        width: 40px;
        height: 40px;
        border-width: 1.5px;
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

    body, .table, .btn, .status-filter-select {
        font-size: var(--font-xs) !important;
    }

    .stat-card {
        padding: var(--sp-sm);
        border-radius: 1.2rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        font-size: var(--font-sm);
        border-radius: 16px;
    }

    .stat-card h2 {
        font-size: var(--font-md) !important;
    }

    .stat-card .text-secondary {
        font-size: var(--font-xs) !important;
    }

    .chart-container {
        padding: var(--sp-sm);
        border-radius: 1.2rem;
    }

    .table-custom th {
        font-size: 0.55rem !important;
        padding: var(--sp-xs) 0.2rem;
    }

    .table-custom td {
        font-size: 0.55rem !important;
        padding: var(--sp-xs) 0.2rem;
    }

    .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 1.5rem;
    }

    .btn-danger {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .btn-outline-red {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
    }

    .btn-secondary {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .badge {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 24px;
    }

    .pagination .page-item .page-link {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-xs);
        min-height: 28px;
    }

    .alert {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
    }

    .modal-header .modal-title {
        font-size: var(--font-sm) !important;
    }

    .modal-body {
        font-size: var(--font-xs) !important;
    }

    .modal-body label {
        font-size: var(--font-xs) !important;
    }

    .modal-body p {
        font-size: var(--font-xs) !important;
    }

    .modal-footer .btn {
        font-size: var(--font-xs) !important;
        min-height: 32px !important;
        min-width: 80px !important;
    }

    .profile-image-thumb {
        width: 32px;
        height: 32px;
        border-width: 1.5px;
    }

    i.fa, i.fas, i.far {
        font-size: var(--font-sm);
        margin-right: 4px;
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

    .stat-icon {
        width: 40px;
        height: 40px;
        font-size: var(--font-xs);
        border-radius: 12px;
    }

    .stat-card h2 {
        font-size: var(--font-sm) !important;
    }

    .table-custom th {
        font-size: 0.45rem !important;
        padding: 0.05rem 0.1rem;
    }

    .table-custom td {
        font-size: 0.45rem !important;
        padding: 0.05rem 0.1rem;
    }

    .btn {
        font-size: 0.55rem !important;
        min-height: 30px;
    }

    .btn-danger {
        font-size: 0.55rem !important;
        min-height: 30px;
    }

    .modal-footer .btn {
        font-size: 0.55rem !important;
        min-height: 28px !important;
        min-width: 70px !important;
    }

    .pagination .page-item .page-link {
        font-size: 0.55rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 24px;
    }

    .profile-image-thumb {
        width: 28px;
        height: 28px;
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

    .stat-icon {
        width: 32px;
        height: 32px;
        font-size: 0.5rem;
        border-radius: 10px;
    }

    .stat-card h2 {
        font-size: 0.6rem !important;
    }

    .btn {
        font-size: 0.45rem !important;
        min-height: 26px;
    }

    .btn-danger {
        font-size: 0.45rem !important;
        min-height: 26px;
    }

    .modal-footer .btn {
        font-size: 0.45rem !important;
        min-height: 24px !important;
        min-width: 60px !important;
    }

    .pagination .page-item .page-link {
        font-size: 0.45rem !important;
        min-height: 22px;
    }

    .profile-image-thumb {
        width: 24px;
        height: 24px;
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

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Total Users</p>
                    <h2 class="fw-bold text-success">{{ $users->total() }}</h2>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Poultry Owners</p>
                    <h2 class="fw-bold">{{ $users->where('user_type', 'poultry_owner')->count() }}</h2>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="chart-container">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h5 class="mb-0" style="color:#0A2B25; font-weight:700;">All Users</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-hover" id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Mobile Number</th>
                    <th>User Type</th>
                    <th>City</th>
                    <th>Role</th>
                    <th>Registered Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->full_name ?? ($user->first_name.' '.$user->last_name) }}</td>
                    <td>{{ $user->mobile_number ?? 'N/A' }}</td>
                    <td>
                        @php
                            $typeClass = match($user->user_type) {
                                'admin' => 'danger',
                                'driver' => 'info',
                                'poultry_owner' => 'warning',
                                default => 'secondary'
                            };
                            $typeIcon = match($user->user_type) {
                                'admin' => 'fa-user-shield',
                                'driver' => 'fa-truck',
                                'poultry_owner' => 'fa-egg',
                                default => 'fa-user'
                            };
                        @endphp
                        <span class="badge bg-{{ $typeClass }}">
                            <i class="fas {{ $typeIcon }} me-1"></i>
                            {{ ucfirst($user->user_type ?? 'customer') }}
                        </span>
                    </td>
                    <td>{{ $user->city ?? 'N/A' }}</td>
                    <td>{{ ucfirst($user->role ?? 'N/A') }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        <div class="btn-group d-flex gap-1">
                            {{-- Delete button --}}
                            <button type="button" class="btn btn-sm btn-outline-red delete-user-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteUserModal"
                                    data-url="{{ route('admin.users.destroy', $user->id) }}"
                                    data-name="{{ $user->full_name ?? ($user->first_name.' '.$user->last_name) }}"
                                    data-id="{{ $user->id }}"
                                    title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5" style="font-weight: 700; color: #6c757d;">
                        <i class="fas fa-users fa-3x mb-3 d-block"></i>No users found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        {{ $users->links() }}
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: var(--red-primary) !important;">
                <h5 class="modal-title" id="deleteUserModalLabel" style="color: var(--red-primary);">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3" id="deleteModalMessage">Are you sure you want to delete this user?</p>
                <div class="bg-light p-3 rounded-3 mb-3" style="background: #f8f9fa !important; border-radius: 12px !important;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold text-secondary">Name:</span>
                        <span id="deleteUserName" class="fw-bold" style="color: #1A2C2A;">—</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold text-secondary">ID:</span>
                        <span id="deleteUserId" class="fw-bold" style="color: #1A2C2A;">—</span>
                    </div>
                </div>
                <div id="deleteErrorContainer" style="display: none;">
                    <div class="alert alert-danger" role="alert" id="deleteErrorMessage">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <span id="deleteErrorText"></span>
                    </div>
                </div>
                <p class="text-danger small mb-0" style="font-size: 1.3rem !important;">
                    <i class="fas fa-exclamation-circle me-1"></i> This action cannot be undone. All associated data will be permanently removed.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash-alt me-2"></i>Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script nonce="{{ $csp_nonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        // =========================================
        // DELETE USER MODAL
        // =========================================
        var deleteModal = document.getElementById('deleteUserModal');
        var deleteForm = document.getElementById('deleteForm');
        var deleteUserName = document.getElementById('deleteUserName');
        var deleteUserId = document.getElementById('deleteUserId');
        var deleteModalMessage = document.getElementById('deleteModalMessage');
        var deleteErrorContainer = document.getElementById('deleteErrorContainer');
        var deleteErrorText = document.getElementById('deleteErrorText');
        var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                if (!button) {
                    console.warn('No relatedTarget found for delete modal');
                    return;
                }
                var url = button.getAttribute('data-url');
                var name = button.getAttribute('data-name');
                var id = button.getAttribute('data-id');

                if (deleteForm) {
                    deleteForm.action = url;
                }
                if (deleteUserName) {
                    deleteUserName.innerText = name || 'Unknown';
                }
                if (deleteUserId) {
                    deleteUserId.innerText = '#' + (id || 'N/A');
                }
                if (deleteModalMessage) {
                    deleteModalMessage.innerHTML = 'Are you sure you want to delete user <strong>' + (name || 'this user') + '</strong>?';
                }
                // Hide any previous errors
                if (deleteErrorContainer) {
                    deleteErrorContainer.style.display = 'none';
                }
                // Reset button state
                if (confirmDeleteBtn) {
                    confirmDeleteBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i>Delete Permanently';
                    confirmDeleteBtn.disabled = false;
                }
            });

            deleteModal.addEventListener('hidden.bs.modal', function() {
                // Hide any errors when modal is closed
                if (deleteErrorContainer) {
                    deleteErrorContainer.style.display = 'none';
                }
                // Reset button state
                if (confirmDeleteBtn) {
                    confirmDeleteBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i>Delete Permanently';
                    confirmDeleteBtn.disabled = false;
                }
            });
        }

        // Handle delete confirmation with loading state and error handling
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', function(e) {
                // Prevent default form submission
                e.preventDefault();
                
                // Show loading state
                var originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Deleting...';
                this.disabled = true;
                
                // Hide any previous errors
                if (deleteErrorContainer) {
                    deleteErrorContainer.style.display = 'none';
                }
                
                // Get the form
                var form = document.getElementById('deleteForm');
                var formData = new FormData(form);
                
                // Use fetch to handle the request and response properly
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    // Check if response is a redirect (success)
                    if (response.redirected) {
                        window.location.href = response.url;
                        return;
                    }
                    
                    // Check if response is OK
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || data.error || 'Server returned ' + response.status);
                        }).catch(() => {
                            // If response is not JSON, try text
                            return response.text().then(text => {
                                throw new Error('Server returned ' + response.status + ': ' + text.substring(0, 200));
                            });
                        });
                    }
                    
                    // If response is OK but not redirected, reload to show changes
                    return response.text().then(text => {
                        // Check if the response contains a success message
                        if (text.includes('success')) {
                            window.location.reload();
                        } else {
                            throw new Error('Unexpected response from server');
                        }
                    });
                })
                .catch(error => {
                    // Reset button state
                    confirmDeleteBtn.innerHTML = originalText;
                    confirmDeleteBtn.disabled = false;
                    
                    console.error('Delete error:', error);
                    
                    // Show error message
                    showDeleteError(error.message || 'An error occurred while deleting the user.');
                });
            });
        }
        
        // Helper function to show error in the modal or on the page
        function showDeleteError(message) {
            if (deleteErrorContainer && deleteErrorText) {
                deleteErrorText.textContent = message;
                deleteErrorContainer.style.display = 'block';
                // Scroll to error
                deleteErrorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                // Fallback: show error on the page
                var errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                               '<i class="fas fa-exclamation-circle me-2"></i> ' +
                               message +
                               '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                               '</div>';
                
                var chartContainer = document.querySelector('.chart-container');
                if (chartContainer) {
                    var existingAlert = chartContainer.querySelector('.alert-danger');
                    if (existingAlert) {
                        existingAlert.remove();
                    }
                    chartContainer.insertAdjacentHTML('afterbegin', errorHtml);
                }
            }
        }
    });
</script>
@endpush
@endsection