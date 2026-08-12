@extends('admin.layouts.app')

@section('title', 'Manage Damage Requests')
@section('page-title', 'Damage Requests')

@section('content')
@php
    use App\Models\DamageRequest;
    $totalRequests = DamageRequest::count();
    $pendingCount = DamageRequest::where('status', 'pending')->count();
    $approvedCount = DamageRequest::where('status', 'approved')->count();
    $rejectedCount = DamageRequest::where('status', 'rejected')->count();
@endphp

<style nonce="{{ $csp_nonce }}">
  /* =============================================
   PROFESSIONAL ADMIN DASHBOARD STYLES
   Theme: White / Violet / Green / Red
   Min Font Size: 1.5rem (24px base)
   Bold & Clear Typography
   ============================================= */

@import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap');

/* ============================================================
   DAMAGE REPORTS - DEEPSEEK-STYLE RESPONSIVE STYLES
   Theme: White / Violet / Green / Red
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-light: #9c27b0;
    --violet-soft: #f3e5f5;
    --violet-dark: #4a148c;
    --green-primary: #28a745;
    --green-light: #34ce57;
    --green-soft: #E6F4EF;
    --red-primary: #dc3545;
    --red-dark: #b91c2c;
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
    font-family: 'Inter', 'Poppins', system-ui, sans-serif !important;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    font-size: 16px;
    -webkit-text-size-adjust: 100%;
}

body {
    font-family: 'Inter', 'Poppins', sans-serif !important;
    background: var(--white);
    color: #1A2C2A;
    font-size: var(--font-base) !important;
    font-weight: 400;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

body, .card, .table, .btn, .form-select, .form-control, .pagination, .modal-content, label, input, select, textarea {
    font-family: 'Inter', 'Poppins', sans-serif !important;
    font-size: var(--font-base) !important;
}

/* ============================================================
   TYPOGRAPHY
   ============================================================ */
h1, h2, h3, h4, h5, h6, .page-title, .section-title {
    font-weight: 800 !important;
    letter-spacing: -0.02em !important;
    line-height: 1.2;
}

h1 { font-size: var(--font-xxxl) !important; }
h2 { font-size: var(--font-xxl) !important; }
h3 { font-size: var(--font-xl) !important; }
h4 { font-size: var(--font-lg) !important; }
h5 { font-size: var(--font-md) !important; }
h6 { font-size: var(--font-base) !important; }

p, span, li, a, label, input, select, textarea, button,
.table, .badge, .small, .text-muted, .form-text,
.modal-content, .btn, .form-label, .status-badge {
    font-size: var(--font-base) !important;
    line-height: 1.6 !important;
}

.page-title {
    font-size: var(--font-xl) !important;
    color: var(--violet-dark) !important;
    margin-bottom: var(--sp-lg) !important;
}

.section-title {
    font-size: var(--font-lg) !important;
    color: var(--violet-dark) !important;
    font-weight: 800 !important;
}

/* ============================================================
   STATS CARDS
   ============================================================ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--sp-lg);
    margin-bottom: var(--sp-xl);
}

.stat-card-modern {
    background: #FFFFFF;
    border-radius: 24px !important;
    padding: var(--sp-lg) var(--sp-lg);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

.stat-card-modern:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--violet-primary);
}

.stat-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 6px;
    height: 100%;
    border-radius: 24px 0 0 24px;
}

.stat-info h4 {
    font-size: var(--font-sm) !important;
    font-weight: 600 !important;
    color: var(--gray-600);
    margin-bottom: var(--sp-xs) !important;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.stat-number {
    font-size: var(--font-xl) !important;
    font-weight: 800 !important;
    color: var(--violet-dark);
    line-height: 1.2;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--violet-soft);
    color: var(--violet-primary);
    font-size: var(--font-xl);
    flex-shrink: 0;
}

.stat-card-modern.total .stat-icon { background: var(--violet-soft); color: var(--violet-primary); }
.stat-card-modern.pending .stat-icon { background: #FEE2E2; color: var(--red-primary); }
.stat-card-modern.approved .stat-icon { background: #DCFCE7; color: var(--green-primary); }
.stat-card-modern.rejected .stat-icon { background: #FEE2E2; color: var(--red-primary); }

/* ============================================================
   MAIN CARD
   ============================================================ */
.main-card-modern {
    background: #FFFFFF;
    border-radius: 28px !important;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    overflow: hidden;
    margin-bottom: var(--sp-xl);
}

.card-header-modern {
    background: #FFFFFF;
    padding: var(--sp-md) var(--sp-lg);
    border-bottom: 2px solid var(--gray-200);
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: var(--sp-md);
}

.card-header-modern h2 {
    color: var(--violet-dark);
    font-size: var(--font-lg) !important;
    font-weight: 800 !important;
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--sp-sm);
}

/* ============================================================
   CHART
   ============================================================ */
.chart-container-modern {
    background: #FFFFFF;
    border-radius: 20px;
    padding: var(--sp-lg);
    margin-bottom: var(--sp-xl);
    border: 1px solid var(--gray-200);
}

.chart-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--sp-lg);
    gap: var(--sp-md);
}

.chart-header h4 {
    font-size: var(--font-md) !important;
    font-weight: 700 !important;
    color: var(--violet-dark);
    margin: 0;
}

.period-buttons {
    display: flex;
    gap: var(--sp-sm);
    flex-wrap: wrap;
}

.period-btn-modern {
    background: #FFFFFF;
    border: 1px solid var(--gray-200);
    border-radius: 40px;
    padding: var(--sp-xs) var(--sp-md);
    font-size: var(--font-sm) !important;
    font-weight: 600;
    color: var(--gray-600);
    transition: all 0.2s;
    cursor: pointer;
    min-height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.period-btn-modern:hover {
    background: var(--violet-soft);
    border-color: var(--violet-primary);
    color: var(--violet-primary);
}

.period-btn-modern.active {
    background: var(--violet-primary);
    border-color: var(--violet-primary);
    color: white;
}

#damageChart {
    max-height: 250px !important;
    width: 100% !important;
}

/* ============================================================
   TABLE
   ============================================================ */
.table-container {
    overflow-x: auto;
    border-radius: 20px;
}

.damage-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: var(--font-base) !important;
}

.damage-table thead th {
    padding: var(--sp-md) var(--sp-md) !important;
    font-size: var(--font-sm) !important;
    font-weight: 700 !important;
    color: var(--violet-dark);
    background: var(--violet-soft);
    border-bottom: 2px solid var(--violet-primary);
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.damage-table tbody td {
    padding: var(--sp-md) var(--sp-md) !important;
    font-size: var(--font-base) !important;
    color: #1A2C2A;
    vertical-align: middle;
    border-bottom: 1px solid var(--gray-200);
    background: #FFFFFF;
}

.damage-table tbody tr:hover td {
    background: var(--violet-soft) !important;
    transition: all 0.3s ease;
}

.damage-table tbody tr:nth-child(even) td {
    background: var(--gray-100);
}

/* ============================================================
   BADGES
   ============================================================ */
.badge-modern {
    display: inline-flex;
    align-items: center;
    gap: var(--sp-xs);
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 40px;
    font-size: var(--font-sm) !important;
    font-weight: 600 !important;
    line-height: 1;
    white-space: nowrap;
    min-height: 32px;
}

.badge-pending-modern {
    background: #FEE2E2;
    color: var(--red-primary);
    border-left: 4px solid var(--red-primary);
}

.badge-approved-modern {
    background: #DCFCE7;
    color: var(--green-primary);
    border-left: 4px solid var(--green-primary);
}

.badge-rejected-modern {
    background: #FEE2E2;
    color: var(--red-primary);
    border-left: 4px solid var(--red-primary);
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-modern {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 40px;
    font-size: var(--font-base) !important;
    font-weight: 600 !important;
    border: 2px solid transparent;
    transition: all 0.3s;
    cursor: pointer;
    min-height: 40px;
}

.btn-primary-modern {
    background: var(--violet-primary);
    border-color: var(--violet-primary);
    color: white;
}

.btn-primary-modern:hover {
    background: var(--violet-light);
    border-color: var(--violet-light);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.btn-outline-modern {
    background: transparent;
    border-color: var(--gray-200);
    color: var(--gray-600);
}

.btn-outline-modern:hover {
    background: var(--violet-soft);
    border-color: var(--violet-primary);
    color: var(--violet-primary);
    transform: translateY(-2px);
}

.btn-danger-modern {
    background: var(--red-primary);
    border-color: var(--red-primary);
    color: white;
}

.btn-danger-modern:hover {
    background: var(--red-dark);
    border-color: var(--red-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.btn-icon-modern {
    width: 40px;
    height: 40px;
    padding: 0;
    border-radius: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--gray-100);
    border: 1px solid var(--gray-200);
    color: var(--gray-600);
    transition: all 0.3s;
    font-size: var(--font-md) !important;
    min-width: 40px;
    min-height: 40px;
}

.btn-icon-modern:hover {
    background: var(--violet-primary);
    border-color: var(--violet-primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.btn-icon-modern svg {
    width: 20px;
    height: 20px;
}

.damage-table tbody td .btn-icon-modern {
    width: 40px;
    height: 40px;
    min-width: 40px;
    min-height: 40px;
    font-size: var(--font-md) !important;
}

.damage-table tbody td .btn-icon-modern svg {
    width: 20px;
    height: 20px;
}

/* ============================================================
   STATUS SELECT
   ============================================================ */
.status-select {
    border-radius: 40px;
    padding: var(--sp-xs) var(--sp-xl) var(--sp-xs) var(--sp-md);
    font-size: var(--font-sm) !important;
    font-weight: 600;
    border: 1px solid var(--gray-200);
    background: #FFFFFF;
    cursor: pointer;
    transition: all 0.2s;
    min-height: 38px;
}

.status-select:hover {
    border-color: var(--violet-primary);
}

.status-select:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* ============================================================
   THUMBNAIL IMAGE
   ============================================================ */
.thumbnail-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 16px;
    border: 2px solid var(--violet-primary);
    transition: transform 0.2s;
}

.thumbnail-image:hover {
    transform: scale(1.1);
    box-shadow: 0 0.3rem 0.8rem rgba(123, 31, 162, 0.2);
}

.thumbnail-placeholder {
    width: 50px;
    height: 50px;
    border-radius: 16px;
    background: var(--gray-100);
    border: 2px dashed var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-600);
    font-size: var(--font-sm) !important;
}

/* ============================================================
   MODAL
   ============================================================ */
.modal-content-modern {
    border-radius: 28px;
    border: none;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    font-family: 'Inter', 'Poppins', sans-serif !important;
    font-size: var(--font-base) !important;
}

.modal-header-modern {
    padding: var(--sp-md) var(--sp-lg);
    border-bottom: 2px solid var(--gray-200);
    background: #FFFFFF;
    border-radius: 28px 28px 0 0;
}

.modal-header-modern h5 {
    font-size: var(--font-lg) !important;
    font-weight: 800 !important;
    color: var(--violet-dark);
}

.modal-body-modern {
    padding: var(--sp-lg);
    font-size: var(--font-base) !important;
    color: #1A2C2A;
}

.modal-footer-modern {
    padding: var(--sp-md) var(--sp-lg);
    border-top: 1px solid var(--gray-200);
    gap: var(--sp-sm);
    border-radius: 0 0 28px 28px;
}

.modal-footer-modern .btn {
    font-size: var(--font-base) !important;
    min-height: 40px;
}

/* ============================================================
   PAGINATION
   ============================================================ */
.pagination-modern {
    display: flex;
    justify-content: center;
    margin-top: var(--sp-lg);
    gap: var(--sp-sm);
    flex-wrap: wrap;
}

.pagination-modern .page-link {
    font-size: var(--font-base) !important;
    font-weight: 600;
    border-radius: 3rem;
    padding: var(--sp-sm) var(--sp-md);
    color: var(--violet-primary);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    background: #ffffff;
    min-height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.pagination-modern .page-link:hover {
    background: var(--violet-soft);
    border-color: var(--violet-primary);
    transform: translateY(-2px);
}

.pagination-modern .active .page-link {
    background: var(--violet-primary);
    border-color: var(--violet-primary);
    color: #ffffff;
}

/* ============================================================
   TOAST NOTIFICATION
   ============================================================ */
.success-toast-modern {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: var(--violet-primary);
    color: white;
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 48px;
    font-size: var(--font-base);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--sp-sm);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    z-index: 1100;
    backdrop-filter: blur(4px);
    animation: slideInRight 0.3s ease;
    min-height: 44px;
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* ============================================================
   UTILITY CLASSES
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

.text-violet {
    color: var(--violet-primary) !important;
    font-weight: 600;
}

.text-secondary {
    color: var(--gray-600) !important;
}

small, .small {
    font-weight: 400;
    color: var(--gray-600) !important;
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

    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: var(--sp-md);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        font-size: var(--font-lg);
    }

    .stat-number {
        font-size: var(--font-lg) !important;
    }

    .damage-table thead th {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-sm) !important;
    }

    .damage-table tbody td {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-sm) !important;
    }

    #damageChart {
        max-height: 200px !important;
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

    body, .card, .table, .btn, .form-select, .form-control, .pagination, .modal-content, label, input, select, textarea {
        font-size: var(--font-sm) !important;
    }

    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: var(--sp-sm);
    }

    .stat-card-modern {
        padding: var(--sp-sm) var(--sp-md);
        border-radius: 18px !important;
    }

    .stat-number {
        font-size: var(--font-md) !important;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        font-size: var(--font-md);
        border-radius: 20px;
    }

    .stat-info h4 {
        font-size: var(--font-xs) !important;
    }

    .card-header-modern {
        flex-direction: column;
        align-items: flex-start;
        padding: var(--sp-sm) var(--sp-md);
    }

    .card-header-modern h2 {
        font-size: var(--font-md) !important;
    }

    .damage-table thead th {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-xs) !important;
    }

    .damage-table tbody td {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm) var(--sp-xs) !important;
    }

    .chart-container-modern {
        padding: var(--sp-sm);
        border-radius: 16px;
    }

    .chart-header {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: var(--sp-sm);
    }

    .chart-header h4 {
        font-size: var(--font-sm) !important;
    }

    .period-buttons {
        width: 100%;
        justify-content: flex-start;
    }

    .period-btn-modern {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    #damageChart {
        max-height: 180px !important;
    }

    .btn-modern {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md);
        min-height: 36px;
        border-radius: 30px;
    }

    .btn-icon-modern {
        width: 34px;
        height: 34px;
        min-width: 34px;
        min-height: 34px;
        font-size: var(--font-sm) !important;
    }

    .btn-icon-modern svg {
        width: 16px;
        height: 16px;
    }

    .badge-modern {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 28px;
    }

    .status-select {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .thumbnail-image {
        width: 40px;
        height: 40px;
    }

    .thumbnail-placeholder {
        width: 40px;
        height: 40px;
        font-size: var(--font-xs) !important;
    }

    .modal-content-modern {
        border-radius: 20px;
    }

    .modal-header-modern {
        padding: var(--sp-sm) var(--sp-md);
    }

    .modal-header-modern h5 {
        font-size: var(--font-md) !important;
    }

    .modal-body-modern {
        padding: var(--sp-md);
        font-size: var(--font-sm) !important;
    }

    .modal-footer-modern {
        padding: var(--sp-sm) var(--sp-md);
    }

    .modal-footer-modern .btn {
        font-size: var(--font-sm) !important;
        min-height: 36px;
    }

    .pagination-modern .page-link {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .success-toast-modern {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
        bottom: 16px;
        right: 16px;
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

    body, .card, .table, .btn, .form-select, .form-control, .pagination, .modal-content, label, input, select, textarea {
        font-size: var(--font-xs) !important;
    }

    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: var(--sp-xs);
    }

    .stat-card-modern {
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 14px !important;
    }

    .stat-number {
        font-size: var(--font-sm) !important;
    }

    .stat-icon {
        width: 32px;
        height: 32px;
        font-size: var(--font-sm);
        border-radius: 16px;
    }

    .stat-info h4 {
        font-size: 0.5rem !important;
    }

    .damage-table thead th {
        font-size: 0.55rem !important;
        padding: var(--sp-xs) var(--sp-xs) !important;
    }

    .damage-table tbody td {
        font-size: 0.55rem !important;
        padding: var(--sp-xs) var(--sp-xs) !important;
    }

    .btn-modern {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .btn-icon-modern {
        width: 30px;
        height: 30px;
        min-width: 30px;
        min-height: 30px;
        font-size: var(--font-xs) !important;
    }

    .btn-icon-modern svg {
        width: 14px;
        height: 14px;
    }

    .badge-modern {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 24px;
    }

    .status-select {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 28px;
    }

    .period-btn-modern {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 28px;
    }

    .thumbnail-image {
        width: 32px;
        height: 32px;
        border-width: 1.5px;
    }

    .thumbnail-placeholder {
        width: 32px;
        height: 32px;
        font-size: 0.5rem !important;
    }

    .modal-header-modern h5 {
        font-size: var(--font-sm) !important;
    }

    .modal-body-modern {
        font-size: var(--font-xs) !important;
        padding: var(--sp-sm);
    }

    .modal-footer-modern .btn {
        font-size: var(--font-xs) !important;
        min-height: 32px;
    }

    .pagination-modern .page-link {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-xs);
        min-height: 28px;
    }

    .success-toast-modern {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 32px;
    }

    .page-title {
        font-size: var(--font-md) !important;
    }

    .section-title {
        font-size: var(--font-sm) !important;
    }

    #damageChart {
        max-height: 150px !important;
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

    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 0.05rem;
    }

    .stat-card-modern {
        padding: 0.05rem var(--sp-xs);
        border-radius: 10px !important;
    }

    .stat-number {
        font-size: 0.6rem !important;
    }

    .stat-icon {
        width: 24px;
        height: 24px;
        font-size: 0.6rem;
        border-radius: 12px;
    }

    .stat-info h4 {
        font-size: 0.4rem !important;
    }

    .damage-table thead th {
        font-size: 0.45rem !important;
        padding: 0.05rem 0.05rem !important;
    }

    .damage-table tbody td {
        font-size: 0.45rem !important;
        padding: 0.05rem 0.05rem !important;
    }

    .btn-modern {
        font-size: 0.5rem !important;
        min-height: 28px;
    }

    .btn-icon-modern {
        width: 26px;
        height: 26px;
        min-width: 26px;
        min-height: 26px;
        font-size: 0.5rem !important;
    }

    .btn-icon-modern svg {
        width: 12px;
        height: 12px;
    }

    .badge-modern {
        font-size: 0.45rem !important;
        min-height: 20px;
    }

    .status-select {
        font-size: 0.45rem !important;
        min-height: 24px;
    }

    .period-btn-modern {
        font-size: 0.45rem !important;
        min-height: 24px;
    }

    .thumbnail-image {
        width: 26px;
        height: 26px;
    }

    .modal-footer-modern .btn {
        font-size: 0.5rem !important;
        min-height: 28px;
    }

    .pagination-modern .page-link {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 24px;
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

    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 0.05rem;
    }

    .stat-icon {
        width: 20px;
        height: 20px;
        font-size: 0.5rem;
        border-radius: 10px;
    }

    .stat-number {
        font-size: 0.5rem !important;
    }

    .btn-modern {
        font-size: 0.4rem !important;
        min-height: 24px;
    }

    .modal-footer-modern .btn {
        font-size: 0.4rem !important;
        min-height: 24px;
    }

    .pagination-modern .page-link {
        font-size: 0.4rem !important;
        min-height: 22px;
    }

    .success-toast-modern {
        font-size: 0.4rem !important;
        min-height: 28px;
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

<div class="container-fluid py-4">
    {{-- Statistics Cards --}}
    <div class="stats-grid">
        <div class="stat-card-modern total">
            <div class="stat-info">
                <h4>Total Requests</h4>
                <div class="stat-number">{{ $totalRequests }}</div>
            </div>
            <div class="stat-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 12h-4l-3 9-4-18-3 9H2" />
                </svg>
            </div>
        </div>
        <div class="stat-card-modern pending">
            <div class="stat-info">
                <h4>Pending</h4>
                <div class="stat-number">{{ $pendingCount }}</div>
            </div>
            <div class="stat-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
        </div>
        <div class="stat-card-modern approved">
            <div class="stat-info">
                <h4>Approved</h4>
                <div class="stat-number">{{ $approvedCount }}</div>
            </div>
            <div class="stat-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
        </div>
        <div class="stat-card-modern rejected">
            <div class="stat-info">
                <h4>Rejected</h4>
                <div class="stat-number">{{ $rejectedCount }}</div>
            </div>
            <div class="stat-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </div>
        </div>
    </div>

    <div class="main-card-modern">
        <div class="card-header-modern">
            <h2>
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="color: #DC2626;">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    <path d="M12 8v4" />
                    <path d="M12 16h.01" />
                </svg>
                Damage Requests
            </h2>
            <div>
                <button class="btn-modern btn-outline-modern" id="openExportCsvModalBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Export CSV
                </button>
            </div>
        </div>

        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 20px; background: #DCFCE7; color: #16A34A; border: none; font-size: 1.4rem; font-weight: 600;">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Chart Section --}}
            <div class="chart-container-modern">
                <div class="chart-header">
                    <h4>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="color: #16A34A; margin-right: 0.5rem;">
                            <path d="M21 12v3a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4v-3" />
                            <path d="M12 2v8" />
                            <path d="m16 6-4 4-4-4" />
                            <path d="M2 20h20" />
                        </svg>
                        Damage Requests Trend
                    </h4>
                    <div class="period-buttons">
                        <button class="period-btn-modern active" data-period="week">Weekly</button>
                        <button class="period-btn-modern" data-period="month">Monthly</button>
                        <button class="period-btn-modern" data-period="year">Yearly</button>
                        <button class="period-btn-modern" id="exportChartPdfBtn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.3rem;">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg>
                            PDF
                        </button>
                    </div>
                </div>
                <canvas id="damageChart" width="400" height="180"></canvas>
                <div id="chartErrorMsg" class="text-danger mt-2 text-center" style="display:none; font-size: 1.3rem;">Unable to load chart data. Please try again later.</div>
            </div>

            {{-- Table --}}
            <div class="table-container">
                <table class="damage-table" id="damageTable">
                    <thead>
                        <tr><th>ID</th><th>User</th><th>Booking Ref</th><th>Qty</th><th>Image</th><th>Notes</th><th>Status</th><th>Submitted</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr data-request-id="{{ $req->id }}">
                            <td>{{ $req->id }}</td>
                            <td>{{ $req->user->name ?? 'N/A' }}</td>
                            <td>{{ $req->booking_reference }}</td>
                            <td>{{ $req->egg_quantity }}</td>
                            <td>
                                @php
                                    // FIXED: Use the image_url accessor for public/uploads
                                    $imageUrl = $req->image_url;
                                @endphp
                                @if($imageUrl)
                                    <a href="{{ e($imageUrl) }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ e($imageUrl) }}" class="thumbnail-image" alt="Damage" onerror="this.onerror=null; this.style.display='none'; this.parentElement.innerHTML='<span class=\'text-muted\' style=\'font-size:1.3rem;\'>No image</span>'">
                                    </a>
                                @else
                                    <span class="text-muted" style="font-size: 1.3rem;">No image</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn-icon-modern view-note-btn" data-bs-toggle="modal" data-bs-target="#viewNoteModal"
                                    data-note="{{ $req->notes ?? '—' }}"
                                    data-request-id="{{ $req->id }}"
                                    data-booking-ref="{{ $req->booking_reference }}">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                        <line x1="9" y1="10" x2="15" y2="10" />
                                    </svg>
                                </button>
                            </td>
                            <td>
                                {{-- Status dropdown with AJAX update --}}
                                <select class="status-select status-update" data-request-id="{{ $req->id }}" data-url="{{ route('admin.damage-requests.status', ['damageRequest' => $req->id]) }}">
                                    <option value="pending" {{ $req->status=='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $req->status=='approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $req->status=='rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <div class="mt-2">
                                    @if($req->status == 'approved')
                                        <span class="badge-modern badge-approved-modern">✓ Approved</span>
                                    @elseif($req->status == 'rejected')
                                        <span class="badge-modern badge-rejected-modern">✗ Rejected</span>
                                    @else
                                        <span class="badge-modern badge-pending-modern">⏳ Pending</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $req->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn-icon-modern" data-bs-toggle="modal" data-bs-target="#replyModal{{ $req->id }}" title="Reply">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                            <polyline points="10 11 12 13 16 9" />
                                        </svg>
                                    </button>
                                    <button class="btn-icon-modern delete-request-btn"
                                            data-id="{{ $req->id }}"
                                            data-booking-ref="{{ $req->booking_reference }}"
                                            data-delete-url="{{ route('admin.damage-requests.destroy', $req) }}"
                                            title="Delete Permanently">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            <line x1="10" y1="11" x2="10" y2="17" />
                                            <line x1="14" y1="11" x2="14" y2="17" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Reply Modal --}}
                        <div class="modal fade" id="replyModal{{ $req->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content modal-content-modern">
                                    <form action="{{ route('admin.damage-requests.reply', $req) }}" method="POST" class="reply-form">
                                        @csrf @method('PUT')
                                        <div class="modal-header-modern">
                                            <h5>Reply to #{{ $req->booking_reference }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body-modern">
                                            <textarea name="reply" class="form-control" rows="4" required style="border-radius: 20px; font-size: 1.5rem; padding: 1rem; border: 1px solid #CBD5E1;">{{ $req->admin_reply }}</textarea>
                                        </div>
                                        <div class="modal-footer-modern">
                                            <button type="button" class="btn-modern btn-outline-modern" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn-modern btn-primary-modern">Send Reply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-modern">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>

{{-- View Note Modal --}}
<div class="modal fade" id="viewNoteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <h5><i class="fas fa-sticky-note me-2"></i> Damage Request Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-modern">
                <p><strong>Request #:</strong> <span id="noteRequestId"></span></p>
                <p><strong>Booking Ref:</strong> <span id="noteBookingRef"></span></p>
                <hr style="border-color: #CBD5E1;">
                <div id="fullNoteText" style="white-space: pre-wrap; font-size: 1.5rem;"></div>
            </div>
            <div class="modal-footer-modern">
                <button type="button" class="btn-modern btn-outline-modern" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern" style="border-bottom-color: #DC2626;">
                <h5 style="color: #DC2626;">Confirm Permanent Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-modern">
                <p style="font-size: 1.6rem;">Are you sure you want to permanently delete damage request <strong id="deleteRequestRef"></strong>?</p>
                <p class="text-muted" style="font-size: 1.4rem;">This action cannot be undone.</p>
            </div>
            <div class="modal-footer-modern">
                <button type="button" class="btn-modern btn-outline-modern" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-modern btn-danger-modern" id="confirmDeleteBtn">Yes, Delete Permanently</button>
            </div>
        </div>
    </div>
</div>

{{-- Export CSV Modal --}}
<div class="modal fade" id="exportCsvModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <h5>Export Damage Requests</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-modern">
                <p style="font-size: 1.6rem;">Export all damage request data as CSV file?</p>
                <p class="text-muted" style="font-size: 1.4rem;">The file will include all columns shown in the table.</p>
            </div>
            <div class="modal-footer-modern">
                <button type="button" class="btn-modern btn-outline-modern" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-modern btn-primary-modern" id="confirmExportBtn">Export CSV</button>
            </div>
        </div>
    </div>
</div>

{{-- PDF EXPORT MODAL --}}
<div class="modal fade" id="pdfExportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <h5>Export Chart as PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body-modern">
                <div class="row g-3">
                    <div class="col-12">
                        <p class="text-secondary mb-2" style="font-size: 1.4rem; font-weight: 500;">Chart: <span id="pdfExportChartTitle" class="fw-bold text-dark">Damage Requests Trend</span></p>
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
            <div class="modal-footer-modern">
                <button type="button" class="btn-modern btn-outline-modern" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-modern btn-primary-modern" id="pdfDownloadBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; margin-right: 6px;">
                        <path d="M12 16V4" />
                        <path d="M8 12L12 16L16 12" />
                        <path d="M4 20H20" />
                    </svg>
                    Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<div id="successToast" class="success-toast-modern" style="display:none;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
        <polyline points="22 4 12 14.01 9 11.01" />
    </svg>
    <span id="toastMessage"></span>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script nonce="{{ $csp_nonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        // ==================== CHART LOGIC ====================
        let damageChart = null;
        const ctx = document.getElementById('damageChart').getContext('2d');
        const chartErrorMsg = document.getElementById('chartErrorMsg');

        // Fallback data for each period
        const fallbackData = {
            week: { labels: ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'], counts: [0,0,0,0,0,0,0] },
            month: { labels: ['Week 1','Week 2','Week 3','Week 4'], counts: [0,0,0,0] },
            year: { labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'], counts: Array(12).fill(0) }
        };

        async function fetchChartData(period) {
            try {
                const res = await fetch(`/admin/damage-requests/chart-data?period=${period}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                if (!res.ok) {
                    if (res.status === 403) {
                        throw new Error('Unauthorized – you may not have permission to view chart data.');
                    }
                    throw new Error('HTTP ' + res.status);
                }
                const data = await res.json();
                if (data && Array.isArray(data.labels) && Array.isArray(data.counts)) {
                    return { labels: data.labels, counts: data.counts };
                } else {
                    throw new Error('Invalid data format');
                }
            } catch (e) {
                console.error('Chart fetch error:', e);
                chartErrorMsg.style.display = 'block';
                chartErrorMsg.innerText = e.message || 'Unable to load chart data. Please try again later.';
                return fallbackData[period] || fallbackData.week;
            }
        }

        async function updateChart(period) {
            chartErrorMsg.style.display = 'none';
            const { labels, counts } = await fetchChartData(period);
            if (damageChart) damageChart.destroy();
            damageChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: `Damage Requests (${period})`,
                        data: counts,
                        borderColor: '#16A34A',
                        backgroundColor: 'rgba(22,163,74,0.12)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#DC2626',
                        pointBorderColor: '#FFFFFF',
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            labels: { font: { size: 16, weight: '700' }, color: '#0F172A' }
                        },
                        tooltip: {
                            bodyFont: { size: 16, weight: '600' },
                            titleFont: { size: 18, weight: '800' },
                            padding: 12,
                            backgroundColor: '#0F172A'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { size: 16, weight: '600' }, color: '#475569' },
                            grid: { color: '#E2E8F0' }
                        },
                        x: {
                            ticks: { font: { size: 16, weight: '600' }, color: '#475569' },
                            grid: { color: '#E2E8F0' }
                        }
                    }
                }
            });
        }

        document.querySelectorAll('.period-btn-modern').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.period-btn-modern').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                updateChart(this.getAttribute('data-period'));
            });
        });

        // Initial chart load
        updateChart('week');

        // ==================== PDF EXPORT MODAL LOGIC ====================
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
        document.getElementById('exportChartPdfBtn').addEventListener('click', function() {
            const chartCanvas = document.getElementById('damageChart');
            if (!chartCanvas) {
                alert('Chart not found.');
                return;
            }
            // Generate data URL from canvas
            const dataURL = chartCanvas.toDataURL('image/png');
            pdfExportDataURL = dataURL;

            // Set preview
            document.getElementById('pdfExportPreview').src = dataURL;
            document.getElementById('pdfExportChartTitle').textContent = 'Damage Requests Trend';

            // Reset orientation & page size to defaults
            document.getElementById('pdfOrientation').value = 'landscape';
            document.getElementById('pdfPageSize').value = 'a4';

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('pdfExportModal'));
            modal.show();
        });

        // Handle download button inside PDF modal
        document.getElementById('pdfDownloadBtn')?.addEventListener('click', function() {
            const dataURL = pdfExportDataURL;
            const fileName = 'damage_requests_trend';
            const orientation = document.getElementById('pdfOrientation').value;
            const pageSize = document.getElementById('pdfPageSize').value;
            if (!dataURL) {
                alert('No chart data available. Please try again.');
                return;
            }
            generatePDFFromDataURL(dataURL, fileName, orientation, pageSize);
        });

        // Clean up PDF modal when hidden
        document.getElementById('pdfExportModal')?.addEventListener('hidden.bs.modal', function() {
            pdfExportDataURL = null;
            document.getElementById('pdfExportPreview').src = '';
        });

        // ==================== VIEW NOTE MODAL ====================
        const viewNoteModal = document.getElementById('viewNoteModal');
        viewNoteModal.addEventListener('show.bs.modal', function(event) {
            const btn = event.relatedTarget;
            document.getElementById('fullNoteText').innerText = btn.getAttribute('data-note') || '—';
            document.getElementById('noteRequestId').innerText = btn.getAttribute('data-request-id');
            document.getElementById('noteBookingRef').innerText = btn.getAttribute('data-booking-ref');
        });

        // ==================== STATUS UPDATE (AJAX) ====================
        const statusSelects = document.querySelectorAll('.status-update');
        statusSelects.forEach(select => {
            select.addEventListener('change', function() {
                const url = this.dataset.url;
                const status = this.value;
                const row = this.closest('tr');
                const originalValue = this.value;

                this.disabled = true;

                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => {
                    if (response.status === 403) {
                        throw new Error('Unauthorized – you do not have permission to update status.');
                    }
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => ({ ok: response.ok, data }));
                    } else {
                        return { ok: response.ok, data: { success: true, message: 'Status updated (reload to see changes)' } };
                    }
                })
                .then(({ ok, data }) => {
                    if (data && data.success !== false) {
                        showToast(data.message || 'Status updated to ' + status.charAt(0).toUpperCase() + status.slice(1));
                        const badgeContainer = row.querySelector('.mt-2');
                        if (badgeContainer) {
                            let badgeHtml = '';
                            if (status === 'approved') {
                                badgeHtml = '<span class="badge-modern badge-approved-modern">✓ Approved</span>';
                            } else if (status === 'rejected') {
                                badgeHtml = '<span class="badge-modern badge-rejected-modern">✗ Rejected</span>';
                            } else {
                                badgeHtml = '<span class="badge-modern badge-pending-modern">⏳ Pending</span>';
                            }
                            badgeContainer.innerHTML = badgeHtml;
                        }
                    } else {
                        const msg = (data && data.message) ? data.message : 'Update failed. Refresh to see changes.';
                        showToast(msg, 'danger');
                        this.value = originalValue;
                    }
                })
                .catch(error => {
                    console.error('Status update error:', error);
                    showToast(error.message || 'Update failed. Please refresh.', 'danger');
                    this.value = originalValue;
                })
                .finally(() => {
                    this.disabled = false;
                });
            });
        });

        // ==================== DELETE CONFIRMATION ====================
        let deleteUrl = null;
        let deleteBookingRef = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        const confirmBtn = document.getElementById('confirmDeleteBtn');

        document.querySelectorAll('.delete-request-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                deleteUrl = this.getAttribute('data-delete-url');
                deleteBookingRef = this.getAttribute('data-booking-ref');
                document.getElementById('deleteRequestRef').innerText = deleteBookingRef || `#${this.getAttribute('data-id')}`;
                deleteModal.show();
            });
        });

        confirmBtn.addEventListener('click', function() {
            if (!deleteUrl) {
                showToast('Delete URL not found.', 'danger');
                return;
            }

            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Deleting...';

            fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                if (response.status === 403) {
                    throw new Error('Unauthorized – you do not have permission to delete this request.');
                }
                const contentType = response.headers.get('content-type');
                let data = null;
                let errorMessage = null;

                if (contentType && contentType.includes('application/json')) {
                    try {
                        data = await response.json();
                    } catch (e) {
                        errorMessage = 'Invalid JSON response.';
                    }
                } else {
                    const text = await response.text();
                    if (response.ok) {
                        data = { success: true, message: 'Deleted successfully.' };
                    } else {
                        errorMessage = text || 'Server returned an error.';
                    }
                }

                if (errorMessage) {
                    throw new Error(errorMessage);
                }

                if (!response.ok) {
                    const msg = data?.message || `HTTP ${response.status}`;
                    throw new Error(msg);
                }

                if (data && data.success === false) {
                    throw new Error(data.message || 'Unknown error');
                }

                return data;
            })
            .then(data => {
                showToast(data?.message || 'Damage request deleted permanently.');
                deleteModal.hide();
                setTimeout(() => window.location.reload(), 800);
            })
            .catch(error => {
                console.error('Delete error:', error);
                showToast(error.message || 'Could not delete the request.', 'danger');
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = 'Yes, Delete Permanently';
            });
        });

        // ==================== REPLY FORM ====================
        document.querySelectorAll('.reply-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Sending...';
            });
        });

        // ==================== EXPORT CSV (Modal) ====================
        const exportModal = new bootstrap.Modal(document.getElementById('exportCsvModal'));
        document.getElementById('openExportCsvModalBtn').addEventListener('click', function() {
            exportModal.show();
        });

        document.getElementById('confirmExportBtn').addEventListener('click', function() {
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Exporting...';

            exportCsv();

            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = 'Export CSV';
            }, 1000);

            exportModal.hide();
        });

        function exportCsv() {
            const table = document.getElementById('damageTable');
            const rows = table.querySelectorAll('tr');
            let csv = [];
            const headers = [];
            document.querySelectorAll('#damageTable thead th').forEach(th => headers.push(th.innerText.trim()));
            csv.push(headers.join(','));
            for (let i = 1; i < rows.length; i++) {
                const cols = rows[i].querySelectorAll('td');
                if (cols.length === 0) continue;
                let rowData = [];
                for (let c = 0; c < cols.length; c++) {
                    if (c === 8) continue; // skip actions column
                    if (c === 4) {
                        const imgLink = cols[c].querySelector('a');
                        rowData.push(imgLink ? imgLink.getAttribute('href') : 'No Image');
                    } else if (c === 5) {
                        const noteBtn = cols[c].querySelector('.view-note-btn');
                        let note = noteBtn ? noteBtn.getAttribute('data-note') : '—';
                        rowData.push(`"${note.replace(/,/g, ';')}"`);
                    } else if (c === 6) {
                        const select = cols[c].querySelector('select');
                        let val = select ? select.options[select.selectedIndex].text : cols[c].innerText;
                        rowData.push(val.trim());
                    } else {
                        let txt = cols[c].innerText.trim().replace(/,/g, ' ');
                        rowData.push(`"${txt}"`);
                    }
                }
                csv.push(rowData.join(','));
            }
            const blob = new Blob(["\uFEFF" + csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'damage_requests_export.csv';
            link.click();
            URL.revokeObjectURL(link.href);
            showToast('CSV exported');
        }

        // ==================== TOAST HELPER ====================
        function showToast(msg, type = 'success') {
            const toast = document.getElementById('successToast');
            const span = document.getElementById('toastMessage');
            if (!toast) return;
            span.innerText = msg;
            toast.style.display = 'flex';
            if (type === 'danger') {
                toast.style.background = '#DC2626';
            } else {
                toast.style.background = '#16A34A';
            }
            if (window.toastTimeout) clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(() => {
                toast.style.display = 'none';
            }, 4000);
        }
    });
</script>
@endsection
