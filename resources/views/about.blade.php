<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SureCargo | About – Intelligent Logistics Platform</title>
    <link rel="icon" type="image/jpeg" href="/assets/white.jpg">

    <!-- Fonts & Libraries -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <style nonce="{{ $csp_nonce }}">
 /* ============================================================
   ABOUT PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES (FIXED)
   ============================================================ */

:root {
    --primary-color: #2d7aff;
    --primary-dark: #1a5fd9;
    --primary-light: #eef4ff;
    --text-dark: #0a2540;
    --text-body: #1e293b;
    --text-muted: #475569;
    --bg-light: #f2f4f8;
    --white: #ffffff;
    --border-light: #eef2ff;

    /* DEEPSEEK-STYLE FONT SIZES */
    --font-xs: 0.75rem;
    --font-sm: 0.875rem;
    --font-base: 1rem;
    --font-md: 1.125rem;
    --font-lg: 1.25rem;
    --font-xl: 1.5rem;
    --font-xxl: 1.75rem;
    --font-xxxl: 2.25rem;
    --font-xxxxl: 3rem;

    --sp-xs: 0.25rem;
    --sp-sm: 0.5rem;
    --sp-md: 1rem;
    --sp-lg: 1.5rem;
    --sp-xl: 2rem;
    --sp-xxl: 3rem;
}

/* ============================================================
   RESET & GLOBAL - FIXED FOR MOBILE
   ============================================================ */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    font-size: 16px;
    -webkit-text-size-adjust: 100%;
    overflow-x: hidden !important;
    width: 100% !important;
    max-width: 100% !important;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    font-size: var(--font-base);
    font-weight: 400;
    line-height: 1.6;
    color: var(--text-body);
    background-color: var(--bg-light);
    position: relative;
    overflow-x: hidden !important;
    width: 100% !important;
    max-width: 100% !important;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Background Image with overlay - FIXED FOR MOBILE */
body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('{{ asset("assets/background.jpg") }}');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    filter: brightness(0.92) contrast(1.02);
    z-index: -2;
}

body::after {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.88);
    z-index: -1;
}

/* ============================================================
   TYPOGRAPHY - DEEPSEEK STYLE (No clamp() with vw)
   ============================================================ */

/* Body text */
p, li, .text-content, .card-flat p, .list-unstyled li, .footer p, .footer li {
    font-size: var(--font-base);
    line-height: 1.7;
    color: var(--text-body);
    font-weight: 400;
}

.lead {
    font-size: var(--font-md);
    font-weight: 400;
    color: var(--text-muted);
    line-height: 1.7;
}

/* Headings */
h1, h2, h3, h4, .display-heading {
    font-weight: 800;
    letter-spacing: -0.02em;
    color: var(--text-dark);
    line-height: 1.2;
}

h1 {
    font-size: var(--font-xxxxl);
    margin-bottom: var(--sp-md);
}

h2 {
    font-size: var(--font-xxl);
    margin-bottom: var(--sp-md);
    position: relative;
}

h2:after {
    content: '';
    display: block;
    width: 80px;
    height: 5px;
    background: var(--primary-color);
    border-radius: 6px;
    margin-top: var(--sp-sm);
}

.text-center h2:after {
    margin-left: auto;
    margin-right: auto;
}

h3 {
    font-size: var(--font-xl);
}

h4 {
    font-size: var(--font-lg);
}

h5 {
    font-size: var(--font-md);
}

h6 {
    font-size: var(--font-base);
}

/* Badges, small texts */
.badge-soft, .tech-badge, .small-text, small, .footer .small, .small {
    font-size: var(--font-sm) !important;
    font-weight: 500;
}

/* ============================================================
   CONTAINER - FIXED FOR MOBILE
   ============================================================ */
.container, .container-lg {
    max-width: 1280px;
    padding-left: var(--sp-lg);
    padding-right: var(--sp-lg);
    margin: 0 auto;
    overflow-x: hidden !important;
}

/* ============================================================
   NAVBAR - MOBILE FIRST - FIXED
   ============================================================ */
.navbar {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.03);
    padding: var(--sp-sm) var(--sp-md);
    border-bottom: 1px solid var(--border-light);
    position: sticky;
    top: 0;
    z-index: 1000;
    width: 100% !important;
    max-width: 100% !important;
    overflow: hidden !important;
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    flex-wrap: wrap;
    max-width: 1280px;
    margin: 0 auto;
    overflow: hidden !important;
}

.logo {
    font-size: var(--font-xl);
    font-weight: 800;
    text-decoration: none;
    color: var(--text-dark);
    letter-spacing: -0.02em;
}

.logo span {
    color: var(--primary-color);
}

.menu-icon {
    display: block;
    font-size: var(--font-xl);
    cursor: pointer;
    color: var(--text-dark);
    background: none;
    border: none;
    padding: var(--sp-xs) var(--sp-sm);
    touch-action: manipulation;
    min-height: 44px;
    min-width: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-links {
    display: none;
    flex-direction: column;
    width: 100%;
    background: var(--white);
    border-radius: 28px;
    padding: var(--sp-md);
    margin-top: var(--sp-sm);
    gap: var(--sp-xs);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--border-light);
}

.nav-links.show {
    display: flex;
}

.nav-links a {
    text-decoration: none;
    font-weight: 500;
    color: var(--text-body);
    font-size: var(--font-base);
    padding: var(--sp-sm) var(--sp-md);
    transition: all 0.2s ease;
    border-radius: 40px;
    text-align: center;
    cursor: pointer;
    touch-action: manipulation;
    min-height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-links a:hover {
    color: var(--primary-color);
    background: var(--primary-light);
}

.nav-links .btn-outline-light-custom,
.nav-links .btn-primary-custom {
    width: 100%;
    text-align: center;
    margin-top: var(--sp-xs);
    padding: var(--sp-sm) var(--sp-md);
    font-size: var(--font-base);
    cursor: pointer;
    touch-action: manipulation;
    min-height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-outline-light-custom {
    border: 1.5px solid var(--primary-color);
    background: transparent;
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 48px;
    font-weight: 600;
    color: var(--primary-color);
    font-size: var(--font-base);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
    touch-action: manipulation;
    min-height: 44px;
    gap: var(--sp-xs);
}

.btn-outline-light-custom:hover {
    background: var(--primary-color);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(45, 122, 255, 0.3);
}

.btn-primary-custom {
    background: var(--primary-color);
    border: none;
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 48px;
    font-weight: 600;
    color: var(--white);
    font-size: var(--font-base);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
    touch-action: manipulation;
    min-height: 44px;
    gap: var(--sp-xs);
}

.btn-primary-custom:hover {
    background: var(--primary-dark);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(45, 122, 255, 0.3);
}

.btn-outline-secondary {
    font-size: var(--font-base);
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 48px;
    border: 1.5px solid var(--primary-color);
    color: var(--primary-color);
    background: transparent;
    cursor: pointer;
    touch-action: manipulation;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.btn-outline-secondary:hover {
    background: var(--primary-color);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(45, 122, 255, 0.3);
}

/* ============================================================
   LAYOUT & COMPONENTS - FIXED FOR MOBILE
   ============================================================ */
.card-flat {
    background: var(--white);
    border-radius: 32px;
    padding: var(--sp-lg);
    box-shadow: 0 18px 36px rgba(0, 0, 0, 0.05);
    transition: all 0.25s ease;
    border: 1px solid var(--border-light);
    height: 100%;
    overflow: hidden !important;
}

.card-flat:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
}

.icon-blue {
    background: var(--primary-light);
    width: 72px;
    height: 72px;
    border-radius: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: var(--sp-md);
}

.icon-blue i {
    font-size: var(--font-xl);
    color: var(--primary-color);
}

.stat-number {
    font-size: var(--font-xxl);
    font-weight: 800;
    color: var(--primary-color);
    line-height: 1.2;
}

.team-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid var(--primary-color);
    margin-bottom: var(--sp-md);
    max-width: 100% !important;
}

.section-light {
    background: rgba(250, 252, 255, 0.92);
    backdrop-filter: blur(2px);
    padding: var(--sp-xxl) 0;
    overflow: hidden !important;
}

.section-white {
    background: rgba(255, 255, 255, 0.92);
    padding: var(--sp-xxl) 0;
    overflow: hidden !important;
}

.footer {
    background: rgba(248, 250, 252, 0.85);
    border-top: 1px solid var(--border-light);
    padding: var(--sp-xl) 0 var(--sp-lg);
}

.tech-badge {
    background: var(--primary-light);
    border-radius: 48px;
    padding: var(--sp-xs) var(--sp-md);
    font-weight: 500;
    display: inline-block;
    margin: var(--sp-xs);
    font-size: var(--font-sm);
}

.feature-icon-group {
    gap: var(--sp-sm);
    flex-wrap: wrap;
    margin-top: var(--sp-sm);
}

/* ============================================================
   REVEAL ANIMATIONS
   ============================================================ */
.reveal {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
}

/* ============================================================
   RESPONSIVE - DEEPSEEK STYLE (FIXED)
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
        --font-xxxxl: 2.5rem;

        --sp-xs: 0.25rem;
        --sp-sm: 0.5rem;
        --sp-md: 0.9rem;
        --sp-lg: 1.3rem;
        --sp-xl: 1.7rem;
        --sp-xxl: 2.5rem;
    }

    .container, .container-lg {
        padding-left: var(--sp-lg);
        padding-right: var(--sp-lg);
    }

    .team-img {
        width: 100px;
        height: 100px;
    }
}

/* --- Desktop (≥ 1025px) --- */
@media (min-width: 1025px) {
    .menu-icon {
        display: none !important;
    }

    .nav-links {
        display: flex !important;
        flex-direction: row;
        width: auto;
        background: transparent;
        border: none;
        box-shadow: none;
        padding: 0;
        margin-top: 0;
        gap: var(--sp-sm);
        align-items: center;
        flex-wrap: wrap;
    }

    .nav-links a {
        padding: var(--sp-xs) var(--sp-md);
        text-align: left;
        background: transparent;
        border-radius: 0;
        min-height: auto;
    }

    .nav-links a:hover {
        background: transparent;
    }

    .nav-links .btn-outline-light-custom,
    .nav-links .btn-primary-custom {
        width: auto;
        margin-top: 0;
        padding: var(--sp-sm) var(--sp-lg);
        min-height: 40px;
    }
}

/* --- Mobile Devices (≤ 768px) - FIXED --- */
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
        --font-xxxxl: 2rem;

        --sp-xs: 0.2rem;
        --sp-sm: 0.4rem;
        --sp-md: 0.8rem;
        --sp-lg: 1.2rem;
        --sp-xl: 1.5rem;
        --sp-xxl: 2rem;
    }

    body::before {
        background-attachment: scroll !important;
        position: absolute !important;
    }

    body::after {
        position: absolute !important;
    }

    .navbar {
        padding: var(--sp-sm) var(--sp-md);
        width: 100% !important;
    }

    .logo {
        font-size: var(--font-lg);
    }

    .nav-links {
        border-radius: 20px;
        padding: var(--sp-sm);
    }

    .nav-links a {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 38px;
    }

    .container, .container-lg {
        padding-left: 15px !important;
        padding-right: 15px !important;
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }

    .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .col-md-4, .col-md-6, .col-lg-3, .col-md-3, .col-sm-6 {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    .card-flat {
        padding: var(--sp-md);
        border-radius: 24px;
    }

    .icon-blue {
        width: 56px;
        height: 56px;
        border-radius: 40px;
    }

    .icon-blue i {
        font-size: var(--font-lg);
    }

    .stat-number {
        font-size: var(--font-xl);
    }

    .team-img {
        width: 80px;
        height: 80px;
        border-width: 3px;
    }

    .section-light,
    .section-white {
        padding: var(--sp-xl) 0;
    }

    .btn-outline-light-custom,
    .btn-primary-custom,
    .btn-outline-secondary {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
    }

    .tech-badge {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
    }

    .footer {
        padding: var(--sp-lg) 0 var(--sp-md);
    }

    h1 {
        font-size: var(--font-xxxl);
    }

    h2 {
        font-size: var(--font-xl);
    }

    h2:after {
        width: 60px;
        height: 4px;
    }

    h3 {
        font-size: var(--font-lg);
    }

    h4 {
        font-size: var(--font-md);
    }

    h5 {
        font-size: var(--font-base);
    }

    p, li, .text-content, .card-flat p {
        font-size: var(--font-sm);
    }

    .lead {
        font-size: var(--font-base);
    }

    .badge-soft, .small-text, small {
        font-size: var(--font-xs) !important;
    }

    img {
        max-width: 100% !important;
        height: auto !important;
    }
}

/* --- Small Phones (≤ 480px) - FIXED --- */
@media (max-width: 480px) {
    :root {
        --font-xs: 0.65rem;
        --font-sm: 0.75rem;
        --font-base: 0.85rem;
        --font-md: 0.95rem;
        --font-lg: 1.05rem;
        --font-xl: 1.15rem;
        --font-xxl: 1.3rem;
        --font-xxxl: 1.5rem;
        --font-xxxxl: 1.8rem;

        --sp-xs: 0.15rem;
        --sp-sm: 0.3rem;
        --sp-md: 0.6rem;
        --sp-lg: 1rem;
        --sp-xl: 1.2rem;
        --sp-xxl: 1.5rem;
    }

    .navbar {
        padding: var(--sp-xs) var(--sp-sm);
    }

    .logo {
        font-size: var(--font-md);
    }

    .menu-icon {
        font-size: var(--font-md);
        min-height: 36px;
        min-width: 36px;
    }

    .nav-links {
        border-radius: 16px;
        padding: var(--sp-xs);
        gap: var(--sp-xs);
    }

    .nav-links a {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
    }

    .container, .container-lg {
        padding-left: var(--sp-sm) !important;
        padding-right: var(--sp-sm) !important;
    }

    .card-flat {
        padding: var(--sp-sm);
        border-radius: 18px;
    }

    .icon-blue {
        width: 48px;
        height: 48px;
        border-radius: 32px;
    }

    .icon-blue i {
        font-size: var(--font-base);
    }

    .stat-number {
        font-size: var(--font-lg);
    }

    .team-img {
        width: 64px;
        height: 64px;
        border-width: 2px;
    }

    .section-light,
    .section-white {
        padding: var(--sp-lg) 0;
    }

    .btn-outline-light-custom,
    .btn-primary-custom,
    .btn-outline-secondary {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 40px;
    }

    .tech-badge {
        font-size: 0.6rem;
        padding: 0.1rem var(--sp-sm);
    }

    .footer {
        padding: var(--sp-md) 0 var(--sp-sm);
    }

    h1 {
        font-size: var(--font-xxl);
    }

    h2 {
        font-size: var(--font-lg);
    }

    h2:after {
        width: 50px;
        height: 3px;
    }

    h3 {
        font-size: var(--font-md);
    }

    h4 {
        font-size: var(--font-base);
    }

    h5 {
        font-size: var(--font-sm);
    }

    p, li, .text-content, .card-flat p {
        font-size: var(--font-sm);
    }

    .lead {
        font-size: var(--font-base);
    }

    .badge-soft, .small-text, small {
        font-size: 0.6rem !important;
    }

    .row.g-4 {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .col-md-4, .col-md-6, .col-lg-3 {
        padding-left: var(--sp-xs) !important;
        padding-right: var(--sp-xs) !important;
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
        --font-xxxxl: 1.6rem;

        --sp-xs: 0.1rem;
        --sp-sm: 0.25rem;
        --sp-md: 0.5rem;
        --sp-lg: 0.8rem;
        --sp-xl: 1rem;
        --sp-xxl: 1.2rem;
    }

    .logo {
        font-size: var(--font-sm);
    }

    .menu-icon {
        font-size: var(--font-sm);
        min-height: 32px;
        min-width: 32px;
    }

    .nav-links a {
        font-size: 0.6rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
    }

    .btn-outline-light-custom,
    .btn-primary-custom,
    .btn-outline-secondary {
        font-size: 0.6rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
    }

    h1 {
        font-size: var(--font-xl);
    }

    h2 {
        font-size: var(--font-md);
    }

    h2:after {
        width: 40px;
        height: 3px;
    }

    h3 {
        font-size: var(--font-base);
    }

    h4 {
        font-size: var(--font-sm);
    }

    p, li, .text-content {
        font-size: 0.65rem;
    }

    .lead {
        font-size: var(--font-sm);
    }

    .card-flat {
        padding: var(--sp-xs);
        border-radius: 14px;
    }

    .icon-blue {
        width: 40px;
        height: 40px;
        border-radius: 28px;
    }

    .icon-blue i {
        font-size: var(--font-sm);
    }

    .stat-number {
        font-size: var(--font-md);
    }

    .team-img {
        width: 56px;
        height: 56px;
    }

    .tech-badge {
        font-size: 0.5rem;
        padding: 0.05rem var(--sp-xs);
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
        --font-xxxxl: 1.4rem;

        --sp-xs: 0.05rem;
        --sp-sm: 0.2rem;
        --sp-md: 0.4rem;
        --sp-lg: 0.6rem;
        --sp-xl: 0.8rem;
        --sp-xxl: 1rem;
    }

    .logo {
        font-size: 0.7rem;
    }

    .menu-icon {
        font-size: 0.7rem;
        min-height: 28px;
        min-width: 28px;
    }

    .nav-links a {
        font-size: 0.5rem;
        min-height: 26px;
    }

    .btn-outline-light-custom,
    .btn-primary-custom,
    .btn-outline-secondary {
        font-size: 0.5rem;
        min-height: 26px;
    }

    h1 {
        font-size: var(--font-lg);
    }

    h2 {
        font-size: var(--font-base);
    }

    .card-flat {
        padding: var(--sp-xs);
        border-radius: 10px;
    }

    .icon-blue {
        width: 32px;
        height: 32px;
        border-radius: 20px;
    }

    .icon-blue i {
        font-size: 0.6rem;
    }

    .team-img {
        width: 44px;
        height: 44px;
    }
}

/* ============================================================
   SPACING UTILITIES
   ============================================================ */
.mt-2 { margin-top: var(--sp-sm) !important; }
.mt-3 { margin-top: var(--sp-md) !important; }
.mt-4 { margin-top: var(--sp-lg) !important; }
.mt-5 { margin-top: var(--sp-xl) !important; }
.mb-2 { margin-bottom: var(--sp-sm) !important; }
.mb-3 { margin-bottom: var(--sp-md) !important; }
.mb-4 { margin-bottom: var(--sp-lg) !important; }
.mb-5 { margin-bottom: var(--sp-xl) !important; }

.py-2 { padding-top: var(--sp-sm) !important; padding-bottom: var(--sp-sm) !important; }
.py-3 { padding-top: var(--sp-md) !important; padding-bottom: var(--sp-md) !important; }
.py-4 { padding-top: var(--sp-lg) !important; padding-bottom: var(--sp-lg) !important; }
.py-5 { padding-top: var(--sp-xl) !important; padding-bottom: var(--sp-xl) !important; }

.px-2 { padding-left: var(--sp-sm) !important; padding-right: var(--sp-sm) !important; }
.px-3 { padding-left: var(--sp-md) !important; padding-right: var(--sp-md) !important; }
.px-4 { padding-left: var(--sp-lg) !important; padding-right: var(--sp-lg) !important; }
.px-5 { padding-left: var(--sp-xl) !important; padding-right: var(--sp-xl) !important; }

.gap-1 { gap: var(--sp-xs) !important; }
.gap-2 { gap: var(--sp-sm) !important; }
.gap-3 { gap: var(--sp-md) !important; }
.gap-4 { gap: var(--sp-lg) !important; }
.gap-5 { gap: var(--sp-xl) !important; }

/* ============================================================
   HIDDEN AUDIO - FIXED
   ============================================================ */
#bgAudio {
    position: absolute !important;
    width: 0 !important;
    height: 0 !important;
    opacity: 0 !important;
    pointer-events: none !important;
    user-select: none !important;
    overflow: hidden !important;
    display: none !important;
}
    </style>
</head>
<body>

<!-- ===== HIDDEN AUDIO ELEMENTS ===== -->
<audio id="bgAudio" src="{{ asset('audio/truckengine.mp3') }}" loop preload="auto"></audio>
<audio id="clickAudio" src="{{ asset('audio/click.mp3') }}" preload="auto"></audio>

<!-- ========== NAVBAR ========== -->
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ url('/') }}" class="logo">Sure<span>Cargo</span></a>
        <button class="menu-icon" id="menuIcon" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="nav-links" id="navLinks">
            <a href="{{ url('/') }}#home">Home</a>
            <a href="{{ url('/') }}#features">Features</a>
            <a href="{{ route('about') }}" class="fw-bold" style="color: #2d7aff;">About</a>

            @guest
                <a href="{{ route('login') }}" class="btn-outline-light-custom" style="text-decoration:none;">Login</a>
                <a href="{{ route('register') }}" class="btn-primary-custom" style="text-decoration:none;">Sign Up</a>
            @endguest
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary-custom">Dashboard</a>
            @endauth
        </div>
    </div>
</nav>

<!-- ========== HERO SECTION ========== -->
<div class="container pt-5 pb-4">
    <div class="row align-items-center g-5 py-4">
        <div class="col-lg-7" data-aos="fade-right">
            <span class="badge-soft mb-3 d-inline-block"><i class="fas fa-graduation-cap me-2"></i> 3rd Year IT Capstone Project 2025</span>
            <h1 class="display-5 fw-bold mt-2">About <span style="color:#2d7aff;">SureCargo</span><br>Intelligent Logistics Ecosystem</h1>
            <p class="lead mt-3">We are a team of IT students from Madridejos Community College, building a next‑generation freight platform that merges <strong>real‑time tracking (Laravel Reverb)</strong>, <strong>instant messaging</strong>, <strong>one‑click booking</strong> and <strong>GCash QR code payments</strong> — making logistics smarter, faster, and completely transparent.</p>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="{{ route('register') }}" class="btn btn-primary-custom px-4 py-2"><i class="fas fa-ship me-2"></i> Register</a>
                <a href="#features-highlight" class="btn btn-outline-secondary px-4 py-2" style="border-color:#2d7aff; color:#2d7aff;"><i class="fas fa-info-circle me-2"></i> Explore Features</a>
            </div>
        </div>
        <div class="col-lg-5 text-center" data-aos="fade-left">
            <div class="bg-light p-4 rounded-4 shadow-sm" style="background: rgba(255,255,255,0.9);">
                <i class="fas fa-comments fa-3x text-primary mb-3"></i>
                <i class="fas fa-location-dot fa-3x text-primary mx-3 mb-3"></i>
                <i class="fas fa-credit-card fa-3x text-primary mb-3"></i>
                <p class="mt-2 fw-semibold">Real-time Chat • Live GPS Tracking • GCash QR (Manual Reference)</p>
                <div class="feature-icon-group justify-content-center mt-2">
                    <span class="tech-badge"><i class="fab fa-laravel"></i> Laravel 13</span>
                    <span class="tech-badge"><i class="fas fa-broadcast-tower"></i> Reverb</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== CAPSTONE CONTEXT + MISSION ========== -->
<div class="section-light py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-md-6" data-aos="fade-up">
                <img src="{{ asset('assets/eggy.jpg') }}" alt="Team working on SureCargo" class="img-fluid rounded-4 shadow" style="border:1px solid #eef2ff; max-width:100%;">
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <span class="badge-soft">Built by IT Students</span>
                <h2 class="mt-2">Our Capstone Journey</h2>
                <p>SureCargo is the culmination of our 3rd year Software Development capstone project. We identified real-world logistics problems — lack of transparency, delayed communication, and limited digital payment options — and built an all-in-one solution using <strong>Laravel + Reverb</strong> for WebSocket-driven live tracking, a two-way messaging hub, and GCash QR code integration (full API integration planned for future releases). Every line of code is student-crafted, focused on innovation and real impact.</p>
                <div class="mt-3">
                    <div><i class="fas fa-check-circle text-primary me-2"></i> <strong>Messaging system</strong> – driver/customer chat with read receipts</div>
                    <div><i class="fas fa-check-circle text-primary me-2"></i> <strong>Real-time tracking</strong> – broadcast location via Reverb & Leaflet maps</div>
                    <div><i class="fas fa-check-circle text-primary me-2"></i> <strong>Easy booking</strong> – 3-step freight order, instant quote</div>
                    <div><i class="fas fa-check-circle text-primary me-2"></i> <strong>GCash QR payments</strong> – display QR code, capture name & reference number (API ready for future automation)</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== KEY INNOVATIONS ========== -->
<div class="section-white py-5" id="features-highlight">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge-soft">Platform Capabilities</span>
            <h2>Designed for Modern Logistics</h2>
            <p class="mx-auto" style="max-width: 720px;">Every feature is crafted to reduce friction and provide absolute clarity — from booking to final delivery.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card-flat">
                    <div class="icon-blue"><i class="fas fa-comment-dots"></i></div>
                    <h4>In-App Messaging</h4>
                    <p>Real-time chat between customers, drivers, and support — powered by WebSockets.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
                <div class="card-flat">
                    <div class="icon-blue"><i class="fas fa-satellite-dish"></i></div>
                    <h4>Live Tracking</h4>
                    <p>WebSocket-based GPS tracking using Reverb + Leaflet. See your cargo moving on a live map, ETA updated every second.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card-flat">
                    <div class="icon-blue"><i class="fas fa-calendar-check"></i></div>
                    <h4>One-Click Booking</h4>
                    <p>Smart forms, instant price estimates, and automated dispatch. Book a shipment in under 60 seconds.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="250">
                <div class="card-flat">
                    <div class="icon-blue"><i class="fab fa-gcash"></i></div>
                    <h4>GCash QR Integration</h4>
                    <p>Display QR code for payments; customer submits name and reference number. Full GCash API integration planned for future release.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== MISSION & VISION ========== -->
<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-6" data-aos="fade-right">
            <span class="badge-soft">Our North Star</span>
            <h2 class="mt-2">Mission & Vision</h2>
            <p class="mt-3"><strong>Mission:</strong> To empower Filipino businesses and beyond with an intelligent logistics platform where real-time tracking, seamless messaging, and digital payments become standard, not premium.</p>
            <p><strong>Vision:</strong> A fully connected supply chain ecosystem — by 2026, SureCargo aims to power 500+ SMEs and reduce delivery anxiety through radical transparency and AI-driven optimization.</p>
            <hr>
            <div class="mt-3">
                <h5 class="fw-bold"><i class="fas fa-microphone-alt text-primary me-2"></i> Developed by 3rd Year IT Students:</h5>
                <p>This capstone project showcases full-stack proficiency: Laravel for backend, Reverb for WebSockets, MySQL, and third-party APIs like GCash (future), Google Maps. Our goal: solve real logistics pains with elegant code and user-centered design.</p>
            </div>
        </div>
        <div class="col-md-6" data-aos="fade-left">
            <div class="bg-light p-4 rounded-4" style="background:#f5f9ff;">
                <i class="fas fa-chalkboard-user fa-2x text-primary mb-2"></i>
                <h4>Why SureCargo stands out?</h4>
                <ul class="list-unstyled mt-3">
                    <li class="mb-2"><i class="fas fa-bolt text-primary me-2"></i> <strong>Real-time communication</strong> (Reverb powered)</li>
                    <li class="mb-2"><i class="fas fa-map-marked-alt text-primary me-2"></i> <strong>Driver geolocation</strong> + push notifications</li>
                    <li class="mb-2"><i class="fas fa-wallet text-primary me-2"></i> <strong>QR code-based GCash payment</strong> – name & reference tracking (API coming soon)</li>
                    <li class="mb-2"><i class="fas fa-chart-line text-primary me-2"></i> <strong>Admin dashboard</strong> with analytics & dispute system</li>
                </ul>
                <div class="mt-3 p-3 rounded-3" style="background:white;">
                    <span class="fw-semibold">🎓 Academic Research & Development:</span>
                    <p class="mb-0">This project is presented as partial fulfillment for the IT Capstone course, integrating software engineering principles, UX research, and modern DevOps.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== STATS SECTION ========== -->
<div class="section-light py-5">
    <div class="container">
        <div class="text-center mb-4" data-aos="fade-up">
            <span class="badge-soft">Platform Milestones</span>
            <h2>SureCargo in Numbers</h2>
        </div>
        <div class="row text-center g-4">
            <div class="col-md-3 reveal" data-aos="zoom-in"><div class="stat-number">200+</div><p class="fw-semibold">Active Users (Beta)</p></div>
            <div class="col-md-3 reveal" data-aos="zoom-in" data-aos-delay="100"><div class="stat-number">98%</div><p class="fw-semibold">Chat Response Rate</p></div>
            <div class="col-md-3 reveal" data-aos="zoom-in" data-aos-delay="200"><div class="stat-number">15k+</div><p class="fw-semibold">Real‑time Updates Sent</p></div>
            <div class="col-md-3 reveal" data-aos="zoom-in" data-aos-delay="300"><div class="stat-number">QR</div><p class="fw-semibold">GCash Manual Payments</p></div>
        </div>
    </div>
</div>

<div class="section-white py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge-soft">The Creators</span>
            <h2>Meet the Capstone Team</h2>
            <p>Third-year IT students passionate about logistics, WebSockets, and elegant UI</p>
        </div>
        <div class="row g-4 justify-content-center">
            <!-- 1. Rogelio Tradio Jr. -->
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card-flat text-center">
                    <img src="{{ asset('assets/doys.jpg') }}" alt="Rogelio Tradio Jr." class="team-img">
                    <h4>Rogelio Tradio Jr.</h4>
                    <p class="text-primary">Programmer</p>
                    <p>System developing in-charge.</p>
                </div>
            </div>
            <!-- 2. Wenifredo Alo -->
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="150">
                <div class="card-flat text-center">
                    <img src="{{ asset('assets/weni.jpg') }}" alt="Wenifredo Alo" class="team-img">
                    <h4>Wenifredo Alo</h4>
                    <p class="text-primary">Researcher</p>
                    <p>Requirements gathering, documentation, and logistics workflow research.</p>
                </div>
            </div>
            <!-- 3. Jimboy Marabe -->
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card-flat text-center">
                    <img src="{{ asset('assets/jimboy.jpg') }}" alt="Jimboy Marabe" class="team-img">
                    <h4>Jimboy Marabe</h4>
                    <p class="text-primary">Researcher</p>
                    <p>QA and user acceptance documentation.</p>
                </div>
            </div>
            <!-- 4. Jake Brylle Pantaleon -->
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="250">
                <div class="card-flat text-center">
                    <img src="{{ asset('assets/jake.jpg') }}" alt="Jake Brylle Pantaleon" class="team-img">
                    <h4>Jake Brylle Pantaleon</h4>
                    <p class="text-primary">Researcher</p>
                    <p>Capstone documentation and integration testing.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4" data-aos="fade-up">
            <p class="fst-italic">“Built as a fully-functional capstone project — showcasing Laravel Reverb, event-driven architecture, and GCash QR integration (API planned).”</p>
        </div>
    </div>
</div>

<!-- ========== ROADMAP / FUTURE PLANS ========== -->
<div class="container py-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-6" data-aos="fade-right">
            <span class="badge-soft">What's Next?</span>
            <h2>Roadmap 2026–2027</h2>
            <ul class="mt-3" style="list-style: none; padding-left:0;">
                <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> ✅ AI-based route optimization</li>
                <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> ⚡ Advanced Reverb broadcasting for fleet tracking</li>
                <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> 📱 Mobile app for drivers (PWA + native notifications)</li>
                <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> 💸 Full GCash API automation (auto-debit & split payments)</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> 🌍 Cross-border logistics module</li>
            </ul>
        </div>
        <div class="col-lg-6 text-center" data-aos="fade-left">
            <div class="bg-light rounded-4 p-4 shadow-sm" style="background:white;">
                <i class="fas fa-book-open fa-3x text-primary mb-3"></i>
                <h5 class="fw-bold">Academic & Industry Impact</h5>
                <p>We are the learners from Madridejos Community College (MCC). This platform is currently being piloted by local logistics cooperatives.</p>
                <a href="{{ route('register') }}" class="btn btn-primary-custom mt-2">Join the Beta <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- ========== CTA SECTION ========== -->
<div class="container my-5">
    <div class="bg-white rounded-4 p-5 text-center shadow-sm border" style="background: #fafdff;">
        <h3 class="fw-bold">Ready to experience intelligent logistics?</h3>
        <p class="fs-5 my-3">Real-time tracking, in-app messaging, and GCash QR payments — all in one powerful platform.</p>
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg"><i class="fas fa-user-plus me-2"></i> Sign Up Now</a>
            <a href="{{ url('/') }}#contact" class="btn btn-outline-secondary btn-lg" style="border-color:#2d7aff; color:#2d7aff;"><i class="fas fa-headset me-2"></i> Talk to Team</a>
        </div>
        <p class="small text-muted mt-3">Capstone Project – Full demo available for evaluators</p>
    </div>
</div>

<!-- ========== FOOTER ========== -->
<footer class="footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5 class="fw-bold fs-4">Sure<span style="color:#2d7aff;">Cargo</span></h5>
                <p class="small">Real-time logistics, messaging & GCash QR payments. 3rd Year IT Capstone Project.</p>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold">Quick</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('about') }}" class="text-decoration-none text-dark">About Us</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Messaging Demo</a></li>
                    <li><a href="#" class="text-decoration-none text-dark">Tracking Simulator</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold">Tech & Integrations</h6>
                <div class="d-flex gap-3 flex-wrap">
                    <span class="badge bg-light text-dark p-2">Laravel Reverb</span>
                    <span class="badge bg-light text-dark p-2">GCash QR (Manual)</span>
                    <span class="badge bg-light text-dark p-2">WebSockets</span>
                </div>
                <div class="mt-3 d-flex gap-3">
                    <a href="#" class="text-dark fs-5"><i class="fab fa-github"></i></a>
                    <a href="#" class="text-dark fs-5"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <hr class="mt-4">
        <p class="text-center small mb-0 opacity-75">&copy; {{ date('Y') }} SureCargo – Capstone Project | All innovations belong to IT Department</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script nonce="{{ $csp_nonce }}">
    // ============================================================
    // 0. AUDIO SYSTEM - Click sounds on all interactive elements
    // ============================================================
    (function() {
        var bgAudio = document.getElementById('bgAudio');
        var clickAudio = document.getElementById('clickAudio');

        // --- Background audio ---
        if (bgAudio) {
            bgAudio.volume = 0.5;
            var audioStarted = false;

            function startBackgroundAudio() {
                if (audioStarted) return;
                bgAudio.play().then(function() {
                    audioStarted = true;
                }).catch(function() {});
            }

            startBackgroundAudio();

            window.addEventListener('load', function() {
                setTimeout(function() {
                    if (!audioStarted) startBackgroundAudio();
                }, 500);
            });

            function mobileAutoplayHandler() {
                if (!audioStarted) {
                    startBackgroundAudio();
                }
                if (audioStarted) {
                    document.removeEventListener('click', mobileAutoplayHandler);
                    document.removeEventListener('touchstart', mobileAutoplayHandler);
                    document.removeEventListener('scroll', mobileAutoplayHandler);
                    document.removeEventListener('keydown', mobileAutoplayHandler);
                }
            }

            document.addEventListener('click', mobileAutoplayHandler);
            document.addEventListener('touchstart', mobileAutoplayHandler);
            document.addEventListener('scroll', mobileAutoplayHandler);
            document.addEventListener('keydown', mobileAutoplayHandler);

            window.addEventListener('beforeunload', function() {
                if (bgAudio) {
                    try {
                        sessionStorage.setItem('bgAudioTime', bgAudio.currentTime);
                        sessionStorage.setItem('bgAudioPlaying', !bgAudio.paused ? 'true' : 'false');
                    } catch (e) {}
                }
            });

            window.addEventListener('load', function() {
                try {
                    var savedTime = sessionStorage.getItem('bgAudioTime');
                    var wasPlaying = sessionStorage.getItem('bgAudioPlaying');
                    if (savedTime && bgAudio) {
                        bgAudio.currentTime = parseFloat(savedTime);
                    }
                    if (wasPlaying === 'true' && bgAudio && audioStarted) {
                        bgAudio.play().catch(function() {});
                    }
                    sessionStorage.removeItem('bgAudioTime');
                    sessionStorage.removeItem('bgAudioPlaying');
                } catch (e) {}
            });
        }

        // --- Click sound on ALL interactive elements ---
        function playClick() {
            if (clickAudio) {
                clickAudio.currentTime = 0;
                clickAudio.play().catch(function() {});
            }
        }

        document.addEventListener('click', function(e) {
            var target = e.target.closest('a, button, .btn-primary-custom, .btn-outline-light-custom, .btn-outline-secondary, .menu-icon, .nav-links a, .footer a, .social-links a, .card-flat, .tech-badge');
            if (target) {
                if (target.closest('#bgAudio') || target.closest('#clickAudio')) {
                    return;
                }
                playClick();
                if (bgAudio && !audioStarted) {
                    startBackgroundAudio();
                }
            }
        });

        window.__bgAudio = bgAudio;
        window.__clickAudio = clickAudio;
    })();

    // ============================================================
    // 1. AOS Init
    // ============================================================
    AOS.init({ duration: 700, once: true, mirror: false });

    // ============================================================
    // 2. Mobile menu toggle
    // ============================================================
    var menuIcon = document.getElementById('menuIcon');
    var navLinks = document.getElementById('navLinks');
    if (menuIcon) {
        menuIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            navLinks.classList.toggle('show');
            var icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }
        });
    }

    // Close menu when clicking a link
    document.querySelectorAll('.nav-links a').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 500) {
                navLinks.classList.remove('show');
                var icon = menuIcon.querySelector('i');
                if (icon) {
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-times');
                }
            }
        });
    });

    // ============================================================
    // 3. scroll reveal for stats
    // ============================================================
    var reveals = document.querySelectorAll('.reveal');
    var revealObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.2 });
    reveals.forEach(function(r) { revealObserver.observe(r); });

    // ============================================================
    // 4. ripple effect for buttons
    // ============================================================
    document.querySelectorAll('.btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            var ripple = document.createElement('span');
            var rect = btn.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height);
            var x = e.clientX - rect.left - size/2;
            var y = e.clientY - rect.top - size/2;
            ripple.style.cssText = 'position:absolute; width:' + size + 'px; height:' + size + 'px; left:' + x + 'px; top:' + y + 'px; background:rgba(45,122,255,0.3); border-radius:50%; transform:scale(0); transition:transform 0.3s, opacity 0.5s; pointer-events:none;';
            btn.style.position = 'relative';
            btn.style.overflow = 'hidden';
            btn.appendChild(ripple);
            setTimeout(function() { ripple.style.transform = 'scale(2)'; }, 10);
            setTimeout(function() { ripple.remove(); }, 500);
        });
    });
</script>
</body>
</html>
