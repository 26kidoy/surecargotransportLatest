@extends('admin.layouts.app')

@section('title', 'Manage Trucks')
@section('page-title', 'Manage Trucks')

@section('content')
<style nonce="{{ $csp_nonce }}">
/* ============================================================
   TRUCKS LIST - DEEPSEEK-STYLE RESPONSIVE STYLES
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
   CONTAINER
   ============================================================ */
.trucks-list-container {
    background: var(--white);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-sm);
    padding: var(--sp-xl);
    transition: all 0.3s ease;
    border: 1px solid var(--gray-200);
}

.trucks-list-container:hover {
    box-shadow: var(--shadow-md);
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
.table {
    font-size: var(--font-base) !important;
}

.table th {
    background: #F4F8F6;
    color: #0A4D3E;
    font-weight: 700;
    border-bottom: 2px solid var(--gray-200);
    padding: var(--sp-md) var(--sp-md);
    font-size: var(--font-sm) !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
    padding: var(--sp-md) var(--sp-md);
    border-bottom: 1px solid var(--gray-200);
    color: #1A2C2A;
    font-size: var(--font-base) !important;
}

.table-hover tbody tr:hover {
    background-color: var(--green-soft);
    transition: all 0.3s ease;
}

/* ============================================================
   BADGES
   ============================================================ */
.badge-status {
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 3rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: var(--font-sm) !important;
    min-width: 90px;
    justify-content: center;
}

.badge-active {
    background: #E0F2E9;
    color: #0C6E4E;
    border-left: 4px solid var(--green-primary);
}

.badge-warning {
    background: #FFF3E0;
    color: #C45C0C;
    border-left: 4px solid #F59E0B;
}

.badge-inactive {
    background: #FEF3F2;
    color: var(--red-primary);
    border-left: 4px solid var(--red-primary);
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

.btn-add {
    background: var(--green-primary);
    border: none;
    border-radius: var(--radius-btn);
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    color: var(--white);
    transition: all 0.3s ease;
    font-size: var(--font-base) !important;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-add:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: var(--shadow-md);
    color: var(--white);
    background: var(--green-light);
}

.btn-group .btn {
    border-radius: 3rem;
    margin: 0 0.2rem;
    padding: var(--sp-xs) var(--sp-md);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-sm) !important;
    border-width: 2px;
    min-height: 38px;
}

.btn-group .btn svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    stroke-width: 2.5;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    vertical-align: middle;
}

.btn-outline-info {
    border-color: var(--green-primary);
    color: var(--green-primary);
    background: transparent;
}

.btn-outline-info:hover {
    background: var(--green-primary);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 0.3rem 0.8rem rgba(134, 16, 163, 0.3);
}

.btn-outline-warning {
    border-color: var(--green-primary);
    color: var(--green-primary);
    background: transparent;
}

.btn-outline-warning:hover {
    background: var(--green-primary);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 0.3rem 0.8rem rgba(134, 16, 163, 0.3);
}

.btn-outline-danger {
    border-color: var(--red-primary);
    color: var(--red-primary);
    background: transparent;
}

.btn-outline-danger:hover {
    background: var(--red-primary);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 0.3rem 0.8rem rgba(78, 4, 97, 0.3);
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
   VIEW TOGGLE
   ============================================================ */
.view-toggle .btn {
    font-size: var(--font-sm) !important;
    font-weight: 600;
    border-radius: 3rem;
    padding: var(--sp-xs) var(--sp-lg);
    border: 2px solid var(--green-primary);
    color: var(--green-primary);
    background: transparent;
    transition: all 0.3s ease;
    min-height: 38px;
}

.view-toggle .btn.active {
    background: var(--green-primary);
    color: var(--white);
    border-color: var(--green-primary);
}

.view-toggle .btn:hover:not(.active) {
    background: var(--green-soft);
    transform: translateY(-2px);
}

/* ============================================================
   PAGINATION
   ============================================================ */
.pagination {
    margin-top: var(--sp-xl);
    justify-content: center;
    gap: 6px;
    flex-wrap: wrap;
}

.pagination .page-link {
    font-size: var(--font-base) !important;
    font-weight: 600;
    border-radius: 3rem;
    margin: 0 0.2rem;
    color: var(--green-primary);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    background: var(--white);
    padding: var(--sp-sm) var(--sp-md);
    min-height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.pagination .page-link:hover {
    background: var(--green-soft);
    border-color: var(--green-primary);
    transform: translateY(-2px);
}

.pagination .active .page-link {
    background: var(--green-primary);
    border-color: var(--green-primary);
    color: var(--white);
}

/* ============================================================
   IMAGE THUMBNAIL
   ============================================================ */
img.rounded-circle {
    border: 2px solid var(--green-primary);
    transition: all 0.3s ease;
    width: 50px;
    height: 50px;
    object-fit: cover;
}

img.rounded-circle:hover {
    transform: scale(1.1);
    box-shadow: 0 0.3rem 0.8rem rgba(134, 16, 163, 0.2);
}

/* ============================================================
   CARD VIEW
   ============================================================ */
.truck-card {
    border-radius: 1.5rem;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    overflow: hidden;
    background: var(--white);
    height: 100%;
    padding: 0;
}

.truck-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
    border-color: var(--green-primary);
}

.truck-card .card-body {
    padding: var(--sp-lg);
}

.truck-card .card-img-top {
    height: 200px;
    width: 100%;
    object-fit: cover;
    object-position: center;
    background: var(--gray-100);
    border-bottom: 2px solid var(--green-primary);
}

.truck-card .truck-info {
    font-size: var(--font-base);
    line-height: 1.6;
}

.truck-card .truck-info strong {
    color: var(--green-primary);
}

.truck-card .card-actions {
    border-top: 1px solid var(--gray-200);
    padding-top: var(--sp-md);
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: var(--sp-sm);
}

.truck-card .card-actions .btn {
    font-size: var(--font-sm) !important;
    padding: var(--sp-xs) var(--sp-md);
    min-width: 70px;
    border-radius: 3rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
    min-height: 36px;
}

.truck-card .card-actions .btn i {
    font-size: var(--font-base);
}

/* ============================================================
   VIEW CONTAINER
   ============================================================ */
.view-container {
    display: none;
}

.view-container.active {
    display: block;
    animation: fadeSlideUp 0.4s ease;
}

@keyframes fadeSlideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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

    .trucks-list-container {
        padding: var(--sp-lg);
    }

    .stat-icon {
        width: 64px;
        height: 64px;
        font-size: var(--font-lg);
    }

    .stat-card h2 {
        font-size: var(--font-xl) !important;
    }

    .truck-card .card-img-top {
        height: 160px;
    }

    .truck-card .card-body {
        padding: var(--sp-md);
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

    .trucks-list-container {
        padding: var(--sp-md);
        overflow-x: auto;
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

    .table th {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-xs);
    }

    .table td {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-xs);
    }

    .btn-add {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
    }

    .btn-group .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .view-toggle .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .truck-card .card-img-top {
        height: 150px;
    }

    .truck-card .card-body {
        padding: var(--sp-sm);
    }

    .truck-card .card-actions .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-width: 60px;
        min-height: 32px;
    }

    .badge-status {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-width: 70px;
    }

    .pagination .page-link {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .alert {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md);
    }

    /* Modal responsive */
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

    img.rounded-circle {
        width: 40px;
        height: 40px;
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

    .trucks-list-container {
        padding: var(--sp-sm);
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

    .table th {
        font-size: 0.55rem !important;
        padding: var(--sp-xs) 0.2rem;
    }

    .table td {
        font-size: 0.55rem !important;
        padding: var(--sp-xs) 0.2rem;
    }

    .btn-add {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .btn-group .btn {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
    }

    .view-toggle .btn {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
    }

    .truck-card .card-img-top {
        height: 120px;
    }

    .truck-card .card-actions .btn {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-width: 50px;
        min-height: 28px;
    }

    .badge-status {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-width: 60px;
    }

    .pagination .page-link {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-xs);
        min-height: 28px;
    }

    .alert {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
    }

    img.rounded-circle {
        width: 32px;
        height: 32px;
        border-width: 1.5px;
    }

    .modal-header .modal-title {
        font-size: var(--font-sm) !important;
    }

    .modal-body {
        font-size: var(--font-xs) !important;
    }

    .modal-footer .btn {
        font-size: var(--font-xs) !important;
        min-height: 32px !important;
        min-width: 80px !important;
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

    .table th {
        font-size: 0.45rem !important;
        padding: 0.05rem 0.1rem;
    }

    .table td {
        font-size: 0.45rem !important;
        padding: 0.05rem 0.1rem;
    }

    .btn-add {
        font-size: 0.55rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 30px;
    }

    .truck-card .card-img-top {
        height: 100px;
    }

    .truck-card .card-actions .btn {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-width: 45px;
        min-height: 24px;
    }

    .badge-status {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-width: 50px;
    }

    .pagination .page-link {
        font-size: 0.55rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 24px;
    }

    .modal-header .modal-title {
        font-size: var(--font-sm) !important;
    }

    .modal-footer .btn {
        font-size: 0.55rem !important;
        min-height: 28px !important;
        min-width: 70px !important;
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

    .btn-add {
        font-size: 0.45rem !important;
        min-height: 26px;
    }

    .truck-card .card-img-top {
        height: 80px;
    }

    .truck-card .card-actions .btn {
        font-size: 0.4rem !important;
        min-height: 22px;
        min-width: 40px;
    }

    .badge-status {
        font-size: 0.4rem !important;
        min-width: 40px;
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
                    <p class="text-secondary mb-1">Total Trucks</p>
                    <h2 class="fw-bold text-success">{{ $trucks->total() }}</h2>
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
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Available</p>
                    <h2 class="fw-bold text-success">{{ $trucks->where('status', 'available')->count() }}</h2>
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
                    <p class="text-secondary mb-1">Booked</p>
                    <h2 class="fw-bold">{{ $trucks->where('status', 'booked')->count() }}</h2>
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
                    <p class="text-secondary mb-1">Maintenance</p>
                    <h2 class="fw-bold">{{ $trucks->where('status', 'maintenance')->count() }}</h2>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 12h-4l-3 9-4-18-3 9H2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="trucks-list-container">
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

    <!-- Header with Add & View Toggle -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h3 class="fw-bold mb-0" style="color: var(--green-primary);">All Trucks</h3>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="btn-group view-toggle" role="group" aria-label="View toggle">
                <button type="button" class="btn active" data-view="table" id="viewTableBtn">
                    <i class="fas fa-table me-1"></i> Table
                </button>
                <button type="button" class="btn" data-view="card" id="viewCardBtn">
                    <i class="fas fa-th-large me-1"></i> Cards
                </button>
            </div>
            <a href="{{ route('admin.trucks.create') }}" class="btn btn-add">
                <i class="fas fa-plus me-2"></i>Add New Truck
            </a>
        </div>
    </div>

    <!-- Table View -->
    <div id="tableView" class="view-container active">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Truck Name</th>
                        <th>Truck #</th>
                        <th>Driver</th>
                        <th>Phone</th>
                        <th>Model/Color</th>
                        <th>Capacity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trucks as $truck)
                    <tr>
                        <td>{{ $truck->id }}</td>
                        <td>
                            @if($truck->image)
                                <img src="{{ asset($truck->image) }}" width="55" height="55" style="object-fit: cover; border-radius: 1rem; border: 2px solid var(--green-primary);">
                            @else
                                <div style="width: 55px; height: 55px; background: var(--gray-100); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-truck" style="color: var(--green-primary); font-size: 2rem;"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $truck->truck_name }}</td>
                        <td>{{ $truck->truck_number }}</td>
                        <td>{{ $truck->driver_name }}</td>
                        <td>{{ $truck->driver_phone }}</td>
                        <td>{{ $truck->truck_model }} / {{ $truck->color }}</td>
                        <td>{{ number_format($truck->max_capacity) }} trays</td>
                        <td>
                            <span class="badge-status
                                @if($truck->status == 'available') badge-active
                                @elseif($truck->status == 'booked') badge-warning
                                @else badge-inactive
                                @endif">
                                <i class="fas
                                    @if($truck->status == 'available') fa-check-circle
                                    @elseif($truck->status == 'booked') fa-clock
                                    @else fa-wrench
                                    @endif">
                                </i>
                                {{ ucfirst($truck->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.trucks.show', $truck->id) }}" class="btn btn-outline-info" title="View">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.trucks.edit', $truck->id) }}" class="btn btn-outline-warning" title="Edit">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                                    </svg>
                                </a>
                                <button type="button" class="btn btn-outline-danger delete-truck-btn"
                                        data-id="{{ $truck->id }}"
                                        data-name="{{ $truck->truck_name }}"
                                        data-number="{{ $truck->truck_number }}"
                                        data-url="{{ route('admin.trucks.destroy', $truck->id) }}"
                                        title="Delete">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-secondary">
                            <i class="fas fa-truck fa-3x mb-2 d-block"></i>
                            No trucks found. Click "Add New Truck" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 d-flex justify-content-end">
            {{ $trucks->links() }}
        </div>
    </div>

    <!-- Card View -->
    <div id="cardView" class="view-container">
        <div class="row g-4">
            @forelse($trucks as $truck)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="truck-card card h-100">
                    @if($truck->image)
                        <img src="{{ asset($truck->image) }}" class="card-img-top" alt="{{ $truck->truck_name }}">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center" style="height:200px; background: var(--gray-100);">
                            <i class="fas fa-truck" style="font-size: 4rem; color: var(--green-primary);"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold" style="font-size:1.8rem; color: var(--green-primary);">{{ $truck->truck_name }}</h5>
                        <div class="truck-info">
                            <p class="mb-1"><strong>#</strong> {{ $truck->truck_number }}</p>
                            <p class="mb-1"><strong>Driver:</strong> {{ $truck->driver_name }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $truck->driver_phone }}</p>
                            <p class="mb-1"><strong>Model/Color:</strong> {{ $truck->truck_model }} / {{ $truck->color }}</p>
                            <p class="mb-1"><strong>Capacity:</strong> {{ number_format($truck->max_capacity) }} trays</p>
                            <p class="mb-2">
                                <span class="badge-status
                                    @if($truck->status == 'available') badge-active
                                    @elseif($truck->status == 'booked') badge-warning
                                    @else badge-inactive
                                    @endif">
                                    <i class="fas
                                        @if($truck->status == 'available') fa-check-circle
                                        @elseif($truck->status == 'booked') fa-clock
                                        @else fa-wrench
                                        @endif">
                                    </i>
                                    {{ ucfirst($truck->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="card-actions mt-auto">
                            <a href="{{ route('admin.trucks.show', $truck->id) }}" class="btn btn-outline-info" title="View">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('admin.trucks.edit', $truck->id) }}" class="btn btn-outline-warning" title="Edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-outline-danger delete-truck-btn"
                                    data-id="{{ $truck->id }}"
                                    data-name="{{ $truck->truck_name }}"
                                    data-number="{{ $truck->truck_number }}"
                                    data-url="{{ route('admin.trucks.destroy', $truck->id) }}"
                                    title="Delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-secondary">
                <i class="fas fa-truck fa-3x mb-2 d-block"></i>
                No trucks found. Click "Add New Truck" to create one.
            </div>
            @endforelse
        </div>
        <div class="mt-4 d-flex justify-content-end">
            {{ $trucks->links() }}
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTruckModal" tabindex="-1" aria-labelledby="deleteTruckModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTruckModalLabel">
                    <i class="fas fa-exclamation-triangle me-2" style="color: var(--red-primary);"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3" id="deleteModalMessage">Are you sure you want to delete this truck?</p>
                <div class="bg-light p-3 rounded-3 mb-3" style="background: #f8f9fa !important; border-radius: 12px !important;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold text-secondary">Truck Name:</span>
                        <span id="deleteTruckName" class="fw-bold" style="color: #1A2C2A;">—</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold text-secondary">Truck #:</span>
                        <span id="deleteTruckNumber" class="fw-bold" style="color: #1A2C2A;">—</span>
                    </div>
                </div>
                <p class="text-danger small mb-0" style="font-size: 1.3rem !important;">
                    <i class="fas fa-exclamation-circle me-1"></i> This action cannot be undone. All associated data will be permanently removed.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-modal-delete" id="confirmDeleteBtn">
                        <i class="fas fa-trash-alt me-2"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" nonce="{{ $csp_nonce }}"></script>
<script nonce="{{ $csp_nonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        // =========================================
        // VIEW TOGGLE WITH LOCALSTORAGE
        // =========================================
        const viewTableBtn = document.getElementById('viewTableBtn');
        const viewCardBtn = document.getElementById('viewCardBtn');
        const tableView = document.getElementById('tableView');
        const cardView = document.getElementById('cardView');

        function setActiveView(view) {
            tableView.classList.remove('active');
            cardView.classList.remove('active');
            if (view === 'table') {
                tableView.classList.add('active');
                viewTableBtn.classList.add('active');
                viewCardBtn.classList.remove('active');
            } else {
                cardView.classList.add('active');
                viewCardBtn.classList.add('active');
                viewTableBtn.classList.remove('active');
            }
            localStorage.setItem('truckViewPreference', view);
        }

        const savedView = localStorage.getItem('truckViewPreference') || 'table';
        setActiveView(savedView);

        viewTableBtn.addEventListener('click', function(e) {
            e.preventDefault();
            setActiveView('table');
        });
        viewCardBtn.addEventListener('click', function(e) {
            e.preventDefault();
            setActiveView('card');
        });

        // =========================================
        // DELETE TRUCK MODAL - FIXED WITH STANDARD FORM SUBMIT
        // =========================================
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteTruckModal'));
        const deleteForm = document.getElementById('deleteForm');
        const deleteTruckName = document.getElementById('deleteTruckName');
        const deleteTruckNumber = document.getElementById('deleteTruckNumber');
        const deleteModalMessage = document.getElementById('deleteModalMessage');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // Handle delete button clicks
        document.querySelectorAll('.delete-truck-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const truckName = this.dataset.name;
                const truckNumber = this.dataset.number;
                const deleteUrl = this.dataset.url;

                console.log('Delete URL:', deleteUrl);

                // Set the form action
                deleteForm.action = deleteUrl;

                // Update modal content
                deleteTruckName.textContent = truckName || 'Unknown';
                deleteTruckNumber.textContent = truckNumber || 'N/A';
                deleteModalMessage.innerHTML = 'Are you sure you want to delete truck <strong>' + (truckName || 'this truck') + '</strong>?';

                // Show the modal
                deleteModal.show();
            });
        });

        // Handle confirm deletion - Standard form submit with confirmation
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Deleting...';
                this.disabled = true;

                // Submit the form
                deleteForm.submit();

                // Reset after a moment (in case form submission takes time)
                setTimeout(function() {
                    confirmDeleteBtn.innerHTML = originalText;
                    confirmDeleteBtn.disabled = false;
                }, 3000);
            });
        }

        // Reset modal state when hidden
        document.getElementById('deleteTruckModal').addEventListener('hidden.bs.modal', function() {
            if (confirmDeleteBtn) {
                confirmDeleteBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i> Delete Permanently';
                confirmDeleteBtn.disabled = false;
            }
        });

        // Handle modal close via backdrop or X button
        document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (confirmDeleteBtn) {
                    confirmDeleteBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i> Delete Permanently';
                    confirmDeleteBtn.disabled = false;
                }
            });
        });
    });
</script>
@endpush
@endsection
