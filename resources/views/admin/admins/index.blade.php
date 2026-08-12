@extends('admin.layouts.app')

@section('page-title', 'Manage Admins')
@section('header', 'Manage Admins')

@section('content')
<style nonce="{{ $csp_nonce }}">
    /* ============================================================
   ADMIN DASHBOARD - DEEPSEEK-STYLE RESPONSIVE STYLES
   Theme: White / Purple / Red
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
    transition: all 0.25s ease;
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
   TABLES
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

.btn-outline-info,
.btn-outline-warning,
.btn-outline-danger {
    border-width: 2px;
    font-size: var(--font-sm) !important;
    margin: 0 3px;
    transition: all 0.2s ease;
    border-radius: 3rem;
    padding: var(--sp-xs) var(--sp-md);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    min-height: 38px;
}

.btn-outline-info {
    color: var(--green-primary);
    border-color: var(--green-primary);
    background: transparent;
}

.btn-outline-info:hover {
    background: var(--green-primary);
    color: white;
    transform: scale(1.05);
}

.btn-outline-warning {
    color: var(--green-primary);
    border-color: var(--green-primary);
    background: transparent;
}

.btn-outline-warning:hover {
    background: var(--green-primary);
    color: white;
    transform: scale(1.05);
}

.btn-outline-danger {
    color: var(--red-primary);
    border-color: var(--red-primary);
    background: transparent;
}

.btn-outline-danger:hover {
    background: var(--red-primary);
    color: white;
    transform: scale(1.05);
}

/* ============================================================
   BADGES
   ============================================================ */
.role-badge {
    display: inline-block;
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 3rem;
    font-size: var(--font-sm) !important;
    font-weight: 600;
    text-transform: capitalize;
    background: var(--green-soft);
    color: var(--green-primary);
    transition: 0.2s ease;
}

.role-badge:hover {
    background: var(--green-primary);
    color: white;
    transform: scale(1.02);
}

.badge-status {
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 3rem;
    font-size: var(--font-sm) !important;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.badge-active {
    background: #E0F2E9;
    color: #0C6E4E;
    border-left: 4px solid var(--green-primary);
}

.badge-inactive {
    background: #FEF3F2;
    color: var(--red-primary);
    border-left: 4px solid var(--red-primary);
}

/* ============================================================
   PAGINATION
   ============================================================ */
.pagination {
    margin-top: var(--sp-lg);
    justify-content: center;
    font-size: var(--font-base);
}

.pagination .page-link {
    color: var(--green-primary);
    border-radius: 3rem;
    margin: 0 5px;
    transition: 0.2s ease;
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-md);
    font-weight: 600;
    min-height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.pagination .page-item.active .page-link {
    background: var(--green-primary);
    border-color: var(--green-primary);
    color: white;
}

.pagination .page-link:hover {
    background: var(--green-soft);
    color: var(--green-primary);
}

/* ============================================================
   FORM ELEMENTS
   ============================================================ */
.form-check-input:checked {
    background-color: var(--green-primary);
    border-color: var(--green-primary);
}

.form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    min-width: 1.2rem;
    min-height: 1.2rem;
}

.form-check-label {
    font-size: var(--font-base) !important;
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
    max-width: 500px !important;
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
    max-width: 500px !important;
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
    font-size: var(--font-xl) !important;
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

.modal-body .text-muted {
    font-size: var(--font-sm) !important;
    color: #5A6A72 !important;
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

.btn-modal-cancel {
    background: #f8f9fa !important;
    color: #6c757d !important;
    border: 1px solid #dee2e6 !important;
    transition: all 0.2s !important;
}

.btn-modal-cancel:hover {
    background: #e9ecef !important;
    color: #495057 !important;
    transform: translateY(-2px) !important;
}

.btn-modal-delete {
    background: var(--red-primary) !important;
    color: white !important;
    border: none !important;
    transition: all 0.2s !important;
}

.btn-modal-delete:hover {
    background: var(--red-dark) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 5px 12px rgba(78, 4, 97, 0.3) !important;
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
   UTILITY
   ============================================================ */
h5.text-white {
    color: #1e1e2f !important;
    font-weight: 700;
    font-size: var(--font-lg) !important;
}

.text-secondary {
    color: var(--gray-600) !important;
}

.text-danger {
    color: var(--red-primary) !important;
    font-weight: 600;
}

.text-success {
    color: var(--green-primary) !important;
    font-weight: 600;
}

small, .small, .text-secondary {
    font-weight: 400;
    color: #3F5C55 !important;
    font-size: var(--font-sm) !important;
}

a {
    color: var(--green-primary);
    text-decoration: none;
    font-weight: 500;
}

a:hover {
    color: var(--green-light);
    text-decoration: underline;
}

/* SVG icon styles */
.btn svg {
    width: 20px;
    height: 20px;
    vertical-align: middle;
    stroke-width: 2.5;
}

.btn-outline-info svg,
.btn-outline-warning svg,
.btn-outline-danger svg {
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

    body {
        font-size: var(--font-base);
    }

    p, span, li, a, label, input, select, textarea, button,
    .table, .badge, .small, .text-muted, .form-text,
    .modal-content, .btn, .form-label, .status-badge {
        font-size: var(--font-sm) !important;
    }

    h1 { font-size: var(--font-xxl) !important; }
    h2 { font-size: var(--font-xl) !important; }
    h3 { font-size: var(--font-lg) !important; }
    h4 { font-size: var(--font-md) !important; }
    h5 { font-size: var(--font-base) !important; }
    h6 { font-size: var(--font-sm) !important; }

    .chart-container {
        padding: var(--sp-md);
        border-radius: 1.5rem;
    }

    .stat-card {
        padding: var(--sp-md);
        border-radius: 1.5rem;
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

    .btn-outline-info,
    .btn-outline-warning,
    .btn-outline-danger {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .role-badge {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
    }

    .badge-status {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
    }

    .pagination .page-link {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .alert {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md);
        border-radius: 1rem;
    }

    /* Modal responsive */
    .modal-dialog {
        max-width: 95% !important;
        width: 95% !important;
        margin: 0.5rem auto !important;
    }

    .modal-header {
        padding: var(--sp-md) var(--sp-lg) !important;
    }

    .modal-header .modal-title {
        font-size: var(--font-lg) !important;
    }

    .modal-body {
        padding: var(--sp-md) !important;
        font-size: var(--font-sm) !important;
    }

    .modal-footer {
        padding: var(--sp-md) var(--sp-lg) !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
    }

    .modal-footer .btn {
        min-width: 100px !important;
        font-size: var(--font-sm) !important;
        min-height: 36px !important;
        margin: var(--sp-xs) !important;
    }

    .form-check-label {
        font-size: var(--font-sm) !important;
    }

    .form-check-input {
        width: 1rem;
        height: 1rem;
        min-width: 1rem;
        min-height: 1rem;
    }

    .text-secondary small {
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

    .chart-container {
        padding: var(--sp-sm);
        border-radius: 1.2rem;
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

    .btn-outline-info,
    .btn-outline-warning,
    .btn-outline-danger {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
    }

    .role-badge {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
    }

    .badge-status {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
    }

    .pagination .page-link {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-xs);
        min-height: 28px;
    }

    .alert {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 0.8rem;
    }

    .modal-header {
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    .modal-header .modal-title {
        font-size: var(--font-md) !important;
    }

    .modal-body {
        padding: var(--sp-sm) !important;
        font-size: var(--font-xs) !important;
    }

    .modal-footer {
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    .modal-footer .btn {
        min-width: 80px !important;
        font-size: var(--font-xs) !important;
        min-height: 32px !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    .form-check-label {
        font-size: var(--font-xs) !important;
    }

    .form-check-input {
        width: 0.9rem;
        height: 0.9rem;
        min-width: 0.9rem;
        min-height: 0.9rem;
    }

    .btn svg {
        width: 16px;
        height: 16px;
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

    .stat-card .text-secondary {
        font-size: var(--font-xs) !important;
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
        padding: 0.05rem var(--sp-xs);
        min-height: 30px;
    }

    .btn-danger {
        font-size: 0.55rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 30px;
    }

    .modal-header .modal-title {
        font-size: var(--font-sm) !important;
    }

    .modal-body {
        font-size: 0.6rem !important;
    }

    .modal-footer .btn {
        font-size: 0.55rem !important;
        min-height: 28px !important;
        min-width: 70px !important;
    }

    .pagination .page-link {
        font-size: 0.55rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 24px;
    }

    .alert {
        font-size: 0.55rem !important;
        padding: 0.05rem var(--sp-xs);
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

    .modal-header .modal-title {
        font-size: 0.6rem !important;
    }

    .modal-footer .btn {
        font-size: 0.45rem !important;
        min-height: 24px !important;
        min-width: 60px !important;
    }
}
</style>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Total Admins</p>
                    <h2 class="fw-bold text-success">{{ $admins->total() }}</h2>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Active Admins</p>
                    <h2 class="fw-bold text-success">{{ $admins->where('is_active', true)->count() }}</h2>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Super Admins</p>
                    <h2 class="fw-bold">{{ $admins->where('role', 'super_admin')->count() }}</h2>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Fleet Managers</p>
                    <h2 class="fw-bold">{{ $admins->where('role', 'fleet_manager')->count() }}</h2>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13" />
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
                        <circle cx="5.5" cy="18" r="2.5" />
                        <circle cx="18.5" cy="18" r="2.5" />
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
        <h5 class="mb-0" style="color:#0A2B25; font-weight:700;">All Administrators</h5>
        <a href="{{ route('admin.admins.create') }}" class="btn btn-danger">
            <i class="fas fa-plus me-2"></i>Add New Admin
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr style="animation: fadeInUp 0.4s ease-out;">
                    <td>{{ $admin->id }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <span class="role-badge role-{{ $admin->role }}">
                            {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                        </span>
                    </td>
                    <td>
                        @if($admin->is_active)
                            <span class="badge-status badge-active"><i class="fas fa-check-circle"></i> Active</span>
                        @else
                            <span class="badge-status badge-inactive"><i class="fas fa-times-circle"></i> Inactive</span>
                        @endif
                    </td>
                    <td>{{ $admin->last_login_at ? \Carbon\Carbon::parse($admin->last_login_at)->diffForHumans() : 'Never' }}</td>
                    <td>
                        <div class="btn-group d-flex gap-1">
                            <a href="{{ route('admin.admins.show', $admin->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                            </a>
                            @if($admin->id != auth()->guard('admin')->id())
                                <button class="btn btn-sm btn-outline-danger delete-admin-btn"
                                        data-id="{{ $admin->id }}"
                                        data-name="{{ $admin->name }}"
                                        data-email="{{ $admin->email }}"
                                        data-url="{{ route('admin.admins.destroy', $admin->id) }}"
                                        title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-secondary py-5">
                        <i class="fas fa-users fa-3x mb-3 d-block"></i>No admins found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        {{ $admins->links() }}
    </div>
</div>

<!-- Delete Confirmation Modal (Bootstrap 5) -->
<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAdminModalLabel">
                    <i class="fas fa-exclamation-triangle me-2" style="color: #dc2626;"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3" id="deleteModalMessage">Are you sure you want to delete this admin?</p>
                <div class="bg-light p-3 rounded-3 mb-3" style="background: #f8f9fa !important; border-radius: 12px !important;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold text-secondary">Name:</span>
                        <span id="deleteAdminName" class="fw-bold" style="color: #1A2C2A;">—</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold text-secondary">Email:</span>
                        <span id="deleteAdminEmail" class="fw-bold" style="color: #1A2C2A;">—</span>
                    </div>
                </div>
                <p class="text-danger small mb-0" style="font-size: 1.3rem !important;">
                    <i class="fas fa-exclamation-circle me-1"></i> This action cannot be undone. All associated data will be permanently removed.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-modal-delete" id="confirmDeleteBtn">
                    <i class="fas fa-trash-alt me-2"></i> Delete Permanently
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script nonce="{{ $csp_nonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        // Variables
        let adminIdToDelete = null;
        const deleteForm = document.getElementById('deleteForm');
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteAdminModal'));
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        const modalElement = document.getElementById('deleteAdminModal');

        // Handle delete button clicks
        document.querySelectorAll('.delete-admin-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const adminId = this.dataset.id;
                const adminName = this.dataset.name;
                const adminEmail = this.dataset.email;
                const deleteUrl = this.dataset.url;

                // Set the admin ID and form action
                adminIdToDelete = adminId;
                deleteForm.action = deleteUrl;

                // Update modal content with admin details
                document.getElementById('deleteAdminName').textContent = adminName;
                document.getElementById('deleteAdminEmail').textContent = adminEmail;
                document.getElementById('deleteModalMessage').innerHTML =
                    'Are you sure you want to delete admin <strong>' + adminName + '</strong>?';

                // Show the modal
                deleteModal.show();
            });
        });

        // Handle confirm deletion button
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                if (adminIdToDelete) {
                    // Show loading state
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Deleting...';
                    this.disabled = true;

                    // Submit the form
                    deleteForm.submit();

                    // Reset after a moment (in case form submission takes time)
                    setTimeout(function() {
                        confirmBtn.innerHTML = originalText;
                        confirmBtn.disabled = false;
                    }, 3000);
                }
            });
        }

        // Reset adminIdToDelete when modal is hidden
        if (modalElement) {
            modalElement.addEventListener('hidden.bs.modal', function() {
                adminIdToDelete = null;
                // Reset the confirm button state
                if (confirmBtn) {
                    confirmBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i> Delete Permanently';
                    confirmBtn.disabled = false;
                }
            });
        }

        // Handle modal close via backdrop click or X button
        document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (confirmBtn) {
                    confirmBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i> Delete Permanently';
                    confirmBtn.disabled = false;
                }
                adminIdToDelete = null;
            });
        });
    });
</script>
@endpush
@endsection
