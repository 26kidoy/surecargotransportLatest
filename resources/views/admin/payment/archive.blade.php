@extends('admin.layouts.app')

@section('title', 'SureCargo Admin | Archived Payments')
@section('page-title', 'Archived Payments')

@push('styles')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" nonce="{{ $csp_nonce }}">
    <style nonce="{{ $csp_nonce }}">

      /* ============================================================
   TRANSACTIONS/ORDERS PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
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

.btn-teal {
    background: var(--green-primary);
    color: white;
    border-radius: 60px;
    padding: var(--sp-sm) var(--sp-lg);
    font-size: var(--font-base) !important;
    font-weight: 600;
    border: none;
    min-height: 44px;
}

.btn-teal:hover {
    background: var(--green-light);
    color: white;
    transform: translateY(-2px);
}

.btn-outline-success {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-md);
    border-radius: 50px;
    font-weight: 600;
    border: 2px solid var(--green-primary);
    color: var(--green-primary);
    background: white;
    min-height: 40px;
}

.btn-outline-success:hover {
    background: var(--green-primary);
    color: white;
    transform: translateY(-2px);
}

.btn-outline-danger {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-md);
    border-radius: 50px;
    font-weight: 600;
    border: 2px solid var(--red-primary);
    color: var(--red-primary);
    background: white;
    min-height: 40px;
}

.btn-outline-danger:hover {
    background: var(--red-primary);
    color: white;
    transform: translateY(-2px);
}

.btn-outline-secondary {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-md);
    border-radius: 50px;
    font-weight: 600 !important;
    background: linear-gradient(135deg, white, hsl(278, 88%, 77%) 100%);
    border: 2px solid var(--green-primary);
    color: var(--green-primary);
    min-height: 40px;
}

.btn-outline-secondary:hover {
    background: linear-gradient(135deg, hsl(125, 90%, 47%) 0%, white 100%);
    color: black !important;
    transform: translateY(-2px);
}

.btn-group .btn {
    margin: 0 0.3rem;
}

.btn-export-csv {
    background: linear-gradient(135deg, white, hsl(278, 88%, 77%) 100%);
    border: 2px solid var(--green-primary);
    border-radius: 50px;
    padding: var(--sp-sm) var(--sp-md);
    font-size: var(--font-base) !important;
    font-weight: 600;
    transition: 0.2s;
    color: var(--green-primary);
    min-height: 40px;
}

.btn-export-csv:hover {
    transform: scale(1.05) !important;
    box-shadow: 0 6px 12px rgba(134, 16, 163, 0.3);
    background: var(--green-primary);
    color: white;
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

/* ============================================================
   TABLE
   ============================================================ */
.data-table-container {
    background: white;
    border-radius: var(--radius-card);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    padding: var(--sp-lg);
}

.table {
    font-size: var(--font-base);
    margin-bottom: 0;
}

.table thead th {
    font-weight: 700;
    font-size: var(--font-sm) !important;
    background: #F4F8F6;
    border-bottom: 2px solid var(--gray-200);
    padding: var(--sp-md) var(--sp-sm);
    color: #0A4D3E;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table tbody td {
    padding: var(--sp-md) var(--sp-sm);
    vertical-align: middle;
    border-color: var(--gray-200);
    background: white;
    font-size: var(--font-base) !important;
}

.table tbody tr:hover {
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
   FILTER BAR
   ============================================================ */
.filter-bar {
    background: white;
    padding: var(--sp-md) var(--sp-lg);
    border-radius: 60px;
    margin-bottom: var(--sp-xl);
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    gap: var(--sp-lg);
    flex-wrap: wrap;
    border: 1px solid var(--gray-200);
}

.filter-label {
    font-weight: 700;
    font-size: var(--font-base);
    color: #1e293b;
}

.status-filter-select {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-xl) !important;
    border-radius: 48px;
    border: 1px solid #cbd5e1;
    background: white;
    font-weight: 500;
    cursor: pointer;
    min-width: 200px;
    min-height: 44px;
}

.filter-clear {
    font-size: var(--font-base);
    color: #475569;
    text-decoration: none;
    font-weight: 500;
    background: transparent;
    border: none;
    min-height: 40px;
    padding: var(--sp-xs) var(--sp-md);
}

.filter-clear:hover {
    color: var(--red-primary);
}

/* ============================================================
   PAGINATION
   ============================================================ */
.pagination {
    font-size: var(--font-base);
    margin-top: var(--sp-xl);
    flex-wrap: wrap;
    gap: var(--sp-sm);
}

.pagination .page-link {
    padding: var(--sp-sm) var(--sp-md);
    font-size: var(--font-base) !important;
    border-radius: 40px;
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

.table code {
    font-size: var(--font-sm);
    background: #fef2f2;
    padding: var(--sp-xs) var(--sp-sm);
    border-radius: 12px;
    color: var(--red-primary);
}

.fa, .fas {
    font-size: var(--font-md);
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
   UTILITY
   ============================================================ */
i.fa, i.fas, i.far {
    color: inherit;
    margin-right: 6px;
    font-size: var(--font-md);
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

    .filter-bar {
        border-radius: 40px;
        padding: var(--sp-sm) var(--sp-md);
        gap: var(--sp-md);
    }

    .status-filter-select {
        min-width: 160px;
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

    .data-table-container {
        padding: var(--sp-sm);
        border-radius: 1.5rem;
        overflow-x: auto;
    }

    .table thead th {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-xs);
    }

    .table tbody td {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-xs);
    }

    .filter-bar {
        flex-direction: column;
        align-items: stretch;
        border-radius: 28px;
        padding: var(--sp-sm) var(--sp-md);
        gap: var(--sp-sm);
    }

    .filter-bar .ms-auto {
        margin-left: 0 !important;
    }

    .status-filter-select {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md) !important;
        min-width: 100%;
        min-height: 38px;
    }

    .status-badge {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 30px;
    }

    .btn {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
    }

    .btn-teal {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
    }

    .btn-outline-success,
    .btn-outline-danger,
    .btn-outline-secondary {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 36px;
    }

    .btn-export-csv {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 36px;
    }

    .pagination .page-link {
        font-size: var(--font-sm) !important;
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

    .filter-label {
        font-size: var(--font-sm);
    }

    .filter-clear {
        font-size: var(--font-sm);
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

    .table thead th {
        font-size: 0.55rem !important;
        padding: var(--sp-xs) 0.2rem;
    }

    .table tbody td {
        font-size: 0.55rem !important;
        padding: var(--sp-xs) 0.2rem;
    }

    .status-badge {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 26px;
    }

    .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 2rem;
    }

    .btn-teal {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .btn-outline-success,
    .btn-outline-danger,
    .btn-outline-secondary {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .btn-export-csv {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .filter-bar {
        border-radius: 20px;
        padding: var(--sp-xs) var(--sp-sm);
    }

    .status-filter-select {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 34px;
    }

    .pagination .page-link {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-xs);
        min-height: 28px;
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

    .filter-label {
        font-size: var(--font-xs);
    }

    .filter-clear {
        font-size: var(--font-xs);
    }

    .modal-custom .modal-title {
        font-size: var(--font-sm) !important;
    }

    .modal-custom .reference-display {
        font-size: var(--font-xs) !important;
    }

    .modal-custom .amount-display {
        font-size: var(--font-sm) !important;
    }

    .data-table-container {
        padding: var(--sp-xs);
        border-radius: 1.2rem;
    }

    .table code {
        font-size: 0.5rem;
        padding: 0.05rem var(--sp-xs);
    }

    .fa, .fas {
        font-size: var(--font-sm);
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

    .stat-card .text-secondary {
        font-size: 0.5rem !important;
    }

    .table thead th {
        font-size: 0.45rem !important;
        padding: 0.05rem 0.05rem;
    }

    .table tbody td {
        font-size: 0.45rem !important;
        padding: 0.05rem 0.05rem;
    }

    .btn {
        font-size: 0.5rem !important;
        min-height: 30px;
    }

    .status-badge {
        font-size: 0.45rem !important;
        min-height: 22px;
        padding: 0.05rem var(--sp-xs);
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

    .filter-bar {
        padding: 0.05rem var(--sp-xs);
    }

    .status-filter-select {
        font-size: 0.5rem !important;
        min-height: 30px;
        padding: 0.05rem var(--sp-xs) !important;
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

    .btn-teal {
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
        padding: 0.05rem var(--sp-xs);
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
<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Total Archived</p>
                    <h2 class="fw-bold text-success">{{ $archivedPayments->total() }}</h2>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 8v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8" />
                        <polyline points="3 8 12 13 21 8" />
                        <path d="M7 4v4" />
                        <path d="M17 4v4" />
                        <path d="M12 4v5" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-secondary mb-1">Total Archived Amount</p>
                    <h2 class="fw-bold">₱{{ number_format($archivedPayments->sum('amount'), 2) }}</h2>
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
</div>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Back to Active Payments</a>
    <h4 class="mb-0 fw-bold" style="font-size: 2rem;">Archived Payments</h4>
    <div></div>
</div>

<div class="data-table-container">
    <!-- Status Filter Bar + Export Button -->
    <div class="filter-bar">
        <span class="filter-label"><i class="fas fa-filter me-2"></i> Filter by Status:</span>
        <select id="statusFilter" class="status-filter-select">
            <option value="all">All Payments</option>
            <option value="pending">Pending</option>
            <option value="approve">Approved / Active</option>
            <option value="decline">Declined / Blocked</option>
            <option value="refunded">Refunded</option>
            <option value="cod">Cash on Delivery</option>
        </select>
        <button id="clearFilterBtn" class="btn filter-clear"><i class="fas fa-times-circle"></i> Reset</button>
        <div class="ms-auto d-flex gap-3 align-items-center">
            <div class="text-muted small" id="filteredCount" style="font-size:1.3rem;">Showing all entries</div>
            <button id="exportCsvBtn" class="btn-export-csv"><i class="fas fa-file-csv me-2"></i> Export CSV</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="archiveTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reference</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Archived On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="archiveTableBody">
                @forelse($archivedPayments as $payment)
                <tr data-status="{{ strtolower($payment->status) }}" data-id="{{ $payment->id }}">
                    <td>#{{ $payment->id }}</td>
                    <td><code class="fw-bold">{{ $payment->payment_reference }}</code></td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-user-circle text-secondary fa-fw"></i>
                            <div>
                                <div class="text-dark fw-semibold">{{ $payment->user->full_name ?? 'N/A' }}</div>
                                <div class="text-secondary" style="font-size:1.3rem;">{{ $payment->user->mobile_number ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="fw-bold text-dark">₱{{ number_format($payment->amount, 2) }}</td>
                    <td><i class="fas {{ $payment->payment_method_icon ?? 'fa-credit-card' }} me-2"></i> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
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
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ ucfirst($payment->status) }}</span>
                     </td>
                    <td class="text-secondary">
                        @if($payment->archived_at)
                            {{ \Carbon\Carbon::parse($payment->archived_at)->format('M d, Y H:i') }}
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        <div class="btn-group d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-success restore-payment-btn" data-url="{{ route('admin.payments.restore', $payment->id) }}" data-id="{{ $payment->id }}" data-reference="{{ $payment->payment_reference }}"><i class="fas fa-trash-restore me-1"></i> Restore</button>
                            <button type="button" class="btn btn-sm btn-outline-danger force-delete-payment-btn" data-url="{{ route('admin.payments.force-delete', $payment->id) }}" data-id="{{ $payment->id }}" data-reference="{{ $payment->payment_reference }}"><i class="fas fa-trash-alt me-1"></i> Delete Permanently</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="noRecordsRow">
                    <td colspan="8" class="text-center text-secondary py-5">
                        <i class="fas fa-archive fa-3x mb-3 d-block"></i>No archived payments found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Original pagination (server-side) -->
    <div class="mt-4 d-flex justify-content-end">
        {{ $archivedPayments->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js" nonce="{{ $csp_nonce }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" nonce="{{ $csp_nonce }}"></script>
<script nonce="{{ $csp_nonce }}">
    $(document).ready(function() {
        // ---- STATUS FILTER LOGIC (client-side) ----
        const filterDropdown = $('#statusFilter');
        const noDataOriginal = $('#noRecordsRow').length > 0;

        function updateFilteredCount(visibleCount, totalCount) {
            $('#filteredCount').text(`Showing ${visibleCount} of ${totalCount} entries`);
            if (visibleCount === 0 && totalCount > 0) {
                if ($('#noFilterMatch').length === 0) {
                    $('#archiveTableBody').append('<tr id="noFilterMatch"><td colspan="8" class="text-center py-4 text-muted">⚠️ No payments match the selected status.</td></tr>');
                }
            } else {
                $('#noFilterMatch').remove();
            }
        }

        function applyStatusFilter() {
            const selectedStatus = filterDropdown.val();
            let visibleCount = 0;
            let totalRowsWithStatus = 0;

            $('#archiveTableBody tr').each(function() {
                const $row = $(this);
                if ($row.attr('id') === 'noRecordsRow' || $row.attr('id') === 'noFilterMatch') {
                    return;
                }
                const rowStatus = $row.data('status');
                if (rowStatus) {
                    totalRowsWithStatus++;
                    if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                        $row.show();
                        visibleCount++;
                    } else {
                        $row.hide();
                    }
                } else {
                    $row.show();
                    visibleCount++;
                }
            });

            if (totalRowsWithStatus === 0 && !noDataOriginal) {
                $('#filteredCount').text('No archived payments found');
            } else {
                updateFilteredCount(visibleCount, totalRowsWithStatus);
            }

            if ($('#noRecordsRow').length && selectedStatus !== 'all') {
                $('#noRecordsRow').hide();
            } else if ($('#noRecordsRow').length) {
                $('#noRecordsRow').show();
            }
        }

        filterDropdown.on('change', applyStatusFilter);
        $('#clearFilterBtn').on('click', function() {
            filterDropdown.val('all').trigger('change');
        });
        applyStatusFilter();

        // ---- EXPORT CSV FUNCTIONALITY ----
        function exportToCSV() {
            const rows = $('#archiveTableBody tr:visible').filter(function() {
                const id = $(this).attr('id');
                return id !== 'noRecordsRow' && id !== 'noFilterMatch';
            });

            if (rows.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'No Data',
                    text: 'There are no visible rows to export.',
                    confirmButtonColor: '#8610a3'
                });
                return;
            }

            const headers = ['ID', 'Reference', 'User', 'Amount', 'Method', 'Status', 'Archived On'];
            const csvData = [headers];

            rows.each(function() {
                const $row = $(this);
                const cells = $row.find('td');
                if (cells.length >= 7) {
                    let id = cells.eq(0).text().trim().replace(/^#/, '');
                    let reference = cells.eq(1).text().trim();
                    let userCell = cells.eq(2);
                    let name = userCell.find('.text-dark').text().trim();
                    let mobile = userCell.find('.text-secondary').text().trim();
                    let user = name + (mobile ? ' (' + mobile + ')' : '');
                    let amount = cells.eq(3).text().trim().replace('₱', '').replace(/,/g, '');
                    let method = cells.eq(4).text().trim();
                    let status = cells.eq(5).find('.status-badge').text().trim() || cells.eq(5).text().trim();
                    let archivedOn = cells.eq(6).text().trim() || '—';

                    csvData.push([id, reference, user, amount, method, status, archivedOn]);
                }
            });

            let csvContent = csvData.map(row =>
                row.map(cell => {
                    if (typeof cell === 'string' && (cell.includes(',') || cell.includes('"') || cell.includes('\n'))) {
                        cell = cell.replace(/"/g, '""');
                        return `"${cell}"`;
                    }
                    return cell;
                }).join(',')
            ).join('\n');

            const blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'archived_payments_export.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }

        $('#exportCsvBtn').on('click', exportToCSV);

        // =========================================
        // ---- RESTORE PAYMENT - FIXED ----
        // =========================================
        $(document).on('click', '.restore-payment-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $btn = $(this);
            const restoreUrl = $btn.data('url');
            const reference = $btn.data('reference');
            
            Swal.fire({
                title: '<i class="fas fa-trash-restore me-2" style="color: #8610a3;"></i> Restore Payment?',
                html: 'You are about to restore payment <strong>' + reference + '</strong>.<br>It will be moved back to the active payments list.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#8610a3',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, restore it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const originalHtml = $btn.html();
                    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>');
                    $btn.prop('disabled', true);
                    
                    $.ajax({
                        url: restoreUrl,
                        method: 'PATCH',
                        headers: { 
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Restored!',
                                    text: res.message || 'Payment restored successfully.',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    confirmButtonColor: '#8610a3'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: res.message || 'Could not restore payment',
                                    confirmButtonColor: '#8610a3'
                                });
                                $btn.html(originalHtml);
                                $btn.prop('disabled', false);
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Network error occurred.',
                                confirmButtonColor: '#8610a3'
                            });
                            $btn.html(originalHtml);
                            $btn.prop('disabled', false);
                        }
                    });
                }
            });
        });

        // =========================================
        // ---- PERMANENT DELETE - FIXED ----
        // =========================================
        $(document).on('click', '.force-delete-payment-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $btn = $(this);
            const deleteUrl = $btn.data('url');
            const reference = $btn.data('reference');
            
            Swal.fire({
                title: '<i class="fas fa-trash-alt me-2" style="color: #dc2626;"></i> Permanently Delete?',
                html: 'You are about to permanently delete payment <strong>' + reference + '</strong>.<br><span class="text-danger">This action cannot be undone! The payment record will be removed forever.</span>',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete permanently',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const originalHtml = $btn.html();
                    $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>');
                    $btn.prop('disabled', true);
                    
                    $.ajax({
                        url: deleteUrl,
                        method: 'DELETE',
                        headers: { 
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: res.message || 'Payment has been permanently removed.',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    confirmButtonColor: '#8610a3'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: res.message || 'Could not delete payment',
                                    confirmButtonColor: '#8610a3'
                                });
                                $btn.html(originalHtml);
                                $btn.prop('disabled', false);
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Network error occurred.',
                                confirmButtonColor: '#8610a3'
                            });
                            $btn.html(originalHtml);
                            $btn.prop('disabled', false);
                        }
                    });
                }
            });
        });
    });
</script>
@endpush