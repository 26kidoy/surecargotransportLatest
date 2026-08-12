@extends('admin.layouts.app')

@section('title', 'Edit Announcement')
@section('page-title', 'Edit Announcement')

@section('content')
<style nonce="{{ $csp_nonce }}">
 /* ============================================================
   ANNOUNCEMENT UPDATE FORM - DEEPSEEK-STYLE RESPONSIVE STYLES
   White & Violet Theme - Professional & Smooth
   ============================================================ */

:root {
    --violet-primary: #7b1fa2;
    --violet-dark: #4a148c;
    --violet-light: #d1c4e9;
    --violet-bg-light: #f3f0f7;
    --violet-bg-lighter: #e8e0f0;
    --violet-bg-soft: #f8f5fc;
    --violet-shadow: rgba(123, 31, 162, 0.08);
    --violet-shadow-hover: rgba(123, 31, 162, 0.12);
    --violet-shadow-focus: rgba(123, 31, 162, 0.25);
    --white: #ffffff;
    --text-dark: #2c2c3e;

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
   FORM CONTAINER
   ============================================================ */
.announcement-form-container {
    background: var(--white);
    border-radius: 2rem;
    box-shadow: 0 1.5rem 3rem var(--violet-shadow);
    padding: var(--sp-xl);
    border-top: 6px solid var(--violet-primary);
    border-bottom: 6px solid #9c27b0;
    transition: all 0.3s ease;
}

.announcement-form-container:hover {
    box-shadow: 0 2rem 4rem var(--violet-shadow-hover);
}

/* ============================================================
   GLOBAL FONT SIZING - DeepSeek Style
   ============================================================ */
.announcement-form-container,
.announcement-form-container .form-label,
.announcement-form-container .form-control,
.announcement-form-container .btn,
.announcement-form-container .form-check-label,
.announcement-form-container .text-muted {
    font-size: var(--font-base) !important;
    font-weight: 400 !important;
}

/* ============================================================
   FORM CONTROLS
   ============================================================ */
.announcement-form-container .form-control {
    border-radius: 1rem;
    padding: var(--sp-sm) var(--sp-md);
    border: 2px solid var(--violet-light);
    background: var(--white);
    color: var(--text-dark);
    transition: all 0.3s ease;
    min-height: 44px;
    font-weight: 400 !important;
}

.announcement-form-container .form-control:focus {
    border-color: var(--violet-primary);
    box-shadow: 0 0 0 0.3rem var(--violet-shadow-focus);
    transform: scale(1.01);
    outline: none;
}

.announcement-form-container .form-control::placeholder {
    color: #a0a0b0;
    font-weight: 400;
}

/* ============================================================
   LABELS
   ============================================================ */
.announcement-form-container .form-label {
    color: var(--violet-dark);
    margin-bottom: var(--sp-xs);
    font-weight: 600 !important;
}

/* ============================================================
   TEXTAREA
   ============================================================ */
.announcement-form-container textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

/* ============================================================
   CHECKBOX & SWITCH
   ============================================================ */
.announcement-form-container .form-check-input:checked {
    background-color: var(--violet-primary);
    border-color: var(--violet-primary);
}

.announcement-form-container .form-check-input:focus {
    border-color: var(--violet-primary);
    box-shadow: 0 0 0 0.2rem var(--violet-shadow-focus);
}

.announcement-form-container .form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    min-width: 1.2rem;
    min-height: 1.2rem;
    margin-top: 0.2rem;
    cursor: pointer;
}

.announcement-form-container .form-check-label {
    font-weight: 400 !important;
    margin-left: var(--sp-xs);
    cursor: pointer;
}

/* ============================================================
   SWITCH - LARGE
   ============================================================ */
.form-check-switch-lg .form-check-input {
    width: 3rem;
    height: 1.5rem;
    min-width: 3rem;
    min-height: 1.5rem;
}

.form-check-switch-lg .form-check-input:checked {
    background-color: var(--violet-primary);
    border-color: var(--violet-primary);
}

/* ============================================================
   BUTTONS
   ============================================================ */
/* Back button - Light Violet */
.btn-back {
    background: var(--violet-bg-light);
    border: 1px solid var(--violet-light);
    border-radius: 3rem;
    padding: var(--sp-sm) var(--sp-lg);
    font-weight: 600;
    color: var(--text-dark);
    transition: all 0.3s ease;
    font-size: var(--font-base) !important;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-back:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 0.5rem 1rem var(--violet-shadow);
    color: var(--text-dark);
    background: var(--violet-bg-lighter);
}

.btn-back:active {
    transform: translateY(0) scale(0.98);
}

/* Update button - Violet Gradient */
.btn-update {
    background: linear-gradient(135deg, var(--violet-primary) 0%, var(--violet-dark) 100%);
    border: none;
    border-radius: 3rem;
    padding: var(--sp-sm) var(--sp-xl);
    font-weight: 600;
    color: var(--white);
    transition: all 0.3s ease;
    font-size: var(--font-base) !important;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-xs);
}

.btn-update:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 0.5rem 1.2rem rgba(123, 31, 162, 0.3);
    color: var(--white);
    background: linear-gradient(135deg, #9c27b0 0%, var(--violet-primary) 100%);
}

.btn-update:active {
    transform: translateY(0) scale(0.98);
}

/* ============================================================
   INVALID FEEDBACK
   ============================================================ */
.invalid-feedback {
    color: var(--violet-primary) !important;
    font-size: var(--font-sm) !important;
    font-weight: 500;
    margin-top: var(--sp-xs);
}

/* ============================================================
   CURRENT IMAGE - FIXED for public/uploads
   ============================================================ */
.current-image-container {
    border: 2px solid var(--violet-primary);
    border-radius: 1rem;
    padding: var(--sp-sm);
    display: inline-block;
    background: var(--violet-bg-soft);
    transition: all 0.3s ease;
}

.current-image-container:hover {
    transform: scale(1.02);
    box-shadow: 0 0.3rem 0.8rem var(--violet-shadow);
}

.current-image {
    max-height: 150px;
    max-width: 200px;
    object-fit: cover;
    border-radius: 0.5rem;
}

.current-image-label {
    display: block;
    font-size: var(--font-sm) !important;
    color: var(--violet-dark);
    font-weight: 600;
    margin-top: var(--sp-xs);
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

    .announcement-form-container {
        padding: var(--sp-lg);
        border-radius: 1.5rem;
    }

    .announcement-form-container .form-control {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 40px;
        border-radius: 0.8rem;
    }

    .btn-back,
    .btn-update {
        padding: var(--sp-sm) var(--sp-lg);
        min-height: 40px;
        font-size: var(--font-sm) !important;
    }

    .current-image {
        max-height: 120px;
        max-width: 160px;
    }

    .current-image-label {
        font-size: var(--font-xs) !important;
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

    .announcement-form-container {
        padding: var(--sp-md);
        border-radius: 1.2rem;
        border-top-width: 4px;
        border-bottom-width: 4px;
    }

    .announcement-form-container .form-label,
    .announcement-form-container .form-control,
    .announcement-form-container .btn,
    .announcement-form-container .form-check-label,
    .announcement-form-container .text-muted {
        font-size: var(--font-sm) !important;
    }

    .announcement-form-container .form-control {
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
        border-radius: 0.8rem;
        border-width: 1.5px;
    }

    .announcement-form-container textarea.form-control {
        min-height: 100px;
    }

    .btn-back,
    .btn-update {
        font-size: var(--font-sm) !important;
        padding: var(--sp-sm) var(--sp-md);
        min-height: 38px;
        border-radius: 2rem;
    }

    .form-check-switch-lg .form-check-input {
        width: 2.5rem;
        height: 1.3rem;
        min-width: 2.5rem;
        min-height: 1.3rem;
    }

    .announcement-form-container .form-check-input {
        width: 1rem;
        height: 1rem;
        min-width: 1rem;
        min-height: 1rem;
    }

    .invalid-feedback {
        font-size: var(--font-xs) !important;
    }

    .current-image {
        max-height: 100px;
        max-width: 150px;
    }

    .current-image-label {
        font-size: var(--font-xs) !important;
    }

    /* Stack buttons on mobile */
    .d-flex.gap-3 {
        gap: var(--sp-sm) !important;
        flex-wrap: wrap;
    }

    .d-flex.gap-3 .btn {
        flex: 1;
        min-width: 0;
        width: 100%;
    }

    .row.g-3 {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .col-md-6 {
        padding-left: var(--sp-xs);
        padding-right: var(--sp-xs);
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

    .announcement-form-container {
        padding: var(--sp-sm);
        border-radius: 1rem;
        border-top-width: 3px;
        border-bottom-width: 3px;
    }

    .announcement-form-container .form-label,
    .announcement-form-container .form-control,
    .announcement-form-container .btn,
    .announcement-form-container .form-check-label,
    .announcement-form-container .text-muted {
        font-size: var(--font-xs) !important;
    }

    .announcement-form-container .form-control {
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 0.6rem;
        border-width: 1.5px;
    }

    .announcement-form-container textarea.form-control {
        min-height: 80px;
    }

    .btn-back,
    .btn-update {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 34px;
        border-radius: 1.5rem;
    }

    .form-check-switch-lg .form-check-input {
        width: 2rem;
        height: 1.1rem;
        min-width: 2rem;
        min-height: 1.1rem;
    }

    .announcement-form-container .form-check-input {
        width: 0.9rem;
        height: 0.9rem;
        min-width: 0.9rem;
        min-height: 0.9rem;
    }

    .invalid-feedback {
        font-size: 0.6rem !important;
    }

    .current-image {
        max-height: 80px;
        max-width: 120px;
    }

    .current-image-label {
        font-size: 0.6rem !important;
    }

    .d-flex.gap-3 .btn {
        font-size: var(--font-xs) !important;
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .row.g-3 {
        --bs-gutter-y: var(--sp-xs) !important;
        --bs-gutter-x: var(--sp-xs) !important;
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

    .announcement-form-container {
        padding: var(--sp-xs);
        border-radius: 0.8rem;
        border-top-width: 2px;
        border-bottom-width: 2px;
    }

    .announcement-form-container .form-label,
    .announcement-form-container .form-control,
    .announcement-form-container .btn,
    .announcement-form-container .form-check-label,
    .announcement-form-container .text-muted {
        font-size: 0.55rem !important;
    }

    .announcement-form-container .form-control {
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        border-radius: 0.5rem;
        border-width: 1px;
    }

    .announcement-form-container textarea.form-control {
        min-height: 60px;
    }

    .btn-back,
    .btn-update {
        font-size: 0.55rem !important;
        padding: 0.1rem var(--sp-xs);
        min-height: 30px;
        border-radius: 1.2rem;
    }

    .form-check-switch-lg .form-check-input {
        width: 1.8rem;
        height: 1rem;
        min-width: 1.8rem;
        min-height: 1rem;
    }

    .announcement-form-container .form-check-input {
        width: 0.8rem;
        height: 0.8rem;
        min-width: 0.8rem;
        min-height: 0.8rem;
    }

    .invalid-feedback {
        font-size: 0.5rem !important;
    }

    .current-image {
        max-height: 60px;
        max-width: 100px;
    }

    .current-image-label {
        font-size: 0.5rem !important;
    }

    .d-flex.gap-3 .btn {
        font-size: 0.5rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 28px;
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

    .announcement-form-container {
        padding: 0.05rem;
        border-radius: 0.6rem;
    }

    .announcement-form-container .form-label,
    .announcement-form-container .form-control,
    .announcement-form-container .btn,
    .announcement-form-container .form-check-label,
    .announcement-form-container .text-muted {
        font-size: 0.45rem !important;
    }

    .announcement-form-container .form-control {
        padding: 0.05rem var(--sp-xs);
        min-height: 26px;
        border-radius: 0.4rem;
    }

    .btn-back,
    .btn-update {
        font-size: 0.45rem !important;
        padding: 0.05rem var(--sp-xs);
        min-height: 26px;
        border-radius: 1rem;
    }

    .form-check-switch-lg .form-check-input {
        width: 1.5rem;
        height: 0.9rem;
        min-width: 1.5rem;
        min-height: 0.9rem;
    }

    .announcement-form-container .form-check-input {
        width: 0.7rem;
        height: 0.7rem;
        min-width: 0.7rem;
        min-height: 0.7rem;
    }

    .current-image {
        max-height: 50px;
        max-width: 80px;
    }

    .d-flex.gap-3 .btn {
        font-size: 0.4rem !important;
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

<div class="announcement-form-container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <h3 class="fw-bold mb-0" style="font-size: 2rem; color: #1e2a3e;">
            <i class="fas fa-edit me-2" style="color: #ffc107;"></i>Edit Announcement
        </h3>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-back">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $announcement->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="content" class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
            <textarea name="content" id="content" rows="6" class="form-control @error('content') is-invalid @enderror"
                      required>{{ old('content', $announcement->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="form-label fw-semibold">Image</label>
            @if($announcement->image)
                @php
                    // FIXED: Use the image_url accessor for public/uploads
                    $imageUrl = $announcement->image_url;
                @endphp
                @if($imageUrl)
                    <div class="current-image-container mb-2">
                        <img src="{{ e($imageUrl) }}" alt="Current image" class="current-image">
                        <span class="current-image-label">Current Image</span>
                    </div>
                @endif
            @endif
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror"
                   accept="image/*">
            <small class="text-muted d-block mt-1">Leave empty to keep current image. Allowed: jpeg, png, jpg, gif, webp. Max 2MB.</small>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="form-check form-switch form-check-switch-lg">
                    <input type="checkbox" name="is_published" id="is_published" class="form-check-input" value="1"
                           {{ old('is_published', $announcement->is_published) ? 'checked' : '' }}>
                    <label for="is_published" class="form-check-label fw-semibold">Published</label>
                </div>
            </div>
            <div class="col-md-6">
                <label for="published_at" class="form-label fw-semibold">Published At</label>
                <input type="datetime-local" name="published_at" id="published_at"
                       class="form-control @error('published_at') is-invalid @enderror"
                       value="{{ old('published_at', optional($announcement->published_at)->format('Y-m-d\TH:i')) }}">
                @error('published_at')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-update">
            <i class="fas fa-save me-2"></i> Update Announcement
        </button>
    </form>
</div>
@endsection
