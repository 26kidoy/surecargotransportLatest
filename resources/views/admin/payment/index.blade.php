@extends('admin.layouts.app')

@section('title', 'SureCargo Admin | Payments & Methods')
@section('page-title', 'Payment Management')

@push('styles')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" nonce="{{ $csp_nonce }}">
    <style nonce="{{ $csp_nonce }}">
/* ============================================================
   SETTINGS/CONFIGURATION PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   Theme: White / Green / Red
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

.btn-green {
    background: var(--green-primary);
    color: white;
    box-shadow: 0 4px 8px rgba(13, 110, 79, 0.2);
    font-size: var(--font-base) !important;
}

.btn-green:hover {
    background: var(--green-light);
    transform: translateY(-2px);
    color: white;
}

.btn-danger-custom,
.btn-outline-danger {
    background: var(--red-primary);
    color: white;
    border: none;
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    font-size: var(--font-base) !important;
    min-height: 44px;
}

.btn-danger-custom:hover,
.btn-outline-danger:hover {
    background: var(--red-dark);
    transform: translateY(-2px);
    color: white;
}

.btn-outline-save {
    background: transparent;
    border: 2px solid var(--green-primary);
    color: var(--green-primary);
    font-weight: 600;
    font-size: var(--font-base) !important;
    min-height: 44px;
}

.btn-outline-save:hover {
    background: var(--green-primary);
    color: white;
    border-color: var(--green-primary);
}

.btn-mass-archive {
    background: var(--red-primary);
    color: white;
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    border-radius: var(--radius-btn);
    transition: 0.2s;
    border: none;
    box-shadow: var(--shadow-sm);
    font-size: var(--font-base) !important;
    min-height: 44px;
}

.btn-mass-archive:hover {
    background: var(--red-dark);
    transform: scale(1.02);
}

.btn-secondary {
    background: var(--green-primary);
    color: white;
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    border-radius: var(--radius-btn);
    margin-left: var(--sp-md);
    font-size: var(--font-base) !important;
    min-height: 44px;
}

.btn-secondary:hover {
    background: var(--green-light);
    transform: translateY(-2px);
}

.btn-group .btn {
    font-size: var(--font-sm) !important;
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 2rem;
    margin: 0 0.2rem;
    min-height: 36px;
}

/* ============================================================
   STAT CARDS
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

.stat-card i.fa-check-circle {
    color: var(--green-primary);
}

/* ============================================================
   CONFIG CARDS
   ============================================================ */
.config-card {
    background: var(--white);
    border-radius: var(--radius-card);
    padding: var(--sp-xl);
    border: 1px solid var(--gray-200);
    transition: all 0.2s;
    height: 100%;
    box-shadow: var(--shadow-sm);
}

.config-card:hover {
    box-shadow: var(--shadow-md);
    border-color: var(--green-light);
}

.method-badge {
    background: var(--gray-200);
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 2rem;
    font-size: var(--font-sm);
    font-weight: 600;
}

.status-badge-method {
    font-size: var(--font-sm);
    padding: var(--sp-xs) var(--sp-md);
}

/* ============================================================
   FORM ELEMENTS
   ============================================================ */
.form-control,
.form-select {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-md) !important;
    border-radius: 1.5rem;
    border: 1px solid var(--gray-200);
    background: white;
    transition: 0.2s;
    min-height: 44px;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--green-primary);
    box-shadow: 0 0 0 3px rgba(13, 110, 79, 0.2);
}

.form-label {
    font-weight: 600;
    margin-bottom: var(--sp-sm);
    color: #1F3B36;
    font-size: var(--font-base) !important;
}

.form-check-input {
    width: 1.6rem;
    height: 1.6rem;
    margin-top: 0;
    min-width: 1.6rem;
    min-height: 1.6rem;
}

.form-check-label {
    font-size: var(--font-base);
    font-weight: 400;
    margin-left: var(--sp-sm);
}

/* ============================================================
   TABLE
   ============================================================ */
.data-table-card,
.data-table-container {
    background: white;
    border-radius: var(--radius-card);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.table-custom {
    width: 100%;
    margin: 0;
}

.table-custom th,
.table-custom td {
    padding: var(--sp-md) var(--sp-md);
    vertical-align: middle;
    font-size: var(--font-base) !important;
    border-bottom: 1px solid var(--gray-200);
}

.table-custom th {
    background: #F4F8F6;
    font-weight: 700;
    color: #0A4D3E;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: var(--font-sm) !important;
}

.table-custom tr:hover {
    background-color: var(--green-soft);
}

/* ============================================================
   STATUS BADGES
   ============================================================ */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 3rem;
    font-weight: 600;
    font-size: var(--font-sm) !important;
    background: white;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    min-height: 36px;
}

.status-pending { background: #FFF3E0; color: #C45C0C; border-left: 5px solid #F59E0B; }
.status-active { background: #E0F2E9; color: #0C6E4E; border-left: 5px solid var(--green-primary); }
.status-blocked { background: #FEF3F2; color: var(--red-primary); border-left: 5px solid var(--red-primary); }
.status-refunded { background: #EFF2F9; color: #334155; border-left: 5px solid #64748B; }
.status-cod { background: #EFF6FF; color: #1E40AF; border-left: 5px solid #3B82F6; }

/* ============================================================
   QR PREVIEW
   ============================================================ */
.qr-preview img {
    max-width: 100px;
    border-radius: 1rem;
    border: 1px solid var(--gray-200);
    padding: 4px;
}

.remove-qr-btn {
    font-size: var(--font-sm) !important;
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 2rem;
    background: white;
    border: 1px solid var(--red-primary);
    color: var(--red-primary);
    min-height: 36px;
}

/* ============================================================
   SCREENSHOT PREVIEW
   ============================================================ */
.screenshot-preview img {
    max-width: 60px;
    max-height: 60px;
    border-radius: 8px;
    border: 1px solid var(--gray-200);
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.2s;
}

.screenshot-preview img:hover {
    transform: scale(1.1);
}

.screenshot-thumbnail {
    max-width: 50px;
    max-height: 50px;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    object-fit: cover;
}

/* ============================================================
   PAGINATION
   ============================================================ */
.pagination .page-link {
    font-size: var(--font-base);
    padding: var(--sp-sm) var(--sp-md);
    border-radius: 2rem;
    margin: 0 3px;
    color: var(--green-primary);
    font-weight: 600;
    min-height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.pagination .active .page-link {
    background: var(--green-primary);
    border-color: var(--green-primary);
    color: white;
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
    max-width: 600px !important;
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
    max-width: 600px !important;
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
    font-size: var(--font-base) !important;
    min-height: 40px !important;
}

/* Modal custom overrides */
.modal-custom .modal-content {
    border-radius: 28px !important;
    border: none !important;
    box-shadow: 0 20px 35px -10px rgba(0,0,0,0.25) !important;
    background: var(--white) !important;
}

.modal-custom .modal-header {
    border-bottom: 3px solid var(--green-primary) !important;
    padding: var(--sp-xl) var(--sp-xl) !important;
    background: var(--white) !important;
    border-radius: 28px 28px 0 0 !important;
}

.modal-custom .modal-title {
    font-size: var(--font-lg) !important;
    font-weight: 700 !important;
    color: var(--green-primary) !important;
}

.modal-custom .modal-body {
    padding: var(--sp-xl) !important;
    background: var(--white) !important;
}

.modal-custom .modal-footer {
    border-top: 1px solid var(--gray-200) !important;
    padding: var(--sp-lg) var(--sp-xl) !important;
    background: var(--white) !important;
    border-radius: 0 0 28px 28px !important;
}

.modal-custom .reference-display {
    font-size: var(--font-base) !important;
    font-family: monospace !important;
    background: #f8f9fa !important;
    padding: var(--sp-sm) var(--sp-md) !important;
    border-radius: 12px !important;
    margin-bottom: 0 !important;
    word-break: break-all !important;
}

.modal-custom .amount-display {
    font-size: var(--font-md) !important;
    font-weight: 700 !important;
    color: var(--green-primary) !important;
    margin-bottom: 0 !important;
}

.modal-custom .form-select-lg-custom {
    font-size: var(--font-base) !important;
    border-radius: 16px !important;
    padding: var(--sp-sm) var(--sp-md) !important;
    border: 1px solid var(--gray-200) !important;
    background: var(--white) !important;
    min-height: 44px;
}

.modal-custom .form-select-lg-custom:focus {
    border-color: var(--green-primary) !important;
    box-shadow: 0 0 0 3px rgba(134, 16, 163, 0.2) !important;
}

.modal-custom .btn-lg-custom {
    border-radius: 48px !important;
    padding: var(--sp-sm) var(--sp-xl) !important;
    font-size: var(--font-base) !important;
    background: #6c757d !important;
    color: var(--white) !important;
    border: none !important;
    min-height: 40px;
}

.modal-custom .btn-lg-custom:hover {
    background: #5a6268 !important;
    transform: translateY(-2px) !important;
}

.modal-custom .btn-lg-custom-primary {
    border-radius: 48px !important;
    padding: var(--sp-sm) var(--sp-xl) !important;
    font-size: var(--font-base) !important;
    background: var(--green-primary) !important;
    color: var(--white) !important;
    border: none !important;
    min-height: 40px;
}

.modal-custom .btn-lg-custom-primary:hover {
    background: var(--green-light) !important;
    transform: translateY(-2px) !important;
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
   SWEETALERT2 CUSTOM STYLES
   ============================================================ */
.swal2-container {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    z-index: 1060 !important;
    padding: 0 !important;
    margin: 0 !important;
    background: rgba(0, 0, 0, 0.5) !important;
}

.swal2-container.swal2-center {
    align-items: center !important;
    justify-content: center !important;
}

.swal2-container.swal2-backdrop-show {
    background: rgba(0, 0, 0, 0.5) !important;
}

.swal2-popup {
    position: relative !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    align-items: stretch !important;
    border-radius: 28px !important;
    padding: 0 !important;
    background: var(--white) !important;
    box-shadow: 0 20px 35px -10px rgba(0,0,0,0.25) !important;
    max-width: 500px !important;
    width: 90% !important;
    margin: 0 auto !important;
    transform: none !important;
    animation: none !important;
}

.swal2-popup .swal2-header {
    padding: var(--sp-xl) var(--sp-xl) 0 var(--sp-xl) !important;
    border-bottom: 3px solid var(--green-primary) !important;
    background: var(--white) !important;
    border-radius: 28px 28px 0 0 !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
}

.swal2-popup .swal2-title {
    font-size: var(--font-lg) !important;
    font-weight: 700 !important;
    color: var(--green-primary) !important;
    padding: 0 !important;
    margin: 0 0 var(--sp-sm) 0 !important;
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
}

.swal2-popup .swal2-title .swal2-icon {
    margin: 0 !important;
    border: none !important;
}

.swal2-popup .swal2-icon.swal2-warning {
    border-color: #fbbf24 !important;
    color: #f59e0b !important;
}

.swal2-popup .swal2-icon.swal2-error {
    border-color: #ef4444 !important;
    color: #ef4444 !important;
}

.swal2-popup .swal2-icon.swal2-success {
    border-color: var(--green-primary) !important;
    color: var(--green-primary) !important;
}

.swal2-popup .swal2-icon.swal2-question {
    border-color: #3b82f6 !important;
    color: #3b82f6 !important;
}

.swal2-popup .swal2-html-container {
    padding: var(--sp-xl) var(--sp-xl) !important;
    background: var(--white) !important;
    font-size: var(--font-base) !important;
    color: #1A2C2A !important;
    line-height: 1.6 !important;
    margin: 0 !important;
}

.swal2-popup .swal2-html-container strong {
    color: var(--green-primary) !important;
}

.swal2-popup .swal2-html-container .text-danger {
    color: var(--red-primary) !important;
}

.swal2-popup .swal2-actions {
    padding: var(--sp-md) var(--sp-xl) var(--sp-xl) var(--sp-xl) !important;
    border-top: 1px solid var(--gray-200) !important;
    background: var(--white) !important;
    border-radius: 0 0 28px 28px !important;
    display: flex !important;
    gap: 12px !important;
    margin: 0 !important;
    flex-wrap: wrap !important;
    justify-content: center !important;
}

.swal2-popup .swal2-actions .swal2-styled {
    border-radius: 48px !important;
    padding: var(--sp-sm) var(--sp-xl) !important;
    font-size: var(--font-base) !important;
    font-weight: 600 !important;
    min-width: 120px !important;
    transition: all 0.2s ease !important;
    margin: 0 !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05) !important;
    min-height: 40px !important;
}

.swal2-popup .swal2-actions .swal2-styled:hover {
    transform: translateY(-2px) !important;
}

.swal2-popup .swal2-actions .swal2-styled.swal2-confirm {
    background: var(--green-primary) !important;
    color: var(--white) !important;
}

.swal2-popup .swal2-actions .swal2-styled.swal2-confirm:hover {
    background: var(--green-light) !important;
}

.swal2-popup .swal2-actions .swal2-styled.swal2-cancel {
    background: #6c757d !important;
    color: var(--white) !important;
}

.swal2-popup .swal2-actions .swal2-styled.swal2-cancel:hover {
    background: #5a6268 !important;
}

.swal2-popup .swal2-actions .swal2-styled:focus {
    box-shadow: none !important;
}

.swal2-popup .swal2-close {
    color: var(--green-primary) !important;
    font-size: var(--font-xl) !important;
    opacity: 0.7 !important;
}

.swal2-popup .swal2-close:hover {
    opacity: 1 !important;
}

.swal2-icon {
    margin: 0 !important;
}

/* ============================================================
   DATA TABLES WRAPPER
   ============================================================ */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_info,
.dataTables_paginate {
    font-size: var(--font-base) !important;
    margin: var(--sp-lg) 0;
}

.dataTables_wrapper .dataTables_filter input {
    margin-left: var(--sp-md);
    padding: var(--sp-sm) !important;
    min-width: 280px;
    min-height: 40px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: var(--sp-sm) var(--sp-md);
    font-size: var(--font-base) !important;
    border-radius: 2rem;
    margin: 0 0.2rem;
    min-height: 36px;
}

/* ============================================================
   UTILITY
   ============================================================ */
a, .btn-link {
    font-weight: 500;
    color: var(--green-primary);
    text-decoration: none;
}

a:hover {
    color: var(--green-light);
    text-decoration: underline;
}

.text-danger {
    color: var(--red-primary) !important;
    font-weight: 600;
}

.text-success {
    color: var(--green-primary) !important;
    font-weight: 600;
}

.bg-success {
    background-color: var(--green-primary) !important;
}

i.fa, i.fas, i.far {
    color: inherit;
    margin-right: 6px;
    font-size: var(--font-md);
}

small, .small, .text-secondary {
    font-weight: 400;
    color: #3F5C55 !important;
    font-size: var(--font-sm) !important;
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

    .config-card {
        padding: var(--sp-lg);
    }

    .table-custom th,
    .table-custom td {
        padding: var(--sp-sm) var(--sp-sm);
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

    body, .btn, .table-custom td, .form-control, .stat-card p {
        font-size: var(--font-sm) !important;
    }

    .stat-card {
        padding: var(--sp-md);
        border-radius: 1.5rem;
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

    .config-card {
        padding: var(--sp-md);
        border-radius: 1.5rem;
    }

    .table-custom {
        display: block;
        overflow-x: auto;
    }

    .table-custom th,
    .table-custom td {
        padding: var(--sp-sm) var(--sp-xs);
        font-size: var(--font-xs) !important;
    }

    .table-custom th {
        font-size: var(--font-xs) !important;
    }

    .btn {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
        border-radius: 2rem;
    }

    .btn-green,
    .btn-danger-custom,
    .btn-outline-danger,
    .btn-outline-save,
    .btn-mass-archive,
    .btn-secondary {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
    }

    .btn-mass-archive,
    .btn-secondary {
        padding: var(--sp-xs) var(--sp-md);
    }

    .btn-group .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .form-control,
    .form-select {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 38px;
        border-radius: 1rem;
    }

    .form-label {
        font-size: var(--font-sm) !important;
        margin-bottom: var(--sp-xs);
    }

    .form-check-input {
        width: 1.4rem;
        height: 1.4rem;
        min-width: 1.4rem;
        min-height: 1.4rem;
    }

    .form-check-label {
        font-size: var(--font-sm);
    }

    .status-badge {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 30px;
    }

    .method-badge {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
    }

    .status-badge-method {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
    }

    .pagination .page-link {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
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

    .modal-custom .modal-header {
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    .modal-custom .modal-title {
        font-size: var(--font-md) !important;
    }

    .modal-custom .modal-body {
        padding: var(--sp-md) !important;
    }

    .modal-custom .modal-footer {
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    .modal-custom .reference-display {
        font-size: var(--font-sm) !important;
    }

    .modal-custom .amount-display {
        font-size: var(--font-sm) !important;
    }

    .modal-custom .form-select-lg-custom {
        font-size: var(--font-sm) !important;
        min-height: 36px;
    }

    .modal-custom .btn-lg-custom,
    .modal-custom .btn-lg-custom-primary {
        font-size: var(--font-sm) !important;
        min-height: 36px;
    }

    .swal2-popup {
        max-width: 95% !important;
        width: 95% !important;
        border-radius: 20px !important;
    }

    .swal2-popup .swal2-header {
        padding: var(--sp-md) var(--sp-md) 0 var(--sp-md) !important;
    }

    .swal2-popup .swal2-title {
        font-size: var(--font-md) !important;
    }

    .swal2-popup .swal2-html-container {
        padding: var(--sp-md) !important;
        font-size: var(--font-sm) !important;
    }

    .swal2-popup .swal2-actions {
        padding: var(--sp-sm) var(--sp-md) var(--sp-md) var(--sp-md) !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
    }

    .swal2-popup .swal2-actions .swal2-styled {
        min-width: 100px !important;
        padding: var(--sp-xs) var(--sp-md) !important;
        font-size: var(--font-sm) !important;
        min-height: 36px !important;
        flex: 1 1 auto !important;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate {
        font-size: var(--font-sm) !important;
        margin: var(--sp-md) 0;
    }

    .dataTables_wrapper .dataTables_filter input {
        margin-left: var(--sp-xs);
        padding: var(--sp-xs) !important;
        min-width: 200px;
        min-height: 34px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 30px;
    }

    .remove-qr-btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .qr-preview img {
        max-width: 80px;
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

    body, .btn, .table-custom td, .form-control, .stat-card p {
        font-size: var(--font-xs) !important;
    }

    .stat-card {
        padding: var(--sp-sm);
        border-radius: 1.2rem;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        font-size: var(--font-sm);
        border-radius: 16px;
    }

    .stat-card h2 {
        font-size: var(--font-md) !important;
    }

    .stat-card .text-secondary {
        font-size: var(--font-xs) !important;
    }

    .config-card {
        padding: var(--sp-sm);
        border-radius: 1.2rem;
    }

    .table-custom th,
    .table-custom td {
        padding: var(--sp-xs) var(--sp-xs);
        font-size: 0.55rem !important;
    }

    .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 1.5rem;
    }

    .btn-green,
    .btn-danger-custom,
    .btn-outline-danger,
    .btn-outline-save,
    .btn-mass-archive,
    .btn-secondary {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .btn-group .btn {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 28px;
    }

    .form-control,
    .form-select {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 34px;
        border-radius: 0.8rem;
    }

    .form-label {
        font-size: var(--font-xs) !important;
    }

    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
        min-width: 1.2rem;
        min-height: 1.2rem;
    }

    .form-check-label {
        font-size: var(--font-xs);
    }

    .status-badge {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 26px;
    }

    .method-badge {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
    }

    .pagination .page-link {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-xs);
        min-height: 28px;
    }

    .modal-header .modal-title {
        font-size: var(--font-sm) !important;
    }

    .modal-body {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) !important;
    }

    .modal-footer .btn {
        font-size: var(--font-xs) !important;
        min-height: 32px !important;
        min-width: 80px !important;
    }

    .modal-custom .modal-title {
        font-size: var(--font-sm) !important;
    }

    .modal-custom .reference-display {
        font-size: var(--font-xs) !important;
    }

    .modal-custom .amount-display {
        font-size: var(--font-xs) !important;
    }

    .modal-custom .form-select-lg-custom {
        font-size: var(--font-xs) !important;
        min-height: 32px;
    }

    .modal-custom .btn-lg-custom,
    .modal-custom .btn-lg-custom-primary {
        font-size: var(--font-xs) !important;
        min-height: 32px;
    }

    .swal2-popup .swal2-title {
        font-size: var(--font-sm) !important;
    }

    .swal2-popup .swal2-html-container {
        font-size: var(--font-xs) !important;
    }

    .swal2-popup .swal2-actions .swal2-styled {
        font-size: var(--font-xs) !important;
        min-height: 32px !important;
        min-width: 80px !important;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate {
        font-size: var(--font-xs) !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        min-width: 160px;
        min-height: 30px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-size: var(--font-xs) !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 26px;
    }

    .remove-qr-btn {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 28px;
    }

    .qr-preview img {
        max-width: 60px;
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
        width: 36px;
        height: 36px;
        font-size: 0.6rem;
        border-radius: 12px;
    }

    .stat-card h2 {
        font-size: 0.7rem !important;
    }

    .btn {
        font-size: 0.5rem !important;
        min-height: 30px;
    }

    .form-control,
    .form-select {
        font-size: 0.5rem !important;
        min-height: 30px;
    }

    .status-badge {
        font-size: 0.45rem !important;
        min-height: 22px;
    }

    .modal-footer .btn {
        font-size: 0.5rem !important;
        min-height: 28px !important;
        min-width: 70px !important;
    }

    .swal2-popup .swal2-actions .swal2-styled {
        font-size: 0.5rem !important;
        min-height: 28px !important;
        min-width: 70px !important;
    }

    .pagination .page-link {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 24px;
    }

    .dataTables_wrapper .dataTables_filter input {
        min-width: 120px;
        min-height: 26px;
    }

    .table-custom th,
    .table-custom td {
        font-size: 0.45rem !important;
        padding: 0.05rem 0.05rem;
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
        width: 30px;
        height: 30px;
        font-size: 0.5rem;
        border-radius: 10px;
    }

    .stat-card h2 {
        font-size: 0.6rem !important;
    }

    .btn {
        font-size: 0.4rem !important;
        min-height: 26px;
    }

    .modal-footer .btn {
        font-size: 0.4rem !important;
        min-height: 24px !important;
        min-width: 60px !important;
    }

    .swal2-popup .swal2-actions .swal2-styled {
        font-size: 0.4rem !important;
        min-height: 24px !important;
        min-width: 60px !important;
    }

    .pagination .page-link {
        font-size: 0.4rem !important;
        min-height: 20px;
    }

    .form-control,
    .form-select {
        font-size: 0.4rem !important;
        min-height: 26px;
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
@endpush

@section('content')
<!-- Approved Payments Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Total Approved Amount</p>
                    <h2 class="fw-bold text-success">₱{{ number_format($approvedStats['total_approved_amount'] ?? 0, 2) }}</h2>
                </div>
                <div class="stat-icon">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M8 12l2 2 4-4" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Approved Payments</p>
                    <h2 class="fw-bold text-success">{{ $approvedStats['total_approved_count'] ?? 0 }}</h2>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 2v20l2-1.5 2 1.5 2-1.5 2 1.5 2-1.5 2 1.5 2-1.5V2l-2 1.5L16 2l-2 1.5L12 2l-2 1.5L8 2 6 3.5 4 2z" />
                        <line x1="8" y1="8" x2="16" y2="8" />
                        <line x1="8" y1="12" x2="14" y2="12" />
                        <line x1="8" y1="16" x2="12" y2="16" />
                        </svg>
               </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Average Approved Amount</p>
                    <h2 class="fw-bold">₱{{ number_format($approvedStats['avg_approved_amount'] ?? 0, 2) }}</h2>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3,17 7,13 11,15 17,9 21,13" />
                        <polyline points="17,9 17,5 21,5 21,9" />
                        <line x1="3" y1="21" x2="21" y2="21" />
                        </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Highest Approved Amount</p>
                    <h2 class="fw-bold">₱{{ number_format($approvedStats['highest_approved_amount'] ?? 0, 2) }}</h2>
                </div>
                <div class="stat-icon">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                    <path d="M4 22h16" />
                    <path d="M12 15v7" />
                    <path d="M6 9c0 3.5 2.5 6 6 6s6-2.5 6-6" />
                    <path d="M9 9c0 2 1.5 3 3 3s3-1 3-3" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Methods Configuration -->
<div class="mb-5">
    <h5 class="mb-3"><i class="fas fa-sliders-h me-2"></i> Payment Methods Configuration</h5>
    <div class="row g-4">
        @php $methodsList = ['gcash' => 'GCash', 'bank_transfer' => 'Bank Transfer', 'paymaya' => 'PayMaya']; @endphp
        @foreach($methodsList as $key => $label)
            @php $config = $paymentMethods[$key] ?? null; @endphp
            <div class="col-md-4">
                <div class="config-card" data-method="{{ $key }}">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="mb-0">
                            <i class="fas {{ $key == 'gcash' ? 'fa-mobile-alt' : ($key == 'bank_transfer' ? 'fa-university' : 'fa-credit-card') }} me-2"></i>
                            {{ ucfirst(str_replace('_', ' ', $key)) }}
                        </h6>
                        <div>
                            <span class="badge {{ ($config->is_active ?? true) ? 'bg-success' : 'bg-secondary' }} status-badge-method">
                                {{ ($config->is_active ?? true) ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                    </div>
                    <form class="method-config-form" data-method-key="{{ $key }}" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label class="form-label small text-secondary">Display Name <span class="text-danger">*</span></label>
                            <input type="text" name="display_name" class="form-control form-control-sm" value="{{ $config->display_name ?? $label }}" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small text-secondary">Account Name</label>
                            <input type="text" name="account_name" class="form-control form-control-sm" value="{{ $config->account_name ?? '' }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small text-secondary">Reference Number / Account #</label>
                            <input type="text" name="reference_number" class="form-control form-control-sm" value="{{ $config->reference_number ?? '' }}">
                        </div>
                        <!-- QR Code Image -->
                        <div class="mb-2">
                            <label class="form-label small text-secondary">QR Code Image</label>
                            <input type="file" name="qr_code_image" class="form-control form-control-sm qr-file-input" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg,image/webp">
                            @if($config && $config->qr_code_image)
                                @php
                                    $qrUrl = $config->qr_code_url;
                                @endphp
                                @if($qrUrl)
                                    <div class="qr-preview mt-2">
                                        <img src="{{ e($qrUrl) }}" alt="QR Code" class="img-fluid qr-preview-img" style="max-width: 80px;" data-fallback="QR not available">
                                        <div class="mt-1">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-qr-btn" data-method="{{ $key }}">
                                                <i class="fas fa-trash-alt"></i> Remove QR
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-2 text-muted" style="font-size:1.2rem;">No QR code uploaded</div>
                                @endif
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-secondary">Payment Instructions</label>
                            <textarea name="instructions" rows="2" class="form-control form-control-sm">{{ $config->instructions ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeSwitch{{ $key }}" {{ ($config->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activeSwitch{{ $key }}"><i class="fas fa-power-off me-1"></i> Available / Active</label>
                            </div>
                            <small class="text-muted">If inactive, this payment method will not be shown to customers.</small>
                        </div>
                        <button type="button" class="btn btn-outline-save w-100 save-method-btn"><i class="fas fa-save me-1"></i> Save Changes (real‑time)</button>
                        <div class="small text-success mt-2 method-feedback d-none"><i class="fas fa-check-circle"></i> <span></span></div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Action Buttons Row -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.payments.export', 'csv') }}" class="btn btn-outline-danger" id="exportCsvBtn">
            <i class="fas fa-download me-1"></i> Export CSV
        </a>
        <a href="{{ route('admin.payments.archive.index') }}" class="btn btn-secondary">
            <i class="fas fa-archive me-1"></i> View Archived Payments
        </a>
        <button type="button" class="btn-mass-archive" id="massArchiveBtn">
            <i class="fas fa-boxes me-1"></i> Mass Archive All
        </button>
    </div>
</div>

<!-- Status Filter Row -->
<div class="row mb-4">
    <div class="col-md-4 col-lg-3">
        <form method="GET" action="{{ route('admin.payments.index') }}" id="statusFilterForm">
            <label class="form-label fw-semibold">Filter by Status</label>
            <select name="status" class="form-select" id="statusFilterSelect">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approve" {{ request('status') == 'approve' ? 'selected' : '' }}>Approved</option>
                <option value="decline" {{ request('status') == 'decline' ? 'selected' : '' }}>Declined</option>
                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                <option value="cod" {{ request('status') == 'cod' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
            </select>
            @if(request('status'))
                <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-link mt-2">Clear filter</a>
            @endif
        </form>
    </div>
</div>

<!-- Payments Table -->
<div class="data-table-container">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle" id="paymentsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reference</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Sender</th>
                    <th>User Ref</th>
                    <th>Screenshot</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr data-payment-id="{{ $payment->id }}">
                    <td class="text-white-50">#{{ $payment->id }}</td>
                    <td><code class="text-danger">{{ $payment->payment_reference }}</code></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-user-circle text-secondary"></i>
                            <div>
                                <div class="text-white small">{{ $payment->user->full_name ?? 'N/A' }}</div>
                                <div class="text-secondary small">{{ $payment->user->mobile_number ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="fw-bold">₱{{ number_format($payment->amount, 2) }}</td>
                    <td><i class="fas {{ $payment->payment_method_icon ?? 'fa-credit-card' }} me-1"></i> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                    <td>
                        @php
                            $statusClass = match($payment->status) {
                                'pending' => 'status-pending',
                                'approve' => 'status-active',
                                'decline' => 'status-blocked',
                                'refunded' => 'status-refunded',
                                'cod' => 'status-cod',
                                default => 'status-pending'
                            };
                            $statusIcon = match($payment->status) {
                                'pending' => 'fa-clock',
                                'approve' => 'fa-check-circle',
                                'decline' => 'fa-times-circle',
                                'refunded' => 'fa-undo-alt',
                                'cod' => 'fa-truck',
                                default => 'fa-question-circle'
                            };
                            $statusLabel = match($payment->status) {
                                'cod' => 'COD',
                                default => ucfirst($payment->status)
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            <i class="fas {{ $statusIcon }} me-1"></i> {{ $statusLabel }}
                        </span>
                    </td>
                    <td>{{ $payment->sender_name ?? '—' }}</td>
                    <td>{{ $payment->user_reference ?? '—' }}</td>
                    <td>
                        @if($payment->screenshot_path)
                            @php
                                $screenshotUrl = $payment->screenshot_url;
                            @endphp
                            @if($screenshotUrl)
                                <div class="screenshot-preview">
                                    <img src="{{ e($screenshotUrl) }}" alt="Screenshot" class="screenshot-thumbnail screenshot-view-btn" 
                                         data-url="{{ e($screenshotUrl) }}"
                                         style="cursor: pointer; max-width: 50px; max-height: 50px; border-radius: 6px; border: 1px solid #e9ecef; object-fit: cover;">
                                    <div><small class="text-muted">Click to view</small></div>
                                </div>
                            @else
                                <span class="text-muted" style="font-size:0.8rem;">File missing</span>
                            @endif
                        @else
                            <span class="text-muted" style="font-size:0.8rem;">—</span>
                        @endif
                    </td>
                    <td class="text-secondary small">{{ $payment->display_date }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i> Show</a>
                            <button type="button" class="btn btn-sm btn-outline-warning edit-status-btn" data-bs-toggle="modal" data-bs-target="#editStatusModal-{{ $payment->id }}"><i class="fas fa-edit"></i> Edit Status</button>
                            <button type="button" class="btn btn-sm btn-outline-danger archive-payment-btn"
                                    data-url="{{ route('admin.payments.archive', $payment->id) }}"
                                    data-id="{{ $payment->id }}"
                                    data-reference="{{ $payment->payment_reference }}">
                                <i class="fas fa-archive"></i> Archive
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-payment-btn"
                                    data-url="{{ route('admin.payments.destroy', $payment->id) }}"
                                    data-id="{{ $payment->id }}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center text-secondary py-5"><i class="fas fa-credit-card fa-3x mb-3 d-block"></i>No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $payments->appends(request()->query())->links() }}</div>
</div>

<!-- Edit Status Modals - CSP Friendly -->
@foreach($payments as $payment)
<div class="modal fade modal-custom" id="editStatusModal-{{ $payment->id }}" tabindex="-1" aria-labelledby="editStatusModalLabel-{{ $payment->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStatusModalLabel-{{ $payment->id }}">
                    <i class="fas fa-edit me-2"></i> Update Payment Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.payments.update-status', $payment->id) }}" method="POST" class="update-status-form">
                @csrf @method('PATCH')
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2">Payment Reference</label>
                        <p class="reference-display">{{ $payment->payment_reference }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2">Amount</label>
                        <p class="amount-display">₱{{ number_format($payment->amount, 2) }}</p>
                    </div>
                    @if($payment->screenshot_path && $payment->screenshot_url)
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2">Screenshot Evidence</label>
                        <div>
                            <img src="{{ e($payment->screenshot_url) }}" alt="Payment Screenshot" 
                                 class="modal-screenshot-img"
                                 style="max-width: 100%; max-height: 300px; border-radius: 12px; border: 1px solid #e9ecef; cursor: pointer;"
                                 data-url="{{ e($payment->screenshot_url) }}">
                        </div>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="status-{{ $payment->id }}" class="form-label fw-semibold">Update Status</label>
                        <select name="status" id="status-{{ $payment->id }}" class="form-select form-select-lg-custom">
                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approve" {{ $payment->status == 'approve' ? 'selected' : '' }}>Approve</option>
                            <option value="decline" {{ $payment->status == 'decline' ? 'selected' : '' }}>Decline</option>
                            <option value="refunded" {{ $payment->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            <option value="cod" {{ $payment->status == 'cod' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-lg-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-green btn-lg-custom-primary"><i class="fas fa-save me-2"></i> Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<!-- Load jQuery first with nonce -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js" nonce="{{ $csp_nonce }}"></script>
<!-- Load DataTables with nonce -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" nonce="{{ $csp_nonce }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js" nonce="{{ $csp_nonce }}"></script>
<!-- Load SweetAlert2 with nonce -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" nonce="{{ $csp_nonce }}"></script>
<!-- Load Bootstrap Bundle with nonce -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" nonce="{{ $csp_nonce }}"></script>

<script nonce="{{ $csp_nonce }}">
    // CSRF token setup
    if (!document.querySelector('meta[name="csrf-token"]')) {
        let meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = '{{ csrf_token() }}';
        document.head.appendChild(meta);
    }

    // Wait for DOM and all scripts to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // =========================================
        // 1. STATUS FILTER - No inline onchange
        // =========================================
        const statusFilter = document.getElementById('statusFilterSelect');
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                document.getElementById('statusFilterForm').submit();
            });
        }

        // =========================================
        // 2. SCREENSHOT VIEW - No inline onclick
        // =========================================
        document.querySelectorAll('.screenshot-view-btn').forEach(function(img) {
            img.addEventListener('click', function() {
                const url = this.dataset.url;
                if (url) {
                    window.open(url, '_blank');
                }
            });
        });

        document.querySelectorAll('.modal-screenshot-img').forEach(function(img) {
            img.addEventListener('click', function() {
                const url = this.dataset.url;
                if (url) {
                    window.open(url, '_blank');
                }
            });
        });

        // =========================================
        // 3. QR IMAGE FALLBACK - No inline onerror
        // =========================================
        document.querySelectorAll('.qr-preview-img').forEach(function(img) {
            img.addEventListener('error', function() {
                const fallback = this.dataset.fallback || 'QR not available';
                this.style.display = 'none';
                const parent = this.parentElement;
                if (parent) {
                    const span = document.createElement('span');
                    span.className = 'text-muted';
                    span.style.fontSize = '1rem';
                    span.textContent = fallback;
                    parent.appendChild(span);
                }
            });
        });

        // =========================================
        // 4. Initialize DataTable
        // =========================================
        try {
            if (typeof $.fn.DataTable !== 'undefined') {
                const tableElement = document.getElementById('paymentsTable');
                if (tableElement) {
                    const tbody = tableElement.querySelector('tbody');
                    if (tbody && tbody.children.length > 0) {
                        const firstRow = tbody.children[0];
                        const hasColspan = firstRow.querySelector('td[colspan]');

                        if (!hasColspan) {
                            $('#paymentsTable').DataTable({
                                pageLength: 10,
                                responsive: true,
                                language: {
                                    search: "Search:",
                                    lengthMenu: "Show _MENU_ entries",
                                    info: "Showing _START_ to _END_ of _TOTAL_ entries"
                                },
                                dom: '<"d-flex justify-content-between align-items-center mb-3"lf>tip',
                                order: [[9, 'desc']]
                            });
                        }
                    }
                }
            } else {
                console.warn('DataTable library not loaded');
            }
        } catch (e) {
            console.warn('DataTable initialization skipped:', e.message);
        }

        // =========================================
        // 5. EXPORT CSV
        // =========================================
        document.getElementById('exportCsvBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');

            Swal.fire({
                title: 'Export Payments?',
                text: 'This will export all current payments to a CSV file.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#8610a3',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, export CSV',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Exporting...',
                        text: 'Please wait while your file is being prepared.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    window.location.href = href;

                    setTimeout(() => {
                        Swal.close();
                    }, 2000);
                }
            });
        });

        // =========================================
        // 6. INDIVIDUAL ARCHIVE PAYMENT
        // =========================================
        document.querySelectorAll('.archive-payment-btn').forEach(function(btn) {
            btn.removeEventListener('click', archiveHandler);
            btn.addEventListener('click', archiveHandler);
        });

        function archiveHandler(e) {
            e.preventDefault();
            e.stopPropagation();

            const $btn = this;
            const archiveUrl = $btn.dataset.url;
            const reference = $btn.dataset.reference;

            Swal.fire({
                title: '<i class="fas fa-archive me-2" style="color: #8610a3;"></i> Archive Payment?',
                html: 'You are about to archive payment <strong>' + reference + '</strong>.<br>It will be moved to the archive and won\'t appear in the main list.<br>You can restore it later from the archive page.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#8610a3',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, archive it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const originalHtml = $btn.innerHTML;
                    $btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>';
                    $btn.disabled = true;

                    fetch(archiveUrl, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Archived!',
                                text: data.message || 'Payment archived successfully.',
                                timer: 2000,
                                timerProgressBar: true,
                                confirmButtonColor: '#8610a3'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Could not archive payment', 'error');
                            $btn.innerHTML = originalHtml;
                            $btn.disabled = false;
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Network error occurred.', 'error');
                        $btn.innerHTML = originalHtml;
                        $btn.disabled = false;
                    });
                }
            });
        }

        // =========================================
        // 7. DELETE PAYMENT
        // =========================================
        document.querySelectorAll('.delete-payment-btn').forEach(function(btn) {
            btn.removeEventListener('click', deleteHandler);
            btn.addEventListener('click', deleteHandler);
        });

        function deleteHandler(e) {
            e.preventDefault();
            e.stopPropagation();

            const $btn = this;
            const deleteUrl = $btn.dataset.url;
            const $row = $btn.closest('tr');
            const reference = $row.querySelector('code')?.textContent || 'this payment';

            Swal.fire({
                title: '<i class="fas fa-trash me-2" style="color: #dc2626;"></i> Delete Payment?',
                html: 'You are about to permanently delete payment <strong>' + reference + '</strong>.<br><span class="text-danger">This action cannot be undone!</span>',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, permanently delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const originalHtml = $btn.innerHTML;
                    $btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>';
                    $btn.disabled = true;

                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message || 'Payment has been permanently deleted.',
                                timer: 2000,
                                timerProgressBar: true,
                                confirmButtonColor: '#8610a3'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Could not delete payment', 'error');
                            $btn.innerHTML = originalHtml;
                            $btn.disabled = false;
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Network error occurred.', 'error');
                        $btn.innerHTML = originalHtml;
                        $btn.disabled = false;
                    });
                }
            });
        }

        // =========================================
        // 8. MASS ARCHIVE ALL
        // =========================================
        const massArchiveBtn = document.getElementById('massArchiveBtn');
        if (massArchiveBtn) {
            massArchiveBtn.removeEventListener('click', massArchiveHandler);
            massArchiveBtn.addEventListener('click', massArchiveHandler);
        }

        function massArchiveHandler(e) {
            e.preventDefault();
            e.stopPropagation();

            const $btn = this;
            const paymentRows = document.querySelectorAll('#paymentsTable tbody tr:not(:has(td.text-center))');
            const count = paymentRows.length;

            if (count === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'No Payments to Archive',
                    text: 'There are no payments currently visible to archive.',
                    confirmButtonColor: '#8610a3'
                });
                return;
            }

            Swal.fire({
                title: '<i class="fas fa-boxes me-2" style="color: #8610a3;"></i> Archive ALL Payments?',
                html: 'This will move <strong>' + count + ' payment(s)</strong> from the main table to the archive.<br>You can restore them later from the archive page.<br><span class="text-danger">This action cannot be undone from this screen.</span>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#8610a3',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, archive all!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const originalText = $btn.innerHTML;
                    $btn.innerHTML = '<i class="fas fa-spinner fa-pulse me-1"></i> Archiving...';
                    $btn.disabled = true;

                    fetch('{{ route("admin.payments.mass-archive") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message || 'All payments have been archived.',
                                timer: 3000,
                                timerProgressBar: true,
                                confirmButtonColor: '#8610a3'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Something went wrong', 'error');
                            $btn.innerHTML = originalText;
                            $btn.disabled = false;
                        }
                    })
                    .catch(() => {
                        Swal.fire('Request Failed', 'Could not archive payments.', 'error');
                        $btn.innerHTML = originalText;
                        $btn.disabled = false;
                    });
                }
            });
        }

        // =========================================
        // 9. SAVE METHOD CONFIG
        // =========================================
        document.querySelectorAll('.save-method-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const $btn = this;
                const $form = $btn.closest('.method-config-form');
                const methodKey = $form.dataset.methodKey;
                const formData = new FormData();

                formData.append('display_name', $form.querySelector('input[name="display_name"]').value);
                formData.append('account_name', $form.querySelector('input[name="account_name"]').value);
                formData.append('reference_number', $form.querySelector('input[name="reference_number"]').value);
                formData.append('instructions', $form.querySelector('textarea[name="instructions"]').value);
                formData.append('is_active', $form.querySelector('input[name="is_active"]').checked ? 1 : 0);
                formData.append('_token', '{{ csrf_token() }}');

                const fileInput = $form.querySelector('input[name="qr_code_image"]');
                if (fileInput.files.length > 0) {
                    formData.append('qr_code_image', fileInput.files[0]);
                }

                const $feedback = $form.querySelector('.method-feedback');
                const $badge = $form.closest('.config-card').querySelector('.status-badge-method');

                $btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Saving...';
                $btn.disabled = true;

                fetch('{{ url("admin/payment-methods") }}/' + methodKey + '/update', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $feedback.classList.remove('d-none');
                        $feedback.querySelector('span').textContent = data.message;
                        setTimeout(() => $feedback.classList.add('d-none'), 3000);

                        const isActive = $form.querySelector('input[name="is_active"]').checked;
                        if (isActive) {
                            $badge.classList.remove('bg-secondary');
                            $badge.classList.add('bg-success');
                            $badge.textContent = 'Available';
                        } else {
                            $badge.classList.remove('bg-success');
                            $badge.classList.add('bg-secondary');
                            $badge.textContent = 'Unavailable';
                        }

                        if (fileInput.files.length > 0 || data.qr_code_url !== undefined) {
                            setTimeout(() => location.reload(), 1500);
                        }
                    } else {
                        Swal.fire('Error', 'Could not update configuration', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'Network error occurred.', 'error');
                })
                .finally(() => {
                    $btn.innerHTML = '<i class="fas fa-save me-1"></i> Save Changes (real‑time)';
                    $btn.disabled = false;
                });
            });
        });

        // =========================================
        // 10. REMOVE QR
        // =========================================
        document.querySelectorAll('.remove-qr-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const methodKey = this.dataset.method;
                const $form = this.closest('.config-card').querySelector('.method-config-form');

                Swal.fire({
                    title: 'Remove QR Code?',
                    text: "Permanently remove the QR code image.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('display_name', $form.querySelector('input[name="display_name"]').value);
                        formData.append('account_name', $form.querySelector('input[name="account_name"]').value);
                        formData.append('reference_number', $form.querySelector('input[name="reference_number"]').value);
                        formData.append('instructions', $form.querySelector('textarea[name="instructions"]').value);
                        formData.append('is_active', $form.querySelector('input[name="is_active"]').checked ? 1 : 0);
                        formData.append('remove_qr', true);
                        formData.append('_token', '{{ csrf_token() }}');

                        fetch('{{ url("admin/payment-methods") }}/' + methodKey + '/update', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Removed!', 'QR code has been removed.', 'success');
                                location.reload();
                            } else {
                                Swal.fire('Error', 'Could not remove QR code', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Network error occurred.', 'error');
                        });
                    }
                });
            });
        });
    });
</script>
@endpush