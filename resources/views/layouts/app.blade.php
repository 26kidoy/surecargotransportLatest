<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>SureCargo – Egg Tray Booking System</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/icon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <style nonce="{{ $csp_nonce }}">
       /* ============================================================
   GLOBAL RESET & VARIABLES – White & Blue Theme
   DEEPSEEK-STYLE FONT SIZING
   ============================================================ */
:root {
    --primary: #1e88e5;
    --primary-dark: #0b5ed7;
    --primary-light: #e3f2fd;
    --secondary: #42a5f5;
    --success-green: #2e7d32;
    --success-light: #e8f5e9;
    --white: #ffffff;
    --gray-100: #f8fafc;
    --gray-200: #f1f5f9;
    --gray-300: #e2e8f0;
    --text-dark: #1e293b;
    --text-muted: #64748b;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.06), 0 2px 8px rgba(0,0,0,0.04);
    --shadow-lg: 0 8px 30px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.04);
    --shadow-xl: 0 20px 40px -12px rgba(0,0,0,0.12);
    --sidebar-width: 290px;
    --transition-bounce: cubic-bezier(0.34, 1.2, 0.64, 1);
    --touch-min: 44px;
    --radius-card: 1.25rem;
    --radius-btn: 3rem;
    --radius-modal: 1.5rem;

    /* DEEPSEEK-STYLE FONT SIZES - Clean, readable, consistent */
    --font-xs: 0.75rem;
    --font-sm: 0.875rem;
    --font-base: 1rem;
    --font-md: 1.125rem;
    --font-lg: 1.25rem;
    --font-xl: 1.5rem;
    --font-xxl: 1.75rem;
    --font-xxxl: 2.25rem;
}

[data-theme="dark"] {
    --primary: #3b82f6;
    --primary-dark: #2563eb;
    --primary-light: #1e293b;
    --white: #0f172a;
    --gray-100: #1e293b;
    --gray-200: #0f172a;
    --gray-300: #334155;
    --text-dark: #f1f5f9;
    --text-muted: #94a3b8;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.3);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.35);
    --shadow-lg: 0 8px 30px rgba(0,0,0,0.4);
    --success-light: #1b2e1f;
    --success-green: #4caf50;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

body {
    background: var(--gray-100);
    color: var(--text-dark);
    transition: background 0.25s ease, color 0.2s ease;
    font-size: var(--font-base);
    font-weight: 400;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    overflow-x: hidden;
}

/* ---- Typography ---- */
h1, h2, h3, h4, h5, h6, .fw-bold {
    font-weight: 700;
    letter-spacing: -0.02em;
    line-height: 1.2;
}

h1 { font-size: var(--font-xxxl); }
h2 { font-size: var(--font-xxl); }
h3 { font-size: var(--font-xl); }
h4 { font-size: var(--font-lg); }
h5 { font-size: var(--font-md); }
h6 { font-size: var(--font-base); }

p, span, div, a, button, input, label, .modal-content, .truck-card, .filter-chip {
    font-weight: 400;
    font-size: var(--font-base);
}

small, .text-muted, .small-text {
    font-size: var(--font-sm);
    font-weight: 400;
}

/* ---- Scrollbar ---- */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: var(--gray-200); }
::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 6px; }

/* ============================================================
   SIDEBAR – all items flex-start left-aligned
   ============================================================ */
.sidebar-3d {
    position: fixed;
    top: 0;
    left: 0;
    width: var(--sidebar-width);
    height: 100vh;
    background: var(--white);
    border-right: 1px solid var(--gray-300);
    z-index: 1050;
    transform: translateX(-100%);
    transition: transform 0.35s var(--transition-bounce);
    box-shadow: 0 0 30px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}
.sidebar-3d.open {
    transform: translateX(0);
    box-shadow: 8px 0 40px rgba(0,0,0,0.08);
}
.sidebar-header-3d {
    padding: 1.8rem 1.5rem;
    border-bottom: 1px solid var(--gray-300);
    background: var(--white);
}
.brand-icon {
    width: 44px;
    height: 44px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.08));
}
.gradient-text {
    background: linear-gradient(115deg, var(--primary), var(--secondary));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.nav-3d {
    padding: 1.5rem 1rem;
    flex: 1;
}
.nav-3d ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: stretch;
}
.nav-item-3d {
    list-style: none;
}
.nav-link-3d {
    display: flex;
    align-items: center !important;
    justify-content: flex-start !important;
    gap: 1rem;
    padding: 0.75rem 1.2rem;
    border-radius: 1.25rem;
    font-weight: 500;
    font-size: var(--font-base);
    color: var(--text-dark);
    text-decoration: none;
    transition: all 0.2s ease;
    background: var(--white);
    border: 1px solid transparent;
    min-height: var(--touch-min);
    width: 100%;
    text-align: left;
}
.nav-link-3d svg {
    width: 24px;
    height: 24px;
    stroke: var(--primary);
    stroke-width: 1.8;
    fill: none;
    flex-shrink: 0;
}
.nav-link-3d:hover,
.nav-link-3d.active {
    background: var(--primary-light);
    color: var(--primary-dark);
    border-color: var(--primary);
    transform: translateX(6px) scale(1.02);
    box-shadow: var(--shadow-sm);
}
.nav-link-3d:hover svg,
.nav-link-3d.active svg {
    stroke: var(--primary-dark);
}

.sidebar-footer-3d {
    padding: 1rem;
    border-top: 1px solid var(--gray-300);
    margin-top: auto;
}
.btn-logout-sidebar {
    background: #e63946;
    border: none;
    border-radius: var(--radius-btn);
    padding: 0.6rem 1.2rem;
    font-weight: 600;
    font-size: var(--font-base);
    color: white;
    transition: all 0.2s;
    min-height: var(--touch-min);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
.btn-logout-sidebar:hover {
    background: #c92a2a;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(201,42,42,0.25);
}
.btn-logout-sidebar svg {
    width: 18px;
    height: 18px;
    stroke: white;
    stroke-width: 2;
    fill: none;
}

.theme-toggle-btn {
    cursor: pointer;
    background: var(--gray-200);
    padding: 0.6rem 1rem;
    border-radius: var(--radius-btn);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: var(--font-base);
    transition: all 0.2s;
    min-height: var(--touch-min);
}
.theme-toggle-btn:hover {
    background: var(--gray-300);
}

.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.35);
    backdrop-filter: blur(2px);
    z-index: 1040;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}
.sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* ============================================================
   THREE-DOTS BUTTON
   ============================================================ */
.three-dots-btn {
    position: fixed;
    top: 18px;
    left: 18px;
    width: 52px;
    height: 52px;
    background: var(--white);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 1060;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--gray-300);
    transition: all 0.2s;
    min-height: var(--touch-min);
    min-width: var(--touch-min);
}
.three-dots-btn i {
    font-size: var(--font-xl);
    color: var(--primary);
}
.three-dots-btn:hover {
    transform: scale(1.05);
    box-shadow: var(--shadow-lg);
}

/* ============================================================
   MAIN CONTENT – allow dropdown overflow
   ============================================================ */
.main-content-3d {
    margin-left: 0;
    transition: margin 0.3s;
    padding: 0 1.2rem 1.5rem 1.2rem;
}

.glass-header {
    background: var(--white);
    border-radius: 1.25rem;
    padding: 1rem 1.5rem;
    margin: 1rem 0 2rem 0;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-300);
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 0.8rem;
    padding-left: 80px;
    position: relative;
    z-index: 10;
}
.page-title {
    font-size: var(--font-xl);
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
    color: var(--text-dark);
    letter-spacing: -0.02em;
}

/* ---- User Dropdown ---- */
.dropdown {
    position: relative;
    z-index: 9999999 !important;
}
.user-dropdown-btn {
    background: var(--white);
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-btn);
    padding: 0.4rem 1rem 0.4rem 0.4rem;
    font-size: var(--font-base);
    display: flex;
    align-items: center;
    gap: 0.6rem;
    transition: all 0.2s;
    min-height: var(--touch-min);
}
.user-dropdown-btn:hover {
    background: var(--gray-200);
}
.header-avatar {
    width: 36px;
    height: 36px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid var(--primary);
}
.dropdown-menu {
    z-index: 9999999 !important;
    font-size: var(--font-base);
    border: 1px solid var(--gray-300);
    border-radius: 1rem;
    box-shadow: var(--shadow-lg);
    padding: 0.5rem;
    background: var(--white);
    min-width: 200px;
}
.dropdown-item {
    font-size: var(--font-base);
    min-height: var(--touch-min);
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-align: left;
}
.dropdown-item:hover {
    background: var(--gray-200);
}

/* ---- Notification Bell ---- */
.notification-bell {
    position: relative;
    cursor: pointer;
    background: var(--white);
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-btn);
    padding: 0.5rem 1rem;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-height: var(--touch-min);
    min-width: var(--touch-min);
}
.notification-bell:hover {
    background: var(--gray-200);
    transform: scale(1.02);
}
.notification-bell i {
    font-size: var(--font-lg);
    color: var(--primary);
}
.notification-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: #e63946;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: var(--font-xs);
    font-weight: 700;
    min-width: 18px;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* ============================================================
   NOTIFICATION MODAL
   ============================================================ */
.notification-modal .modal-dialog {
    max-width: 600px;
    margin: 1.75rem auto;
}
.notification-modal .modal-content {
    border-radius: var(--radius-modal);
    background: var(--white);
    max-height: 80vh;
    display: flex;
    flex-direction: column;
    border: none;
    box-shadow: var(--shadow-xl);
}
.notification-modal .modal-header {
    background: var(--primary);
    color: white;
    padding: 1rem 1.5rem;
    border: none;
    border-radius: var(--radius-modal) var(--radius-modal) 0 0;
    flex-shrink: 0;
}
.notification-modal .modal-title {
    font-size: var(--font-lg);
    font-weight: 700;
    color: white;
}
.btn-close-white {
    filter: brightness(0) invert(1);
}
.notification-modal .modal-body {
    padding: 0;
    flex: 1;
    overflow-y: auto;
}
.notification-list-modal {
    max-height: 60vh;
    overflow-y: auto;
}
.notification-item-modal {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gray-300);
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
}
.notification-item-modal:hover {
    background: var(--gray-200);
}
.notification-item-modal.unread {
    background: rgba(30,136,229,0.06);
}
[data-theme="dark"] .notification-item-modal.unread {
    background: rgba(59,130,246,0.12);
}
.notification-item-modal.unread::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: var(--primary);
}
.notification-icon-modal {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-light);
    flex-shrink: 0;
}
.notification-icon-modal i {
    font-size: var(--font-md);
    color: var(--primary);
}
.notification-title-modal {
    font-weight: 600;
    font-size: var(--font-base);
    margin-bottom: 0.25rem;
}
.notification-message-modal {
    font-size: var(--font-sm);
    color: var(--text-muted);
}
.notification-time-modal {
    font-size: var(--font-xs);
    color: var(--text-muted);
}
.empty-notifications-modal {
    padding: 3rem 2rem;
    text-align: center;
    color: var(--text-muted);
}
.empty-notifications-modal i {
    font-size: var(--font-xxl);
    margin-bottom: 1rem;
    opacity: 0.5;
}
.btn-clear-all {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    font-size: var(--font-sm);
    padding: 0.4rem 1rem;
    border-radius: var(--radius-btn);
    cursor: pointer;
    transition: all 0.2s;
    min-height: var(--touch-min);
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}
.btn-clear-all:hover {
    background: rgba(255,255,255,0.3);
    transform: scale(1.02);
}

/* ============================================================
   CONFIRM MODAL
   ============================================================ */
.confirm-modal .modal-dialog { max-width: 420px; }
.confirm-modal .modal-content {
    border-radius: var(--radius-modal);
    background: var(--white);
    border: none;
    box-shadow: var(--shadow-xl);
}
.confirm-modal .modal-header {
    border-bottom: 1px solid var(--gray-300);
    padding: 1rem 1.25rem;
    background: transparent;
    border-radius: var(--radius-modal) var(--radius-modal) 0 0;
}
.confirm-modal .modal-title {
    color: var(--text-dark);
}
.confirm-modal .modal-body {
    padding: 1.25rem;
    font-size: var(--font-base);
}
.confirm-modal .modal-footer {
    padding: 0.75rem 1.25rem;
    border-top: 1px solid var(--gray-300);
}
.btn-confirm-danger {
    background: #e63946;
    border: none;
    padding: 0.5rem 1.25rem;
    border-radius: var(--radius-btn);
    font-weight: 600;
    font-size: var(--font-base);
    color: white;
    transition: all 0.2s;
    min-height: var(--touch-min);
}
.btn-confirm-danger:hover {
    background: #c92a2a;
    transform: translateY(-1px);
}
.btn-confirm-secondary {
    background: var(--gray-300);
    border: none;
    padding: 0.5rem 1.25rem;
    border-radius: var(--radius-btn);
    font-weight: 600;
    font-size: var(--font-base);
    color: var(--text-dark);
    transition: all 0.2s;
    min-height: var(--touch-min);
}
.btn-confirm-secondary:hover {
    background: var(--gray-200);
}

/* ============================================================
   TRUCK CARDS – NEW LAYOUT
   ============================================================ */
.truck-card {
    border: none;
    border-radius: var(--radius-card);
    background: var(--white);
    transition: all 0.3s var(--transition-bounce);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-300);
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.truck-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}
.truck-card.selected {
    border: 3px solid var(--primary);
    box-shadow: 0 0 0 4px rgba(30,136,229,0.15), var(--shadow-lg);
}
.truck-card.selected::before {
    content: '✓';
    position: absolute;
    top: 12px;
    right: 16px;
    background: var(--primary);
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: var(--font-md);
    z-index: 12;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

/* Square image */
.truck-image-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    background: var(--gray-200);
    overflow: hidden;
    flex-shrink: 0;
}
.truck-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}
.truck-card:hover .truck-image {
    transform: scale(1.02);
}

/* Summary area below image */
.truck-summary {
    padding: 0.8rem 1rem 0.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}
.truck-summary .truck-name {
    font-size: var(--font-md);
    font-weight: 600;
    margin: 0;
    line-height: 1.2;
    color: var(--text-dark);
}
.truck-summary .truck-number {
    font-size: var(--font-sm);
    color: var(--text-muted);
}
.truck-summary .status-badge {
    align-self: flex-start;
    font-weight: 600;
    padding: 0.2rem 0.8rem;
    border-radius: 2rem;
    font-size: var(--font-xs);
    display: inline-block;
    margin: 0.2rem 0;
}
.status-available {
    background: var(--success-light);
    color: var(--success-green);
    border-left: 4px solid var(--success-green);
}
.status-booked {
    background: #fff1e0;
    color: #b45309;
    border-left: 4px solid #b45309;
}
.status-maintenance {
    background: #ffe6e5;
    color: #b91c1c;
    border-left: 4px solid #b91c1c;
}
[data-theme="dark"] .status-available {
    background: #1b2e1f;
    color: #6fbf6f;
}
[data-theme="dark"] .status-booked {
    background: #332411;
    color: #f5a623;
}
[data-theme="dark"] .status-maintenance {
    background: #2c1818;
    color: #f87171;
}

/* See Details button */
.truck-detail-btn-wrapper {
    padding: 0 1rem 1rem;
    margin-top: auto;
}
.truck-detail-btn {
    background: var(--primary);
    border: none;
    width: 100%;
    padding: 0.6rem 0;
    border-radius: var(--radius-btn);
    font-weight: 600;
    font-size: var(--font-base);
    color: white;
    transition: all 0.2s;
    min-height: var(--touch-min);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    box-shadow: 0 4px 12px rgba(30,136,229,0.25);
    cursor: pointer;
}
.truck-detail-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(30,136,229,0.35);
}

/* ============================================================
   FILTER CHIPS
   ============================================================ */
.filter-chip-group {
    display: flex;
    flex-wrap: nowrap;
    gap: 0.75rem;
    overflow-x: auto;
    padding: 0.25rem 0.125rem;
    -webkit-overflow-scrolling: touch;
    justify-content: center;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.filter-chip-group::-webkit-scrollbar {
    display: none;
}

@media (max-width: 480px) {
    .filter-chip-group {
        gap: 0.5rem;
        justify-content: flex-start;
    }
    .three-dots-btn {
        width: 44px !important;
        height: 44px !important;
        top: 16px !important;
        left: 8px !important;
        padding: 2px !important;
    }
}

.filter-chip {
    background: var(--white);
    border: 1px solid var(--gray-300);
    padding: 0.5rem 1.2rem;
    border-radius: 40px;
    font-weight: 500;
    font-size: var(--font-sm);
    transition: all 0.2s;
    color: var(--text-dark);
    white-space: nowrap;
    min-height: var(--touch-min);
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    flex-shrink: 0;
}
.filter-chip:hover {
    background: var(--gray-200);
}
.filter-chip.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    box-shadow: 0 4px 12px rgba(30,136,229,0.35);
    transform: scale(1.02);
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-primary-3d {
    background: var(--primary);
    border: none;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    font-size: var(--font-base);
    border-radius: var(--radius-btn);
    transition: all 0.2s;
    min-height: var(--touch-min);
    color: white;
}
.btn-primary-3d:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(30,136,229,0.35);
    color: white;
}
.btn-book-confirm {
    background: var(--primary);
    border: none;
    width: 100%;
    padding: 0.7rem;
    border-radius: var(--radius-btn);
    font-weight: 700;
    font-size: var(--font-lg);
    color: white;
    transition: all 0.2s;
    min-height: var(--touch-min);
}
.btn-book-confirm:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(30,136,229,0.35);
    color: white;
}
.btn-book-confirm:disabled {
    opacity: 0.6;
    transform: none;
}

/* ============================================================
   MODALS (General)
   ============================================================ */
.modal-content {
    border-radius: var(--radius-modal);
    background: var(--white);
    border: 1px solid var(--gray-300);
    box-shadow: var(--shadow-xl);
}
.modal-header {
    background: var(--primary);
    border-radius: var(--radius-modal) var(--radius-modal) 0 0;
    border: none;
    padding: 1rem 1.5rem;
}
.modal-title {
    font-size: var(--font-lg);
    font-weight: 700;
    color: white;
}
.modal-body {
    padding: 1.5rem;
    font-size: var(--font-base);
}
.modal-body .form-label {
    font-size: var(--font-base);
    font-weight: 500;
    margin-bottom: 0.4rem;
}
.modal-body .form-control {
    font-size: var(--font-base);
    padding: 0.6rem 0.8rem;
    background: var(--white);
    border: 1px solid var(--gray-300);
    border-radius: 0.75rem;
    color: var(--text-dark);
    min-height: var(--touch-min);
}
.modal-body .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(30,136,229,0.15);
}

#bookingModal .modal-dialog {
    max-height: 97vh;
    margin: 1rem auto;
}
#bookingModal .modal-content {
    max-height: 97vh;
    display: flex;
    flex-direction: column;
}
#bookingModal .modal-body {
    overflow-y: auto;
    flex: 1;
}
#bookingModal .modal-header,
#bookingModal .modal-footer {
    flex-shrink: 0;
}

/* ============================================================
   TOAST
   ============================================================ */
.toast-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1100;
    font-size: var(--font-base);
    font-weight: 400;
    min-width: 260px;
    box-shadow: var(--shadow-lg);
    border-radius: 1rem;
    padding: 0.8rem 1.2rem;
    background: var(--white);
    border-left: 5px solid var(--primary);
    color: var(--text-dark);
}

/* ============================================================
   RESPONSIVE — PHONE-FIRST (DeepSeek Style)
   ============================================================ */

/* --- Base mobile (≤ 768px) --- */
@media (max-width: 768px) {
    :root {
        --font-xs: 0.7rem;
        --font-sm: 0.8rem;
        --font-base: 0.9rem;
        --font-md: 1rem;
        --font-lg: 1.1rem;
        --font-xl: 1.25rem;
        --font-xxl: 1.4rem;
        --font-xxxl: 1.8rem;
    }

    .main-content-3d {
        padding: 0 0.8rem 1rem 0.8rem;
    }
    .glass-header {
        padding: 0.8rem 1rem;
        padding-left: 70px;
        margin: 0.5rem 0 1.5rem 0;
        border-radius: 1rem;
    }
    .page-title {
        font-size: var(--font-lg);
    }
    .three-dots-btn {
        width: 46px;
        height: 46px;
        top: 16px;
        left: 10px;
    }
    .three-dots-btn i {
        font-size: var(--font-lg);
    }

    .truck-card {
        border-radius: 1.25rem;
        width: 98%;
        margin: 0 auto 1.5rem auto;
        margin-top: -20px;
    }
    .truck-summary .truck-name {
        font-size: var(--font-base);
    }
    .truck-detail-btn {
        font-size: var(--font-sm);
        padding: 0.5rem 0;
    }
    .filter-chip {
        font-size: var(--font-sm);
        padding: 0.4rem 1rem;
    }

    .notification-modal .modal-dialog {
        margin: 0.5rem;
        max-width: 98%;
    }
    .confirm-modal .modal-dialog {
        max-width: 98%;
        margin: 0.5rem;
    }
    #bookingModal .modal-dialog {
        max-width: 98%;
        margin: 0.5rem auto;
    }
    .modal-body {
        padding: 1rem;
    }
    .btn-book-confirm {
        font-size: var(--font-md);
        padding: 0.6rem;
    }
    .filter-chip {
        margin-top: -5px;
    }
}

/* --- Small phones (≤ 480px) --- */
@media (max-width: 480px) {
    :root {
        --font-xs: 0.65rem;
        --font-sm: 0.75rem;
        --font-base: 0.85rem;
        --font-md: 0.95rem;
        --font-lg: 1.05rem;
        --font-xl: 1.15rem;
        --font-xxl: 1.3rem;
        --font-xxxl: 1.6rem;
    }

    .main-content-3d {
        padding: 0 0.4rem 0.8rem 0.4rem;
    }
    .glass-header {
        padding: 0.5rem 0.6rem;
        padding-left: 55px;
        gap: 0.4rem;
    }
    .page-title {
        font-size: var(--font-md);
    }
    .three-dots-btn {
        width: 40px;
        height: 40px;
        top: 12px;
        left: 8px;
    }
    .three-dots-btn i {
        font-size: var(--font-base);
    }

    .truck-summary .truck-name {
        font-size: var(--font-sm);
    }
    .truck-summary .truck-number {
        font-size: var(--font-xs);
    }
    .truck-detail-btn {
        font-size: var(--font-xs);
        padding: 0.4rem 0;
    }
    .filter-chip {
        font-size: var(--font-xs);
        padding: 0.3rem 0.8rem;
    }
    .status-badge {
        font-size: var(--font-xs);
    }
    .btn-primary-3d {
        font-size: var(--font-sm);
        padding: 0.4rem 1rem;
    }
    .modal-title {
        font-size: var(--font-md);
    }
    .modal-body .form-label,
    .modal-body .form-control {
        font-size: var(--font-sm);
    }
    .toast-notification {
        font-size: var(--font-sm);
        min-width: 180px;
        padding: 0.5rem 1rem;
    }
    .notification-bell {
        padding: 0.3rem 0.8rem;
    }
    .user-dropdown-btn span {
        display: none;
    }
    .user-dropdown-btn {
        padding: 0.3rem 0.6rem;
    }
}

/* --- Extra small (≤ 400px) --- */
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
    }

    .glass-header {
        padding-left: 45px;
        padding: 0.4rem 0.6rem;
    }
    .three-dots-btn {
        width: 20px;
        height: 20px;
        top: 8px;
        left: 6px;

    }
    .three-dots-btn i {
        font-size: var(--font-sm);
    }
    .truck-summary .truck-name {
        font-size: var(--font-xs);
    }
    .filter-chip {
        font-size: var(--font-xs);
        padding: 0.25rem 0.6rem;
    }
    .page-title {
        font-size: var(--font-base);
    }
    .btn-book-confirm {
        font-size: var(--font-base);
        padding: 0.5rem;
    }
    .modal-body .form-label,
    .modal-body .form-control {
        font-size: var(--font-xs);
    }
    .modal-title {
        font-size: var(--font-base);
    }
}

/* --- Touch targets override for all interactive --- */
.btn,
.nav-link-3d,
.user-dropdown-btn,
.notification-bell,
.three-dots-btn,
.filter-chip,
.truck-detail-btn,
.btn-clear-all,
.btn-confirm-danger,
.btn-confirm-secondary,
.btn-book-confirm,
.btn-primary-3d,
.dropdown-item,
.btn-close {
    min-height: var(--touch-min);
    min-width: var(--touch-min);
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.dropdown-item {
    justify-content: flex-start;
}

/* --- Dashboard specific overrides --- */
.dashboard-container {
    padding: 0 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    min-height: 100vh;
    text-align: center;
}
.hero-section {
    margin-top: 0.5rem;
}
.dashboard-title {
    font-size: var(--font-xxxl);
    font-weight: 800;
    background: linear-gradient(115deg, var(--primary), var(--secondary));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}
.dashboard-subtitle {
    font-size: var(--font-lg);
    color: var(--text-muted);
    font-weight: 400;
    max-width: 90%;
    margin-left: auto;
    margin-right: auto;
}
.filter-wrapper {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    padding-bottom: 0.5rem;
    display: flex;
    justify-content: center;
}
.filter-scroll {
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: min-content;
}
.filter-chip-group {
    display: flex;
    flex-wrap: nowrap;
    gap: 0.75rem;
    padding: 0.25rem 0.125rem;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.filter-chip-group::-webkit-scrollbar {
    display: none;
}
@media (max-width: 480px) {
    .filter-chip-group {
        gap: 0.5rem;
        justify-content: flex-start;
    }
    .filter-chip {
        padding: 0.4rem 0.9rem;
        font-size: 0.85rem;
        white-space: nowrap;
    }
}
.loading-spinner i {
    font-size: 2.5rem;
}
@media (min-width: 576px) {
    .row > .col-md-6 {
        width: 50%;
    }
}
@media (min-width: 992px) {
    .row > .col-xl-4 {
        width: 33.333%;
    }
}
.truck-card {
    margin-bottom: 0;
    height: 100%;
}
.trucks-grid-wrapper {
    margin-top: 0;
}
@media (max-width: 576px) {
    .dashboard-container {
        padding: 0 0.75rem;
    }
    .hero-section {
        margin-bottom: 1rem;
    }
    .filter-wrapper {
        margin-bottom: 1rem !important;
    }
}
@media (max-width: 400px) {
    .dashboard-container {
        padding: 0 0.5rem;
    }
    .filter-chip {
        font-size: 0.75rem;
        padding: 0.3rem 0.7rem;
    }
    .filter-chip-group {
        gap: 0.4rem;
    }
    .dashboard-subtitle {
        font-size: 0.9rem;
    }
    .page-title {
        font-size: 0.8rem;
        margin-left:40px;
    }
}

/* ---- Shake animation ---- */
@keyframes customShakeEvery3s {
    0%, 85% { transform: translateX(0); }
    90% { transform: translateX(-6px); }
    93% { transform: translateX(6px); }
    96% { transform: translateX(-3px); }
    100% { transform: translateX(0); }
}
.shake-every-3s {
    animation: customShakeEvery3s 3s infinite ease-in-out !important;
    transform-origin: center !important;
}

/* Guidelines modal */
.guidelines-modal .modal-content {
    border-radius: var(--radius-modal);
}
.guidelines-list {
    list-style: none;
    padding-left: 0;
}
.guidelines-list li {
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--gray-300);
    font-size: var(--font-base);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.guidelines-list li:last-child {
    border-bottom: none;
}
.guidelines-list i {
    width: 28px;
    color: var(--primary);
}

/* Fixed action icons */
.icon-circle {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    background: var(--white) !important;
    border-radius: 50% !important;
    box-shadow: var(--shadow-md) !important;
    border: 1px solid var(--gray-300) !important;
    transition: all 0.2s ease !important;
    cursor: pointer !important;
    width: 56px !important;
    height: 56px !important;
}
.icon-circle svg {
    width: 30px !important;
    height: 30px !important;
    fill: var(--primary);
}
.icon-circle:hover {
    transform: scale(1.05) !important;
    background: var(--gray-200) !important;
    box-shadow: var(--shadow-lg) !important;
}
@media (max-width: 480px) {
    .icon-circle {
        width: 48px !important;
        height: 48px !important;
    }
    .icon-circle svg {
        width: 26px !important;
        height: 26px !important;
    }
}

/* ===== HIDDEN AUDIO (click only) ===== */
#clickAudio {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
    user-select: none;
}
    </style>
      @stack('styles')
</head>
<body>
    <!-- ===== HIDDEN CLICK AUDIO ELEMENT ===== -->
    <audio id="clickAudio" src="{{ asset('audio/click.mp3') }}" preload="auto"></audio>

    <div id="toast-container"></div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar-3d" id="mainSidebar">
        <div class="sidebar-header-3d">
            <div class="d-flex align-items-center gap-3">
                <svg class="brand-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 3H4C2.9 3 2 3.9 2 5V17H4C4 18.66 5.34 20 7 20C8.66 20 10 18.66 10 17H14C14 18.66 15.34 20 17 20C18.66 20 20 18.66 20 17H22V11L18 3H16Z" stroke="url(#brandGrad)" stroke-width="1.8" fill="none" />
                    <path d="M16 3V11H22" stroke="url(#brandGrad)" stroke-width="1.8" fill="none" />
                    <circle cx="7" cy="17" r="2" stroke="url(#brandGrad)" stroke-width="1.5" fill="none" />
                    <circle cx="17" cy="17" r="2" stroke="url(#brandGrad)" stroke-width="1.5" fill="none" />
                    <defs>
                        <linearGradient id="brandGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#1e88e5" />
                            <stop offset="100%" stop-color="#42a5f5" />
                        </linearGradient>
                    </defs>
                </svg>
                <h2 class="fw-bold mb-0 gradient-text">SureCargo</h2>
            </div>
        </div>
        <div class="nav-3d">
            <ul class="nav flex-column">
                <li class="nav-item-3d">
                    <a href="{{ route('user.dashboard') }}" class="nav-link-3d" data-page="dashboard">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z" stroke="currentColor" stroke-width="1.8" fill="none" />
                            <path d="M12 8V12L15 15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <circle cx="12" cy="12" r="2" fill="currentColor" stroke="none" />
                            <path d="M4 4L8 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <path d="M20 4L16 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <path d="M20 12H18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <path d="M6 12H4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item-3d">
                    <a href="{{ route('user.bookings') }}" class="nav-link-3d" data-page="bookings">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="1.8" fill="none" />
                            <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <polyline points="16 14 11 19 8 16" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>My Bookings</span>
                    </a>
                </li>
                <li class="nav-item-3d">
                    <a href="{{ route('messages.index') }}" class="nav-link-3d" data-page="messages">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 11.5C21 16.194 17.194 20 12.5 20C11.204 20 9.983 19.711 8.879 19.19L3 21L4.81 15.121C4.289 14.017 4 12.796 4 11.5C4 6.806 7.806 3 12.5 3C17.194 3 21 6.806 21 11.5Z" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linejoin="round" />
                            <line x1="8" y1="11" x2="16" y2="11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <line x1="11" y1="15" x2="13" y2="15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                        <span>Messages</span>
                    </a>
                </li>
                <li class="nav-item-3d">
                    <a href="{{ route('profile.index') }}" class="nav-link-3d" data-page="profile">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.8" fill="none" />
                            <path d="M5 20V19C5 15.134 8.134 12 12 12C15.866 12 19 15.134 19 19V20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none" />
                        </svg>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="nav-item-3d">
                    <a href="{{ route('damage-requests.index') }}" class="nav-link-3d" data-page="damage-requests">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C8 6 6 10 6 14C6 17.314 8.686 20 12 20C15.314 20 18 17.314 18 14C18 10 16 6 12 2Z" stroke="currentColor" stroke-width="1.8" fill="none" />
                            <path d="M14 10L10 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <path d="M10 10L14 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <circle cx="12" cy="12" r="1.5" fill="currentColor" stroke="none" />
                        </svg>
                        <span>Damage Request</span>
                    </a>
                </li>
                <li class="nav-item-3d">
                    <a href="{{ route('announcements.index') }}" class="nav-link-3d" data-page="announcements">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C8 6 6 10 6 14c0 3.314 2.686 6 6 6s6-2.686 6-6c0-4-2-8-6-12z" stroke="currentColor" stroke-width="1.8" fill="none"/>
                            <path d="M12 10v4M12 14v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"/>
                        </svg>
                        <span>Announcements</span>
                    </a>
                </li>
                <li class="nav-item-3d">
                    <a href="{{ route('track-validate.index') }}" class="nav-link-3d" data-page="track-validate">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="currentColor" stroke-width="1.8" fill="none" />
                            <path d="M12 22V12M3.3 7L12 12l8.7-5" stroke="currentColor" stroke-width="1.8" />
                            <circle cx="18" cy="18" r="2" stroke="currentColor" stroke-width="1.8" fill="none" />
                            <path d="M18 16V14M18 22V20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                        <span>Track Validate</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- ===== 3-DOTS BUTTON ===== -->
    <div class="three-dots-btn" id="threeDotsBtn" aria-label="Toggle sidebar">
        <i class="fas fa-ellipsis-h"></i>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content-3d" id="mainContent">
        <div class="glass-header">
            <div>
                <h3 class="page-title" id="pageTitle">Dashboard</h3>
            </div>
            <div class="d-flex gap-3 align-items-center flex-wrap">
                <div class="position-relative" id="notificationWrapper">
                    <button class="notification-bell" id="notificationBellBtn" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                        <span id="notificationBadge" class="notification-badge" style="display: none;">0</span>
                    </button>
                </div>

                <div class="dropdown">
                    <button class="user-dropdown-btn dropdown-toggle" data-bs-toggle="dropdown" aria-label="User menu">
                        @php
                            $fullName = (Auth::user()->first_name ?? '') . ' ' . (Auth::user()->last_name ?? '');
                            $fullName = trim($fullName);
                            $defaultAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($fullName) . '&background=0D8F81&color=fff&size=64&bold=true';
                            $profileImage = Auth::user()->profile_image_url ?: $defaultAvatar;
                        @endphp
                        <img id="headerProfileImage"
                             src="{{ $profileImage }}"
                             class="header-avatar"
                             alt="Profile"
                             onerror="this.onerror=null; this.src='{{ $defaultAvatar }}';" />
                        <span>{{ $fullName ?: 'User' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item text-danger" href="#" id="logoutBtn"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="mainContentArea" class="page-content">
            @yield('content')
        </div>
    </div>

    <!-- ===== NOTIFICATION MODAL ===== -->
    <div class="modal fade notification-modal" id="notificationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-bell me-2"></i>Notifications
                    </h5>
                    <!-- Action buttons group -->
                    <div class="d-flex gap-2 align-items-center">
                        <button class="btn-clear-all" id="markAllReadBtn">
                            <i class="fas fa-check-double me-1"></i>
                        </button>
                        <button class="btn-clear-all" id="clearAllNotificationsBtn">
                            <i class="fas fa-trash-alt me-1"></i>
                        </button>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="notification-list-modal" id="notificationListModal">
                        <div class="empty-notifications-modal">
                            <i class="fas fa-bell-slash"></i>
                            <p>No notifications yet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== CLEAR ALL CONFIRMATION ===== -->
    <div class="modal fade confirm-modal" id="clearAllConfirmModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2" style="color: #e63946;"></i>Clear All Notifications
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to clear <strong>ALL</strong> notifications? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-confirm-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-confirm-danger" id="confirmClearAllBtn">
                        <i class="fas fa-trash-alt me-1"></i> Clear All
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== BOOKING MODAL ===== -->
    <div class="modal fade" id="bookingModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-truck me-2"></i>
                        Book Egg Trays – <span id="modalTruckName">Loading...</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <div class="d-flex justify-content-between">
                                    <span> Available Egg Trays:</span>
                                    <strong id="modalAvailableTrays" class="fs-3">0</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-secondary">
                                <div class="d-flex justify-content-between">
                                    <span> Capacity Used:</span>
                                    <strong id="modalPercentageUsed" class="fs-5">0%</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="row">
                            <div class="col-md-6"><small>Driver: <strong id="modalDriverName">-</strong></small></div>
                            <div class="col-md-6"><small>Contact: <strong id="modalDriverPhone">-</strong></small></div>
                            <div class="col-md-6"><small>Model: <strong id="modalTruckModel">-</strong></small></div>
                            <div class="col-md-6"><small>Color: <strong id="modalTruckColor">-</strong></small></div>
                        </div>
                    </div>
                    <form id="bookingFormModal">
                        <input type="hidden" id="modalTruckId" name="truck_id" />
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Quantity (Egg Trays)*max:2000 <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="modalQuantity" name="quantity" min="1" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pickup Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modalPickupAddress" required />
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Receiver Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="modalReceiverName" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Receiver Phone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="modalReceiverPhone" maxlength="11" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Drop-off Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modalDropLocation" required />
                        </div>
                        <button type="submit" class="btn-book-confirm" id="modalBookBtn">
                            <i class="fas fa-bookmark me-2"></i> CONFIRM BOOKING
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== LOGOUT CONFIRMATION ===== -->
    <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-sign-out-alt me-2"></i>Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to logout from your account?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script nonce="{{ $csp_nonce }}">
        // ========== GLOBALS ==========
        window.currentTrucks = [];
        window.selectedTruck = null;
        let bookingModalInstance;
        let logoutModalInstance;
        let notificationModalInstance;
        let clearAllConfirmModalInstance;
        let darkMode = localStorage.getItem('darkMode') === 'true';
        let notificationCheckInterval = null;
        let notificationSoundEnabled = true;
        let lastNotificationCount = 0;

        // ========== CLICK SOUND SYSTEM (No background audio) ==========
        (function() {
            var clickAudio = document.getElementById('clickAudio');

            function playClick() {
                if (clickAudio) {
                    clickAudio.currentTime = 0;
                    clickAudio.play().catch(function() {});
                }
            }

            document.addEventListener('click', function(e) {
                var target = e.target.closest('a, button, .btn-primary-3d, .btn-book-confirm, .btn-confirm-danger, .btn-confirm-secondary, .btn-clear-all, .btn-close, .filter-chip, .nav-link-3d, .user-dropdown-btn, .notification-bell, .three-dots-btn, .truck-detail-btn, .dropdown-item, .icon-circle, [href], [role="button"]');
                if (target) {
                    if (target.closest('#clickAudio')) {
                        return;
                    }
                    playClick();
                }
            });

            window.__clickAudio = clickAudio;
        })();

        const loggedUser = {
            id: {{ Auth::id() ?? 0 }},
            name: "{{ addslashes(trim((Auth::user()->first_name ?? '') . ' ' . (Auth::user()->last_name ?? ''))) }}",
            phone: "{{ Auth::user()->mobile_number ?? '' }}",
            email: "{{ Auth::user()->email ?? '' }}",
            city: "{{ Auth::user()->city ?? '' }}",
            type: "{{ Auth::user()->user_type ?? 'customer' }}"
        };

        // ========== HELPER FUNCTIONS ==========
        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        function showToast(message, type = 'success') {
            const safeMessage = escapeHtml(message);
            const icon = { success: 'fa-check-circle', danger: 'fa-exclamation-circle', warning: 'fa-exclamation-triangle', info: 'fa-info-circle' }[type] || 'fa-info-circle';
            const bg = { success: 'bg-success', danger: 'bg-danger', warning: 'bg-warning', info: 'bg-info' }[type] || 'bg-primary';
            const toast = $(`<div class="toast-notification ${bg} text-white shadow-lg p-3 rounded-4"><i class="fas ${icon} me-2"></i> ${safeMessage}</div>`);
            $('#toast-container').append(toast);
            setTimeout(() => toast.fadeOut(300, () => toast.remove()), 3500);
        }

        function playNotificationSound() {
            if (!notificationSoundEnabled) return;
            try {
                const audio = new Audio('/sounds/notification.mp3');
                audio.volume = 0.5;
                audio.play().catch(e => console.log('Sound play failed:', e));
            } catch (e) { console.log('Sound error:', e); }
        }

        // ========== NOTIFICATION SYSTEM ==========
        async function loadNotificationsForModal() {
            try {
                const response = await fetch('/notifications', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();

                if (data.success) {
                    renderNotificationsInModal(data.notifications);
                    updateNotificationBadge(data.unread_count);

                    if (data.unread_count > lastNotificationCount && lastNotificationCount > 0) {
                        playNotificationSound();
                    }
                    lastNotificationCount = data.unread_count;
                }
            } catch (error) {
                console.error('Error loading notifications:', error);
            }
        }

        async function loadUnreadCount() {
            try {
                const response = await fetch('/notifications/unread-count', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                updateNotificationBadge(data.count);

                if (data.count > lastNotificationCount && lastNotificationCount > 0) {
                    playNotificationSound();
                }
                lastNotificationCount = data.count;
            } catch (error) {
                console.error('Error loading unread count:', error);
            }
        }

        function updateNotificationBadge(count) {
            const badge = $('#notificationBadge');
            if (count > 0) {
                badge.text(count > 99 ? '99+' : count);
                badge.fadeIn();
            } else {
                badge.fadeOut();
            }
        }

        function getNotificationIcon(type) {
            const icons = {
                'damage_request': 'fa-clipboard-list',
                'damage_request_reply': 'fa-reply-all',
                'message': 'fa-envelope',
                'booking': 'fa-truck',
                'fee_update': 'fa-dollar-sign',
                'system': 'fa-bell',
                'announcement': 'fa-bullhorn'
            };
            return icons[type] || 'fa-bell';
        }

        function getTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);

            if (seconds < 60) return 'Just now';
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
            const days = Math.floor(hours / 24);
            if (days < 7) return `${days} day${days > 1 ? 's' : ''} ago`;
            return date.toLocaleDateString();
        }

        function renderNotificationsInModal(notifications) {
            const $list = $('#notificationListModal');

            if (!notifications || notifications.length === 0) {
                $list.html(`
                    <div class="empty-notifications-modal">
                        <i class="fas fa-bell-slash"></i>
                        <p>No notifications yet</p>
                        <small>You'll be notified about damage request updates, replies, messages, and fee changes.</small>
                    </div>
                `);
                return;
            }

            let html = '';
            notifications.forEach(notif => {
                const isUnread = !notif.is_read;
                const icon = getNotificationIcon(notif.type);
                const timeAgo = notif.created_at_human || getTimeAgo(notif.created_at);

                html += `
                    <div class="notification-item-modal ${isUnread ? 'unread' : ''}" data-id="${escapeHtml(String(notif.id))}" data-type="${escapeHtml(notif.type)}">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="notification-icon-modal">
                                <i class="fas ${icon}"></i>
                            </div>
                            <div class="notification-content-modal">
                                <div class="notification-title-modal">${escapeHtml(notif.title)}</div>
                                <div class="notification-message-modal">${escapeHtml(notif.message)}</div>
                                <div class="notification-time-modal">${escapeHtml(timeAgo)}</div>
                            </div>
                            ${!isUnread ? '<i class="fas fa-check-circle text-muted" style="font-size: 0.8rem;"></i>' : ''}
                        </div>
                    </div>
                `;
            });

            $list.html(html);

            $('.notification-item-modal').on('click', function() {
                const id = $(this).data('id');
                const type = $(this).data('type');
                markNotificationAsRead(id);

                if (type === 'damage_request' || type === 'damage_request_reply') {
                    window.location.href = '/damage-requests';
                } else if (type === 'message') {
                    window.location.href = '/messages';
                } else if (type === 'booking') {
                    window.location.href = '/bookings';
                } else if (type === 'announcement') {
                    window.location.href = '/announcements';
                }
            });
        }

        async function markNotificationAsRead(id) {
            try {
                const response = await fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    if (notificationModalInstance && notificationModalInstance._isShown) {
                        await loadNotificationsForModal();
                    }
                    loadUnreadCount();
                }
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }
        }

        // ----- NEW: Mark All Read -----
        async function markAllNotificationsRead() {
            try {
                const response = await fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    showToast('All notifications marked as read', 'success');
                    if (notificationModalInstance && notificationModalInstance._isShown) {
                        await loadNotificationsForModal();
                    }
                    await loadUnreadCount();
                } else {
                    showToast(data.error || 'Failed to mark all as read', 'danger');
                }
            } catch (error) {
                console.error('Error marking all as read:', error);
                showToast('Network error', 'danger');
            }
        }

        async function clearAllNotifications() {
            const confirmBtn = $('#confirmClearAllBtn');
            const originalText = confirmBtn.html();

            try {
                confirmBtn.html('<i class="fas fa-spinner fa-spin me-1"></i> Clearing...').prop('disabled', true);

                const response = await fetch('/notifications/clear-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast('All notifications cleared successfully', 'success');
                    if (clearAllConfirmModalInstance) {
                        clearAllConfirmModalInstance.hide();
                    }
                    if (notificationModalInstance) {
                        notificationModalInstance.hide();
                    }
                    await loadNotificationsForModal();
                    await loadUnreadCount();
                } else {
                    showToast(data.error || 'Failed to clear notifications', 'danger');
                }
            } catch (error) {
                console.error('Error clearing notifications:', error);
                showToast('Network error: ' + error.message, 'danger');
            } finally {
                confirmBtn.html(originalText).prop('disabled', false);
            }
        }

        function initNotificationModal() {
            const $bellBtn = $('#notificationBellBtn');

            notificationModalInstance = new bootstrap.Modal(document.getElementById('notificationModal'));
            clearAllConfirmModalInstance = new bootstrap.Modal(document.getElementById('clearAllConfirmModal'));

            $bellBtn.off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                loadNotificationsForModal().then(() => {
                    notificationModalInstance.show();
                });
            });

            // Mark All Read button
            $('#markAllReadBtn').off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                markAllNotificationsRead();
            });

            $('#clearAllNotificationsBtn').off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                notificationModalInstance.hide();
                setTimeout(() => {
                    clearAllConfirmModalInstance.show();
                }, 300);
            });

            $('#confirmClearAllBtn').off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                clearAllNotifications();
            });
        }

        function startNotificationPolling() {
            if (notificationCheckInterval) {
                clearInterval(notificationCheckInterval);
            }
            loadUnreadCount();
            // Refresh every 10 seconds – silent update
            notificationCheckInterval = setInterval(() => {
                // If modal is open, refresh the full list; otherwise just update badge
                if (notificationModalInstance && notificationModalInstance._isShown) {
                    loadNotificationsForModal();
                } else {
                    loadUnreadCount();
                }
            }, 10000); // 10 seconds
        }

        function stopNotificationPolling() {
            if (notificationCheckInterval) {
                clearInterval(notificationCheckInterval);
                notificationCheckInterval = null;
            }
        }

        // ========== INITIALIZATION ==========
        function initTheme() {
            if (darkMode) document.documentElement.setAttribute('data-theme', 'dark');
            else document.documentElement.setAttribute('data-theme', 'light');
        }
        initTheme();

        // Sidebar
        $('#threeDotsBtn').click(function(e) {
            e.stopPropagation();
            $('#mainSidebar').addClass('open');
            $('#sidebarOverlay').addClass('active');
        });

        function closeSidebar() {
            $('#mainSidebar').removeClass('open');
            $('#sidebarOverlay').removeClass('active');
        }

        $('#sidebarOverlay').click(closeSidebar);
        $(document).on('keydown', function(e) { if (e.key === 'Escape') closeSidebar(); });

        function updateActiveNav() {
            let path = window.location.pathname;
            $('.nav-link-3d').removeClass('active');
            let title = 'Surecargo';
            if (path === '/dashboard') {
                $('.nav-link-3d[data-page="dashboard"]').addClass('active');
                title = 'Surecargo';
            } else if (path === '/bookings') {
                $('.nav-link-3d[data-page="bookings"]').addClass('active');
                title = 'My Bookings';
            } else if (path === '/profile') {
                $('.nav-link-3d[data-page="profile"]').addClass('active');
                title = 'Profile';
            } else if (path === '/messages') {
                $('.nav-link-3d[data-page="messages"]').addClass('active');
                title = 'Messages';
            } else if (path === '/damage-requests') {
                $('.nav-link-3d[data-page="damage-requests"]').addClass('active');
                title = 'Damage Requests';
            } else if (path === '/track-validate') {
                $('.nav-link-3d[data-page="track-validate"]').addClass('active');
                title = 'Track Validate';
            } else if (path === '/announcements') {
                $('.nav-link-3d[data-page="announcements"]').addClass('active');
                title = 'Announcements';
            }
            $('#pageTitle').text(title);
        }
        updateActiveNav();

        function isOnDashboard() { return window.location.pathname === '/dashboard'; }

        // ===== TRUCK FUNCTIONS (NEW LAYOUT) =====
        window.loadTrucks = async function() {
            if (!isOnDashboard()) return;
            try {
                const resp = await fetch('/api/trucks-with-stats');
                const data = await resp.json();
                if (data.success && data.trucks) {
                    window.currentTrucks = data.trucks;
                    window.renderTrucks(window.currentTrucks);
                } else {
                    $('#trucksContainer').html('<div class="col-12 text-center py-5"><p class="text-danger">Failed to load trucks</p></div>');
                }
            } catch (e) {
                console.error(e);
                $('#trucksContainer').html('<div class="col-12 text-center py-5"><p class="text-danger">Error loading trucks</p></div>');
            }
        };

        window.renderTrucks = function(trucks) {
            if (!isOnDashboard()) return;
            const filter = $('.filter-chip.active').data('filter') || 'all';
            let filtered = trucks;
            if (filter !== 'all') filtered = trucks.filter(t => t.status === filter);
            if (!filtered.length) {
                $('#trucksContainer').html('<div class="col-12 text-center py-5"><p class="text-muted">No trucks found</p></div>');
                return;
            }
            let html = '';
            filtered.forEach(truck => {
                let statusClass = truck.status === 'available' ? 'status-available' : (truck.status === 'booked' ? 'status-booked' : 'status-maintenance');
                let statusText = truck.status.charAt(0).toUpperCase() + truck.status.slice(1);
                let imageUrl = truck.image ? '/' + truck.image : 'https://via.placeholder.com/500x500?text=' + encodeURIComponent(truck.truck_name);
                html += `
                    <div class="col-md-6 col-lg-6 col-xl-4 mb-4">
                        <div class="truck-card" data-truck-id="${truck.id}">
                            <!-- Square Image -->
                            <div class="truck-image-wrapper">
                                <img src="${imageUrl}" class="truck-image" alt="${escapeHtml(truck.truck_name)}" data-fallback="https://via.placeholder.com/500x500?text=Truck" />
                            </div>
                            <!-- Summary -->
                            <div class="truck-summary">
                                <h5 class="truck-name">${escapeHtml(truck.truck_name)}</h5>
                                <div class="truck-number">${escapeHtml(truck.truck_number)}</div>
                                <span class="status-badge ${statusClass}">${statusText}</span>
                            </div>
                            <!-- See Details Button -->
                            <div class="truck-detail-btn-wrapper">
                                <button class="truck-detail-btn" data-truck-id="${truck.id}">
                                    See Details <i class="fas fa-chevron-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            $('#trucksContainer').html(html);

            // Image error fallback
            $('.truck-image').off('error').on('error', function() {
                const fallback = $(this).data('fallback') || 'https://via.placeholder.com/500x500?text=Truck';
                $(this).attr('src', fallback);
            });
        };

        // Event delegation for "See Details" button
        $(document).on('click', '.truck-detail-btn', function(e) {
            e.stopPropagation();
            const truckId = $(this).data('truck-id');
            if (truckId) {
                window.selectTruck(truckId);
            }
        });

        // Optional: clicking the card (not on button) also opens details
        $(document).on('click', '.truck-card', function(e) {
            if ($(e.target).closest('.truck-detail-btn').length) return; // let button handle it
            const truckId = $(this).data('truck-id');
            if (truckId) {
                window.selectTruck(truckId);
            }
        });

        window.selectTruck = async function(truckId) {
            let truck = window.currentTrucks.find(t => t.id === truckId);
            if (!truck) {
                showToast('Truck not found', 'warning');
                return;
            }
            if (truck.status !== 'available') {
                showToast(`Truck is ${truck.status} and cannot be booked`, 'warning');
                return;
            }
            $('.truck-card').removeClass('selected');
            $(`.truck-card[data-truck-id="${truckId}"]`).addClass('selected');
            $('#modalTruckName').text(truck.truck_name);
            $('#modalTruckId').val(truck.id);
            $('#modalDriverName').text(truck.driver_name);
            $('#modalDriverPhone').text(truck.driver_phone);
            $('#modalTruckModel').text(truck.truck_model);
            $('#modalTruckColor').text(truck.color);
            $('#modalAvailableTrays').text(truck.remaining);
            $('#modalPercentageUsed').text(truck.percentage_used + '%');
            $('#modalQuantity').attr('max', truck.remaining);
            $('#bookingFormModal')[0].reset();
            $('#modalReceiverName').val(loggedUser.name);
            $('#modalReceiverPhone').val(loggedUser.phone);
            bookingModalInstance.show();
        };

        // Filter chips
        $(document).on('click', '.filter-chip', function() {
            $('.filter-chip').removeClass('active');
            $(this).addClass('active');
            if (window.renderTrucks && window.currentTrucks) window.renderTrucks(window.currentTrucks);
        });

        // Booking form submission
        $('#bookingFormModal').on('submit', async function(e) {
            e.preventDefault();
            let quantity = parseInt($('#modalQuantity').val());
            let truckId = $('#modalTruckId').val();
            let truck = window.currentTrucks.find(t => t.id == truckId);
            if (quantity > truck?.remaining) {
                showToast(`Only ${truck?.remaining} trays available`, 'danger');
                return;
            }
            let payload = {
                truck_id: truckId,
                quantity: quantity,
                pickup_address: $('#modalPickupAddress').val().trim(),
                receiver_name: $('#modalReceiverName').val().trim(),
                receiver_phone: $('#modalReceiverPhone').val().trim(),
                drop_location: $('#modalDropLocation').val().trim(),
                notes: ''
            };
            if (!payload.receiver_name || !payload.receiver_phone || !payload.pickup_address || !payload.drop_location) {
                showToast('Please fill all fields', 'danger');
                return;
            }
            $('#modalBookBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            try {
                let resp = await fetch('/api/book', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                    body: JSON.stringify(payload)
                });
                let result = await resp.json();
                if (resp.ok && result.success) {
                    showToast('Booking created successfully!', 'success');
                    bookingModalInstance.hide();
                    if (isOnDashboard()) await window.loadTrucks();
                    setTimeout(() => { window.location.href = '/bookings'; }, 1500);
                } else {
                    showToast(result.error || 'Booking failed', 'danger');
                }
            } catch (e) {
                showToast('Network error. Please try again.', 'danger');
            } finally {
                $('#modalBookBtn').prop('disabled', false).html('<i class="fas fa-bookmark me-2"></i> CONFIRM BOOKING');
            }
        });

        // Initialize modals
        bookingModalInstance = new bootstrap.Modal(document.getElementById('bookingModal'));
        logoutModalInstance = new bootstrap.Modal(document.getElementById('logoutConfirmModal'));

        $('#logoutBtn').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            logoutModalInstance.show();
        });

        // Initialize notification system
        initNotificationModal();
        startNotificationPolling();

        // Load trucks if on dashboard
        if (isOnDashboard()) {
            $(document).ready(function() {
                window.loadTrucks();
                setInterval(() => {
                    if (isOnDashboard()) window.loadTrucks();
                }, 30000);
            });
        }

        window.updateHeaderProfileImage = function(imageUrl, fullName = null) {
            const $headerImg = $('#headerProfileImage');
            if (!$headerImg.length) return;
            const userName = fullName || $('.user-dropdown-btn span').text() || 'User';
            const encodedName = encodeURIComponent(userName);
            const fallbackAvatar = `https://ui-avatars.com/api/?name=${encodedName}&background=0D8F81&color=fff&size=64&bold=true`;
            if (imageUrl && imageUrl.trim() !== '') {
                $headerImg.attr('src', imageUrl + '?t=' + new Date().getTime());
            } else {
                $headerImg.attr('src', fallbackAvatar);
            }
            $headerImg.off('error').on('error', function() {
                $(this).attr('src', fallbackAvatar);
            });
        };
    </script>
    @stack('scripts')
</body>
</html>
