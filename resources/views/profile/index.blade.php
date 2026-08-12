@extends('layouts.app')

@section('content')
<div class="container py-4" style="width: 98% !important; max-width: 98% !important; padding-left: 1rem !important; padding-right: 1rem !important;">
    <div class="row g-4">
        <!-- Profile Summary Card -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-lg rounded-4 text-center overflow-hidden hover-scale transition-all profile-card" style="width: 100% !important; margin: 0 auto;">
                <div class="card-body p-4">
                    <div class="position-relative d-inline-block mb-3">
                        <div id="profileImageContainer">
                            @php
                                $profileImage = Auth::user()->profile_image_url;
                                $fullName = Auth::user()->full_name ?? 'User';
                                $defaultAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($fullName) . '&background=0D8F81&color=fff&size=120&bold=true';
                                if (empty($profileImage) || !filter_var($profileImage, FILTER_VALIDATE_URL)) {
                                    $profileImage = $defaultAvatar;
                                }
                            @endphp
                            <img src="{{ e($profileImage) }}"
                                 class="rounded-circle profile-image-preview"
                                 style="width: clamp(80px, 15vw, 120px); height: clamp(80px, 15vw, 120px); object-fit: cover; border: 4px solid #fff; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease; max-width: 100%; height: auto;"
                                 id="profileImagePreview"
                                 alt="Profile Image"
                                 onerror="this.onerror=null; this.src='{{ $defaultAvatar }}';">
                        </div>
                    </div>
                    <h4 id="displayName" class="fw-bold text-dark" style="font-size: clamp(1.2rem, 3vw, 1.6rem);">{{ e(Auth::user()->first_name ?? '') }} {{ e(Auth::user()->last_name ?? '') }}</h4>
                    <p class="mb-0" id="displayType">
                        <span class="badge bg-gradient-success px-3 py-2 rounded-pill" style="font-size: clamp(0.75rem, 1.5vw, 1rem); font-weight: 600; background: linear-gradient(135deg, #0D8F81, #0a6b5f);">{{ ucfirst(e(Auth::user()->user_type ?? 'Customer')) }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Profile Form Card -->
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden transition-all" style="width: 100% !important; margin: 0 auto;">
                <div class="card-header bg-white border-0 pt-4 px-4" style="padding: clamp(0.75rem, 2vw, 1.5rem) clamp(0.75rem, 2vw, 1.5rem) !important;">
                    <ul class="nav nav-tabs card-header-tabs gap-2" id="profileTabs" style="flex-wrap: nowrap !important; overflow-x: auto !important; -webkit-overflow-scrolling: touch; padding-bottom: 2px;">
                        <li class="nav-item" style="flex: 0 0 auto !important;">
                            <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#personalInfo" style="white-space: nowrap !important; font-size: clamp(0.7rem, 2vw, 1.1rem) !important; padding: 0.4rem 1rem !important; border-radius: 40px; color: #2c3e50; border: none; background: #eef2f5; margin-right: 0.5rem; transition: all 0.2s;">
                                <i class="fas fa-user-circle me-2"></i>Personal Information
                            </a>
                        </li>
                        <li class="nav-item" style="flex: 0 0 auto !important;">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#changePassword" style="white-space: nowrap !important; font-size: clamp(0.7rem, 2vw, 1.1rem) !important; padding: 0.4rem 1rem !important; border-radius: 40px; color: #2c3e50; border: none; background: #eef2f5; margin-right: 0.5rem; transition: all 0.2s;">
                                <i class="fas fa-shield-alt me-2"></i>Change Password
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4 p-xl-5" style="padding: clamp(1rem, 3vw, 2rem) !important;">
                    <div class="tab-content">
                        <!-- Personal Info Tab -->
                        <div class="tab-pane fade show active" id="personalInfo">
                            <form id="profileForm" enctype="multipart/form-data" action="/api/update-profile" method="POST" class="needs-validation">
                                @csrf

                                <div class="mb-4 text-center">
                                    <div style="position: relative; display: inline-block;">
                                        <div id="cameraButtonVisual" class="btn btn-outline-primary rounded-circle p-3 transition-all"
                                             style="width: 48px; height: 48px; display: inline-flex; align-items: center; justify-content: center; border-width: 2px; touch-action: manipulation; cursor: pointer;">
                                            <i class="fas fa-camera fa-lg" style="font-size: clamp(1rem, 1.5vw, 1.2rem);"></i>
                                        </div>
                                        <input type="file" id="profile_image" name="profile_image" accept="image/*"
                                               style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; pointer-events: auto; margin: 0; padding: 0; border: 0; z-index: 10;">
                                    </div>
                                    <small class="text-muted d-block mt-2 fw-medium" style="font-size: clamp(0.7rem, 1.5vw, 1rem);">Click the camera to update photo</small>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" style="font-size: clamp(0.85rem, 2.5vw, 1.3rem);">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" name="first_name" id="first_name"
                                               value="{{ e(Auth::user()->first_name ?? '') }}" required
                                               style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important; padding: clamp(0.4rem, 1.5vw, 0.75rem) clamp(0.6rem, 2vw, 1rem) !important;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" style="font-size: clamp(0.85rem, 2.5vw, 1.3rem);">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" name="last_name" id="last_name"
                                               value="{{ e(Auth::user()->last_name ?? '') }}" required
                                               style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important; padding: clamp(0.4rem, 1.5vw, 0.75rem) clamp(0.6rem, 2vw, 1rem) !important;">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold" style="font-size: clamp(0.85rem, 2.5vw, 1.3rem);">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control form-control-lg" name="mobile_number" id="mobile_number"
                                           value="{{ e(Auth::user()->mobile_number ?? '') }}" placeholder="09123456789" maxlength="11" required
                                           style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important; padding: clamp(0.4rem, 1.5vw, 0.75rem) clamp(0.6rem, 2vw, 1rem) !important;">
                                    <small class="text-muted fw-medium" style="font-size: clamp(0.7rem, 1.5vw, 1rem);">Enter 11-digit mobile number (numbers only)</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold" style="font-size: clamp(0.85rem, 2.5vw, 1.3rem);">City <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" name="city" id="city" required
                                            style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important; padding: clamp(0.4rem, 1.5vw, 0.75rem) clamp(0.6rem, 2vw, 1rem) !important;">
                                        <option value="">Select City</option>
                                        <option value="bantayan" {{ Auth::user()->city == 'bantayan' ? 'selected' : '' }}>Bantayan</option>
                                        <option value="escalante" {{ Auth::user()->city == 'escalante' ? 'selected' : '' }}>Escalante</option>
                                        <option value="sagay" {{ Auth::user()->city == 'sagay' ? 'selected' : '' }}>Sagay</option>
                                        <option value="cadiz" {{ Auth::user()->city == 'cadiz' ? 'selected' : '' }}>Cadiz</option>
                                        <option value="victorias" {{ Auth::user()->city == 'victorias' ? 'selected' : '' }}>Victorias</option>
                                        <option value="silay" {{ Auth::user()->city == 'silay' ? 'selected' : '' }}>Silay</option>
                                        <option value="bata" {{ Auth::user()->city == 'bata' ? 'selected' : '' }}>Bata</option>
                                        <option value="bacolod" {{ Auth::user()->city == 'bacolod' ? 'selected' : '' }}>Bacolod</option>
                                        <option value="libertad" {{ Auth::user()->city == 'libertad' ? 'selected' : '' }}>Libertad</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold" style="font-size: clamp(0.85rem, 2.5vw, 1.3rem);">User Type <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" name="user_type" id="user_type" required
                                            style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important; padding: clamp(0.4rem, 1.5vw, 0.75rem) clamp(0.6rem, 2vw, 1rem) !important;">
                                        <option value="customer" {{ Auth::user()->user_type == 'customer' ? 'selected' : '' }}>Customer</option>
                                        <option value="poultry_owner" {{ Auth::user()->user_type == 'poultry_owner' ? 'selected' : '' }}>Poultry Owner</option>
                                    </select>
                                </div>

                                <button type="submit" id="profileSubmitBtn" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm transition-all"
                                        style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important; padding: clamp(0.4rem, 1.5vw, 0.75rem) clamp(1rem, 3vw, 2rem) !important;">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </button>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="changePassword">
                            <form id="passwordForm" class="needs-validation">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label fw-semibold" style="font-size: clamp(0.85rem, 2.5vw, 1.3rem);">Current Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="currentPassword" required
                                               style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important; padding: clamp(0.4rem, 1.5vw, 0.75rem) clamp(0.6rem, 2vw, 1rem) !important;">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#currentPassword"
                                                style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important;">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold" style="font-size: clamp(0.85rem, 2.5vw, 1.3rem);">New Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="newPassword" required
                                               style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important; padding: clamp(0.4rem, 1.5vw, 0.75rem) clamp(0.6rem, 2vw, 1rem) !important;">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#newPassword"
                                                style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important;">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="fw-semibold" style="font-size: clamp(0.7rem, 1.5vw, 1rem);">Password Strength</small>
                                            <small id="strengthText" class="fw-bold" style="font-size: clamp(0.7rem, 1.5vw, 1rem);">—</small>
                                        </div>
                                        <div class="progress shadow-sm" style="height: 8px;">
                                            <div id="strengthBar" class="progress-bar transition-all" role="progressbar" style="width: 0%;"></div>
                                        </div>
                                        <div id="passwordRequirements" class="mt-2 small">
                                            <ul class="list-unstyled mb-0 d-flex flex-wrap gap-3" style="font-size: clamp(0.7rem, 1.5vw, 1rem);">
                                                <li id="req-length" class="text-muted"><i class="fas fa-circle me-1 fa-xs"></i> At least 6 chars</li>
                                                <li id="req-upper" class="text-muted"><i class="fas fa-circle me-1 fa-xs"></i> Uppercase</li>
                                                <li id="req-lower" class="text-muted"><i class="fas fa-circle me-1 fa-xs"></i> Lowercase</li>
                                                <li id="req-digit" class="text-muted"><i class="fas fa-circle me-1 fa-xs"></i> Number</li>
                                                <li id="req-special" class="text-muted"><i class="fas fa-circle me-1 fa-xs"></i> Special char</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <small class="text-muted" style="font-size: clamp(0.7rem, 1.5vw, 1rem);">Minimum 6 characters, use mix of uppercase, lowercase, numbers & symbols for strong password.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold" style="font-size: clamp(0.85rem, 2.5vw, 1.3rem);">Confirm New Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="confirmPassword" required
                                               style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important; padding: clamp(0.4rem, 1.5vw, 0.75rem) clamp(0.6rem, 2vw, 1rem) !important;">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#confirmPassword"
                                                style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important;">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div id="matchFeedback" class="mt-2 small fw-semibold" style="font-size: clamp(0.7rem, 1.5vw, 1rem);"></div>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm transition-all"
                                        style="font-size: clamp(0.85rem, 2.5vw, 1.3rem) !important; padding: clamp(0.4rem, 1.5vw, 0.75rem) clamp(1rem, 3vw, 2rem) !important;">
                                    <i class="fas fa-key me-2"></i>Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style nonce="{{ $csp_nonce }}">
   /* ============================================================
   PROFILE PAGE - DEEPSEEK-STYLE RESPONSIVE STYLES
   ============================================================ */

:root {
    --primary-gradient: linear-gradient(135deg, #0d6efd, #0a58ca);
    --success-gradient: linear-gradient(135deg, #198754, #146c43);
    --shadow-sm: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);

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
}

/* ============================================================
   GLOBAL STYLES
   ============================================================ */
.transition-all {
    transition: all 0.25s ease-in-out;
}

.hover-scale:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1) !important;
}

.btn-primary {
    background: var(--primary-gradient);
    border: none;
    font-weight: 600;
    font-size: var(--font-base);
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
}

.btn-success {
    background: var(--success-gradient);
    border: none;
    font-weight: 600;
    font-size: var(--font-base);
}
.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(25, 135, 84, 0.3);
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.progress-bar {
    background: linear-gradient(90deg, #dc3545, #ffc107, #198754);
    border-radius: 8px;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #0D8F81, #0a6b5f);
}

/* ============================================================
   LAYOUT - CONTAINER & CARDS
   ============================================================ */
.container {
    width: 100% !important;
    max-width: 1200px !important;
    padding-left: var(--sp-lg) !important;
    padding-right: var(--sp-lg) !important;
    margin: 0 auto !important;
}

.card {
    width: 100% !important;
    margin: 0 auto;
    border-radius: 1.25rem !important;
    border: 1px solid rgba(0, 0, 0, 0.05) !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.04) !important;
}

.profile-card {
    max-width: 100% !important;
}

.card-header {
    padding: var(--sp-md) var(--sp-lg) !important;
    background: rgba(13, 110, 253, 0.04) !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
    font-size: var(--font-lg);
    font-weight: 700;
}

.card-body {
    padding: var(--sp-lg) !important;
}

/* ============================================================
   PROFILE IMAGE
   ============================================================ */
.profile-image-preview {
    width: 100px !important;
    height: 100px !important;
    border-radius: 50% !important;
    object-fit: cover !important;
    border: 3px solid #0d6efd !important;
    padding: 3px !important;
    transition: all 0.3s ease !important;
}

.profile-image-preview:hover {
    transform: scale(1.05) !important;
    box-shadow: 0 0 20px rgba(13, 110, 253, 0.3) !important;
}

#displayName {
    font-size: var(--font-xl) !important;
    font-weight: 800 !important;
    letter-spacing: -0.02em !important;
}

.badge {
    font-size: var(--font-sm) !important;
    font-weight: 600 !important;
    padding: 0.4rem 0.8rem !important;
    border-radius: 40px !important;
}

/* ============================================================
   NAVIGATION TABS
   ============================================================ */
.nav-tabs {
    flex-wrap: nowrap !important;
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
    padding-bottom: 2px;
    gap: 0.5rem;
    border-bottom: none !important;
}

.nav-tabs .nav-item {
    flex: 0 0 auto !important;
}

.nav-tabs .nav-link {
    white-space: nowrap !important;
    font-size: var(--font-base) !important;
    font-weight: 500 !important;
    padding: 0.5rem 1.2rem !important;
    border-radius: 40px;
    color: #2c3e50;
    border: none !important;
    background: #eef2f5;
    transition: all 0.2s ease;
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.nav-tabs .nav-link i {
    font-size: var(--font-md);
}

.nav-tabs .nav-link.active {
    background: var(--primary-gradient);
    color: white;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    transform: translateY(-2px);
}

.nav-tabs .nav-link:hover:not(.active) {
    background: #e2e8f0;
    transform: translateY(-2px);
}

/* ============================================================
   FORM ELEMENTS
   ============================================================ */
.form-label {
    font-size: var(--font-base) !important;
    font-weight: 500 !important;
    margin-bottom: var(--sp-xs) !important;
    color: var(--text-dark);
}

.form-control,
.form-select {
    font-size: var(--font-base) !important;
    padding: 0.6rem 0.8rem !important;
    border-radius: 0.75rem !important;
    border: 1.5px solid #e2e8f0 !important;
    background: #ffffff !important;
    transition: all 0.2s ease !important;
    min-height: 44px !important;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

.form-control::placeholder {
    color: #94a3b8 !important;
    font-weight: 400 !important;
}

.input-group-text {
    font-size: var(--font-base) !important;
    background: #f8fafc !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 0.75rem 0 0 0.75rem !important;
    min-height: 44px !important;
}

.input-group .form-control {
    border-radius: 0 0.75rem 0.75rem 0 !important;
}

.btn {
    font-size: var(--font-base) !important;
    font-weight: 600 !important;
    padding: 0.6rem 1.5rem !important;
    border-radius: 0.75rem !important;
    min-height: 44px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
    transition: all 0.2s ease !important;
}

.btn i {
    font-size: var(--font-md);
}

small.text-muted,
.password-requirements-text,
#passwordRequirements li,
#matchFeedback {
    font-size: var(--font-sm) !important;
    font-weight: 400 !important;
    color: #64748b !important;
}

#passwordRequirements li {
    padding: var(--sp-xs) 0 !important;
}

/* ============================================================
   TOAST NOTIFICATION
   ============================================================ */
.toast-notification {
    position: fixed;
    bottom: 25px;
    right: 25px;
    z-index: 9999;
    padding: 14px 28px;
    border-radius: 50px;
    font-weight: 600;
    font-size: var(--font-base);
    backdrop-filter: blur(8px);
    background: rgba(0, 0, 0, 0.85);
    color: white;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    animation: slideInRight 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
}

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

/* ============================================================
   BUTTON LOADING STATE
   ============================================================ */
.btn-loading {
    opacity: 0.7;
    pointer-events: none;
}

.toggle-password {
    cursor: pointer;
}

/* ============================================================
   MODAL
   ============================================================ */
.modal-content {
    border-radius: 1.25rem !important;
    border: none !important;
    box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.2) !important;
}

.modal-header {
    padding: var(--sp-md) var(--sp-lg) !important;
    border-bottom: 1px solid #e2e8f0 !important;
}

.modal-title {
    font-size: var(--font-lg) !important;
    font-weight: 700 !important;
}

.modal-body {
    padding: var(--sp-lg) !important;
    font-size: var(--font-base) !important;
}

.modal-footer {
    padding: var(--sp-md) var(--sp-lg) !important;
    border-top: 1px solid #e2e8f0 !important;
    gap: 0.5rem !important;
}

.modal-footer .btn {
    font-size: var(--font-base) !important;
    padding: 0.5rem 1.2rem !important;
    min-height: 40px !important;
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
    }

    .container {
        padding-left: var(--sp-lg) !important;
        padding-right: var(--sp-lg) !important;
    }

    .nav-tabs .nav-link {
        font-size: var(--font-sm) !important;
        padding: 0.4rem 1rem !important;
        min-height: 36px !important;
    }

    .profile-image-preview {
        width: 90px !important;
        height: 90px !important;
    }

    #displayName {
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
    }

    .container {
        padding-left: var(--sp-md) !important;
        padding-right: var(--sp-md) !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .row.g-4 {
        --bs-gutter-y: var(--sp-md) !important;
        --bs-gutter-x: var(--sp-md) !important;
    }

    .card-body {
        padding: var(--sp-md) !important;
    }

    .card-header {
        padding: var(--sp-sm) var(--sp-md) !important;
        font-size: var(--font-md) !important;
    }

    .nav-tabs {
        gap: 0.4rem;
        padding-bottom: 2px;
    }

    .nav-tabs .nav-link {
        font-size: var(--font-sm) !important;
        padding: 0.35rem 0.8rem !important;
        min-height: 34px !important;
        border-radius: 30px;
    }

    .nav-tabs .nav-link i {
        font-size: var(--font-sm);
    }

    .profile-image-preview {
        width: 80px !important;
        height: 80px !important;
    }

    #displayName {
        font-size: var(--font-lg) !important;
    }

    .badge {
        font-size: var(--font-xs) !important;
        padding: 0.3rem 0.6rem !important;
    }

    .form-label {
        font-size: var(--font-sm) !important;
        margin-bottom: var(--sp-xs) !important;
    }

    .form-control,
    .form-select {
        font-size: var(--font-sm) !important;
        padding: 0.5rem 0.7rem !important;
        min-height: 38px !important;
        border-radius: 0.6rem !important;
    }

    .input-group-text {
        font-size: var(--font-sm) !important;
        min-height: 38px !important;
    }

    .btn {
        font-size: var(--font-sm) !important;
        padding: 0.5rem 1rem !important;
        min-height: 38px !important;
        border-radius: 0.6rem !important;
    }

    .btn i {
        font-size: var(--font-base);
    }

    small.text-muted,
    .password-requirements-text,
    #passwordRequirements li,
    #matchFeedback {
        font-size: var(--font-xs) !important;
    }

    .toast-notification {
        font-size: var(--font-sm) !important;
        padding: 10px 20px !important;
        bottom: 16px !important;
        right: 16px !important;
        min-height: 38px !important;
        border-radius: 40px !important;
    }

    .modal-content {
        border-radius: 1rem !important;
    }

    .modal-header {
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    .modal-title {
        font-size: var(--font-md) !important;
    }

    .modal-body {
        padding: var(--sp-md) !important;
        font-size: var(--font-sm) !important;
    }

    .modal-footer {
        padding: var(--sp-sm) var(--sp-md) !important;
    }

    .modal-footer .btn {
        font-size: var(--font-sm) !important;
        padding: 0.4rem 1rem !important;
        min-height: 36px !important;
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

        --sp-xs: 0.15rem;
        --sp-sm: 0.3rem;
        --sp-md: 0.6rem;
        --sp-lg: 1rem;
        --sp-xl: 1.2rem;
    }

    .container {
        padding-left: var(--sp-sm) !important;
        padding-right: var(--sp-sm) !important;
    }

    .row.g-4 {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .card {
        border-radius: 0.8rem !important;
    }

    .card-body {
        padding: var(--sp-sm) !important;
    }

    .card-header {
        padding: var(--sp-xs) var(--sp-sm) !important;
        font-size: var(--font-sm) !important;
    }

    .nav-tabs {
        gap: 0.3rem;
    }

    .nav-tabs .nav-link {
        font-size: var(--font-xs) !important;
        padding: 0.25rem 0.6rem !important;
        min-height: 30px !important;
        border-radius: 20px;
    }

    .nav-tabs .nav-link i {
        font-size: var(--font-xs);
    }

    .profile-image-preview {
        width: 70px !important;
        height: 70px !important;
        border-width: 2px !important;
    }

    #displayName {
        font-size: var(--font-md) !important;
    }

    .badge {
        font-size: var(--font-xs) !important;
        padding: 0.2rem 0.5rem !important;
    }

    .form-label {
        font-size: var(--font-xs) !important;
        margin-bottom: 0.15rem !important;
    }

    .form-control,
    .form-select {
        font-size: var(--font-xs) !important;
        padding: 0.4rem 0.5rem !important;
        min-height: 34px !important;
        border-radius: 0.5rem !important;
        border-width: 1px !important;
    }

    .input-group-text {
        font-size: var(--font-xs) !important;
        min-height: 34px !important;
        padding: 0.4rem 0.6rem !important;
    }

    .btn {
        font-size: var(--font-xs) !important;
        padding: 0.4rem 0.8rem !important;
        min-height: 34px !important;
        border-radius: 0.5rem !important;
    }

    .btn i {
        font-size: var(--font-sm);
    }

    small.text-muted,
    .password-requirements-text,
    #passwordRequirements li,
    #matchFeedback {
        font-size: 0.6rem !important;
    }

    .toast-notification {
        font-size: var(--font-xs) !important;
        padding: 8px 14px !important;
        bottom: 12px !important;
        right: 12px !important;
        min-height: 34px !important;
        border-radius: 30px !important;
        max-width: 92% !important;
    }

    .modal-content {
        border-radius: 0.8rem !important;
    }

    .modal-header {
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    .modal-title {
        font-size: var(--font-sm) !important;
    }

    .modal-body {
        padding: var(--sp-sm) !important;
        font-size: var(--font-xs) !important;
    }

    .modal-footer {
        padding: var(--sp-xs) var(--sp-sm) !important;
        flex-wrap: wrap;
        gap: 0.3rem !important;
    }

    .modal-footer .btn {
        font-size: var(--font-xs) !important;
        padding: 0.3rem 0.8rem !important;
        min-height: 32px !important;
        flex: 1;
        min-width: 0;
    }

    #passwordRequirements li {
        font-size: 0.6rem !important;
        padding: 0.1rem 0 !important;
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
    }

    .container {
        padding-left: var(--sp-xs) !important;
        padding-right: var(--sp-xs) !important;
    }

    .row.g-4 {
        --bs-gutter-y: var(--sp-xs) !important;
        --bs-gutter-x: var(--sp-xs) !important;
    }

    .card {
        border-radius: 0.6rem !important;
    }

    .card-body {
        padding: var(--sp-xs) !important;
    }

    .card-header {
        padding: 0.15rem var(--sp-xs) !important;
        font-size: var(--font-xs) !important;
    }

    .nav-tabs .nav-link {
        font-size: 0.55rem !important;
        padding: 0.2rem 0.4rem !important;
        min-height: 26px !important;
        border-radius: 16px;
    }

    .nav-tabs .nav-link i {
        font-size: 0.55rem !important;
    }

    .profile-image-preview {
        width: 60px !important;
        height: 60px !important;
        border-width: 2px !important;
        padding: 2px !important;
    }

    #displayName {
        font-size: var(--font-sm) !important;
    }

    .badge {
        font-size: 0.5rem !important;
        padding: 0.15rem 0.4rem !important;
    }

    .form-label {
        font-size: 0.6rem !important;
        margin-bottom: 0.1rem !important;
    }

    .form-control,
    .form-select {
        font-size: 0.6rem !important;
        padding: 0.3rem 0.4rem !important;
        min-height: 30px !important;
        border-radius: 0.4rem !important;
    }

    .input-group-text {
        font-size: 0.6rem !important;
        min-height: 30px !important;
        padding: 0.3rem 0.4rem !important;
    }

    .btn {
        font-size: 0.6rem !important;
        padding: 0.3rem 0.6rem !important;
        min-height: 30px !important;
        border-radius: 0.4rem !important;
    }

    .btn i {
        font-size: 0.6rem !important;
    }

    small.text-muted,
    .password-requirements-text,
    #passwordRequirements li,
    #matchFeedback {
        font-size: 0.5rem !important;
    }

    .toast-notification {
        font-size: 0.6rem !important;
        padding: 6px 12px !important;
        bottom: 8px !important;
        right: 8px !important;
        min-height: 30px !important;
        border-radius: 24px !important;
        max-width: 90% !important;
    }

    .modal-content {
        border-radius: 0.6rem !important;
    }

    .modal-title {
        font-size: var(--font-xs) !important;
    }

    .modal-body {
        padding: var(--sp-xs) !important;
        font-size: 0.6rem !important;
    }

    .modal-footer .btn {
        font-size: 0.6rem !important;
        padding: 0.25rem 0.5rem !important;
        min-height: 28px !important;
    }
}

/* --- Extra Small (≤ 350px) --- */
@media (max-width: 350px) {
    .nav-tabs .nav-link {
        font-size: 0.5rem !important;
        padding: 0.15rem 0.35rem !important;
        min-height: 24px !important;
        border-radius: 14px;
    }

    .profile-image-preview {
        width: 50px !important;
        height: 50px !important;
    }

    #displayName {
        font-size: 0.7rem !important;
    }

    .form-control,
    .form-select {
        font-size: 0.5rem !important;
        padding: 0.2rem 0.3rem !important;
        min-height: 26px !important;
    }

    .btn {
        font-size: 0.5rem !important;
        padding: 0.2rem 0.4rem !important;
        min-height: 26px !important;
    }

    .toast-notification {
        font-size: 0.5rem !important;
        padding: 4px 10px !important;
        bottom: 6px !important;
        right: 6px !important;
        min-height: 26px !important;
        border-radius: 20px !important;
    }

    .modal-footer .btn {
        font-size: 0.5rem !important;
        padding: 0.2rem 0.4rem !important;
        min-height: 24px !important;
    }
}

/* ============================================================
   HIDDEN AUDIO (click only)
   ============================================================ */
#clickAudio {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
    user-select: none;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script nonce="{{ $csp_nonce }}">
// ============================================================
// 0. CLICK SOUND SYSTEM (CSP-friendly, non-blocking)
// ============================================================
(function() {
    var clickAudio = null;
    var audioLoaded = false;
    var audioInitialized = false;

    function initClickAudio() {
        try {
            clickAudio = new Audio('{{ asset("audio/click.mp3") }}');
            clickAudio.preload = 'auto';
            clickAudio.volume = 0.5;
            clickAudio.load();
            audioLoaded = true;
        } catch(e) {
            // Silently fail
        }
    }

    function playClick() {
        if (clickAudio && audioLoaded) {
            try {
                clickAudio.currentTime = 0;
                clickAudio.play().catch(function() {});
            } catch(e) {
                // Silently fail
            }
        }
    }

    function ensureAudioInitialized() {
        if (!audioInitialized) {
            initClickAudio();
            audioInitialized = true;
        }
    }

    document.addEventListener('click', function(e) {
        var target = e.target.closest('a, button, .btn, .nav-link, .toggle-password, #cameraButtonVisual, [href], [role="button"], .form-control, .form-select, .badge');
        if (target) {
            ensureAudioInitialized();
            requestAnimationFrame(function() {
                playClick();
            });
        }
    });
})();

// ===== HELPER FUNCTIONS =====
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

function showToast(message, type) {
    type = type || 'success';
    $('.toast-notification').remove();
    var icon = type === 'danger' ? 'fa-exclamation-triangle' : 'fa-check-circle';
    var bgGradient = type === 'danger' ? 'linear-gradient(135deg, #dc3545, #b02a37)' : 'linear-gradient(135deg, #198754, #146c43)';
    var toastHtml = '<div class="toast-notification shadow-lg" style="background: ' + bgGradient + ';"><i class="fas ' + icon + ' me-2"></i>' + escapeHtml(message) + '</div>';
    $('body').append(toastHtml);
    setTimeout(function() {
        $('.toast-notification').fadeOut(300, function() { $(this).remove(); });
    }, 4000);
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

function sanitizeName(str) {
    if (!str) return '';
    return str.replace(/[^A-Za-z\s\-']/g, '').trim();
}

function isValidMobile(mobile) {
    return /^09\d{9}$/.test(mobile);
}

function updateProfileImagePreview(imageUrl) {
    var $img = $('#profileImagePreview');
    var fullName = escapeHtml($('#displayName').text() || 'User');
    var encodedName = encodeURIComponent(fullName);
    var defaultAvatar = 'https://ui-avatars.com/api/?name=' + encodedName + '&background=0D8F81&color=fff&size=120&bold=true';
    if (imageUrl && !imageUrl.includes('ui-avatars.com')) {
        if (imageUrl.startsWith('http://') || imageUrl.startsWith('https://')) {
            $img.attr('src', imageUrl);
        } else {
            $img.attr('src', defaultAvatar);
        }
    } else {
        $img.attr('src', defaultAvatar);
    }
}

// Password strength and match
function evaluatePasswordStrength(password) {
    var strength = 0;
    var checks = {
        length: password.length >= 6,
        upper: /[A-Z]/.test(password),
        lower: /[a-z]/.test(password),
        digit: /\d/.test(password),
        special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
    };
    if (checks.length) strength++;
    if (checks.upper) strength++;
    if (checks.lower) strength++;
    if (checks.digit) strength++;
    if (checks.special) strength++;

    $('#req-length').html('<i class="fas ' + (checks.length ? 'fa-check-circle text-success' : 'fa-circle text-muted') + ' me-1 fa-xs"></i> At least 6 chars');
    $('#req-upper').html('<i class="fas ' + (checks.upper ? 'fa-check-circle text-success' : 'fa-circle text-muted') + ' me-1 fa-xs"></i> Uppercase');
    $('#req-lower').html('<i class="fas ' + (checks.lower ? 'fa-check-circle text-success' : 'fa-circle text-muted') + ' me-1 fa-xs"></i> Lowercase');
    $('#req-digit').html('<i class="fas ' + (checks.digit ? 'fa-check-circle text-success' : 'fa-circle text-muted') + ' me-1 fa-xs"></i> Number');
    $('#req-special').html('<i class="fas ' + (checks.special ? 'fa-check-circle text-success' : 'fa-circle text-muted') + ' me-1 fa-xs"></i> Special char');

    var strengthText = '', width = 0, barColor = '';
    if (strength <= 2) { strengthText = 'Weak'; width = 25; barColor = '#dc3545'; }
    else if (strength <= 3) { strengthText = 'Moderate'; width = 55; barColor = '#ffc107'; }
    else { strengthText = 'Strong'; width = 100; barColor = '#198754'; }

    $('#strengthText').text(strengthText).css('color', barColor);
    $('#strengthBar').css('width', width + '%').css('background', barColor);
    return strength;
}

function checkPasswordMatch() {
    var newPwd = $('#newPassword').val();
    var confirmPwd = $('#confirmPassword').val();
    if (confirmPwd === '') {
        $('#matchFeedback').html('').removeClass('text-success text-danger');
        return false;
    }
    if (newPwd === confirmPwd) {
        $('#matchFeedback').html('<i class="fas fa-check-circle me-1"></i> Passwords match!').addClass('text-success').removeClass('text-danger');
        return true;
    } else {
        $('#matchFeedback').html('<i class="fas fa-times-circle me-1"></i> Passwords do not match').addClass('text-danger').removeClass('text-success');
        return false;
    }
}

$(document).ready(function() {
    // ========== IMAGE PICKER - FIXED: Properly handle file upload ==========
    var $fileInput = $('#profile_image');
    var $imagePreview = $('#profileImagePreview');
    var selectedFile = null;

    // When a file is selected, show preview
    $fileInput.on('change', function(e) {
        var file = e.target.files[0];
        if (!file) return;

        // Validate file
        if (file.size > 2 * 1024 * 1024) {
            showToast('Image size must be less than 2MB', 'danger');
            this.value = '';
            return;
        }

        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type.toLowerCase())) {
            showToast('Only JPG, PNG, and GIF images are allowed', 'danger');
            this.value = '';
            return;
        }

        selectedFile = file;

        // Preview the image
        var reader = new FileReader();
        reader.onload = function(ev) {
            $imagePreview.attr('src', ev.target.result);
            showToast('Image selected! Click Update Profile to save.', 'success');
        };
        reader.readAsDataURL(file);
    });

    // Click on camera icon triggers file input
    $('#cameraButtonVisual').on('click', function(e) {
        e.preventDefault();
        $fileInput.click();
    });

    // ========== PROFILE FORM VALIDATIONS ==========
    $('#mobile_number').on('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 11);
        var val = this.value.trim();
        if (val.length > 0 && !isValidMobile(val)) {
            $(this).addClass('is-invalid').removeClass('is-valid');
        } else if (isValidMobile(val)) {
            $(this).addClass('is-valid').removeClass('is-invalid');
        } else {
            $(this).removeClass('is-valid is-invalid');
        }
    });

    function sanitizeNameInput(inputElement) {
        var rawValue = inputElement.value;
        var sanitized = rawValue.replace(/[^A-Za-z\s\-']/g, '');
        if (sanitized !== rawValue) inputElement.value = sanitized;
    }
    $('#first_name, #last_name').on('input', function() { sanitizeNameInput(this); });

    // ========== PROFILE FORM SUBMIT - FULLY FIXED ==========
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();

        var firstName = $('#first_name').val().trim();
        var lastName = $('#last_name').val().trim();
        var mobile = $('#mobile_number').val().trim();

        // Sanitize inputs
        firstName = sanitizeName(firstName);
        lastName = sanitizeName(lastName);

        if (!firstName || firstName.length < 2 || firstName.length > 50) {
            showToast('First name must be 2-50 characters and contain only letters, spaces, hyphens, or apostrophes', 'danger');
            return;
        }
        if (!lastName || lastName.length < 2 || lastName.length > 50) {
            showToast('Last name must be 2-50 characters and contain only letters, spaces, hyphens, or apostrophes', 'danger');
            return;
        }
        if (!mobile || !isValidMobile(mobile)) {
            showToast('Mobile number must be exactly 11 digits starting with 09 (e.g., 09123456789)', 'danger');
            return;
        }

        // Update form values with sanitized data
        $('#first_name').val(firstName);
        $('#last_name').val(lastName);
        $('#mobile_number').val(mobile);

        var formData = new FormData(this);
        var submitBtn = $(this).find('button[type="submit"]');
        var originalHtml = submitBtn.html();

        // Disable button and show loading state
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...').addClass('btn-loading');

        // Get the update URL
        var updateUrl = $(this).attr('action');
        if (!updateUrl || updateUrl === '') {
            updateUrl = '/api/update-profile';
        }

        console.log('Submitting to URL:', updateUrl);

        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(response) {
                console.log('Profile update success:', response);
                if (response.success) {
                    showToast('Profile updated successfully!', 'success');

                    // Update display name
                    var fullName = escapeHtml(response.user.full_name);
                    $('#displayName').text(fullName);

                    // Update user type badge
                    var userTypeText = response.user.user_type.charAt(0).toUpperCase() + response.user.user_type.slice(1);
                    $('#displayType').html('<span class="badge bg-gradient-success px-3 py-2 rounded-pill" style="font-size: clamp(0.75rem, 1.5vw, 1rem); font-weight: 600; background: linear-gradient(135deg, #0D8F81, #0a6b5f);">' + escapeHtml(userTypeText) + '</span>');

                    // Update profile image
                    if (response.user.profile_image_url) {
                        var imgUrl = response.user.profile_image_url;
                        if (!imgUrl.includes('ui-avatars.com')) {
                            imgUrl += '?t=' + new Date().getTime();
                        }
                        updateProfileImagePreview(imgUrl);
                    } else {
                        updateProfileImagePreview(null);
                    }

                    // Reset file input
                    $fileInput.val('');
                    selectedFile = null;

                    // Update the form values with the response data
                    $('#first_name').val(response.user.first_name);
                    $('#last_name').val(response.user.last_name);
                    $('#mobile_number').val(response.user.mobile_number);
                    $('#city').val(response.user.city);
                    $('#user_type').val(response.user.user_type);
                } else {
                    showToast(escapeHtml(response.error || 'Update failed'), 'danger');
                }
            },
            error: function(xhr) {
                console.error('Profile update error:', xhr);

                var errorMessage = 'Error updating profile';

                try {
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var firstError = Object.values(errors).flat()[0];
                            if (firstError) {
                                errorMessage = firstError;
                            }
                        } else if (xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        } else if (xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }

                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your connection.';
                } else if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page.';
                } else if (xhr.status === 422) {
                    errorMessage = 'Validation failed. Please check your inputs.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please check the logs.';
                }

                showToast(escapeHtml(errorMessage), 'danger');
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                submitBtn.html(originalHtml).removeClass('btn-loading');
            }
        });
    });

    // ========== PASSWORD CHANGE ==========
    $('#newPassword').on('input', function() {
        evaluatePasswordStrength($(this).val());
        checkPasswordMatch();
    });
    $('#confirmPassword').on('input', checkPasswordMatch);

    $('#passwordForm').on('submit', function(e) {
        e.preventDefault();
        var currentPwd = $('#currentPassword').val();
        var newPwd = $('#newPassword').val();
        var confirmPwd = $('#confirmPassword').val();

        if (!currentPwd || currentPwd.trim() === '') {
            showToast('Current password is required', 'danger');
            return;
        }
        if (!newPwd || newPwd.trim() === '') {
            showToast('New password is required', 'danger');
            return;
        }
        if (newPwd !== confirmPwd) {
            showToast('New passwords do not match', 'danger');
            return;
        }
        if (newPwd.length < 6) {
            showToast('Password must be at least 6 characters', 'danger');
            return;
        }
        if (newPwd !== newPwd.trim()) {
            showToast('Password cannot contain leading or trailing spaces', 'danger');
            return;
        }

        var strength = evaluatePasswordStrength(newPwd);
        if (strength <= 2) {
            if (!confirm('Your new password is weak. Are you sure you want to continue?')) return;
        }

        var submitBtn = $(this).find('button[type="submit"]');
        var originalHtml = submitBtn.html();
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Changing...').addClass('btn-loading');

        $.ajax({
            url: '/api/change-password',
            method: 'POST',
            data: JSON.stringify({
                current_password: currentPwd,
                new_password: newPwd,
                new_password_confirmation: confirmPwd
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    showToast('Password changed successfully!', 'success');
                    $('#passwordForm')[0].reset();
                    $('#strengthBar').css('width', '0%');
                    $('#strengthText').text('—');
                    $('#matchFeedback').html('');
                    $('#passwordRequirements li').html('<i class="fas fa-circle text-muted me-1 fa-xs"></i> At least 6 chars');
                } else {
                    showToast(escapeHtml(response.error || 'Failed to change password'), 'danger');
                }
            },
            error: function(xhr) {
                console.error('Password change error:', xhr);
                var error = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Error changing password';
                showToast(escapeHtml(error), 'danger');
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                submitBtn.html(originalHtml).removeClass('btn-loading');
            }
        });
    });

    // ========== TOGGLE PASSWORD VISIBILITY ==========
    $('.toggle-password').on('click', function() {
        var target = $(this).data('target');
        var input = $(target);
        var type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    // ========== ENSURE CSRF TOKEN ==========
    if (!document.querySelector('meta[name="csrf-token"]')) {
        var meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = '{{ csrf_token() }}';
        document.head.appendChild(meta);
    }

    console.log('Profile form initialized - FIXED VERSION');
    console.log('File input ID: profile_image');
});
</script>
@endsection
