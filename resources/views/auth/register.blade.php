<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SureCargo Transport | Create Account</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style nonce="{{ $csp_nonce }}">
       /* ---------- RESET & GLOBAL (SureCar Design System) ---------- */
*,
*::before,
*::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --color-primary-bg: #FFFFFF;
    --color-deep-navy: #1E3A8A;
    --color-bright-blue: #3B82F6;
    --color-light-blue-accent: #DBEAFE;
    --color-success: #10B981;
    --color-error: #EF4444;
    --color-warning: #F59E0B;
    --color-text-dark: #111827;
    --color-text-gray: #6B7280;
    --color-border-light: #E5E7EB;
    --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 12px rgba(30, 58, 138, 0.08);
    --shadow-lg: 0 8px 24px rgba(30, 58, 138, 0.12);
    --transition-fast: 200ms cubic-bezier(0.4, 0, 0.2, 1);
    --transition-base: 300ms cubic-bezier(0.4, 0, 0.2, 1);
    --transition-slow: 400ms cubic-bezier(0.2, 0.9, 0.4, 1.1);

    /* DEEPSEEK-STYLE FONT SIZES */
    --font-xs: 0.75rem;
    --font-sm: 0.875rem;
    --font-base: 1rem;
    --font-md: 1.125rem;
    --font-lg: 1.25rem;
    --font-xl: 1.5rem;
    --font-xxl: 1.75rem;
    --font-xxxl: 2.25rem;
}

/* ---------- BASE FONT SIZES (DeepSeek Style) ---------- */
html {
    font-size: 16px;
    -webkit-text-size-adjust: 100%;
}

body {
    font-family: var(--font-sans);
    font-weight: 400;
    line-height: 1.6;
    overflow-x: hidden;
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 1rem;
    font-size: var(--font-base);
    color: var(--color-text-dark);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ---------- TYPOGRAPHY ---------- */
.register-header h3 {
    font-size: var(--font-xxl);
    font-weight: 800;
    background: linear-gradient(135deg, var(--color-deep-navy), var(--color-bright-blue));
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    letter-spacing: -0.02em;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.register-header p {
    font-size: var(--font-base);
    color: var(--color-text-gray);
    font-weight: 400;
}

.form-label {
    font-weight: 500;
    font-size: var(--font-base);
    margin-bottom: 0.4rem;
    color: var(--color-text-dark);
}

.form-control,
.form-select {
    font-size: var(--font-base);
    padding: 0.65rem 1rem;
    border-radius: 0.75rem;
    border: 1.5px solid var(--color-border-light);
    background: #FFFFFF;
    transition: all var(--transition-fast);
    height: auto;
    line-height: 1.5;
    min-height: 44px;
    color: var(--color-text-dark);
}

.form-control:focus,
.form-select:focus {
    border-color: var(--color-bright-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    outline: none;
}

small,
.text-muted,
.requirement-check div,
.password-match,
.otp-timer {
    font-size: var(--font-sm);
    line-height: 1.5;
    font-weight: 400;
    color: var(--color-text-gray);
}

/* ---------- BUTTONS ---------- */
.btn-primary-custom,
.btn-next,
.btn-register,
.btn-otp-verify {
    background: var(--color-deep-navy);
    border: none;
    padding: 0.65rem 1.5rem;
    border-radius: 0.75rem;
    font-size: var(--font-base);
    font-weight: 600;
    color: white;
    transition: all var(--transition-fast);
    position: relative;
    overflow: hidden;
    cursor: pointer;
    touch-action: manipulation;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary-custom:hover:not(:disabled),
.btn-next:hover:not(:disabled),
.btn-register:hover:not(:disabled),
.btn-otp-verify:hover:not(:disabled) {
    background: #1E40AF;
    transform: scale(1.02);
    box-shadow: 0 8px 18px rgba(30, 58, 138, 0.25);
}

.btn-primary-custom:active:not(:disabled),
.btn-next:active:not(:disabled),
.btn-register:active:not(:disabled),
.btn-otp-verify:active:not(:disabled) {
    transform: scale(0.98);
}

.btn-primary-custom:disabled,
.btn-next:disabled,
.btn-register:disabled,
.btn-otp-verify:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-back {
    background: #F3F4F6;
    color: var(--color-text-dark);
    border: 1px solid var(--color-border-light);
    padding: 0.65rem 1.5rem;
    border-radius: 0.75rem;
    font-size: var(--font-base);
    font-weight: 500;
    transition: all var(--transition-fast);
    cursor: pointer;
    touch-action: manipulation;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-back:hover {
    background: #E5E7EB;
    transform: translateY(-2px);
}

.btn-resend-otp {
    background: transparent;
    border: 1px solid var(--color-bright-blue);
    border-radius: 2rem;
    color: var(--color-bright-blue);
    padding: 0.5rem 1rem;
    font-size: var(--font-sm);
    font-weight: 500;
    cursor: pointer;
    touch-action: manipulation;
    min-height: 38px;
    transition: all var(--transition-fast);
}

.btn-resend-otp:hover:not(:disabled) {
    background: var(--color-light-blue-accent);
    transform: scale(1.02);
}

.btn-resend-otp:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* ---------- CARDS ---------- */
.register-card {
    background: #FFFFFF;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--color-border-light);
    transition: transform var(--transition-base), box-shadow var(--transition-base);
    width: 100%;
    max-width: 520px;
    margin: 0 auto;
}

.register-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 32px -12px rgba(30, 58, 138, 0.2);
}

.register-body {
    padding: var(--sp-xl);
}

/* ---------- SPACING VARIABLES ---------- */
:root {
    --sp-xs: 0.25rem;
    --sp-sm: 0.5rem;
    --sp-md: 1rem;
    --sp-lg: 1.5rem;
    --sp-xl: 2rem;
}

/* ---------- FORM ELEMENTS ---------- */
.input-icon {
    position: relative;
}

.input-icon i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--color-bright-blue);
    z-index: 2;
    pointer-events: none;
    font-size: var(--font-md);
}

.input-icon input,
.input-icon select {
    padding-left: 3rem;
}

.valid-field {
    border-color: var(--color-success) !important;
    background-color: #F0FDF4 !important;
}

.invalid-field {
    border-color: var(--color-error) !important;
    background-color: #FEF2F2 !important;
    animation: shake 0.4s ease-in-out 0s 1;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* ---------- PROGRESS STEPS ---------- */
.step-progress {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.step-dot {
    width: 10px;
    height: 10px;
    border-radius: 40px;
    background: #CBD5E1;
    transition: all 0.3s ease;
}

.step-dot.active {
    width: 32px;
    background: var(--color-bright-blue);
}

.step-dot.completed {
    background: var(--color-success);
}

.steps-wrapper {
    overflow: hidden;
    width: 100%;
}

.steps-container {
    display: flex;
    transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    width: 100%;
}

.step {
    flex: 0 0 100%;
    padding: 0 0.25rem;
}

/* ---------- PASSWORD STRENGTH ---------- */
.strength-bar {
    height: 6px;
    background: #E5E7EB;
    border-radius: 12px;
    margin-top: 10px;
    overflow: hidden;
}

.strength-bar-fill {
    height: 100%;
    border-radius: 12px;
    width: 0%;
    transition: width 0.2s ease;
}

/* ---------- ALERTS & TOASTS ---------- */
.error-container {
    background: #FEF2F2;
    border-left: 5px solid var(--color-error);
    border-radius: 1rem;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    animation: slideInRight 0.4s ease, shakeOnce 0.5s ease;
    font-size: var(--font-base);
    color: #991b1b;
}

.success-toast {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 1100;
    background: #ECFDF5;
    border-left: 4px solid var(--color-success);
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    color: #065F46;
    font-weight: 500;
    animation: slideInRight 0.3s ease, fadeOut 0.5s ease 4.5s forwards;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: var(--font-base);
}

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes fadeOut {
    to { opacity: 0; visibility: hidden; }
}

@keyframes shakeOnce {
    0%, 100% { transform: translateX(0); }
    20% { transform: translateX(-6px); }
    40% { transform: translateX(6px); }
    60% { transform: translateX(-3px); }
}

/* ---------- MODALS ---------- */
.modal-content {
    border-radius: 1.5rem;
    border: none;
    box-shadow: 0 25px 40px -12px rgba(0,0,0,0.25);
    animation: modalPop 0.4s cubic-bezier(0.34, 1.2, 0.64, 1);
}

@keyframes modalPop {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.modal-backdrop.show {
    backdrop-filter: blur(6px);
    background-color: rgba(0,0,0,0.5);
}

.modal-body {
    padding: 1.5rem;
    font-size: var(--font-base);
}

.modal-footer {
    padding: 1rem 1.5rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.modal .btn {
    font-size: var(--font-base);
    min-height: 44px;
    padding: 0.5rem 1.5rem;
    border-radius: 0.75rem;
}

/* ---------- PRIVACY CHECK ---------- */
.privacy-check-row {
    margin-top: 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.privacy-check-row .form-check {
    margin: 0;
    padding-left: 1.8rem;
    min-height: auto;
}

.privacy-check-row .form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    margin-top: 0.1rem;
    cursor: pointer;
    min-width: 1.2rem;
    min-height: 1.2rem;
}

.privacy-check-row .form-check-label {
    font-size: var(--font-base);
    font-weight: 400;
    color: var(--color-text-dark);
}

.privacy-link {
    color: var(--color-deep-navy);
    text-decoration: underline;
    font-weight: 500;
    cursor: pointer;
    transition: color 0.2s;
    touch-action: manipulation;
}

.privacy-link:hover {
    color: var(--color-bright-blue);
}

/* ---------- REQUIREMENTS ---------- */
.requirement-met {
    color: var(--color-success);
}

.requirement-unmet {
    color: var(--color-text-gray);
}

.requirement-met i,
.requirement-unmet i {
    margin-right: 6px;
}

.tracking-dot {
    display: inline-block;
    width: 12px;
    height: 12px;
    background: var(--color-bright-blue);
    border-radius: 50%;
    box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
    animation: pulse-blue 1.8s infinite;
    margin-right: 6px;
}

@keyframes pulse-blue {
    0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.5); }
    70% { box-shadow: 0 0 0 6px rgba(59, 130, 246, 0); }
    100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
}

/* ---------- RIPPLE EFFECT ---------- */
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    transform: scale(0);
    animation: rippleAnim 0.6s linear;
    pointer-events: none;
}

@keyframes rippleAnim {
    to { transform: scale(4); opacity: 0; }
}

/* ---------- DEVICE BLOCKED OVERLAY ---------- */
.device-blocked-overlay {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(2px) !important;
    z-index: 10 !important;
    border-radius: 1.5rem !important;
    display: none !important;
    align-items: center !important;
    justify-content: center !important;
    flex-direction: column !important;
    padding: 2rem !important;
    text-align: center !important;
}

.device-blocked-overlay.show {
    display: flex !important;
}

.device-blocked-overlay i {
    font-size: 4rem !important;
    color: var(--color-error) !important;
    margin-bottom: 1rem !important;
}

.device-blocked-overlay h4 {
    font-weight: 700 !important;
    color: var(--color-text-dark) !important;
    font-size: var(--font-lg);
}

.device-blocked-overlay p {
    color: var(--color-text-gray) !important;
    font-size: var(--font-base);
}

/* ============================================================ */
/* ===== RESPONSIVE (DeepSeek Style) ===== */
/* ============================================================ */

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

    body {
        padding: 0.75rem;
        font-size: var(--font-base);
    }

    .register-card {
        max-width: 98%;
        border-radius: 1.2rem;
    }

    .register-body {
        padding: var(--sp-lg) !important;
    }

    .register-header {
        padding: var(--sp-md) var(--sp-md) var(--sp-sm) !important;
    }

    .register-header h3 {
        font-size: var(--font-xl);
    }

    .register-header p {
        font-size: var(--font-sm);
    }

    .form-label {
        font-size: var(--font-sm);
        margin-bottom: 0.3rem;
    }

    .form-control,
    .form-select {
        font-size: var(--font-sm);
        padding: 0.5rem 0.8rem;
        min-height: 38px;
    }

    .btn-primary-custom,
    .btn-next,
    .btn-register,
    .btn-back,
    .btn-otp-verify {
        font-size: var(--font-sm);
        padding: 0.5rem 1rem;
        min-height: 38px;
    }

    .input-icon i {
        font-size: var(--font-base);
        left: 0.75rem;
    }

    .input-icon input,
    .input-icon select {
        padding-left: 2.5rem;
    }

    small,
    .text-muted,
    .requirement-check div,
    .password-match,
    .otp-timer {
        font-size: var(--font-xs);
    }

    .step-progress {
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .step-dot {
        width: 8px;
        height: 8px;
    }

    .step-dot.active {
        width: 24px;
    }

    .privacy-check-row .form-check-label {
        font-size: var(--font-sm);
    }

    .privacy-check-row .form-check-input {
        width: 1rem;
        height: 1rem;
        min-width: 1rem;
        min-height: 1rem;
    }

    .d-flex.justify-content-between {
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-next,
    .btn-back,
    .btn-register {
        width: 100%;
    }

    .error-container {
        padding: 0.75rem 1rem;
        font-size: var(--font-sm);
    }

    .success-toast {
        font-size: var(--font-sm);
        padding: 0.75rem 1rem;
        top: 12px;
        right: 12px;
    }

    .modal-content {
        border-radius: 1rem;
    }

    .modal-body {
        padding: 1rem;
        font-size: var(--font-sm);
    }

    .modal-footer {
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .modal-footer .btn {
        width: 100%;
        font-size: var(--font-sm);
        min-height: 38px;
    }

    .btn-resend-otp {
        font-size: var(--font-xs);
        padding: 0.4rem 0.8rem;
        min-height: 34px;
    }

    .device-blocked-overlay h4 {
        font-size: var(--font-md);
    }

    .device-blocked-overlay p {
        font-size: var(--font-sm);
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

    body {
        padding: 0.5rem;
    }

    .register-card {
        border-radius: 1rem;
        max-width: 100%;
    }

    .register-body {
        padding: var(--sp-md) !important;
    }

    .register-header h3 {
        font-size: var(--font-lg);
    }

    .register-header p {
        font-size: var(--font-xs);
    }

    .form-control,
    .form-select {
        padding: 0.4rem 0.6rem;
        font-size: var(--font-xs);
        min-height: 34px;
        border-radius: 0.5rem;
    }

    .form-label {
        font-size: var(--font-xs);
    }

    .btn-primary-custom,
    .btn-next,
    .btn-register,
    .btn-back,
    .btn-otp-verify {
        font-size: var(--font-xs);
        padding: 0.4rem 0.8rem;
        min-height: 34px;
        border-radius: 0.5rem;
    }

    .input-icon i {
        font-size: var(--font-sm);
        left: 0.6rem;
    }

    .input-icon input,
    .input-icon select {
        padding-left: 2.2rem;
    }

    .privacy-check-row .form-check-label {
        font-size: var(--font-xs);
    }

    .privacy-check-row .form-check-input {
        width: 0.9rem;
        height: 0.9rem;
        min-width: 0.9rem;
        min-height: 0.9rem;
    }

    .error-container {
        font-size: var(--font-xs);
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
    }

    .success-toast {
        font-size: var(--font-xs);
        padding: 0.5rem 0.75rem;
        top: 8px;
        right: 8px;
    }

    .step-dot {
        width: 6px;
        height: 6px;
    }

    .step-dot.active {
        width: 18px;
    }

    .modal-body {
        padding: 0.75rem;
        font-size: var(--font-xs);
    }

    .modal-footer .btn {
        font-size: var(--font-xs);
        min-height: 34px;
    }

    .btn-resend-otp {
        font-size: var(--font-xs);
        padding: 0.3rem 0.6rem;
        min-height: 30px;
    }

    .device-blocked-overlay i {
        font-size: 3rem !important;
    }

    .device-blocked-overlay h4 {
        font-size: var(--font-base);
    }

    .device-blocked-overlay p {
        font-size: var(--font-xs);
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

    body {
        padding: 0.35rem;
    }

    .register-card {
        border-radius: 0.75rem;
    }

    .register-body {
        padding: var(--sp-sm) !important;
    }

    .register-header {
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    .register-header h3 {
        font-size: var(--font-md);
    }

    .register-header p {
        font-size: 0.6rem;
    }

    .form-control,
    .form-select {
        padding: 0.3rem 0.5rem;
        font-size: var(--font-xs);
        min-height: 30px;
        border-radius: 0.4rem;
    }

    .form-label {
        font-size: var(--font-xs);
        margin-bottom: 0.2rem;
    }

    .btn-primary-custom,
    .btn-next,
    .btn-register,
    .btn-back,
    .btn-otp-verify {
        font-size: var(--font-xs);
        padding: 0.3rem 0.6rem;
        min-height: 30px;
        border-radius: 0.4rem;
    }

    .input-icon i {
        font-size: var(--font-xs);
        left: 0.5rem;
    }

    .input-icon input,
    .input-icon select {
        padding-left: 2rem;
    }

    small,
    .text-muted,
    .requirement-check div,
    .password-match,
    .otp-timer {
        font-size: 0.55rem;
    }

    .privacy-check-row .form-check-label {
        font-size: 0.6rem;
    }

    .privacy-check-row .form-check-input {
        width: 0.8rem;
        height: 0.8rem;
        min-width: 0.8rem;
        min-height: 0.8rem;
    }

    .step-progress {
        gap: 0.35rem;
        margin-bottom: 1rem;
    }

    .step-dot {
        width: 5px;
        height: 5px;
    }

    .step-dot.active {
        width: 14px;
    }

    .error-container {
        font-size: 0.6rem;
        padding: 0.4rem 0.6rem;
        border-radius: 0.4rem;
    }

    .success-toast {
        font-size: 0.6rem;
        padding: 0.4rem 0.6rem;
        top: 6px;
        right: 6px;
    }

    .modal-content {
        border-radius: 0.75rem;
    }

    .modal-body {
        padding: 0.5rem;
        font-size: var(--font-xs);
    }

    .modal-footer .btn {
        font-size: var(--font-xs);
        min-height: 30px;
        padding: 0.3rem 0.6rem;
    }

    .btn-resend-otp {
        font-size: 0.55rem;
        padding: 0.25rem 0.5rem;
        min-height: 28px;
    }

    .device-blocked-overlay i {
        font-size: 2.5rem !important;
    }

    .device-blocked-overlay h4 {
        font-size: var(--font-sm);
    }

    .device-blocked-overlay p {
        font-size: var(--font-xs);
    }
}

/* --- Tablets (769px - 1024px) --- */
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
    }

    .register-card {
        max-width: 560px;
    }

    .register-body {
        padding: 1.75rem;
    }
}

/* --- Desktops (≥ 1025px) --- */
@media (min-width: 1025px) {
    :root {
        --font-xs: 0.75rem;
        --font-sm: 0.875rem;
        --font-base: 1rem;
        --font-md: 1.125rem;
        --font-lg: 1.25rem;
        --font-xl: 1.5rem;
        --font-xxl: 1.75rem;
        --font-xxxl: 2.25rem;
    }

    .register-card {
        max-width: 560px;
        margin: 0 auto;
    }

    .register-body {
        padding: 2rem;
    }

    .register-header h3 {
        font-size: var(--font-xxl);
    }
}

/* ---------- HIDDEN AUDIO (click only) ---------- */
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

<div class="container fade-page">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-xl-7">
            <div class="register-card position-relative">
                <!-- Overlay shown if device already registered -->
                <div class="device-blocked-overlay" id="deviceBlockedOverlay">
                    <i class="fas fa-ban"></i>
                    <h4>Device Already Registered</h4>
                    <p>This device is already linked to an existing account. Only one account per device is allowed.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary-custom">Login Instead</a>
                </div>

                <div class="register-header text-center p-4 pb-2">
                    <div class="mb-2"><i class="fas fa-truck-fast fa-2x" style="color: #1E3A8A;"></i></div>
                    <h3>Drive with <span style="background: linear-gradient(135deg,#1E3A8A,#3B82F6); background-clip:text; -webkit-background-clip:text; color:transparent;">SureCargo</span></h3>
                    <p>Seamless cargo & logistics registration</p>
                </div>
                <div class="register-body p-4 pt-2">
                    @if ($errors->any())
                        <div class="error-container" id="serverErrorBox">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fas fa-exclamation-triangle text-danger mt-1"></i>
                                <div>
                                    <strong class="d-block">Please fix the following:</strong>
                                    <ul class="mb-0 mt-1 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                </div>
                                <button type="button" class="btn-close ms-auto" style="font-size: 0.8rem;" onclick="this.closest('.error-container')?.remove()"></button>
                            </div>
                        </div>
                    @endif

                    <div class="step-progress">
                        <div class="step-dot" data-step="0"></div>
                        <div class="step-dot" data-step="1"></div>
                        <div class="step-dot" data-step="2"></div>
                    </div>

                    <form method="POST" action="{{ route('register.post') }}" id="registerForm">
                        @csrf
                        <!-- Hidden device_id field -->
                        <input type="hidden" name="device_id" value="{{ $deviceId ?? '' }}">

                        <div class="steps-wrapper">
                            <div class="steps-container" id="stepsContainer">
                                <!-- STEP 1: First & Last Name -->
                                <div class="step" data-step="0">
                                    <div class="mb-4">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <div class="input-icon"><i class="fas fa-user"></i><input type="text" name="first_name" id="first_name" class="form-control" required value="{{ old('first_name') }}" autocomplete="given-name" placeholder="John"></div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <div class="input-icon"><i class="fas fa-user"></i><input type="text" name="last_name" id="last_name" class="form-control" required value="{{ old('last_name') }}" autocomplete="family-name" placeholder="Doe"></div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn-next" id="nextStep1">Next <i class="fas fa-arrow-right ms-2"></i></button>
                                    </div>
                                </div>

                                <!-- STEP 2: City, User Type, Password -->
                                <div class="step" data-step="1">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                            <div class="input-icon"><i class="fas fa-city"></i>
                                                <select name="city" id="city" class="form-select" required>
                                                    <option value="">Select City</option>
                                                    <option value="bantayan" {{ old('city')=='bantayan' ? 'selected' : '' }}>Bantayan</option>
                                                    <option value="escalante" {{ old('city')=='escalante' ? 'selected' : '' }}>Escalante</option>
                                                    <option value="sagay" {{ old('city')=='sagay' ? 'selected' : '' }}>Sagay</option>
                                                    <option value="cadiz" {{ old('city')=='cadiz' ? 'selected' : '' }}>Cadiz</option>
                                                    <option value="victorias" {{ old('city')=='victorias' ? 'selected' : '' }}>Victorias</option>
                                                    <option value="silay" {{ old('city')=='silay' ? 'selected' : '' }}>Silay</option>
                                                    <option value="bata" {{ old('city')=='bata' ? 'selected' : '' }}>Bata</option>
                                                    <option value="bacolod" {{ old('city')=='bacolod' ? 'selected' : '' }}>Bacolod</option>
                                                    <option value="libertad" {{ old('city')=='libertad' ? 'selected' : '' }}>Libertad</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="user_type" class="form-label">Account Type <span class="text-danger">*</span></label>
                                            <div class="input-icon"><i class="fas fa-user-tag"></i><select name="user_type" id="user_type" class="form-select" required><option value="">Select Type</option><option value="poultry_owner" {{ old('user_type')=='poultry_owner' ? 'selected' : '' }}>Poultry Owner/shipper</option><option value="customer" {{ old('user_type')=='customer' ? 'selected' : '' }}>Customer / Shipper</option></select></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-icon"><i class="fas fa-lock"></i><input type="password" name="password" id="password" class="form-control" required autocomplete="new-password" placeholder="Create strong password"></div>
                                        <div class="password-strength"><div class="strength-bar"><div class="strength-bar-fill" id="strengthBar"></div></div><div id="strengthText" class="mt-1"></div></div>
                                        <div class="requirement-check mt-2 d-flex flex-wrap gap-3">
                                            <div id="lengthReq" class="requirement-unmet"><i class="fas fa-circle"></i> Min 8 chars</div>
                                            <div id="uppercaseReq" class="requirement-unmet"><i class="fas fa-circle"></i> Uppercase</div>
                                            <div id="lowercaseReq" class="requirement-unmet"><i class="fas fa-circle"></i> Lowercase</div>
                                            <div id="numberReq" class="requirement-unmet"><i class="fas fa-circle"></i> Number</div>
                                            <div id="specialReq" class="requirement-unmet"><i class="fas fa-circle"></i> Special (@$!%*?&)</div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <div class="input-icon"><i class="fas fa-lock"></i><input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required></div>
                                        <div id="passwordMatchMsg" class="mt-1"></div>
                                    </div>
                                    <div class="d-flex justify-content-between gap-2 flex-wrap">
                                        <button type="button" class="btn-back" id="backStep2"><i class="fas fa-arrow-left me-2"></i> Back</button>
                                        <button type="button" class="btn-next" id="nextStep2">Next <i class="fas fa-arrow-right ms-2"></i></button>
                                    </div>
                                </div>

                                <!-- STEP 3: Mobile Number + Privacy & Policy Checkbox + Register -->
                                <div class="step" data-step="2">
                                    <div class="mb-4">
                                        <label for="mobile_number" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                        <div class="input-icon"><i class="fas fa-phone-alt"></i><input type="tel" name="mobile_number" id="mobile_number" class="form-control" placeholder="09123456789" required value="{{ old('mobile_number') }}"></div>
                                        <small class="text-muted"><i class="fas fa-info-circle"></i> 11 digits starting with 09</small>
                                    </div>

                                    <!-- Privacy & Policy Checkbox with Clickable Links -->
                                    <div class="privacy-check-row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="privacyCheckbox" required>
                                            <label class="form-check-label" for="privacyCheckbox">
                                                I agree to the <a href="#" class="privacy-link" id="termsLink">Terms of Service</a> and
                                                <a href="#" class="privacy-link" id="privacyLink">Privacy Policy</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between gap-2 flex-wrap">
                                        <button type="button" class="btn-back" id="backStep3"><i class="fas fa-arrow-left me-2"></i> Back</button>
                                        <button type="submit" class="btn-register" id="submitBtn" disabled><i class="fas fa-check-circle me-2"></i> Register</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr class="my-4">
                    <p class="text-center mb-0">Already have an account? <a href="{{ route('login') }}" class="fw-semibold" style="color:#1E3A8A;">Login here</a></p>
                    <p class="text-center mt-3"><a href="{{ route('welcome') }}"><i class="fas fa-arrow-left me-1"></i> Back to Home</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- OTP MODAL -->
<div class="modal fade" id="otpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title"><i class="fas fa-key me-2" style="color:#1E3A8A;"></i>Verify Mobile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <p>We sent a 6-digit OTP to <strong id="otpMobileDisplay"></strong></p>
                <div class="input-icon mb-3">
                    <i class="fas fa-lock"></i>
                    <input type="text" id="modalOtpInput" class="form-control text-center" placeholder="000000" maxlength="6" autocomplete="off" autofocus style="letter-spacing: 4px; font-weight:600;">
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" id="resendOtpBtn" class="btn-resend-otp px-3 py-2" disabled><i class="fas fa-redo-alt me-1"></i> Resend</button>
                    <span id="otpTimer" class="small text-warning"></span>
                </div>
                <div id="modalOtpError" class="text-danger small mt-2"></div>
                <div id="modalOtpSuccess" class="text-success small"></div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="modalVerifyBtn" class="btn-otp-verify" disabled>Verify & Register</button>
            </div>
        </div>
    </div>
</div>

<!-- PRIVACY POLICY MODAL -->
<div class="modal fade" id="privacyPolicyModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="privacyPolicyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title" id="privacyPolicyModalLabel"><i class="fas fa-shield-alt me-2" style="color:#1E3A8A;"></i>Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                <h6>1. Information Collection</h6>
                <p>SureCargo Transport collects personal information such as full name, mobile number, city, and account type to facilitate cargo bookings, real-time tracking, and communication regarding shipments. We also collect device and usage data to improve our platform.</p>
                <h6>2. Use of Information</h6>
                <p>Your data is used to create your account, process cargo transport requests, provide real-time tracking updates, send OTP verification messages, and enhance customer support. We never sell your personal data to third parties.</p>
                <h6>3. Data Security</h6>
                <p>We implement industry-standard encryption (SSL/TLS), secure servers, and restricted access. Passwords are hashed and OTPs are time-sensitive. You are responsible for keeping your login credentials confidential.</p>
                <h6>4. Third-Party Services</h6>
                <p>We may share essential data with logistics partners or SMS gateways solely to fulfill deliveries and authentication. These parties are contractually bound to protect your data.</p>
                <h6>5. Cookies & Tracking</h6>
                <p>We use session cookies and analytics to improve performance. You may disable cookies but some features may be limited.</p>
                <h6>6. Your Rights</h6>
                <p>You can request access, correction, or deletion of your personal data by contacting support@surecargo.com. We will respond within 30 days.</p>
                <h6>7. Updates to Policy</h6>
                <p>This policy may be revised periodically. Continued use of SureCargo constitutes acceptance of any changes.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary-custom" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- TERMS OF SERVICE MODAL -->
<div class="modal fade" id="termsModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title" id="termsModalLabel"><i class="fas fa-file-contract me-2" style="color:#1E3A8A;"></i>Terms of Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                <h6>1. Acceptance of Terms</h6>
                <p>By registering for SureCargo Transport, you agree to abide by these Terms of Service and our Privacy Policy. If you do not agree, please do not use our platform.</p>
                <h6>2. User Responsibilities</h6>
                <p>You must provide accurate information, safeguard your account, and not misuse the cargo booking or tracking system. Any fraudulent activity will result in immediate termination.</p>
                <h6>3. Cargo Booking & Real-Time Tracking</h6>
                <p>SureCargo facilitates shipment bookings, real-time GPS tracking, and delivery notifications. While we strive for accuracy, we are not liable for delays caused by weather, traffic, or third-party carriers.</p>
                <h6>4. Payment & Fees</h6>
                <p>Applicable transport fees are displayed before booking. Payments are processed securely. Refunds are handled case-by-case in accordance with our cancellation policy.</p>
                <h6>5. Intellectual Property</h6>
                <p>All content, logos, and system design are property of SureCargo. Unauthorized reproduction or hacking attempts are prohibited.</p>
                <h6>6. Limitation of Liability</h6>
                <p>To the maximum extent permitted by law, SureCargo is not liable for indirect damages, loss of profits, or data breaches caused by user negligence. Total liability shall not exceed the fees paid in the last 3 months.</p>
                <h6>7. Termination</h6>
                <p>We reserve the right to suspend or terminate accounts violating these terms or applicable laws. You may delete your account at any time via support.</p>
                <h6>8. Governing Law</h6>
                <p>These terms are governed by the laws of the Philippines. Any disputes shall be resolved through binding arbitration in Cebu City.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary-custom" data-bs-dismiss="modal">Close</button>
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

            function playClick() {
                if (clickAudio) {
                    clickAudio.currentTime = 0;
                    clickAudio.play().catch(function() {});
                }
            }

            document.addEventListener('click', function(e) {
                var target = e.target.closest('a, button, .btn-next, .btn-back, .btn-register, .btn-otp-verify, .btn-resend-otp, .btn-primary-custom, .btn-outline-secondary, .btn-close, .privacy-link, .form-check-input, .form-check-label, [href], [role="button"]');
                if (target) {
                    if (target.closest('#clickAudio')) {
                        return;
                    }
                    playClick();
                }
            });

            window.__clickAudio = clickAudio;
        })();

        // --- Device registered check ---
        @if ($deviceRegistered ?? false)
            document.getElementById('deviceBlockedOverlay')?.classList.add('show');
            // Disable all form inputs
            const form = document.getElementById('registerForm');
            if (form) {
                const inputs = form.querySelectorAll('input, select, button, textarea');
                inputs.forEach(el => el.disabled = true);
            }
        @endif

        function addRipple(e, btn) {
            const rect = btn.getBoundingClientRect();
            const ripple = document.createElement('span');
            const size = Math.max(rect.width, rect.height);
            ripple.classList.add('ripple');
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
            btn.style.position = 'relative';
            btn.style.overflow = 'hidden';
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        }
        document.querySelectorAll('.btn-next, .btn-back, .btn-register, .btn-otp-verify, .btn-resend-otp').forEach(btn => {
            btn.addEventListener('click', (e) => addRipple(e, btn));
        });

        let currentStep = 0;
        const steps = document.querySelectorAll('.step');
        const stepsContainer = document.getElementById('stepsContainer');
        const stepDots = document.querySelectorAll('.step-dot');
        const totalSteps = steps.length;
        function updateSlider() { stepsContainer.style.transform = `translateX(-${currentStep * 100}%)`; stepDots.forEach((dot, idx) => { dot.classList.remove('active','completed'); if(idx<currentStep) dot.classList.add('completed'); else if(idx===currentStep) dot.classList.add('active'); }); }
        function goToStep(step) { if(step<0 || step>=totalSteps) return; currentStep=step; updateSlider(); if(currentStep===2) validateAllFields(); else if(currentStep===1) validateStep2(); else validateStep1(); }

        function validateStep1() { const next=document.getElementById('nextStep1'); if(next) next.disabled = !(document.getElementById('first_name').value.trim() && document.getElementById('last_name').value.trim()); }
        function validateStep2() { const city=document.getElementById('city').value, type=document.getElementById('user_type').value, pass=document.getElementById('password').value, confirm=document.getElementById('password_confirmation').value; const strong = pass.length>=8 && /[A-Z]/.test(pass) && /[a-z]/.test(pass) && /\d/.test(pass) && /[@$!%*?&]/.test(pass); const match = pass === confirm && confirm.length>0; const nextBtn = document.getElementById('nextStep2'); if(nextBtn) nextBtn.disabled = !(city && type && strong && match); }
        function validateAllFields() {
            const fname=document.getElementById('first_name').value.trim(), lname=document.getElementById('last_name').value.trim(), city=document.getElementById('city').value, type=document.getElementById('user_type').value, pass=document.getElementById('password').value, confirm=document.getElementById('password_confirmation').value, mobile=document.getElementById('mobile_number').value.trim();
            const mobileValid=/^09[0-9]{9}$/.test(mobile);
            const strong = pass.length>=8 && /[A-Z]/.test(pass) && /[a-z]/.test(pass) && /\d/.test(pass) && /[@$!%*?&]/.test(pass);
            const match=pass===confirm && confirm.length>0;
            const privacyChecked = document.getElementById('privacyCheckbox').checked;
            const submit=document.getElementById('submitBtn');
            if(submit) submit.disabled = !(fname && lname && city && type && strong && match && mobileValid && privacyChecked);
        }

        document.getElementById('nextStep1')?.addEventListener('click',()=>{ if(!document.getElementById('nextStep1').disabled) goToStep(1); });
        document.getElementById('nextStep2')?.addEventListener('click',()=>{ if(!document.getElementById('nextStep2').disabled) goToStep(2); });
        document.getElementById('backStep2')?.addEventListener('click',()=>goToStep(0));
        document.getElementById('backStep3')?.addEventListener('click',()=>goToStep(1));

        document.getElementById('first_name')?.addEventListener('input',()=>{ validateStep1(); if(currentStep===2) validateAllFields(); });
        document.getElementById('last_name')?.addEventListener('input',()=>{ validateStep1(); if(currentStep===2) validateAllFields(); });
        document.getElementById('city')?.addEventListener('change',()=>{ validateStep2(); if(currentStep===2) validateAllFields(); });
        document.getElementById('user_type')?.addEventListener('change',()=>{ validateStep2(); if(currentStep===2) validateAllFields(); });

        const privacyCheckbox = document.getElementById('privacyCheckbox');
        privacyCheckbox?.addEventListener('change', () => { if(currentStep===2) validateAllFields(); });

        const passwordField = document.getElementById('password'), confirmField = document.getElementById('password_confirmation');
        const strengthBar = document.getElementById('strengthBar'), strengthText = document.getElementById('strengthText');
        const lengthReq=document.getElementById('lengthReq'), uppercaseReq=document.getElementById('uppercaseReq'), lowercaseReq=document.getElementById('lowercaseReq'), numberReq=document.getElementById('numberReq'), specialReq=document.getElementById('specialReq');
        function updateRequirement(el,isMet,text){ el.innerHTML=`<i class="fas ${isMet ? 'fa-check-circle' : 'fa-circle'}"></i> ${text}`; el.classList.toggle('requirement-met',isMet); el.classList.toggle('requirement-unmet',!isMet); }
        function validatePassword(){ const val=passwordField.value; const len=val.length>=8, upper=/[A-Z]/.test(val), lower=/[a-z]/.test(val), num=/\d/.test(val), special=/[@$!%*?&]/.test(val); updateRequirement(lengthReq,len,'Minimum 8 characters'); updateRequirement(uppercaseReq,upper,'Uppercase'); updateRequirement(lowercaseReq,lower,'Lowercase'); updateRequirement(numberReq,num,'Number'); updateRequirement(specialReq,special,'Special (@$!%*?&)'); let strength=0; if(len)strength++;if(upper)strength++;if(lower)strength++;if(num)strength++;if(special)strength++; const percent=(strength/5)*100; strengthBar.style.width=percent+'%'; if(strength<=2){ strengthBar.style.backgroundColor='#EF4444'; strengthText.innerHTML='Weak password'; strengthText.style.color='#EF4444'; } else if(strength<=4){ strengthBar.style.backgroundColor='#F59E0B'; strengthText.innerHTML='Medium password'; strengthText.style.color='#F59E0B'; } else { strengthBar.style.backgroundColor='#10B981'; strengthText.innerHTML='Strong password!'; strengthText.style.color='#10B981'; } if(val.length>0 && strength===5){ passwordField.classList.add('valid-field'); passwordField.classList.remove('invalid-field');} else if(val.length>0){ passwordField.classList.add('invalid-field'); passwordField.classList.remove('valid-field');} else{ passwordField.classList.remove('valid-field','invalid-field');} checkPasswordMatch(); validateStep2(); if(currentStep===2) validateAllFields(); }
        function checkPasswordMatch(){ const pass=passwordField.value, conf=confirmField.value, matchMsg=document.getElementById('passwordMatchMsg'); if(conf.length>0){ if(pass===conf){ matchMsg.innerHTML='<i class="fas fa-check-circle text-success"></i> Passwords match'; confirmField.classList.add('valid-field'); confirmField.classList.remove('invalid-field'); } else { matchMsg.innerHTML='<i class="fas fa-times-circle text-danger"></i> Passwords do not match'; confirmField.classList.add('invalid-field'); confirmField.classList.remove('valid-field'); } } else { matchMsg.innerHTML=''; confirmField.classList.remove('valid-field','invalid-field'); } validateStep2(); if(currentStep===2) validateAllFields(); }
        passwordField.addEventListener('input',validatePassword); confirmField.addEventListener('input',checkPasswordMatch);
        const mobileInput = document.getElementById('mobile_number'); mobileInput.addEventListener('input',function(){ const regex=/^09[0-9]{9}$/; if(this.value.trim().length>0 && regex.test(this.value)){ this.classList.add('valid-field'); this.classList.remove('invalid-field'); } else if(this.value.trim().length>0){ this.classList.add('invalid-field'); this.classList.remove('valid-field'); } else { this.classList.remove('valid-field','invalid-field'); } if(currentStep===2) validateAllFields(); });

        // Privacy & Terms Modal triggers
        const termsLink = document.getElementById('termsLink');
        const privacyLink = document.getElementById('privacyLink');
        const termsModal = new bootstrap.Modal(document.getElementById('termsModal'));
        const privacyModal = new bootstrap.Modal(document.getElementById('privacyPolicyModal'));
        if(termsLink) termsLink.addEventListener('click', (e) => { e.preventDefault(); termsModal.show(); });
        if(privacyLink) privacyLink.addEventListener('click', (e) => { e.preventDefault(); privacyModal.show(); });

        const form = document.getElementById('registerForm');
        const otpModalEl = document.getElementById('otpModal');
        const otpModal = new bootstrap.Modal(otpModalEl);
        const modalOtpInput = document.getElementById('modalOtpInput'), modalVerifyBtn = document.getElementById('modalVerifyBtn'), modalOtpError = document.getElementById('modalOtpError'), modalOtpSuccess = document.getElementById('modalOtpSuccess');
        const otpMobileDisplay = document.getElementById('otpMobileDisplay'), resendOtpBtn = document.getElementById('resendOtpBtn'), otpTimerSpan = document.getElementById('otpTimer');
        let pendingMobile = '', timerInterval = null, timeLeft = 0;
        function startTimer(seconds=60){ if(timerInterval) clearInterval(timerInterval); timeLeft=seconds; updateTimerDisplay(); resendOtpBtn.disabled=true; timerInterval=setInterval(()=>{ if(timeLeft<=1){ clearInterval(timerInterval); resendOtpBtn.disabled=false; otpTimerSpan.innerHTML=''; } else { timeLeft--; updateTimerDisplay(); } },1000); }
        function updateTimerDisplay(){ if(timeLeft>0) otpTimerSpan.innerHTML=`<i class="fas fa-hourglass-half"></i> ${timeLeft}s`; else otpTimerSpan.innerHTML=''; }
        async function sendOtpRequest(mobile,isResend=false){ try{ const response=await fetch('{{ route("send.otp") }}',{ method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body:JSON.stringify({mobile_number:mobile}) }); const data=await response.json(); if(!response.ok) throw new Error(data.error||'Failed to send OTP'); modalOtpSuccess.innerText=isResend?'OTP resent successfully!':'OTP sent! Check your SMS.'; modalOtpError.innerText=''; startTimer(60); return true; } catch(err){ modalOtpError.innerText=err.message; return false; } }
        form.addEventListener('submit', async(e)=>{ e.preventDefault(); const mobile=mobileInput.value.trim(); if(!/^09[0-9]{9}$/.test(mobile)){ alert('Enter valid 11-digit mobile starting with 09'); return; } const pass=passwordField.value; const strong=pass.length>=8 && /[A-Z]/.test(pass) && /[a-z]/.test(pass) && /\d/.test(pass) && /[@$!%*?&]/.test(pass); if(!strong || pass!==confirmField.value){ alert('Ensure strong password and matching confirmation'); return; } if(document.getElementById('city').value==='' || document.getElementById('user_type').value===''){ alert('Select city and account type'); return; } if(document.getElementById('first_name').value.trim()===''||document.getElementById('last_name').value.trim()===''){ alert('Enter your full name'); return; } if(!privacyCheckbox.checked){ alert('You must agree to the Terms of Service and Privacy Policy to register.'); return; } pendingMobile=mobile; otpMobileDisplay.innerText=mobile; modalOtpInput.value=''; modalOtpError.innerText=''; modalOtpSuccess.innerText=''; modalVerifyBtn.disabled=true; modalVerifyBtn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Sending...'; resendOtpBtn.disabled=true; otpModal.show(); const success=await sendOtpRequest(mobile,false); if(success){ modalVerifyBtn.disabled=false; modalVerifyBtn.innerHTML='<i class="fas fa-check-circle"></i> Verify & Register'; modalOtpInput.focus(); } else { modalVerifyBtn.disabled=true; modalVerifyBtn.innerHTML='Retry'; } });
        resendOtpBtn.addEventListener('click',async()=>{ if(!pendingMobile) return; resendOtpBtn.disabled=true; resendOtpBtn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Sending...'; await sendOtpRequest(pendingMobile,true); resendOtpBtn.innerHTML='<i class="fas fa-redo-alt me-1"></i> Resend'; modalVerifyBtn.disabled=false; modalVerifyBtn.innerHTML='<i class="fas fa-check-circle"></i> Verify & Register'; });
        modalVerifyBtn.addEventListener('click', async()=>{ if(modalVerifyBtn.disabled) return; const otp=modalOtpInput.value.trim(); if(!otp || otp.length!==6){ modalOtpError.innerText='Enter 6-digit OTP'; modalOtpInput.classList.add('invalid-field'); setTimeout(()=>modalOtpInput.classList.remove('invalid-field'),500); return; } modalVerifyBtn.disabled=true; modalVerifyBtn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Verifying...'; try{ const res=await fetch('{{ route("verify.otp") }}',{ method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body:JSON.stringify({mobile_number:pendingMobile,otp:otp}) }); const data=await res.json(); if(!res.ok) throw new Error(data.error||'Invalid OTP'); const hiddenOtp=document.createElement('input'); hiddenOtp.type='hidden'; hiddenOtp.name='otp'; hiddenOtp.value=otp; form.appendChild(hiddenOtp); otpModal.hide(); if(timerInterval) clearInterval(timerInterval); form.submit(); } catch(err){ modalOtpError.innerText=err.message; modalVerifyBtn.disabled=false; modalVerifyBtn.innerHTML='<i class="fas fa-check-circle"></i> Verify & Register'; } });
        document.getElementById('otpModal').addEventListener('hidden.bs.modal',()=>{ if(timerInterval) clearInterval(timerInterval); });
        validateStep1(); validateStep2(); validatePassword(); updateSlider();
    })();
</script>
</body>
</html>
