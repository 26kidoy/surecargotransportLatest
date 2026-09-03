<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SureCargo | Intelligent Cargo Logistics & Real-Time Tracking</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/icon.png') }}">

    <!-- External Resources -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" id="fontawesome-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    @php
        use App\Models\Booking;
        use App\Models\User;
        use App\Models\Truck;
        use App\Models\Batch;

        // --- ACCURATE DELIVERED SHIPMENTS COUNT (matches admin dashboard) ---
        // Sum delivered bookings from ALL batches (including archived)
        $deliveredShipmentsCount = 0;
        try {
            $batches = Batch::with('bookings')->get();
            foreach ($batches as $batch) {
                $deliveredShipmentsCount += $batch->bookings->where('status', 'delivered')->count();
            }
        } catch (\Exception $e) {
            $deliveredShipmentsCount = 0;
        }

        // Total users and trucks (fallback to 0 on error)
        $totalUsersCount = 0;
        $totalTrucksCount = 0;
        try {
            $totalUsersCount = User::count();
        } catch (\Exception $e) {
            $totalUsersCount = 0;
        }
        try {
            $totalTrucksCount = Truck::count();
        } catch (\Exception $e) {
            $totalTrucksCount = 0;
        }
    @endphp

    <style nonce="{{ $csp_nonce }}">
       /* ===== RESET & GLOBAL ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

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
    --font-base: 'Inter', sans-serif;
    --navbar-height: 80px;
}

html {
    scroll-behavior: smooth;
    scroll-padding-top: var(--navbar-height);
    font-size: 16px;
}

body {
    font-family: var(--font-base);
    color: var(--text-light);
    overflow-x: hidden;
    background: #0a0f1f;
    padding-top: var(--navbar-height);
    min-height: 100vh;
    font-size: 1rem;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ===== HIDE SCROLLBAR ON DESKTOP ===== */
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

/* ===== BACKGROUND ===== */
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

/* ===== PRELOADER ===== */
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #0a0f1f;
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
    margin-top: 1.5rem;
    font-size: 1.75rem;
    font-weight: 800;
    color: white;
}
#preloader .logo-text span {
    color: var(--primary);
}
@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ===== IMAGE SKELETON ===== */
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

/* ===== NAVBAR ===== */
.navbar-custom {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: rgba(6, 12, 24, 0.95);
    backdrop-filter: blur(20px);
    padding: 0.6rem 2rem;
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
    font-size: 1.4rem;
    font-weight: 800;
    color: white;
    text-decoration: none;
    letter-spacing: -0.5px;
}

.navbar-custom .logo span {
    color: var(--primary);
}

.navbar-custom .nav-links {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.navbar-custom .nav-links a {
    color: #f0f4ff;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: color 0.2s;
}

.navbar-custom .nav-links a:hover {
    color: var(--primary-light);
}

/* ===== HAMBURGER ===== */
.menu-icon {
    display: none;
    font-size: 1.5rem;
    color: white;
    cursor: pointer;
    position: relative;
    z-index: 999999 !important;
    pointer-events: auto !important;
    touch-action: manipulation !important;
    -webkit-tap-highlight-color: transparent;
    padding: 0.4rem;
    line-height: 1;
}

/* ===== BUTTONS ===== */
.btn-primary-custom {
    background: var(--primary);
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    font-size: 0.9rem;
    white-space: nowrap;
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
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    border: 2px solid var(--primary);
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    font-size: 0.9rem;
    white-space: nowrap;
}

.btn-outline-custom:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
}

.btn-download {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    font-size: 0.9rem;
    white-space: nowrap;
}

.btn-download:hover {
    transform: translateY(-2px);
    color: white;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
}

.btn-download-sm {
    padding: 0.35rem 1rem;
    font-size: 0.8rem;
}

/* ===== HERO SECTION ===== */
.hero-section {
    min-height: 80vh;
    display: flex;
    align-items: center;
    padding: 3rem 0;
}

.hero-section h1 {
    font-size: 2.8rem;
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 1rem;
    letter-spacing: -1px;
}

.hero-section .lead {
    font-size: 1.1rem;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 1.5rem;
    max-width: 90%;
    line-height: 1.6;
}

.gradient-text {
    background: linear-gradient(135deg, #fff, var(--primary-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.badge-pill-custom {
    background: rgba(45, 122, 255, 0.2);
    backdrop-filter: blur(4px);
    padding: 0.4rem 1.2rem;
    border-radius: 50px;
    font-weight: 500;
    color: #c7e0ff;
    display: inline-block;
    border: 1px solid rgba(45, 122, 255, 0.3);
    font-size: 0.85rem;
}

/* ===== LOCATION IMAGE CARD ===== */
.location-card {
    background-image: linear-gradient(white, rgb(118, 204, 253), white);
    backdrop-filter: blur(12px);
    border-radius: 1.5rem;
    padding: 0.8rem;
    border: 1px solid rgba(45, 122, 255, 0.3);
    transition: transform 0.3s ease;
}

.location-card:hover {
    transform: scale(1.02);
}

.location-card img {
    width: 100%;
    border-radius: 1.2rem;
    height: auto;
    max-width: 100%;
}

.btn-find-us {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: 0.6rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    border: none;
    width: 100%;
    margin-top: 0.8rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    font-size: 0.9rem;
}

.btn-find-us:hover {
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 10px 30px rgba(45, 122, 255, 0.4);
}

/* ===== FEATURES ===== */
.feature-card {
    background: var(--glass-card);
    backdrop-filter: blur(14px);
    border-radius: 1.5rem;
    padding: 1.8rem;
    border: 1px solid rgba(45, 122, 255, 0.3);
    transition: all 0.3s ease;
    height: 100%;
    text-align: center;
}

.feature-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.feature-icon {
    width: 65px;
    height: 65px;
    background: linear-gradient(135deg, rgba(45, 122, 255, 0.2), rgba(37, 99, 235, 0.3));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.8rem;
    color: var(--primary-light);
}

.feature-card h4 {
    font-size: 1.15rem;
    font-weight: 700;
    margin-bottom: 0.6rem;
    letter-spacing: -0.3px;
}

.feature-card p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    line-height: 1.6;
}

/* ===== STATS ===== */
.stats-section {
    background: rgba(8, 16, 30, 0.6);
    backdrop-filter: blur(14px);
    padding: 3rem 0;
    margin: 1.5rem 0;
    border-radius: 2.5rem;
}

.stat-card {
    background: rgba(12, 22, 40, 0.85);
    backdrop-filter: blur(12px);
    border-radius: 1.5rem;
    padding: 1.5rem 1rem;
    border: 1px solid rgba(0, 255, 255, 0.3);
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.1);
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    border-color: rgba(0, 255, 255, 0.8);
    box-shadow: 0 0 40px rgba(0, 255, 255, 0.2);
}

.stat-icon {
    font-size: 2rem;
    color: #0ff;
    margin-bottom: 0.5rem;
}

.stat-number {
    font-size: 2.8rem;
    font-weight: 900;
    background: linear-gradient(135deg, #fff, #b3d4ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1.2;
    letter-spacing: -1px;
}

.stat-card p {
    font-size: 0.95rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.85);
    margin-top: 0.3rem;
    margin-bottom: 0;
}

/* ===== WHY US ===== */
.why-card {
    background: rgba(10, 18, 32, 0.75);
    backdrop-filter: blur(10px);
    border-radius: 1.2rem;
    padding: 1.2rem;
    border-left: 4px solid var(--primary);
    transition: all 0.3s ease;
    margin-bottom: 1rem;
    display: flex;
    align-items: flex-start;
}

.why-card:hover {
    background: rgba(20, 34, 58, 0.9);
    transform: translateX(8px);
}

.why-card .icon {
    font-size: 1.6rem;
    color: var(--primary);
    margin-right: 1.2rem;
    flex-shrink: 0;
}

.why-card h5 {
    font-weight: 700;
    margin-bottom: 0.2rem;
    font-size: 1.05rem;
    letter-spacing: -0.3px;
}

.why-card p {
    color: rgba(255, 255, 255, 0.75);
    margin-bottom: 0;
    font-size: 0.9rem;
}

/* ===== FOOTER ===== */
.footer {
    background: rgba(4, 10, 20, 0.95);
    backdrop-filter: blur(12px);
    border-top: 1px solid rgba(45, 122, 255, 0.2);
    padding: 2.5rem 0 1.5rem;
    margin-top: 2.5rem;
}

.footer a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: color 0.2s;
    font-size: 0.9rem;
}

.footer a:hover {
    color: var(--primary-light);
}

.footer-download-box {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    border-radius: 1rem;
    padding: 1rem;
    margin-top: 0.8rem;
}

.footer-download-box:hover {
    background: rgba(16, 185, 129, 0.15);
}

.social-links a {
    font-size: 1.5rem;
    margin-right: 1rem;
}

/* ===== CHATBOT ===== */
.chatbot-float {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 999999 !important;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 8px 30px rgba(45, 122, 255, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    pointer-events: auto !important;
    touch-action: manipulation !important;
    cursor: pointer;
}

.chatbot-float:hover {
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 12px 40px rgba(45, 122, 255, 0.5);
}

.chatbot-float i {
    font-size: 1.2rem;
}

/* ===== FLOATING CUBE ===== */
.floating-cube {
    position: fixed;
    bottom: 6rem;
    right: 2rem;
    width: 60px;
    height: 60px;
    z-index: 1050;
    perspective: 500px;
    pointer-events: none !important;
}

.cube {
    width: 100%;
    height: 100%;
    position: relative;
    transform-style: preserve-3d;
    animation: spinCube 20s infinite linear;
    pointer-events: none !important;
}

.cube .face {
    position: absolute;
    width: 60px;
    height: 60px;
    background: linear-gradient(145deg, var(--primary), var(--primary-dark));
    border: 1px solid rgba(255, 255, 255, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(45, 122, 255, 0.2);
    pointer-events: none !important;
}

.cube .face i {
    font-size: 1.5rem;
    color: white;
}

.cube .front { transform: translateZ(30px); }
.cube .back { transform: rotateY(180deg) translateZ(30px); }
.cube .right { transform: rotateY(90deg) translateZ(30px); }
.cube .left { transform: rotateY(-90deg) translateZ(30px); }
.cube .top { transform: rotateX(90deg) translateZ(30px); }
.cube .bottom { transform: rotateX(-90deg) translateZ(30px); }

@keyframes spinCube {
    0% { transform: rotateX(0) rotateY(0); }
    100% { transform: rotateX(360deg) rotateY(360deg); }
}

/* ============================================================ */
/* ===== RESPONSIVE - MOBILE FIRST (DeepSeek Style) ===== */
/* ============================================================ */

/* --- Small phones (320px - 400px) --- */
@media (max-width: 400px) {
    :root {
        --navbar-height: 64px;
    }

    html {
        font-size: 15px;
    }

    body {
        font-size: 0.9rem;
        padding-top: var(--navbar-height);
    }

    .navbar-custom {
        padding: 0.3rem 0.6rem;
    }

    .navbar-custom .logo {
        font-size: 1.1rem;
    }

    .menu-icon {
        font-size: 1.3rem;
        padding: 0.2rem;
    }

    .hero-section {
        min-height: 70vh;
        padding: 1.5rem 0;
    }

    .hero-section h1 {
        font-size: 2rem;
        margin-bottom: 0.6rem;
    }

    .hero-section .lead {
        font-size: 0.9rem;
        margin-bottom: 1rem;
        max-width: 100%;
    }

    .badge-pill-custom {
        font-size: 0.7rem;
        padding: 0.2rem 0.7rem;
    }

    .hero-section .d-flex {
        flex-wrap: wrap !important;
        gap: 0.4rem !important;
        justify-content: center;
    }

    .hero-section .btn-primary-custom,
    .hero-section .btn-outline-custom {
        padding: 0.25rem 0.6rem;
        font-size: 0.7rem;
        white-space: nowrap;
    }

    .hero-buttons {
        margin-left: 0;
        justify-content: center !important;
    }

    .location-card {
        padding: 0.5rem;
        border-radius: 1rem;
    }

    .location-card img {
        border-radius: 0.8rem;
    }

    .btn-find-us {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        margin-top: 0.5rem;
    }

    .feature-card {
        padding: 1rem;
        border-radius: 1rem;
    }

    .feature-icon {
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
        margin-bottom: 0.6rem;
    }

    .feature-card h4 {
        font-size: 0.95rem;
    }

    .feature-card p {
        font-size: 0.8rem;
    }

    .stats-section {
        padding: 1.5rem 0;
        margin: 0.8rem 0;
        border-radius: 1.5rem;
    }

    .stat-card {
        padding: 0.8rem 0.4rem;
        border-radius: 1rem;
    }

    .stat-icon {
        font-size: 1.5rem;
        margin-bottom: 0.2rem;
    }

    .stat-number {
        font-size: 1.8rem;
    }

    .stat-card p {
        font-size: 0.75rem;
    }

    .why-card {
        padding: 0.8rem;
        border-left-width: 3px;
        margin-bottom: 0.6rem;
    }

    .why-card .icon {
        font-size: 1.3rem;
        margin-right: 0.7rem;
    }

    .why-card h5 {
        font-size: 0.9rem;
    }

    .why-card p {
        font-size: 0.8rem;
    }

    .section-title {
        font-size: 1.6rem !important;
    }

    .footer {
        padding: 1.2rem 0 0.8rem;
        margin-top: 1.2rem;
    }

    .footer h5 {
        font-size: 1.2rem;
    }

    .footer h6 {
        font-size: 0.9rem;
    }

    .footer a {
        font-size: 0.8rem;
    }

    .footer-download-box {
        padding: 0.6rem;
    }

    .social-links a {
        font-size: 1.2rem;
        margin-right: 0.5rem;
    }

    .chatbot-float {
        bottom: 0.8rem;
        right: 0.6rem;
        padding: 0.35rem 0.8rem;
        font-size: 0.75rem;
        gap: 0.3rem;
        border-radius: 40px;
    }

    .chatbot-float span {
        display: none;
    }

    .chatbot-float i {
        font-size: 1rem;
    }

    .floating-cube {
        display: none;
    }

    .container {
        padding-left: 10px;
        padding-right: 10px;
    }

    .row {
        --bs-gutter-x: 0.6rem;
    }

    .col-6 {
        padding-left: 0.3rem;
        padding-right: 0.3rem;
    }

    .text-small {
        font-size: 0.6rem !important;
    }

    .btn-logout {
        padding: 0.2rem 0.6rem !important;
        font-size: 0.7rem !important;
    }

    .section-spacing {
        padding: 1.2rem 0;
    }
}

/* --- Medium phones (401px - 576px) --- */
@media (min-width: 401px) and (max-width: 576px) {
    :root {
        --navbar-height: 68px;
    }

    html {
        font-size: 15.5px;
    }

    body {
        font-size: 0.95rem;
        padding-top: var(--navbar-height);
    }

    .navbar-custom {
        padding: 0.4rem 0.8rem;
    }

    .navbar-custom .logo {
        font-size: 1.2rem;
    }

    .hero-section h1 {
        font-size: 2.4rem;
    }

    .hero-section .lead {
        font-size: 1rem;
    }

    .hero-section .d-flex {
        flex-wrap: wrap !important;
        gap: 0.4rem !important;
        justify-content: center;
    }

    .hero-buttons {
        margin-left: 0;
        justify-content: center !important;
    }

    .hero-section .btn-primary-custom,
    .hero-section .btn-outline-custom {
        padding: 0.3rem 0.7rem;
        font-size: 0.75rem;
    }

    .feature-card {
        padding: 1.2rem;
    }

    .stat-card {
        padding: 1rem 0.6rem;
    }

    .stat-number {
        font-size: 2.2rem;
    }

    .btn-primary-custom,
    .btn-outline-custom,
    .btn-download {
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
    }

    .chatbot-float span {
        display: none;
    }
}

/* --- Tablets (577px - 768px) --- */
@media (min-width: 577px) and (max-width: 768px) {
    :root {
        --navbar-height: 72px;
    }

    html {
        font-size: 15.5px;
    }

    body {
        font-size: 1rem;
        padding-top: var(--navbar-height);
    }

    .navbar-custom {
        padding: 0.5rem 1rem;
    }

    .navbar-custom .logo {
        font-size: 1.3rem;
    }

    .hero-section h1 {
        font-size: 2.8rem;
    }

    .hero-section .lead {
        font-size: 1.05rem;
    }

    .stat-number {
        font-size: 2.5rem;
    }

    .feature-card {
        padding: 1.5rem;
    }

    .chatbot-float span {
        display: inline;
    }

    .hero-buttons {
        margin-left: 0;
        justify-content: center !important;
    }

    .hero-section .d-flex {
        flex-wrap: wrap !important;
        gap: 0.5rem !important;
        justify-content: center;
    }
}

/* --- Small desktops / large tablets (769px - 992px) --- */
@media (min-width: 769px) and (max-width: 992px) {
    html {
        font-size: 16px;
    }

    body {
        font-size: 1rem;
    }

    .hero-section h1 {
        font-size: 3.2rem;
    }

    .hero-section .lead {
        font-size: 1.1rem;
    }

    .stat-number {
        font-size: 2.8rem;
    }

    .navbar-custom .nav-links a {
        font-size: 0.9rem;
    }

    .hero-buttons {
        margin-left: 0;
    }
}

/* ============================================================ */
/* ===== DESKTOP (993px and above) - DeepSeek Standard ===== */
/* ============================================================ */
@media (min-width: 993px) {
    :root {
        --navbar-height: 80px;
    }

    html {
        font-size: 16px;
    }

    body {
        font-size: 1rem;
        line-height: 1.6;
    }

    .navbar-custom {
        padding: 0.6rem 2.5rem;
    }

    .navbar-custom .logo {
        font-size: 1.5rem;
    }

    .navbar-custom .nav-links a {
        font-size: 0.95rem;
        font-weight: 500;
    }

    .btn-primary-custom,
    .btn-outline-custom,
    .btn-download {
        font-size: 0.95rem;
        padding: 0.5rem 1.6rem;
    }

    .hero-section {
        min-height: 75vh;
        padding: 3rem 0;
    }

    .hero-section h1 {
        font-size: 3.8rem;
        line-height: 1.1;
        margin-bottom: 1.2rem;
        letter-spacing: -1.5px;
    }

    .hero-section .lead {
        font-size: 1.2rem;
        max-width: 85%;
        margin-bottom: 1.8rem;
    }

    .badge-pill-custom {
        font-size: 0.9rem;
        padding: 0.4rem 1.4rem;
    }

    .location-card {
        padding: 0.8rem;
        border-radius: 1.5rem;
    }

    .btn-find-us {
        font-size: 0.95rem;
        padding: 0.6rem 1.5rem;
    }

    .feature-card {
        padding: 2rem 1.5rem;
        border-radius: 1.5rem;
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }

    .feature-card h4 {
        font-size: 1.25rem;
    }

    .feature-card p {
        font-size: 0.95rem;
    }

    .stats-section {
        padding: 3rem 0;
        margin: 2rem 0;
        border-radius: 2.5rem;
    }

    .stat-card {
        padding: 1.8rem 1rem;
        border-radius: 1.5rem;
    }

    .stat-icon {
        font-size: 2.2rem;
    }

    .stat-number {
        font-size: 3.2rem;
    }

    .stat-card p {
        font-size: 1rem;
    }

    .why-card {
        padding: 1.2rem 1.5rem;
        border-radius: 1.2rem;
    }

    .why-card .icon {
        font-size: 1.6rem;
    }

    .why-card h5 {
        font-size: 1.1rem;
    }

    .why-card p {
        font-size: 0.95rem;
    }

    .section-title {
        font-size: 2.5rem !important;
    }

    .footer {
        padding: 3rem 0 1.5rem;
        margin-top: 3rem;
    }

    .footer a {
        font-size: 0.95rem;
    }

    .footer h5 {
        font-size: 1.6rem;
    }

    .footer h6 {
        font-size: 1.1rem;
    }

    .social-links a {
        font-size: 1.6rem;
    }

    .chatbot-float {
        bottom: 2.5rem;
        right: 2.5rem;
        padding: 0.7rem 1.5rem;
        font-size: 0.95rem;
    }

    .chatbot-float i {
        font-size: 1.3rem;
    }
}

/* --- Large desktops (1400px and above) --- */
@media (min-width: 1400px) {
    html {
        font-size: 16px;
    }

    body {
        font-size: 1rem;
    }

    .hero-section h1 {
        font-size: 4.2rem;
    }

    .hero-section .lead {
        font-size: 1.3rem;
        max-width: 80%;
    }

    .stat-number {
        font-size: 3.5rem;
    }

    .section-title {
        font-size: 2.8rem !important;
    }

    .container {
        max-width: 1320px;
    }
}

/* ===== UTILITY ===== */
.section-title {
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    font-weight: 800;
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
}

.text-muted-light {
    color: rgba(255, 255, 255, 0.7);
}

.img-rounded {
    border-radius: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    max-width: 100%;
    height: auto;
}

.section-spacing {
    padding: 2.5rem 0;
}

.btn-logout {
    background: transparent !important;
    border-color: rgba(255, 255, 255, 0.3) !important;
}

.text-small {
    font-size: 0.75rem;
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

/* ===== LOADING STATE ===== */
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
.icon-skeleton {
    display: inline-block;
    width: 1.2em;
    height: 1.2em;
    background: rgba(255,255,255,0.1);
    border-radius: 4px;
    animation: shimmer 1.5s infinite;
    vertical-align: middle;
    margin: 0 0.15em;
}

/* ===== HIDDEN AUDIO PLAYER ===== */
#bgAudio {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
    user-select: none;
}

/* ============================================================ */
/* ===== RESPONSIVE - MOBILE MENU OVERRIDES ===== */
/* ============================================================ */
@media (max-width: 768px) {
    .navbar-custom .nav-links {
        display: none;
        flex-direction: column;
        width: 100%;
        background: rgba(6, 12, 24, 0.98);
        backdrop-filter: blur(12px);
        padding: 0.8rem 0.6rem;
        border-radius: 0.8rem;
        border: 1px solid rgba(45, 122, 255, 0.2);
        margin-top: 8px;
        gap: 0.4rem;
    }

    .navbar-custom .nav-links.show {
        display: flex;
    }

    .navbar-custom .nav-links a {
        padding: 0.4rem 0.6rem;
        font-size: 0.9rem;
        width: 100%;
        text-align: center;
        border-radius: 30px;
        transition: background 0.2s;
    }

    .navbar-custom .nav-links a:hover {
        background: rgba(45, 122, 255, 0.15);
    }

    .navbar-custom .nav-links .btn-download-sm,
    .navbar-custom .nav-links .btn-primary-custom,
    .navbar-custom .nav-links .btn-outline-custom {
        width: 100%;
        text-align: center;
        margin: 0.15rem 0;
        white-space: normal;
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
    }

    .menu-icon {
        display: block;
    }

    .chatbot-float {
        bottom: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
    }
}

@media (max-width: 400px) {
    .hero-section .btn-primary-custom i,
    .hero-section .btn-outline-custom i {
        margin-right: 0.15rem;
    }
}

@media (min-width: 401px) and (max-width: 576px) {
    .hero-section .btn-primary-custom i,
    .hero-section .btn-outline-custom i {
        margin-right: 0.2rem;
    }
}

/* ============================================================ */
/* ===== ONBOARDING MODAL – full screen, one-time ===== */
/* ============================================================ */
.onboarding-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.92);
    backdrop-filter: blur(12px);
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    transition: opacity 0.4s ease;
}
.onboarding-modal.hidden {
    opacity: 0;
    pointer-events: none;
}
.onboarding-card {
    background: rgba(10, 18, 32, 0.97);
    backdrop-filter: blur(20px);
    border-radius: 2rem;
    border: 1px solid rgba(45, 122, 255, 0.4);
    padding: 2rem 2rem 2.2rem;
    max-width: 560px;
    width: 100%;
    box-shadow: 0 30px 60px rgba(0,0,0,0.6);
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease;
}
.onboarding-card .step-indicator {
    text-align: center;
    font-size: 0.9rem;
    font-weight: 700;
    color: rgba(255,255,255,0.5);
    letter-spacing: 3px;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
}
.onboarding-card .step-title {
    font-size: 1.8rem;
    font-weight: 800;
    text-align: center;
    margin-bottom: 0.8rem;
    color: #fff;
    letter-spacing: -0.5px;
}
.onboarding-card .step-title span {
    color: var(--primary-light);
}
.onboarding-card .step-desc {
    color: rgba(255,255,255,0.8);
    text-align: center;
    font-size: 1.05rem;
    margin-bottom: 1.5rem;
    font-weight: 400;
    line-height: 1.5;
}
.onboarding-card .btn-choice {
    width: 100%;
    padding: 0.9rem;
    border-radius: 60px;
    font-weight: 700;
    font-size: 1.05rem;
    border: 2px solid rgba(45,122,255,0.3);
    background: rgba(255,255,255,0.05);
    color: #fff;
    transition: all 0.2s;
    margin-bottom: 0.75rem;
    cursor: pointer;
}
.onboarding-card .btn-choice:hover {
    background: var(--primary);
    border-color: var(--primary);
    transform: scale(1.02);
}
.onboarding-card .btn-choice i {
    margin-right: 0.6rem;
    font-size: 1.1rem;
}
.onboarding-card .form-control {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    color: #fff;
    border-radius: 60px;
    padding: 0.8rem 1.4rem;
    font-size: 1rem;
    font-weight: 400;
    width: 100%;
    transition: all 0.3s;
}
.onboarding-card .form-control:focus {
    background: rgba(255,255,255,0.12);
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(45,122,255,0.2);
    color: #fff;
    outline: none;
}
.onboarding-card .form-control option {
    background: #1a1f2e;
    color: #fff;
    padding: 0.5rem;
}
.onboarding-card .form-control::placeholder {
    color: rgba(255,255,255,0.4);
    font-weight: 300;
}
.onboarding-card .form-label {
    color: rgba(255,255,255,0.8);
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.4rem;
    display: block;
}
.onboarding-card .btn-submit {
    width: 100%;
    padding: 0.9rem;
    border-radius: 60px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border: none;
    color: #fff;
    font-weight: 700;
    font-size: 1.05rem;
    transition: all 0.3s;
    margin-top: 0.5rem;
    cursor: pointer;
}
.onboarding-card .btn-submit:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(45,122,255,0.4);
}
.onboarding-card .btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}
.onboarding-card .btn-back {
    background: transparent;
    border: none;
    color: rgba(255,255,255,0.5);
    font-size: 0.9rem;
    padding: 0.6rem 0;
    transition: color 0.2s;
    cursor: pointer;
    font-weight: 600;
}
.onboarding-card .btn-back:hover {
    color: #fff;
}
.onboarding-card .slide-container {
    overflow: hidden;
}
.onboarding-card .slide-track {
    display: flex;
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.onboarding-card .slide {
    min-width: 100%;
    padding: 0.2rem 0;
}
.onboarding-card .error-msg {
    color: #f87171;
    font-size: 0.9rem;
    margin-top: 0.6rem;
    display: none;
    font-weight: 500;
}
.onboarding-card .error-msg.show {
    display: block;
}
.onboarding-card .success-msg {
    color: #34d399;
    font-size: 0.95rem;
    margin-top: 0.6rem;
    display: none;
    font-weight: 600;
    text-align: center;
    padding: 0.8rem;
    background: rgba(52, 211, 153, 0.1);
    border-radius: 1rem;
    border: 1px solid rgba(52, 211, 153, 0.2);
}
.onboarding-card .success-msg.show {
    display: block;
}
/* Countdown timer styling */
.onboarding-card .countdown-timer {
    color: #fbbf24;
    font-weight: 700;
    font-size: 1.1rem;
    text-align: center;
    margin-top: 0.5rem;
    padding: 0.5rem;
    background: rgba(251, 191, 36, 0.1);
    border-radius: 1rem;
    border: 1px solid rgba(251, 191, 36, 0.2);
    display: none;
}
.onboarding-card .countdown-timer.show {
    display: block;
}
/* Character counter styling - MAX limit */
.onboarding-card .char-counter {
    text-align: right;
    font-size: 0.8rem;
    color: rgba(255,255,255,0.4);
    margin-top: 0.2rem;
}
.onboarding-card .char-counter.limit-reached {
    color: #f87171;
}
/* small tweaks for mobile */
@media (max-width: 480px) {
    .onboarding-card {
        padding: 1.5rem 1.2rem;
        border-radius: 1.5rem;
    }
    .onboarding-card .step-title {
        font-size: 1.4rem;
    }
    .onboarding-card .step-desc {
        font-size: 0.9rem;
    }
    .onboarding-card .btn-choice {
        font-size: 0.9rem;
        padding: 0.7rem;
    }
    .onboarding-card .form-control {
        font-size: 0.9rem;
        padding: 0.6rem 1rem;
    }
    .onboarding-card .btn-submit {
        font-size: 0.9rem;
        padding: 0.7rem;
    }
}
/* ============================================================ */
/* ===== CONTACT BLOCK - MODERN SVG ICONS ===== */
/* ============================================================ */

.contact-block {
    margin: 2rem 0 1.2rem 0;
    background: rgba(0, 20, 40, 0.45);
    backdrop-filter: blur(10px);
    border-radius: 32px;
    padding: 1.5rem 2rem;
    border: 1px solid rgba(255, 255, 255, 0.06);
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.02), 0 10px 30px -10px rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 18px;
    font-size: 1rem;
    padding: 8px 12px;
    border-radius: 60px;
    background: rgba(255, 255, 255, 0.02);
    transition: all 0.2s ease;
    border-left: 2px solid transparent;
    color: #d4e6ff;
    font-weight: 400;
    letter-spacing: 0.2px;
}

.contact-item:hover {
    background: rgba(255, 255, 255, 0.04);
    border-left-color: #5a9aff;
    padding-left: 20px;
    color: white;
}

.contact-icon {
    width: 28px;
    height: 28px;
    flex-shrink: 0;
    stroke: #7bb3ff;
    filter: drop-shadow(0 0 6px rgba(60, 140, 255, 0.3));
    transition: all 0.2s ease;
}

.contact-item:hover .contact-icon {
    stroke: #b0d0ff;
    transform: scale(1.05);
}

.contact-item span {
    word-break: break-word;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* ============================================================ */
/* ===== CONTACT BLOCK - RESPONSIVE ===== */
/* ============================================================ */

/* Small phones (320px - 400px) */
@media (max-width: 400px) {
    .contact-block {
        padding: 0.8rem 0.8rem;
        gap: 0.5rem;
        border-radius: 20px;
        margin: 1.2rem 0 0.8rem 0;
    }

    .contact-item {
        padding: 5px 8px;
        gap: 10px;
        font-size: 0.8rem;
        border-left-width: 2px;
    }

    .contact-item:hover {
        padding-left: 10px;
    }

    .contact-icon {
        width: 18px;
        height: 18px;
        filter: drop-shadow(0 0 3px rgba(60, 140, 255, 0.15));
    }

    .contact-item span {
        font-size: 0.8rem;
    }
}

/* Medium phones (401px - 576px) */
@media (min-width: 401px) and (max-width: 576px) {
    .contact-block {
        padding: 1rem 1.2rem;
        gap: 0.8rem;
        margin: 1.5rem 0 1rem 0;
        border-radius: 24px;
    }

    .contact-item {
        padding: 6px 10px;
        gap: 14px;
        font-size: 0.9rem;
        border-left-width: 2px;
        border-radius: 40px;
    }

    .contact-item:hover {
        padding-left: 14px;
    }

    .contact-icon {
        width: 22px;
        height: 22px;
        filter: drop-shadow(0 0 4px rgba(60, 140, 255, 0.2));
    }

    .contact-item span {
        font-size: 0.9rem;
        word-break: break-word;
    }
}

/* Tablets (577px - 768px) */
@media (min-width: 577px) and (max-width: 768px) {
    .contact-block {
        padding: 1.2rem 1.5rem;
        gap: 0.9rem;
        border-radius: 28px;
    }

    .contact-item {
        padding: 7px 12px;
        gap: 16px;
        font-size: 0.95rem;
    }

    .contact-icon {
        width: 24px;
        height: 24px;
    }
}

/* Small desktops / large tablets (769px - 992px) */
@media (min-width: 769px) and (max-width: 992px) {
    .contact-block {
        padding: 1.4rem 1.8rem;
        gap: 1rem;
        border-radius: 32px;
    }

    .contact-item {
        padding: 8px 14px;
        gap: 18px;
        font-size: 1rem;
    }

    .contact-icon {
        width: 26px;
        height: 26px;
    }

    .contact-item span {
        font-size: 1rem;
    }
}

/* Desktop (993px and above) */
@media (min-width: 993px) {
    .contact-block {
        padding: 1.8rem 2.2rem;
        gap: 1.2rem;
        border-radius: 36px;
        margin: 2.5rem 0 1.5rem 0;
    }

    .contact-item {
        padding: 10px 16px;
        gap: 20px;
        font-size: 1.05rem;
        border-left-width: 3px;
    }

    .contact-item:hover {
        padding-left: 24px;
    }

    .contact-icon {
        width: 30px;
        height: 30px;
        filter: drop-shadow(0 0 8px rgba(60, 140, 255, 0.35));
    }

    .contact-item span {
        font-size: 1.05rem;
    }
}

/* Large desktops (1400px and above) */
@media (min-width: 1400px) {
    .contact-block {
        padding: 2rem 2.5rem;
        gap: 1.4rem;
        border-radius: 40px;
    }

    .contact-item {
        padding: 12px 20px;
        gap: 24px;
        font-size: 1.1rem;
    }

    .contact-icon {
        width: 32px;
        height: 32px;
    }

    .contact-item span {
        font-size: 1.1rem;
    }
}

/* ============================================================ */
/* ===== ONBOARDING MODAL CONTACT BLOCK OVERRIDES ===== */
/* ============================================================ */

.onboarding-card .contact-block {
    background: rgba(0, 20, 40, 0.35);
    padding: 1.2rem 1.5rem;
    margin: 1.5rem 0 1rem 0;
    border-radius: 28px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.onboarding-card .contact-item {
    padding: 6px 10px;
    gap: 14px;
    font-size: 0.9rem;
    border-left-width: 2px;
    background: rgba(255, 255, 255, 0.01);
}

.onboarding-card .contact-item:hover {
    padding-left: 14px;
    background: rgba(255, 255, 255, 0.03);
}

.onboarding-card .contact-icon {
    width: 22px;
    height: 22px;
    filter: drop-shadow(0 0 4px rgba(60, 140, 255, 0.2));
}

.onboarding-card .contact-item span {
    font-size: 0.9rem;
}

/* Mobile onboarding contact block */
@media (max-width: 576px) {
    .onboarding-card .contact-block {
        padding: 0.8rem 1rem;
        gap: 0.6rem;
        margin: 1.2rem 0 0.8rem 0;
        border-radius: 20px;
    }

    .onboarding-card .contact-item {
        padding: 4px 8px;
        gap: 10px;
        font-size: 0.8rem;
    }

    .onboarding-card .contact-icon {
        width: 18px;
        height: 18px;
    }

    .onboarding-card .contact-item span {
        font-size: 0.8rem;
    }
}

@media (max-width: 400px) {
    .onboarding-card .contact-block {
        padding: 0.6rem 0.6rem;
        gap: 0.4rem;
        border-radius: 16px;
        margin: 1rem 0 0.6rem 0;
    }

    .onboarding-card .contact-item {
        padding: 3px 6px;
        gap: 8px;
        font-size: 0.7rem;
        border-left-width: 2px;
    }

    .onboarding-card .contact-icon {
        width: 16px;
        height: 16px;
        filter: drop-shadow(0 0 2px rgba(60, 140, 255, 0.1));
    }

    .onboarding-card .contact-item span {
        font-size: 0.7rem;
    }
}

/* ===== CHATBOT DISABLED STATE ===== */
.chatbot-float.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none !important;
    filter: grayscale(0.6);
    box-shadow: none !important;
}
.chatbot-float.disabled:hover {
    transform: none !important;
    box-shadow: none !important;
}
    </style>
</head>
<body>


<div class="onboarding-modal" id="onboardingModal">
    <div class="onboarding-card">
        <div class="step-indicator" id="stepIndicator">STEP 0 / 1</div>
        <div class="slide-container">
            <div class="slide-track" id="slideTrack">
                <!-- STEP 0 -->
                <div class="slide" id="slide0">
    <div class="step-title">🔒 <span>Secure</span> Access</div>
    <div class="step-desc">This site is secured by SureCargo Transport Admin. Contact details below:</div>
    <button class="btn-choice" id="newCustomerBtn"><i class="fas fa-user-plus"></i> Request Access</button>
    <button class="btn-choice" id="oldCustomerBtn"><i class="fas fa-user-check"></i>Access code</button>


    <div class="contact-block">

        <div class="contact-item">
            <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2" />
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
            </svg>
            <span>Email: tradiorogelio@gmail.com</span>
        </div>
        <div class="contact-item">
            <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.574 2.81.7A2 2 0 0 1 22 16.92z" />
            </svg>
            <span>Phone: 09482106844</span>
        </div>
    </div>
                </div>
                <!-- STEP 1 – New Customer -->
                <div class="slide" id="slide1new">
                    <div class="step-title">👋 <span>Welcome</span> New Customer</div>
                    <div class="step-desc">Tell us how you found us and leave a message for admin.</div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-info-circle me-1"></i> How did you know about SureCargo?</label>
                        <select class="form-control" id="knowSite">
                            <option value="">Select an option...</option>
                            <option value="social">📱 Social Media</option>
                            <option value="friend">🤝 Friend / Referral</option>
                            <option value="search">🔍 Search Engine</option>
                            <option value="ad">📢 Advertisement</option>
                            <option value="other">📌 Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-comment me-1"></i> Why we would trust you?? - Cite some text about our company /who recommend you? / Cite your main intension to our company -bisaya,tagalog,cebuano--accepted!</label>
                        <textarea class="form-control" id="messageText" rows="4" placeholder="Write your message to admin (maximum 200 characters)..." style="border-radius:1.2rem;resize:vertical;min-height:120px;" maxlength="200"></textarea>
                        <div class="char-counter" id="charCounter">0 / 200 max</div>
                    </div>
                    <button class="btn-submit" id="submitNewCustomer"><i class="fas fa-paper-plane me-2"></i> Submit Request</button>
                    <button class="btn-back" id="backFromNew"><i class="fas fa-arrow-left me-1"></i> Back</button>
                    <div class="error-msg" id="newError">⚠️ Please select how you know us.</div>
                    <div class="success-msg" id="newSuccess">✅ Your request has been submitted! Please wait for admin approval.</div>
                </div>
                <!-- STEP 1 – Old Customer -->
                <div class="slide" id="slide1old">
                    <div class="step-title">🔑 <span>Access</span> Code</div>
                    <div class="step-desc">Enter your secret code to access the platform. </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock me-1"></i> Access Code</label>
                        <input type="password" class="form-control" id="secretCodeInput" placeholder="Enter your access code" maxlength="20" inputmode="numeric" pattern="[0-9]*">
                        <div class="char-counter" id="attemptCounter">Attempts remaining: 3</div>
                        <div class="countdown-timer" id="countdownTimer">⏳ Please wait 10:00 before trying again</div>
                    </div>
                    <button class="btn-submit" id="submitOldCustomer"><i class="fas fa-unlock me-2"></i> Unlock</button>
                    <button class="btn-back" id="backFromOld"><i class="fas fa-arrow-left me-1"></i> Back</button>
                    <div class="error-msg" id="oldError">❌ Invalid access code. Please try again.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== PRELOADER ===== -->
<div id="preloader">
    <div class="spinner"></div>
    <div class="logo-text">Sure<span>Cargo</span></div>
</div>

<div class="page-wrapper">

<!-- ===== HIDDEN AUDIO ELEMENTS ===== -->
<audio id="bgAudio" src="{{ asset('audio/truckengine.mp3') }}" loop preload="auto"></audio>
<audio id="clickAudio" src="{{ asset('audio/click.mp3') }}" preload="auto"></audio>

<!-- ===== NAVBAR ===== -->
<nav class="navbar-custom">
    <div class="nav-container">
        <a href="#" class="logo">Sure<span>Cargo</span></a>
        <div class="menu-icon" id="menuIcon">
            <i class="fas fa-bars"></i>
        </div>
        <div class="nav-links" id="navLinks">
            <a href="#home">Home</a>
            <a href="#features">Features</a>
            <a href="{{ route('about') }}">About</a>

            <a href="{{ asset('assets/apk/surecargo.apk') }}" class="btn-download btn-download-sm" download>
                <i class="fas fa-download"></i>Download Apk
            </a>

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

<!-- ===== CHATBOT FLOATING BUTTON - DISABLED UNTIL AUTHENTICATED ===== -->
<a href="{{ route('chatbot') }}" class="chatbot-float disabled" id="chatButton">
    <i class="fas fa-comment-dots"></i>
    <span>Ask me</span>
</a>

<!-- ===== HERO SECTION ===== -->
<section class="hero-section" id="home">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-7 text-center text-lg-start" data-aos="fade-up">
                <div class="mb-4">
                    <span class="badge-pill-custom">
                        <i class="fas fa-rocket me-2"></i> Next-Gen Intelligence
                    </span>
                </div>
                <h1>Ship Smarter, <br><span class="gradient-text">Track Instantly</span></h1>
                <p class="lead">Enterprise-grade cargo logistics with real-time visibility, routing, and security all in one powerful platform.</p>
                @guest
                    <div class="d-flex flex-wrap gap-3 hero-buttons">
                        <a href="{{ route('login') }}" class="btn-primary-custom">
                            <i class="fas fa-arrow-right-to-bracket me-2"></i> Launch Dashboard
                        </a>
                        <a href="{{ route('register') }}" class="btn-outline-custom">
                            <i class="fas fa-user-plus me-2"></i> Create Account
                        </a>
                    </div>
                @endguest
                @auth
                    <div class="d-flex flex-wrap gap-3 hero-buttons">
                        <a href="{{ url('/dashboard') }}" class="btn-primary-custom">
                            <i class="fas fa-tachometer-alt me-2"></i> Go to Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-outline-custom btn-logout">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
            <div class="col-lg-5 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">
                <div class="location-card">
                    <img src="{{ asset('assets/display.jpg') }}" alt="Our Locations" class="img-skeleton" onerror="this.src='https://via.placeholder.com/600x400/1a5ad9/ffffff?text=SureCargo'">
                    <a href="{{ url('/find') }}" class="btn-find-us">
                        <i class="fas fa-map-marker-alt me-2"></i> Find Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== FEATURES SECTION ===== -->
<section class="section-spacing" id="features">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge-pill-custom">Core Capabilities</span>
            <h2 class="section-title mt-3">Intelligent Logistics Suite</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-truck-fast"></i></div>
                    <h4>Express Booking</h4>
                    <p>Smart booking engine reduces entry time by 60% — instant quotes, fast dispatch.</p>
                    <div class="mt-3 text-primary">
                        <i class="fas fa-arrow-right me-1"></i> <strong>2-min setup</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-satellite-dish"></i></div>
                    <h4>Live Tracking</h4>
                    <p>Real‑time tracking with accurate ETA updates every 3 seconds.</p>
                    <div class="mt-3 text-success">
                        <i class="fas fa-chart-line me-1"></i> <strong>100% visibility</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-virus"></i></div>
                    <h4>CargoShield™</h4>
                    <p>Comprehensive protection with automated claims & risk monitoring.</p>
                    <div class="mt-3 text-warning">
                        <i class="fas fa-lock me-1"></i> <strong>Fully bonded</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATS SECTION ===== -->
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-box-open"></i></div>
                    <div class="stat-number" id="counter1">0</div>
                    <p>Shipments Delivered</p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-truck"></i></div>
                    <div class="stat-number" id="counter2">0</div>
                    <p>Active Drivers</p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-handshake"></i></div>
                    <div class="stat-number" id="counter3">0</div>
                    <p>Partners</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== WHY US SECTION ===== -->
<section class="section-spacing">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <img src="{{ asset('assets/eggy.jpg') }}" alt="Supply chain excellence" class="img-fluid img-rounded img-skeleton" onerror="this.src='https://via.placeholder.com/600x400/1a5ad9/ffffff?text=Supply+Chain'">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="badge-pill-custom">Why SureCargo</span>
                <h2 class="section-title mt-3">Engineered for Supply Chain Excellence</h2>

                <div class="why-card">
                    <div class="icon"><i class="fas fa-charging-station"></i></div>
                    <div>
                        <h5>Carbon-Neutral Logistics</h5>
                        <p>Offsetting 110% of emissions — green operations.</p>
                    </div>
                </div>

                <div class="why-card">
                    <div class="icon"><i class="fas fa-chart-simple"></i></div>
                    <div>
                        <h5>Predictive Analytics</h5>
                        <p>AI-powered delay predictions & proactive rerouting.</p>
                    </div>
                </div>

                <div class="why-card">
                    <div class="icon"><i class="fas fa-headset"></i></div>
                    <div>
                        <h5>24/7 Dedicated Support</h5>
                        <p>Average human response under 45 seconds.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="text-white fw-bold fs-4">SureCargo</h5>
                <p class="text-muted-light">Redefining global freight with intelligent logistics & real-time intelligence.</p>
                <div class="footer-download-box">
                    <p class="mb-1">
                        <i class="fas fa-mobile-alt text-success me-2"></i>
                        <strong>Get the Android App</strong>
                    </p>
                    <a href="{{ asset('assets/apk/surecargo.apk') }}" class="btn-download" download>
                        <i class="fas fa-download"></i> Download APK
                    </a>
                    <small class="d-block text-muted-light mt-1 text-small">
                        Version 1.0.0 • Android 6.0+
                    </small>
                </div>
            </div>
            <div class="col-md-3">
                <h6 class="text-white fw-bold">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('about') }}">About Us</a></li>
                    <li class="mb-2"><a href="{{ url('/find') }}">Find Us</a></li>
                    <li class="mb-2"><a href="{{ asset('assets/apk/surecargo.apk') }}" download>
                        <i class="fas fa-download text-success me-1"></i> Download App
                    </a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-white fw-bold">Connect</h6>
                <div class="social-links mt-2">
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 divider-light">
        <p class="text-center text-muted-light mb-0">&copy; {{ date('Y') }} SureCargo Inc. — Seamless logistics, absolute clarity.</p>
    </div>
</footer>

</div>

<!-- ===== SCRIPTS ===== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script nonce="{{ $csp_nonce }}">
    // ============================================================
    // 0. BACKGROUND AUDIO - FIXED
    // ============================================================
    (function() {
        var bgAudio = document.getElementById('bgAudio');
        if (!bgAudio) return;

        bgAudio.volume = 0.3;
        bgAudio.loop = true;

        var audioStarted = false;

        function startAudio() {
            if (audioStarted) return;
            bgAudio.play().then(function() {
                audioStarted = true;
            }).catch(function(e) {
                // Will retry on user interaction
            });
        }

        // Try to start on load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(startAudio, 500);
        });

        // Start on any user interaction
        var events = ['click', 'touchstart', 'keydown', 'scroll', 'mousemove'];
        function handleInteraction() {
            startAudio();
            events.forEach(function(ev) {
                document.removeEventListener(ev, handleInteraction);
            });
        }
        events.forEach(function(ev) {
            document.addEventListener(ev, handleInteraction);
        });

        // Save state
        window.addEventListener('beforeunload', function() {
            try {
                sessionStorage.setItem('bgAudioTime', bgAudio.currentTime);
                sessionStorage.setItem('bgAudioPlaying', audioStarted ? 'true' : 'false');
            } catch(e) {}
        });

        window.addEventListener('load', function() {
            try {
                var savedTime = sessionStorage.getItem('bgAudioTime');
                var wasPlaying = sessionStorage.getItem('bgAudioPlaying');
                if (savedTime && bgAudio) {
                    bgAudio.currentTime = parseFloat(savedTime);
                }
                if (wasPlaying === 'true' && bgAudio) {
                    startAudio();
                }
                sessionStorage.removeItem('bgAudioTime');
                sessionStorage.removeItem('bgAudioPlaying');
            } catch(e) {}
        });
    })();

   // ============================================================
// 1. ONBOARDING MODAL – with automatic approval polling
//    ENHANCED: Message max 200 chars, Secret code numbers only + 3 attempts + 10min lockout
// ============================================================
(function() {
    var modal = document.getElementById('onboardingModal');
    var track = document.getElementById('slideTrack');
    var stepIndicator = document.getElementById('stepIndicator');
    var currentSlide = 0;
    var pollInterval = null;

    // DOM refs
    var newCustomerBtn = document.getElementById('newCustomerBtn');
    var oldCustomerBtn = document.getElementById('oldCustomerBtn');
    var backFromNew = document.getElementById('backFromNew');
    var backFromOld = document.getElementById('backFromOld');
    var submitNew = document.getElementById('submitNewCustomer');
    var submitOld = document.getElementById('submitOldCustomer');
    var knowSite = document.getElementById('knowSite');
    var messageText = document.getElementById('messageText');
    var charCounter = document.getElementById('charCounter');
    var secretInput = document.getElementById('secretCodeInput');
    var attemptCounter = document.getElementById('attemptCounter');
    var countdownTimer = document.getElementById('countdownTimer');
    var newError = document.getElementById('newError');
    var oldError = document.getElementById('oldError');
    var newSuccess = document.getElementById('newSuccess');

    // ===== SECRET CODE STATE =====
    var secretAttempts = 3;
    var isLockedOut = false;
    var lockoutEndTime = null;
    var countdownInterval = null;

    // Load state from sessionStorage
    function loadSecretState() {
        var saved = sessionStorage.getItem('secret_code_attempts');
        if (saved !== null) {
            secretAttempts = parseInt(saved, 10);
        }
        var savedLockout = sessionStorage.getItem('secret_code_lockout_end');
        if (savedLockout) {
            lockoutEndTime = parseInt(savedLockout, 10);
            if (lockoutEndTime > Date.now()) {
                isLockedOut = true;
            } else {
                // Lockout expired, reset
                secretAttempts = 3;
                isLockedOut = false;
                sessionStorage.setItem('secret_code_attempts', '3');
                sessionStorage.removeItem('secret_code_lockout_end');
            }
        }
        updateSecretUI();
        if (isLockedOut) {
            startCountdown();
        }
    }

    function saveSecretState() {
        sessionStorage.setItem('secret_code_attempts', String(secretAttempts));
        if (isLockedOut && lockoutEndTime) {
            sessionStorage.setItem('secret_code_lockout_end', String(lockoutEndTime));
        } else {
            sessionStorage.removeItem('secret_code_lockout_end');
        }
        updateSecretUI();
    }

    function updateSecretUI() {
        if (attemptCounter) {
            if (isLockedOut) {
                attemptCounter.textContent = '⛔ Locked out - please wait';
                attemptCounter.style.color = '#f87171';
            } else {
                attemptCounter.textContent = 'Attempts remaining: ' + secretAttempts;
                attemptCounter.style.color = secretAttempts <= 1 ? '#fbbf24' : 'rgba(255,255,255,0.6)';
            }
        }
        if (countdownTimer) {
            if (isLockedOut) {
                countdownTimer.classList.add('show');
            } else {
                countdownTimer.classList.remove('show');
            }
        }
        if (secretInput) {
            secretInput.disabled = isLockedOut;
        }
        if (submitOld) {
            submitOld.disabled = isLockedOut;
        }
    }

    function startCountdown() {
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }
        countdownInterval = setInterval(function() {
            if (!lockoutEndTime) {
                clearInterval(countdownInterval);
                return;
            }
            var remaining = Math.max(0, Math.floor((lockoutEndTime - Date.now()) / 1000));
            if (remaining <= 0) {
                // Lockout expired
                clearInterval(countdownInterval);
                countdownInterval = null;
                isLockedOut = false;
                secretAttempts = 3;
                saveSecretState();
                updateSecretUI();
                if (countdownTimer) {
                    countdownTimer.classList.remove('show');
                }
                if (attemptCounter) {
                    attemptCounter.textContent = 'Attempts remaining: 3';
                    attemptCounter.style.color = 'rgba(255,255,255,0.6)';
                }
                return;
            }
            var minutes = Math.floor(remaining / 60);
            var seconds = remaining % 60;
            if (countdownTimer) {
                countdownTimer.textContent = '⏳ Please wait ' +
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0') + ' before trying again';
            }
        }, 1000);
    }

    // Restrict secret input to numbers only
    if (secretInput) {
        secretInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        secretInput.addEventListener('keydown', function(e) {
            // Allow backspace, delete, tab, escape, enter, arrow keys
            var allowed = [8, 9, 13, 27, 37, 38, 39, 40, 46];
            if (allowed.indexOf(e.keyCode) !== -1) {
                return;
            }
            // Allow number keys
            if (e.key >= '0' && e.key <= '9') {
                return;
            }
            if (e.key === 'Enter') {
                submitOld.click();
                return;
            }
            e.preventDefault();
        });
    }

    // ===== CHARACTER COUNTER for message (max 200) =====
    if (messageText && charCounter) {
        var maxLength = 200;

        function updateCharCounter() {
            var len = messageText.value.length;
            charCounter.textContent = len + ' / ' + maxLength + ' max';
            if (len >= maxLength) {
                charCounter.classList.add('limit-reached');
                charCounter.style.color = '#f87171';
            } else {
                charCounter.classList.remove('limit-reached');
                charCounter.style.color = 'rgba(255,255,255,0.4)';
            }
        }
        messageText.addEventListener('input', updateCharCounter);
        updateCharCounter();

        // Also count paste events
        messageText.addEventListener('paste', function() {
            setTimeout(updateCharCounter, 10);
        });

        // Enforce max length on paste
        messageText.addEventListener('paste', function(e) {
            var pastedText = (e.clipboardData || window.clipboardData).getData('text');
            var currentText = this.value;
            var currentSelectionStart = this.selectionStart;
            var currentSelectionEnd = this.selectionEnd;

            // Calculate new length after paste
            var newLength = currentText.length - (currentSelectionEnd - currentSelectionStart) + pastedText.length;
            if (newLength > maxLength) {
                e.preventDefault();
                // Truncate pasted text
                var allowedLength = maxLength - (currentText.length - (currentSelectionEnd - currentSelectionStart));
                if (allowedLength > 0) {
                    var truncated = pastedText.substring(0, allowedLength);
                    this.value = currentText.substring(0, currentSelectionStart) + truncated + currentText.substring(currentSelectionEnd);
                    // Set cursor position after inserted text
                    this.selectionStart = this.selectionEnd = currentSelectionStart + truncated.length;
                } else {
                    this.value = currentText;
                }
                updateCharCounter();
            }
        });
    }

    // Check if modal should be hidden
    var onboardingDone = sessionStorage.getItem('surecargo_onboarding_done');
    var requestApproved = sessionStorage.getItem('surecargo_request_approved');

    if (onboardingDone === 'true' || requestApproved === 'true') {
        modal.classList.add('hidden');
        // Enable chatbot if authenticated
        enableChatbot();
        return;
    }

    // Check if request is pending
    var requestPending = sessionStorage.getItem('surecargo_request_pending') === 'true';
    var requestRejected = sessionStorage.getItem('surecargo_request_rejected') === 'true';
    var userRequestId = sessionStorage.getItem('user_request_id');

    // --- Function to enable chatbot ---
    function enableChatbot() {
        var chatBtn = document.getElementById('chatButton');
        if (chatBtn) {
            chatBtn.classList.remove('disabled');
            chatBtn.style.pointerEvents = 'auto';
            chatBtn.style.cursor = 'pointer';
            chatBtn.style.opacity = '1';
            chatBtn.style.filter = 'none';
        }
    }

    // --- Function to check request status from server ---
    function checkRequestStatus() {
        var requestId = userRequestId || sessionStorage.getItem('user_request_id');
        if (!requestId) {
            if (pollInterval) {
                clearInterval(pollInterval);
                pollInterval = null;
            }
            return;
        }

        var statusUrl = '/user-request/check-status?request_id=' + encodeURIComponent(requestId);

        fetch(statusUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(function(data) {
            if (data.status === 'approved') {
                // Request approved! Close modal and enable chatbot
                modal.classList.add('hidden');
                sessionStorage.setItem('surecargo_request_approved', 'true');
                sessionStorage.removeItem('surecargo_request_pending');
                sessionStorage.setItem('surecargo_onboarding_done', 'true');

                // Enable chatbot
                enableChatbot();

                // Stop polling
                if (pollInterval) {
                    clearInterval(pollInterval);
                    pollInterval = null;
                }

                // Reload page to show logged in state
                setTimeout(function() {
                    location.reload();
                }, 500);
            } else if (data.status === 'rejected') {
                // Request rejected
                sessionStorage.setItem('surecargo_request_rejected', 'true');
                sessionStorage.removeItem('surecargo_request_pending');

                // Show error on the new customer slide
                if (currentSlide === 1) {
                    newError.textContent = '❌ Your request was rejected. Please submit a new request.';
                    newError.classList.add('show');
                    submitNew.disabled = false;
                    submitNew.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Submit Request';
                    knowSite.disabled = false;
                    messageText.disabled = false;
                    newSuccess.classList.remove('show');
                }

                // Stop polling
                if (pollInterval) {
                    clearInterval(pollInterval);
                    pollInterval = null;
                }
            }
        })
        .catch(function(error) {
            console.log('Status check failed:', error);
        });
    }

    // --- Start polling for status updates ---
    function startPolling() {
        if (pollInterval) {
            clearInterval(pollInterval);
        }
        // Check every 3 seconds
        pollInterval = setInterval(checkRequestStatus, 3000);
        // Also check immediately
        setTimeout(checkRequestStatus, 100);
    }

    function goToSlide(index) {
        currentSlide = index;
        track.style.transform = 'translateX(-' + (index * 100) + '%)';
        stepIndicator.textContent = index === 0 ? 'STEP 0 / 1' : 'STEP 1 / 1';
        newError.classList.remove('show');
        oldError.classList.remove('show');
        newSuccess.classList.remove('show');
    }

    function resetStep1() {
        knowSite.value = '';
        messageText.value = '';
        if (charCounter) {
            updateCharCounter();
        }
        secretInput.value = '';
        newError.classList.remove('show');
        oldError.classList.remove('show');
        newSuccess.classList.remove('show');
        submitNew.disabled = false;
        submitNew.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Submit Request';
        submitOld.disabled = isLockedOut || false;
        submitOld.innerHTML = '<i class="fas fa-unlock me-2"></i> Unlock';
        knowSite.disabled = false;
        messageText.disabled = false;
        // Reset secret state if not locked out
        if (!isLockedOut) {
            secretAttempts = 3;
            saveSecretState();
        }
        updateSecretUI();
    }

    // --- New Customer ---
    newCustomerBtn.addEventListener('click', function() {
        resetStep1();
        // Check if there's a pending request already
        if (requestPending) {
            goToSlide(1);
            newSuccess.textContent = '✅ Your request has been submitted! Please wait for admin approval.';
            newSuccess.classList.add('show');
            submitNew.innerHTML = '<i class="fas fa-check me-2"></i> Request Submitted';
            submitNew.disabled = true;
            knowSite.disabled = true;
            messageText.disabled = true;
            // Start polling if not already
            if (!pollInterval) {
                startPolling();
            }
            return;
        }
        if (requestRejected) {
            goToSlide(1);
            newError.textContent = '❌ Your previous request was rejected. Please submit a new request.';
            newError.classList.add('show');
            return;
        }
        goToSlide(1);
    });

    // --- Old Customer ---
    oldCustomerBtn.addEventListener('click', function() {
        resetStep1();
        goToSlide(2);
        // Load secret state
        loadSecretState();
    });

    // --- Back buttons ---
    backFromNew.addEventListener('click', function() {
        goToSlide(0);
        resetStep1();
        if (pollInterval) {
            clearInterval(pollInterval);
            pollInterval = null;
        }
    });
    backFromOld.addEventListener('click', function() {
        goToSlide(0);
        resetStep1();
        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
        }
    });

    // --- Submit New Customer ---
    submitNew.addEventListener('click', function() {
        var know = knowSite.value;
        var msg = messageText.value.trim();

        if (!know) {
            newError.textContent = '⚠️ Please select how you know us.';
            newError.classList.add('show');
            return;
        }
        newError.classList.remove('show');
        newSuccess.classList.remove('show');

        submitNew.disabled = true;
        submitNew.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Submitting...';

        fetch('{{ route("user-request.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                know_site: know,
                message: msg
            })
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.success) {
                newSuccess.textContent = '✅ ' + data.message;
                newSuccess.classList.add('show');
                submitNew.innerHTML = '<i class="fas fa-check me-2"></i> Request Submitted';
                submitNew.disabled = true;
                knowSite.disabled = true;
                messageText.disabled = true;
                sessionStorage.setItem('surecargo_request_pending', 'true');
                sessionStorage.setItem('user_request_id', data.request_id);
                userRequestId = data.request_id;
                requestPending = true;
                // Start polling for status updates
                startPolling();
            } else {
                newError.textContent = '❌ ' + data.message;
                newError.classList.add('show');
                submitNew.disabled = false;
                submitNew.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Submit Request';
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            newError.textContent = '❌ An error occurred. Please try again.';
            newError.classList.add('show');
            submitNew.disabled = false;
            submitNew.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Submit Request';
        });
    });

    // --- Submit Old Customer ---
    submitOld.addEventListener('click', function() {
        // Check if locked out
        if (isLockedOut) {
            oldError.textContent = '⛔ You are locked out. Please wait ' +
                (lockoutEndTime ? Math.ceil((lockoutEndTime - Date.now()) / 60000) : 10) + ' minutes.';
            oldError.classList.add('show');
            return;
        }

        var code = secretInput.value.trim();
        if (!code) {
            oldError.textContent = 'Please enter a secret code.';
            oldError.classList.add('show');
            return;
        }
        // Validate numbers only
        if (!/^\d+$/.test(code)) {
            oldError.textContent = 'Secret code must contain numbers only.';
            oldError.classList.add('show');
            return;
        }

        oldError.classList.remove('show');

        submitOld.disabled = true;
        submitOld.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Verifying...';

        fetch('{{ route("user-request.verify-secret") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                secret_code: code
            })
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.success) {
                oldError.classList.remove('show');
                // Reset attempts on success
                secretAttempts = 3;
                isLockedOut = false;
                saveSecretState();
                // Auto close modal and enable chatbot
                modal.classList.add('hidden');
                sessionStorage.setItem('surecargo_onboarding_done', 'true');
                enableChatbot();
                // Reload page
                setTimeout(function() {
                    location.reload();
                }, 300);
            } else {
                // Decrement attempts
                secretAttempts--;
                saveSecretState();

                if (secretAttempts <= 0) {
                    // Lock out
                    isLockedOut = true;
                    lockoutEndTime = Date.now() + (10 * 60 * 1000); // 10 minutes
                    saveSecretState();
                    updateSecretUI();
                    startCountdown();
                    oldError.textContent = '⛔ Too many failed attempts. You are locked out for 10 minutes.';
                    oldError.classList.add('show');
                    submitOld.disabled = true;
                    submitOld.innerHTML = '<i class="fas fa-unlock me-2"></i> Unlock';
                    secretInput.value = '';
                } else {
                    oldError.textContent = '❌ Invalid secret code. ' + secretAttempts + ' attempt' +
                        (secretAttempts > 1 ? 's' : '') + ' remaining.';
                    oldError.classList.add('show');
                    submitOld.disabled = false;
                    submitOld.innerHTML = '<i class="fas fa-unlock me-2"></i> Unlock';
                    secretInput.value = '';
                    secretInput.focus();
                }
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            oldError.textContent = 'An error occurred. Please try again.';
            oldError.classList.add('show');
            submitOld.disabled = false;
            submitOld.innerHTML = '<i class="fas fa-unlock me-2"></i> Unlock';
        });
    });

    // Enter key support with enhanced validation
    secretInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            submitOld.click();
        }
    });

    messageText.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
            e.preventDefault();
            submitNew.click();
        }
    });

    // Prevent closing modal with Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            // ignore - modal must be completed
        }
    });

    // Check for pending request on load and start polling
    if (requestPending && userRequestId) {
        // Auto-show new customer slide with pending message
        setTimeout(function() {
            goToSlide(1);
            newSuccess.textContent = '✅ Your request has been submitted! Please wait for admin approval.';
            newSuccess.classList.add('show');
            submitNew.innerHTML = '<i class="fas fa-check me-2"></i> Request Submitted';
            submitNew.disabled = true;
            knowSite.disabled = true;
            messageText.disabled = true;
            startPolling();
        }, 300);
    }

    // Load secret state on page load
    loadSecretState();

    // Clean up polling on page unload
    window.addEventListener('beforeunload', function() {
        if (pollInterval) {
            clearInterval(pollInterval);
            pollInterval = null;
        }
        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
        }
    });

})();

    // ============================================================
    // 2. GLOBAL PRELOADER
    // ============================================================
    (function() {
        var preloader = document.getElementById('preloader');
        if (!preloader) return;

        var resourcesLoaded = false;
        var externalCssLoaded = 0;
        var totalCss = 2;

        function checkPreloader() {
            if (resourcesLoaded && externalCssLoaded >= totalCss) {
                preloader.classList.add('hidden');
            }
        }

        window.addEventListener('load', function() {
            resourcesLoaded = true;
            checkPreloader();
        });

        if (document.readyState === 'complete') {
            resourcesLoaded = true;
        }

        document.getElementById('bootstrap-css').addEventListener('load', function() {
            externalCssLoaded++;
            checkPreloader();
        });
        document.getElementById('fontawesome-css').addEventListener('load', function() {
            externalCssLoaded++;
            checkPreloader();
        });
        if (document.querySelector('#bootstrap-css').sheet) {
            externalCssLoaded++;
        }
        if (document.querySelector('#fontawesome-css').sheet) {
            externalCssLoaded++;
        }
        setTimeout(function() {
            if (externalCssLoaded < totalCss) {
                if (document.querySelector('#bootstrap-css') && document.querySelector('#bootstrap-css').sheet) {
                    externalCssLoaded++;
                }
                if (document.querySelector('#fontawesome-css') && document.querySelector('#fontawesome-css').sheet) {
                    externalCssLoaded++;
                }
                checkPreloader();
            }
        }, 2000);

        if (document.fonts) {
            document.fonts.ready.then(function() {
                resourcesLoaded = true;
                checkPreloader();
            });
        } else {
            resourcesLoaded = true;
            checkPreloader();
        }

        setTimeout(function() {
            preloader.classList.add('hidden');
        }, 5000);
    })();

    // ============================================================
    // 3. IMAGE SKELETON LOADING
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
    // 4. ICON SKELETON
    // ============================================================
    (function() {
        function iconsReady() {
            document.body.classList.add('icons-loaded');
            var fallbacks = document.querySelectorAll('.icon-skeleton-fallback');
            fallbacks.forEach(function(el) { el.remove(); });
        }

        var faLoaded = false, biLoaded = false;
        var faLink = document.getElementById('fontawesome-css');
        var biLink = document.getElementById('bootstrap-css');

        function checkIcons() {
            if (faLoaded && biLoaded) {
                iconsReady();
            }
        }

        if (faLink) {
            faLink.addEventListener('load', function() { faLoaded = true; checkIcons(); });
            if (faLink.sheet) faLoaded = true;
        }
        if (biLink) {
            biLink.addEventListener('load', function() { biLoaded = true; checkIcons(); });
            if (biLink.sheet) biLoaded = true;
        }

        function testIcon() {
            var testEl = document.createElement('i');
            testEl.className = 'fas fa-rocket';
            document.body.appendChild(testEl);
            var style = getComputedStyle(testEl);
            var fontFamily = style.fontFamily;
            document.body.removeChild(testEl);
            if (fontFamily && fontFamily.indexOf('Font Awesome') !== -1) {
                faLoaded = true;
                checkIcons();
            }
            var testBi = document.createElement('i');
            testBi.className = 'bi bi-star';
            document.body.appendChild(testBi);
            var biStyle = getComputedStyle(testBi);
            var biFamily = biStyle.fontFamily;
            document.body.removeChild(testBi);
            if (biFamily && biFamily.indexOf('bootstrap-icons') !== -1) {
                biLoaded = true;
                checkIcons();
            }
        }
        setTimeout(testIcon, 500);
        setTimeout(function() {
            faLoaded = true;
            biLoaded = true;
            checkIcons();
        }, 3000);
    })();

    // ============================================================
    // 5. BUTTON LOADING STATES
    // ============================================================
    (function() {
        var targets = document.querySelectorAll(`
            .btn-primary-custom:not([download]),
            .btn-outline-custom:not([download]),
            .btn-find-us:not([download]),
            .btn-logout,
            .chatbot-float:not(.disabled),
            .btn-download:not([download])
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
    // 6. HAMBURGER MENU
    // ============================================================
    (function() {
        var menuIcon = document.getElementById('menuIcon');
        var navLinks = document.getElementById('navLinks');

        if (menuIcon && navLinks) {
            var toggleMenu = function(e) {
                e.preventDefault();
                e.stopPropagation();
                navLinks.classList.toggle('show');
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
                    }
                });
            });

            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    var nav = document.querySelector('.navbar-custom');
                    if (nav && !nav.contains(e.target)) {
                        navLinks.classList.remove('show');
                    }
                }
            });
        }
    })();

    // ============================================================
    // 7. STATS COUNTERS
    // ============================================================
    var deliveredShipmentsTarget = {{ $deliveredShipmentsCount }};
    var totalTrucksTarget = {{ $totalTrucksCount }};
    var totalUsersTarget = {{ $totalUsersCount }};

    var counters = [
        { el: document.getElementById('counter1'), target: deliveredShipmentsTarget || 1250, suffix: '' },
        { el: document.getElementById('counter2'), target: totalTrucksTarget || 85, suffix: '' },
        { el: document.getElementById('counter3'), target: totalUsersTarget || 320, suffix: '' }
    ];

    function animateNumber(counter, start, end, duration, suffix) {
        if (!counter) return;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var value = Math.floor(progress * (end - start) + start);
            counter.textContent = value.toLocaleString() + suffix;
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                counter.textContent = end.toLocaleString() + suffix;
            }
        }
        requestAnimationFrame(step);
    }

    var statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                counters.forEach(function(c) {
                    if (c.el && (c.el.textContent === '0' || c.el.textContent === '0%')) {
                        animateNumber(c.el, 0, c.target, 2000, c.suffix);
                    }
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    var statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            var href = this.getAttribute('href');
            if (href === '#') return;
            e.preventDefault();
            var target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Initialize AOS
    AOS.init({
        duration: 800,
        once: false,
        mirror: false
    });

    // ============================================================
    // 8. CLICK SOUND EFFECT
    // ============================================================
    (function() {
        var clickAudio = document.getElementById('clickAudio');
        if (!clickAudio) return;

        function playClick() {
            try {
                clickAudio.currentTime = 0;
                clickAudio.play().catch(function() {});
            } catch(e) {}
        }

        document.addEventListener('click', function(e) {
            var target = e.target.closest('a, button, .btn-choice, .btn-submit, .btn-back, .btn-primary-custom, .btn-outline-custom, .btn-download, .btn-find-us, .chatbot-float, .menu-icon, .nav-links a, .social-links a, .feature-card, .why-card, .stat-card, .location-card');
            if (target) {
                if (target.closest('#bgAudio') || target.closest('#clickAudio')) return;
                playClick();
            }
        });
    })();
</script>
</body>
</html>
