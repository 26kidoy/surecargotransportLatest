<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Find Us | SureCargo Locations</title>
    <link rel="icon" type="image/jpeg" href="/assets/white.jpg">

    <!-- Fonts & Libraries -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />

    <style nonce="{{ $csp_nonce }}">
      /* ============================================================
   FIND/MAP PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   FIXED: NO API KEY REQUIRED, REMOVED BACKGROUND AUDIO
   ============================================================ */

:root {
    --primary: #2d7aff;
    --primary-dark: #1a5ad9;
    --primary-light: #7aaefc;
    --secondary: #0a0f1f;
    --accent: #10b981;
    --text-light: #ffffff;
    --text-muted: #e2edff;
    --glass-bg: rgba(8, 14, 26, 0.78);
    --glass-card: rgba(12, 20, 35, 0.82);
    --font-base: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    --navbar-height: 80px;

    /* FONT SIZES - ENHANCED FOR MOBILE */
    --font-xs: 0.8rem;
    --font-sm: 0.95rem;
    --font-base: 1.05rem;
    --font-md: 1.2rem;
    --font-lg: 1.35rem;
    --font-xl: 1.6rem;
    --font-xxl: 1.9rem;
    --font-xxxl: 2.5rem;
    --font-xxxxl: 3.2rem;

    --sp-xs: 0.25rem;
    --sp-sm: 0.5rem;
    --sp-md: 1rem;
    --sp-lg: 1.5rem;
    --sp-xl: 2rem;
    --sp-xxl: 3rem;
}

/* ============================================================
   RESET & GLOBAL
   ============================================================ */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
    scroll-padding-top: var(--navbar-height);
    font-size: 16px;
    -webkit-text-size-adjust: 100%;
}

body {
    font-family: var(--font-base);
    color: var(--text-light);
    overflow-x: hidden;
    background: var(--secondary);
    padding-top: var(--navbar-height);
    min-height: 100vh;
    font-size: var(--font-base);
    font-weight: 400;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ============================================================
   SCROLLBAR HIDING ON DESKTOP
   ============================================================ */
@media (min-width: 992px) {
    html, body, * {
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }
    html::-webkit-scrollbar,
    body::-webkit-scrollbar,
    *::-webkit-scrollbar {
        width: 0 !important;
        height: 0 !important;
        display: none !important;
    }
}

/* ============================================================
   BACKGROUND
   ============================================================ */
.page-wrapper {
    position: relative;
    min-height: 100vh;
    overflow-x: hidden;
}

.page-wrapper::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('{{ asset("assets/background.jpg") }}');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    opacity: 0.85;
    z-index: -2;
}

.page-wrapper::after {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(10, 15, 31, 0.7), rgba(0, 0, 0, 0.8));
    z-index: -1;
}

/* ============================================================
   PRELOADER
   ============================================================ */
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--secondary);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 999999;
    transition: opacity 0.8s ease, visibility 0.8s ease;
}

#preloader.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

#preloader .spinner {
    width: 60px;
    height: 60px;
    border: 5px solid rgba(45, 122, 255, 0.2);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

#preloader .logo-text {
    margin-top: var(--sp-lg);
    font-size: var(--font-xl);
    font-weight: 800;
    color: white;
}

#preloader .logo-text span {
    color: var(--primary);
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ============================================================
   IMAGE SKELETON
   ============================================================ */
.img-skeleton {
    background: linear-gradient(90deg, rgba(255,255,255,0.06) 25%, rgba(255,255,255,0.12) 50%, rgba(255,255,255,0.06) 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 1.5rem;
    min-height: 100px;
    transition: opacity 0.5s ease;
    opacity: 0.6;
}

.img-skeleton.loaded {
    background: none;
    animation: none;
    opacity: 1;
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* ============================================================
   NAVBAR
   ============================================================ */
.navbar-custom {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: rgba(6, 12, 24, 0.95);
    backdrop-filter: blur(20px);
    padding: var(--sp-sm) var(--sp-xl);
    border-bottom: 1px solid rgba(45, 122, 255, 0.3);
    z-index: 1030;
    transition: all 0.3s ease;
}

.navbar-custom .nav-container {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.navbar-custom .logo {
    font-size: var(--font-lg);
    font-weight: 800;
    color: white;
    text-decoration: none;
    letter-spacing: -0.02em;
}

.navbar-custom .logo span {
    color: var(--primary);
}

.navbar-custom .nav-links {
    display: flex;
    align-items: center;
    gap: var(--sp-lg);
    flex-wrap: wrap;
}

.navbar-custom .nav-links a {
    color: #f0f4ff;
    text-decoration: none;
    font-weight: 500;
    font-size: var(--font-base);
    transition: color 0.2s;
}

.navbar-custom .nav-links a:hover {
    color: var(--primary-light);
}

/* ============================================================
   HAMBURGER MENU
   ============================================================ */
.menu-icon {
    display: none;
    font-size: var(--font-xl);
    color: white;
    cursor: pointer;
    position: relative;
    z-index: 999999 !important;
    pointer-events: auto !important;
    touch-action: manipulation !important;
    -webkit-tap-highlight-color: transparent;
    padding: var(--sp-sm);
    line-height: 1;
    min-height: 44px;
    min-width: 44px;
    align-items: center;
    justify-content: center;
}

/* ============================================================
   BUTTONS
   ============================================================ */
.btn-primary-custom {
    background: var(--primary);
    color: white;
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 50px;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-base);
    white-space: nowrap;
    min-height: 44px;
    gap: var(--sp-xs);
}

.btn-primary-custom:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    color: white;
    box-shadow: 0 8px 25px rgba(45, 122, 255, 0.4);
}

.btn-outline-custom {
    background: transparent;
    color: white;
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 50px;
    font-weight: 600;
    border: 2px solid var(--primary);
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-base);
    white-space: nowrap;
    min-height: 44px;
    gap: var(--sp-xs);
}

.btn-outline-custom:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
}

.btn-back {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: var(--sp-sm) var(--sp-xl);
    border-radius: 50px;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-base);
    text-align: center;
    min-height: 44px;
    gap: var(--sp-xs);
}

.btn-back:hover {
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 10px 30px rgba(45, 122, 255, 0.4);
}

/* ============================================================
   BADGE
   ============================================================ */
.badge-pill-custom {
    background: rgba(45, 122, 255, 0.2);
    backdrop-filter: blur(4px);
    padding: var(--sp-xs) var(--sp-lg);
    border-radius: 50px;
    font-weight: 500;
    color: #c7e0ff;
    display: inline-block;
    border: 1px solid rgba(45, 122, 255, 0.3);
    font-size: var(--font-sm);
}

/* ============================================================
   HERO HEADER
   ============================================================ */
.page-header {
    padding: var(--sp-xl) 0 var(--sp-md);
}

.page-header h1 {
    font-size: var(--font-xxxl);
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: var(--sp-sm);
    letter-spacing: -0.02em;
}

.page-header .lead {
    font-size: var(--font-lg);
    font-weight: 400;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.6;
}

.gradient-text {
    background: linear-gradient(135deg, #fff, var(--primary-light));
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* ============================================================
   LOCATION CARDS
   ============================================================ */
.location-card {
    background: var(--glass-card);
    backdrop-filter: blur(14px);
    border-radius: 2rem;
    padding: var(--sp-lg);
    border-left: 5px solid var(--primary);
    transition: all 0.3s ease;
    height: 100%;
}

.location-card:hover {
    transform: translateX(8px);
    border-color: var(--primary-light);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.location-card h3 {
    font-size: var(--font-lg);
    font-weight: 700;
    margin-bottom: var(--sp-sm);
}

.location-card p {
    font-size: var(--font-base);
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: var(--sp-sm);
    display: flex;
    align-items: center;
    gap: var(--sp-sm);
}

.location-card i {
    font-size: var(--font-md);
    width: 2rem;
    color: var(--primary-light);
    flex-shrink: 0;
}

.location-card a {
    color: var(--primary-light);
    text-decoration: none;
    font-weight: 500;
    font-size: var(--font-base);
    transition: color 0.2s;
}

.location-card a:hover {
    color: var(--primary);
}

/* ============================================================
   MAP
   ============================================================ */
.map-container {
    background: var(--glass-card);
    backdrop-filter: blur(14px);
    border-radius: 2rem;
    padding: var(--sp-sm);
    border: 1px solid rgba(45, 122, 255, 0.3);
    margin: var(--sp-xl) 0;
}

#map {
    height: 500px;
    width: 100%;
    border-radius: 1.5rem;
    z-index: 1;
}

/* ============================================================
   MAP POPUP FIXES
   ============================================================ */
.leaflet-popup-content {
    font-size: var(--font-base) !important;
    min-width: 200px;
    line-height: 1.5;
    font-family: var(--font-base);
}

.leaflet-popup-content-wrapper {
    border-radius: 1rem;
    font-family: var(--font-base);
}

.leaflet-container a.leaflet-popup-close-button {
    font-size: var(--font-lg) !important;
    padding: 6px !important;
}

.truck-marker i {
    display: block;
    text-align: center;
    line-height: 1;
}

/* ============================================================
   FOOTER
   ============================================================ */
.footer {
    background: rgba(4, 10, 20, 0.95);
    backdrop-filter: blur(12px);
    border-top: 1px solid rgba(45, 122, 255, 0.2);
    padding: var(--sp-xl) 0 var(--sp-lg);
    margin-top: var(--sp-xxl);
}

.footer p {
    font-size: var(--font-sm);
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
}

/* ============================================================
   UTILITY
   ============================================================ */
.section-spacing {
    padding: var(--sp-xl) 0;
}

.text-muted-light {
    color: rgba(255, 255, 255, 0.7);
}

.divider-light {
    border-color: rgba(255, 255, 255, 0.1);
}

img, svg, iframe, video {
    max-width: 100%;
    height: auto;
}

.container, .container-fluid {
    overflow-x: hidden;
}

/* ============================================================
   BUTTON LOADING STATE
   ============================================================ */
.btn-loading {
    opacity: 0.7;
    pointer-events: none;
    cursor: default;
}

.btn-loading i.fa-spinner {
    animation: fa-spin 1s infinite linear;
}

.btn-loading:disabled {
    opacity: 0.7;
}

/* ============================================================
   RESPONSIVE - ENHANCED FOR BIGGER MOBILE FONTS
   ============================================================ */

/* --- Tablets & Small Desktops (769px - 992px) --- */
@media (min-width: 769px) and (max-width: 992px) {
    :root {
        --font-xs: 0.8rem;
        --font-sm: 0.9rem;
        --font-base: 1rem;
        --font-md: 1.1rem;
        --font-lg: 1.25rem;
        --font-xl: 1.4rem;
        --font-xxl: 1.6rem;
        --font-xxxl: 1.9rem;
        --font-xxxxl: 2.6rem;
    }

    .page-header h1 {
        font-size: var(--font-xxxl);
    }

    .page-header .lead {
        font-size: var(--font-md);
    }

    #map {
        height: 420px;
    }

    .location-card h3 {
        font-size: var(--font-md);
    }

    .location-card p {
        font-size: var(--font-sm);
    }
}

/* --- Mobile Devices (≤ 768px) - LARGER FONTS --- */
@media (max-width: 768px) {
    :root {
        --font-xs: 0.85rem;
        --font-sm: 0.95rem;
        --font-base: 1.1rem;
        --font-md: 1.25rem;
        --font-lg: 1.4rem;
        --font-xl: 1.55rem;
        --font-xxl: 1.7rem;
        --font-xxxl: 1.9rem;
        --font-xxxxl: 2.2rem;

        --sp-xs: 0.3rem;
        --sp-sm: 0.5rem;
        --sp-md: 0.9rem;
        --sp-lg: 1.3rem;
        --sp-xl: 1.7rem;
        --sp-xxl: 2.5rem;
    }

    body {
        font-size: var(--font-base);
        padding-top: var(--navbar-height);
    }

    .navbar-custom {
        padding: var(--sp-sm) var(--sp-md);
    }

    .navbar-custom .logo {
        font-size: var(--font-md);
    }

    .navbar-custom .nav-links {
        display: none;
        flex-direction: column;
        width: 100%;
        background: rgba(6, 12, 24, 0.98);
        backdrop-filter: blur(12px);
        padding: var(--sp-sm) var(--sp-sm);
        border-radius: 1rem;
        border: 1px solid rgba(45, 122, 255, 0.2);
        margin-top: 10px;
        gap: var(--sp-xs);
    }

    .navbar-custom .nav-links.show {
        display: flex;
    }

    .navbar-custom .nav-links a {
        padding: var(--sp-xs) var(--sp-sm);
        font-size: var(--font-base);
        width: 100%;
        text-align: center;
        border-radius: 30px;
        transition: background 0.2s;
        min-height: 44px;
        align-items: center;
        justify-content: center;
    }

    .navbar-custom .nav-links a:hover {
        background: rgba(45, 122, 255, 0.15);
    }

    .navbar-custom .nav-links .btn-primary-custom,
    .navbar-custom .nav-links .btn-outline-custom {
        width: 100%;
        text-align: center;
        margin: var(--sp-xs) 0;
        white-space: normal;
        min-height: 44px;
        font-size: var(--font-base);
    }

    .menu-icon {
        display: flex;
        font-size: var(--font-xl);
        min-height: 44px;
        min-width: 44px;
    }

    .page-header {
        padding: var(--sp-md) 0 var(--sp-sm);
    }

    .page-header h1 {
        font-size: var(--font-xxl);
    }

    .page-header .lead {
        font-size: var(--font-base);
    }

    .badge-pill-custom {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-md);
    }

    .location-card {
        padding: var(--sp-md);
        border-left-width: 4px;
        border-radius: 1.5rem;
    }

    .location-card h3 {
        font-size: var(--font-md);
    }

    .location-card p {
        font-size: var(--font-sm);
        margin-bottom: var(--sp-xs);
        gap: var(--sp-xs);
        flex-wrap: wrap;
    }

    .location-card i {
        font-size: var(--font-base);
        width: 1.8rem;
    }

    .location-card a {
        font-size: var(--font-sm);
    }

    .map-container {
        padding: var(--sp-xs);
        border-radius: 1.5rem;
        margin: var(--sp-md) 0;
    }

    #map {
        height: 400px;
        border-radius: 1.2rem;
    }

    .btn-primary-custom,
    .btn-outline-custom {
        padding: var(--sp-xs) var(--sp-md);
        font-size: var(--font-sm);
        min-height: 44px;
    }

    .btn-back {
        padding: var(--sp-sm) var(--sp-lg);
        font-size: var(--font-base);
        min-height: 44px;
        border-radius: 40px;
    }

    .footer {
        padding: var(--sp-lg) 0 var(--sp-sm);
        margin-top: var(--sp-xl);
    }

    .footer p {
        font-size: var(--font-sm);
    }

    .container {
        padding-left: var(--sp-md);
        padding-right: var(--sp-md);
    }

    .row {
        --bs-gutter-x: var(--sp-md);
    }

    .leaflet-popup-content {
        font-size: var(--font-sm) !important;
        min-width: 180px !important;
    }

    .leaflet-popup-content strong {
        font-size: var(--font-base) !important;
    }

    .leaflet-popup-content a {
        font-size: var(--font-sm) !important;
    }

    .leaflet-container a.leaflet-popup-close-button {
        font-size: var(--font-md) !important;
        padding: 6px !important;
    }
}

/* --- Small Phones (≤ 576px) - LARGER FONTS --- */
@media (max-width: 576px) {
    :root {
        --font-xs: 0.8rem;
        --font-sm: 0.9rem;
        --font-base: 1rem;
        --font-md: 1.15rem;
        --font-lg: 1.3rem;
        --font-xl: 1.45rem;
        --font-xxl: 1.6rem;
        --font-xxxl: 1.8rem;
        --font-xxxxl: 2rem;

        --sp-xs: 0.25rem;
        --sp-sm: 0.4rem;
        --sp-md: 0.7rem;
        --sp-lg: 1.1rem;
        --sp-xl: 1.3rem;
        --sp-xxl: 1.8rem;
    }

    .navbar-custom {
        padding: var(--sp-xs) var(--sp-sm);
    }

    .navbar-custom .logo {
        font-size: var(--font-sm);
    }

    .menu-icon {
        font-size: var(--font-md);
        min-height: 40px;
        min-width: 40px;
        padding: var(--sp-xs);
    }

    .navbar-custom .nav-links a {
        font-size: var(--font-sm);
        min-height: 40px;
        padding: var(--sp-xs) var(--sp-sm);
    }

    .navbar-custom .nav-links .btn-primary-custom,
    .navbar-custom .nav-links .btn-outline-custom {
        font-size: var(--font-sm);
        min-height: 40px;
        padding: var(--sp-xs) var(--sp-sm);
    }

    .page-header {
        padding: var(--sp-sm) 0 var(--sp-xs);
    }

    .page-header h1 {
        font-size: var(--font-xl);
    }

    .page-header .lead {
        font-size: var(--font-sm);
    }

    .badge-pill-custom {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
    }

    .location-card {
        padding: var(--sp-sm);
        border-left-width: 3px;
        border-radius: 1.2rem;
    }

    .location-card h3 {
        font-size: var(--font-md);
    }

    .location-card p {
        font-size: var(--font-sm);
        gap: var(--sp-xs);
        margin-bottom: var(--sp-xs);
    }

    .location-card i {
        font-size: var(--font-base);
        width: 1.6rem;
    }

    .location-card a {
        font-size: var(--font-sm);
    }

    .map-container {
        padding: var(--sp-xs);
        border-radius: 1.2rem;
        margin: var(--sp-sm) 0;
    }

    #map {
        height: 350px;
        border-radius: 1rem;
    }

    .btn-primary-custom,
    .btn-outline-custom {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 40px;
        border-radius: 40px;
    }

    .btn-back {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 40px;
        border-radius: 40px;
    }

    .footer {
        padding: var(--sp-md) 0 var(--sp-xs);
        margin-top: var(--sp-lg);
    }

    .footer p {
        font-size: var(--font-xs);
    }

    .container {
        padding-left: var(--sp-sm);
        padding-right: var(--sp-sm);
    }

    .row {
        --bs-gutter-x: var(--sp-sm);
    }

    .text-center .btn-back {
        width: 100%;
        max-width: 260px;
    }

    .leaflet-popup-content {
        font-size: var(--font-sm) !important;
        min-width: 160px !important;
    }

    .leaflet-popup-content strong {
        font-size: var(--font-base) !important;
    }

    .leaflet-popup-content a {
        font-size: var(--font-sm) !important;
    }
}

/* --- Very Small Phones (≤ 400px) - LARGER FONTS --- */
@media (max-width: 400px) {
    :root {
        --font-xs: 0.75rem;
        --font-sm: 0.85rem;
        --font-base: 0.95rem;
        --font-md: 1.05rem;
        --font-lg: 1.15rem;
        --font-xl: 1.25rem;
        --font-xxl: 1.4rem;
        --font-xxxl: 1.5rem;
        --font-xxxxl: 1.7rem;

        --sp-xs: 0.2rem;
        --sp-sm: 0.35rem;
        --sp-md: 0.6rem;
        --sp-lg: 0.9rem;
        --sp-xl: 1.1rem;
        --sp-xxl: 1.4rem;
    }

    body {
        font-size: var(--font-base);
        padding-top: var(--navbar-height);
    }

    .navbar-custom {
        padding: 0.2rem var(--sp-xs);
    }

    .navbar-custom .logo {
        font-size: 0.8rem;
    }

    .menu-icon {
        font-size: 0.9rem;
        min-height: 36px;
        min-width: 36px;
        padding: 0.1rem;
    }

    .navbar-custom .nav-links a {
        font-size: 0.8rem;
        min-height: 36px;
        padding: 0.1rem var(--sp-xs);
    }

    .page-header h1 {
        font-size: var(--font-lg);
    }

    .page-header .lead {
        font-size: 0.8rem;
    }

    .location-card {
        padding: var(--sp-xs);
        border-left-width: 3px;
        border-radius: 1rem;
    }

    .location-card h3 {
        font-size: var(--font-sm);
    }

    .location-card p {
        font-size: 0.75rem;
        gap: var(--sp-xs);
        margin-bottom: 0.1rem;
    }

    .location-card i {
        font-size: 0.8rem;
        width: 1.4rem;
    }

    .location-card a {
        font-size: 0.75rem;
    }

    .map-container {
        padding: 0.2rem;
        border-radius: 1rem;
        margin: var(--sp-xs) 0;
    }

    #map {
        height: 300px;
        border-radius: 0.8rem;
    }

    .btn-primary-custom,
    .btn-outline-custom {
        font-size: 0.75rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 36px;
        border-radius: 30px;
    }

    .btn-back {
        font-size: 0.75rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 36px;
        border-radius: 30px;
    }

    .badge-pill-custom {
        font-size: 0.7rem;
        padding: 0.1rem var(--sp-xs);
    }

    .footer {
        padding: var(--sp-sm) 0 0.2rem;
        margin-top: var(--sp-md);
    }

    .footer p {
        font-size: 0.7rem;
    }

    .container {
        padding-left: var(--sp-xs);
        padding-right: var(--sp-xs);
    }

    .row {
        --bs-gutter-x: var(--sp-xs);
    }

    .text-center .btn-back {
        max-width: 220px;
    }

    .leaflet-popup-content {
        font-size: 0.75rem !important;
        min-width: 140px !important;
    }

    .leaflet-popup-content strong {
        font-size: 0.85rem !important;
    }

    .leaflet-popup-content a {
        font-size: 0.75rem !important;
    }

    .leaflet-container a.leaflet-popup-close-button {
        font-size: 0.9rem !important;
        padding: 4px !important;
    }
}

/* --- Extra Small (≤ 350px) --- */
@media (max-width: 350px) {
    :root {
        --font-xs: 0.7rem;
        --font-sm: 0.8rem;
        --font-base: 0.9rem;
        --font-md: 1rem;
        --font-lg: 1.1rem;
        --font-xl: 1.2rem;
        --font-xxl: 1.3rem;
        --font-xxxl: 1.4rem;
        --font-xxxxl: 1.5rem;

        --sp-xs: 0.15rem;
        --sp-sm: 0.3rem;
        --sp-md: 0.5rem;
        --sp-lg: 0.7rem;
        --sp-xl: 0.9rem;
        --sp-xxl: 1.1rem;
    }

    .page-header h1 {
        font-size: var(--font-md);
    }

    .page-header .lead {
        font-size: 0.7rem;
    }

    #map {
        height: 250px;
    }

    .location-card h3 {
        font-size: 0.8rem;
    }

    .location-card p {
        font-size: 0.65rem;
    }

    .btn-back {
        font-size: 0.65rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 30px;
    }

    .navbar-custom .logo {
        font-size: 0.7rem;
    }

    .menu-icon {
        font-size: 0.7rem;
        min-height: 30px;
        min-width: 30px;
    }
}
    </style>
</head>
<body>

<!-- ===== PRELOADER ===== -->
<div id="preloader">
    <div class="spinner"></div>
    <div class="logo-text">Sure<span>Cargo</span></div>
</div>

<div class="page-wrapper">

<!-- ===== CLICK SOUND ONLY (NO BACKGROUND AUDIO) ===== -->
<audio id="clickAudio" src="{{ asset('audio/click.mp3') }}" preload="auto"></audio>

<!-- ===== NAVBAR ===== -->
<nav class="navbar-custom">
    <div class="nav-container">
        <a href="{{ url('/') }}" class="logo">Sure<span>Cargo</span></a>
        <div class="menu-icon" id="menuIcon">
            <i class="fas fa-bars"></i>
        </div>
        <div class="nav-links" id="navLinks">
            <a href="{{ url('/#home') }}">Home</a>
            <a href="{{ url('/#features') }}">Features</a>
            <a href="{{ route('about') }}">About</a>
            @guest
                <a href="{{ route('login') }}" class="btn-outline-custom">Login</a>
                <a href="{{ route('register') }}" class="btn-primary-custom">Sign Up</a>
            @endguest
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary-custom">Dashboard</a>
            @endauth
        </div>
    </div>
</nav>

<!-- ===== MAIN CONTENT ===== -->
<div class="container py-3 py-md-4">
    <div class="page-header text-center mb-4" data-aos="fade-down">
        <span class="badge-pill-custom">
            <i class="fas fa-map-marked-alt me-2"></i> Our Locations
        </span>
        <h1 class="mt-3 gradient-text">Find Us in Cebu</h1>
        <p class="lead">Visit our operational hubs in Santa Fe and Bantayan Island</p>
    </div>

    <div class="row g-4 mb-4">
        <!-- Bantayan & Santa Fe Boundary (Mohon) -->
        <div class="col-md-6" data-aos="fade-right">
            <div class="location-card">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-map-pin"></i>
                    <h3 class="fw-bold mb-0">Bantayan & Santa Fe Boundary (Mohon)</h3>
                </div>
                <p><i class="fas fa-warehouse"></i> Main Logistics Hub/Loading area · 5Q87+C6X, Bantayan - Sta.Fe Rd, Santa Fe, 6052 Cebu</p>
                <p><i class="fas fa-clock"></i> Sunday Only: 8:00 AM - 6:00 PM</p>
                <a href="https://maps.google.com/?q=11.1661212,123.7631057" target="_blank">
                    Get Directions <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <!-- Sulangan / Sungko -->
        <div class="col-md-6" data-aos="fade-left">
            <div class="location-card">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h3 class="fw-bold mb-0">Sungko / Sulangan, Bantayan, Cebu</h3>
                </div>
                <p><i class="fas fa-ship"></i> Maintenance Camp (Sulangan Area)</p>
                <p><i class="fas fa-clock"></i> Wed-Sat: 7:00 AM - 7:00 PM</p>
                <a href="https://maps.google.com/?q=11.14225,123.724889" target="_blank">
                    Get Directions <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="map-container" data-aos="zoom-in">
        <div id="map"></div>
    </div>

    <div class="text-center mt-3">
        <a href="{{ url('/') }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i> Back to Home
        </a>
    </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="container text-center">
        <p>&copy; {{ date('Y') }} SureCargo Inc. — Seamless logistics, absolute clarity.</p>
    </div>
</footer>

</div>

<!-- ===== SCRIPTS ===== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>

<script nonce="{{ $csp_nonce }}">
    // ============================================================
    // 0. CLICK SOUND ONLY (NO BACKGROUND AUDIO)
    // ============================================================
    (function() {
        var clickAudio = document.getElementById('clickAudio');

        // --- Click sound on interactive elements ---
        function playClick() {
            if (clickAudio) {
                clickAudio.currentTime = 0;
                clickAudio.play().catch(function() {});
            }
        }

        document.addEventListener('click', function(e) {
            var target = e.target.closest('a, button, .btn-primary-custom, .btn-outline-custom, .btn-back, .location-card, .menu-icon, .nav-links a, .social-links a, .badge-pill-custom');
            if (target) {
                if (target.closest('#clickAudio')) {
                    return;
                }
                playClick();
            }
        });

        window.__clickAudio = clickAudio;
    })();

    // ============================================================
    // 1. PRELOADER
    // ============================================================
    (function() {
        var preloader = document.getElementById('preloader');
        if (!preloader) return;

        var resourcesLoaded = false;

        function hidePreloader() {
            preloader.classList.add('hidden');
        }

        window.addEventListener('load', function() {
            resourcesLoaded = true;
            setTimeout(hidePreloader, 300);
        });

        if (document.readyState === 'complete') {
            resourcesLoaded = true;
            setTimeout(hidePreloader, 300);
        }

        setTimeout(hidePreloader, 5000);
    })();

    // ============================================================
    // 2. IMAGE SKELETON
    // ============================================================
    (function() {
        var images = document.querySelectorAll('img.img-skeleton');
        images.forEach(function(img) {
            if (img.complete && img.naturalWidth !== 0) {
                img.classList.add('loaded');
                return;
            }
            img.addEventListener('load', function() {
                this.classList.add('loaded');
            });
            img.addEventListener('error', function() {
                this.classList.add('loaded');
            });
        });
    })();

    // ============================================================
    // 3. HAMBURGER MENU
    // ============================================================
    (function() {
        var menuIcon = document.getElementById('menuIcon');
        var navLinks = document.getElementById('navLinks');

        if (menuIcon && navLinks) {
            var toggleMenu = function(e) {
                e.preventDefault();
                e.stopPropagation();
                navLinks.classList.toggle('show');
                var icon = menuIcon.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-bars');
                    icon.classList.toggle('fa-times');
                }
                return false;
            };

            menuIcon.removeEventListener('click', toggleMenu);
            menuIcon.removeEventListener('touchstart', toggleMenu);
            menuIcon.addEventListener('click', toggleMenu);
            menuIcon.addEventListener('touchstart', toggleMenu, { passive: false });
            menuIcon.onclick = toggleMenu;

            document.querySelectorAll('.nav-links a').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        navLinks.classList.remove('show');
                        var icon = menuIcon.querySelector('i');
                        if (icon) {
                            icon.classList.add('fa-bars');
                            icon.classList.remove('fa-times');
                        }
                    }
                });
            });

            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    var nav = document.querySelector('.navbar-custom');
                    if (nav && !nav.contains(e.target)) {
                        navLinks.classList.remove('show');
                        var icon = menuIcon.querySelector('i');
                        if (icon) {
                            icon.classList.add('fa-bars');
                            icon.classList.remove('fa-times');
                        }
                    }
                }
            });
        }
    })();

    // ============================================================
    // 4. BUTTON LOADING STATES
    // ============================================================
    (function() {
        var targets = document.querySelectorAll(`
            .btn-primary-custom:not([download]),
            .btn-outline-custom:not([download]),
            .btn-back:not([download]),
            .btn-logout
        `);

        targets.forEach(function(el) {
            if (el.dataset.loadingBound) return;
            el.dataset.loadingBound = 'true';

            el.addEventListener('click', function(e) {
                if (el.tagName === 'BUTTON' && el.type === 'submit') {
                    return;
                }
                if (el.classList.contains('btn-loading')) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                var isLink = el.tagName === 'A';
                var isButton = el.tagName === 'BUTTON';
                if (!el.dataset.originalHtml) {
                    el.dataset.originalHtml = el.innerHTML;
                }
                if (isButton) {
                    el.disabled = true;
                }
                el.classList.add('btn-loading');
                el.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Please wait...';
                if (isLink) {
                    var href = el.getAttribute('href');
                    if (!href || href === '#') {
                        e.preventDefault();
                        setTimeout(function() {
                            resetButton(el);
                        }, 2000);
                    } else {
                        setTimeout(function() {
                            if (!document.hidden) {
                                resetButton(el);
                            }
                        }, 8000);
                    }
                } else {
                    setTimeout(function() {
                        resetButton(el);
                    }, 8000);
                }
            });
        });

        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                var btn = form.querySelector('.btn-logout, .btn-primary-custom, .btn-outline-custom');
                if (btn && !btn.classList.contains('btn-loading')) {
                    if (!btn.dataset.originalHtml) {
                        btn.dataset.originalHtml = btn.innerHTML;
                    }
                    btn.disabled = true;
                    btn.classList.add('btn-loading');
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Please wait...';
                }
            });
        });

        function resetButton(el) {
            if (el.dataset.originalHtml) {
                el.innerHTML = el.dataset.originalHtml;
            }
            el.classList.remove('btn-loading');
            if (el.tagName === 'BUTTON') {
                el.disabled = false;
            }
        }
    })();

    // ============================================================
    // 5. LEAFLET MAP - NO API KEY REQUIRED
    // ============================================================
    AOS.init({ duration: 800, once: false, mirror: false });

    var locations = [
        {
            name: "Bantayan & Santa Fe Boundary (Mohon)",
            lat: 11.1661212,
            lng: 123.7631057,
            description: "Main Logistics Hub · Bantayan - Sta.Fe Road, Santa Fe"
        },
        {
            name: "Sungko / Sulangan, Bantayan, Cebu",
            lat: 11.14225,
            lng: 123.724889,
            description: "Portside Cargo Terminal & Maintenance Camp (Sulangan shoreline)"
        }
    ];

    var bounds = L.latLngBounds(locations.map(function(loc) {
        return [loc.lat, loc.lng];
    }));
    var map = L.map('map').fitBounds(bounds, { padding: [60, 60] });

    // ✅ FIXED: Using OpenStreetMap tiles - NO API KEY REQUIRED!
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        minZoom: 10,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var truckIcon = L.divIcon({
        html: '<i class="fas fa-truck" style="font-size: 2.4rem; color: #2d7aff; filter: drop-shadow(2px 2px 6px rgba(0,0,0,0.5));"></i>',
        iconSize: [44, 44],
        className: 'truck-marker',
        popupAnchor: [0, -18]
    });

    locations.forEach(function(loc) {
        var marker = L.marker([loc.lat, loc.lng], { icon: truckIcon }).addTo(map);
        marker.bindPopup(
            '<div style="font-family: \'Inter\', sans-serif; min-width: 200px;">' +
                '<strong style="font-size:1.2rem; display:block; margin-bottom:4px;">' + loc.name + '</strong>' +
                '<span style="font-size:0.95rem;">' + loc.description + '</span><br>' +
                '<a href="https://maps.google.com/?q=' + loc.lat + ',' + loc.lng + '" target="_blank" style="color: #2d7aff; font-size:0.95rem; margin-top:4px; display:inline-block;">Open in Google Maps →</a>' +
            '</div>'
        );
    });

    locations.forEach(function(loc) {
        L.circleMarker([loc.lat, loc.lng], {
            radius: 14,
            color: '#2d7aff',
            weight: 2.2,
            opacity: 0.6,
            fillOpacity: 0.18,
            fillColor: '#2d7aff'
        }).addTo(map);
    });

    // Fix map resize on mobile
    window.addEventListener('resize', function() {
        setTimeout(function() {
            map.invalidateSize();
        }, 200);
    });

    // Fix map after orientation change
    window.addEventListener('orientationchange', function() {
        setTimeout(function() {
            map.invalidateSize();
        }, 400);
    });

    console.log("✅ Map loaded successfully - NO API KEY REQUIRED!");
</script>

</body>
</html>
