<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MFA Verification | SureCargo Admin</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style nonce="{{ $csp_nonce }}">
   /* ============================================================
   MFA PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   White & Violet Theme (Light Theme - Matches Login)
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
    --warning-yellow: #f59e0b;
    --warning-soft: #fffbeb;
    
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
   MFA CARD - White & Violet Theme
   ============================================================ */
.mfa-card {
    background: var(--white);
    border-radius: 2rem;
    box-shadow: 0 25px 50px -12px rgba(123, 31, 162, 0.2);
    border: 1px solid rgba(123, 31, 162, 0.15);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    position: relative;
    z-index: 10;
}

.mfa-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 30px 55px -12px rgba(123, 31, 162, 0.25);
    border-color: var(--violet-primary);
}

/* ============================================================
   TYPOGRAPHY - DeepSeek Style
   ============================================================ */
.mfa-card,
.mfa-card .form-label,
.mfa-card .form-control,
.mfa-card .btn,
.mfa-card .alert,
.mfa-card p:not(.small),
.mfa-card .text-secondary-custom,
.mfa-card .attempts-warning {
    font-size: var(--font-base);
    font-weight: 400;
    letter-spacing: -0.01em;
}

h2.fw-bold {
    font-size: var(--font-xxl) !important;
    font-weight: 800 !important;
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
    text-align: center;
    min-height: 48px;
}

.form-control:focus {
    border-color: var(--violet-primary);
    box-shadow: 0 0 0 5px var(--violet-shadow-focus);
    transform: scale(1.01);
    outline: none;
}

.form-control::placeholder {
    font-size: var(--font-base);
    color: #a0a0b0;
    font-weight: 400;
}

.form-control:disabled {
    background: #f1f5f9;
    cursor: not-allowed;
}

/* ============================================================
   VERIFY BUTTON - Violet Gradient
   ============================================================ */
.btn-verify {
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

.btn-verify:hover:not(:disabled) {
    background: linear-gradient(135deg, var(--violet-dark), #380e6b);
    transform: translateY(-3px);
    box-shadow: 0 18px 32px -12px rgba(123, 31, 162, 0.5);
    color: white;
}

.btn-verify:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}

.btn-verify:active:not(:disabled) {
    transform: translateY(0);
}

/* ============================================================
   OUTLINE BUTTON - Violet Theme
   ============================================================ */
.btn-outline-secondary {
    border-radius: 80px;
    padding: var(--sp-sm) var(--sp-lg);
    font-size: var(--font-base);
    font-weight: 600;
    border-width: 2px;
    border-color: var(--violet-primary);
    color: var(--violet-primary);
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background-color: var(--violet-primary);
    border-color: var(--violet-primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(123, 31, 162, 0.2);
}

/* ============================================================
   ALERTS & WARNINGS - Violet Theme
   ============================================================ */
.alert {
    border-radius: 48px;
    border: none;
    font-weight: 500;
    padding: var(--sp-sm) var(--sp-lg);
    backdrop-filter: blur(6px);
    background: rgba(255, 255, 255, 0.95);
    font-size: var(--font-base);
    min-height: 44px;
}

.alert-danger {
    background: #fff5f5;
    color: var(--violet-dark);
    border-left: 8px solid var(--violet-primary);
}

.alert-warning {
    background: var(--warning-soft);
    color: #92400e;
    border-left: 8px solid var(--warning-yellow);
}

.attempts-warning {
    background: var(--warning-soft);
    border-left: 6px solid var(--warning-yellow);
    border-radius: 32px;
    padding: var(--sp-sm) var(--sp-lg);
    font-size: var(--font-base);
    font-weight: 500;
    color: #b45309;
    min-height: 44px;
}

/* ============================================================
   LOCKOUT TIMER - Violet Theme
   ============================================================ */
.lockout-timer {
    font-family: monospace;
    font-size: var(--font-base);
    font-weight: 700;
    background: var(--violet-primary);
    display: inline-block;
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 60px;
    color: white;
    letter-spacing: 2px;
    min-height: 36px;
}

/* ============================================================
   TOAST - Violet Theme
   ============================================================ */
.toast-container {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 1100;
}

.toast {
    background: white;
    border-radius: 28px;
    box-shadow: 0 20px 35px -10px rgba(0,0,0,0.15);
    border-left: 8px solid var(--violet-primary);
    font-size: var(--font-base);
}

.toast.error-toast .toast-header {
    background: var(--violet-soft);
    color: var(--violet-dark);
    border-bottom: none;
    font-weight: 600;
    font-size: var(--font-base);
}

hr {
    margin: var(--sp-xl) 0;
    opacity: 0.5;
    border-color: var(--violet-light);
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

    .mfa-card {
        border-radius: 1.8rem;
    }

    .mfa-card .p-4 {
        padding: var(--sp-lg) !important;
    }

    .form-control {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 44px;
    }

    .btn-verify {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 44px;
    }

    .btn-outline-secondary {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 40px;
    }

    h2.fw-bold {
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

    .mfa-card {
        border-radius: 1.5rem;
    }

    .mfa-card .p-4 {
        padding: var(--sp-lg) !important;
    }

    .mfa-card,
    .mfa-card .form-label,
    .mfa-card .form-control,
    .mfa-card .btn,
    .mfa-card .alert,
    .mfa-card p:not(.small) {
        font-size: var(--font-sm);
    }

    h2.fw-bold {
        font-size: var(--font-xl) !important;
    }

    .form-control {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 42px;
        border-radius: 36px;
    }

    .form-control::placeholder {
        font-size: var(--font-sm);
    }

    .btn-verify {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        min-height: 42px;
        border-radius: 60px;
    }

    .btn-outline-secondary {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
        border-radius: 60px;
    }

    .alert {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        border-radius: 36px;
        min-height: 38px;
    }

    .attempts-warning {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
        border-radius: 28px;
    }

    .lockout-timer {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .toast {
        font-size: var(--font-sm);
    }

    .toast.error-toast .toast-header {
        font-size: var(--font-sm);
    }

    hr {
        margin: var(--sp-lg) 0;
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

    .mfa-card {
        border-radius: 1.2rem;
    }

    .mfa-card .p-4 {
        padding: var(--sp-md) !important;
    }

    .mfa-card,
    .mfa-card .form-label,
    .mfa-card .form-control,
    .mfa-card .btn,
    .mfa-card .alert,
    .mfa-card p:not(.small) {
        font-size: var(--font-xs);
    }

    h2.fw-bold {
        font-size: var(--font-lg) !important;
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

    .btn-verify {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 38px;
        border-radius: 50px;
    }

    .btn-outline-secondary {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 50px;
    }

    .alert {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 30px;
        border-left-width: 5px;
    }

    .attempts-warning {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 24px;
        border-left-width: 4px;
    }

    .lockout-timer {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 30px;
        letter-spacing: 1px;
    }

    .toast {
        font-size: var(--font-xs);
    }

    .toast.error-toast .toast-header {
        font-size: var(--font-xs);
    }

    hr {
        margin: var(--sp-md) 0;
    }

    .d-flex.gap-2 {
        gap: var(--sp-xs) !important;
        flex-wrap: wrap;
    }

    .d-flex.gap-2 .btn {
        width: 100%;
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

    .mfa-card {
        border-radius: 1rem;
    }

    .mfa-card .p-4 {
        padding: var(--sp-sm) !important;
    }

    .mfa-card,
    .mfa-card .form-label,
    .mfa-card .form-control,
    .mfa-card .btn,
    .mfa-card .alert,
    .mfa-card p:not(.small) {
        font-size: 0.55rem;
    }

    h2.fw-bold {
        font-size: var(--font-md) !important;
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

    .btn-verify {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 34px;
        border-radius: 40px;
    }

    .btn-outline-secondary {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        border-radius: 40px;
    }

    .alert {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        border-radius: 24px;
        border-left-width: 4px;
    }

    .attempts-warning {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        border-radius: 20px;
    }

    .lockout-timer {
        font-size: 0.55rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 28px;
    }

    .toast {
        font-size: 0.55rem;
    }

    .toast.error-toast .toast-header {
        font-size: 0.55rem;
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

    .mfa-card {
        border-radius: 0.8rem;
    }

    .mfa-card .p-4 {
        padding: var(--sp-xs) !important;
    }

    .mfa-card,
    .mfa-card .form-label,
    .mfa-card .form-control,
    .mfa-card .btn,
    .mfa-card .alert,
    .mfa-card p:not(.small) {
        font-size: 0.45rem;
    }

    h2.fw-bold {
        font-size: var(--font-sm) !important;
    }

    .form-control {
        min-height: 30px;
        padding: 0.05rem var(--sp-xs);
        border-radius: 20px;
    }

    .btn-verify {
        font-size: 0.45rem;
        min-height: 30px;
        border-radius: 36px;
    }

    .alert {
        font-size: 0.45rem;
        min-height: 26px;
        border-radius: 20px;
    }

    .attempts-warning {
        font-size: 0.45rem;
        min-height: 26px;
    }

    .lockout-timer {
        font-size: 0.45rem;
        min-height: 24px;
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
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                </div>
            @endif
                <div class="mfa-card p-4 p-md-5 p-xl-5">
                    <div class="text-center mb-5">
                        <i class="fas fa-mobile-alt fa-4x" style="color: #dc2626;"></i>
                        <h2 class="fw-bold gradient-text mt-3">Two-Factor Authentication</h2>
                        <p class="text-danger fw-semibold mt-2" style="font-size: 1.5rem;">Enter the 6-digit code from your authenticator app</p>
                    </div>

                    {{-- Hidden error container for toast fallback --}}
                    @if(session('error'))
                        <div id="inline-error" class="alert alert-danger d-flex align-items-center mb-4" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    @php
                        $isLocked = isset($lockoutEnd) && $lockoutEnd > now();
                        $remainingAttempts = $remainingAttempts ?? 3;
                    @endphp

                    @if($isLocked)
                        <div class="alert alert-warning mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-hourglass-half fa-2x me-4"></i>
                                <div>
                                    <strong class="d-block mb-1">Account temporarily locked</strong>
                                    Too many failed attempts. Please wait <span id="countdown-timer" class="lockout-timer ms-2"></span> before trying again.
                                </div>
                            </div>
                        </div>
                    @elseif($remainingAttempts <= 2)
                        <div class="attempts-warning mb-4 d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-3 fa-lg"></i>
                            <span>You have <strong>{{ $remainingAttempts }}</strong> attempt{{ $remainingAttempts !== 1 ? 's' : '' }} remaining. After 3 failed attempts, your account will be locked for 30 minutes.</span>
                        </div>
                    @endif

                    {{-- MFA Code Form --}}
                    <form method="POST" action="{{ route('admin.mfa.verify') }}" id="mfa-form">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Authentication Code</label>
                            <input type="text" name="one_time_password" id="otp-input" class="form-control text-center" placeholder="000000" maxlength="6" autofocus required pattern="[0-9]{6}" inputmode="numeric" {{ $isLocked ? 'disabled' : '' }}>
                            <div class="invalid-feedback" id="otp-feedback" style="font-size:1.2rem;"></div>
                        </div>

                        <button type="submit" class="btn btn-verify w-100" id="submit-btn" {{ $isLocked ? 'disabled' : '' }}>
                            <i class="fas fa-shield-alt me-2"></i> Verify & Login
                        </button>
                    </form>

                    <hr class="my-4">

                    {{-- Recovery Code Form --}}
                    <form method="POST" action="{{ route('admin.mfa.recovery') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Recovery Code</label>
                            <input type="text" name="recovery_code" class="form-control text-center" placeholder="XXXX-XXXX-XXXX" {{ $isLocked ? 'disabled' : '' }}>
                        </div>
                        <button type="submit" class="btn btn-outline-secondary w-100 rounded-pill" {{ $isLocked ? 'disabled' : '' }}>
                            <i class="fas fa-key me-2"></i> Use Recovery Code
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="#" id="timeSyncHelp" class="small-text text-decoration-none" style="color: #dc2626; font-weight: 600;">
                            <i class="fas fa-clock"></i> Code not working? Try syncing your authenticator time
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast Popup for Errors --}}
    <div class="toast-container">
        <div id="errorToast" class="toast error-toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="6000">
            <div class="toast-header">
                <i class="fas fa-exclamation-circle me-2 fa-lg"></i>
                <strong class="me-auto">Verification Failed</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-message"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script nonce="{{ $csp_nonce }}">
        (function() {
            // Lockout countdown timer
            @if($isLocked && isset($lockoutEnd) && $lockoutEnd > now())
                const lockoutEndTimestamp = {{ $lockoutEnd->timestamp }} * 1000;
                const timerElement = document.getElementById('countdown-timer');
                if (timerElement) {
                    function updateTimer() {
                        const now = Date.now();
                        const remainingMs = lockoutEndTimestamp - now;
                        if (remainingMs <= 0) {
                            timerElement.textContent = '00:00';
                            location.reload();
                            return;
                        }
                        const minutes = Math.floor(remainingMs / 60000);
                        const seconds = Math.floor((remainingMs % 60000) / 1000);
                        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }
                    updateTimer();
                    setInterval(updateTimer, 1000);
                }
            @endif

            // Show session error as toast
            const inlineError = document.getElementById('inline-error');
            const errorToastEl = document.getElementById('errorToast');
            if (errorToastEl && inlineError && inlineError.innerText.trim()) {
                const toastBody = document.getElementById('toast-message');
                if (toastBody) toastBody.innerText = inlineError.innerText.trim();
                const toast = new bootstrap.Toast(errorToastEl, { autohide: true, delay: 6000 });
                toast.show();
            }

            // Client-side validation
            const form = document.getElementById('mfa-form');
            const otpInput = document.getElementById('otp-input');
            const submitBtn = document.getElementById('submit-btn');
            const otpFeedback = document.getElementById('otp-feedback');

            if (form && otpInput) {
                otpInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
                    if (this.value.length === 6) {
                        this.classList.remove('is-invalid');
                        otpFeedback.style.display = 'none';
                    }
                });

                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    let errorMsg = '';
                    const code = otpInput.value.trim();

                    if (!code) {
                        errorMsg = 'Please enter the 6-digit authentication code.';
                        isValid = false;
                    } else if (!/^\d{6}$/.test(code)) {
                        errorMsg = 'Code must be exactly 6 digits (0-9).';
                        isValid = false;
                    }

                    if (!isValid) {
                        e.preventDefault();
                        otpInput.classList.add('is-invalid');
                        otpFeedback.innerText = errorMsg;
                        otpFeedback.style.display = 'block';
                        if (errorToastEl) {
                            const toastBody = document.getElementById('toast-message');
                            if (toastBody) toastBody.innerText = errorMsg;
                            const toast = new bootstrap.Toast(errorToastEl, { autohide: true, delay: 5000 });
                            toast.show();
                        }
                        return false;
                    }
                    otpInput.classList.remove('is-invalid');
                    otpFeedback.style.display = 'none';
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Verifying...';
                    return true;
                });
            }

            // Time sync help
            const syncLink = document.getElementById('timeSyncHelp');
            if (syncLink) {
                syncLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    const helpMsg = 'If your codes are not working, open Google Authenticator → tap menu → "Settings" → "Time correction for codes" → "Sync now". Then wait 30 seconds and try a fresh code.';
                    if (errorToastEl) {
                        const toastBody = document.getElementById('toast-message');
                        if (toastBody) toastBody.innerText = helpMsg;
                        const toast = new bootstrap.Toast(errorToastEl, { autohide: true, delay: 8000 });
                        toast.show();
                    } else {
                        alert(helpMsg);
                    }
                });
            }
        })();
    </script>
</body>
</html>

