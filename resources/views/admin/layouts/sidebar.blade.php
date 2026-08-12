@php
    $admin = Auth::guard('admin')->user();
@endphp

<style nonce="{{ $csp_nonce }}">
/* ============================================================
   SIDEBAR NAVIGATION - DEEPSEEK-STYLE RESPONSIVE STYLES
   Default Minimized (80px) / Expanded (320px)
   With Real-Time Theme Support (Light / Dark / Violet)
   ============================================================ */

:root {
    --sidebar-width-collapsed: 80px;
    --sidebar-width-expanded: 320px;
    --sidebar-transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    --text-color: #1A1A1A;
    --border-color: #E5E5E5;
    --hover-color: #DC2626;
    --shadow-color: rgba(0, 0, 0, 0.04);
    --sidebar-bg-start: #ffffff;
    --sidebar-bg-end: #d4b8e8;

    /* DEEPSEEK-STYLE FONT SIZES */
    --font-xs: 0.75rem;
    --font-sm: 0.875rem;
    --font-base: 1rem;
    --font-md: 1.125rem;
    --font-lg: 1.25rem;
    --font-xl: 1.5rem;
    --font-xxl: 1.75rem;

    --sp-xs: 0.25rem;
    --sp-sm: 0.5rem;
    --sp-md: 1rem;
    --sp-lg: 1.5rem;
    --sp-xl: 2rem;
}

/* ============================================================
   THEME VARIABLES - Real-Time Background Support
   ============================================================ */
[data-theme="light"] {
    --sidebar-bg-start: #ffffff;
    --sidebar-bg-end: #d4b8e8;
    --text-color: #1A1A1A;
    --border-color: #E5E5E5;
    --shadow-color: rgba(0, 0, 0, 0.04);
}

[data-theme="dark"] {
    --sidebar-bg-start: #1a1a2e;
    --sidebar-bg-end: #2d2d44;
    --text-color: #e0e0e0;
    --border-color: #2d2d44;
    --shadow-color: rgba(0, 0, 0, 0.3);
}

[data-theme="violet"] {
    --sidebar-bg-start: #2d1b4e;
    --sidebar-bg-end: #5a2d7a;
    --text-color: #e8d5f5;
    --border-color: #5a2d7a;
    --shadow-color: rgba(0, 0, 0, 0.3);
}

/* ============================================================
   SIDEBAR - DEFAULT MINIMIZED (80px) / EXPANDED (320px)
   FIXED: Added flex layout to push footer to bottom
   ============================================================ */
.admin-sidebar {
    width: var(--sidebar-width-collapsed);
    background: linear-gradient(135deg, var(--sidebar-bg-start), var(--sidebar-bg-end) 100%);
    border-right: 2px solid var(--border-color);
    transition: all var(--sidebar-transition), background 0.5s ease, color 0.5s ease, border-color 0.5s ease;
    position: fixed;
    height: 100vh;
    z-index: 100;
    overflow-y: auto;
    overflow-x: hidden;
    box-shadow: 4px 0 24px var(--shadow-color);
    color: var(--text-color);

    /* FIX: Flex layout to push footer to bottom */
    display: flex;
    flex-direction: column;
}

/* When expanded (collapsed class removed) */
.admin-sidebar:not(.collapsed) {
    width: var(--sidebar-width-expanded);
}

/* Hide text & extra content when minimized */
.admin-sidebar .sidebar-brand span,
.admin-sidebar .user-info,
.admin-sidebar .role-badge,
.admin-sidebar .nav-link span {
    opacity: 0;
    transform: translateX(-10px);
    pointer-events: none;
    display: none;
    transition: all 0.3s;
}

/* Show them when expanded */
.admin-sidebar:not(.collapsed) .sidebar-brand span,
.admin-sidebar:not(.collapsed) .user-info,
.admin-sidebar:not(.collapsed) .role-badge,
.admin-sidebar:not(.collapsed) .nav-link span {
    opacity: 1;
    transform: translateX(0);
    pointer-events: auto;
    display: inline-block;
}

/* ============================================================
   NAV LINKS
   ============================================================ */
.admin-sidebar .nav-link {
    justify-content: center;
    padding: var(--sp-md) var(--sp-sm);
    box-shadow: inset 2px 5px 3px black !important;
    font-weight: 600 !important;
    background: linear-gradient(135deg, var(--sidebar-bg-start), var(--sidebar-bg-end) 100%);
    color: var(--text-color);
    font-size: var(--font-base);
    min-height: 56px;
    transition: background 0.5s ease, color 0.5s ease, border-color 0.5s ease;
}

.admin-sidebar:not(.collapsed) .nav-link {
    justify-content: flex-start;
    padding: var(--sp-lg) var(--sp-xl);
}

/* SVG icon styling */
.admin-sidebar .nav-link svg {
    width: 28px;
    height: 28px;
    margin: 0;
    fill: none;
    stroke: var(--text-color);
    stroke-width: 1.8;
    transition: all 0.25s, stroke 0.5s ease;
    flex-shrink: 0;
}

.admin-sidebar:not(.collapsed) .nav-link svg {
    margin-right: var(--sp-md);
    width: 26px;
    height: 26px;
}

.admin-sidebar .nav-link:hover svg {
    stroke: #960983;
    transform: scale(1.1) rotate(-2deg);
}

.admin-sidebar .nav-link.active svg {
    stroke: #960983;
}

/* ============================================================
   BRAND
   ============================================================ */
.sidebar-brand svg {
    width: 32px;
    height: 32px;
    stroke: #960983;
    stroke-width: 1.6;
    fill: none;
    transition: stroke 0.5s ease;
}

.admin-sidebar:not(.collapsed) .sidebar-brand svg {
    margin-right: var(--sp-sm);
}

/* ============================================================
   TOGGLE BUTTON
   ============================================================ */
.toggle-sidebar-btn svg {
    width: 20px;
    height: 20px;
    stroke: #737373;
    stroke-width: 2.5;
    fill: none;
    transition: all 0.2s, stroke 0.5s ease;
}

.toggle-sidebar-btn:hover svg {
    stroke: white;
}

/* Role badge icon (shield) */
.role-badge svg {
    width: 14px;
    height: 14px;
    display: inline-block;
    margin-right: 4px;
    stroke: currentColor;
    stroke-width: 2;
    vertical-align: middle;
}

/* ============================================================
   HEADER - FIXED: Added flex-shrink: 0
   ============================================================ */
.admin-sidebar .sidebar-header {
    text-align: center;
    padding: var(--sp-md) var(--sp-sm);
    background: linear-gradient(135deg, var(--sidebar-bg-start), var(--sidebar-bg-end) 100%);
    transition: background 0.5s ease, border-color 0.5s ease;
    flex-shrink: 0; /* FIX: Prevent header from shrinking */
}

.admin-sidebar:not(.collapsed) .sidebar-header {
    text-align: left;
    padding: var(--sp-xl) var(--sp-xl);
}

.admin-sidebar .toggle-sidebar-btn {
    right: 50%;
    transform: translateX(50%) translateY(-50%);
}

.admin-sidebar:not(.collapsed) .toggle-sidebar-btn {
    right: var(--sp-md);
    transform: translateY(-50%);
}

@keyframes iconPop {
    0% { transform: scale(0.5) rotate(-10deg); opacity: 0; }
    70% { transform: scale(1.15) rotate(3deg); }
    100% { transform: scale(1) rotate(0deg); opacity: 1; }
}

/* ============================================================
   HEADER & BRAND
   ============================================================ */
.sidebar-header {
    border-bottom: 2px solid var(--border-color);
    position: relative;
    background: linear-gradient(135deg, var(--sidebar-bg-start), var(--sidebar-bg-end) 100%);
    transition: background 0.5s ease, border-color 0.5s ease;
}

.sidebar-brand {
    font-size: var(--font-xl);
    font-weight: 700;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.3s, color 0.5s ease;
    justify-content: center;
}

.admin-sidebar:not(.collapsed) .sidebar-brand {
    justify-content: flex-start;
}

@keyframes brandPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.08); }
}

/* ============================================================
   TOGGLE SIDEBAR BUTTON
   ============================================================ */
.toggle-sidebar-btn {
    position: absolute;
    top: 50%;
    background: #F5F5F5;
    border: 2px solid var(--border-color);
    color: #737373;
    width: 42px;
    height: 42px;
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), background 0.5s ease, border-color 0.5s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    min-height: 42px;
}

.toggle-sidebar-btn:hover {
    background: var(--hover-color);
    border-color: var(--hover-color);
    transform: translateY(-50%) scale(1.1);
}

.admin-sidebar:not(.collapsed) .toggle-sidebar-btn:hover {
    transform: translateY(-50%) scale(1.1);
}

/* ============================================================
   NAVIGATION - FIXED: Added flex: 1 and overflow-y: auto
   ============================================================ */
.sidebar-nav {
    flex: 1; /* FIX: Take up remaining space */
    overflow-y: auto; /* FIX: Make nav scrollable if content exceeds */
    padding: var(--sp-xl) 14px;
    list-style: none;
}

.nav-item {
    margin-bottom: var(--sp-sm);
    opacity: 0;
    animation: slideInRight 0.4s ease forwards;
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

.nav-link {
    display: flex;
    align-items: center;
    gap: var(--sp-md);
    border-radius: 20px;
    color: var(--text-color);
    transition: all 0.25s ease, background 0.5s ease, color 0.5s ease;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    font-size: var(--font-base);
    position: relative;
    overflow: hidden;
    cursor: pointer;
    min-height: 50px;
}

.nav-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 5px;
    background: var(--hover-color);
    border-radius: 0 4px 4px 0;
    transform: scaleY(0);
    transition: transform 0.25s;
}

.nav-link:hover::before {
    transform: scaleY(1);
}

.nav-link:hover {
    background: rgba(220, 38, 38, 0.06);
    color: var(--hover-color);
    transform: translateX(4px);
}

.nav-link.active {
    background: white;
    color: green;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.1);
}

.nav-link.active::before {
    transform: scaleY(1);
}

/* ============================================================
   USER INFO & AVATAR
   ============================================================ */
.avatar-sm {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    object-fit: cover;
    border: 3px solid var(--border-color);
    transition: all 0.3s, border-color 0.5s ease;
}

.avatar-sm:hover {
    transform: scale(1.05);
    border-color: var(--hover-color);
}

.user-info .text-dark {
    font-size: var(--font-base);
    font-weight: 700;
    color: var(--text-color);
    transition: color 0.5s ease;
}

.user-info .text-secondary {
    font-size: var(--font-sm);
    font-weight: 600;
    color: var(--text-color);
    opacity: 0.7;
    transition: color 0.5s ease;
}

.role-badge {
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 60px;
    font-size: var(--font-sm);
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s, background 0.5s ease, color 0.5s ease;
}

.role-super_admin { background: rgba(220,38,38,0.1); color: #DC2626; border: 1px solid rgba(220,38,38,0.2); }
.role-fleet_manager { background: rgba(22,163,74,0.1); color: #16A34A; border: 1px solid rgba(22,163,74,0.2); }
.role-auditor { background: rgba(139,92,246,0.1); color: #7C3AED; border: 1px solid rgba(139,92,246,0.2); }

/* ============================================================
   FOOTER - FIXED: Removed absolute positioning, added flex properties
   ============================================================ */
.sidebar-footer {
    flex-shrink: 0; /* FIX: Prevent footer from shrinking */
    margin-top: auto; /* FIX: Push footer to bottom */
    padding: var(--sp-sm);
    border-top: 2px solid var(--border-color);
    background: linear-gradient(135deg, var(--sidebar-bg-start), var(--sidebar-bg-end) 100%);
    transition: background 0.5s ease, border-color 0.5s ease;

    /* REMOVED: position: absolute, bottom: 0, left: 0, right: 0 */
}

/* ============================================================
   RIPPLE EFFECT
   ============================================================ */
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(220, 38, 38, 0.2);
    transform: scale(0);
    animation: rippleEffect 0.6s ease-out;
    pointer-events: none;
}

@keyframes rippleEffect {
    to { transform: scale(4); opacity: 0; }
}

/* ============================================================
   TOOLTIP FOR MINIMIZED SIDEBAR
   ============================================================ */
.admin-sidebar .nav-link::after {
    content: attr(data-title);
    position: absolute;
    left: calc(100% + 12px);
    top: 50%;
    transform: translateY(-50%) scale(0.9);
    background: #1A1A1A;
    color: white;
    padding: var(--sp-sm) var(--sp-md);
    border-radius: 14px;
    font-size: var(--font-sm);
    font-weight: 600;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: all 0.2s;
}

.admin-sidebar .nav-link:hover::after {
    opacity: 1;
    transform: translateY(-50%) scale(1);
}

/* Hide tooltip when expanded */
.admin-sidebar:not(.collapsed) .nav-link::after {
    display: none;
}

/* ============================================================
   HAMBURGER MENU BUTTON - Mobile Only
   ============================================================ */
.hamburger-btn {
    display: none; /* Hidden by default on desktop */
    position: fixed;
    top: 10px;
    left: 10px;
    z-index: 1060;
    background: linear-gradient(135deg, var(--sidebar-bg-start), var(--sidebar-bg-end) 100%);
    border: 2px solid var(--border-color);
    color: var(--text-color);
    width: 44px;
    height: 44px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), background 0.5s ease, border-color 0.5s ease;
    display: none;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 4px;
    padding: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.hamburger-btn:hover {
    transform: scale(1.05);
    border-color: var(--hover-color);
}

.hamburger-btn .bar {
    display: block;
    width: 22px;
    height: 2.5px;
    background: var(--text-color);
    border-radius: 4px;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform-origin: center;
}

.hamburger-btn.active .bar:nth-child(1) {
    transform: rotate(45deg) translate(4px, 4px);
}

.hamburger-btn.active .bar:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
}

.hamburger-btn.active .bar:nth-child(3) {
    transform: rotate(-45deg) translate(5px, -5px);
}

/* ============================================================
   QUICK SEARCH INDICATOR
   ============================================================ */
.quick-search-indicator {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background: #1F2937;
    color: #F9FAFB;
    padding: var(--sp-sm) var(--sp-md);
    border-radius: 40px;
    font-size: var(--font-sm);
    font-weight: 600;
    font-family: monospace;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    z-index: 1100;
    backdrop-filter: blur(4px);
    background-color: rgba(31,41,55,0.9);
    border-left: 4px solid var(--hover-color);
    transition: opacity 0.2s ease, border-color 0.5s ease;
    pointer-events: none;
    white-space: nowrap;
}

/* ============================================================
   THEME TRANSITIONS - All sidebar elements
   ============================================================ */
.admin-sidebar,
.sidebar-header,
.sidebar-footer,
.nav-link,
.sidebar-brand,
.user-info .text-dark,
.user-info .text-secondary,
.avatar-sm,
.toggle-sidebar-btn,
.role-badge {
    transition: background 0.5s ease, color 0.5s ease, border-color 0.5s ease, box-shadow 0.5s ease;
}

/* ============================================================
   RESPONSIVE - DEEPSEEK STYLE WITH HAMBURGER
   ============================================================ */

/* --- Tablets & Small Desktops (769px - 992px) --- */
@media (min-width: 769px) and (max-width: 992px) {
    :root {
        --sidebar-width-collapsed: 0px;
        --sidebar-width-expanded: 300px;
    }

    /* Show hamburger on tablet */
    .hamburger-btn {
        display: flex !important;
    }

    .admin-sidebar {
        transform: translateX(-100%);
        position: fixed;
        z-index: 1050;
        width: var(--sidebar-width-expanded) !important;
        display: flex;
        flex-direction: column;
        top: 0;
        left: 0;
        height: 100vh;
    }

    .admin-sidebar.open {
        transform: translateX(0);
        box-shadow: 8px 0 40px rgba(0, 0, 0, 0.15);
    }

    .admin-sidebar .nav-link {
        font-size: var(--font-base);
        padding: var(--sp-lg) var(--sp-xl);
        justify-content: flex-start;
        min-height: 52px;
    }

    .admin-sidebar .sidebar-brand span,
    .admin-sidebar .user-info,
    .admin-sidebar .role-badge,
    .admin-sidebar .nav-link span {
        opacity: 1;
        transform: translateX(0);
        pointer-events: auto;
        display: inline-block;
    }

    .admin-sidebar .nav-link svg {
        margin-right: var(--sp-md);
        width: 26px;
        height: 26px;
    }

    .admin-sidebar .sidebar-brand {
        justify-content: flex-start;
    }

    .admin-sidebar .sidebar-header {
        text-align: left;
        padding: var(--sp-xl) var(--sp-xl);
    }

    .admin-sidebar .toggle-sidebar-btn {
        right: var(--sp-md);
        transform: translateY(-50%);
    }

    .admin-sidebar .nav-link::after {
        display: none !important;
    }
}

/* --- Mobile Devices (≤ 768px) --- */
@media (max-width: 768px) {
    :root {
        --sidebar-width-expanded: 280px;
        --font-xs: 0.7rem;
        --font-sm: 0.8rem;
        --font-base: 0.9rem;
        --font-md: 1rem;
        --font-lg: 1.1rem;
        --font-xl: 1.2rem;
        --font-xxl: 1.4rem;

        --sp-xs: 0.2rem;
        --sp-sm: 0.4rem;
        --sp-md: 0.8rem;
        --sp-lg: 1.2rem;
        --sp-xl: 1.5rem;
    }

    /* Show hamburger on mobile */
    .hamburger-btn {
        display: flex !important;
        width: 40px;
        height: 40px;
        top: 8px;
        left: 8px;
        padding: 8px;
        border-radius: 10px;
    }

    .hamburger-btn .bar {
        width: 20px;
        height: 2px;
    }

    .admin-sidebar {
        transform: translateX(-100%);
        position: fixed;
        z-index: 1050;
        width: var(--sidebar-width-expanded) !important;
        display: flex;
        flex-direction: column;
        top: 0;
        left: 0;
        height: 100vh;
    }

    .admin-sidebar.open {
        transform: translateX(0);
        box-shadow: 8px 0 40px rgba(0, 0, 0, 0.15);
    }

    .admin-sidebar .nav-link {
        font-size: var(--font-sm);
        padding: var(--sp-md) var(--sp-lg);
        justify-content: flex-start;
        min-height: 48px;
    }

    .admin-sidebar .sidebar-brand span,
    .admin-sidebar .user-info,
    .admin-sidebar .role-badge,
    .admin-sidebar .nav-link span {
        opacity: 1;
        transform: translateX(0);
        pointer-events: auto;
        display: inline-block;
    }

    .admin-sidebar .nav-link svg {
        margin-right: var(--sp-sm);
        width: 24px;
        height: 24px;
    }

    .admin-sidebar .sidebar-brand {
        justify-content: flex-start;
        font-size: var(--font-md);
    }

    .admin-sidebar .sidebar-header {
        text-align: left;
        padding: var(--sp-md) var(--sp-lg);
        flex-shrink: 0;
    }

    .admin-sidebar .toggle-sidebar-btn {
        right: var(--sp-sm);
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        min-width: 36px;
        min-height: 36px;
        border-radius: 10px;
    }

    .admin-sidebar .toggle-sidebar-btn svg {
        width: 16px;
        height: 16px;
    }

    .admin-sidebar .nav-link::after {
        display: none !important;
    }

    .avatar-sm {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        border-width: 2px;
    }

    .user-info .text-dark {
        font-size: var(--font-sm);
    }

    .user-info .text-secondary {
        font-size: var(--font-xs);
    }

    .role-badge {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
    }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: var(--sp-md) 12px;
    }

    .nav-item {
        margin-bottom: var(--sp-xs);
    }

    .sidebar-footer {
        flex-shrink: 0;
        margin-top: auto;
        padding: var(--sp-xs);
    }

    .quick-search-indicator {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        bottom: 12px;
        left: 12px;
    }

    .admin-sidebar .nav-link.active {
        background: rgba(255,255,255,0.1);
    }
}

/* --- Small Phones (≤ 576px) --- */
@media (max-width: 576px) {
    :root {
        --sidebar-width-expanded: 260px;
        --font-xs: 0.65rem;
        --font-sm: 0.75rem;
        --font-base: 0.85rem;
        --font-md: 0.95rem;
        --font-lg: 1.05rem;
        --font-xl: 1.15rem;
        --font-xxl: 1.3rem;

        --sp-xs: 0.15rem;
        --sp-sm: 0.3rem;
        --sp-md: 0.6rem;
        --sp-lg: 1rem;
        --sp-xl: 1.2rem;
    }

    .hamburger-btn {
        width: 36px;
        height: 36px;
        top: 6px;
        left: 6px;
        padding: 6px;
        border-radius: 8px;
    }

    .hamburger-btn .bar {
        width: 18px;
        height: 2px;
    }

    .admin-sidebar {
        width: var(--sidebar-width-expanded) !important;
        display: flex;
        flex-direction: column;
    }

    .admin-sidebar .nav-link {
        font-size: var(--font-xs);
        padding: var(--sp-sm) var(--sp-md);
        min-height: 42px;
        border-radius: 14px;
    }

    .admin-sidebar .nav-link svg {
        width: 20px;
        height: 20px;
        margin-right: var(--sp-xs);
    }

    .admin-sidebar .sidebar-brand {
        font-size: var(--font-sm);
    }

    .admin-sidebar .sidebar-brand svg {
        width: 26px;
        height: 26px;
    }

    .admin-sidebar .sidebar-header {
        padding: var(--sp-sm) var(--sp-md);
        flex-shrink: 0;
    }

    .admin-sidebar .toggle-sidebar-btn {
        width: 30px;
        height: 30px;
        min-width: 30px;
        min-height: 30px;
        border-radius: 8px;
        border-width: 1.5px;
    }

    .admin-sidebar .toggle-sidebar-btn svg {
        width: 14px;
        height: 14px;
    }

    .avatar-sm {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border-width: 2px;
    }

    .user-info .text-dark {
        font-size: var(--font-xs);
    }

    .user-info .text-secondary {
        font-size: 0.55rem;
    }

    .role-badge {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
    }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: var(--sp-sm) 10px;
    }

    .sidebar-footer {
        flex-shrink: 0;
        margin-top: auto;
        padding: var(--sp-xs);
    }

    .quick-search-indicator {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        bottom: 8px;
        left: 8px;
        border-left-width: 3px;
    }
}

/* --- Very Small Phones (≤ 400px) --- */
@media (max-width: 400px) {
    :root {
        --sidebar-width-expanded: 240px;
        --font-xs: 0.6rem;
        --font-sm: 0.7rem;
        --font-base: 0.8rem;
        --font-md: 0.9rem;
        --font-lg: 1rem;
        --font-xl: 1.1rem;
        --font-xxl: 1.2rem;

        --sp-xs: 0.1rem;
        --sp-sm: 0.25rem;
        --sp-md: 0.5rem;
        --sp-lg: 0.8rem;
        --sp-xl: 1rem;
    }

    .hamburger-btn {
        width: 32px;
        height: 32px;
        top: 4px;
        left: 4px;
        padding: 5px;
        border-radius: 6px;
    }

    .hamburger-btn .bar {
        width: 16px;
        height: 1.8px;
    }

    .admin-sidebar {
        width: var(--sidebar-width-expanded) !important;
        display: flex;
        flex-direction: column;
    }

    .admin-sidebar .nav-link {
        font-size: 0.55rem;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 36px;
        border-radius: 10px;
    }

    .admin-sidebar .nav-link svg {
        width: 18px;
        height: 18px;
    }

    .admin-sidebar .sidebar-brand {
        font-size: 0.65rem;
    }

    .admin-sidebar .sidebar-brand svg {
        width: 22px;
        height: 22px;
    }

    .admin-sidebar .sidebar-header {
        padding: var(--sp-xs) var(--sp-sm);
        flex-shrink: 0;
    }

    .admin-sidebar .toggle-sidebar-btn {
        width: 26px;
        height: 26px;
        min-width: 26px;
        min-height: 26px;
        border-radius: 6px;
    }

    .admin-sidebar .toggle-sidebar-btn svg {
        width: 12px;
        height: 12px;
    }

    .avatar-sm {
        width: 30px;
        height: 30px;
        border-radius: 8px;
    }

    .role-badge {
        font-size: 0.45rem;
        padding: 0.05rem var(--sp-xs);
    }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: var(--sp-xs) 8px;
    }

    .sidebar-footer {
        flex-shrink: 0;
        margin-top: auto;
        padding: var(--sp-xs);
    }

    .quick-search-indicator {
        font-size: 0.45rem;
        padding: 0.05rem var(--sp-xs);
        bottom: 6px;
        left: 6px;
    }
}

/* --- Extra Small (≤ 350px) --- */
@media (max-width: 350px) {
    :root {
        --sidebar-width-expanded: 220px;
        --font-xs: 0.5rem;
        --font-sm: 0.6rem;
        --font-base: 0.7rem;
        --font-md: 0.8rem;
        --font-lg: 0.9rem;
        --font-xl: 1rem;
        --font-xxl: 1.1rem;

        --sp-xs: 0.05rem;
        --sp-sm: 0.2rem;
        --sp-md: 0.4rem;
        --sp-lg: 0.6rem;
        --sp-xl: 0.8rem;
    }

    .hamburger-btn {
        width: 28px;
        height: 28px;
        top: 3px;
        left: 3px;
        padding: 4px;
        border-radius: 5px;
    }

    .hamburger-btn .bar {
        width: 14px;
        height: 1.5px;
    }

    .admin-sidebar {
        width: var(--sidebar-width-expanded) !important;
        display: flex;
        flex-direction: column;
    }

    .admin-sidebar .nav-link {
        font-size: 0.45rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 30px;
        border-radius: 8px;
    }

    .admin-sidebar .nav-link svg {
        width: 16px;
        height: 16px;
    }

    .admin-sidebar .sidebar-brand {
        font-size: 0.55rem;
    }

    .admin-sidebar .sidebar-brand svg {
        width: 18px;
        height: 18px;
    }

    .admin-sidebar .toggle-sidebar-btn {
        width: 22px;
        height: 22px;
        min-width: 22px;
        min-height: 22px;
        border-radius: 4px;
    }

    .admin-sidebar .toggle-sidebar-btn svg {
        width: 10px;
        height: 10px;
    }

    .avatar-sm {
        width: 24px;
        height: 24px;
        border-radius: 6px;
    }

    .user-info .text-dark {
        font-size: 0.45rem;
    }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: var(--sp-xs) 6px;
    }

    .sidebar-footer {
        flex-shrink: 0;
        margin-top: auto;
        padding: var(--sp-xs);
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

<aside class="admin-sidebar collapsed" id="adminSidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <!-- SVG Cube icon -->
            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16.008V7.992a1 1 0 0 0-.5-.866l-8-4.632a1 1 0 0 0-1 0l-8 4.632a1 1 0 0 0-.5.866v8.016a1 1 0 0 0 .5.866l8 4.632a1 1 0 0 0 1 0l8-4.632a1 1 0 0 0 .5-.866Z"/>
                <path d="M12 12 3.5 7.5"/>
                <path d="M12 12v9.5"/>
                <path d="M12 12 20.5 7.5"/>
                <path d="M12 2.5v9.5"/>
            </svg>
            <span>SureCargo</span>
        </div>
        <button class="toggle-sidebar-btn" id="toggleSidebarBtn" aria-label="Toggle sidebar">
            <!-- SVG Chevron (will be swapped via JS) -->
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </button>
    </div>

    <ul class="sidebar-nav">
        {{-- DASHBOARD – accessible to super_admin and fleet_manager --}}
        @if(in_array($admin->role, ['super_admin', 'fleet_manager']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" data-title="Dashboard">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18" />
                    <path d="M7 15v-4" />
                    <path d="M12 15v-6" />
                    <path d="M17 15v-2" />
                </svg>
                <span>Dashboard</span>
            </a>
        </li>
        @endif

        {{-- USER REQUESTS – only super_admin --}}
        @if(in_array($admin->role, ['super_admin']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.user-requests.*') ? 'active' : '' }}" href="{{ route('admin.user-requests.index') }}" data-title="User Requests">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M3 12h4" />
                    <path d="M13 12h4" />
                    <path d="M8 16h2" />
                </svg>
                <span>User Requests</span>
            </a>
        </li>
        @endif

        {{-- MANAGE USERS – only super_admin --}}
        @if(in_array($admin->role, ['super_admin']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}" data-title="Manage Users">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                <span>Users</span>
            </a>
        </li>
        @endif

        {{-- MANAGE ADMINS – only super_admin --}}
        @if(in_array($admin->role, ['super_admin']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}" href="{{ route('admin.admins.index') }}" data-title="Manage Admins">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    <path d="M12 8v4" />
                    <path d="M12 16h.01" />
                </svg>
                <span>Admins</span>
            </a>
        </li>
        @endif

        {{-- MANAGE BOOKINGS – super_admin and fleet_manager --}}
        @if(in_array($admin->role, ['super_admin', 'fleet_manager']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}" data-title="Manage Bookings">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                    <path d="M17 21v-4H7v4" />
                    <path d="M7 3v4h10V3" />
                </svg>
                <span>Bookings</span>
            </a>
        </li>
        @endif

        {{-- MANAGE TRUCKS – super_admin and fleet_manager --}}
        @if(in_array($admin->role, ['super_admin', 'fleet_manager']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.trucks.*') ? 'active' : '' }}" href="{{ route('admin.trucks.index') }}" data-title="Manage Trucks">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 3h15v13H1z" />
                    <path d="M16 8h4l3 3v5h-7V8z" />
                    <circle cx="5.5" cy="18.5" r="2.5" />
                    <circle cx="18.5" cy="18.5" r="2.5" />
                </svg>
                <span>Trucks</span>
            </a>
        </li>
        @endif

        {{-- MANAGE PAYMENTS – super_admin and fleet_manager --}}
        @if(in_array($admin->role, ['super_admin', 'fleet_manager']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}" data-title="Manage Payments">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                    <circle cx="18" cy="15" r="1" />
                </svg>
                <span>Payments</span>
            </a>
        </li>
        @endif

        {{-- MANAGE FEE – super_admin and fleet_manager --}}
        @if(in_array($admin->role, ['super_admin', 'fleet_manager']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.fee.*') ? 'active' : '' }}" href="{{ route('admin.fee.index') }}" data-title="Manage Fee">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v4" />
                    <path d="M12 18v4" />
                    <path d="M4.93 4.93l2.83 2.83" />
                    <path d="M16.24 16.24l2.83 2.83" />
                    <path d="M2 12h4" />
                    <path d="M18 12h4" />
                    <path d="M4.93 19.07l2.83-2.83" />
                    <path d="M16.24 7.76l2.83-2.83" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                <span>Fee</span>
            </a>
        </li>
        @endif

        {{-- MANAGE ROUTE – super_admin and fleet_manager --}}
        @if(in_array($admin->role, ['super_admin', 'fleet_manager']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.route.*') ? 'active' : '' }}" href="{{ route('admin.route.index') }}" data-title="Manage Route">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2c3 4 3 8 0 12-3-4-3-8 0-12z" />
                    <path d="M12 2c-3 4-3 8 0 12" />
                    <circle cx="12" cy="14" r="2" />
                    <path d="M5 22h14" />
                    <path d="M8 22v-4" />
                    <path d="M16 22v-4" />
                </svg>
                <span>Route</span>
            </a>
        </li>
        @endif

        {{-- DAMAGE REQUESTS – super_admin and fleet_manager --}}
        @if(in_array($admin->role, ['super_admin', 'fleet_manager']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.damage-requests.*') ? 'active' : '' }}" href="{{ route('admin.damage-requests.index') }}" data-title="Damage Requests">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                    <path d="M12 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                    <path d="M12 14v3"/>
                </svg>
                <span>Damage Request</span>
            </a>
        </li>
        @endif

        {{-- ANNOUNCEMENTS – super_admin and fleet_manager --}}
        @if(in_array($admin->role, ['super_admin', 'fleet_manager']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}" data-title="Announcements">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2C8 6 6 10 6 14c0 3.314 2.686 6 6 6s6-2.686 6-6c0-4-2-8-6-12z"/>
                    <path d="M12 10v4M12 14v2"/>
                    <circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"/>
                </svg>
                <span>Announcements</span>
            </a>
        </li>
        @endif
    </ul>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-3">
            <img src="https://ui-avatars.com/api/?background=DC2626&color=fff&bold=true&name={{ urlencode($admin->name ?? 'Admin') }}"
                 class="avatar-sm" alt="Admin Avatar">
            <div class="user-info flex-grow-1">
                <div class="text-dark fw-semibold">{{ $admin->name ?? 'Admin User' }}</div>
                <div class="text-secondary">{{ $admin->email ?? 'admin@surecargo.com' }}</div>
                <span class="role-badge role-{{ $admin->role ?? 'fleet_manager' }} mt-1 d-inline-flex">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="M12 8v4"/>
                        <path d="M12 16h.01"/>
                    </svg>
                    {{ ucfirst(str_replace('_', ' ', $admin->role ?? 'Admin')) }}
                </span>
            </div>
        </div>
    </div>
</aside>

<!-- Hamburger Menu Button -->
<button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle menu">
    <span class="bar"></span>
    <span class="bar"></span>
    <span class="bar"></span>
</button>

<script nonce="{{ $csp_nonce }}">
    (function() {
        'use strict';

        // ================================================================
        // CLICK SOUND - Using HTML5 Audio for guaranteed playback
        // ================================================================
        var audioElement = null;
        var audioLoaded = false;

        function initAudio() {
            if (audioLoaded) return;
            try {
                audioElement = new Audio('/audio/click.mp3');
                audioElement.preload = 'auto';
                audioElement.volume = 0.6;

                audioElement.addEventListener('canplaythrough', function() {
                    audioLoaded = true;
                    window.sidebarAudio = audioElement;
                }, { once: true });

                audioElement.addEventListener('error', function(e) {
                    console.warn('Audio file not found, using fallback beep');
                    audioLoaded = true;
                }, { once: true });

                audioElement.load();
            } catch (e) {
                console.warn('Audio not supported, using fallback');
                audioLoaded = true;
            }
        }

        function playClickSound() {
            try {
                if (audioElement && audioLoaded) {
                    audioElement.currentTime = 0;
                    var playPromise = audioElement.play();
                    if (playPromise !== undefined) {
                        playPromise.catch(function(error) {
                            playFallbackSound();
                        });
                    }
                } else {
                    playFallbackSound();
                }
            } catch (e) {
                // Silently fail
            }
        }

        function playFallbackSound() {
            try {
                var ctx = new (window.AudioContext || window.webkitAudioContext)();
                var oscillator = ctx.createOscillator();
                var gainNode = ctx.createGain();

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
        }

        // ================================================================
        // SIDEBAR FUNCTIONALITY
        // ================================================================
        var sidebarEl = document.getElementById('adminSidebar');
        var toggleBtn = document.getElementById('toggleSidebarBtn');
        var toggleIconSvg = toggleBtn ? toggleBtn.querySelector('svg') : null;
        var hamburgerBtn = document.getElementById('hamburgerBtn');

        var VERSION_KEY = 'sidebar_version_v3_min80';
        var COLLAPSED_KEY = 'sidebarCollapsed';

        var isCollapsed;

        if (!localStorage.getItem(VERSION_KEY)) {
            localStorage.setItem(VERSION_KEY, '3');
            localStorage.setItem(COLLAPSED_KEY, 'true');
            isCollapsed = true;
        } else {
            var saved = localStorage.getItem(COLLAPSED_KEY);
            isCollapsed = (saved === 'true');
        }

        function updateChevronIcon(isRight) {
            if (!toggleIconSvg) return;
            var oldPath = toggleIconSvg.querySelector('path');
            if (oldPath) oldPath.remove();
            var newPath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            if (isRight) {
                newPath.setAttribute('d', 'm9 18 6-6-6-6');
            } else {
                newPath.setAttribute('d', 'm15 18-6-6 6-6');
            }
            toggleIconSvg.appendChild(newPath);
        }

        if (isCollapsed) {
            sidebarEl.classList.add('collapsed');
            updateChevronIcon(true);
        } else {
            sidebarEl.classList.remove('collapsed');
            updateChevronIcon(false);
        }

        function ensureAudioInit() {
            if (!audioLoaded) {
                initAudio();
            }
        }

        // ================================================================
        // TOGGLE SIDEBAR (Desktop expand/collapse)
        // ================================================================
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                ensureAudioInit();
                playClickSound();

                var wasCollapsed = sidebarEl.classList.contains('collapsed');
                if (wasCollapsed) {
                    sidebarEl.classList.remove('collapsed');
                    updateChevronIcon(false);
                    localStorage.setItem(COLLAPSED_KEY, 'false');
                } else {
                    sidebarEl.classList.add('collapsed');
                    updateChevronIcon(true);
                    localStorage.setItem(COLLAPSED_KEY, 'true');
                }
            });
        }

        // ================================================================
        // HAMBURGER MENU (Mobile toggle)
        // ================================================================
        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                ensureAudioInit();
                playClickSound();

                // Toggle sidebar open class
                sidebarEl.classList.toggle('open');

                // Toggle hamburger active state
                this.classList.toggle('active');

                // Update overlay
                overlay.style.opacity = sidebarEl.classList.contains('open') ? '1' : '0';
                overlay.style.pointerEvents = sidebarEl.classList.contains('open') ? 'auto' : 'none';

                // Close sidebar when clicking outside
                if (sidebarEl.classList.contains('open')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
        }

        // ================================================================
        // RIPPLE EFFECT + CLICK SOUND ON NAV LINKS
        // ================================================================
        var navLinks = document.querySelectorAll('.nav-link');
        for (var i = 0; i < navLinks.length; i++) {
            (function(link) {
                link.addEventListener('click', function(e) {
                    ensureAudioInit();
                    playClickSound();

                    // Ripple
                    var rect = this.getBoundingClientRect();
                    var ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    var size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
                    ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
                    this.appendChild(ripple);
                    setTimeout(function() {
                        if (ripple.parentNode) ripple.remove();
                    }, 600);

                    // Close sidebar on mobile after navigation
                    if (window.innerWidth <= 992) {
                        sidebarEl.classList.remove('open');
                        if (hamburgerBtn) hamburgerBtn.classList.remove('active');
                        overlay.style.opacity = '0';
                        overlay.style.pointerEvents = 'none';
                        document.body.style.overflow = '';
                    }
                });
            })(navLinks[i]);
        }

        // ================================================================
        // MOBILE OVERLAY
        // ================================================================
        var overlay = document.querySelector('.sidebar-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);z-index:1040;opacity:0;pointer-events:none;transition:opacity 0.3s ease;';
            document.body.appendChild(overlay);
        }

        overlay.addEventListener('click', function() {
            sidebarEl.classList.remove('open');
            if (hamburgerBtn) hamburgerBtn.classList.remove('active');
            overlay.style.opacity = '0';
            overlay.style.pointerEvents = 'none';
            document.body.style.overflow = '';
        });

        // ================================================================
        // KEYBOARD SHORTCUTS
        // ================================================================
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                if (toggleBtn) toggleBtn.click();
            }
            if (e.key === 'Escape' && sidebarEl.classList.contains('open')) {
                sidebarEl.classList.remove('open');
                if (hamburgerBtn) hamburgerBtn.classList.remove('active');
                overlay.style.opacity = '0';
                overlay.style.pointerEvents = 'none';
                document.body.style.overflow = '';
            }
        });

        // ================================================================
        // QUICK SEARCH
        // ================================================================
        (function() {
            var searchQuery = '';
            var resetTimer = null;
            var RESET_DELAY = 2000;

            var indicator = document.createElement('div');
            indicator.className = 'quick-search-indicator';
            indicator.style.opacity = '0';
            document.body.appendChild(indicator);

            function showIndicator(text) {
                indicator.textContent = '🔍 ' + text;
                indicator.style.opacity = '1';
            }

            function hideIndicator() {
                indicator.style.opacity = '0';
            }

            function resetSearch() {
                searchQuery = '';
                if (resetTimer) clearTimeout(resetTimer);
                hideIndicator();
            }

            function performSearch() {
                if (!searchQuery.trim()) return;
                var navLinks = document.querySelectorAll('.sidebar-nav .nav-link');
                var matchedLink = null;
                for (var i = 0; i < navLinks.length; i++) {
                    var link = navLinks[i];
                    var span = link.querySelector('span');
                    if (!span) continue;
                    var text = span.innerText.trim().toLowerCase();
                    if (text.indexOf(searchQuery.toLowerCase()) !== -1) {
                        matchedLink = link;
                        break;
                    }
                }
                if (matchedLink) {
                    ensureAudioInit();
                    playClickSound();

                    matchedLink.click();
                    matchedLink.style.transition = 'all 0.1s';
                    matchedLink.style.backgroundColor = 'rgba(220,38,38,0.2)';
                    setTimeout(function() {
                        matchedLink.style.backgroundColor = '';
                    }, 200);
                } else {
                    var originalBg = indicator.style.backgroundColor;
                    indicator.style.backgroundColor = '#DC2626';
                    setTimeout(function() {
                        indicator.style.backgroundColor = '';
                    }, 300);
                }
                resetSearch();
            }

            document.addEventListener('keydown', function(e) {
                var tag = e.target.tagName;
                if (tag === 'INPUT' || tag === 'TEXTAREA' || e.target.isContentEditable) return;
                if (e.key === 'Enter' && searchQuery.length > 0) {
                    e.preventDefault();
                    performSearch();
                    return;
                }
                if (e.key === 'Escape') {
                    if (searchQuery.length > 0) {
                        e.preventDefault();
                        resetSearch();
                    }
                    return;
                }
                if (e.key.length === 1 && /[a-zA-Z0-9]/i.test(e.key)) {
                    if (e.ctrlKey || e.altKey || e.metaKey) return;
                    e.preventDefault();
                    searchQuery += e.key;
                    showIndicator(searchQuery);
                    if (resetTimer) clearTimeout(resetTimer);
                    resetTimer = setTimeout(function() { resetSearch(); }, RESET_DELAY);
                }
            });

            document.addEventListener('click', function() {
                if (searchQuery) resetSearch();
            });
        })();

        // ================================================================
        // CLICK SOUND - Safety trigger
        // ================================================================
        sidebarEl.addEventListener('click', function(e) {
            if (e.target.closest && (e.target.closest('.nav-link') || e.target.closest('#toggleSidebarBtn'))) {
                return;
            }
            ensureAudioInit();
            playClickSound();
        });

        // ================================================================
        // INITIALIZE AUDIO
        // ================================================================
        var firstInteraction = function() {
            ensureAudioInit();
            document.removeEventListener('click', firstInteraction);
            document.removeEventListener('keydown', firstInteraction);
            document.removeEventListener('touchstart', firstInteraction);
        };
        document.addEventListener('click', firstInteraction);
        document.addEventListener('keydown', firstInteraction);
        document.addEventListener('touchstart', firstInteraction);

        setTimeout(function() {
            initAudio();
        }, 100);

        window.playClickSound = playClickSound;

        // ================================================================
        // HANDLE WINDOW RESIZE - Close mobile menu on resize to desktop
        // ================================================================
        var resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 992 && sidebarEl.classList.contains('open')) {
                    sidebarEl.classList.remove('open');
                    if (hamburgerBtn) hamburgerBtn.classList.remove('active');
                    overlay.style.opacity = '0';
                    overlay.style.pointerEvents = 'none';
                    document.body.style.overflow = '';
                }
            }, 250);
        });

    })();
</script>

