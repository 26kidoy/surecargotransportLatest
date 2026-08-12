<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>SureCargo AI | Intelligent Logistics Assistant</title>
    <link rel="icon" type="image/jpeg" href="/assets/white.jpg" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style nonce="{{ $csp_nonce }}">
      /* ============================================================
   CHATBOT PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   ============================================================ */

:root {
    --primary-color: #2b6ef0;
    --primary-dark: #1d4ed8;
    --primary-light: #f0f7ff;
    --text-dark: #0a2540;
    --text-body: #0a2b42;
    --text-muted: #2c6280;
    --bg-light: #eef2fa;
    --white: #ffffff;
    --border-light: #cbdff2;
    --border-chat: #e0edfc;
    --success: #10b981;

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
    --sp-xxl: 3rem;
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
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-light);
    height: 100vh;
    overflow: hidden;
    font-size: var(--font-base);
    font-weight: 400;
    line-height: 1.6;
    color: var(--text-body);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ============================================================
   SCROLLBAR HIDING (DESKTOP)
   ============================================================ */
html,
body,
.app-wrapper,
.chat-messages,
.questions-sidebar {
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
}

html::-webkit-scrollbar,
body::-webkit-scrollbar,
.app-wrapper::-webkit-scrollbar,
.chat-messages::-webkit-scrollbar,
.questions-sidebar::-webkit-scrollbar {
    width: 0 !important;
    height: 0 !important;
    display: none !important;
}

/* ============================================================
   APP LAYOUT
   ============================================================ */
.app-wrapper {
    display: flex;
    height: 100vh;
    width: 100vw;
    overflow: hidden;
    max-width: 100vw;
    overflow-x: hidden;
}

/* ============================================================
   SIDEBAR
   ============================================================ */
.questions-sidebar {
    width: 360px;
    background: var(--white);
    border-right: 1px solid var(--border-light);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    flex-shrink: 0;
    transition: left 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    box-shadow: 2px 0 12px rgba(0, 0, 0, 0.02);
    -webkit-overflow-scrolling: touch;
    overscroll-behavior: contain;
    z-index: 1050 !important;
}

.sidebar-header {
    padding: var(--sp-xl) var(--sp-lg);
    border-bottom: 2px solid var(--primary-color);
    background: var(--white);
    position: relative;
}

.sidebar-header h3 {
    font-size: var(--font-xl);
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    letter-spacing: -0.02em;
}

.sidebar-header p {
    font-size: var(--font-base);
    color: var(--text-muted);
    margin-top: var(--sp-sm);
    font-weight: 400;
}

.sidebar-close-btn {
    display: none;
    position: absolute;
    top: var(--sp-lg);
    right: var(--sp-lg);
    background: var(--primary-light);
    border: none;
    font-size: var(--font-lg);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: var(--primary-color);
    cursor: pointer;
    transition: all 0.2s;
    justify-content: center;
    align-items: center;
    z-index: 10;
    touch-action: manipulation;
    min-height: 40px;
    min-width: 40px;
}

.sidebar-close-btn:hover {
    background: var(--primary-color);
    color: var(--white);
}

.questions-list {
    flex: 1;
    padding: var(--sp-lg) var(--sp-md);
    display: flex;
    flex-direction: column;
    gap: var(--sp-md);
}

.quick-question {
    background: var(--primary-light);
    border: 1px solid #cfe2ff;
    border-radius: 60px;
    padding: var(--sp-md) var(--sp-lg);
    font-size: var(--font-base);
    font-weight: 500;
    color: var(--text-dark);
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    min-height: 48px;
}

.quick-question i {
    width: 28px;
    font-size: var(--font-md);
    color: var(--primary-color);
    flex-shrink: 0;
}

.quick-question:hover {
    background: var(--primary-color);
    transform: translateX(6px);
    border-color: transparent;
    color: var(--white);
}

.quick-question:hover i {
    color: var(--white);
}

.quick-question:active {
    transform: scale(0.97);
}

.sidebar-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1040 !important;
    backdrop-filter: blur(2px);
}

.sidebar-backdrop.active {
    display: block;
}

/* ============================================================
   CHAT MAIN
   ============================================================ */
.chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: var(--white);
    overflow: hidden;
    box-shadow: -4px 0 20px rgba(0, 0, 0, 0.02);
    max-width: 100vw;
    overflow-x: hidden;
}

.chat-header {
    margin-top: var(--sp-md);
    padding: var(--sp-md) var(--sp-xl);
    background: var(--white);
    border-bottom: 2px solid var(--border-chat);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: var(--sp-md);
    flex-shrink: 0;
}

.logo-area {
    display: flex;
    align-items: center;
    gap: 16px;
}

.logo-area i {
    font-size: var(--font-xl);
    color: var(--primary-color);
}

.logo-area h1 {
    font-size: var(--font-xl);
    font-weight: 800;
    margin: 0;
    color: var(--text-dark);
    letter-spacing: -0.5px;
}

.home-btn {
    background: var(--primary-light);
    padding: var(--sp-sm) var(--sp-lg);
    border-radius: 50px;
    text-decoration: none;
    color: var(--primary-color);
    font-weight: 600;
    font-size: var(--font-base);
    transition: all 0.2s ease;
    border: 1px solid #cae0fc;
    display: inline-flex;
    align-items: center;
    gap: var(--sp-xs);
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    min-height: 40px;
}

.home-btn:hover {
    background: var(--primary-color);
    color: var(--white);
    border-color: var(--primary-color);
}

.home-btn:active {
    transform: scale(0.96);
}

/* ============================================================
   CHAT MESSAGES
   ============================================================ */
.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: var(--sp-xl);
    display: flex;
    flex-direction: column;
    gap: var(--sp-md);
    background: #fefefe;
    -webkit-overflow-scrolling: touch;
    overscroll-behavior: contain;
}

.message {
    display: flex;
    gap: var(--sp-md);
    animation: fadeSlide 0.25s ease;
}

@keyframes fadeSlide {
    from {
        opacity: 0;
        transform: translateY(12px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message.user {
    justify-content: flex-end;
}

.message.bot .avatar {
    background: linear-gradient(145deg, var(--primary-color), var(--primary-dark));
    width: 56px;
    height: 56px;
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-xl);
    flex-shrink: 0;
    box-shadow: 0 6px 12px rgba(43, 110, 240, 0.2);
}

.message.user .avatar {
    background: var(--success);
    width: 52px;
    height: 52px;
    border-radius: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-xl);
    order: 2;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

.bubble {
    max-width: 72%;
    padding: var(--sp-md) var(--sp-xl);
    border-radius: 2rem;
    font-size: var(--font-base);
    line-height: 1.6;
    font-weight: 400;
    word-break: break-word;
}

.message.bot .bubble {
    background: var(--primary-light);
    color: var(--text-body);
    border-bottom-left-radius: 0.5rem;
    border: 1px solid #e2efff;
}

.message.user .bubble {
    background: var(--primary-color);
    color: var(--white);
    border-bottom-right-radius: 0.5rem;
}

/* ============================================================
   TYPING INDICATOR
   ============================================================ */
.typing-indicator {
    display: flex;
    gap: 8px;
    padding: var(--sp-md) var(--sp-lg);
    background: var(--primary-light);
    border-radius: 3rem;
    width: fit-content;
    border: 1px solid #d4e6ff;
    align-items: center;
}

.typing-dot {
    width: 10px;
    height: 10px;
    background: var(--primary-color);
    border-radius: 50%;
    animation: pulseTyping 1.3s infinite;
}

.typing-dot:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes pulseTyping {
    0%, 100% {
        opacity: 0.3;
        transform: scale(0.8);
    }
    50% {
        opacity: 1;
        transform: scale(1.2);
    }
}

.typing-indicator span {
    font-size: var(--font-base);
    margin-left: var(--sp-xs);
    color: var(--primary-color);
    font-weight: 500;
}

/* ============================================================
   CHAT INPUT AREA
   ============================================================ */
.chat-input-area {
    padding: var(--sp-md) var(--sp-lg);
    background: var(--white);
    display: flex;
    gap: var(--sp-md);
    border-top: 1px solid var(--border-chat);
    margin-bottom: var(--sp-md);
    flex-shrink: 0;
}

.chat-input-area input {
    flex: 1;
    background: #f9fcff;
    border: 1.5px solid #cde2fe;
    border-radius: 70px;
    padding: var(--sp-md) var(--sp-lg);
    font-size: var(--font-base);
    color: var(--text-dark);
    outline: none;
    font-weight: 400;
    transition: all 0.2s ease;
    min-width: 0;
    touch-action: manipulation;
    min-height: 48px;
}

.chat-input-area input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(43, 110, 240, 0.2);
}

.chat-input-area input::placeholder {
    color: #8aa9cc;
    font-size: var(--font-base);
    font-weight: 400;
}

.chat-input-area button {
    background: linear-gradient(105deg, var(--primary-color), var(--primary-dark));
    border: none;
    border-radius: 70px;
    padding: 0 var(--sp-xl);
    height: 56px;
    font-weight: 600;
    font-size: var(--font-base);
    color: var(--white);
    display: inline-flex;
    align-items: center;
    gap: var(--sp-sm);
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    cursor: pointer;
    flex-shrink: 0;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    min-height: 48px;
    min-width: 48px;
}

.chat-input-area button:hover {
    transform: scale(1.02);
    background: var(--primary-dark);
}

.chat-input-area button:active {
    transform: scale(0.96);
}

.chat-input-area button .btn-spinner {
    border-color: rgba(255, 255, 255, 0.3);
    border-top-color: var(--white);
}

/* ============================================================
   SIDEBAR TOGGLE (FLOATING)
   ============================================================ */
.sidebar-toggle-btn {
    display: none;
    position: fixed;
    bottom: 30px;
    left: 20px;
    z-index: 1060 !important;
    background: var(--primary-color);
    border: none;
    border-radius: 60px;
    width: 56px;
    height: 56px;
    color: var(--white);
    font-size: var(--font-xl);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: all 0.2s;
    align-items: center;
    justify-content: center;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    min-width: 56px;
    min-height: 56px;
}

.sidebar-toggle-btn:active {
    transform: scale(0.92);
}

.sidebar-toggle-btn .btn-spinner {
    border-color: rgba(255, 255, 255, 0.3);
    border-top-color: var(--white);
}

/* ============================================================
   PRELOADER
   ============================================================ */
#preloader {
    position: fixed;
    inset: 0;
    z-index: 9999 !important;
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.6s ease, visibility 0.6s ease;
    opacity: 1;
    visibility: visible;
    pointer-events: all;
}

#preloader.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

.preloader-content {
    width: 100%;
    max-width: 800px;
    padding: var(--sp-xl);
    display: flex;
    flex-direction: column;
    gap: var(--sp-lg);
}

.preloader-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 var(--sp-sm);
}

.preloader-logo {
    display: flex;
    align-items: center;
    gap: var(--sp-md);
}

.preloader-logo .skeleton-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: #e8eff8;
}

.preloader-logo .skeleton-title {
    width: 180px;
    height: 32px;
    border-radius: 8px;
    background: #e8eff8;
}

.preloader-logo .skeleton-title.short {
    width: 100px;
}

.preloader-header .skeleton-btn {
    width: 120px;
    height: 38px;
    border-radius: 50px;
    background: #e8eff8;
}

.preloader-messages {
    display: flex;
    flex-direction: column;
    gap: var(--sp-md);
    padding: var(--sp-sm);
}

.preloader-msg {
    display: flex;
    gap: var(--sp-md);
    align-items: flex-start;
}

.preloader-msg.user {
    flex-direction: row-reverse;
}

.preloader-msg .skeleton-avatar {
    width: 56px;
    height: 56px;
    border-radius: 24px;
    background: #e8eff8;
    flex-shrink: 0;
}

.preloader-msg.user .skeleton-avatar {
    border-radius: 60px;
}

.preloader-msg .skeleton-bubble {
    background: #e8eff8;
    border-radius: 20px;
    padding: var(--sp-md) var(--sp-lg);
    display: flex;
    flex-direction: column;
    gap: var(--sp-sm);
    max-width: 70%;
    min-width: 120px;
}

.preloader-msg.user .skeleton-bubble {
    background: #dbe6f5;
}

.skeleton-line {
    height: 16px;
    border-radius: 6px;
    background: #d5e0ed;
    width: 100%;
}

.skeleton-line.short {
    width: 60%;
}

.skeleton-line.medium {
    width: 80%;
}

.skeleton-line.long {
    width: 95%;
}

.preloader-input {
    display: flex;
    gap: var(--sp-md);
    padding: var(--sp-sm);
}

.preloader-input .skeleton-field {
    flex: 1;
    height: 54px;
    border-radius: 70px;
    background: #e8eff8;
}

.preloader-input .skeleton-send {
    width: 120px;
    height: 54px;
    border-radius: 70px;
    background: #dbe6f5;
}

/* Shimmer animation */
.shimmer {
    background: linear-gradient(90deg, #e8eff8 25%, #f2f7fc 50%, #e8eff8 75%);
    background-size: 200% 100%;
    animation: shimmer 1.6s ease-in-out infinite;
}

.shimmer-dark {
    background: linear-gradient(90deg, #d5e0ed 25%, #e4ecf5 50%, #d5e0ed 75%);
    background-size: 200% 100%;
    animation: shimmer 1.6s ease-in-out infinite;
}

@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ============================================================
   IMAGE SKELETON
   ============================================================ */
.img-skeleton {
    position: relative;
    display: inline-block;
    overflow: hidden;
    background: #eef2fa;
    border-radius: 8px;
    min-width: 40px;
    min-height: 40px;
}

.img-skeleton img {
    opacity: 0;
    transition: opacity 0.4s ease;
    display: block;
    width: 100%;
    height: auto;
}

.img-skeleton img.loaded {
    opacity: 1;
}

.img-skeleton .skeleton-shimmer {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, #e8eff8 25%, #f2f7fc 50%, #e8eff8 75%);
    background-size: 200% 100%;
    animation: shimmer 1.6s ease-in-out infinite;
    border-radius: 8px;
    pointer-events: none;
}

.img-skeleton img.loaded + .skeleton-shimmer {
    opacity: 0;
    transition: opacity 0.3s;
}

/* ============================================================
   ICON SKELETON
   ============================================================ */
.icon-skeleton {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 1.2em;
    min-height: 1.2em;
    background: #eef2fa;
    border-radius: 4px;
    color: transparent !important;
    position: relative;
    overflow: hidden;
    vertical-align: middle;
}

.icon-skeleton .skeleton-shimmer {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, #e8eff8 25%, #f2f7fc 50%, #e8eff8 75%);
    background-size: 200% 100%;
    animation: shimmer 1.6s ease-in-out infinite;
    border-radius: 4px;
    pointer-events: none;
}

.icon-skeleton.loaded {
    background: transparent !important;
    color: inherit !important;
}

.icon-skeleton.loaded .skeleton-shimmer {
    opacity: 0;
    transition: opacity 0.3s;
}

/* ============================================================
   BUTTON LOADING STATE
   ============================================================ */
.btn-loading {
    position: relative;
    pointer-events: none !important;
    cursor: default !important;
    opacity: 0.8;
}

.btn-loading .btn-spinner {
    display: inline-block !important;
    margin-right: 0.6rem;
    width: 1.1em;
    height: 1.1em;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
    vertical-align: middle;
}

.btn-loading .btn-text {
    vertical-align: middle;
}

.btn-loading .btn-original {
    display: none !important;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ============================================================
   RESPONSIVE - DEEPSEEK STYLE
   ============================================================ */

/* --- Tablets (769px - 860px) --- */
@media (max-width: 860px) {
    .questions-sidebar {
        position: fixed;
        left: -320px;
        top: 0;
        height: 100vh;
        z-index: 1050;
        width: 300px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .questions-sidebar.open {
        left: 0;
    }

    .sidebar-toggle-btn {
        display: flex;
    }

    .sidebar-close-btn {
        display: flex;
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

        --sp-xs: 0.2rem;
        --sp-sm: 0.4rem;
        --sp-md: 0.8rem;
        --sp-lg: 1.2rem;
        --sp-xl: 1.5rem;
    }

    .chat-header {
        padding: var(--sp-md) var(--sp-lg);
    }

    .logo-area h1 {
        font-size: var(--font-lg);
    }

    .home-btn {
        font-size: var(--font-sm);
        padding: var(--sp-xs) var(--sp-md);
        min-height: 36px;
    }

    .sidebar-header {
        padding: var(--sp-lg);
    }

    .sidebar-header h3 {
        font-size: var(--font-lg);
    }

    .sidebar-header p {
        font-size: var(--font-sm);
    }

    .questions-list {
        padding: var(--sp-md);
        gap: var(--sp-sm);
    }

    .quick-question {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        min-height: 40px;
        border-radius: 40px;
    }

    .quick-question i {
        font-size: var(--font-base);
        width: 24px;
    }

    .chat-messages {
        padding: var(--sp-md);
        gap: var(--sp-md);
    }

    .bubble {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        max-width: 80%;
        border-radius: 1.5rem;
    }

    .message .avatar {
        width: 44px;
        height: 44px;
        font-size: var(--font-md);
    }

    .message.user .avatar {
        width: 42px;
        height: 42px;
    }

    .chat-input-area {
        padding: var(--sp-sm) var(--sp-md);
        gap: var(--sp-sm);
    }

    .chat-input-area input {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
        min-height: 40px;
    }

    .chat-input-area input::placeholder {
        font-size: var(--font-sm);
    }

    .chat-input-area button {
        font-size: var(--font-sm);
        padding: 0 var(--sp-lg);
        height: 48px;
        min-height: 40px;
    }

    .typing-indicator {
        padding: var(--sp-sm) var(--sp-md);
    }

    .typing-indicator span {
        font-size: var(--font-sm);
    }

    .typing-dot {
        width: 8px;
        height: 8px;
    }

    .preloader-content {
        padding: var(--sp-lg);
    }

    .preloader-msg .skeleton-avatar {
        width: 44px;
        height: 44px;
    }

    .preloader-msg .skeleton-bubble {
        max-width: 75%;
        padding: var(--sp-sm) var(--sp-md);
    }

    .skeleton-line {
        height: 14px;
    }

    .preloader-logo .skeleton-title {
        width: 140px;
        height: 28px;
    }

    .preloader-input .skeleton-field {
        height: 48px;
    }

    .preloader-input .skeleton-send {
        height: 48px;
        width: 100px;
    }

    .sidebar-toggle-btn {
        width: 50px;
        height: 50px;
        min-width: 50px;
        min-height: 50px;
        font-size: var(--font-lg);
    }
}

/* --- Small Phones (≤ 600px) --- */
@media (max-width: 600px) {
    :root {
        --font-xs: 0.65rem;
        --font-sm: 0.75rem;
        --font-base: 0.85rem;
        --font-md: 0.95rem;
        --font-lg: 1.05rem;
        --font-xl: 1.15rem;

        --sp-xs: 0.15rem;
        --sp-sm: 0.3rem;
        --sp-md: 0.6rem;
        --sp-lg: 1rem;
        --sp-xl: 1.2rem;
    }

    .questions-sidebar {
        width: 280px;
        left: -300px;
    }

    .questions-sidebar.open {
        left: 0;
    }

    .logo-area i {
        font-size: var(--font-lg);
    }

    .logo-area h1 {
        font-size: var(--font-md);
    }

    .home-btn {
        font-size: var(--font-xs);
        padding: 0.15rem var(--sp-sm);
        min-height: 32px;
    }

    .sidebar-header h3 {
        font-size: var(--font-md);
    }

    .sidebar-header p {
        font-size: var(--font-xs);
    }

    .quick-question {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        gap: 8px;
        border-radius: 30px;
    }

    .quick-question i {
        font-size: var(--font-sm);
        width: 20px;
    }

    .bubble {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        max-width: 85%;
        border-radius: 1.2rem;
    }

    .message .avatar {
        width: 38px;
        height: 38px;
        font-size: var(--font-sm);
        border-radius: 16px;
    }

    .message.user .avatar {
        width: 36px;
        height: 36px;
        border-radius: 36px;
    }

    .chat-input-area {
        padding: var(--sp-xs) var(--sp-sm);
        gap: var(--sp-xs);
    }

    .chat-input-area input {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 36px;
        border-radius: 40px;
    }

    .chat-input-area input::placeholder {
        font-size: var(--font-xs);
    }

    .chat-input-area button {
        font-size: var(--font-xs);
        padding: 0 var(--sp-md);
        height: 42px;
        min-height: 36px;
        border-radius: 40px;
    }

    .chat-messages {
        padding: var(--sp-sm);
        gap: var(--sp-sm);
    }

    .typing-indicator {
        padding: var(--sp-xs) var(--sp-sm);
    }

    .typing-indicator span {
        font-size: var(--font-xs);
    }

    .typing-dot {
        width: 6px;
        height: 6px;
    }

    .sidebar-toggle-btn {
        width: 44px;
        height: 44px;
        min-width: 44px;
        min-height: 44px;
        bottom: 20px;
        left: 14px;
        font-size: var(--font-base);
    }

    .sidebar-close-btn {
        top: var(--sp-sm);
        right: var(--sp-sm);
        width: 32px;
        height: 32px;
        min-width: 32px;
        min-height: 32px;
        font-size: var(--font-md);
    }

    .preloader-content {
        padding: var(--sp-md);
    }

    .preloader-msg .skeleton-avatar {
        width: 36px;
        height: 36px;
        border-radius: 14px;
    }

    .preloader-msg.user .skeleton-avatar {
        border-radius: 36px;
    }

    .preloader-msg .skeleton-bubble {
        max-width: 78%;
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 14px;
    }

    .skeleton-line {
        height: 12px;
    }

    .preloader-logo .skeleton-title {
        width: 110px;
        height: 24px;
    }

    .preloader-logo .skeleton-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
    }

    .preloader-header .skeleton-btn {
        width: 80px;
        height: 30px;
        border-radius: 40px;
    }

    .preloader-input .skeleton-field {
        height: 42px;
        border-radius: 50px;
    }

    .preloader-input .skeleton-send {
        height: 42px;
        width: 80px;
        border-radius: 50px;
    }

    .preloader-messages {
        gap: var(--sp-sm);
    }
}

/* --- Very Small Phones (≤ 500px) --- */
@media (max-width: 500px) {
    :root {
        --font-xs: 0.6rem;
        --font-sm: 0.7rem;
        --font-base: 0.8rem;
        --font-md: 0.9rem;
        --font-lg: 1rem;
        --font-xl: 1.1rem;

        --sp-xs: 0.1rem;
        --sp-sm: 0.25rem;
        --sp-md: 0.5rem;
        --sp-lg: 0.8rem;
        --sp-xl: 1rem;
    }

    .questions-sidebar {
        width: 260px;
        left: -280px;
    }

    .questions-sidebar.open {
        left: 0;
    }

    .chat-header {
        padding: var(--sp-xs) var(--sp-sm);
        gap: var(--sp-xs);
    }

    .logo-area {
        gap: 8px;
    }

    .logo-area i {
        font-size: var(--font-base);
    }

    .logo-area h1 {
        font-size: var(--font-sm);
    }

    .home-btn {
        font-size: 0.55rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 28px;
    }

    .bubble {
        font-size: 0.65rem;
        padding: var(--sp-xs) var(--sp-sm);
        max-width: 90%;
        border-radius: 1rem;
    }

    .message .avatar {
        width: 32px;
        height: 32px;
        font-size: var(--font-xs);
        border-radius: 12px;
    }

    .message.user .avatar {
        width: 30px;
        height: 30px;
        border-radius: 30px;
    }

    .chat-input-area input {
        font-size: 0.6rem;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .chat-input-area input::placeholder {
        font-size: 0.6rem;
    }

    .chat-input-area button {
        font-size: 0.6rem;
        padding: 0 var(--sp-sm);
        height: 36px;
        min-height: 32px;
    }

    .sidebar-toggle-btn {
        width: 40px;
        height: 40px;
        min-width: 40px;
        min-height: 40px;
        bottom: 16px;
        left: 12px;
        font-size: var(--font-sm);
    }

    .sidebar-header {
        padding: var(--sp-sm) var(--sp-md);
    }

    .sidebar-header h3 {
        font-size: var(--font-sm);
    }

    .sidebar-header p {
        font-size: 0.6rem;
        margin-top: var(--sp-xs);
    }

    .quick-question {
        font-size: 0.55rem;
        padding: 0.15rem var(--sp-xs);
        min-height: 28px;
        gap: 6px;
        border-radius: 24px;
    }

    .quick-question i {
        font-size: 0.6rem;
        width: 16px;
    }

    .questions-list {
        padding: var(--sp-xs);
        gap: var(--sp-xs);
    }

    .sidebar-close-btn {
        top: var(--sp-xs);
        right: var(--sp-xs);
        width: 28px;
        height: 28px;
        min-width: 28px;
        min-height: 28px;
        font-size: var(--font-sm);
    }

    .preloader-content {
        padding: var(--sp-sm);
    }

    .preloader-msg .skeleton-avatar {
        width: 30px;
        height: 30px;
        border-radius: 10px;
    }

    .preloader-msg.user .skeleton-avatar {
        border-radius: 30px;
    }

    .preloader-msg .skeleton-bubble {
        max-width: 80%;
        padding: var(--sp-xs) var(--sp-sm);
        border-radius: 10px;
    }

    .skeleton-line {
        height: 10px;
        border-radius: 4px;
    }

    .preloader-logo .skeleton-title {
        width: 90px;
        height: 20px;
    }

    .preloader-logo .skeleton-icon {
        width: 28px;
        height: 28px;
        border-radius: 6px;
    }

    .preloader-header .skeleton-btn {
        width: 70px;
        height: 26px;
        border-radius: 40px;
    }

    .preloader-input .skeleton-field {
        height: 36px;
        border-radius: 40px;
    }

    .preloader-input .skeleton-send {
        height: 36px;
        width: 70px;
        border-radius: 40px;
    }

    .preloader-messages {
        gap: var(--sp-xs);
    }
}

/* --- Extra Small (≤ 400px) --- */
@media (max-width: 400px) {
    :root {
        --font-xs: 0.55rem;
        --font-sm: 0.65rem;
        --font-base: 0.75rem;
        --font-md: 0.85rem;
        --font-lg: 0.95rem;
        --font-xl: 1.05rem;

        --sp-xs: 0.08rem;
        --sp-sm: 0.2rem;
        --sp-md: 0.4rem;
        --sp-lg: 0.6rem;
        --sp-xl: 0.8rem;
    }

    body {
        font-size: var(--font-xs);
    }

    .questions-sidebar {
        width: 85%;
        left: -85%;
    }

    .questions-sidebar.open {
        left: 0;
    }

    .bubble {
        font-size: 0.55rem;
        padding: 0.15rem var(--sp-xs);
        max-width: 92%;
        border-radius: 0.75rem;
    }

    .message .avatar {
        width: 28px;
        height: 28px;
        font-size: 0.6rem;
        border-radius: 10px;
    }

    .message.user .avatar {
        width: 26px;
        height: 26px;
        border-radius: 26px;
    }

    .chat-input-area input {
        font-size: 0.5rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 28px;
        border-radius: 30px;
    }

    .chat-input-area input::placeholder {
        font-size: 0.5rem;
    }

    .chat-input-area button {
        font-size: 0.5rem;
        padding: 0 var(--sp-xs);
        height: 30px;
        min-height: 28px;
        border-radius: 30px;
    }

    .sidebar-toggle-btn {
        width: 36px;
        height: 36px;
        min-width: 36px;
        min-height: 36px;
        bottom: 12px;
        left: 10px;
        font-size: 0.7rem;
    }

    .sidebar-header h3 {
        font-size: 0.7rem;
    }

    .sidebar-header p {
        font-size: 0.5rem;
    }

    .quick-question {
        font-size: 0.5rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 24px;
        gap: 4px;
        border-radius: 20px;
    }

    .quick-question i {
        font-size: 0.5rem;
        width: 14px;
    }

    .logo-area i {
        font-size: 0.7rem;
    }

    .logo-area h1 {
        font-size: 0.65rem;
    }

    .home-btn {
        font-size: 0.45rem;
        padding: 0.05rem var(--sp-xs);
        min-height: 24px;
    }

    .sidebar-close-btn {
        width: 24px;
        height: 24px;
        min-width: 24px;
        min-height: 24px;
        font-size: 0.6rem;
    }

    .typing-indicator {
        padding: 0.15rem var(--sp-xs);
    }

    .typing-indicator span {
        font-size: 0.5rem;
    }

    .typing-dot {
        width: 5px;
        height: 5px;
    }

    .preloader-content {
        padding: var(--sp-xs);
    }

    .preloader-msg .skeleton-avatar {
        width: 24px;
        height: 24px;
        border-radius: 8px;
    }

    .preloader-msg.user .skeleton-avatar {
        border-radius: 24px;
    }

    .preloader-msg .skeleton-bubble {
        padding: var(--sp-xs);
        border-radius: 8px;
        min-width: 80px;
    }

    .skeleton-line {
        height: 8px;
        border-radius: 3px;
    }

    .preloader-logo .skeleton-title {
        width: 70px;
        height: 16px;
    }

    .preloader-logo .skeleton-icon {
        width: 22px;
        height: 22px;
        border-radius: 5px;
    }

    .preloader-header .skeleton-btn {
        width: 60px;
        height: 22px;
        border-radius: 30px;
    }

    .preloader-input .skeleton-field {
        height: 30px;
        border-radius: 30px;
    }

    .preloader-input .skeleton-send {
        height: 30px;
        width: 60px;
        border-radius: 30px;
    }
}

/* ============================================================
   UTILITY CLASSES
   ============================================================ */
.no-fouc {
    opacity: 0;
    transition: opacity 0.01s;
}

.no-fouc.ready {
    opacity: 1;
}

/* Touch scrolling smooth */
.chat-messages,
.questions-sidebar {
    -webkit-overflow-scrolling: touch;
    overscroll-behavior: contain;
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

    <!-- ===== PRELOADER ===== -->
    <div id="preloader" role="status" aria-label="Loading">
        <div class="preloader-content">
            <div class="preloader-header">
                <div class="preloader-logo">
                    <div class="skeleton-icon shimmer"></div>
                    <div class="skeleton-title shimmer"></div>
                </div>
                <div class="skeleton-btn shimmer"></div>
            </div>
            <div class="preloader-messages">
                <div class="preloader-msg bot">
                    <div class="skeleton-avatar shimmer"></div>
                    <div class="skeleton-bubble shimmer">
                        <div class="skeleton-line long shimmer-dark"></div>
                        <div class="skeleton-line medium shimmer-dark"></div>
                        <div class="skeleton-line short shimmer-dark"></div>
                    </div>
                </div>
                <div class="preloader-msg user">
                    <div class="skeleton-avatar shimmer"></div>
                    <div class="skeleton-bubble shimmer">
                        <div class="skeleton-line medium shimmer-dark"></div>
                        <div class="skeleton-line short shimmer-dark"></div>
                    </div>
                </div>
                <div class="preloader-msg bot">
                    <div class="skeleton-avatar shimmer"></div>
                    <div class="skeleton-bubble shimmer">
                        <div class="skeleton-line long shimmer-dark"></div>
                        <div class="skeleton-line short shimmer-dark"></div>
                    </div>
                </div>
            </div>
            <div class="preloader-input">
                <div class="skeleton-field shimmer"></div>
                <div class="skeleton-send shimmer"></div>
            </div>
        </div>
    </div>

    <!-- ===== HIDDEN AUDIO ELEMENTS ===== -->
    <audio id="bgAudio" src="{{ asset('audio/truckengine.mp3') }}" loop preload="auto"></audio>
    <audio id="clickAudio" src="{{ asset('audio/click.mp3') }}" preload="auto"></audio>

    <!-- ===== APP ===== -->
    <div class="app-wrapper no-fouc" id="appWrapper">

        <!-- SIDEBAR -->
        <div class="questions-sidebar" id="questionsSidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-comment-question me-2"></i> Quick Questions</h3>
                <p>Click any — instant answer</p>
                <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Close sidebar"><i class="fas fa-times"></i></button>
            </div>
            <div class="questions-list" id="questionsList">
                <!-- populated by JS -->
            </div>
        </div>

        <!-- CHAT MAIN -->
        <div class="chat-main">
            <div class="chat-header">
                <div class="logo-area">
                    <i class="fas fa-cube"></i>
                    <h1>SureCargo AI</h1>
                </div>
                <a href="{{ url('/') }}" class="home-btn" id="homeBtn"><i class="fas fa-arrow-left me-2"></i> Home</a>
            </div>

            <div class="chat-messages" id="chatMessages">
                <div class="message bot">
                    <div class="avatar"><i class="fas fa-robot"></i></div>
                    <div class="bubble">
                        <strong>⚡ SureCargo Intelligent Assistant</strong><br />
                        I'm here to help with egg tray bookings, real-time tracking (Reverb), GCash/COD payments, registration, and more.<br />
                        Ask me anything or click a question from the sidebar!
                    </div>
                </div>
            </div>

            <div class="chat-input-area">
                <input type="text" id="userInput" placeholder="Ask me about booking, tracking, payments, registration..." autocomplete="off" />
                <button id="sendBtn"><i class="fas fa-paper-plane"></i> Send</button>
            </div>
        </div>
    </div>

    <!-- SIDEBAR TOGGLE (FLOATING) -->
    <button class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- ===== SCRIPTS ===== -->
    <script nonce="{{ $csp_nonce }}">
        (function() {
            'use strict';

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
                    var target = e.target.closest('a, button, .btn-primary-custom, .btn-outline-light-custom, .btn-outline-secondary, .menu-icon, .nav-links a, .home-btn, .sidebar-toggle-btn, .sidebar-close-btn, .quick-question, .tech-badge, .card-flat');
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
            // 1.  PRELOADER – robust asset detection
            // ============================================================
            const preloader = document.getElementById('preloader');
            let preloaderHidden = false;

            function hidePreloader() {
                if (preloaderHidden) return;
                preloaderHidden = true;
                requestAnimationFrame(() => {
                    preloader.classList.add('hidden');
                    document.getElementById('appWrapper').classList.add('ready');
                });
            }

            // Count assets that need to load
            let loadedCount = 0;
            const totalAssets = 3; // fonts, FA, BS

            function assetLoaded() {
                loadedCount++;
                if (loadedCount >= totalAssets) {
                    hidePreloader();
                }
            }

            // Helper to attach load/error events to a link element
            function trackLink(link, name) {
                if (!link) {
                    assetLoaded();
                    return;
                }

                let loaded = false;
                function onLoad() {
                    if (loaded) return;
                    loaded = true;
                    assetLoaded();
                }

                // Listen for load/error events
                link.addEventListener('load', onLoad);
                link.addEventListener('error', onLoad);

                // If the stylesheet is already available, assume it's loaded
                if (link.sheet) {
                    // Short delay to avoid double‑counting if the load event fires soon
                    setTimeout(onLoad, 100);
                }

                // Safety fallback: mark as loaded after 3 seconds
                setTimeout(onLoad, 3000);
            }

            // Font Awesome
            const faLink = document.querySelector('link[href*="font-awesome"]');
            trackLink(faLink, 'fontawesome');

            // Bootstrap CSS (also loads Bootstrap Icons via the same link)
            const bsLink = document.querySelector('link[href*="bootstrap.min.css"]');
            trackLink(bsLink, 'bootstrap');

            // Web fonts
            if (document.fonts) {
                document.fonts.ready.then(assetLoaded).catch(assetLoaded);
                // Fallback: if fonts don't load within 4s, proceed
                setTimeout(assetLoaded, 4000);
            } else {
                assetLoaded();
            }

            // Overall safety: hide preloader after 5s max
            setTimeout(hidePreloader, 5000);

            // Also on window load (for any remaining images)
            if (document.readyState === 'complete') {
                setTimeout(hidePreloader, 300);
            } else {
                window.addEventListener('load', function() {
                    setTimeout(hidePreloader, 300);
                });
            }

            // ============================================================
            // 2.  IMAGE SKELETON LOADING (MutationObserver)
            // ============================================================
            function wrapImageWithSkeleton(img) {
                if (img.dataset.skeletonWrapped) return;
                img.dataset.skeletonWrapped = '1';

                const parent = img.parentNode;
                if (!parent) return;
                if (parent.classList.contains('img-skeleton')) return;

                const wrapper = document.createElement('span');
                wrapper.className = 'img-skeleton';
                const shimmer = document.createElement('span');
                shimmer.className = 'skeleton-shimmer';

                parent.insertBefore(wrapper, img);
                wrapper.appendChild(img);
                wrapper.appendChild(shimmer);

                if (img.complete) {
                    img.classList.add('loaded');
                } else {
                    img.addEventListener('load', function() {
                        this.classList.add('loaded');
                    });
                    img.addEventListener('error', function() {
                        this.classList.add('loaded');
                    });
                }
            }

            function observeImages() {
                document.querySelectorAll('img:not([data-skeleton-wrapped])').forEach(wrapImageWithSkeleton);
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mut) {
                        if (mut.type === 'childList') {
                            mut.addedNodes.forEach(function(node) {
                                if (node.nodeType === 1) {
                                    if (node.tagName === 'IMG') {
                                        wrapImageWithSkeleton(node);
                                    } else {
                                        node.querySelectorAll('img:not([data-skeleton-wrapped])')
                                            .forEach(wrapImageWithSkeleton);
                                    }
                                }
                            });
                        }
                    });
                });
                observer.observe(document.body, { childList: true, subtree: true });
                return observer;
            }
            observeImages();

            // ============================================================
            // 3.  ICON SKELETON LOADING
            // ============================================================
            function wrapIconWithSkeleton(el) {
                if (el.dataset.iconSkeletonWrapped) return;
                el.dataset.iconSkeletonWrapped = '1';

                const hasIcon = el.classList.contains('fa') ||
                    el.classList.contains('fas') ||
                    el.classList.contains('far') ||
                    el.classList.contains('fal') ||
                    el.classList.contains('fab') ||
                    el.classList.contains('bi') ||
                    el.classList.contains('fa-solid') ||
                    el.classList.contains('fa-regular') ||
                    el.classList.contains('fa-brands') ||
                    el.tagName === 'svg';

                if (!hasIcon) return;

                el.classList.add('icon-skeleton');
                const shimmer = document.createElement('span');
                shimmer.className = 'skeleton-shimmer';
                el.appendChild(shimmer);

                const checkIcon = function() {
                    const hasContent = el.textContent.trim().length > 0 ||
                        el.querySelector('svg') !== null ||
                        el.querySelector('path') !== null ||
                        el.querySelector('use') !== null;
                    const computed = getComputedStyle(el);
                    const fontFamily = computed.fontFamily || '';
                    const isIconFont = fontFamily.includes('Font Awesome') ||
                        fontFamily.includes('bootstrap-icons') ||
                        fontFamily.includes('FontAwesome');

                    if (hasContent || isIconFont) {
                        el.classList.add('loaded');
                        return true;
                    }
                    return false;
                };

                if (!checkIcon()) {
                    let attempts = 0;
                    const maxAttempts = 8;
                    const interval = setInterval(function() {
                        attempts++;
                        if (checkIcon() || attempts >= maxAttempts) {
                            clearInterval(interval);
                            if (attempts >= maxAttempts) {
                                el.classList.add('loaded');
                            }
                        }
                    }, 300);
                }
            }

            function observeIcons() {
                document.querySelectorAll('i, svg, .bi, .fa, .fas, .far, .fal, .fab, .fa-solid, .fa-regular, .fa-brands')
                    .forEach(wrapIconWithSkeleton);

                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mut) {
                        if (mut.type === 'childList') {
                            mut.addedNodes.forEach(function(node) {
                                if (node.nodeType === 1) {
                                    if (node.matches && node.matches(
                                            'i, svg, .bi, .fa, .fas, .far, .fal, .fab, .fa-solid, .fa-regular, .fa-brands'
                                            )) {
                                        wrapIconWithSkeleton(node);
                                    } else {
                                        node.querySelectorAll(
                                            'i, svg, .bi, .fa, .fas, .far, .fal, .fab, .fa-solid, .fa-regular, .fa-brands'
                                        ).forEach(wrapIconWithSkeleton);
                                    }
                                }
                            });
                        }
                    });
                });
                observer.observe(document.body, { childList: true, subtree: true });
                return observer;
            }
            observeIcons();

            // ============================================================
            // 4.  BUTTON LOADING STATES
            // ============================================================
            const loadingButtons = new Set();

            function setButtonLoading(btn, loading) {
                if (!btn) return;
                if (loading) {
                    if (loadingButtons.has(btn)) return;
                    loadingButtons.add(btn);

                    const originalHtml = btn.innerHTML;
                    btn.dataset.originalHtml = originalHtml;
                    btn.classList.add('btn-loading');
                    btn.innerHTML =
                        '<span class="btn-spinner" aria-hidden="true"></span><span class="btn-text">Please wait...</span>';
                    btn.disabled = true;
                } else {
                    if (!loadingButtons.has(btn)) return;
                    loadingButtons.delete(btn);
                    btn.classList.remove('btn-loading');
                    if (btn.dataset.originalHtml) {
                        btn.innerHTML = btn.dataset.originalHtml;
                        delete btn.dataset.originalHtml;
                    }
                    btn.disabled = false;
                }
            }

            function handleClickableClick(e) {
                const target = e.currentTarget;
                if (loadingButtons.has(target)) return;
                if (target.disabled) return;
                if (target.dataset.noLoading === 'true') return;

                const isNavLink = target.tagName === 'A' && target.getAttribute('href') &&
                    !target.getAttribute('href').startsWith('#') &&
                    !target.getAttribute('href').startsWith('javascript:');

                setButtonLoading(target, true);

                if (isNavLink) {
                    const timeout = setTimeout(function() {
                        setButtonLoading(target, false);
                    }, 3000);

                    window.addEventListener('beforeunload', function() {
                        clearTimeout(timeout);
                        setButtonLoading(target, false);
                    }, { once: true });

                    setTimeout(function() {
                        if (loadingButtons.has(target)) {
                            setButtonLoading(target, false);
                        }
                    }, 4000);
                } else {
                    setTimeout(function() {
                        setButtonLoading(target, false);
                    }, 2000);
                }
            }

            function attachLoadingListeners() {
                const selectors = [
                    'button:not([data-no-loading="true"])',
                    'a:not([data-no-loading="true"])',
                    '[role="button"]:not([data-no-loading="true"])',
                    '.btn:not([data-no-loading="true"])',
                    '.card:not([data-no-loading="true"])',
                    '.quick-question',
                    '.sidebar-toggle-btn',
                    '.sidebar-close-btn',
                    '.home-btn',
                    '#sendBtn'
                ];

                document.querySelectorAll(selectors.join(',')).forEach(function(el) {
                    if (el.dataset.loadingHandlerAttached) return;
                    el.dataset.loadingHandlerAttached = 'true';
                    el.addEventListener('click', handleClickableClick);
                });

                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mut) {
                        if (mut.type === 'childList') {
                            mut.addedNodes.forEach(function(node) {
                                if (node.nodeType === 1) {
                                    if (node.matches && node.matches(selectors.join(','))) {
                                        if (!node.dataset.loadingHandlerAttached) {
                                            node.dataset.loadingHandlerAttached = 'true';
                                            node.addEventListener('click', handleClickableClick);
                                        }
                                    } else {
                                        node.querySelectorAll(selectors.join(',')).forEach(
                                        function(el) {
                                            if (!el.dataset.loadingHandlerAttached) {
                                                el.dataset.loadingHandlerAttached =
                                                'true';
                                                el.addEventListener('click',
                                                    handleClickableClick);
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    });
                });
                observer.observe(document.body, { childList: true, subtree: true });
                return observer;
            }
            attachLoadingListeners();

            // ============================================================
            // 5.  SIDEBAR TOGGLE – always clickable
            // ============================================================
            const sidebar = document.getElementById('questionsSidebar');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');
            const backdrop = document.getElementById('sidebarBackdrop');

            function openSidebar() {
                if (sidebar) sidebar.classList.add('open');
                if (backdrop) backdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                if (sidebar) sidebar.classList.remove('open');
                if (backdrop) backdrop.classList.remove('active');
                document.body.style.overflow = '';
            }

            function toggleSidebar() {
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
                toggleBtn.style.pointerEvents = 'auto';
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closeSidebar();
                });
            }
            if (backdrop) {
                backdrop.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closeSidebar();
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
                    closeSidebar();
                }
            });

            // ============================================================
            // 6.  CHAT FUNCTIONALITY
            // ============================================================
            const chatMessages = document.getElementById('chatMessages');
            const userInput = document.getElementById('userInput');
            const sendBtn = document.getElementById('sendBtn');

            function escapeHtml(str) {
                if (!str) return '';
                return str.replace(/[&<>]/g, function(m) {
                    if (m === '&') return '&amp;';
                    if (m === '<') return '&lt;';
                    if (m === '>') return '&gt;';
                    return m;
                }).replace(/\n/g, '<br>');
            }

            function removeIconTagsFromHtml(htmlString) {
                if (!htmlString) return '';
                let cleaned = htmlString.replace(/<i\b[^<]*>.*?<\/i>/gi, '');
                cleaned = cleaned.replace(/<span\s+class="[^"]*fa-[^"]*"[^>]*>.*?<\/span>/gi, '');
                cleaned = cleaned.replace(/<i\b[^>]*\/?>/gi, '');
                return cleaned;
            }

            function cleanBotResponse(rawHtml) {
                if (!rawHtml) return '';
                let cleaned = removeIconTagsFromHtml(rawHtml);
                cleaned = cleaned.replace(/<span[^>]*class="[^"]*fa-[^"]*"[^>]*><\/span>/gi, '');
                return cleaned;
            }

            function addMessage(sender, text, isUser) {
                const msgDiv = document.createElement('div');
                msgDiv.className = 'message ' + (isUser ? 'user' : 'bot');
                const avatar = document.createElement('div');
                avatar.className = 'avatar';
                avatar.innerHTML = isUser ? '<i class="fas fa-user"></i>' : '<i class="fas fa-robot"></i>';
                const bubble = document.createElement('div');
                bubble.className = 'bubble';
                const finalText = isUser ? escapeHtml(text) : cleanBotResponse(text);
                bubble.innerHTML = finalText;
                msgDiv.appendChild(avatar);
                msgDiv.appendChild(bubble);
                if (isUser) msgDiv.querySelector('.avatar').style.order = '2';
                chatMessages.appendChild(msgDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function removeTyping() {
                const el = document.getElementById('typingIndicator');
                if (el) el.remove();
            }

            function showTyping() {
                removeTyping();
                const typingDiv = document.createElement('div');
                typingDiv.id = 'typingIndicator';
                typingDiv.className = 'message bot';
                const avatar = document.createElement('div');
                avatar.className = 'avatar';
                avatar.innerHTML = '<i class="fas fa-robot"></i>';
                const bubble = document.createElement('div');
                bubble.className = 'typing-indicator';
                bubble.innerHTML =
                    '<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div><span>AI is thinking...</span>';
                typingDiv.appendChild(avatar);
                typingDiv.appendChild(bubble);
                chatMessages.appendChild(typingDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function getSureCargoFallback(userMessage) {
                const msg = userMessage.toLowerCase();
                if (msg.match(/register|sign up|create account|registration|how to join|new account/i)) {
                    return "📝 <strong>How to register on SureCargo:</strong><br>• Visit the Register page (link on login/home).<br>• Step 1: Enter First Name & Last Name.<br>• Step 2: Select your City (Bantayan or Bacolod) and User Type (Poultry Owner or Customer).<br>• Create a strong password: minimum 8 characters, including uppercase, lowercase, number, and special character (@$!%*?&).<br>• Confirm your password.<br>• Step 3: Provide a valid 11-digit mobile number starting with 09 (e.g., 09123456789).<br>• Click Register → you'll receive a 6-digit OTP via SMS for verification.<br>• Enter OTP to complete registration, then log in to start booking!";
                }
                if (msg.match(/book|booking|how to book|reserve/i)) {
                    if (msg.match(/step|process|how/i)) {
                        return "📋 Booking Steps:<br>1. Dashboard → select AVAILABLE truck<br>2. Enter quantity, pickup, receiver, drop-off<br>3. Submit → wait admin approval<br>4. Pay via GCash (upload ref) or COD<br>5. Track live when 'in_transit'";
                    }
                    return "To book, go to Dashboard, pick a truck with available capacity, fill the form, and submit. Admin confirms within 24h.";
                }
                if (msg.match(/track|live|gps|location|real-time/i)) {
                    return "📍 Live Tracking: When booking status becomes 'in_transit', a 'Track' button appears in My Bookings. Click it to see the driver's live GPS on a map (Leaflet + Reverb WebSockets).";
                }
                if (msg.match(/pay|gcash|payment|gcash|qr code|cod|bayad/i)) {
                    if (msg.includes('gcash')) return "💚 GCash: After confirmation, go to My Bookings → Pay → choose GCash. Scan QR, send exact amount, upload reference number. Admin verifies within 24h.";
                    if (msg.includes('cod')) return "🚚 COD: Select Cash on Delivery at checkout, provide your full name. Pay exact cash when driver delivers.";
                    return "SureCargo accepts GCash (upload reference) and Cash on Delivery. Both secure.";
                }
                if (msg.match(/capacity|max trays|limit/i)) return "🚛 Each truck holds 12000 egg trays. Dashboard shows 'Available Egg Trays' in real-time.";
                if (msg.match(/edit|modify|update booking/i)) return "✏️ You can edit a booking only while status is 'pending'. Go to My Bookings → Edit.";
                if (msg.match(/cancel|refund/i)) return "❌ Cancel: Pending bookings can be cancelled from My Bookings. For confirmed bookings, contact support. GCash refunds take 3-5 days.";
                if (msg.match(/profile|update profile|change password/i)) return "👤 Profile: Click Profile in sidebar → update photo, mobile, city, user type. Change password with current verification.";
                if (msg.match(/support|help|contact/i)) return "📞 Support: Email support@surecargo.com | Hotline +1 (800) 555-1234 | In-app chat with admin.";
                if (msg.match(/about|what is surecargo|platform/i)) return "🚚 SureCargo is a logistics platform specialized in egg tray transportation, offering real-time tracking, digital payments (GCash/COD), and seamless booking management.";
                if (msg.match(/hello|hi|hey|maayong|kumusta|good morning/i)) return "👋 Maayong adlaw! I'm SureCargo AI. Ask me about registrations, bookings, tracking, payments, or account updates.";
                if (msg.match(/thank|salamat|thanks/i)) return "😊 You're welcome! Safe shipping and happy tracking! Anything else?";
                return "🤖 I can help with: Registration, booking steps, live tracking, GCash/COD payments, profile updates, and support info. Please rephrase or click a quick question.";
            }

            async function callPuterAI(userMessage) {
                try {
                    const response = await fetch('/api/chat-ai', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ message: userMessage })
                    });
                    if (!response.ok) throw new Error('HTTP ' + response.status);
                    const data = await response.json();
                    if (data.reply && data.reply.trim()) return data.reply;
                    throw new Error('Empty reply');
                } catch (error) {
                    console.warn('Puter AI failed, using fallback:', error);
                    return null;
                }
            }

            async function sendMessage(messageOverride) {
                const rawMessage = (messageOverride !== null && messageOverride !== undefined) ? messageOverride :
                    userInput.value.trim();
                if (!rawMessage) return;

                setButtonLoading(sendBtn, true);

                addMessage('user', rawMessage, true);
                if (messageOverride === null || messageOverride === undefined) userInput.value = '';
                else userInput.value = '';

                showTyping();
                let aiReply = await callPuterAI(rawMessage);
                if (!aiReply) aiReply = getSureCargoFallback(rawMessage);
                removeTyping();
                addMessage('bot', aiReply, false);

                setButtonLoading(sendBtn, false);
            }

            if (sendBtn) {
                sendBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (loadingButtons.has(sendBtn)) return;
                    sendMessage();
                });
            }

            if (userInput) {
                userInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (loadingButtons.has(sendBtn)) return;
                        sendMessage();
                    }
                });
                userInput.focus();
            }

            // ============================================================
            // 7.  POPULATE SIDEBAR QUESTIONS
            // ============================================================
            const questions = [
                "📦 How do I book a truck?",
                "📝 How to register a new account?",
                "📍 How does real-time tracking work?",
                "💳 What payment methods are accepted?",
                "🧾 How to pay via GCash QR?",
                "🚛 What is the maximum capacity per truck?",
                "✏️ Can I edit my booking after confirmation?",
                "❌ How to cancel a booking?",
                "⏱️ How long does admin confirmation take?",
                "📊 Where can I see my booking history?",
                "📱 Is there a mobile app?",
                "🔄 What does 'in_transit' status mean?",
                "💰 How is the total amount calculated?",
                "🔔 Will I receive notifications?",
                "🧑‍💼 How to update my profile?",
                "📞 Support contact?",
                "🧾 What is COD & how does it work?",
                "🛣️ Which cities does SureCargo cover?",
                "📦 Egg tray quantity limits?",
                "🔄 Booking reference lookup?"
            ];

            const sidebarList = document.getElementById('questionsList');
            if (sidebarList) {
                questions.forEach(function(q) {
                    const div = document.createElement('div');
                    div.className = 'quick-question';
                    let iconHtml = '<i class="fas fa-comment"></i>';
                    if (q.includes("📦")) iconHtml = '<i class="fas fa-box"></i>';
                    else if (q.includes("📍")) iconHtml = '<i class="fas fa-map-marker-alt"></i>';
                    else if (q.includes("💳") || q.includes("🧾")) iconHtml = '<i class="fas fa-credit-card"></i>';
                    else if (q.includes("🚛")) iconHtml = '<i class="fas fa-truck"></i>';
                    else if (q.includes("✏️")) iconHtml = '<i class="fas fa-edit"></i>';
                    else if (q.includes("❌")) iconHtml = '<i class="fas fa-ban"></i>';
                    else if (q.includes("⏱️")) iconHtml = '<i class="fas fa-clock"></i>';
                    else if (q.includes("📊")) iconHtml = '<i class="fas fa-chart-line"></i>';
                    else if (q.includes("📱")) iconHtml = '<i class="fas fa-mobile-alt"></i>';
                    else if (q.includes("🔄")) iconHtml = '<i class="fas fa-sync-alt"></i>';
                    else if (q.includes("💰")) iconHtml = '<i class="fas fa-calculator"></i>';
                    else if (q.includes("🔔")) iconHtml = '<i class="fas fa-bell"></i>';
                    else if (q.includes("🧑‍💼")) iconHtml = '<i class="fas fa-user-edit"></i>';
                    else if (q.includes("📞")) iconHtml = '<i class="fas fa-headset"></i>';
                    else if (q.includes("🛣️")) iconHtml = '<i class="fas fa-city"></i>';
                    else if (q.includes("📝")) iconHtml = '<i class="fas fa-user-plus"></i>';
                    else iconHtml = '<i class="fas fa-question-circle"></i>';

                    div.innerHTML = iconHtml + ' <span>' + q.replace(/^[^\w]+/, '').trim() + '</span>';
                    div.addEventListener('click', function() {
                        sendMessage(q);
                        if (window.innerWidth <= 860) {
                            closeSidebar();
                        }
                    });
                    sidebarList.appendChild(div);
                });
            }

            // ============================================================
            // 8.  CLEAN WELCOME MESSAGE
            // ============================================================
            const initialBotBubble = document.querySelector('.message.bot .bubble');
            if (initialBotBubble) {
                initialBotBubble.innerHTML = cleanBotResponse(initialBotBubble.innerHTML);
            }

            // ============================================================
            // 9.  RESIZE HANDLER – close sidebar on desktop
            // ============================================================
            window.addEventListener('resize', function() {
                if (window.innerWidth > 860 && sidebar && sidebar.classList.contains('open')) {
                    closeSidebar();
                }
                if (window.innerWidth > 860) {
                    document.body.style.overflow = '';
                }
            });

            // ============================================================
            // 10. ENSURE SIDEBAR TOGGLE IS NEVER BLOCKED
            // ============================================================
            if (toggleBtn) {
                toggleBtn.style.position = 'fixed';
                toggleBtn.style.pointerEvents = 'auto';
                toggleBtn.style.zIndex = '1060';
            }

        })();
    </script>
</body>
</html>
