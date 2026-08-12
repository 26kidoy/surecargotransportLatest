@extends('admin.layouts.app')

@section('title', 'SureCargo Admin | Payment Details')

@section('page-title', 'Payment Details')

@push('styles')
    <style nonce="{{ $csp_nonce }}">
/* ============================================================
   RECEIPT/ORDER DETAILS - DEEPSEEK-STYLE RESPONSIVE STYLES
   Theme: White / Teal / Brick Red
   ============================================================ */

:root {
    --teal-primary: #1A6D5E;
    --teal-light: #238b78;
    --teal-soft-bg: #E8F3F0;
    --brick-red: #B53B34;
    --brick-red-light: #c9544c;
    --brick-red-soft: #FEF3F2;
    --gray-50: #F9FAFB;
    --gray-100: #F3F4F6;
    --gray-200: #E5E7EB;
    --gray-300: #D1D5DB;
    --gray-600: #4B5563;
    --gray-800: #1F2937;
    --shadow-sm: 0 4px 10px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 8px 20px rgba(0, 0, 0, 0.05), 0 2px 4px rgba(0, 0, 0, 0.02);
    --shadow-lg: 0 20px 28px -12px rgba(0, 0, 0, 0.1);

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
   BASE & RESET
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
    background: #F8FAFC;
    color: #1A2C2A;
    line-height: 1.6;
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ============================================================
   LAYOUT
   ============================================================ */
.admin-container {
    max-width: calc(100% - 250px);
    margin: 0 250px 0 0;
    padding: var(--sp-xl) var(--sp-xxl);
}

/* ============================================================
   TYPOGRAPHY
   ============================================================ */
.page-header {
    margin-bottom: var(--sp-xxl);
}

.page-title {
    font-size: var(--font-xxl);
    font-weight: 800;
    color: #111827;
    letter-spacing: -0.02em;
    margin-bottom: var(--sp-sm);
}

.page-subtitle {
    font-size: var(--font-base);
    color: var(--gray-600);
    font-weight: 400;
}

/* ============================================================
   DETAILS CARD
   ============================================================ */
.details-card {
    background: white;
    border-radius: 28px;
    box-shadow: var(--shadow-md);
    overflow: hidden;
    border: 1px solid var(--gray-100);
    margin-bottom: var(--sp-xl);
}

.details-header {
    padding: var(--sp-xl) var(--sp-xxl);
    border-bottom: 3px solid var(--teal-primary);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--sp-md);
}

.details-header h3 {
    font-size: var(--font-lg);
    font-weight: 800;
    color: var(--gray-800);
    margin: 0;
}

.details-body {
    padding: var(--sp-xxl);
}

/* ============================================================
   INFO ROWS
   ============================================================ */
.info-row {
    display: flex;
    padding: var(--sp-md) 0;
    border-bottom: 1px solid var(--gray-200);
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    width: 200px;
    font-weight: 600;
    font-size: var(--font-base);
    color: var(--gray-800);
    letter-spacing: -0.01em;
    flex-shrink: 0;
}

.info-value {
    flex: 1;
    font-size: var(--font-base);
    font-weight: 400;
    color: #374151;
    word-break: break-word;
}

.info-value code {
    font-size: var(--font-sm);
    background: var(--gray-100);
    padding: var(--sp-xs) var(--sp-sm);
    border-radius: 12px;
    font-family: monospace;
}

/* ============================================================
   INFO GRID
   ============================================================ */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--sp-md) var(--sp-xxl);
}

@media (max-width: 640px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
}

/* ============================================================
   STATUS BADGES
   ============================================================ */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: var(--sp-sm) var(--sp-xl);
    border-radius: 48px;
    font-size: var(--font-sm);
    font-weight: 600;
    letter-spacing: 0.01em;
    width: fit-content;
    min-height: 42px;
}

.status-pending {
    background: #FEF3C7;
    color: #92400E;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.status-approve {
    background: var(--teal-soft-bg);
    color: var(--teal-primary);
    border: 1px solid rgba(26, 109, 94, 0.3);
}

.status-decline {
    background: var(--brick-red-soft);
    color: var(--brick-red);
    border: 1px solid rgba(181, 59, 52, 0.3);
}

.status-refunded {
    background: #E5E7EB;
    color: #374151;
    border: 1px solid rgba(107, 114, 128, 0.3);
}

.status-cod {
    background: #DBEAFE;
    color: #1E40AF;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

/* ============================================================
   SCREENSHOT SECTION
   ============================================================ */
.screenshot-container {
    background: var(--gray-50);
    border: 2px dashed var(--gray-300);
    border-radius: 16px;
    padding: var(--sp-xl);
    text-align: center;
    transition: all 0.3s ease;
}

.screenshot-container:hover {
    border-color: var(--teal-primary);
    background: var(--teal-soft-bg);
}

.screenshot-image {
    max-width: 100%;
    max-height: 400px;
    border-radius: 12px;
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    cursor: pointer;
    transition: transform 0.2s ease;
}

.screenshot-image:hover {
    transform: scale(1.02);
    box-shadow: var(--shadow-md);
}

.screenshot-placeholder {
    padding: var(--sp-xxl) var(--sp-xl);
    color: var(--gray-600);
}

.screenshot-placeholder i {
    font-size: 48px;
    color: var(--gray-300);
    margin-bottom: var(--sp-md);
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-green {
    background: var(--teal-primary);
    color: white;
    border: none;
    padding: var(--sp-sm) var(--sp-xl);
    border-radius: 48px;
    font-weight: 600;
    font-size: var(--font-base);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    display: inline-flex;
    align-items: center;
    gap: var(--sp-sm);
    transition: transform 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1), box-shadow 0.2s ease;
    cursor: pointer;
    text-decoration: none;
    box-shadow: var(--shadow-sm);
    min-height: 44px;
}

.btn-green:hover {
    transform: scale(1.05);
    box-shadow: var(--shadow-md);
    background: var(--teal-light);
    color: white;
}

.btn-red {
    background: white;
    color: var(--brick-red);
    border: 1.5px solid var(--brick-red);
    padding: var(--sp-sm) var(--sp-xl);
    border-radius: 48px;
    font-weight: 600;
    font-size: var(--font-base);
    transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    min-height: 44px;
}

.btn-red:hover {
    background: var(--brick-red);
    color: white;
    transform: scale(1.02);
    box-shadow: 0 4px 10px rgba(181, 59, 52, 0.2);
}

.btn-outline-secondary {
    background: white;
    color: var(--gray-600);
    border: 1.5px solid var(--gray-300);
    padding: var(--sp-sm) var(--sp-xl);
    border-radius: 48px;
    font-weight: 600;
    font-size: var(--font-base);
    transition: all 0.2s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    min-height: 44px;
}

.btn-outline-secondary:hover {
    background: var(--gray-100);
    border-color: var(--gray-400);
    transform: translateY(-1px);
}

.btn-print {
    background: #4B5563;
    color: white;
    border: none;
    padding: var(--sp-sm) var(--sp-xl);
    border-radius: 48px;
    font-weight: 600;
    font-size: var(--font-base);
    display: inline-flex;
    align-items: center;
    gap: var(--sp-sm);
    transition: all 0.2s ease;
    cursor: pointer;
    min-height: 44px;
}

.btn-print:hover {
    background: #374151;
    transform: scale(1.02);
}

/* ============================================================
   ACTION BUTTONS GROUP
   ============================================================ */
.action-buttons {
    display: flex;
    gap: var(--sp-md);
    flex-wrap: wrap;
    margin-top: var(--sp-xl);
}

/* ============================================================
   TIMELINE
   ============================================================ */
.timeline-section {
    margin-top: var(--sp-xl);
}

.timeline-title {
    font-size: var(--font-lg);
    font-weight: 800;
    color: var(--gray-800);
    margin-bottom: var(--sp-xl);
    padding-bottom: var(--sp-sm);
    border-bottom: 2px solid var(--teal-primary);
    display: inline-block;
}

.timeline {
    list-style: none;
    padding: 0;
    position: relative;
}

.timeline:before {
    content: '';
    position: absolute;
    left: 24px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--gray-200);
}

.timeline-item {
    position: relative;
    padding-left: 70px;
    margin-bottom: var(--sp-xl);
}

.timeline-badge {
    position: absolute;
    left: 12px;
    top: 0;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: white;
    border: 3px solid var(--teal-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
}

.timeline-badge i {
    font-size: var(--font-sm);
    color: var(--teal-primary);
}

.timeline-content {
    background: var(--gray-50);
    padding: var(--sp-md) var(--sp-lg);
    border-radius: 20px;
    border: 1px solid var(--gray-200);
}

.timeline-time {
    font-size: var(--font-sm);
    color: var(--gray-600);
    margin-bottom: var(--sp-xs);
    font-weight: 500;
}

.timeline-status {
    font-size: var(--font-base);
    font-weight: 700;
    color: var(--teal-primary);
    margin-bottom: 4px;
}

.timeline-note {
    font-size: var(--font-sm);
    color: var(--gray-600);
}

/* ============================================================
   PRINT STYLES
   ============================================================ */
@media print {
    body {
        background: white;
        padding: 20px;
    }

    .admin-container {
        max-width: 100%;
        margin: 0;
        padding: 0;
    }

    .action-buttons,
    .btn-print,
    .btn-green,
    .btn-red,
    .btn-outline-secondary,
    .pagination,
    nav,
    .main-header,
    .sidebar {
        display: none !important;
    }

    .details-card {
        box-shadow: none;
        border: 1px solid #ddd;
        break-inside: avoid;
    }

    .details-header {
        padding: 20px;
    }

    .details-body {
        padding: 20px;
    }

    .info-row {
        padding: 12px 0;
    }

    .status-badge {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }

    .screenshot-container {
        border: 1px solid #ddd;
        background: white;
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }

    .screenshot-image {
        max-height: 300px;
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }

    .timeline:before {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }

    .timeline-badge {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
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

    .admin-container {
        max-width: 100%;
        margin: 0;
        padding: var(--sp-xl) var(--sp-lg);
    }

    .page-title {
        font-size: var(--font-xxl);
    }

    .details-header {
        padding: var(--sp-lg) var(--sp-xl);
    }

    .details-body {
        padding: var(--sp-xl);
    }

    .info-label {
        width: 160px;
    }

    .screenshot-image {
        max-height: 300px;
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

    .admin-container {
        max-width: 100%;
        margin: 0;
        padding: var(--sp-md) var(--sp-md);
    }

    .page-title {
        font-size: var(--font-xl);
        margin-bottom: var(--sp-xs);
    }

    .page-subtitle {
        font-size: var(--font-sm);
    }

    .page-header {
        margin-bottom: var(--sp-lg);
    }

    .details-card {
        border-radius: 20px;
    }

    .details-header {
        flex-direction: column;
        align-items: flex-start;
        padding: var(--sp-md) var(--sp-lg);
    }

    .details-header h3 {
        font-size: var(--font-md);
    }

    .details-body {
        padding: var(--sp-md);
    }

    .info-row {
        flex-direction: column;
        gap: var(--sp-xs);
        padding: var(--sp-sm) 0;
    }

    .info-label {
        width: 100%;
        font-size: var(--font-sm);
    }

    .info-value {
        font-size: var(--font-sm);
    }

    .info-value code {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
    }

    .status-badge {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .btn-green,
    .btn-red,
    .btn-outline-secondary,
    .btn-print {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
    }

    .action-buttons {
        flex-direction: column;
        width: 100%;
        gap: var(--sp-sm);
        margin-top: var(--sp-md);
    }

    .action-buttons a,
    .action-buttons button {
        justify-content: center;
        width: 100%;
    }

    .screenshot-container {
        padding: var(--sp-md);
    }

    .screenshot-image {
        max-height: 250px;
    }

    .screenshot-placeholder {
        padding: var(--sp-lg) var(--sp-md);
    }

    .screenshot-placeholder i {
        font-size: 36px;
    }

    .timeline-section {
        margin-top: var(--sp-lg);
    }

    .timeline-title {
        font-size: var(--font-md);
        margin-bottom: var(--sp-md);
        padding-bottom: var(--sp-xs);
    }

    .timeline:before {
        left: 16px;
    }

    .timeline-item {
        padding-left: 50px;
        margin-bottom: var(--sp-md);
    }

    .timeline-badge {
        left: 4px;
        width: 24px;
        height: 24px;
        border-width: 2px;
    }

    .timeline-badge i {
        font-size: var(--font-xs);
    }

    .timeline-content {
        padding: var(--sp-sm) var(--sp-md);
        border-radius: 16px;
    }

    .timeline-time {
        font-size: var(--font-xs);
        margin-bottom: var(--sp-xs);
    }

    .timeline-status {
        font-size: var(--font-sm);
    }

    .timeline-note {
        font-size: var(--font-xs);
    }

    .info-grid {
        grid-template-columns: 1fr;
        gap: var(--sp-sm);
    }

    .row.g-3 {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .row.g-4 {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .col-md-6 {
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

    .admin-container {
        padding: var(--sp-sm) var(--sp-sm);
    }

    .page-title {
        font-size: var(--font-lg);
    }

    .page-subtitle {
        font-size: var(--font-xs);
    }

    .details-card {
        border-radius: 16px;
    }

    .details-header {
        padding: var(--sp-sm) var(--sp-md);
    }

    .details-header h3 {
        font-size: var(--font-sm);
    }

    .details-body {
        padding: var(--sp-sm);
    }

    .info-row {
        padding: var(--sp-xs) 0;
    }

    .info-label {
        font-size: var(--font-xs);
    }

    .info-value {
        font-size: var(--font-xs);
    }

    .info-value code {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
    }

    .status-badge {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        gap: 6px;
    }

    .btn-green,
    .btn-red,
    .btn-outline-secondary,
    .btn-print {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        gap: var(--sp-xs);
        border-radius: 40px;
    }

    .action-buttons {
        gap: var(--sp-xs);
        margin-top: var(--sp-sm);
    }

    .screenshot-container {
        padding: var(--sp-sm);
    }

    .screenshot-image {
        max-height: 200px;
    }

    .screenshot-placeholder {
        padding: var(--sp-md) var(--sp-sm);
    }

    .screenshot-placeholder i {
        font-size: 28px;
    }

    .timeline:before {
        left: 12px;
    }

    .timeline-item {
        padding-left: 40px;
        margin-bottom: var(--sp-sm);
    }

    .timeline-badge {
        left: 2px;
        width: 20px;
        height: 20px;
        border-width: 2px;
    }

    .timeline-badge i {
        font-size: 0.55rem;
    }

    .timeline-content {
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 12px;
    }

    .timeline-time {
        font-size: 0.55rem;
    }

    .timeline-status {
        font-size: var(--font-xs);
    }

    .timeline-note {
        font-size: 0.55rem;
    }

    .timeline-title {
        font-size: var(--font-sm);
        margin-bottom: var(--sp-sm);
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

    .page-title {
        font-size: var(--font-md);
    }

    .page-subtitle {
        font-size: 0.55rem;
    }

    .details-header h3 {
        font-size: var(--font-xs);
    }

    .info-label {
        font-size: 0.55rem;
    }

    .info-value {
        font-size: 0.55rem;
    }

    .status-badge {
        font-size: 0.5rem;
        min-height: 26px;
        padding: 0.05rem var(--sp-xs);
    }

    .btn-green,
    .btn-red,
    .btn-outline-secondary,
    .btn-print {
        font-size: 0.5rem;
        min-height: 30px;
        padding: 0.05rem var(--sp-xs);
    }

    .screenshot-image {
        max-height: 150px;
    }

    .screenshot-placeholder i {
        font-size: 24px;
    }

    .timeline-item {
        padding-left: 34px;
    }

    .timeline-badge {
        width: 16px;
        height: 16px;
        left: 2px;
    }

    .timeline-badge i {
        font-size: 0.45rem;
    }

    .timeline-content {
        padding: 0.1rem var(--sp-xs);
    }

    .timeline-time {
        font-size: 0.45rem;
    }

    .timeline-status {
        font-size: 0.5rem;
    }

    .timeline-note {
        font-size: 0.45rem;
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

    .page-title {
        font-size: var(--font-sm);
    }

    .details-header h3 {
        font-size: 0.6rem;
    }

    .info-label {
        font-size: 0.45rem;
    }

    .info-value {
        font-size: 0.45rem;
    }

    .status-badge {
        font-size: 0.4rem;
        min-height: 22px;
    }

    .btn-green,
    .btn-red,
    .btn-outline-secondary,
    .btn-print {
        font-size: 0.4rem;
        min-height: 26px;
    }

    .screenshot-image {
        max-height: 120px;
    }

    .timeline-item {
        padding-left: 28px;
    }

    .timeline-badge {
        width: 14px;
        height: 14px;
    }

    .timeline-badge i {
        font-size: 0.35rem;
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
<div class="details-card">
    <div class="details-header">
        <h3>
            <i class="fas fa-receipt me-2" style="color: var(--teal-primary);"></i>
            Payment Receipt
        </h3>
        <div>
            @php
                $statusClass = match($payment->status) {
                    'pending' => 'status-pending',
                    'approve' => 'status-approve',
                    'decline' => 'status-decline',
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
                    'cod' => 'Cash on Delivery',
                    default => ucfirst($payment->status)
                };
            @endphp
            <span class="status-badge {{ $statusClass }}">
                <i class="fas {{ $statusIcon }} me-2"></i>
                {{ $statusLabel }}
            </span>
        </div>
    </div>

    <div class="details-body">
        <!-- Two column grid for basic info -->
        <div class="info-grid">
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Payment ID</div>
                <div class="info-value">
                    <code>#{{ $payment->id }}</code>
                </div>
            </div>
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Reference Number</div>
                <div class="info-value">
                    <code>{{ $payment->payment_reference }}</code>
                </div>
            </div>
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Transaction ID</div>
                <div class="info-value">
                    <code>{{ $payment->transaction_id ?? 'N/A' }}</code>
                </div>
            </div>
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Payment Date</div>
                <div class="info-value">
                    <i class="fas fa-calendar-alt me-2 text-secondary"></i>
                    {{ $payment->payment_date ? $payment->payment_date->format('F d, Y') : 'N/A' }}
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="my-4" style="border-top: 2px dashed var(--gray-200);"></div>

        <!-- Amount Section - Highlighted -->
        <div class="text-center mb-4 p-4 rounded-4" style="background: var(--teal-soft-bg);">
            <span style="font-size: 18px; font-weight: 600; color: var(--gray-600);">Total Amount</span>
            <div style="font-size: 56px; font-weight: 800; color: var(--teal-primary); letter-spacing: -0.02em;">
                ₱{{ number_format($payment->amount, 2) }}
            </div>
        </div>

        <!-- User Information -->
        <h5 class="mb-3" style="font-size: 20px; font-weight: 700; color: var(--gray-800);">
            <i class="fas fa-user me-2" style="color: var(--teal-primary);"></i> Customer Information
        </h5>
        <div class="info-grid mb-4">
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Full Name</div>
                <div class="info-value">{{ $payment->user->name ?? 'N/A' }}</div>
            </div>
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Email Address</div>
                <div class="info-value">{{ $payment->user->email ?? 'N/A' }}</div>
            </div>
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Mobile Number</div>
                <div class="info-value">{{ $payment->user->mobile ?? $payment->user->mobile_number ?? 'N/A' }}</div>
            </div>
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">User ID</div>
                <div class="info-value">#{{ $payment->user->id ?? 'N/A' }}</div>
            </div>
        </div>

        <!-- Sender Information (for payment requests) -->
        @if($payment->sender_name || $payment->user_reference)
        <h5 class="mb-3 mt-4" style="font-size: 20px; font-weight: 700; color: var(--gray-800);">
            <i class="fas fa-user-check me-2" style="color: var(--teal-primary);"></i> Payment Submitter
        </h5>
        <div class="info-grid mb-4">
            @if($payment->sender_name)
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Sender Name</div>
                <div class="info-value">{{ $payment->sender_name }}</div>
            </div>
            @endif
            @if($payment->user_reference)
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">User Reference</div>
                <div class="info-value"><code>{{ $payment->user_reference }}</code></div>
            </div>
            @endif
        </div>
        @endif

        <!-- Payment Method Details -->
        <h5 class="mb-3 mt-4" style="font-size: 20px; font-weight: 700; color: var(--gray-800);">
            <i class="fas fa-credit-card me-2" style="color: var(--teal-primary);"></i> Payment Method
        </h5>
        <div class="info-grid mb-4">
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Method</div>
                <div class="info-value">
                    <i class="fas {{ $payment->payment_method_icon ?? 'fa-credit-card' }} me-2"></i>
                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                </div>
            </div>
            @if($payment->payment_method_details)
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Account Name</div>
                <div class="info-value">{{ $payment->payment_method_details['account_name'] ?? 'N/A' }}</div>
            </div>
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Reference/Account #</div>
                <div class="info-value">{{ $payment->payment_method_details['reference_number'] ?? 'N/A' }}</div>
            </div>
            @endif
        </div>

        <!-- Screenshot Evidence -->
        <h5 class="mb-3 mt-4" style="font-size: 20px; font-weight: 700; color: var(--gray-800);">
            <i class="fas fa-image me-2" style="color: var(--teal-primary);"></i> Payment Screenshot Evidence
        </h5>
        <div class="screenshot-container" id="screenshotContainer">
            @php
                $screenshotUrl = $payment->screenshot_url;
            @endphp
            @if($screenshotUrl)
                <div>
                    <img src="{{ e($screenshotUrl) }}" 
                         alt="Payment Screenshot" 
                         class="screenshot-image" 
                         id="screenshotImage"
                         data-url="{{ e($screenshotUrl) }}">
                    <div class="mt-2">
                        <small class="text-muted">Click the image to view in full size</small>
                    </div>
                </div>
            @else
                <div class="screenshot-placeholder">
                    <i class="fas fa-image"></i>
                    <p class="mb-0">No screenshot uploaded for this payment.</p>
                    @if($payment->screenshot_path)
                        <small class="text-danger">(File path: {{ $payment->screenshot_path }} - file may be missing)</small>
                    @endif
                </div>
            @endif
        </div>

        <!-- Payment Notes -->
        @if($payment->notes)
        <h5 class="mb-3 mt-4" style="font-size: 20px; font-weight: 700; color: var(--gray-800);">
            <i class="fas fa-pencil-alt me-2" style="color: var(--teal-primary);"></i> Payment Notes
        </h5>
        <div class="p-3 rounded-3 mb-4" style="background: var(--gray-50); border: 1px solid var(--gray-200);">
            <p style="font-size: 16px; margin: 0;">{{ $payment->notes }}</p>
        </div>
        @endif

        <!-- Booking Reference (if linked) -->
        @if($payment->booking_id)
        <h5 class="mb-3 mt-4" style="font-size: 20px; font-weight: 700; color: var(--gray-800);">
            <i class="fas fa-shopping-bag me-2" style="color: var(--teal-primary);"></i> Related Booking
        </h5>
        <div class="info-grid mb-4">
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Booking ID</div>
                <div class="info-value">
                    <code>#{{ $payment->booking_id }}</code>
                </div>
            </div>
            @if($payment->booking)
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Booking Reference</div>
                <div class="info-value">
                    <code>{{ $payment->booking->booking_reference ?? 'N/A' }}</code>
                </div>
            </div>
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Booking Status</div>
                <div class="info-value">
                    <span class="badge {{ $payment->booking->status == 'confirmed' ? 'bg-success' : 'bg-warning' }}">
                        {{ ucfirst($payment->booking->status ?? 'N/A') }}
                    </span>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Divider -->
        <div class="my-4" style="border-top: 2px dashed var(--gray-200);"></div>

        <!-- Created/Updated Timestamps -->
        <div class="info-grid">
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Created At</div>
                <div class="info-value">
                    <i class="fas fa-clock me-2 text-secondary"></i>
                    {{ $payment->created_at ? $payment->created_at->format('F d, Y h:i A') : 'N/A' }}
                </div>
            </div>
            <div class="info-row" style="border-bottom: none; padding: 0;">
                <div class="info-label">Last Updated</div>
                <div class="info-value">
                    <i class="fas fa-sync me-2 text-secondary"></i>
                    {{ $payment->updated_at ? $payment->updated_at->format('F d, Y h:i A') : 'N/A' }}
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn-print" id="printBtn">
                <i class="fas fa-print"></i> Print Receipt
            </button>

            @if($screenshotUrl)
            <button class="btn-green" id="viewFullScreenshotBtn">
                <i class="fas fa-expand"></i> View Full Screenshot
            </button>
            @endif

            <a href="{{ route('admin.payments.index') }}" class="btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Payments
            </a>
        </div>
    </div>
</div>

<!-- Status Timeline (if you have status history) -->
@if(isset($statusHistory) && count($statusHistory) > 0)
<div class="details-card timeline-section">
    <div class="details-header" style="border-bottom-color: var(--brick-red);">
        <h3 style="font-size: 24px;">
            <i class="fas fa-history me-2" style="color: var(--brick-red);"></i>
            Payment Status Timeline
        </h3>
    </div>
    <div class="details-body">
        <ul class="timeline">
            @foreach($statusHistory as $history)
            <li class="timeline-item">
                <div class="timeline-badge">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-time">
                        <i class="far fa-clock me-1"></i> {{ $history->created_at->format('F d, Y h:i A') }}
                    </div>
                    <div class="timeline-status">
                        Status changed to: {{ ucfirst($history->status) }}
                    </div>
                    @if($history->notes)
                    <div class="timeline-note">
                        Note: {{ $history->notes }}
                    </div>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script nonce="{{ $csp_nonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        // =========================================
        // 1. PRINT BUTTON - No inline onclick
        // =========================================
        const printBtn = document.getElementById('printBtn');
        if (printBtn) {
            printBtn.addEventListener('click', function() {
                window.print();
            });
        }

        // =========================================
        // 2. VIEW FULL SCREENSHOT - No inline onclick
        // =========================================
        const viewFullBtn = document.getElementById('viewFullScreenshotBtn');
        if (viewFullBtn) {
            viewFullBtn.addEventListener('click', function() {
                const img = document.getElementById('screenshotImage');
                if (img && img.dataset.url) {
                    window.open(img.dataset.url, '_blank');
                }
            });
        }

        // =========================================
        // 3. SCREENSHOT IMAGE CLICK - No inline onclick
        // =========================================
        const screenshotImg = document.getElementById('screenshotImage');
        if (screenshotImg) {
            screenshotImg.addEventListener('click', function() {
                const url = this.dataset.url;
                if (url) {
                    window.open(url, '_blank');
                }
            });
        }

        // =========================================
        // 4. PRINT STYLE ADJUSTMENTS
        // =========================================
        window.onbeforeprint = function() {
            document.body.style.background = 'white';
        };

        window.onafterprint = function() {
            document.body.style.background = '#F8FAFC';
        };
    });
</script>
@endpush