<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Login - SureCargo</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/icon.png') }}">
    <!-- Fonts & Libraries -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style nonce="{{ $csp_nonce }}">
       /* ---------- RESET & GLOBAL VARIABLES ---------- */
*,
*::before,
*::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --color-primary: #0d6efd;
    --color-primary-dark: #0a58ca;
    --color-primary-light: #6ea8fe;
    --color-secondary: #0a0f1f;
    --color-accent: #10b981;
    --color-text-dark: #1e293b;
    --color-text-muted: #475569;
    --color-glass-bg: rgba(8, 14, 26, 0.78);
    --font-base: 'Inter', sans-serif;
    --transition-base: 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    --shadow-green-thick: inset 5px 5px 10px rgba(9, 235, 9, 0.55), 0 8px 18px rgba(0, 0, 0, 0.15);

    /* DEEPSEEK-STYLE FONT SIZES - Clean, readable, consistent */
    --font-xs: 0.75rem;
    --font-sm: 0.875rem;
    --font-base: 1rem;
    --font-md: 1.125rem;
    --font-lg: 1.25rem;
    --font-xl: 1.5rem;
    --font-xxl: 1.75rem;
    --font-xxxl: 2.25rem;

    /* responsive spacing */
    --sp-xs: 0.25rem;
    --sp-sm: 0.5rem;
    --sp-md: 1rem;
    --sp-lg: 1.5rem;
    --sp-xl: 2rem;
}

html {
    font-size: 16px;
    scroll-behavior: smooth;
}

body {
    font-family: var(--font-base);
    font-weight: 400;
    line-height: 1.6;
    overflow-x: hidden;
    min-height: 100vh;
    display: flex;
    align-items: center;
    font-size: var(--font-base);
    color: var(--color-text-dark);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ---------- SCROLLBAR HIDING (desktop only) ---------- */
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

/* ---------- TYPOGRAPHY (DeepSeek-style) ---------- */
h1 {
    font-size: var(--font-xxxl);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.02em;
}
h2 {
    font-size: var(--font-xxl);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.02em;
}
h3 {
    font-size: var(--font-xl);
    font-weight: 700;
    line-height: 1.2;
    letter-spacing: -0.02em;
}
h4 {
    font-size: var(--font-lg);
    font-weight: 700;
    line-height: 1.2;
}
h5 {
    font-size: var(--font-md);
    font-weight: 600;
    line-height: 1.3;
}
h6 {
    font-size: var(--font-base);
    font-weight: 600;
    line-height: 1.3;
}

small,
.text-muted,
.form-text {
    font-size: var(--font-sm);
    font-weight: 400;
}

/* ---------- LAYOUT ---------- */
.container {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}

.login-card {
    width: 100%;
    max-width: 480px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 1.5rem;
    overflow: hidden;
    border: 1px solid rgba(13, 110, 253, 0.2);
    transition: transform var(--transition-base);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.login-card:hover {
    transform: translateY(-3px);
}

.login-header {
    background: #eff6ff;
    padding: var(--sp-lg) var(--sp-xl);
    text-align: center;
    border-bottom: 4px solid var(--color-primary);
}

.login-header h3 {
    color: var(--color-primary-dark);
    margin-bottom: 0;
}

.login-header p {
    color: var(--color-text-dark);
    margin-top: var(--sp-sm);
    margin-bottom: 0;
    font-size: var(--font-base);
}

.login-body {
    padding: var(--sp-lg) var(--sp-xl) var(--sp-xl);
}

/* ---------- FORM ELEMENTS ---------- */
.form-label {
    font-weight: 500;
    font-size: var(--font-base);
    margin-bottom: var(--sp-xs);
}

.form-control {
    font-size: var(--font-base);
    padding: 0.6rem 0.8rem;
    border-radius: 0.75rem;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #0f172a;
    transition: all var(--transition-base);
    height: auto;
    min-height: 44px;
}

.form-control:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    background-color: #ffffff;
    color: #0f172a;
}

.form-control::placeholder {
    color: #94a3b8;
    font-size: var(--font-sm);
}

.input-icon {
    position: relative;
}

.input-icon .svg-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--color-primary);
    width: 1.2rem;
    height: 1.2rem;
    pointer-events: none;
}

.input-icon .form-control {
    padding-left: 3rem;
}

.btn-login {
    background: linear-gradient(105deg, #0d6efd, #0a58ca);
    border: none;
    padding: 0.7rem 1.5rem;
    border-radius: 60px;
    font-weight: 600;
    font-size: var(--font-base);
    color: white;
    transition: all var(--transition-base);
    box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-sm);
    width: 100%;
    cursor: pointer;
    touch-action: manipulation;
    min-height: 44px;
}

.btn-login:hover {
    transform: translateY(-2px);
    background: linear-gradient(105deg, #0b5ed7, #0950b0);
    box-shadow: 0 10px 20px rgba(13, 110, 253, 0.4);
    color: white;
}

.btn-login:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none !important;
}

.btn-login .spinner-border {
    width: 1.2em;
    height: 1.2em;
    border-width: 0.15em;
}

.form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    margin-top: 0.15rem;
    border: 1.5px solid #cbd5e1;
    cursor: pointer;
    min-width: 1.2rem;
    min-height: 1.2rem;
}

.form-check-input:checked {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
}

.form-check-label {
    font-size: var(--font-base);
    font-weight: 400;
    padding-left: var(--sp-xs);
    cursor: pointer;
}

/* ---------- ALERTS ---------- */
.alert {
    border-radius: 0.75rem;
    padding: var(--sp-md) var(--sp-lg);
    font-size: var(--font-base);
    font-weight: 400;
    border-left-width: 4px;
    display: flex;
    align-items: center;
    gap: var(--sp-sm);
    color: #991b1b;
    background: #fee2e2;
    border-left-color: #dc2626;
}

.alert-success {
    background: #dcfce7;
    border-left-color: #10b981;
    color: #166534;
}

.alert .svg-icon {
    flex-shrink: 0;
    width: 1.2rem;
    height: 1.2rem;
    fill: currentColor;
}

.last-attempt-warning {
    background: #fff3cd;
    border-left-color: #ffc107;
    color: #856404;
    transition: opacity 0.3s ease;
}

/* ---------- LOCKOUT BANNER ---------- */
.lockout-banner {
    background: #fff0f0;
    border: 3px solid #dc2626;
    border-radius: 1.5rem;
    padding: var(--sp-lg) var(--sp-md);
    text-align: center;
    box-shadow: 0 15px 30px rgba(220, 38, 38, 0.2);
    margin-bottom: var(--sp-lg);
}

.lockout-banner .svg-icon {
    width: 2.5rem;
    height: 2.5rem;
    fill: #dc2626;
    display: block;
    margin: 0 auto var(--sp-sm);
}

.lockout-banner .big-headline {
    font-size: var(--font-xl);
    font-weight: 800;
    color: #b91c1c;
    letter-spacing: -0.02em;
}

.lockout-banner .big-message {
    font-size: var(--font-base);
    font-weight: 400;
    margin-top: var(--sp-sm);
}

.lockout-banner .countdown-timer {
    font-size: var(--font-xxl);
    font-weight: 700;
    background: #ffffffcc;
    display: inline-block;
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 60px;
    margin-top: var(--sp-md);
    font-family: monospace;
    letter-spacing: 2px;
}

.lockout-banner small {
    display: block;
    margin-top: var(--sp-md);
    color: #991b1b;
}

/* ---------- LINKS ---------- */
a {
    color: var(--color-primary);
    text-decoration: none;
    font-weight: 500;
    transition: color var(--transition-base);
    cursor: pointer;
    touch-action: manipulation;
}

a:hover {
    color: var(--color-primary-dark);
    text-decoration: underline;
}

hr {
    border-color: #e2e8f0;
    margin: var(--sp-lg) 0;
}

/* ---------- PROGRESS DOTS ---------- */
.progress-dot,
.progress-dots .dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #cbd5e1;
    margin: 0 4px;
    transition: all var(--transition-base);
}
.progress-dot.active,
.progress-dots .dot.active {
    background-color: var(--color-primary);
    transform: scale(1.1);
}

/* ---------- MODAL (bottom sheet) ---------- */
.modal-content {
    border-radius: 1.5rem 1.5rem 0 0;
    border: none;
    box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.15);
    background: #ffffff;
}

.modal-header {
    border-bottom: 1px solid #e9ecef;
    padding: var(--sp-md) var(--sp-lg);
}

.modal-body {
    padding: var(--sp-lg);
}

.modal-footer {
    border-top: none;
    padding: var(--sp-md) var(--sp-lg);
}

.modal .btn {
    font-size: var(--font-base);
    padding: var(--sp-sm) var(--sp-md);
    border-radius: 60px;
    cursor: pointer;
    touch-action: manipulation;
    min-height: 44px;
}

/* Swipe handle (drag bar) */
.modal-swipe-handle {
    width: 40px;
    height: 4px;
    background: #d1d5db;
    border-radius: 4px;
    margin: 8px auto 4px;
    cursor: grab;
}

/* Step indicator */
.step-indicator {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}
.step-indicator .step-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #cbd5e1;
    transition: all 0.3s;
}
.step-indicator .step-dot.active {
    background: var(--color-primary);
    transform: scale(1.3);
}
.step-indicator .step-dot.completed {
    background: var(--color-accent);
}

/* Step container */
.reset-steps-wrapper {
    overflow: hidden !important;
    position: relative !important;
}
.reset-steps-container {
    display: flex !important;
    transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1) !important;
    width: 100% !important;
    transform: translateX(0%) !important;
}
.reset-step {
    flex: 0 0 100% !important;
    max-width: 100% !important;
    padding: 0 0.25rem !important;
}

/* Password strength bar */
.strength-bar {
    height: 6px;
    background: #e5e7eb;
    border-radius: 12px;
    margin-top: 10px;
}
.strength-bar-fill {
    height: 100%;
    border-radius: 12px;
    width: 0%;
    transition: width 0.2s;
}

/* Toast notifications */
.modal-toast {
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    font-weight: 400;
    font-size: var(--font-sm);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.modal-toast.success {
    background: #dcfce7;
    color: #166534;
}
.modal-toast.error {
    background: #fee2e2;
    color: #991b1b;
}

.modal-toast.info {
    background: #dbeafe;
    color: #1e40af;
}

/* Identity verification lockout banner in modal */
.identity-lockout-banner {
    background: #fff0f0;
    border: 2px solid #dc2626;
    border-radius: 1rem;
    padding: 1rem;
    text-align: center;
    margin-bottom: 1rem;
}
.identity-lockout-banner .lockout-icon {
    font-size: 1.75rem;
    display: block;
    margin-bottom: 0.5rem;
}
.identity-lockout-banner .lockout-title {
    font-weight: 700;
    color: #b91c1c;
    font-size: var(--font-base);
}
.identity-lockout-banner .lockout-message {
    font-size: var(--font-sm);
    color: #991b1b;
    margin-top: 0.25rem;
}
.identity-lockout-banner .lockout-timer {
    font-weight: 700;
    font-size: var(--font-lg);
    margin-top: 0.5rem;
    font-family: monospace;
    background: #ffffffcc;
    display: inline-block;
    padding: 0.25rem 1rem;
    border-radius: 60px;
}

/* ---------- RESPONSIVE (DeepSeek Style) ---------- */

/* --- Tablets & small desktops (769px - 992px) --- */
@media (max-width: 992px) {
    :root {
        --font-xs: 0.75rem;
        --font-sm: 0.85rem;
        --font-base: 0.95rem;
        --font-md: 1.05rem;
        --font-lg: 1.15rem;
        --font-xl: 1.3rem;
        --font-xxl: 1.5rem;
        --font-xxxl: 1.8rem;
    }
}

/* --- Mobile devices (≤ 768px) --- */
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
    }

    .login-card {
        border-radius: 1.2rem;
        max-width: 98%;
    }
    .login-body {
        padding: var(--sp-md) var(--sp-lg);
    }
    .login-header {
        padding: var(--sp-md) var(--sp-lg);
    }
    .modal-content {
        border-radius: 1rem 1rem 0 0;
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
        --font-xxxl: 1.5rem;

        --sp-xs: 0.15rem;
        --sp-sm: 0.3rem;
        --sp-md: 0.6rem;
        --sp-lg: 1rem;
        --sp-xl: 1.2rem;
    }

    .login-card {
        border-radius: 0.8rem 1.2rem;
        max-width: 100%;
    }
    .login-body {
        padding: var(--sp-sm) var(--sp-md);
    }
    .login-header {
        padding: var(--sp-sm) var(--sp-md);
    }
    .form-control {
        padding: 0.4rem 0.6rem;
        font-size: var(--font-base);
        min-height: 38px;
    }
    .input-icon .svg-icon {
        width: 1rem;
        height: 1rem;
        left: 0.6rem;
    }
    .input-icon .form-control {
        padding-left: 2.4rem;
    }
    .btn-login {
        padding: var(--sp-xs) var(--sp-sm);
        font-size: var(--font-base);
        min-height: 38px;
    }
    .lockout-banner {
        padding: var(--sp-sm) var(--sp-xs);
        border-width: 2px;
    }
    .lockout-banner .big-headline {
        font-size: var(--font-lg);
    }
    .lockout-banner .countdown-timer {
        font-size: var(--font-xl);
        padding: var(--sp-xs) var(--sp-sm);
    }
    .alert {
        padding: var(--sp-sm) var(--sp-md);
        font-size: var(--font-sm);
        border-left-width: 4px;
    }
    .modal-body {
        padding: var(--sp-md);
    }
    .reset-step .btn {
        width: 100%;
    }
    .form-check-label {
        font-size: var(--font-sm);
    }
    .form-check-input {
        width: 1rem;
        height: 1rem;
        min-width: 1rem;
        min-height: 1rem;
    }
    .login-header p {
        font-size: var(--font-sm);
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
        --font-xxxl: 1.3rem;

        --sp-xs: 0.1rem;
        --sp-sm: 0.25rem;
        --sp-md: 0.5rem;
        --sp-lg: 0.8rem;
        --sp-xl: 1rem;
    }

    .login-card {
        border-radius: 0.6rem 0.8rem;
    }
    .login-body {
        padding: var(--sp-sm) var(--sp-md);
    }
    .form-control {
        padding: 0.3rem 0.5rem;
        font-size: var(--font-sm);
        min-height: 34px;
        border-radius: 0.5rem;
    }
    .input-icon .svg-icon {
        width: 0.9rem;
        height: 0.9rem;
        left: 0.5rem;
    }
    .input-icon .form-control {
        padding-left: 2rem;
    }
    .btn-login {
        padding: 0.25rem 0.5rem;
        font-size: var(--font-sm);
        min-height: 34px;
        border-radius: 40px;
    }
    .form-label {
        font-size: var(--font-sm);
    }
    .form-check-label {
        font-size: var(--font-xs);
    }
    .form-check-input {
        width: 0.9rem;
        height: 0.9rem;
        min-width: 0.9rem;
        min-height: 0.9rem;
    }
    .login-header h3 {
        font-size: var(--font-lg);
    }
    .login-header p {
        font-size: var(--font-xs);
    }
    .alert {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 0.5rem;
    }
    .lockout-banner .big-headline {
        font-size: var(--font-base);
    }
    .lockout-banner .big-message {
        font-size: var(--font-xs);
    }
    .lockout-banner .countdown-timer {
        font-size: var(--font-md);
        padding: var(--sp-xs) var(--sp-sm);
    }
}

/* ---------- SVG ICON BASE ---------- */
.svg-icon {
    display: inline-block;
    vertical-align: middle;
    flex-shrink: 0;
    fill: currentColor;
    width: 1em;
    height: 1em;
    line-height: 1;
}

/* ---------- PRELOADER ---------- */
#pagePreloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity 0.6s ease, visibility 0.6s ease;
}
#pagePreloader.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}
.preloader-spinner {
    width: 3rem;
    height: 3rem;
    border: 0.3rem solid #e2e8f0;
    border-top-color: var(--color-primary);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ---------- IMAGE SKELETON ---------- */
.img-skeleton {
    background: #e2e8f0;
    background: linear-gradient(110deg, #ececec 8%, #f5f5f5 18%, #ececec 33%);
    background-size: 200% 100%;
    animation: shimmer 1.5s linear infinite;
    border-radius: 0.25rem;
}
@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}
img[data-src] {
    opacity: 0;
    transition: opacity 0.4s ease;
}
img.loaded {
    opacity: 1;
}
.img-wrapper {
    position: relative;
    display: inline-block;
    overflow: hidden;
}
.img-wrapper .img-skeleton {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
}
.img-wrapper img {
    position: relative;
    z-index: 1;
}

/* ---------- BUTTON LOADING STATE ---------- */
.btn-loading .btn-text {
    display: none;
}
.btn-loading .btn-spinner {
    display: inline-flex;
}
.btn-spinner {
    display: none;
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
</head>
<body>
    <!-- ===== HIDDEN CLICK AUDIO ELEMENT ===== -->
    <audio id="clickAudio" src="{{ asset('audio/click.mp3') }}" preload="auto"></audio>

    <!-- ===== PRELOADER ===== -->
    <div id="pagePreloader">
        <div class="preloader-spinner"></div>
    </div>

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 col-12 mx-auto">
                <div class="login-card">
                    <div class="login-header">
                        <h3>Welcome Back!</h3>
                        <p>Sign in to your account</p>
                    </div>
                    <div class="login-body">
                        @php
                            $lockoutRemaining = session('lockout_remaining');
                            $lastAttemptWarning = session('last_attempt_warning');
                            $isLocked = $lockoutRemaining && $lockoutRemaining > 0;
                            $lastLoginMobile = session('last_login_mobile', old('mobile_number'));
                        @endphp

                        {{-- LOCKOUT BANNER WITH COUNTDOWN --}}
                        @if($isLocked)
                            <div class="lockout-banner" id="lockoutBanner">
                                <svg class="svg-icon" viewBox="0 0 384 512" aria-hidden="true">
                                    <path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H352c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H32zM96 75V64H288V75c0 19-7.6 37.2-21.1 50.7L213.3 179.3c-6.2 6.2-16.4 6.2-22.6 0L117.1 125.7C103.6 112.2 96 94 96 75zM96 437c0-19 7.6-37.2 21.1-50.7L170.7 332.7c6.2-6.2 16.4-6.2 22.6 0l67.9 67.9c13.5 13.5 21.1 31.7 21.1 50.7v11H96V437z"/>
                                </svg>
                                <div class="big-headline">🔒 ACCOUNT LOCKED</div>
                                <div class="big-message">Too many failed attempts. Try again in:</div>
                                <div class="countdown-timer" id="countdownDisplay">
                                    {{ gmdate("i:s", $lockoutRemaining) }}
                                </div>
                                <small class="text-danger">Your account is temporarily locked for 30 minutes.</small>
                            </div>
                        @endif

                        {{-- LAST ATTEMPT WARNING --}}
                        @if($lastAttemptWarning)
                            <div class="alert last-attempt-warning mb-4" id="lastAttemptWarning">
                                <svg class="svg-icon" viewBox="0 0 576 512" aria-hidden="true">
                                    <path d="M569.5 440.8C573.6 448.1 576 456.2 576 464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48 0-7.8 2.4-15.9 6.5-23.2l224-384c12.7-21.8 42.3-29.2 64.1-16.5 6.5 3.8 11.8 9.1 15.6 15.6l224 384zM288 208c-13.3 0-24 10.7-24 24v64c0 13.3 10.7 24 24 24s24-10.7 24-24V232c0-13.3-10.7-24-24-24zm0 176c-13.3 0-24 10.7-24 24s10.7 24 24 24 24-10.7 24-24-10.7-24-24-24z"/>
                                </svg>
                                {{ $lastAttemptWarning }}
                            </div>
                        @endif

                        {{-- OTHER ERRORS --}}
                        @if ($errors->any() && !$errors->has('locked') && !$lastAttemptWarning)
                            <div class="alert alert-danger mb-4">
                                <svg class="svg-icon" viewBox="0 0 512 512" aria-hidden="true">
                                    <path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 464c-114.7 0-208-93.3-208-208S141.3 48 256 48s208 93.3 208 208-93.3 208-208 208zm0-288c-13.3 0-24 10.7-24 24v80c0 13.3 10.7 24 24 24s24-10.7 24-24V200c0-13.3-10.7-24-24-24zm0 160c-13.3 0-24 10.7-24 24s10.7 24 24 24 24-10.7 24-24-10.7-24-24-24z"/>
                                </svg>
                                {{ $errors->first() }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success mb-4">
                                <svg class="svg-icon" viewBox="0 0 512 512" aria-hidden="true">
                                    <path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 464c-114.7 0-208-93.3-208-208S141.3 48 256 48s208 93.3 208 208-93.3 208-208 208zm101.8-209.6l-128 112c-4.9 4.3-11.1 6.6-17.5 6.6s-12.6-2.2-17.5-6.6l-64-56c-4.9-4.3-7.3-10.4-6.6-16.7s4.8-11.6 10.8-14.7c6-3.1 13.3-2.4 18.7 1.6l54.9 48.1 112-98c5.4-4.7 13.1-5.3 19.1-1.5 6 3.8 9.1 10.7 8.1 17.4-1 6.6-4.4 12.3-9.9 15.8z"/>
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Mobile Number</label>
                                <div class="input-icon">
                                    <input type="tel" name="mobile_number" id="mobileNumberInput" class="form-control" placeholder="09123456789" required autofocus value="{{ $lastLoginMobile ?? old('mobile_number') }}" @if($isLocked) disabled @endif>
                                </div>
                                <small class="text-muted d-block mt-1">Enter 11-digit mobile number starting with 09</small>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password</label>
                                <div class="input-icon">
                                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required @if($isLocked) disabled @endif>
                                </div>
                            </div>
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" @if($isLocked) disabled @endif>
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn-login w-100" id="loginBtn" @if($isLocked) disabled @endif>
                                <span class="btn-text">
                                    <svg class="svg-icon" viewBox="0 0 512 512" aria-hidden="true">
                                        <path d="M217.9 105.9L340.2 228.1c7.2 7.2 11.3 17.1 11.3 27.9s-4.1 20.7-11.3 27.9L217.9 406.1c-7.2 7.2-18.7 11.3-27.9 11.3-21.9 0-39.1-17.2-39.1-39.1V304H32c-17.7 0-32-14.3-32-32s14.3-32 32-32h118.9V132.5c0-21.9 17.2-39.1 39.1-39.1 10.8 0 20.7 4.1 27.9 11.3zM480 32v448c0 17.7-14.3 32-32 32s-32-14.3-32-32V32c0-17.7 14.3-32 32-32s32 14.3 32 32z"/>
                                    </svg>
                                    Login
                                </span>
                                <span class="btn-spinner">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Please wait...
                                </span>
                            </button>
                        </form>

                        <!-- ===== FORGOT PASSWORD LINK ===== -->
                        <div class="text-end mt-3">
                            <a href="#" id="forgotPasswordLink" class="text-decoration-none" style="font-size: 0.9em;">Forgot Password?</a>
                        </div>

                        <hr class="my-4">
                        <p class="text-center mb-0">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="fw-semibold">Register here</a>
                        </p>
                        <p class="text-center mt-3">
                            <a href="{{ route('welcome') }}">
                                <svg class="svg-icon" viewBox="0 0 448 512" aria-hidden="true">
                                    <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 214.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160zM448 256c0-17.7-14.3-32-32-32H80c-17.7 0-32 14.3-32 32s14.3 32 32 32h336c17.7 0 32-14.3 32-32z"/>
                                </svg>
                                Back to Home
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== FORGOT PASSWORD MODAL (Bottom Sheet) ===== -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Swipe handle -->
                    <div class="modal-swipe-handle"></div>

                    <!-- Step indicator dots -->
                    <div class="step-indicator" id="resetStepIndicator">
                        <span class="step-dot active" data-step="0"></span>
                        <span class="step-dot" data-step="1"></span>
                        <span class="step-dot" data-step="2"></span>
                        <span class="step-dot" data-step="3"></span>
                    </div>

                    <!-- Steps container -->
                    <div class="reset-steps-wrapper">
                        <div class="reset-steps-container" id="resetStepsContainer">
                            <!-- STEP 0: Verify First Name & Last Name -->
                            <div class="reset-step" data-step="0">
                                <div class="mb-3">
                                    <label class="form-label">Verify Your Identity</label>
                                    <p class="text-muted small">Enter your first and last name to verify your account</p>
                                </div>

                                <!-- Identity Lockout Banner (hidden by default) -->
                                <div class="identity-lockout-banner" id="identityLockoutBanner" style="display:none;">
                                    <span class="lockout-icon">🔒</span>
                                    <div class="lockout-title">Identity Verification Locked</div>
                                    <div class="lockout-message">Too many failed attempts. Please wait before trying again.</div>
                                    <div class="lockout-timer" id="identityLockoutTimer">01:00</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">First Name</label>
                                    <div class="input-icon">
                                        <svg class="svg-icon" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                                        <input type="text" id="resetFirstName" class="form-control" placeholder="Enter your first name" required>
                                    </div>
                                    <div id="resetFirstNameFeedback" class="small mt-1"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <div class="input-icon">
                                        <svg class="svg-icon" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                                        <input type="text" id="resetLastName" class="form-control" placeholder="Enter your last name" required>
                                    </div>
                                    <div id="resetLastNameFeedback" class="small mt-1"></div>
                                </div>
                                <div id="identityAttemptsDisplay" class="small text-muted mb-2">Attempts remaining: 3</div>
                                <button type="button" class="btn btn-primary w-100" id="verifyIdentityBtn">Verify Identity</button>
                            </div>

                            <!-- STEP 1: Mobile Number -->
                            <div class="reset-step" data-step="1">
                                <div class="mb-3">
                                    <label class="form-label">Enter your mobile number</label>
                                    <p class="text-muted small" id="verifiedUserDisplay"></p>
                                    <div class="input-icon">
                                        <svg class="svg-icon" viewBox="0 0 512 512"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                                        <input type="tel" id="resetMobile" class="form-control" placeholder="09123456789" maxlength="11" required>
                                    </div>
                                    <div id="resetMobileFeedback" class="small mt-1"></div>
                                </div>
                                <button type="button" class="btn btn-primary w-100" id="sendResetOtpBtn">Send OTP</button>
                            </div>

                            <!-- STEP 2: OTP Verification -->
                            <div class="reset-step" data-step="2">
                                <div class="mb-3">
                                    <label class="form-label">Enter 6-digit OTP</label>
                                    <div class="input-icon">
                                        <svg class="svg-icon" viewBox="0 0 448 512"><path d="M224 0C100.3 0 0 100.3 0 224v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V224c0-88.4 71.6-160 160-160s160 71.6 160 160v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V224c0-123.7-100.3-224-224-224zM128 352v64c0 35.3 28.7 64 64 64h64c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H192c-35.3 0-64 28.7-64 64z"/></svg>
                                        <input type="text" id="resetOtp" class="form-control" placeholder="000000" maxlength="6" inputmode="numeric" pattern="[0-9]*">
                                    </div>
                                    <div id="resetOtpFeedback" class="small mt-1"></div>
                                </div>
                                <button type="button" class="btn btn-success w-100" id="verifyResetOtpBtn">Verify OTP</button>
                                <button type="button" class="btn btn-link w-100 mt-2" id="resendResetOtpBtn">Resend OTP</button>
                            </div>

                            <!-- STEP 3: New Password -->
                            <div class="reset-step" data-step="3">
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <div class="input-icon">
                                        <svg class="svg-icon" viewBox="0 0 448 512"><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64v192c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64h16z"/></svg>
                                        <input type="password" id="resetNewPassword" class="form-control" placeholder="Min 8 chars" required>
                                    </div>
                                    <div class="strength-bar mt-2">
                                        <div class="strength-bar-fill" id="resetStrengthBar"></div>
                                    </div>
                                    <div id="resetStrengthText" class="small mt-1"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <div class="input-icon">
                                        <svg class="svg-icon" viewBox="0 0 448 512"><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64v192c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64h16z"/></svg>
                                        <input type="password" id="resetConfirmPassword" class="form-control" placeholder="Confirm password" required>
                                    </div>
                                    <div id="resetMatchFeedback" class="small mt-1"></div>
                                </div>
                                <button type="button" class="btn btn-primary w-100" id="resetPasswordBtn">Reset Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script nonce="{{ $csp_nonce }}">
        (function() {
            'use strict';

            // ============================================================
            // 0. CLICK SOUND SYSTEM (No background audio)
            // ============================================================
            (function() {
                var clickAudio = document.getElementById('clickAudio');

                // --- Click sound on ALL interactive elements ---
                function playClick() {
                    if (clickAudio) {
                        clickAudio.currentTime = 0;
                        clickAudio.play().catch(function() {});
                    }
                }

                document.addEventListener('click', function(e) {
                    var target = e.target.closest('a, button, .btn-login, .btn-primary, .btn-success, .btn-link, .btn-close, .form-check-input, .form-check-label, .modal .btn, #forgotPasswordLink, [href], [role="button"]');
                    if (target) {
                        if (target.closest('#clickAudio')) {
                            return;
                        }
                        playClick();
                    }
                });

                window.__clickAudio = clickAudio;
            })();

            // ---- PAGE PRELOADER ----
            var preloader = document.getElementById('pagePreloader');
            if (preloader) {
                function hidePreloader() {
                    preloader.classList.add('hidden');
                    setTimeout(function() { if (preloader.parentNode) preloader.remove(); }, 700);
                }
                if (document.readyState === 'complete') {
                    hidePreloader();
                } else {
                    window.addEventListener('load', hidePreloader);
                    setTimeout(hidePreloader, 5000);
                }
            }

            // ---- LOGIN BUTTON LOADING ----
            var loginBtn = document.getElementById('loginBtn');
            var loginForm = document.getElementById('loginForm');
            if (loginBtn && loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    if (loginBtn.disabled) return;
                    if (!this.checkValidity()) return;
                    loginBtn.disabled = true;
                    loginBtn.classList.add('btn-loading');
                });
            }

            // ---- LOCKOUT COUNTDOWN ----
            var lockoutRemaining = @json($lockoutRemaining ?? null);
            if (lockoutRemaining && lockoutRemaining > 0) {
                var remainingSeconds = lockoutRemaining;
                var countdownElement = document.getElementById('countdownDisplay');
                var formInputs = document.querySelectorAll('#loginForm input, #loginForm button');
                for (var i = 0; i < formInputs.length; i++) {
                    formInputs[i].disabled = true;
                }

                var timerInterval = setInterval(function() {
                    if (remainingSeconds <= 0) {
                        clearInterval(timerInterval);
                        window.location.reload();
                        return;
                    }
                    remainingSeconds--;
                    var minutes = Math.floor(remainingSeconds / 60);
                    var seconds = remainingSeconds % 60;
                    countdownElement.textContent = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
                }, 1000);
            }

            // ---- LAST ATTEMPT WARNING ----
            var warningDiv = document.getElementById('lastAttemptWarning');
            if (warningDiv) {
                setTimeout(function() {
                    warningDiv.style.opacity = '0';
                    setTimeout(function() { warningDiv.remove(); }, 300);
                }, 4000);
            }

            // ============================================================
            //  FORGOT PASSWORD MODAL LOGIC
            // ============================================================
            var modalElement = document.getElementById('forgotPasswordModal');
            var modal = new bootstrap.Modal(modalElement, {
                backdrop: 'static',
                keyboard: false
            });

            var forgotLink = document.getElementById('forgotPasswordLink');

            // DOM refs
            var stepsContainer = document.getElementById('resetStepsContainer');
            var stepDots = document.querySelectorAll('#resetStepIndicator .step-dot');
            var totalSteps = 4;
            var currentStep = 0;
            var verifiedUserData = null;

            // Step 0: Identity verification
            var firstNameInput = document.getElementById('resetFirstName');
            var lastNameInput = document.getElementById('resetLastName');
            var verifyIdentityBtn = document.getElementById('verifyIdentityBtn');
            var firstNameFeedback = document.getElementById('resetFirstNameFeedback');
            var lastNameFeedback = document.getElementById('resetLastNameFeedback');
            var identityAttemptsDisplay = document.getElementById('identityAttemptsDisplay');
            var identityLockoutBanner = document.getElementById('identityLockoutBanner');
            var identityLockoutTimer = document.getElementById('identityLockoutTimer');

            // Identity verification state
            var identityAttempts = 0;
            var maxIdentityAttempts = 3;
            var identityLocked = false;
            var identityLockoutSeconds = 0;
            var identityLockoutInterval = null;

            // Step 1: Mobile
            var mobileInput = document.getElementById('resetMobile');
            var sendOtpBtn = document.getElementById('sendResetOtpBtn');
            var mobileFeedback = document.getElementById('resetMobileFeedback');
            var verifiedUserDisplay = document.getElementById('verifiedUserDisplay');

            // Step 2: OTP
            var otpInput = document.getElementById('resetOtp');
            var verifyOtpBtn = document.getElementById('verifyResetOtpBtn');
            var resendOtpBtn = document.getElementById('resendResetOtpBtn');
            var otpFeedback = document.getElementById('resetOtpFeedback');

            // Step 3: Password
            var newPassInput = document.getElementById('resetNewPassword');
            var confirmPassInput = document.getElementById('resetConfirmPassword');
            var resetPwdBtn = document.getElementById('resetPasswordBtn');
            var matchFeedback = document.getElementById('resetMatchFeedback');
            var strengthBar = document.getElementById('resetStrengthBar');
            var strengthText = document.getElementById('resetStrengthText');

            var loginMobileInput = document.getElementById('mobileNumberInput');

            // Helper: show toast
            function showModalToast(message, type) {
                type = type || 'success';
                var existingToasts = document.querySelectorAll('.modal-toast');
                for (var i = 0; i < existingToasts.length; i++) {
                    existingToasts[i].remove();
                }
                var toast = document.createElement('div');
                toast.className = 'modal-toast ' + type;
                toast.textContent = message;
                var container = document.querySelector('.reset-steps-wrapper');
                container.parentNode.insertBefore(toast, container.nextSibling);
                setTimeout(function() {
                    if (toast.parentNode) toast.remove();
                }, 4000);
            }

            // Step navigation
            function goToStep(step) {
                if (step < 0 || step >= totalSteps) return;
                currentStep = step;
                stepsContainer.style.transform = 'translateX(-' + (step * 100) + '%)';
                void stepsContainer.offsetHeight;
                for (var i = 0; i < stepDots.length; i++) {
                    var dot = stepDots[i];
                    dot.classList.remove('active', 'completed');
                    if (i === step) dot.classList.add('active');
                    else if (i < step) dot.classList.add('completed');
                }
                if (step === 1) {
                    setTimeout(function() { mobileInput.focus(); }, 300);
                } else if (step === 2) {
                    setTimeout(function() { otpInput.focus(); }, 300);
                } else if (step === 3) {
                    setTimeout(function() { newPassInput.focus(); }, 300);
                }
            }

            // Validate mobile format
            function isValidMobile(mobile) {
                return /^09[0-9]{9}$/.test(mobile);
            }

            // Password strength checker
            function checkPasswordStrength(pwd) {
                var strength = 0;
                if (pwd.length >= 8) strength++;
                if (/[a-z]/.test(pwd)) strength++;
                if (/[A-Z]/.test(pwd)) strength++;
                if (/\d/.test(pwd)) strength++;
                if (/[!@#$%^&*(),.?":{}|<>]/.test(pwd)) strength++;

                var percent = (strength / 5) * 100;
                strengthBar.style.width = percent + '%';
                var text = '';
                var color = '';
                if (strength <= 2) { text = 'Weak'; color = '#dc3545'; }
                else if (strength <= 3) { text = 'Medium'; color = '#ffc107'; }
                else { text = 'Strong'; color = '#198754'; }
                strengthText.textContent = text;
                strengthText.style.color = color;
                strengthBar.style.background = color;
                return strength;
            }

            // Check password match
            function checkMatch() {
                var pwd = newPassInput.value;
                var confirm = confirmPassInput.value;
                if (confirm.length === 0) {
                    matchFeedback.textContent = '';
                    matchFeedback.className = 'small mt-1';
                    return false;
                }
                if (pwd === confirm) {
                    matchFeedback.textContent = '✓ Passwords match';
                    matchFeedback.className = 'small mt-1 text-success';
                    return true;
                } else {
                    matchFeedback.textContent = '✗ Passwords do not match';
                    matchFeedback.className = 'small mt-1 text-danger';
                    return false;
                }
            }

            // Update identity attempts display
            function updateIdentityAttemptsDisplay() {
                if (identityLocked) {
                    identityAttemptsDisplay.textContent = '🔒 Identity verification is locked. Please wait.';
                    identityAttemptsDisplay.className = 'small text-danger mb-2';
                    return;
                }
                var remaining = maxIdentityAttempts - identityAttempts;
                identityAttemptsDisplay.textContent = 'Attempts remaining: ' + remaining;
                identityAttemptsDisplay.className = 'small ' + (remaining <= 1 ? 'text-danger' : 'text-muted') + ' mb-2';
            }

            // Start identity lockout
            function startIdentityLockout() {
                identityLocked = true;
                identityLockoutSeconds = 600;
                identityLockoutBanner.style.display = 'block';
                verifyIdentityBtn.disabled = true;
                verifyIdentityBtn.innerHTML = 'Locked - Please wait';
                firstNameInput.disabled = true;
                lastNameInput.disabled = true;
                updateIdentityAttemptsDisplay();

                if (identityLockoutInterval) {
                    clearInterval(identityLockoutInterval);
                }

                identityLockoutInterval = setInterval(function() {
                    identityLockoutSeconds--;
                    var mins = Math.floor(identityLockoutSeconds / 60);
                    var secs = identityLockoutSeconds % 60;
                    identityLockoutTimer.textContent = mins.toString().padStart(2, '0') + ':' + secs.toString().padStart(2, '0');

                    if (identityLockoutSeconds <= 0) {
                        clearInterval(identityLockoutInterval);
                        identityLockoutInterval = null;
                        identityLocked = false;
                        identityAttempts = 0;
                        identityLockoutBanner.style.display = 'none';
                        verifyIdentityBtn.disabled = false;
                        verifyIdentityBtn.innerHTML = 'Verify Identity';
                        firstNameInput.disabled = false;
                        lastNameInput.disabled = false;
                        updateIdentityAttemptsDisplay();
                        showModalToast('Identity verification is now unlocked. You can try again.', 'info');
                    }
                }, 1000);
            }

            // Reset identity verification state
            function resetIdentityVerification() {
                if (identityLockoutInterval) {
                    clearInterval(identityLockoutInterval);
                    identityLockoutInterval = null;
                }
                identityAttempts = 0;
                identityLocked = false;
                identityLockoutSeconds = 0;
                identityLockoutBanner.style.display = 'none';
                verifyIdentityBtn.disabled = false;
                verifyIdentityBtn.innerHTML = 'Verify Identity';
                firstNameInput.disabled = false;
                lastNameInput.disabled = false;
                firstNameInput.value = '';
                lastNameInput.value = '';
                firstNameFeedback.textContent = '';
                firstNameFeedback.className = 'small mt-1';
                lastNameFeedback.textContent = '';
                lastNameFeedback.className = 'small mt-1';
                updateIdentityAttemptsDisplay();
            }

            if (forgotLink) {
                forgotLink.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Reset everything
                    goToStep(0);
                    verifiedUserData = null;
                    resetIdentityVerification();
                    mobileInput.value = '';
                    otpInput.value = '';
                    newPassInput.value = '';
                    confirmPassInput.value = '';

                    var toasts = document.querySelectorAll('.modal-toast');
                    for (var i = 0; i < toasts.length; i++) {
                        toasts[i].remove();
                    }

                    mobileFeedback.textContent = '';
                    mobileFeedback.className = 'small mt-1';
                    otpFeedback.textContent = '';
                    otpFeedback.className = 'small mt-1';
                    matchFeedback.textContent = '';
                    matchFeedback.className = 'small mt-1';
                    verifiedUserDisplay.textContent = '';
                    strengthBar.style.width = '0%';
                    strengthText.textContent = '';

                    sendOtpBtn.disabled = true;
                    sendOtpBtn.innerHTML = 'Send OTP';
                    verifyOtpBtn.disabled = true;
                    verifyOtpBtn.innerHTML = 'Verify OTP';
                    resendOtpBtn.disabled = false;
                    resendOtpBtn.innerHTML = 'Resend OTP';
                    resetPwdBtn.disabled = false;
                    resetPwdBtn.innerHTML = 'Reset Password';

                    // If there's a mobile number in the login form, try to pre-fill
                    if (loginMobileInput) {
                        var loginMobile = loginMobileInput.value.trim();
                        if (loginMobile && isValidMobile(loginMobile)) {
                            // Try to find user by mobile
                            fetch('{{ route("user.find-by-mobile") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ mobile_number: loginMobile })
                            })
                            .then(function(res) { return res.json(); })
                            .then(function(data) {
                                if (data.success && data.user) {
                                    firstNameInput.value = data.user.first_name || '';
                                    lastNameInput.value = data.user.last_name || '';
                                    verifiedUserData = data.user;
                                    showModalToast('Account found! Click "Verify Identity" to continue.', 'info');
                                }
                            })
                            .catch(function() {});
                        }
                    }

                    modal.show();
                });
            }

            // ---- VERIFY IDENTITY with 3-attempt limit ----
            verifyIdentityBtn.addEventListener('click', function() {
                // Check if locked
                if (identityLocked) {
                    showModalToast('Identity verification is locked. Please wait ' + identityLockoutSeconds + ' seconds.', 'error');
                    return;
                }

                // Check attempts
                if (identityAttempts >= maxIdentityAttempts) {
                    startIdentityLockout();
                    showModalToast('Too many failed attempts. Identity verification is locked for 1 minute.', 'error');
                    return;
                }

                var firstName = firstNameInput.value.trim();
                var lastName = lastNameInput.value.trim();

                if (!firstName || firstName.length < 2) {
                    firstNameFeedback.textContent = 'Please enter your first name (min 2 characters)';
                    firstNameFeedback.className = 'small mt-1 text-danger';
                    firstNameInput.focus();
                    return;
                }
                firstNameFeedback.textContent = '';
                firstNameFeedback.className = 'small mt-1';

                if (!lastName || lastName.length < 2) {
                    lastNameFeedback.textContent = 'Please enter your last name (min 2 characters)';
                    lastNameFeedback.className = 'small mt-1 text-danger';
                    lastNameInput.focus();
                    return;
                }
                lastNameFeedback.textContent = '';
                lastNameFeedback.className = 'small mt-1';

                verifyIdentityBtn.disabled = true;
                verifyIdentityBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Verifying...';

                fetch('{{ route("user.verify-identity") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        first_name: firstName,
                        last_name: lastName
                    })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.success && data.user) {
                        // Success - reset attempts
                        identityAttempts = 0;
                        updateIdentityAttemptsDisplay();
                        verifiedUserData = data.user;
                        mobileInput.value = data.user.mobile_number || '';
                        verifiedUserDisplay.textContent = '✓ Verified: ' + data.user.first_name + ' ' + data.user.last_name;
                        showModalToast('Identity verified! Proceed to reset password.', 'success');
                        // Move to step 1 (mobile)
                        goToStep(1);
                        // Auto-enable send OTP if mobile is valid
                        if (mobileInput.value && isValidMobile(mobileInput.value)) {
                            sendOtpBtn.disabled = false;
                        }
                    } else {
                        // Failed - increment attempts
                        identityAttempts++;
                        updateIdentityAttemptsDisplay();
                        var errorMsg = data.error || 'Identity verification failed. Please check your name.';

                        // Check if this was the last attempt
                        if (identityAttempts >= maxIdentityAttempts) {
                            startIdentityLockout();
                            showModalToast('Too many failed attempts. Identity verification is locked for 1 minute.', 'error');
                        } else {
                            var remaining = maxIdentityAttempts - identityAttempts;
                            showModalToast(errorMsg + ' (' + remaining + ' attempt' + (remaining > 1 ? 's' : '') + ' remaining)', 'error');
                        }

                        verifyIdentityBtn.disabled = false;
                        verifyIdentityBtn.innerHTML = 'Verify Identity';
                    }
                })
                .catch(function(err) {
                    // Network error - count as attempt
                    identityAttempts++;
                    updateIdentityAttemptsDisplay();

                    if (identityAttempts >= maxIdentityAttempts) {
                        startIdentityLockout();
                        showModalToast('Too many failed attempts. Identity verification is locked for 1 minute.', 'error');
                    } else {
                        var remaining = maxIdentityAttempts - identityAttempts;
                        showModalToast('Network error. Please try again. (' + remaining + ' attempt' + (remaining > 1 ? 's' : '') + ' remaining)', 'error');
                    }

                    verifyIdentityBtn.disabled = false;
                    verifyIdentityBtn.innerHTML = 'Verify Identity';
                });
            });

            // ---- SEND OTP ----
            sendOtpBtn.addEventListener('click', function() {
                var mobile = mobileInput.value.trim();
                if (!isValidMobile(mobile)) {
                    mobileFeedback.textContent = 'Invalid mobile number. Must be 11 digits starting with 09.';
                    mobileFeedback.className = 'small mt-1 text-danger';
                    return;
                }
                mobileFeedback.textContent = '';
                mobileFeedback.className = 'small mt-1';

                sendOtpBtn.disabled = true;
                sendOtpBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Sending...';

                fetch('{{ route("password.forgot") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ mobile_number: mobile })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.message) {
                        showModalToast(data.message, 'success');
                        goToStep(2);
                    } else {
                        showModalToast(data.error || 'Failed to send OTP.', 'error');
                        sendOtpBtn.disabled = false;
                        sendOtpBtn.innerHTML = 'Send OTP';
                    }
                })
                .catch(function(err) {
                    showModalToast('Network error. Please try again.', 'error');
                    sendOtpBtn.disabled = false;
                    sendOtpBtn.innerHTML = 'Send OTP';
                });
            });

            // ---- VERIFY OTP ----
            verifyOtpBtn.addEventListener('click', function() {
                var mobile = mobileInput.value.trim();
                var otp = otpInput.value.trim();
                if (!isValidMobile(mobile)) {
                    otpFeedback.textContent = 'Invalid mobile number.';
                    otpFeedback.className = 'small mt-1 text-danger';
                    return;
                }
                if (otp.length !== 6) {
                    otpFeedback.textContent = 'OTP must be 6 digits.';
                    otpFeedback.className = 'small mt-1 text-danger';
                    return;
                }
                otpFeedback.textContent = '';
                otpFeedback.className = 'small mt-1';

                verifyOtpBtn.disabled = true;
                verifyOtpBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Verifying...';

                fetch('{{ route("password.verify-otp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ mobile_number: mobile, otp: otp })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.message) {
                        showModalToast(data.message, 'success');
                        goToStep(3);
                    } else {
                        showModalToast(data.error || 'Invalid OTP.', 'error');
                    }
                })
                .catch(function(err) {
                    showModalToast('Network error. Please try again.', 'error');
                })
                .finally(function() {
                    verifyOtpBtn.disabled = false;
                    verifyOtpBtn.innerHTML = 'Verify OTP';
                });
            });

            // ---- RESEND OTP ----
            resendOtpBtn.addEventListener('click', function() {
                var mobile = mobileInput.value.trim();
                if (!isValidMobile(mobile)) {
                    showModalToast('Invalid mobile number.', 'error');
                    return;
                }
                resendOtpBtn.disabled = true;
                resendOtpBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Sending...';

                fetch('{{ route("password.forgot") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ mobile_number: mobile })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.message) {
                        showModalToast('OTP resent successfully.', 'success');
                    } else {
                        showModalToast(data.error || 'Failed to resend OTP.', 'error');
                    }
                })
                .catch(function(err) {
                    showModalToast('Network error.', 'error');
                })
                .finally(function() {
                    resendOtpBtn.disabled = false;
                    resendOtpBtn.innerHTML = 'Resend OTP';
                });
            });

            // ---- RESET PASSWORD ----
            resetPwdBtn.addEventListener('click', function() {
                var mobile = mobileInput.value.trim();
                var password = newPassInput.value;
                var confirm = confirmPassInput.value;

                if (!isValidMobile(mobile)) {
                    showModalToast('Invalid mobile number.', 'error');
                    return;
                }
                if (password.length < 8) {
                    showModalToast('Password must be at least 8 characters.', 'error');
                    return;
                }
                if (password !== confirm) {
                    showModalToast('Passwords do not match.', 'error');
                    return;
                }

                resetPwdBtn.disabled = true;
                resetPwdBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Resetting...';

                fetch('{{ route("password.reset") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        mobile_number: mobile,
                        password: password,
                        password_confirmation: confirm
                    })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.message) {
                        showModalToast(data.message, 'success');
                        setTimeout(function() {
                            modal.hide();
                            window.location.reload();
                        }, 1500);
                    } else {
                        var errMsg = data.error || 'Failed to reset password.';
                        if (data.errors) {
                            errMsg = Object.values(data.errors).flat().join(' ');
                        }
                        showModalToast(errMsg, 'error');
                    }
                })
                .catch(function(err) {
                    showModalToast('Network error. Please try again.', 'error');
                })
                .finally(function() {
                    resetPwdBtn.disabled = false;
                    resetPwdBtn.innerHTML = 'Reset Password';
                });
            });

            // ---- REAL-TIME VALIDATION ----
            firstNameInput.addEventListener('input', function() {
                var val = this.value.trim();
                if (val.length > 0 && val.length < 2) {
                    firstNameFeedback.textContent = 'Min 2 characters';
                    firstNameFeedback.className = 'small mt-1 text-danger';
                } else if (val.length >= 2) {
                    firstNameFeedback.textContent = '✓ Valid';
                    firstNameFeedback.className = 'small mt-1 text-success';
                } else {
                    firstNameFeedback.textContent = '';
                    firstNameFeedback.className = 'small mt-1';
                }
            });

            lastNameInput.addEventListener('input', function() {
                var val = this.value.trim();
                if (val.length > 0 && val.length < 2) {
                    lastNameFeedback.textContent = 'Min 2 characters';
                    lastNameFeedback.className = 'small mt-1 text-danger';
                } else if (val.length >= 2) {
                    lastNameFeedback.textContent = '✓ Valid';
                    lastNameFeedback.className = 'small mt-1 text-success';
                } else {
                    lastNameFeedback.textContent = '';
                    lastNameFeedback.className = 'small mt-1';
                }
            });

            mobileInput.addEventListener('input', function() {
                var val = this.value.trim();
                if (val.length > 0 && !isValidMobile(val)) {
                    mobileFeedback.textContent = 'Invalid format. Must be 11 digits starting with 09.';
                    mobileFeedback.className = 'small mt-1 text-danger';
                } else if (isValidMobile(val)) {
                    mobileFeedback.textContent = '✓ Valid mobile number.';
                    mobileFeedback.className = 'small mt-1 text-success';
                } else {
                    mobileFeedback.textContent = '';
                    mobileFeedback.className = 'small mt-1';
                }
                sendOtpBtn.disabled = !isValidMobile(val);
            });

            otpInput.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '').slice(0, 6);
                var val = this.value.trim();
                if (val.length === 6) {
                    otpFeedback.textContent = '';
                    otpFeedback.className = 'small mt-1';
                    verifyOtpBtn.disabled = false;
                } else {
                    verifyOtpBtn.disabled = true;
                }
            });

            newPassInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
                checkMatch();
            });

            confirmPassInput.addEventListener('input', checkMatch);

            // ---- INITIAL STATE ----
            goToStep(0);
            sendOtpBtn.disabled = true;
            verifyOtpBtn.disabled = true;
            updateIdentityAttemptsDisplay();

            // Auto-check if there's a valid mobile from login
            var initialMobile = mobileInput.value.trim();
            if (initialMobile && isValidMobile(initialMobile)) {
                sendOtpBtn.disabled = false;
            }

            // ---- MODAL EVENTS ----
            modalElement.addEventListener('shown.bs.modal', function() {
                if (!identityLocked) {
                    firstNameInput.focus();
                }
            });

            modalElement.addEventListener('hidden.bs.modal', function() {
                goToStep(0);
                verifiedUserData = null;
                resetIdentityVerification();
                var toasts = document.querySelectorAll('.modal-toast');
                for (var i = 0; i < toasts.length; i++) {
                    toasts[i].remove();
                }
                verifyIdentityBtn.disabled = false;
                verifyIdentityBtn.innerHTML = 'Verify Identity';
                sendOtpBtn.disabled = true;
                sendOtpBtn.innerHTML = 'Send OTP';
                verifyOtpBtn.disabled = true;
                verifyOtpBtn.innerHTML = 'Verify OTP';
                resendOtpBtn.disabled = false;
                resendOtpBtn.innerHTML = 'Resend OTP';
                resetPwdBtn.disabled = false;
                resetPwdBtn.innerHTML = 'Reset Password';
                firstNameFeedback.textContent = '';
                firstNameFeedback.className = 'small mt-1';
                lastNameFeedback.textContent = '';
                lastNameFeedback.className = 'small mt-1';
                mobileFeedback.textContent = '';
                mobileFeedback.className = 'small mt-1';
                otpFeedback.textContent = '';
                otpFeedback.className = 'small mt-1';
                matchFeedback.textContent = '';
                matchFeedback.className = 'small mt-1';
                verifiedUserDisplay.textContent = '';
                otpInput.value = '';
                newPassInput.value = '';
                confirmPassInput.value = '';
                strengthBar.style.width = '0%';
                strengthText.textContent = '';
                updateIdentityAttemptsDisplay();
            });

        })();
    </script>
</body>
</html>
