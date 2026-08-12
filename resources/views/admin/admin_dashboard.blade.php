@extends('admin.layouts.app')

@section('title', 'Dashboard - SureCargo Admin')
@section('page-title', 'Charts Oversight')

@section('content')
<!-- STAT CARDS (White/Red/Green) - Total Delivered Sales Removed -->
<div class="row g-4 mb-5">
    <div class="col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label mb-1">Total Admins</p>
                    <h2 class="mb-1">{{ $stats['total_admins'] ?? 0 }}</h2>
                    <small class="text-success"><i class="fas fa-arrow-up"></i> +12% this month</small>
                </div>
                <div class="stat-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12Z" stroke="#DC2626" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M5 20V19C5 15.13 8.13 12 12 12C15.87 12 19 15.13 19 19V20" stroke="#DC2626" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label mb-1">Total Users</p>
                    <h2 class="mb-1">{{ $totalUsers ?? 0 }}</h2>
                    <small class="text-success"><i class="fas fa-arrow-up"></i> +5% this week</small>
                </div>
                <div class="stat-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 21V19C17 16.79 15.21 15 13 15H5C2.79 15 1 16.79 1 19V21" stroke="#16A34A" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="#16A34A" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M23 21V19C22.9982 16.8582 21.3052 15.0613 19.18 14.94" stroke="#16A34A" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M16 3.13C18.0881 3.50084 19.6575 5.26778 19.774 7.38C19.7755 7.44145 19.7755 7.50321 19.774 7.56463" stroke="#16A34A" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label mb-1">Total Trucks</p>
                    <h2 class="mb-1">{{ $totalTrucks ?? 0 }}</h2>
                    <small class="text-info"><i class="fas fa-truck-moving"></i> Active fleet</small>
                </div>
                <div class="stat-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 5H19L22 9V15H20" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M4 5H15V15H4V5Z" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M22 15H18V13H22V15Z" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <circle cx="7" cy="18" r="2" stroke="#8B5CF6" stroke-width="1.8" fill="none"/>
                        <circle cx="17" cy="18" r="2" stroke="#8B5CF6" stroke-width="1.8" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row with Maximize & PDF Export -->
<div class="row g-4 mb-5">
    <div class="col-lg-8">
        <div class="chart-container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h5 class="mb-0">Admin Activity Trends</h5>
                <div class="d-flex gap-2">
                    <span class="badge-blue-soft"><i class="fas fa-chart-line me-1"></i> Last 7 days</span>
                    <button class="btn btn-sm btn-outline-secondary maximize-chart-btn" data-chart="activity">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 3H5C3.89543 3 3 3.89543 3 5V8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 3H19C20.1046 3 21 3.89543 21 5V8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 21H19C20.1046 21 21 20.1046 21 19V16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 21H5C3.89543 21 3 20.1046 3 19V16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="btn btn-sm btn-outline-danger export-chart-pdf-btn" data-chart="activity" data-title="Admin Activity Trends">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 16V4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 12L12 16L16 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 20H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
            <canvas id="activityChart" style="max-height: 300px; width: 100%;"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="chart-container h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h5 class="mb-0">Admin Role Distribution</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-secondary maximize-chart-btn" data-chart="role">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 3H5C3.89543 3 3 3.89543 3 5V8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 3H19C20.1046 3 21 3.89543 21 5V8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 21H19C20.1046 21 21 20.1046 21 19V16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 21H5C3.89543 21 3 20.1046 3 19V16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="btn btn-sm btn-outline-danger export-chart-pdf-btn" data-chart="role" data-title="Admin Role Distribution">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 16V4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 12L12 16L16 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 20H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
            <canvas id="roleChart" style="max-height: 240px; width: 100%;"></canvas>
            <div class="mt-3 text-center small text-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-right: 4px;">
                    <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M7 11V7C7 5.89543 7.89543 5 9 5H15C16.1046 5 17 5.89543 17 7V11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                RBAC Active
            </div>
        </div>
    </div>
</div>

<!-- NEW ROW: Daily Approved Payments (Bar Graph) + Most Active Users -->
<div class="row g-4 mb-5">
    <div class="col-lg-6">
        <div class="chart-container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h5 class="mb-0">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 8px;">
                        <path d="M4 20H20" stroke="#16A34A" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M6 16L10 8L14 12L18 4" stroke="#16A34A" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 8H22V4" stroke="#16A34A" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Daily Approved Payments (₱) – Bar Graph
                </h5>
                <div class="d-flex gap-2">
                    <span class="badge-green-soft">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-right: 4px;">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M8 2V6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M16 2V6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M3 10H21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        Last 7 days
                    </span>
                    <button class="btn btn-sm btn-outline-secondary maximize-chart-btn" data-chart="payments">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 3H5C3.89543 3 3 3.89543 3 5V8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 3H19C20.1046 3 21 3.89543 21 5V8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 21H19C20.1046 21 21 20.1046 21 19V16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 21H5C3.89543 21 3 20.1046 3 19V16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="btn btn-sm btn-outline-danger export-chart-pdf-btn" data-chart="payments" data-title="Daily Approved Payments">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 16V4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 12L12 16L16 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 20H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div style="position: relative;">
                <canvas id="dailyPaymentsBarChart" style="max-height: 340px; width: 100%;"></canvas>
                <div id="noPaymentsOverlay" class="text-center text-muted d-none" style="position: absolute; top: 50%; left: 0; right: 0; transform: translateY(-50%); background: rgba(255,255,255,0.8); padding: 20px;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto 8px;">
                        <path d="M4 20H20" stroke="#475569" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M6 16L10 8L14 12L18 4" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 8H22V4" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    No approved payments data available
                </div>
            </div>
            <div class="text-center small text-secondary mt-3">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-right: 4px;">
                    <path d="M4 20H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M6 16L10 8L14 12L18 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18 8H22V4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Daily total of approved payments
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="chart-container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h5 class="mb-0">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 8px;">
                        <path d="M12 2V4" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M12 20V22" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M4 12H2" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M22 12H20" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round"/>
                        <circle cx="12" cy="12" r="3" stroke="#8B5CF6" stroke-width="1.8"/>
                        <path d="M19.07 4.92993L17.66 6.33993" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M6.33998 17.66L4.92998 19.07" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M17.66 17.66L19.07 19.07" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M6.33998 6.33993L4.92998 4.92993" stroke="#8B5CF6" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    Most Active Users by Bookings
                </h5>
                <div class="d-flex gap-2">
                    <span class="badge-blue-soft">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-right: 4px;">
                            <path d="M12 2L15 9H22L16 14L19 21L12 16.5L5 21L8 14L2 9H9L12 2Z" stroke="currentColor" stroke-width="1.8" fill="none"/>
                        </svg>
                        Top 5 users
                    </span>
                    <button class="btn btn-sm btn-outline-secondary maximize-chart-btn" data-chart="users">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 3H5C3.89543 3 3 3.89543 3 5V8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 3H19C20.1046 3 21 3.89543 21 5V8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 21H19C20.1046 21 21 20.1046 21 19V16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 21H5C3.89543 21 3 20.1046 3 19V16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="btn btn-sm btn-outline-danger export-chart-pdf-btn" data-chart="users" data-title="Most Active Users">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 16V4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 12L12 16L16 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 20H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
            <canvas id="topUsersChart" style="max-height: 340px; width: 100%;"></canvas>
            <div class="text-center small text-secondary mt-3">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-right: 4px;">
                    <path d="M3 17L9 11L13 15L21 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Total bookings per user
            </div>
        </div>
    </div>
</div>

<!-- Maximize Modals for each chart -->
<div class="modal fade" id="activityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Admin Activity Trends (Maximized)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <canvas id="activityModalCanvas" style="max-height: 70vh; width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Admin Role Distribution (Maximized)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <canvas id="roleModalCanvas" style="max-height: 70vh; width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="paymentsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Daily Approved Payments (Maximized)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <canvas id="paymentsModalCanvas" style="max-height: 70vh; width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="usersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Most Active Users (Maximized)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <canvas id="usersModalCanvas" style="max-height: 70vh; width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ========== NEW PDF EXPORT MODAL ========== -->
<div class="modal fade" id="pdfExportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Export Chart as PDF</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <p class="text-secondary mb-2" style="font-weight: 500;">Chart: <span id="pdfExportChartTitle" class="fw-bold text-dark"></span></p>
                    </div>
                    <div class="col-12">
                        <div class="border rounded p-3 bg-light text-center">
                            <img id="pdfExportPreview" src="" alt="Chart Preview" class="img-fluid" style="max-height: 350px; width: auto; margin: 0 auto;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Page Orientation</label>
                        <select id="pdfOrientation" class="form-select form-select-lg">
                            <option value="landscape">Landscape</option>
                            <option value="portrait">Portrait</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Page Size</label>
                        <select id="pdfPageSize" class="form-select form-select-lg">
                            <option value="a4">A4</option>
                            <option value="letter">Letter</option>
                            <option value="legal">Legal</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-lg btn-danger" id="pdfDownloadBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline; margin-right: 6px;">
                        <path d="M12 16V4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 12L12 16L16 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 20H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<style nonce="{{ $csp_nonce }}">
@import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap');

* {
    font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, 'Poppins', sans-serif;
}

body, .admin-dashboard, .container-fluid, main {
    background: #F8FAFC;
}

/* ============================================================
   GLOBAL TYPOGRAPHY ROOT - Violet Theme
   DEEPSEEK-STYLE FONT SIZES
   ============================================================ */
:root {
    --primary-violet: #7b1fa2;
    --secondary-violet: #9c27b0;
    --light-violet: #f3e5f5;
    --violet-dark: #4a148c;
    --violet-lighter: #faf8ff;
    --bg-white: #FFFFFF;
    --bg-soft: #F8FAFC;
    --text-primary: #2c2c3e;
    --text-secondary: #6c6c80;
    --border: #d1c4e9;
    --hover-border: #7b1fa2;
    --shadow-sm: 0 8px 20px rgba(123, 31, 162, 0.08);
    --shadow-md: 0 15px 35px rgba(123, 31, 162, 0.12);
    --shadow-hover: 0 20px 40px rgba(123, 31, 162, 0.15);
    --radius-card: 24px;
    --radius-chart: 20px;
    --transition-smooth: all 0.25s cubic-bezier(0.2, 0, 0, 1);

    /* DEEPSEEK-STYLE FONT SIZES */
    --font-xs: 0.75rem;
    --font-sm: 0.875rem;
    --font-base: 1rem;
    --font-md: 1.125rem;
    --font-lg: 1.25rem;
    --font-xl: 1.5rem;
    --font-xxl: 1.75rem;

    --sp-xs: 0.25rem;
    --sp-sm: 0.5rem;
    --sp-md: 1rem;
    --sp-lg: 1.5rem;
    --sp-xl: 2rem;
}

/* Cards */
.stat-card {
    background: var(--bg-white);
    border-radius: var(--radius-card);
    padding: var(--sp-xl) var(--sp-lg);
    transition: var(--transition-smooth);
    border: 1px solid var(--border);
    backdrop-filter: blur(0px);
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-hover);
    border-color: var(--hover-border);
}

.stat-label {
    font-size: var(--font-base);
    font-weight: 600;
    color: var(--text-secondary);
    letter-spacing: -0.01em;
    margin-bottom: var(--sp-sm);
}

.stat-card h2 {
    font-size: var(--font-xxl);
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: var(--sp-xs);
    letter-spacing: -0.02em;
}

.stat-card small {
    font-size: var(--font-sm);
    font-weight: 400;
    color: var(--text-secondary);
}

.stat-icon svg {
    width: 56px;
    height: 56px;
    opacity: 0.85;
}

/* Chart Containers */
.chart-container {
    background: var(--bg-white);
    border-radius: var(--radius-chart);
    padding: var(--sp-lg) var(--sp-lg) var(--sp-lg) var(--sp-lg);
    transition: var(--transition-smooth);
    border: 1px solid var(--border);
    height: 100%;
}

.chart-container:hover {
    box-shadow: var(--shadow-hover);
    transform: scale(1.01);
}

.chart-container h5 {
    font-size: var(--font-md);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.01em;
    display: flex;
    align-items: center;
}

.badge-blue-soft, .badge-green-soft {
    font-size: var(--font-sm);
    font-weight: 600;
    padding: var(--sp-xs) var(--sp-md);
    border-radius: 100px;
    background: var(--light-violet);
    color: var(--primary-violet);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.badge-green-soft {
    background: var(--light-violet);
    color: var(--primary-violet);
}

/* Buttons */
.maximize-chart-btn, .export-chart-pdf-btn {
    background: transparent;
    border: 1px solid var(--border);
    border-radius: 40px;
    padding: var(--sp-xs) var(--sp-md);
    transition: var(--transition-smooth);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: var(--font-sm);
    font-weight: 600;
    color: var(--text-secondary);
    min-height: 38px;
}

.maximize-chart-btn:hover {
    background: var(--light-violet);
    border-color: var(--primary-violet);
    color: var(--primary-violet);
    transform: scale(1.02);
}

.export-chart-pdf-btn:hover {
    background: var(--primary-violet);
    border-color: var(--primary-violet);
    color: white;
    transform: scale(1.02);
}

/* Modal enhancements - Violet Theme */
.modal-content {
    border-radius: 28px;
    border: none;
    overflow: hidden;
    background: var(--bg-white);
}

.modal-header {
    background: linear-gradient(135deg, #4a148c 0%, #7b1fa2 100%);
    padding: var(--sp-lg) var(--sp-xl);
    border-bottom: none;
}

.modal-header .modal-title {
    font-size: var(--font-lg);
    font-weight: 700;
    letter-spacing: -0.01em;
    color: #ffffff;
}

.modal-body {
    padding: var(--sp-xl);
    background: var(--bg-white);
}

/* Animation */
@keyframes fadeSlideIn {
    from { opacity: 0; transform: translateY(-12px); }
    to { opacity: 1; transform: translateY(0); }
}

.stat-card, .chart-container {
    animation: fadeSlideIn 0.5s ease backwards;
}

.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.1s; }
.stat-card:nth-child(3) { animation-delay: 0.15s; }
.chart-container {
    animation-delay: 0.2s;
}

/* ============================================================
   RESPONSIVE - DEEPSEEK STYLE
   ============================================================ */

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

        --sp-xs: 0.25rem;
        --sp-sm: 0.5rem;
        --sp-md: 0.9rem;
        --sp-lg: 1.3rem;
        --sp-xl: 1.7rem;
    }

    .stat-card {
        padding: var(--sp-lg) var(--sp-md);
    }

    .stat-label {
        font-size: var(--font-sm);
    }

    .stat-card h2 {
        font-size: var(--font-xl);
    }

    .chart-container {
        padding: var(--sp-md);
    }

    .chart-container h5 {
        font-size: var(--font-base);
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

    .stat-card {
        padding: var(--sp-md);
        border-radius: 20px;
    }

    .stat-label {
        font-size: var(--font-sm);
    }

    .stat-card h2 {
        font-size: var(--font-lg);
    }

    .stat-card small {
        font-size: var(--font-xs);
    }

    .stat-icon svg {
        width: 40px;
        height: 40px;
    }

    .chart-container {
        padding: var(--sp-md);
        border-radius: 16px;
    }

    .chart-container h5 {
        font-size: var(--font-base);
    }

    .badge-blue-soft, .badge-green-soft {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
    }

    .maximize-chart-btn, .export-chart-pdf-btn {
        font-size: var(--font-xs);
        padding: var(--sp-xs) var(--sp-sm);
        min-height: 32px;
    }

    .modal-header {
        padding: var(--sp-sm) var(--sp-md);
    }

    .modal-header .modal-title {
        font-size: var(--font-base);
    }

    .modal-body {
        padding: var(--sp-md);
    }

    .modal-footer .btn {
        font-size: var(--font-sm) !important;
        min-height: 38px !important;
    }

    canvas {
        max-height: 250px !important;
    }

    #activityChart {
        max-height: 250px !important;
    }

    #roleChart {
        max-height: 200px !important;
    }

    #dailyPaymentsBarChart {
        max-height: 250px !important;
    }

    #topUsersChart {
        max-height: 250px !important;
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

        --sp-xs: 0.15rem;
        --sp-sm: 0.3rem;
        --sp-md: 0.6rem;
        --sp-lg: 1rem;
        --sp-xl: 1.2rem;
    }

    .stat-card {
        padding: var(--sp-sm);
        border-radius: 16px;
    }

    .stat-label {
        font-size: var(--font-xs);
        margin-bottom: var(--sp-xs);
    }

    .stat-card h2 {
        font-size: var(--font-md);
    }

    .stat-card small {
        font-size: 0.6rem;
    }

    .stat-icon svg {
        width: 32px;
        height: 32px;
    }

    .chart-container {
        padding: var(--sp-sm);
        border-radius: 12px;
    }

    .chart-container h5 {
        font-size: var(--font-sm);
    }

    .badge-blue-soft, .badge-green-soft {
        font-size: 0.6rem;
        padding: 0.1rem var(--sp-xs);
    }

    .maximize-chart-btn, .export-chart-pdf-btn {
        font-size: 0.6rem;
        padding: 0.1rem var(--sp-xs);
        min-height: 28px;
    }

    .maximize-chart-btn svg,
    .export-chart-pdf-btn svg {
        width: 16px;
        height: 16px;
    }

    .modal-header .modal-title {
        font-size: var(--font-sm);
    }

    .modal-body {
        padding: var(--sp-sm);
    }

    .modal-footer .btn {
        font-size: var(--font-xs) !important;
        min-height: 34px !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
    }

    .row.g-4 {
        --bs-gutter-y: var(--sp-sm) !important;
        --bs-gutter-x: var(--sp-sm) !important;
    }

    .row.g-4.mb-5 {
        margin-bottom: var(--sp-lg) !important;
    }

    canvas {
        max-height: 200px !important;
    }

    #activityChart {
        max-height: 200px !important;
    }

    #roleChart {
        max-height: 180px !important;
    }

    #dailyPaymentsBarChart {
        max-height: 200px !important;
    }

    #topUsersChart {
        max-height: 200px !important;
    }

    .chart-container .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: var(--sp-xs);
    }

    .chart-container .d-flex .d-flex {
        flex-direction: row;
        flex-wrap: wrap;
    }

    .modal-xl {
        max-width: 95% !important;
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

        --sp-xs: 0.1rem;
        --sp-sm: 0.25rem;
        --sp-md: 0.5rem;
        --sp-lg: 0.8rem;
        --sp-xl: 1rem;
    }

    .stat-card h2 {
        font-size: var(--font-sm);
    }

    .stat-label {
        font-size: 0.55rem;
    }

    .stat-icon svg {
        width: 28px;
        height: 28px;
    }

    .chart-container h5 {
        font-size: 0.65rem;
    }

    .badge-blue-soft, .badge-green-soft {
        font-size: 0.5rem;
    }

    .maximize-chart-btn, .export-chart-pdf-btn {
        font-size: 0.5rem;
        min-height: 24px;
    }

    .maximize-chart-btn svg,
    .export-chart-pdf-btn svg {
        width: 14px;
        height: 14px;
    }

    .modal-footer .btn {
        font-size: 0.5rem !important;
        min-height: 30px !important;
    }

    canvas {
        max-height: 160px !important;
    }

    #roleChart {
        max-height: 150px !important;
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

        --sp-xs: 0.05rem;
        --sp-sm: 0.2rem;
        --sp-md: 0.4rem;
        --sp-lg: 0.6rem;
        --sp-xl: 0.8rem;
    }

    .stat-card {
        padding: 0.1rem;
    }

    .stat-card h2 {
        font-size: 0.6rem !important;
    }

    .stat-label {
        font-size: 0.45rem;
    }

    .chart-container {
        padding: 0.1rem;
    }

    .chart-container h5 {
        font-size: 0.55rem;
    }

    .modal-footer .btn {
        font-size: 0.4rem !important;
        min-height: 26px !important;
    }
}

canvas {
    max-width: 100%;
    height: auto;
}

.modal-xl {
    max-width: 90%;
}

/* PDF modal preview */
#pdfExportPreview {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(123, 31, 162, 0.05);
}

/* PDF modal form elements */
#pdfExportModal .form-label {
    font-size: var(--font-base) !important;
    font-weight: 600 !important;
}

#pdfExportModal .form-select {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-md) !important;
    min-height: 42px;
    border-radius: 12px;
}

#pdfExportModal .modal-footer .btn {
    font-size: var(--font-base) !important;
    padding: var(--sp-sm) var(--sp-xl) !important;
    min-height: 44px !important;
}

@media (max-width: 576px) {
    #pdfExportModal .form-label {
        font-size: var(--font-xs) !important;
    }
    #pdfExportModal .form-select {
        font-size: var(--font-xs) !important;
        min-height: 34px;
    }
    #pdfExportModal .modal-footer .btn {
        font-size: var(--font-xs) !important;
        min-height: 34px !important;
        padding: var(--sp-xs) var(--sp-sm) !important;
    }
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script nonce="{{ $csp_nonce }}">
    // ==================== RESPONSIVE FONT HELPER ====================
    function getResponsiveChartFonts() {
        const width = window.innerWidth;

        let sizes = {
            title: 14,
            legend: 14,
            tick: 13,
            tooltipTitle: 14,
            tooltipBody: 13,
            axisTitle: 14,
            doughnutCutout: '65%',
            barRadius: 10,
            pointRadius: 6,
            padding: 12
        };

        // Tablet (769px - 1024px)
        if (width >= 769 && width <= 1024) {
            sizes.title = 12;
            sizes.legend = 12;
            sizes.tick = 11;
            sizes.tooltipTitle = 12;
            sizes.tooltipBody = 11;
            sizes.axisTitle = 12;
            sizes.doughnutCutout = '60%';
            sizes.barRadius = 8;
            sizes.pointRadius = 5;
            sizes.padding = 10;
        }
        // Mobile (≤ 768px)
        else if (width <= 768) {
            sizes.title = 10;
            sizes.legend = 10;
            sizes.tick = 9;
            sizes.tooltipTitle = 10;
            sizes.tooltipBody = 9;
            sizes.axisTitle = 10;
            sizes.doughnutCutout = '55%';
            sizes.barRadius = 6;
            sizes.pointRadius = 4;
            sizes.padding = 8;
        }
        // Small phones (≤ 576px)
        else if (width <= 576) {
            sizes.title = 8;
            sizes.legend = 8;
            sizes.tick = 7;
            sizes.tooltipTitle = 8;
            sizes.tooltipBody = 7;
            sizes.axisTitle = 8;
            sizes.doughnutCutout = '50%';
            sizes.barRadius = 4;
            sizes.pointRadius = 3;
            sizes.padding = 6;
        }
        // Very small phones (≤ 400px)
        else if (width <= 400) {
            sizes.title = 7;
            sizes.legend = 7;
            sizes.tick = 6;
            sizes.tooltipTitle = 7;
            sizes.tooltipBody = 6;
            sizes.axisTitle = 7;
            sizes.doughnutCutout = '45%';
            sizes.barRadius = 3;
            sizes.pointRadius = 2;
            sizes.padding = 4;
        }

        return sizes;
    }

    // ==================== GLOBAL CHART RULE - Violet Theme ====================
    const fontSizes = getResponsiveChartFonts();
    Chart.defaults.font.size = fontSizes.title;
    Chart.defaults.font.weight = '600';
    Chart.defaults.color = '#2c2c3e';

    // ==================== GLOBAL CHART REFERENCES ====================
    let activityChart, roleChart, paymentsBarChart, topUsersChart;
    let modalActivityChart, modalRoleChart, modalPaymentsChart, modalUsersChart;

    // ==================== RESPONSIVE CHART OPTIONS BUILDER ====================
    function buildBaseOptions(customOptions = {}) {
        const sizes = getResponsiveChartFonts();
        return {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    labels: {
                        font: { size: sizes.legend, weight: '600' },
                        color: '#2c2c3e',
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: Math.max(8, sizes.legend * 1.2)
                    },
                    position: window.innerWidth < 576 ? 'bottom' : 'top'
                },
                tooltip: {
                    backgroundColor: '#4a148c',
                    padding: Math.max(6, sizes.padding),
                    cornerRadius: Math.max(6, sizes.padding * 0.8),
                    titleFont: { size: sizes.tooltipTitle, weight: '600' },
                    bodyFont: { size: sizes.tooltipBody, weight: '500' }
                },
                ...customOptions.plugins
            },
            scales: {
                y: {
                    grid: { color: '#d1c4e9', lineWidth: 1 },
                    ticks: {
                        color: '#2c2c3e',
                        font: { size: sizes.tick, weight: '600' },
                        maxTicksLimit: window.innerWidth < 576 ? 5 : 8
                    },
                    title: {
                        display: window.innerWidth > 400,
                        color: '#6c6c80',
                        font: { size: sizes.axisTitle, weight: '600' }
                    }
                },
                x: {
                    ticks: {
                        color: '#2c2c3e',
                        font: { size: sizes.tick, weight: '600' },
                        maxTicksLimit: window.innerWidth < 576 ? 6 : 12,
                        maxRotation: window.innerWidth < 576 ? 45 : 30
                    },
                    grid: { display: false },
                    title: {
                        display: window.innerWidth > 400,
                        color: '#6c6c80',
                        font: { size: sizes.axisTitle, weight: '600' }
                    }
                },
                ...customOptions.scales
            },
            ...customOptions
        };
    }

    // ==================== ROLE DISTRIBUTION CHART ====================
    @php
        $roleCounts = [
            'super_admin' => \App\Models\Admin::where('role', 'super_admin')->count(),
            'fleet_manager' => \App\Models\Admin::where('role', 'fleet_manager')->count(),
            'auditor' => \App\Models\Admin::where('role', 'auditor')->count(),
        ];
    @endphp
    const roleCtx = document.getElementById('roleChart')?.getContext('2d');
    if(roleCtx) {
        const roleSizes = getResponsiveChartFonts();
        roleChart = new Chart(roleCtx, {
            type: 'doughnut',
            data: {
                labels: ['Super Admin', 'Fleet Manager', 'Auditor'],
                datasets: [{
                    data: [{{ $roleCounts['super_admin'] }}, {{ $roleCounts['fleet_manager'] }}, {{ $roleCounts['auditor'] }}],
                    backgroundColor: ['#7b1fa2', '#9c27b0', '#d1c4e9'],
                    borderColor: ['#4a148c', '#7b1fa2', '#b39ddb'],
                    borderWidth: Math.max(1, roleSizes.barRadius * 0.2),
                    hoverOffset: window.innerWidth < 576 ? 6 : 12,
                    borderRadius: Math.max(4, roleSizes.barRadius * 0.6),
                    spacing: Math.max(3, roleSizes.barRadius * 0.4)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: roleSizes.doughnutCutout,
                plugins: {
                    legend: {
                        position: window.innerWidth < 576 ? 'bottom' : 'bottom',
                        labels: {
                            font: { size: roleSizes.legend, weight: '600' },
                            color: '#2c2c3e',
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: Math.max(8, roleSizes.legend * 1.2)
                        }
                    },
                    tooltip: {
                        backgroundColor: '#4a148c',
                        padding: Math.max(6, roleSizes.padding),
                        cornerRadius: Math.max(6, roleSizes.padding * 0.8),
                        titleFont: { size: roleSizes.tooltipTitle, weight: '600' },
                        bodyFont: { size: roleSizes.tooltipBody, weight: '500' },
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });
    }

    // ==================== ACTIVITY TRENDS CHART ====================
    const activityCtx = document.getElementById('activityChart')?.getContext('2d');
    if(activityCtx) {
        const activitySizes = getResponsiveChartFonts();
        activityChart = new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Admin Actions',
                    data: [45, 52, 48, 61, 73, 55, 42],
                    borderColor: '#7b1fa2',
                    backgroundColor: 'rgba(123, 31, 162, 0.04)',
                    borderWidth: Math.max(1.5, activitySizes.barRadius * 0.2),
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#7b1fa2',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: Math.max(1, activitySizes.barRadius * 0.15),
                    pointRadius: Math.max(2, activitySizes.pointRadius),
                    pointHoverRadius: Math.max(4, activitySizes.pointRadius * 1.5),
                    pointHoverBackgroundColor: '#9c27b0'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: {
                            font: { size: activitySizes.legend, weight: '600' },
                            color: '#2c2c3e'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#4a148c',
                        padding: Math.max(6, activitySizes.padding),
                        cornerRadius: Math.max(6, activitySizes.padding * 0.8),
                        titleFont: { size: activitySizes.tooltipTitle, weight: '600' },
                        bodyFont: { size: activitySizes.tooltipBody, weight: '500' }
                    }
                },
                scales: {
                    y: {
                        grid: { color: '#d1c4e9', lineWidth: 1 },
                        ticks: {
                            color: '#2c2c3e',
                            font: { size: activitySizes.tick, weight: '600' },
                            stepSize: 20,
                            maxTicksLimit: window.innerWidth < 576 ? 4 : 8
                        },
                        title: {
                            display: window.innerWidth > 400,
                            text: 'Actions Count',
                            color: '#6c6c80',
                            font: { size: activitySizes.axisTitle, weight: '600' }
                        }
                    },
                    x: {
                        ticks: {
                            color: '#2c2c3e',
                            font: { size: activitySizes.tick, weight: '600' },
                            maxTicksLimit: window.innerWidth < 576 ? 5 : 12
                        },
                        grid: { display: false },
                        title: {
                            display: window.innerWidth > 400,
                            text: 'Day',
                            color: '#6c6c80',
                            font: { size: activitySizes.axisTitle, weight: '600' }
                        }
                    }
                }
            }
        });
    }

    // ==================== DAILY APPROVED PAYMENTS (BAR CHART) ====================
    @php
        $dailyDates = isset($approvedPaymentsChart['dates']) ? $approvedPaymentsChart['dates'] : [];
        $dailyAmounts = isset($approvedPaymentsChart['daily_amounts']) ? $approvedPaymentsChart['daily_amounts'] : [];

        if(empty($dailyDates)) {
            for ($i = 6; $i >= 0; $i--) {
                $dailyDates[] = now()->subDays($i)->format('M d');
                $dailyAmounts[] = 0;
            }
        }
    @endphp
    const paymentsCtx = document.getElementById('dailyPaymentsBarChart')?.getContext('2d');
    if(paymentsCtx) {
        const dates = @json($dailyDates);
        const amounts = @json($dailyAmounts);
        const allZero = amounts.every(amt => amt === 0);
        if (allZero) {
            document.getElementById('noPaymentsOverlay')?.classList.remove('d-none');
        }
        const paymentsSizes = getResponsiveChartFonts();
        paymentsBarChart = new Chart(paymentsCtx, {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Approved Payments (₱)',
                    data: amounts,
                    backgroundColor: 'rgba(123, 31, 162, 0.85)',
                    borderColor: '#7b1fa2',
                    borderWidth: Math.max(1, paymentsSizes.barRadius * 0.2),
                    borderRadius: Math.max(3, paymentsSizes.barRadius),
                    barPercentage: window.innerWidth < 576 ? 0.5 : 0.65,
                    categoryPercentage: window.innerWidth < 576 ? 0.7 : 0.8,
                    hoverBackgroundColor: '#4a148c'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.raw.toLocaleString(undefined, { minimumFractionDigits: 2 });
                            }
                        },
                        backgroundColor: '#4a148c',
                        padding: Math.max(6, paymentsSizes.padding),
                        cornerRadius: Math.max(6, paymentsSizes.padding * 0.8),
                        titleFont: { size: paymentsSizes.tooltipTitle, weight: '600' },
                        bodyFont: { size: paymentsSizes.tooltipBody, weight: '500' }
                    },
                    legend: {
                        position: window.innerWidth < 576 ? 'bottom' : 'top',
                        labels: {
                            font: { size: paymentsSizes.legend, weight: '600' },
                            color: '#2c2c3e',
                            usePointStyle: true
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return '₱' + (value / 1000000).toFixed(1) + 'M';
                                } else if (value >= 1000) {
                                    return '₱' + (value / 1000).toFixed(1) + 'k';
                                }
                                return '₱' + value.toLocaleString();
                            },
                            color: '#2c2c3e',
                            font: { size: paymentsSizes.tick, weight: '600' },
                            maxTicksLimit: window.innerWidth < 576 ? 5 : 8
                        },
                        grid: { color: '#d1c4e9' },
                        title: {
                            display: window.innerWidth > 400,
                            text: 'Amount (₱)',
                            color: '#6c6c80',
                            font: { size: paymentsSizes.axisTitle, weight: '600' }
                        }
                    },
                    x: {
                        ticks: {
                            color: '#2c2c3e',
                            font: { size: paymentsSizes.tick, weight: '600' },
                            maxTicksLimit: window.innerWidth < 576 ? 5 : 12,
                            maxRotation: window.innerWidth < 576 ? 45 : 30
                        },
                        grid: { display: false },
                        title: {
                            display: window.innerWidth > 400,
                            text: 'Date',
                            color: '#6c6c80',
                            font: { size: paymentsSizes.axisTitle, weight: '600' }
                        }
                    }
                }
            }
        });
    }

    // ==================== MOST ACTIVE USERS BY BOOKING COUNT ====================
    @php
        $topUsers = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->select(DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_name"), DB::raw('COUNT(bookings.id) as total_bookings'))
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->orderByDesc('total_bookings')
            ->limit(5)
            ->get();

        $userLabels = $topUsers->pluck('user_name')->toArray();
        $userBookingCounts = $topUsers->pluck('total_bookings')->toArray();

        if(empty($userLabels)) {
            $userLabels = ['No bookings yet'];
            $userBookingCounts = [0];
        }
    @endphp
    const topUsersCtx = document.getElementById('topUsersChart')?.getContext('2d');
    if(topUsersCtx) {
        const usersSizes = getResponsiveChartFonts();
        const isMobile = window.innerWidth < 576;
        topUsersChart = new Chart(topUsersCtx, {
            type: 'bar',
            data: {
                labels: @json($userLabels),
                datasets: [{
                    label: 'Total Bookings',
                    data: @json($userBookingCounts),
                    backgroundColor: 'rgba(123, 31, 162, 0.85)',
                    borderColor: '#7b1fa2',
                    borderWidth: Math.max(1, usersSizes.barRadius * 0.2),
                    borderRadius: Math.max(3, usersSizes.barRadius),
                    barPercentage: isMobile ? 0.5 : 0.6,
                    categoryPercentage: isMobile ? 0.7 : 0.7,
                    hoverBackgroundColor: '#4a148c'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                indexAxis: isMobile ? 'x' : 'y',
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) { return 'Bookings: ' + context.raw; }
                        },
                        backgroundColor: '#4a148c',
                        padding: Math.max(6, usersSizes.padding),
                        cornerRadius: Math.max(6, usersSizes.padding * 0.8),
                        titleFont: { size: usersSizes.tooltipTitle, weight: '600' },
                        bodyFont: { size: usersSizes.tooltipBody, weight: '500' }
                    },
                    legend: {
                        position: isMobile ? 'bottom' : 'top',
                        labels: {
                            font: { size: usersSizes.legend, weight: '600' },
                            color: '#2c2c3e',
                            usePointStyle: true
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#2c2c3e',
                            font: { size: usersSizes.tick, weight: '600' },
                            stepSize: 1,
                            maxTicksLimit: isMobile ? 5 : 8
                        },
                        grid: { color: '#d1c4e9' },
                        title: {
                            display: window.innerWidth > 400 && !isMobile,
                            text: 'Number of Bookings',
                            color: '#6c6c80',
                            font: { size: usersSizes.axisTitle, weight: '600' }
                        }
                    },
                    y: {
                        ticks: {
                            color: '#2c2c3e',
                            font: { size: usersSizes.tick, weight: '600' },
                            maxTicksLimit: isMobile ? 4 : 8
                        },
                        grid: { display: false },
                        title: {
                            display: window.innerWidth > 400,
                            text: isMobile ? 'Bookings' : 'User',
                            color: '#6c6c80',
                            font: { size: usersSizes.axisTitle, weight: '600' }
                        }
                    }
                }
            }
        });
    }

    // ==================== MAXIMIZE & MODAL FUNCTIONS ====================
    function createModalChart(modalCanvasId, chartConfig) {
        const ctx = document.getElementById(modalCanvasId)?.getContext('2d');
        if(!ctx) return null;
        return new Chart(ctx, chartConfig);
    }

    function getModalFontSizes() {
        const width = window.innerWidth;
        if (width < 576) {
            return { title: 12, legend: 12, tick: 10, tooltipTitle: 12, tooltipBody: 10, axisTitle: 12 };
        } else if (width < 768) {
            return { title: 14, legend: 14, tick: 12, tooltipTitle: 14, tooltipBody: 12, axisTitle: 14 };
        } else {
            return { title: 18, legend: 18, tick: 16, tooltipTitle: 18, tooltipBody: 16, axisTitle: 18 };
        }
    }

    // Maximize handlers
    document.querySelectorAll('.maximize-chart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const chartType = this.getAttribute('data-chart');
            const modalSizes = getModalFontSizes();

            if(chartType === 'activity') {
                const data = activityChart.data;
                const options = {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { labels: { font: { size: modalSizes.legend, weight: '600' }, color: '#2c2c3e' } },
                        tooltip: { titleFont: { size: modalSizes.tooltipTitle, weight: '600' }, bodyFont: { size: modalSizes.tooltipBody, weight: '500' }, backgroundColor: '#4a148c' }
                    },
                    scales: {
                        y: { ticks: { font: { size: modalSizes.tick, weight: '600' } }, title: { font: { size: modalSizes.axisTitle, weight: '600' } }, grid: { color: '#d1c4e9' } },
                        x: { ticks: { font: { size: modalSizes.tick, weight: '600' } }, title: { font: { size: modalSizes.axisTitle, weight: '600' } } }
                    }
                };
                if(modalActivityChart) modalActivityChart.destroy();
                modalActivityChart = createModalChart('activityModalCanvas', { type: 'line', data: data, options: options });
                new bootstrap.Modal(document.getElementById('activityModal')).show();
            }
            else if(chartType === 'role') {
                const data = roleChart.data;
                const options = {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: window.innerWidth < 576 ? '50%' : '60%',
                    plugins: {
                        legend: { labels: { font: { size: modalSizes.legend, weight: '600' }, usePointStyle: true, color: '#2c2c3e' } },
                        tooltip: { titleFont: { size: modalSizes.tooltipTitle, weight: '600' }, bodyFont: { size: modalSizes.tooltipBody, weight: '500' }, backgroundColor: '#4a148c' }
                    }
                };
                if(modalRoleChart) modalRoleChart.destroy();
                modalRoleChart = createModalChart('roleModalCanvas', { type: 'doughnut', data: data, options: options });
                new bootstrap.Modal(document.getElementById('roleModal')).show();
            }
            else if(chartType === 'payments') {
                const data = paymentsBarChart.data;
                const options = {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        tooltip: {
                            callbacks: { label: (ctx) => '₱' + ctx.raw.toLocaleString() },
                            titleFont: { size: modalSizes.tooltipTitle, weight: '600' },
                            bodyFont: { size: modalSizes.tooltipBody, weight: '500' },
                            backgroundColor: '#4a148c'
                        },
                        legend: { labels: { font: { size: modalSizes.legend, weight: '600' }, color: '#2c2c3e' } }
                    },
                    scales: {
                        y: { ticks: { font: { size: modalSizes.tick, weight: '600' }, callback: (val) => '₱' + val.toLocaleString() }, title: { font: { size: modalSizes.axisTitle, weight: '600' } }, grid: { color: '#d1c4e9' } },
                        x: { ticks: { font: { size: modalSizes.tick, weight: '600' } }, title: { font: { size: modalSizes.axisTitle, weight: '600' } } }
                    }
                };
                if(modalPaymentsChart) modalPaymentsChart.destroy();
                modalPaymentsChart = createModalChart('paymentsModalCanvas', { type: 'bar', data: data, options: options });
                new bootstrap.Modal(document.getElementById('paymentsModal')).show();
            }
            else if(chartType === 'users') {
                const data = topUsersChart.data;
                const isMobile = window.innerWidth < 576;
                const options = {
                    responsive: true,
                    maintainAspectRatio: true,
                    indexAxis: isMobile ? 'x' : 'y',
                    plugins: {
                        tooltip: { titleFont: { size: modalSizes.tooltipTitle, weight: '600' }, bodyFont: { size: modalSizes.tooltipBody, weight: '500' }, backgroundColor: '#4a148c' },
                        legend: { labels: { font: { size: modalSizes.legend, weight: '600' }, color: '#2c2c3e' } }
                    },
                    scales: {
                        x: { ticks: { font: { size: modalSizes.tick, weight: '600' } }, title: { font: { size: modalSizes.axisTitle, weight: '600' } }, grid: { color: '#d1c4e9' } },
                        y: { ticks: { font: { size: modalSizes.tick, weight: '600' } }, title: { font: { size: modalSizes.axisTitle, weight: '600' } } }
                    }
                };
                if(modalUsersChart) modalUsersChart.destroy();
                modalUsersChart = createModalChart('usersModalCanvas', { type: 'bar', data: data, options: options });
                new bootstrap.Modal(document.getElementById('usersModal')).show();
            }
        });
    });

    // Destroy modal charts on close
    const modals = ['activityModal', 'roleModal', 'paymentsModal', 'usersModal'];
    modals.forEach(modalId => {
        const modalEl = document.getElementById(modalId);
        if(modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                if(modalId === 'activityModal' && modalActivityChart) { modalActivityChart.destroy(); modalActivityChart = null; }
                if(modalId === 'roleModal' && modalRoleChart) { modalRoleChart.destroy(); modalRoleChart = null; }
                if(modalId === 'paymentsModal' && modalPaymentsChart) { modalPaymentsChart.destroy(); modalPaymentsChart = null; }
                if(modalId === 'usersModal' && modalUsersChart) { modalUsersChart.destroy(); modalUsersChart = null; }
            });
        }
    });

    // ==================== WINDOW RESIZE HANDLER ====================
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            const newSizes = getResponsiveChartFonts();

            // Update global defaults
            Chart.defaults.font.size = newSizes.title;

            // Update each chart if it exists
            if (roleChart) {
                roleChart.options.cutout = newSizes.doughnutCutout;
                roleChart.options.plugins.legend.labels.font.size = newSizes.legend;
                roleChart.options.plugins.tooltip.titleFont.size = newSizes.tooltipTitle;
                roleChart.options.plugins.tooltip.bodyFont.size = newSizes.tooltipBody;
                roleChart.options.plugins.tooltip.padding = Math.max(6, newSizes.padding);
                roleChart.options.plugins.tooltip.cornerRadius = Math.max(6, newSizes.padding * 0.8);
                roleChart.data.datasets[0].borderRadius = Math.max(4, newSizes.barRadius * 0.6);
                roleChart.data.datasets[0].spacing = Math.max(3, newSizes.barRadius * 0.4);
                roleChart.update('none');
            }

            if (activityChart) {
                activityChart.options.plugins.legend.labels.font.size = newSizes.legend;
                activityChart.options.plugins.tooltip.titleFont.size = newSizes.tooltipTitle;
                activityChart.options.plugins.tooltip.bodyFont.size = newSizes.tooltipBody;
                activityChart.options.plugins.tooltip.padding = Math.max(6, newSizes.padding);
                activityChart.options.plugins.tooltip.cornerRadius = Math.max(6, newSizes.padding * 0.8);
                activityChart.options.scales.y.ticks.font.size = newSizes.tick;
                activityChart.options.scales.y.title.font.size = newSizes.axisTitle;
                activityChart.options.scales.x.ticks.font.size = newSizes.tick;
                activityChart.options.scales.x.title.font.size = newSizes.axisTitle;
                activityChart.options.scales.y.ticks.maxTicksLimit = window.innerWidth < 576 ? 4 : 8;
                activityChart.options.scales.x.ticks.maxTicksLimit = window.innerWidth < 576 ? 5 : 12;
                activityChart.data.datasets[0].pointRadius = Math.max(2, newSizes.pointRadius);
                activityChart.data.datasets[0].pointHoverRadius = Math.max(4, newSizes.pointRadius * 1.5);
                activityChart.update('none');
            }

            if (paymentsBarChart) {
                const isMobile = window.innerWidth < 576;
                paymentsBarChart.options.plugins.legend.labels.font.size = newSizes.legend;
                paymentsBarChart.options.plugins.tooltip.titleFont.size = newSizes.tooltipTitle;
                paymentsBarChart.options.plugins.tooltip.bodyFont.size = newSizes.tooltipBody;
                paymentsBarChart.options.plugins.tooltip.padding = Math.max(6, newSizes.padding);
                paymentsBarChart.options.plugins.tooltip.cornerRadius = Math.max(6, newSizes.padding * 0.8);
                paymentsBarChart.options.scales.y.ticks.font.size = newSizes.tick;
                paymentsBarChart.options.scales.y.title.font.size = newSizes.axisTitle;
                paymentsBarChart.options.scales.x.ticks.font.size = newSizes.tick;
                paymentsBarChart.options.scales.x.title.font.size = newSizes.axisTitle;
                paymentsBarChart.options.scales.y.ticks.maxTicksLimit = isMobile ? 5 : 8;
                paymentsBarChart.options.scales.x.ticks.maxTicksLimit = isMobile ? 5 : 12;
                paymentsBarChart.options.scales.x.ticks.maxRotation = isMobile ? 45 : 30;
                paymentsBarChart.data.datasets[0].barPercentage = isMobile ? 0.5 : 0.65;
                paymentsBarChart.data.datasets[0].categoryPercentage = isMobile ? 0.7 : 0.8;
                paymentsBarChart.data.datasets[0].borderRadius = Math.max(3, newSizes.barRadius);
                paymentsBarChart.update('none');
            }

            if (topUsersChart) {
                const isMobile = window.innerWidth < 576;
                topUsersChart.options.indexAxis = isMobile ? 'x' : 'y';
                topUsersChart.options.plugins.legend.labels.font.size = newSizes.legend;
                topUsersChart.options.plugins.tooltip.titleFont.size = newSizes.tooltipTitle;
                topUsersChart.options.plugins.tooltip.bodyFont.size = newSizes.tooltipBody;
                topUsersChart.options.plugins.tooltip.padding = Math.max(6, newSizes.padding);
                topUsersChart.options.plugins.tooltip.cornerRadius = Math.max(6, newSizes.padding * 0.8);
                topUsersChart.options.scales.x.ticks.font.size = newSizes.tick;
                topUsersChart.options.scales.x.title.font.size = newSizes.axisTitle;
                topUsersChart.options.scales.y.ticks.font.size = newSizes.tick;
                topUsersChart.options.scales.y.title.font.size = newSizes.axisTitle;
                topUsersChart.options.scales.x.ticks.maxTicksLimit = isMobile ? 5 : 8;
                topUsersChart.options.scales.y.ticks.maxTicksLimit = isMobile ? 4 : 8;
                topUsersChart.data.datasets[0].barPercentage = isMobile ? 0.5 : 0.6;
                topUsersChart.data.datasets[0].categoryPercentage = isMobile ? 0.7 : 0.7;
                topUsersChart.data.datasets[0].borderRadius = Math.max(3, newSizes.barRadius);
                topUsersChart.update('none');
            }
        }, 300);
    });

    // ================================================================
    // ================ PDF EXPORT MODAL LOGIC ========================
    // ================================================================

    // Store current export data
    let pdfExportData = {
        canvasId: null,
        fileName: null,
        chartTitle: null,
        dataURL: null
    };

    // Function to generate PDF from dataURL with options
    function generatePDFFromDataURL(dataURL, fileName, orientation = 'landscape', pageSize = 'a4') {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF({
            orientation: orientation,
            unit: 'mm',
            format: pageSize
        });
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const margin = 10;
        const maxWidth = pageWidth - 2 * margin;
        const maxHeight = pageHeight - 2 * margin;
        const img = new Image();
        img.onload = function() {
            let imgWidth = img.width;
            let imgHeight = img.height;
            const ratio = Math.min(maxWidth / imgWidth, maxHeight / imgHeight);
            imgWidth = imgWidth * ratio;
            imgHeight = imgHeight * ratio;
            const x = (pageWidth - imgWidth) / 2;
            const y = (pageHeight - imgHeight) / 2;
            pdf.addImage(dataURL, 'PNG', x, y, imgWidth, imgHeight);
            pdf.save(fileName + '.pdf');
        };
        img.src = dataURL;
    }

    // Handle export button clicks -> open modal
    document.querySelectorAll('.export-chart-pdf-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const chartType = this.getAttribute('data-chart');
            const chartTitle = this.getAttribute('data-title') || 'Chart';
            let canvasId;
            let fileName;
            switch(chartType) {
                case 'activity':
                    canvasId = 'activityChart';
                    fileName = 'admin_activity_trends';
                    break;
                case 'role':
                    canvasId = 'roleChart';
                    fileName = 'admin_role_distribution';
                    break;
                case 'payments':
                    canvasId = 'dailyPaymentsBarChart';
                    fileName = 'daily_approved_payments';
                    break;
                case 'users':
                    canvasId = 'topUsersChart';
                    fileName = 'most_active_users';
                    break;
                default:
                    return;
            }
            const canvas = document.getElementById(canvasId);
            if(!canvas) {
                alert('Chart not found.');
                return;
            }
            const dataURL = canvas.toDataURL('image/png');
            pdfExportData.canvasId = canvasId;
            pdfExportData.fileName = fileName;
            pdfExportData.chartTitle = chartTitle;
            pdfExportData.dataURL = dataURL;

            document.getElementById('pdfExportPreview').src = dataURL;
            document.getElementById('pdfExportChartTitle').textContent = chartTitle;

            document.getElementById('pdfOrientation').value = 'landscape';
            document.getElementById('pdfPageSize').value = 'a4';

            const modal = new bootstrap.Modal(document.getElementById('pdfExportModal'));
            modal.show();
        });
    });

    // Handle download button inside modal
    document.getElementById('pdfDownloadBtn').addEventListener('click', function() {
        const dataURL = pdfExportData.dataURL;
        const fileName = pdfExportData.fileName || 'chart_export';
        const orientation = document.getElementById('pdfOrientation').value;
        const pageSize = document.getElementById('pdfPageSize').value;
        if(!dataURL) {
            alert('No chart data available. Please try again.');
            return;
        }
        generatePDFFromDataURL(dataURL, fileName, orientation, pageSize);
    });

    // Clean up when modal is hidden
    document.getElementById('pdfExportModal').addEventListener('hidden.bs.modal', function() {
        pdfExportData.dataURL = null;
        document.getElementById('pdfExportPreview').src = '';
    });
</script>
@endpush
