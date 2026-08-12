<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | SureCargo</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style nonce="{{ $csp_nonce }}">
/* ============================================================
   LOGIN PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   White & Violet Theme (Light Theme)
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-dark: #4a148c;
    --violet-light: #d1c4e9;
    --violet-soft: #f3e5f5;
    --violet-bg-light: #f3f0f7;
    --violet-bg-lighter: #e8e0f0;
    --violet-shadow: rgba(123, 31, 162, 0.08);
    --violet-shadow-hover: rgba(123, 31, 162, 0.12);
    --violet-shadow-focus: rgba(123, 31, 162, 0.25);
    --violet-gradient-start: #7b1fa2;
    --violet-gradient-end: #4a148c;
    --white: #ffffff;
    --text-dark: #2c2c3e;
    --text-muted: #6c6c80;
    --gray-soft: #f8f9fa;
    --border-color: #d1c4e9;
    --success-green: #22c55e;
    
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
    background: linear-gradient(135deg, #ffffff, #f0e6f5 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow-x: hidden;
    padding: var(--sp-xl);
    font-size: var(--font-base);
    font-weight: 400;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: var(--text-dark);
}

/* ============================================================
   LOGIN CARD - White & Violet Theme
   ============================================================ */
.login-card {
    background: var(--white);
    border-radius: 2rem;
    box-shadow: 0 25px 50px -12px rgba(123, 31, 162, 0.2);
    border: 1px solid rgba(123, 31, 162, 0.15);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    position: relative;
    z-index: 10;
}

.login-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 30px 55px -12px rgba(123, 31, 162, 0.25);
    border-color: var(--violet-primary);
}

/* ============================================================
   TYPOGRAPHY - DeepSeek Style
   ============================================================ */
.login-card,
.login-card .form-label,
.login-card .form-control,
.login-card .btn,
.login-card .alert,
.login-card p:not(.small),
.login-card .input-group-text {
    font-size: var(--font-base);
    font-weight: 400;
    letter-spacing: -0.01em;
}

.display-6 {
    font-size: var(--font-xxxl) !important;
    font-weight: 800 !important;
    color: var(--violet-dark);
}

h2.fw-bold {
    font-size: var(--font-xxl);
    font-weight: 800;
    color: var(--violet-dark);
}

.gradient-text {
    background: linear-gradient(125deg, var(--violet-primary), var(--violet-dark), var(--violet-light));
    background-size: 200% auto;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    animation: shimmer 4s infinite linear;
}

@keyframes shimmer {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* ============================================================
   FORM CONTROLS - Violet Theme
   ============================================================ */
.form-control {
    background: var(--white);
    border: 2px solid var(--violet-light);
    border-radius: 48px;
    padding: var(--sp-sm) var(--sp-lg);
    font-size: var(--font-base);
    color: var(--text-dark);
    transition: all 0.25s ease;
    min-height: 48px;
}

.form-control:focus {
    border-color: var(--violet-primary);
    box-shadow: 0 0 0 5px var(--violet-shadow-focus);
    background: var(--white);
    outline: none;
    transform: scale(1.01);
}

.form-control::placeholder {
    font-size: var(--font-base);
    color: #a0a0b0;
    font-weight: 400;
}

.input-group-text {
    background: var(--violet-soft);
    border: 2px solid var(--violet-light);
    border-right: none;
    border-radius: 48px 0 0 48px;
    color: var(--violet-dark);
    font-size: var(--font-base);
    padding: 0 var(--sp-lg);
    font-weight: 600;
    min-height: 48px;
}

.input-group .form-control {
    border-left: none;
    border-radius: 0 48px 48px 0;
}

/* ============================================================
   LOGIN BUTTON - Violet Gradient
   ============================================================ */
.btn-login {
    background: linear-gradient(135deg, var(--violet-primary), var(--violet-dark));
    border: none;
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 80px;
    font-weight: 600;
    font-size: var(--font-base);
    transition: all 0.35s ease;
    box-shadow: 0 12px 28px -10px rgba(123, 31, 162, 0.4);
    color: white;
    min-height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-login:hover {
    background: linear-gradient(135deg, var(--violet-dark), #380e6b);
    transform: translateY(-3px);
    box-shadow: 0 18px 32px -12px rgba(123, 31, 162, 0.5);
    color: white;
}

.btn-login:active {
    transform: translateY(0);
}

/* ============================================================
   ALERTS - Violet Theme
   ============================================================ */
.alert {
    border-radius: 48px;
    border: none;
    font-weight: 500;
    font-size: var(--font-base);
    padding: var(--sp-sm) var(--sp-lg);
    backdrop-filter: blur(6px);
    min-height: 44px;
}

.alert-danger {
    background: #fff5f5;
    color: var(--violet-dark);
    border-left: 8px solid var(--violet-primary);
    box-shadow: 0 6px 14px rgba(123, 31, 162, 0.1);
}

.alert-success {
    background: #f0fdf4;
    color: #166534;
    border-left: 8px solid var(--success-green);
}

/* ============================================================
   LOCKOUT BANNER - Violet Theme
   ============================================================ */
.lockout-banner {
    background: #fff0f0;
    border: 3px solid var(--violet-primary);
    border-radius: 40px;
    padding: var(--sp-lg) var(--sp-md);
    text-align: center;
    box-shadow: 0 15px 30px rgba(123, 31, 162, 0.15);
    margin-bottom: var(--sp-xl);
}

.lockout-banner i {
    font-size: var(--font-xxl);
    color: var(--violet-primary);
    margin-bottom: var(--sp-sm);
}

.lockout-banner .big-headline {
    font-size: var(--font-xxl);
    font-weight: 800;
    color: var(--violet-dark);
}

.lockout-banner .countdown-timer {
    font-size: var(--font-xl);
    font-weight: 800;
    background: rgba(255, 255, 255, 0.8);
    display: inline-block;
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 60px;
    margin-top: var(--sp-md);
    font-family: monospace;
    color: var(--violet-dark);
    min-height: 44px;
}

/* ============================================================
   LAST ATTEMPT WARNING
   ============================================================ */
.last-attempt-warning {
    background: #fff3cd;
    border-left: 8px solid #ffc107;
    color: #856404;
    transition: opacity 0.3s ease;
}

/* ============================================================
   HONEYPOT
   ============================================================ */
.honeypot {
    position: absolute;
    left: -9999px;
    opacity: 0;
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

    body {
        padding: var(--sp-lg);
    }

    .login-card {
        border-radius: 1.8rem;
    }

    .login-card .p-4 {
        padding: var(--sp-lg) !important;
    }

    .form-control {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 44px;
    }

    .input-group-text {
        padding: 0 var(--sp-md);
        min-height: 44px;
    }

    .btn-login {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 44px;
    }

    .display-6 {
        font-size: var(--font-xl) !important;
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

    body {
        padding: var(--sp-md);
    }

    .login-card {
        border-radius: 1.5rem;
    }

    .login-card .p-4 {
        padding: var(--sp-lg) !important;
    }

    .login-card,
    .login-card .form-label,
    .login-card .form-control,
    .login-card .btn,
    .login-card .alert,
    .login-card .input-group-text {
        font-size: var(--font-sm);
    }

    .display-6 {
        font-size: var(--font-xl) !important;
    }

    h2.fw-bold {
        font-size: var(--font-lg);
    }

    .form-control {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 42px;
        border-radius: 36px;
    }

    .form-control::placeholder {
        font-size: var(--font-sm);
    }

    .input-group-text {
        padding: 0 var(--sp-md);
        font-size: var(--font-sm);
        min-height: 42px;
    }

    .btn-login {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        min-height: 42px;
        border-radius: 60px;
    }

    .alert {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        border-radius: 36px;
        min-height: 38px;
    }

    .lockout-banner {
        padding: var(--sp-md);
        border-radius: 32px;
    }

    .lockout-banner i {
        font-size: var(--font-lg);
    }

    .lockout-banner .big-headline {
        font-size: var(--font-lg);
    }

    .lockout-banner .countdown-timer {
        font-size: var(--font-md);
        padding: var(--sp-xs) var(--sp-md);
        min-height: 38px;
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

    body {
        padding: var(--sp-sm);
    }

    .login-card {
        border-radius: 1.2rem;
    }

    .login-card .p-4 {
        padding: var(--sp-md) !important;
    }

    .login-card,
    .login-card .form-label,
    .login-card .form-control,
    .login-card .btn,
    .login-card .alert,
    .login-card .input-group-text {
        font-size: var(--font-xs);
    }

    .display-6 {
        font-size: var(--font-lg) !important;
    }

    h2.fw-bold {
        font-size: var(--font-md);
    }

    .form-control {
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 38px;
        border-radius: 30px;
        border-width: 1.5px;
    }

    .form-control::placeholder {
        font-size: var(--font-xs);
    }

    .input-group-text {
        padding: 0 var(--sp-sm);
        font-size: var(--font-xs);
        min-height: 38px;
        border-radius: 30px 0 0 30px;
    }

    .input-group .form-control {
        border-radius: 0 30px 30px 0;
    }

    .btn-login {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 38px;
        border-radius: 50px;
    }

    .alert {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 30px;
        min-height: 34px;
        border-left-width: 5px;
    }

    .lockout-banner {
        padding: var(--sp-sm);
        border-radius: 28px;
        border-width: 2px;
    }

    .lockout-banner i {
        font-size: var(--font-md);
        margin-bottom: var(--sp-xs);
    }

    .lockout-banner .big-headline {
        font-size: var(--font-md);
    }

    .lockout-banner .countdown-timer {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        margin-top: var(--sp-xs);
    }

    .last-attempt-warning {
        border-left-width: 5px;
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

    body {
        padding: var(--sp-xs);
    }

    .login-card {
        border-radius: 1rem;
    }

    .login-card .p-4 {
        padding: var(--sp-sm) !important;
    }

    .login-card,
    .login-card .form-label,
    .login-card .form-control,
    .login-card .btn,
    .login-card .alert,
    .login-card .input-group-text {
        font-size: 0.55rem;
    }

    .display-6 {
        font-size: var(--font-md) !important;
    }

    h2.fw-bold {
        font-size: var(--font-sm);
    }

    .form-control {
        padding: 0.1rem var(--sp-xs);
        min-height: 34px;
        border-radius: 24px;
        border-width: 1px;
    }

    .form-control::placeholder {
        font-size: 0.5rem;
    }

    .input-group-text {
        padding: 0 var(--sp-xs);
        font-size: 0.55rem;
        min-height: 34px;
        border-radius: 24px 0 0 24px;
    }

    .input-group .form-control {
        border-radius: 0 24px 24px 0;
    }

    .btn-login {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 34px;
        border-radius: 40px;
    }

    .alert {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        border-radius: 24px;
        border-left-width: 4px;
    }

    .lockout-banner {
        padding: var(--sp-xs);
        border-radius: 20px;
    }

    .lockout-banner i {
        font-size: var(--font-sm);
    }

    .lockout-banner .big-headline {
        font-size: var(--font-sm);
    }

    .lockout-banner .countdown-timer {
        font-size: 0.55rem;
        min-height: 30px;
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

    .login-card {
        border-radius: 0.8rem;
    }

    .login-card .p-4 {
        padding: var(--sp-xs) !important;
    }

    .login-card,
    .login-card .form-label,
    .login-card .form-control,
    .login-card .btn,
    .login-card .alert,
    .login-card .input-group-text {
        font-size: 0.45rem;
    }

    .display-6 {
        font-size: var(--font-sm) !important;
    }

    .form-control {
        min-height: 30px;
        padding: 0.05rem var(--sp-xs);
        border-radius: 20px;
    }

    .input-group-text {
        min-height: 30px;
        padding: 0 var(--sp-xs);
        border-radius: 20px 0 0 20px;
    }

    .input-group .form-control {
        border-radius: 0 20px 20px 0;
    }

    .btn-login {
        font-size: 0.45rem;
        min-height: 30px;
        border-radius: 36px;
    }

    .alert {
        font-size: 0.45rem;
        min-height: 26px;
        border-radius: 20px;
    }

    .lockout-banner .big-headline {
        font-size: 0.6rem;
    }

    .lockout-banner .countdown-timer {
        font-size: 0.45rem;
        min-height: 26px;
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
</head>
<body>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="login-card p-4 p-lg-5">
                <div class="text-center mb-4">
                    <i class="fas fa-shield-alt fa-4x" style="color: #dc2626;"></i>
                    <h2 class="fw-bold gradient-text display-6 mt-3">SureCargo Admin</h2>
                    <p class="text-danger fw-semibold mt-2" style="font-size: 1.5rem;">Secure Command Center</p>
                </div>

                @php
                    $lockoutRemaining = session('lockout_remaining') ?? ($lockoutRemaining ?? null);
                    $lastAttemptWarning = session('last_attempt_warning');
                    $isLocked = $lockoutRemaining && $lockoutRemaining > 0;
                @endphp

                {{-- LOCKOUT BANNER --}}
                @if($isLocked)
                    <div class="lockout-banner" id="lockoutBanner">
                        <i class="fas fa-hourglass-half"></i>
                        <div class="big-headline">🔒 ACCOUNT LOCKED</div>
                        <div class="big-message">Too many failed attempts. Try again in:</div>
                        <div class="countdown-timer" id="countdownDisplay">
                            {{ gmdate("i:s", $lockoutRemaining) }}
                        </div>
                        <small class="d-block mt-3 text-danger">Your account is temporarily locked for 30 minutes.</small>
                    </div>
                @endif

                {{-- LAST ATTEMPT WARNING --}}
                @if($lastAttemptWarning)
                    <div class="alert last-attempt-warning mb-4 d-flex align-items-center gap-2" id="lastAttemptWarning">
                        <i class="fas fa-exclamation-triangle me-2 fa-fw"></i>
                        {{ $lastAttemptWarning }}
                    </div>
                @endif

                {{-- OTHER ERRORS --}}
                @if ($errors->any() && !$errors->has('locked') && !$lastAttemptWarning && !$isLocked)
                    <div class="alert alert-danger mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-exclamation-circle me-2 fa-fw"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" id="loginForm">
                    @csrf
                    <div class="honeypot">
                        <label for="website">Website</label>
                        <input type="text" name="website" id="website" autocomplete="off" tabindex="-1">
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-envelope me-2 text-danger"></i> Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@surecargo.com" @if($isLocked) disabled @endif>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label"><i class="fas fa-lock me-2 text-danger"></i> Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" required autocomplete="current-password" placeholder="••••••••" @if($isLocked) disabled @endif>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100" @if($isLocked) disabled id="lockedSubmitBtn" @endif>
                        <i class="fas fa-sign-in-alt me-2"></i> Access Dashboard
                    </button>
                </form>

                <div class="text-center mt-5 pt-2">
                    <small class="text-danger small-text" style="font-size: 1.25rem;">
                        <i class="fas fa-shield-alt me-1"></i> Encrypted & Secure Login
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script nonce="{{ $csp_nonce }}">
    (function() {
        // --------------------------------------------------------------
        // 1. AUTO-DISMISS ALL WARNING MESSAGES AFTER 5 SECONDS
        //    (Includes: last-attempt-warning, alert-danger, alert-success)
        //    Excludes lockout banner contents to keep lockout info safe.
        // --------------------------------------------------------------
        const AUTO_DISMISS_DELAY_MS = 5000; // 5 seconds

        // Target all dismissible alerts within the login card, but avoid lockout banner areas.
        const alertSelectors = ['.alert-danger', '.alert-success', '.last-attempt-warning'];
        let dismissibleAlerts = [];

        alertSelectors.forEach(selector => {
            const alerts = document.querySelectorAll(selector);
            alerts.forEach(alert => {
                // Safety: never auto-remove any alert that lives inside the lockout banner
                if (!alert.closest('.lockout-banner')) {
                    dismissibleAlerts.push(alert);
                }
            });
        });

        // Function to gracefully fade out and remove element
        function fadeOutAndRemove(element) {
            if (!element || element._removing) return;
            element._removing = true;
            // Apply transition style for smooth fade
            element.style.transition = 'opacity 0.3s ease';
            element.style.opacity = '0';
            setTimeout(() => {
                if (element.parentNode) element.remove();
            }, 300);
        }

        // Schedule removal for each alert
        dismissibleAlerts.forEach(alert => {
            setTimeout(() => {
                fadeOutAndRemove(alert);
            }, AUTO_DISMISS_DELAY_MS);
        });

        // --------------------------------------------------------------
        // 2. LOCKOUT COUNTDOWN HANDLER (Preserved & untouched)
        // --------------------------------------------------------------
        const lockoutRemaining = @json($lockoutRemaining ?? null);
        if (lockoutRemaining && lockoutRemaining > 0) {
            let remainingSeconds = lockoutRemaining;
            const countdownElement = document.getElementById('countdownDisplay');
            const formInputs = document.querySelectorAll('#loginForm input, #loginForm button');
            formInputs.forEach(input => input.disabled = true);

            const timerInterval = setInterval(() => {
                if (remainingSeconds <= 0) {
                    clearInterval(timerInterval);
                    window.location.reload();
                    return;
                }
                remainingSeconds--;
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;
                if (countdownElement) {
                    countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                }
            }, 1000);
        }

        // --------------------------------------------------------------
        // 3. DISABLE BUTTON ON FORM SUBMIT (Prevent double submission)
        // --------------------------------------------------------------
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('lockedSubmitBtn') || document.querySelector('.btn-login');
        if (form && btn && !btn.disabled) {
            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-pulse me-2"></i> Authenticating...';
            });
        }

        // --------------------------------------------------------------
        // 4. CLEAN HONEYPOT FIELD (Anti-spam technique)
        // --------------------------------------------------------------
        const honeypot = document.getElementById('website');
        if (honeypot) honeypot.value = '';
    })();
</script>
</body>
</html>

