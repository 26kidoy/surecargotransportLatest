{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SureCargo Admin')</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/icon.png') }}">
    {{-- Main layout styles --}}
    <style nonce="{{ $csp_nonce ?? '' }}">
/* ============================================================
   ADMIN LAYOUT - LIGHT/DARK/VIOLET THEME
   FIXED: Mobile content width 98%, padding 3px
   ============================================================ */

:root {
    --bg-gradient-start: #ffffff;
    --bg-gradient-end: #f0e6f5;
    --navbar-bg-start: #ffffff;
    --navbar-bg-end: #d4b8e8;
    --sidebar-bg-start: #ffffff;
    --sidebar-bg-end: #d4b8e8;
    --content-bg: rgba(255,255,255,0.8);
    --text-color: #1A1A1A;
    --card-border: rgba(255,255,255,0.3);

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
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html {
    font-size: 16px;
    -webkit-text-size-adjust: 100%;
}

body {
    font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    overflow-x: hidden;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    font-size: var(--font-base);
    font-weight: 400;
    line-height: 1.6;
    color: var(--text-color);
}

/* ============================================================
   THEME MODE VARIABLES
   ============================================================ */
[data-theme="light"] {
    --bg-gradient-start: #ffffff;
    --bg-gradient-end: #f0e6f5;
    --navbar-bg-start: #ffffff;
    --navbar-bg-end: #d4b8e8;
    --sidebar-bg-start: #ffffff;
    --sidebar-bg-end: #d4b8e8;
    --content-bg: rgba(255,255,255,0.8);
    --text-color: #1A1A1A;
    --card-border: rgba(255,255,255,0.3);
}

[data-theme="dark"] {
    --bg-gradient-start: #1a1a2e;
    --bg-gradient-end: #16213e;
    --navbar-bg-start: #1a1a2e;
    --navbar-bg-end: #2d2d44;
    --sidebar-bg-start: #1a1a2e;
    --sidebar-bg-end: #2d2d44;
    --content-bg: rgba(26,26,46,0.85);
    --text-color: #e0e0e0;
    --card-border: rgba(255,255,255,0.1);
}

[data-theme="violet"] {
    --bg-gradient-start: #2d1b4e;
    --bg-gradient-end: #4a1a6b;
    --navbar-bg-start: #2d1b4e;
    --navbar-bg-end: #5a2d7a;
    --sidebar-bg-start: #2d1b4e;
    --sidebar-bg-end: #5a2d7a;
    --content-bg: rgba(45,27,78,0.85);
    --text-color: #e8d5f5;
    --card-border: rgba(255,255,255,0.15);
}

/* ============================================================
   TRANSITIONS
   ============================================================ */
.main-content,
.top-navbar,
.content-card,
.admin-sidebar {
    transition: background 0.5s ease, color 0.5s ease, border-color 0.5s ease;
}

/* ============================================================
   MAIN CONTENT
   ============================================================ */
.main-content {
    margin-left: 80px;
    min-height: 100vh;
    transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: linear-gradient(135deg, var(--bg-gradient-start), var(--bg-gradient-end) 100%);
    position: relative;
    display: flex;
    flex-direction: column;
    color: var(--text-color);
}

.admin-sidebar:not(.collapsed) ~ .main-content {
    margin-left: 320px;
}

/* ============================================================
   FIXED TOP NAVBAR
   ============================================================ */
.top-navbar {
    position: fixed;
    top: 0;
    left: 80px;
    right: 0;
    z-index: 1040;
    padding: var(--sp-sm) var(--sp-xl);
    min-height: 70px;
    backdrop-filter: blur(8px);
    border-bottom: 1px solid rgba(0,0,0,0.05);
    border-radius: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: var(--font-base) !important;
    transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: linear-gradient(135deg, var(--navbar-bg-start), var(--navbar-bg-end) 100%);
    color: var(--text-color);
}

.top-navbar * {
    font-size: var(--font-base) !important;
}

.admin-sidebar:not(.collapsed) ~ .main-content .top-navbar {
    left: 320px;
}

/* ============================================================
   SCROLLABLE CONTENT AREA - FIXED FOR MOBILE
   ============================================================ */
.content-area {
    margin-top: 70px;
    padding: var(--sp-xl) var(--sp-xxl) var(--sp-xl) var(--sp-xxl);
    flex: 1;
    transition: padding 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    max-width: 100%;
}

/* ============================================================
   CONTENT CARD
   ============================================================ */
.content-card {
    background: var(--content-bg);
    backdrop-filter: blur(4px);
    border-radius: 24px;
    padding: var(--sp-xl);
    box-shadow: 0 8px 32px rgba(0,0,0,0.04);
    border: 1px solid var(--card-border);
    color: var(--text-color);
    max-width: 100%;
}

/* ============================================================
   NAVBAR ELEMENTS
   ============================================================ */
.top-navbar .navbar-title h5 {
    font-size: var(--font-base) !important;
    font-weight: 700;
    margin-bottom: 0;
    color: var(--text-color);
}

.top-navbar .navbar-title small {
    font-size: var(--font-sm) !important;
    color: var(--text-color);
    opacity: 0.7;
}

.navbar-actions {
    display: flex;
    align-items: center;
    gap: var(--sp-sm);
}

/* ============================================================
   THEME TOGGLE BUTTONS
   ============================================================ */
.theme-toggle-group {
    display: flex;
    gap: 6px;
    align-items: center;
    background: rgba(255,255,255,0.15);
    padding: 4px 8px;
    border-radius: 30px;
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,0.1);
}

.theme-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-base);
    background: transparent;
    padding: 0;
    position: relative;
    min-width: 34px;
    min-height: 34px;
}

.theme-btn:hover {
    transform: scale(1.15);
}

.theme-btn.active-theme {
    border-color: #DC2626;
    transform: scale(1.1);
    box-shadow: 0 0 20px rgba(220,38,38,0.3);
}

.theme-btn .theme-dot {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: block;
    transition: all 0.3s;
    border: 1px solid rgba(255,255,255,0.2);
}

.theme-btn .theme-dot.light-dot {
    background: linear-gradient(135deg, #ffffff, #e8d5f5);
}

.theme-btn .theme-dot.dark-dot {
    background: linear-gradient(135deg, #1a1a2e, #16213e);
}

.theme-btn .theme-dot.violet-dot {
    background: linear-gradient(135deg, #2d1b4e, #5a2d7a);
}

.theme-btn .theme-tooltip {
    position: absolute;
    bottom: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%) scale(0.8);
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: var(--font-xs) !important;
    font-weight: 600;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: all 0.2s;
    backdrop-filter: blur(4px);
}

.theme-btn:hover .theme-tooltip {
    opacity: 1;
    transform: translateX(-50%) scale(1);
}

/* ============================================================
   LOGOUT BUTTON
   ============================================================ */
.btn-logout {
    border-radius: 40px;
    padding: var(--sp-xs) var(--sp-lg);
    font-weight: 600;
    transition: all 0.2s;
    box-shadow: inset 2px 5px 3px black !important;
    background: linear-gradient(135deg, white, hsl(278, 88%, 77%) 100%);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: var(--font-base) !important;
    color: red;
    min-height: 40px;
    border: none;
}

.btn-logout:hover {
    background: white;
    transform: scale(1.05) !important;
    box-shadow: 0 6px 12px rgba(220,38,38,0.3);
}

.btn-logout svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
    flex-shrink: 0;
}

.btn-logout:hover svg {
    stroke: black;
}

/* ============================================================
   SIDEBAR ICONS
   ============================================================ */
.admin-sidebar i,
.admin-sidebar .fas,
.admin-sidebar .far,
.admin-sidebar .fab {
    font-size: var(--font-base);
    vertical-align: middle;
}

/* ============================================================
   RESPONSIVE - FIXED FOR MOBILE
   ============================================================ */

/* --- Tablets & Small Desktops (769px - 992px) --- */
@media (min-width: 769px) and (max-width: 992px) {
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

    .main-content {
        margin-left: 0 !important;
    }

    .top-navbar {
        left: 0 !important;
        padding: var(--sp-sm) var(--sp-md);
        min-height: 60px;
    }

    .admin-sidebar:not(.collapsed) ~ .main-content .top-navbar {
        left: 0 !important;
    }

    .content-area {
        padding: var(--sp-md) var(--sp-md) var(--sp-md) var(--sp-md);
        margin-top: 60px;
        max-width: 100%;
    }

    .top-navbar .navbar-title h5 {
        font-size: var(--font-sm) !important;
    }

    .top-navbar * {
        font-size: var(--font-sm) !important;
    }

    .btn-logout {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 36px;
    }

    .theme-btn {
        width: 30px;
        height: 30px;
        min-width: 30px;
        min-height: 30px;
    }

    .theme-btn .theme-dot {
        width: 20px;
        height: 20px;
    }

    .content-card {
        padding: var(--sp-lg);
        border-radius: 20px;
        max-width: 100%;
    }
}

/* --- Mobile Devices (≤ 768px) - FIXED: 98% width, 3px padding --- */
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

    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }

    .top-navbar {
        left: 0 !important;
        padding: var(--sp-sm) var(--sp-md);
        min-height: 60px;
        padding-left: 56px; /* Space for hamburger button */
        width: 100% !important;
    }

    .admin-sidebar:not(.collapsed) ~ .main-content .top-navbar {
        left: 0 !important;
    }

    /* FIXED: Content area - 98% width, 3px padding */
    .content-area {
        padding: 3px !important;
        margin-top: 60px;
        width: 98% !important;
        max-width: 98% !important;
        margin-left: auto !important;
        margin-right: auto !important;
        display: block !important;
        flex: 1;
        box-sizing: border-box !important;
    }

    .top-navbar .navbar-title h5 {
        font-size: var(--font-sm) !important;
    }

    .top-navbar .navbar-title small {
        font-size: var(--font-xs) !important;
    }

    .top-navbar * {
        font-size: var(--font-sm) !important;
    }

    .btn-logout {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 36px;
        border-radius: 30px;
    }

    .btn-logout span {
        font-size: var(--font-xs) !important;
    }

    .theme-btn {
        width: 28px;
        height: 28px;
        min-width: 28px;
        min-height: 28px;
    }

    .theme-btn .theme-dot {
        width: 18px;
        height: 18px;
    }

    .theme-toggle-group {
        padding: var(--sp-xs) var(--sp-sm);
        gap: 4px;
    }

    .content-card {
        padding: var(--sp-md) !important;
        border-radius: 18px !important;
        max-width: 100% !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .navbar-actions {
        gap: var(--sp-xs);
    }
}
/* --- Small Phones (≤ 576px) - FIXED --- */
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

    .top-navbar {
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 50px;
        padding-left: 46px;
        width: 100% !important;
    }

    .top-navbar .navbar-title h5 {
        font-size: var(--font-xs) !important;
    }

    .top-navbar .navbar-title small {
        display: none;
    }

    .top-navbar * {
        font-size: var(--font-xs) !important;
    }

    .content-area {
        padding: 3px !important;
        margin-top: 50px;
        width: 98% !important;
        max-width: 98% !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    /* FIXED: Logout button - consistent styling */
    .btn-logout {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
        min-height: 32px !important;
        min-width: 32px !important;
        border-radius: 8px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px !important;
        background: linear-gradient(135deg, white, hsl(278, 88%, 77%) 100%) !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        color: red !important;
        font-weight: 600 !important;
        box-shadow: inset 2px 5px 3px rgba(0,0,0,0.1) !important;
    }

    .btn-logout:hover {
        transform: scale(1.05) !important;
        box-shadow: 0 6px 12px rgba(220,38,38,0.3) !important;
    }

    .btn-logout span {
        display: none !important;
    }

    .btn-logout svg {
        width: 14px !important;
        height: 14px !important;
        flex-shrink: 0 !important;
    }

    .theme-btn {
        width: 24px;
        height: 24px;
        min-width: 24px;
        min-height: 24px;
    }

    .theme-btn .theme-dot {
        width: 15px;
        height: 15px;
    }

    .theme-toggle-group {
        padding: 2px 6px;
        gap: 3px;
        border-radius: 24px;
    }

    .theme-btn .theme-tooltip {
        font-size: 0.5rem !important;
        padding: 2px 6px;
        bottom: calc(100% + 4px);
    }

    .content-card {
        padding: var(--sp-sm) !important;
        border-radius: 14px !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .navbar-actions {
        gap: var(--sp-xs);
    }
}

/* --- Very Small Phones (≤ 400px) - FIXED --- */
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

    .top-navbar {
        padding: 0.05rem var(--sp-xs);
        min-height: 44px;
        padding-left: 40px;
        width: 100% !important;
    }

    .top-navbar .navbar-title h5 {
        font-size: 0.55rem !important;
    }

    .content-area {
        padding: 3px !important;
        margin-top: 44px;
        width: 98% !important;
        max-width: 98% !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    /* FIXED: Logout button - consistent styling */
    .btn-logout {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs) !important;
        min-height: 28px !important;
        min-width: 28px !important;
        border-radius: 6px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 3px !important;
        background: linear-gradient(135deg, white, hsl(278, 88%, 77%) 100%) !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        color: red !important;
        font-weight: 600 !important;
        box-shadow: inset 2px 5px 3px rgba(0,0,0,0.1) !important;
    }

    .btn-logout:hover {
        transform: scale(1.05) !important;
        box-shadow: 0 6px 12px rgba(220,38,38,0.3) !important;
    }

    .btn-logout svg {
        width: 12px !important;
        height: 12px !important;
        flex-shrink: 0 !important;
    }

    .theme-btn {
        width: 20px;
        height: 20px;
        min-width: 20px;
        min-height: 20px;
    }

    .theme-btn .theme-dot {
        width: 12px;
        height: 12px;
    }

    .theme-toggle-group {
        padding: 2px 4px;
        gap: 2px;
        border-radius: 20px;
    }

    .content-card {
        padding: var(--sp-xs) !important;
        border-radius: 12px !important;
        width: 100% !important;
        max-width: 100% !important;
    }
}

/* --- Extra Small (≤ 350px) - FIXED --- */
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

    .top-navbar .navbar-title h5 {
        font-size: 0.45rem !important;
    }

    .content-area {
        padding: 3px !important;
        width: 98% !important;
        max-width: 98% !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    /* FIXED: Logout button - consistent styling */
    .btn-logout {
        font-size: 0.4rem !important;
        padding: 0.05rem var(--sp-xs) !important;
        min-height: 24px !important;
        min-width: 24px !important;
        border-radius: 4px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 2px !important;
        background: linear-gradient(135deg, white, hsl(278, 88%, 77%) 100%) !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        color: red !important;
        font-weight: 600 !important;
        box-shadow: inset 2px 5px 3px rgba(0,0,0,0.1) !important;
    }

    .btn-logout:hover {
        transform: scale(1.05) !important;
        box-shadow: 0 6px 12px rgba(220,38,38,0.3) !important;
    }

    .btn-logout svg {
        width: 10px !important;
        height: 10px !important;
        flex-shrink: 0 !important;
    }

    .theme-btn {
        width: 18px;
        height: 18px;
        min-width: 18px;
        min-height: 18px;
    }

    .theme-btn .theme-dot {
        width: 10px;
        height: 10px;
    }

    .content-card {
        padding: 0.05rem !important;
        border-radius: 10px !important;
        width: 100% !important;
        max-width: 100% !important;
    }
}

/* ============================================================
   FIX: Prevent horizontal scroll on all devices
   ============================================================ */
.container,
.container-fluid,
.row,
.col-12,
.col-sm-6,
.col-md-4,
.col-lg-3 {
    max-width: 100% !important;
    overflow-x: hidden !important;
}

/* ============================================================
   FIX: Ensure content card fills width on mobile
   ============================================================ */
@media (max-width: 768px) {
    .content-card {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        overflow-x: hidden !important;
    }

    .content-card * {
        max-width: 100% !important;
        overflow-x: hidden !important;
        word-wrap: break-word !important;
    }

    .content-card .table-responsive {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
    }
}

/* ============================================================
   BASE LOGOUT BUTTON - Consistent across all sizes
   ============================================================ */
.btn-logout {
    font-size: var(--font-base) !important;
    padding: var(--sp-xs) var(--sp-lg) !important;
    min-height: 40px !important;
    min-width: 40px !important;
    border-radius: 8px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
    background: linear-gradient(135deg, white, hsl(278, 88%, 77%) 100%) !important;
    border: none !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    color: red !important;
    font-weight: 600 !important;
    box-shadow: inset 2px 5px 3px rgba(0,0,0,0.1) !important;
}

.btn-logout:hover {
    transform: scale(1.05) !important;
    box-shadow: 0 6px 12px rgba(220,38,38,0.3) !important;
    color: red !important;
}

.btn-logout svg {
    width: 16px !important;
    height: 16px !important;
    stroke: currentColor !important;
    stroke-width: 2 !important;
    fill: none !important;
    flex-shrink: 0 !important;
}

.btn-logout span {
    font-size: inherit !important;
    font-weight: 600 !important;
}

/* Tablet size */
@media (min-width: 769px) and (max-width: 1024px) {
    .btn-logout {
        font-size: var(--font-sm) !important;
        padding: var(--sp-xs) var(--sp-md) !important;
        min-height: 36px !important;
        min-width: 36px !important;
        border-radius: 6px !important;
        gap: 4px !important;
    }

    .btn-logout svg {
        width: 14px !important;
        height: 14px !important;
    }
}

/* Desktop base - already defined above */

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

    @stack('styles')
</head>
<body>

    {{-- Include the sidebar --}}
    @include('admin.layouts.sidebar')

    {{-- Main content wrapper --}}
    <div class="main-content" id="mainContent">

        {{-- Fixed top navbar – inside main-content, moves with sidebar --}}
        <div class="top-navbar" id="topNavbar">
            <div class="navbar-title">
                <h5>@yield('page-title', 'Dashboard')</h5>
                <small class="text-muted">@yield('breadcrumb', '')</small>
            </div>
            <div class="navbar-actions">
                {{-- Theme toggle buttons --}}
                <div class="theme-toggle-group" id="themeToggleGroup">
                    <button type="button" class="theme-btn active-theme" data-theme="light" aria-label="Light mode">
                        <span class="theme-dot light-dot"></span>
                        <span class="theme-tooltip">Light</span>
                    </button>
                    <button type="button" class="theme-btn" data-theme="dark" aria-label="Dark mode">
                        <span class="theme-dot dark-dot"></span>
                        <span class="theme-tooltip">Dark</span>
                    </button>
                    <button type="button" class="theme-btn" data-theme="violet" aria-label="Violet mode">
                        <span class="theme-dot violet-dot"></span>
                        <span class="theme-tooltip">Violet</span>
                    </button>
                </div>

                {{-- Logout button triggers modal --}}
                <button type="button" class="btn btn-logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span>Logout</span>
                </button>

                {{-- LOGOUT FORM – moved outside modal to avoid Bootstrap event conflicts --}}
                <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>

        {{-- Scrollable content area --}}
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    {{-- Logout Confirmation Modal --}}
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to log out of the admin panel?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    {{-- Use a direct click handler with a unique ID – no inline JS, CSP friendly --}}
                    <button type="button" class="btn btn-danger" id="confirmLogoutBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" style="margin-right: 6px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Yes, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- CSP‑friendly JavaScript: no inline events, all logic in a DOMContentLoaded listener --}}
    <script nonce="{{ $csp_nonce ?? '' }}">
        document.addEventListener('DOMContentLoaded', function () {
            // ================================================================
            // LOGOUT CONFIRMATION
            // ================================================================
            const confirmBtn = document.getElementById('confirmLogoutBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const logoutForm = document.getElementById('logout-form');
                    if (logoutForm) {
                        logoutForm.submit();
                    }
                });
            }

            // ================================================================
            // THEME TOGGLE FUNCTIONALITY
            // ================================================================
            const themeButtons = document.querySelectorAll('.theme-btn');
            const htmlElement = document.documentElement;
            const STORAGE_KEY = 'admin_theme_preference';

            // Load saved theme or default to 'light'
            function getSavedTheme() {
                const saved = localStorage.getItem(STORAGE_KEY);
                if (saved && ['light', 'dark', 'violet'].includes(saved)) {
                    return saved;
                }
                return 'light';
            }

            function setTheme(theme) {
                // Update HTML data attribute
                htmlElement.setAttribute('data-theme', theme);

                // Update active state on buttons
                themeButtons.forEach(btn => {
                    btn.classList.remove('active-theme');
                    if (btn.getAttribute('data-theme') === theme) {
                        btn.classList.add('active-theme');
                    }
                });

                // Save preference
                localStorage.setItem(STORAGE_KEY, theme);
            }

            // Apply saved theme on load
            const savedTheme = getSavedTheme();
            setTheme(savedTheme);

            // Add click listeners to theme buttons
            themeButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const theme = this.getAttribute('data-theme');
                    setTheme(theme);

                    // Play click sound if available from sidebar
                    try {
                        if (typeof window.playClickSound === 'function') {
                            window.playClickSound();
                        }
                    } catch (e) {
                        // Silent fail
                    }
                });
            });

            // ================================================================
            // EXPOSE PLAY CLICK SOUND FOR SIDEBAR INTEGRATION
            // ================================================================
            window.playClickSound = function() {
                try {
                    if (window.sidebarAudio && window.sidebarAudio.play) {
                        window.sidebarAudio.currentTime = 0;
                        const promise = window.sidebarAudio.play();
                        if (promise && promise.catch) {
                            promise.catch(() => {});
                        }
                        return;
                    }
                    const ctx = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = ctx.createOscillator();
                    const gainNode = ctx.createGain();
                    oscillator.type = 'square';
                    oscillator.frequency.value = 600;
                    gainNode.gain.setValueAtTime(0.15, ctx.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.04);
                    oscillator.connect(gainNode);
                    gainNode.connect(ctx.destination);
                    oscillator.start(ctx.currentTime);
                    oscillator.stop(ctx.currentTime + 0.04);
                } catch (e) {
                    // Silent fail
                }
            };

            // ================================================================
            // HAMBURGER MENU - Ensure active state sync with sidebar
            // ================================================================
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const sidebarEl = document.getElementById('adminSidebar');

            if (hamburgerBtn && sidebarEl) {
                // Listen for sidebar open/close events to sync hamburger
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === 'class') {
                            if (sidebarEl.classList.contains('open')) {
                                hamburgerBtn.classList.add('active');
                            } else {
                                hamburgerBtn.classList.remove('active');
                            }
                        }
                    });
                });

                observer.observe(sidebarEl, { attributes: true });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
