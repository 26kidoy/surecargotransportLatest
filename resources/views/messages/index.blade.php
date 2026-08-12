@extends('layouts.app')

@section('content')
<style nonce="{{ $csp_nonce }}">
/* ==================== MESSENGER V3 - DEEPSEEK-STYLE RESPONSIVE ==================== */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --secondary-bg: #ffffff;
    --sidebar-bg: #ffffff;
    --chat-bg: #f8fafc;
    --border-light: #e2e8f0;
    --text-dark: #1e293b;
    --text-muted: #64748b;
    --online-green: #22c55e;
    --hover-gray: #f1f5f9;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --transition-default: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);

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

/* Body Base - Clean & Readable */
body {

    font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    font-size: var(--font-base);
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    line-height: 1.6;
}

/* Messenger Container - full height, flex column */
.messenger-container {
    background: var(--chat-bg);
    border-radius: 28px;
    overflow: hidden !important;
    box-shadow: var(--shadow-lg);
    height: calc(100dvh - 90px);
    position: relative;
    display: flex !important;
    flex-direction: column !important;
}

/* ==================== SLIDING SIDEBAR ==================== */
.messenger-wrapper {
    display: flex;
    height: 100%;
    width: 100%;
    position: relative;
    background: var(--secondary-bg);
    overflow: hidden !important;
}

/* Sidebar Drawer */
.messenger-sidebar {
    width: 380px;
    background: var(--sidebar-bg);
    border-right: 1px solid var(--border-light);
    display: flex;
    flex-direction: column;
    transition: var(--transition-default);
    z-index: 30;
    flex-shrink: 0;
    box-shadow: var(--shadow-sm);
    height: 100% !important;
    overflow: hidden !important;
}

/* Sidebar Toggle Button */
.sidebar-toggle {
    position: absolute;
    left: 390px;
    top: 24px;
    z-index: 40;
    background: white;
    border: 1px solid var(--border-light);
    border-radius: 40px;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition-default);
    box-shadow: var(--shadow-md);
    color: var(--text-dark);
    min-height: 44px;
    min-width: 44px;
}

.sidebar-toggle:hover {
    background: var(--hover-gray);
    transform: scale(1.05);
}

.sidebar-toggle i {
    font-size: var(--font-lg);
}

/* Collapsed Sidebar State */
.messenger-sidebar.collapsed {
    margin-left: -380px;
}

.messenger-sidebar.collapsed + .sidebar-toggle {
    left: 20px;
}

/* Chat Area - flex column to keep input at bottom */
.messenger-chat-area {
    flex: 1;
    display: flex !important;
    flex-direction: column !important;
    background: var(--chat-bg);
    position: relative;
    transition: var(--transition-default);
    min-width: 0;
    height: 100% !important;
    overflow: hidden !important;
}

/* Overlay for mobile */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 25;
    backdrop-filter: blur(2px);
}

/* ==================== SIDEBAR STYLES ==================== */
.sidebar-header {
    padding: 24px 20px;
    border-bottom: 1px solid var(--border-light);
    background: white;
    flex-shrink: 0;
}

.sidebar-header h4 {
    font-weight: 800;
    font-size: var(--font-xl);
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: 0;
    letter-spacing: -0.3px;
}

.search-wrapper {
    position: relative;
    margin-top: 16px;
}

.search-wrapper i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: var(--font-md);
}

.messenger-search {
    width: 100%;
    padding: 12px 16px 12px 48px;
    border: 1px solid var(--border-light);
    border-radius: 40px;
    font-size: var(--font-base);
    font-weight: 400;
    background: #f8fafc;
    transition: var(--transition-default);
    min-height: 44px;
}

.messenger-search:focus {
    outline: none;
    border-color: var(--primary-color);
    background: white;
    box-shadow: 0 0 0 4px rgba(99,102,241,0.15);
}

.filter-group {
    display: flex;
    gap: 10px;
    margin-top: 14px;
}

.filter-select {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid var(--border-light);
    border-radius: 40px;
    background: #f8fafc;
    font-size: var(--font-sm);
    font-weight: 400;
    color: var(--text-dark);
    cursor: pointer;
    min-height: 40px;
}

/* Users List - takes remaining space and scrolls */
.messenger-users-list {
    flex: 1 !important;
    overflow-y: auto !important;
    padding: 10px 0;
    min-height: 0 !important;
}

.messenger-user-item {
    padding: 16px 20px;
    cursor: pointer;
    transition: var(--transition-default);
    border-bottom: 1px solid var(--border-light);
    position: relative;
}

.messenger-user-item:hover {
    background: var(--hover-gray);
}

.messenger-user-item.active {
    background: linear-gradient(95deg, rgba(99,102,241,0.08) 0%, rgba(99,102,241,0.02) 100%);
    border-left: 4px solid var(--primary-color);
}

/* Avatar with online badge */
.avatar-wrapper {
    position: relative;
    width: 56px;
    height: 56px;
    flex-shrink: 0;
}

.user-avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: var(--shadow-sm);
}

.online-badge {
    position: absolute;
    bottom: 3px;
    right: 3px;
    width: 14px;
    height: 14px;
    background: var(--online-green);
    border: 2px solid white;
    border-radius: 50%;
    box-shadow: var(--shadow-sm);
}

.user-info {
    flex: 1;
    min-width: 0;
}

.user-name {
    font-weight: 700;
    font-size: var(--font-md);
    color: var(--text-dark);
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.user-last-message {
    font-size: var(--font-sm);
    color: var(--text-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-weight: 400;
}

.unread-badge {
    background: var(--primary-color);
    color: white;
    border-radius: 30px;
    padding: 2px 10px;
    font-size: var(--font-xs);
    font-weight: 700;
    min-width: 24px;
    text-align: center;
    line-height: 1.4;
}

.message-time {
    font-size: var(--font-xs);
    color: var(--text-muted);
    white-space: nowrap;
    font-weight: 400;
}

/* ==================== CHAT AREA STYLES ==================== */
.chat-header {
    background: white;
    padding: 16px 24px;
    border-bottom: 1px solid var(--border-light);
    display: flex;
    align-items: center;
    gap: 16px;
    flex-shrink: 0;
}

.chat-header-avatar {
    position: relative;
    width: 52px;
    height: 52px;
}

.chat-user-name {
    font-weight: 700;
    font-size: var(--font-lg);
    color: var(--text-dark);
    letter-spacing: -0.2px;
}

.chat-user-status {
    font-size: var(--font-sm);
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 400;
}

.online-text {
    color: var(--online-green);
    font-weight: 600;
}

/* Messages List - takes remaining space, scrolls */
.messages-list {
    flex: 1 1 auto !important;
    overflow-y: auto !important;
    padding: 24px 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    min-height: 0 !important;
}

.message-bubble {
    max-width: 70%;
    padding: 14px 20px;
    border-radius: 28px;
    position: relative;
    word-wrap: break-word;
    font-size: var(--font-base);
    line-height: 1.5;
    font-weight: 400;
    box-shadow: var(--shadow-sm);
}

.message-sent {
    background: var(--primary-color);
    color: white;
    border-bottom-right-radius: 8px;
    margin-left: auto;
}

.message-received {
    background: white;
    color: var(--text-dark);
    border-bottom-left-radius: 8px;
    border: 1px solid var(--border-light);
}

.message-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    justify-content: flex-end;
    margin-top: 6px;
    font-size: var(--font-xs);
    font-weight: 400;
    opacity: 0.85;
}

.message-sent .message-meta {
    color: rgba(255,255,255,0.85);
}

.message-received .message-meta {
    color: var(--text-muted);
    justify-content: flex-start;
}

/* ==================== INPUT AREA - ALWAYS AT BOTTOM ==================== */
.message-input-container {
    background: white;
    padding: 16px 24px;
    border-top: 1px solid var(--border-light);
    flex-shrink: 0 !important;
}

.input-wrapper {
    display: flex;
    gap: 14px;
    align-items: center;
    background: #f8fafc;
    border-radius: 60px;
    padding: 4px 4px 4px 20px;
    border: 1px solid var(--border-light);
    transition: var(--transition-default);
}

.input-wrapper:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(99,102,241,0.15);
    background: white;
}

.message-input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 12px 0;
    font-size: var(--font-base);
    font-weight: 400;
    outline: none;
    min-width: 0;
    min-height: 44px;
}

.message-input::placeholder {
    color: var(--text-muted);
    font-weight: 400;
}

.send-btn {
    background: var(--primary-color);
    border: none;
    border-radius: 50px;
    padding: 10px 28px;
    color: white;
    font-weight: 600;
    font-size: var(--font-base);
    transition: var(--transition-default);
    white-space: nowrap;
    cursor: pointer;
    flex-shrink: 0;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.send-btn:hover:not(:disabled) {
    background: var(--primary-dark);
    transform: scale(1.02);
}

.send-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.send-btn i {
    font-size: var(--font-md);
}

/* ============================================================ */
/* ===== RESPONSIVE (DeepSeek Style) ===== */
/* ============================================================ */

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
    }

    .messenger-sidebar {
        width: 320px;
    }

    .messenger-sidebar.collapsed {
        margin-left: -320px;
    }

    .sidebar-toggle {
        left: 330px;
    }

    .messenger-sidebar.collapsed + .sidebar-toggle {
        left: 16px;
    }

    .avatar-wrapper {
        width: 48px;
        height: 48px;
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
    }

    .messenger-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        z-index: 100;
        transform: translateX(0);
        box-shadow: var(--shadow-lg);
        width: 320px;
    }

    .messenger-sidebar.collapsed {
        transform: translateX(-100%);
        margin-left: 0;
    }

    .sidebar-toggle {
        left: auto;
        right: 16px;
        top: 16px;
        z-index: 101;
        width: 40px;
        height: 40px;
        min-height: 40px;
        min-width: 40px;
    }

    .sidebar-toggle i {
        font-size: var(--font-md);
    }

    .messenger-sidebar.collapsed + .sidebar-toggle {
        left: auto;
        right: 16px;
    }

    .sidebar-overlay.active {
        display: block;
    }

    .messenger-chat-area {
        width: 100%;
    }

    .message-bubble {
        max-width: 85%;
        font-size: var(--font-base);
        padding: 12px 16px;
    }

    body {
        font-size: var(--font-base);
        padding-bottom: 20px !important;
    }

    .sidebar-header {
        padding: 18px 16px;
    }

    .sidebar-header h4 {
        font-size: var(--font-lg);
    }

    .messenger-search {
        font-size: var(--font-sm);
        padding: 10px 14px 10px 44px;
        min-height: 38px;
    }

    .search-wrapper i {
        font-size: var(--font-base);
        left: 16px;
    }

    .messenger-user-item {
        padding: 14px 16px;
    }

    .avatar-wrapper {
        width: 48px;
        height: 48px;
    }

    .user-name {
        font-size: var(--font-sm);
    }

    .user-last-message {
        font-size: var(--font-xs);
    }

    .filter-select {
        font-size: var(--font-sm);
        padding: 8px 12px;
        min-height: 36px;
    }

    .chat-header {
        padding: 14px 18px;
        gap: 12px;
    }

    .chat-header-avatar {
        width: 44px;
        height: 44px;
    }

    .chat-user-name {
        font-size: var(--font-md);
    }

    .chat-user-status {
        font-size: var(--font-xs);
    }

    .messages-list {
        padding: 18px 14px;
        gap: 14px;
    }

    .message-input-container {
        padding: 14px 18px;
    }

    .input-wrapper {
        padding: 4px 4px 4px 16px;
        gap: 10px;
    }

    .message-input {
        font-size: var(--font-sm);
        padding: 10px 0;
        min-height: 38px;
    }

    .send-btn {
        padding: 8px 20px;
        font-size: var(--font-sm);
        min-height: 38px;
    }

    .send-btn i {
        font-size: var(--font-base);
    }

    .message-time {
        font-size: var(--font-xs);
    }

    .unread-badge {
        font-size: var(--font-xs);
        padding: 2px 8px;
        min-width: 20px;
    }
}

/* --- Small Phones (≤ 480px) --- */
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
    }

    .messenger-sidebar {
        width: 280px;
    }

    .messenger-sidebar.collapsed {
        transform: translateX(-100%);
    }

    .sidebar-toggle {
        width: 36px;
        height: 36px;
        min-height: 36px;
        min-width: 36px;
        right: 12px;
        top: 12px;
    }

    .sidebar-toggle i {
        font-size: var(--font-sm);
    }

    .sidebar-header {
        padding: 14px 12px;
    }

    .sidebar-header h4 {
        font-size: var(--font-md);
    }

    .messenger-search {
        font-size: var(--font-xs);
        padding: 8px 12px 8px 38px;
        min-height: 34px;
    }

    .search-wrapper i {
        font-size: var(--font-sm);
        left: 14px;
    }

    .messenger-user-item {
        padding: 10px 12px;
    }

    .avatar-wrapper {
        width: 40px;
        height: 40px;
    }

    .online-badge {
        width: 12px;
        height: 12px;
        bottom: 2px;
        right: 2px;
    }

    .user-name {
        font-size: var(--font-sm);
    }

    .user-last-message {
        font-size: var(--font-xs);
    }

    .message-time {
        font-size: 0.6rem;
    }

    .unread-badge {
        font-size: 0.6rem;
        padding: 1px 6px;
        min-width: 18px;
    }

    .filter-group {
        gap: 6px;
        flex-direction: column;
    }

    .filter-select {
        font-size: var(--font-xs);
        padding: 6px 10px;
        min-height: 32px;
    }

    .chat-header {
        padding: 10px 14px;
        gap: 10px;
    }

    .chat-header-avatar {
        width: 38px;
        height: 38px;
    }

    .chat-user-name {
        font-size: var(--font-sm);
    }

    .chat-user-status {
        font-size: var(--font-xs);
    }

    .messages-list {
        padding: 14px 10px;
        gap: 10px;
    }

    .message-bubble {
        max-width: 90%;
        padding: 10px 14px;
        font-size: var(--font-sm);
        border-radius: 20px;
    }

    .message-meta {
        font-size: var(--font-xs);
        margin-top: 4px;
        gap: 6px;
    }

    .message-input-container {
        padding: 10px 14px;
    }

    .input-wrapper {
        padding: 4px 4px 4px 14px;
        gap: 8px;
    }

    .message-input {
        font-size: var(--font-sm);
        padding: 8px 0;
        min-height: 34px;
    }

    .send-btn {
        padding: 6px 16px;
        font-size: var(--font-xs);
        min-height: 34px;
        border-radius: 40px;
    }

    .send-btn i {
        font-size: var(--font-sm);
        margin-right: 4px;
    }

    .messenger-container {
        border-radius: 16px;
        height: calc(100dvh - 70px);
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
    }

    .messenger-sidebar {
        width: 260px;
    }

    .sidebar-toggle {
        width: 32px;
        height: 32px;
        min-height: 32px;
        min-width: 32px;
        right: 10px;
        top: 10px;
    }

    .sidebar-toggle i {
        font-size: var(--font-xs);
    }

    .sidebar-header {
        padding: 10px 10px;
    }

    .sidebar-header h4 {
        font-size: var(--font-sm);
    }

    .messenger-search {
        font-size: 0.6rem;
        padding: 6px 10px 6px 34px;
        min-height: 30px;
        border-radius: 30px;
    }

    .search-wrapper i {
        font-size: var(--font-xs);
        left: 12px;
    }

    .messenger-user-item {
        padding: 8px 10px;
    }

    .avatar-wrapper {
        width: 34px;
        height: 34px;
    }

    .online-badge {
        width: 10px;
        height: 10px;
        bottom: 1px;
        right: 1px;
        border-width: 1.5px;
    }

    .user-name {
        font-size: var(--font-xs);
        font-weight: 600;
    }

    .user-last-message {
        font-size: 0.55rem;
    }

    .message-time {
        font-size: 0.5rem;
    }

    .unread-badge {
        font-size: 0.5rem;
        padding: 1px 5px;
        min-width: 16px;
    }

    .chat-header {
        padding: 8px 12px;
        gap: 8px;
    }

    .chat-header-avatar {
        width: 32px;
        height: 32px;
    }

    .chat-user-name {
        font-size: var(--font-xs);
        font-weight: 600;
    }

    .chat-user-status {
        font-size: 0.55rem;
    }

    .messages-list {
        padding: 10px 8px;
        gap: 8px;
    }

    .message-bubble {
        max-width: 92%;
        padding: 8px 12px;
        font-size: var(--font-xs);
        border-radius: 16px;
    }

    .message-meta {
        font-size: 0.5rem;
        margin-top: 3px;
        gap: 4px;
    }

    .message-input-container {
        padding: 8px 10px;
    }

    .input-wrapper {
        padding: 4px 4px 4px 12px;
        gap: 6px;
        border-radius: 30px;
    }

    .message-input {
        font-size: var(--font-xs);
        padding: 6px 0;
        min-height: 30px;
    }

    .send-btn {
        padding: 4px 12px;
        font-size: 0.6rem;
        min-height: 30px;
        border-radius: 30px;
    }

    .send-btn i {
        font-size: var(--font-xs);
        margin-right: 2px;
    }

    .messenger-container {
        border-radius: 12px;
        height: calc(100dvh - 60px);
    }

    .filter-select {
        font-size: 0.6rem;
        padding: 5px 8px;
        min-height: 28px;
        border-radius: 30px;
    }
}

/* --- Extra Small (≤ 350px) --- */
@media (max-width: 350px) {
    .messenger-sidebar {
        width: 220px;
    }

    .sidebar-toggle {
        width: 28px;
        height: 28px;
        min-height: 28px;
        min-width: 28px;
        right: 8px;
        top: 8px;
    }

    .sidebar-header h4 {
        font-size: 0.8rem;
    }

    .messenger-search {
        font-size: 0.5rem;
        padding: 4px 8px 4px 28px;
        min-height: 26px;
    }

    .search-wrapper i {
        font-size: 0.6rem;
        left: 10px;
    }

    .avatar-wrapper {
        width: 28px;
        height: 28px;
    }

    .user-name {
        font-size: 0.6rem;
    }

    .user-last-message {
        font-size: 0.45rem;
    }

    .chat-user-name {
        font-size: 0.7rem;
    }

    .message-bubble {
        padding: 6px 10px;
        font-size: 0.65rem;
        max-width: 95%;
    }

    .send-btn {
        padding: 4px 10px;
        font-size: 0.5rem;
        min-height: 26px;
    }

    .message-input {
        font-size: 0.6rem;
        padding: 4px 0;
        min-height: 26px;
    }

    .input-wrapper {
        padding: 2px 2px 2px 10px;
    }

    .messenger-container {
        border-radius: 8px;
        height: calc(100dvh - 50px);
    }
}

/* ==================== SCROLLBAR STYLES ==================== */
.messenger-users-list::-webkit-scrollbar,
.messages-list::-webkit-scrollbar {
    width: 5px;
}

.messenger-users-list::-webkit-scrollbar-track,
.messages-list::-webkit-scrollbar-track {
    background: #eef2ff;
}

.messenger-users-list::-webkit-scrollbar-thumb,
.messages-list::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.messenger-users-list::-webkit-scrollbar-thumb:hover,
.messages-list::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* ============================================================ */
/* ===== HIDDEN AUDIO (click only) ===== */
/* ============================================================ */
#clickAudio {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
    user-select: none;
}
</style>

<div class="container-fluid px-0 px-md-3 mt-2 mt-md-3">
    <div class="messenger-container mx-auto">
        <div class="messenger-wrapper">
            <!-- Sidebar Overlay (Mobile) -->
            <div class="sidebar-overlay" id="sidebarOverlay"></div>

            <!-- Left Sliding Sidebar -->
            <div class="messenger-sidebar" id="messengerSidebar">
                <div class="sidebar-header">
                    <h4><i class="fas fa-comment-dots me-2"></i> Chats</h4>
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" class="messenger-search" id="searchUserInput" placeholder="Search by name...">
                    </div>
                    <div class="filter-group">
                        <select class="filter-select" id="userTypeSelect">
                            <option value="">All Types</option>
                            <option value="poultry_owner">Poultry Owners</option>
                            <option value="customer">Customers</option>
                        </select>
                        <select class="filter-select" id="citySelect">
                            <option value="">All Cities</option>
                        </select>
                    </div>
                </div>
                <div id="usersList" class="messenger-users-list">
                    <div class="text-center py-5 text-muted">
                        <div class="spinner-border text-primary mb-2"></div>
                        <div>Loading conversations...</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Toggle Button (Slider control) -->
            <div class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-chevron-left"></i>
            </div>

            <!-- Chat Area -->
            <div class="messenger-chat-area" id="chatAreaContainer">
                <!-- Chat Header -->
                <div class="chat-header">
                    <div class="chat-header-avatar" id="chatUserAvatarWrapper">
                        <i class="fas fa-user-circle fa-3x text-secondary"></i>
                    </div>
                    <div>
                        <div class="chat-user-name" id="chatUserName">Select a conversation</div>
                        <div class="chat-user-status" id="chatUserStatus">
                            <i class="fas fa-circle me-1" style="font-size: 0.6rem; color: #cbd5e1;"></i> Click on a user
                        </div>
                    </div>
                </div>

                <!-- Messages List -->
                <div id="messagesList" class="messages-list">
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-comment-dots fa-3x mb-3 opacity-50"></i>
                        <p class="mb-0">Select a conversation to start messaging</p>
                    </div>
                </div>

                <!-- Message Input -->
                <div class="message-input-container">
                    <div class="input-wrapper">
                        <input type="text" class="message-input" id="messageInput" placeholder="Aa" disabled>
                        <button class="send-btn" id="sendBtn" disabled><i class="fas fa-paper-plane me-2"></i> Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script nonce="{{ $csp_nonce }}">
$(document).ready(function() {
    // ==================== STATE ====================
    let allUsers = [];
    let activeChatUserId = null;
    let messagesInterval = null;
    let usersInterval = null;
    let onlineCheckInterval = null;
    let lastMessageCount = 0;
    const loggedUserId = parseInt('{{ Auth::id() }}');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // ==================== UTILITIES ====================
    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // Show accurate local time (HH:MM) using client's timezone
    function getCurrentLocalTime() {
        const now = new Date();
        return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    // Convert a UTC timestamp (from server) to local time string
    function formatTimestampToLocal(timestamp) {
        if (!timestamp) return '';
        const date = new Date(timestamp);
        if (isNaN(date.getTime())) return '';
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    // Format date separator (Today, Yesterday, or date)
    function formatMessageDate(dateObj) {
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(today.getDate() - 1);

        if (dateObj.toDateString() === today.toDateString()) return 'Today';
        if (dateObj.toDateString() === yesterday.toDateString()) return 'Yesterday';
        return dateObj.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function showToast(message, type = 'success') {
        let toastHtml = `<div class="position-fixed bottom-0 end-0 m-3 p-3 rounded shadow-lg bg-${type === 'danger' ? 'danger' : 'success'} text-white" style="z-index: 9999; font-size:0.9rem; border-radius: 20px; font-weight:500;">
                            <i class="fas ${type === 'danger' ? 'fa-exclamation-circle' : 'fa-check-circle'} me-2"></i> ${escapeHtml(message)}
                         </div>`;
        $('body').append(toastHtml);
        setTimeout(() => $('.position-fixed.bottom-0.end-0').fadeOut(300, function() { $(this).remove(); }), 3500);
    }

    // Compute online status based on last activity (within 2 minutes)
    function computeOnlineStatus(user) {
        if (user.is_online_forced) return true;
        let lastTimestamp = user.last_message_timestamp || user.last_seen || null;
        if (lastTimestamp && (Math.floor(Date.now() / 1000) - lastTimestamp < 120)) {
            return true;
        }
        return false;
    }

    function refreshOnlineStatuses() {
        let changed = false;
        allUsers = allUsers.map(user => {
            let wasOnline = user.is_online_computed;
            let newOnline = computeOnlineStatus(user);
            if (wasOnline !== newOnline) {
                changed = true;
                user.is_online_computed = newOnline;
            }
            return user;
        });
        if (changed) {
            applyFilters();
            if (activeChatUserId) updateChatHeaderStatus(activeChatUserId);
        }
    }

    // ==================== USER LIST ====================
    function loadUsers() {
        $.ajax({
            url: '/api/users',
            method: 'GET',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(users) {
                if (!users || users.length === 0) {
                    $('#usersList').html('<div class="text-center py-5 text-muted">No conversations yet. Start messaging someone!</div>');
                    allUsers = [];
                    return;
                }
                allUsers = users.map(user => {
                    let lastMsgTs = user.last_message?.timestamp || user.last_seen || null;
                    user.last_message_timestamp = lastMsgTs;
                    user.is_online_computed = computeOnlineStatus(user);
                    return user;
                });
                populateCityFilter();
                applyFilters();
                updateGlobalUnreadCount();
            },
            error: function() {
                $('#usersList').html('<div class="text-center py-5 text-danger">Failed to load conversations.</div>');
            }
        });
    }

    function populateCityFilter() {
        const cities = [...new Set(allUsers.map(u => u.city).filter(c => c && c !== 'Not set'))];
        const citySelect = $('#citySelect');
        citySelect.find('option:not(:first)').remove();
        cities.forEach(city => {
            citySelect.append(`<option value="${escapeHtml(city)}">${escapeHtml(city)}</option>`);
        });
    }

    function applyFilters() {
        const searchTerm = $('#searchUserInput').val().toLowerCase();
        const userType = $('#userTypeSelect').val();
        const city = $('#citySelect').val();

        let filtered = [...allUsers];
        if (searchTerm) filtered = filtered.filter(u => u.name && u.name.toLowerCase().includes(searchTerm));
        if (userType) filtered = filtered.filter(u => u.user_type === userType);
        if (city) filtered = filtered.filter(u => u.city === city);
        renderUsersList(filtered);
    }

    function renderUsersList(users) {
        if (users.length === 0) {
            $('#usersList').html('<div class="text-center py-5 text-muted">No users found</div>');
            return;
        }
        let html = '';
        users.forEach(user => {
            const isActive = activeChatUserId === user.id;
            const unreadBadge = user.unread_count > 0 ? `<span class="unread-badge">${user.unread_count}</span>` : '';
            const lastMsgText = user.last_message ? (user.last_message.message.length > 40 ? user.last_message.message.substring(0,37)+'...' : user.last_message.message) : 'No messages yet';
            const timeAgo = user.last_message?.time || '';
            const userTypeDisplay = user.user_type === 'poultry_owner' ? 'Poultry Owner' : 'Customer';
            const avatarUrl = user.profile_image_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=6366f1&color=fff&size=80&bold=true`;
            const isOnline = user.is_online_computed === true;

            html += `
                <div class="messenger-user-item ${isActive ? 'active' : ''}" data-user-id="${user.id}" data-user-name="${escapeHtml(user.name)}" data-user-avatar="${escapeHtml(avatarUrl)}" data-user-type="${user.user_type}" data-user-online="${isOnline}">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="avatar-wrapper">
                            <img src="${avatarUrl}" class="user-avatar" alt="${escapeHtml(user.name)}" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=6366f1&color=fff'">
                            ${isOnline ? '<span class="online-badge"></span>' : ''}
                        </div>
                        <div class="user-info">
                            <div class="user-name">
                                <span>${escapeHtml(user.name)}</span>
                                ${unreadBadge}
                            </div>
                            <div class="user-last-message"><i class="fas fa-reply fa-flip-horizontal me-1 small"></i> ${escapeHtml(lastMsgText)}</div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="text-muted" style="font-size:0.75rem; font-weight:500">${userTypeDisplay} • ${escapeHtml(user.city || 'No city')}</small>
                                <span class="message-time">${timeAgo}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        $('#usersList').html(html);
    }

    function updateUserInList(userId, updates) {
        const index = allUsers.findIndex(u => u.id === userId);
        if (index !== -1) {
            allUsers[index] = { ...allUsers[index], ...updates };
            if (updates.last_message_timestamp) allUsers[index].is_online_computed = computeOnlineStatus(allUsers[index]);
            applyFilters();
            if (activeChatUserId === userId) updateChatHeaderStatus(userId);
        }
    }

    function updateGlobalUnreadCount() {
        const total = allUsers.reduce((sum, u) => sum + (u.unread_count || 0), 0);
        if (total > 0) $('title').text(`(${total}) Messages`);
        else $('title').text('Messages');
    }

    // ==================== CHAT ACTIONS ====================
    function updateChatHeaderStatus(userId) {
        const user = allUsers.find(u => u.id === userId);
        if (!user) return;
        const isOnline = user.is_online_computed === true;
        const statusHtml = isOnline ? '<span class="online-text"><i class="fas fa-circle me-1" style="font-size:0.65rem; color:#22c55e;"></i> Online</span>' : '<span><i class="fas fa-circle me-1" style="font-size:0.65rem; color:#94a3b8;"></i> Offline</span>';
        $('#chatUserStatus').html(statusHtml);
        const headerAvatarWrapper = $('#chatUserAvatarWrapper');
        if (isOnline && !headerAvatarWrapper.find('.online-badge').length) {
            const existingImg = headerAvatarWrapper.find('img');
            if (existingImg.length) {
                existingImg.parent().append('<span class="online-badge" style="bottom: 0; right: 0;"></span>');
            }
        } else if (!isOnline) {
            headerAvatarWrapper.find('.online-badge').remove();
        }
    }

    function selectUser(userId, userName, userAvatar, userType) {
        if (activeChatUserId === userId) return;
        activeChatUserId = userId;
        $('#chatUserName').text(userName);
        updateChatHeaderStatus(userId);

        const avatarHtml = `<div class="chat-header-avatar position-relative">
                                <img src="${userAvatar}" class="user-avatar" width="60" height="60" style="border-radius:50%; object-fit:cover;" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=6366f1&color=fff'">
                                ${allUsers.find(u=>u.id===userId)?.is_online_computed ? '<span class="online-badge"></span>' : ''}
                            </div>`;
        $('#chatUserAvatarWrapper').html(avatarHtml);

        $('#messageInput, #sendBtn').prop('disabled', false);
        $('#messageInput').focus();
        $('.messenger-user-item').removeClass('active');
        $(`.messenger-user-item[data-user-id="${userId}"]`).addClass('active');

        if (allUsers.find(u => u.id === userId)?.unread_count > 0) {
            updateUserInList(userId, { unread_count: 0 });
        }
        markMessagesAsRead(userId);
        loadMessages(userId);

        if (messagesInterval) clearInterval(messagesInterval);
        messagesInterval = setInterval(() => {
            if (activeChatUserId === userId) loadMessages(userId, true);
        }, 2800);

        if ($(window).width() < 768) {
            $('#messengerSidebar').addClass('collapsed');
            $('#sidebarToggle i').toggleClass('fa-chevron-left fa-chevron-right');
            $('.sidebar-overlay').removeClass('active');
        }
    }

    function loadMessages(userId, isPolling = false) {
        $.ajax({
            url: `/api/messages/${userId}`,
            method: 'GET',
            success: function(messages) {
                if (isPolling && messages.length === lastMessageCount && activeChatUserId === userId) return;
                lastMessageCount = messages.length;
                renderMessages(messages);
                const hasNew = messages.some(m => !m.is_sent_by_me && !m.is_read);
                if (hasNew && activeChatUserId === userId) markMessagesAsRead(userId);
            }
        });
    }

    function renderMessages(messages) {
        if (!messages || messages.length === 0) {
            $('#messagesList').html(`<div class="text-center text-muted py-5"><i class="fas fa-comment-alt fa-3x mb-3 opacity-50"></i><p>Send a message to start!</p></div>`);
            return;
        }
        let html = '';
        let lastDate = null;
        messages.forEach(msg => {
            // Convert server timestamp to local date
            let messageDate = null;
            let timeStr = '';
            if (msg.created_at) {
                const dateObj = new Date(msg.created_at);
                if (!isNaN(dateObj.getTime())) {
                    messageDate = dateObj;
                    timeStr = dateObj.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                }
            }
            // Fallback to provided time_formatted if conversion fails
            if (!timeStr && msg.time_formatted) timeStr = msg.time_formatted;

            const currentDate = messageDate ? formatMessageDate(messageDate) : msg.date_formatted;
            if (currentDate !== lastDate) {
                html += `<div class="text-center my-3"><span class="small bg-white px-4 py-1 rounded-pill text-muted shadow-sm" style="font-size:0.85rem; font-weight:500;">${currentDate}</span></div>`;
                lastDate = currentDate;
            }
            const isSent = msg.is_sent_by_me;
            let readIcon = '';
            if (isSent) readIcon = msg.is_read ? '<i class="fas fa-check-double" title="Read"></i>' : '<i class="fas fa-check" title="Sent"></i>';
            html += `
                <div class="d-flex ${isSent ? 'justify-content-end' : 'justify-content-start'}">
                    <div class="message-bubble ${isSent ? 'message-sent' : 'message-received'}">
                        <div>${escapeHtml(msg.message)}</div>
                        <div class="message-meta">
                            <span>${timeStr}</span>
                            ${readIcon ? `<span>${readIcon}</span>` : ''}
                        </div>
                    </div>
                </div>
            `;
        });
        $('#messagesList').html(html);
        const container = document.getElementById('messagesList');
        if(container) container.scrollTop = container.scrollHeight;
    }

    function sendMessage() {
        const message = $('#messageInput').val().trim();
        if (!message || !activeChatUserId) return;
        const sendBtn = $('#sendBtn');
        sendBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending');

        // Optimistically add message with current local time
        const tempMessage = {
            message: message,
            is_sent_by_me: true,
            is_read: false,
            created_at: new Date().toISOString(),
            time_formatted: getCurrentLocalTime()
        };
        // Append to UI immediately
        const currentMessagesHtml = $('#messagesList').html();
        if (currentMessagesHtml.includes('Send a message to start') || currentMessagesHtml.includes('Select a conversation')) {
            renderMessages([tempMessage]);
        } else {
            // Add to existing messages
            let lastDate = null;
            let newMsgHtml = '';
            const now = new Date();
            const todayStr = formatMessageDate(now);
            // Check if last date separator is today
            const lastSeparator = $('.messages-list .text-center:last-child span').text();
            if (lastSeparator !== todayStr) {
                newMsgHtml += `<div class="text-center my-3"><span class="small bg-white px-4 py-1 rounded-pill text-muted shadow-sm" style="font-size:0.85rem; font-weight:500;">${todayStr}</span></div>`;
            }
            newMsgHtml += `
                <div class="d-flex justify-content-end">
                    <div class="message-bubble message-sent">
                        <div>${escapeHtml(message)}</div>
                        <div class="message-meta">
                            <span>${getCurrentLocalTime()}</span>
                            <span><i class="fas fa-check" title="Sent"></i></span>
                        </div>
                    </div>
                </div>
            `;
            $('#messagesList').append(newMsgHtml);
            const container = document.getElementById('messagesList');
            container.scrollTop = container.scrollHeight;
        }

        $.ajax({
            url: '/api/messages/send',
            method: 'POST',
            data: JSON.stringify({ receiver_id: activeChatUserId, message: message, _token: csrfToken }),
            contentType: 'application/json',
            success: function(response) {
                if (response.success) {
                    $('#messageInput').val('');
                    // Replace optimistic message with real one (refresh)
                    loadMessages(activeChatUserId);
                    updateUserInList(activeChatUserId, {
                        last_message: { message: message.substring(0,50), time: 'Just now', timestamp: Math.floor(Date.now()/1000) },
                        last_message_timestamp: Math.floor(Date.now()/1000)
                    });
                    showToast('Message sent', 'success');
                } else {
                    showToast('Failed to send', 'danger');
                    loadMessages(activeChatUserId); // revert
                }
            },
            error: function() {
                showToast('Error sending message', 'danger');
                loadMessages(activeChatUserId);
            },
            complete: function() {
                sendBtn.prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i> Send');
            }
        });
    }

    function markMessagesAsRead(senderId) {
        $.ajax({ url: `/api/messages/mark-read/${senderId}`, method: 'POST', data: { _token: csrfToken } });
    }

    // ==================== SLIDER TOGGLE ====================
    $('#sidebarToggle').click(function() {
        $('#messengerSidebar').toggleClass('collapsed');
        const icon = $(this).find('i');
        if ($('#messengerSidebar').hasClass('collapsed')) {
            icon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
            $('.sidebar-overlay').removeClass('active');
        } else {
            icon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
            if ($(window).width() < 768) $('.sidebar-overlay').addClass('active');
        }
    });

    $('.sidebar-overlay').click(function() {
        $('#messengerSidebar').addClass('collapsed');
        $('#sidebarToggle i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
        $(this).removeClass('active');
    });

    // ==================== EVENT HANDLERS ====================
    $('#sendBtn').click(sendMessage);
    $('#messageInput').on('keypress', function(e) { if(e.which === 13 && !e.shiftKey) { e.preventDefault(); sendMessage(); } });
    $('#searchUserInput, #userTypeSelect, #citySelect').on('input change', applyFilters);
    $(document).on('click', '.messenger-user-item', function() {
        const userId = $(this).data('user-id'), userName = $(this).data('user-name'), userAvatar = $(this).data('user-avatar'), userType = $(this).data('user-type');
        selectUser(userId, userName, userAvatar, userType);
    });

    // ==================== INIT & POLLING ====================
    loadUsers();
    usersInterval = setInterval(loadUsers, 15000);
    onlineCheckInterval = setInterval(() => { if(allUsers.length) refreshOnlineStatuses(); }, 30000);

    $(window).on('beforeunload', function() {
        if(messagesInterval) clearInterval(messagesInterval);
        if(usersInterval) clearInterval(usersInterval);
        if(onlineCheckInterval) clearInterval(onlineCheckInterval);
    });
});
</script>
@endsection
