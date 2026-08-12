{{-- resources/views/admin/user-requests/show.blade.php --}}
@extends('admin.layouts.app')

@section('page-title', 'Request #' . $userRequest->id)
@section('title', 'Request Details')

@section('content')
<style nonce="{{ $csp_nonce }}">
/* ============================================================
   USER REQUEST DETAILS - DEEPSEEK-STYLE STYLES
   Theme: White / Purple / Green / Red (matching admin)
   ============================================================ */

:root {
    --green-primary: #8610a3;
    --green-light: #9a46e9;
    --green-soft: #f3e8f7;
    --red-primary: #4e0461;
    --red-dark: #4e065c;
    --white: #FFFFFF;
    --gray-100: #F8F9FC;
    --gray-200: #E9ECF0;
    --gray-600: #5A6A72;
    --shadow-sm: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
    --radius-card: 2rem;
    --radius-btn: 3rem;

    --font-sm: 0.875rem;
    --font-base: 1rem;
    --font-md: 1.125rem;
    --font-lg: 1.25rem;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f5f7fa;
    color: #1A2C2A;
    font-size: var(--font-base);
    line-height: 1.6;
}

/* Card */
.card {
    border-radius: 1.5rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    overflow: hidden;
    background: var(--white);
}
.card-header {
    background: var(--white);
    border-bottom: 3px solid var(--green-primary);
    padding: 1.2rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.card-header .card-title {
    color: var(--green-primary);
    font-weight: 700;
    font-size: var(--font-md);
    margin: 0;
}
.card-body {
    padding: 1.8rem;
}

/* Table */
.table {
    margin-bottom: 0;
}
.table th {
    background: var(--gray-100);
    color: var(--green-primary);
    font-weight: 700;
    padding: 0.8rem 1.2rem;
    width: 180px;
    border: 1px solid var(--gray-200);
}
.table td {
    padding: 0.8rem 1.2rem;
    border: 1px solid var(--gray-200);
    vertical-align: middle;
    color: #1A2C2A;
}

/* Badges */
.badge {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}
.badge-warning {
    background-color: #ffc107 !important;
    color: #212529;
}
.badge-success {
    background-color: #28a745 !important;
    color: #fff;
}
.badge-danger {
    background-color: #dc3545 !important;
    color: #fff;
}

/* Buttons */
.btn {
    border-radius: 3rem;
    padding: 0.5rem 1.5rem;
    font-weight: 600;
    transition: all 0.2s ease;
    border: none;
    font-size: 0.875rem;
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.btn-success {
    background: #28a745;
    color: #fff;
}
.btn-success:hover {
    background: #1e7e34;
    transform: translateY(-2px);
    color: #fff;
}
.btn-danger {
    background: #dc3545;
    color: #fff;
}
.btn-danger:hover {
    background: #b91d2c;
    transform: translateY(-2px);
    color: #fff;
}
.btn-secondary {
    background: #6c757d;
    color: #fff;
}
.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
    color: #fff;
}
.btn-sm {
    padding: 0.3rem 1rem;
    font-size: 0.75rem;
    min-height: 32px;
    border-radius: 2rem;
}

/* Alert info */
.alert-info {
    background: var(--green-soft);
    border: none;
    border-radius: 1rem;
    color: var(--green-primary);
    padding: 0.8rem 1.2rem;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 768px) {
    .card-header {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start !important;
    }
    .card-body {
        padding: 1rem;
    }
    .table th {
        width: 120px;
        padding: 0.5rem 0.8rem;
        font-size: 0.8rem;
    }
    .table td {
        padding: 0.5rem 0.8rem;
        font-size: 0.8rem;
    }
    .btn {
        font-size: 0.75rem;
        padding: 0.3rem 1rem;
        min-height: 34px;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 0.6rem;
    }
    .table th {
        width: 90px;
        padding: 0.3rem 0.5rem;
        font-size: 0.7rem;
    }
    .table td {
        padding: 0.3rem 0.5rem;
        font-size: 0.7rem;
    }
    .btn {
        font-size: 0.65rem;
        padding: 0.2rem 0.6rem;
        min-height: 28px;
    }
    .btn-sm {
        font-size: 0.6rem;
        padding: 0.15rem 0.5rem;
        min-height: 24px;
    }
    .card-header .card-title {
        font-size: 1rem;
    }
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt me-2"></i>Request Details #{{ $userRequest->id }}
                    </h3>
                    <a href="{{ route('admin.user-requests.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Request ID</th>
                                    <td>#{{ $userRequest->id }}</td>
                                </tr>
                                <tr>
                                    <th>How They Know</th>
                                    <td>
                                        <span class="badge bg-info text-white">
                                            <i class="fas fa-info-circle me-1"></i>
                                            {{ ucfirst($userRequest->know_site) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Message</th>
                                    <td>{{ $userRequest->message ?: 'No message provided' }}</td>
                                </tr>
                                <tr>
                                    <th>IP Address</th>
                                    <td><code>{{ $userRequest->ip_address ?: 'N/A' }}</code></td>
                                </tr>
                                <tr>
                                    <th>User Agent</th>
                                    <td><small>{{ $userRequest->user_agent ?: 'N/A' }}</small></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($userRequest->status === 'pending')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock me-1"></i> Pending
                                            </span>
                                        @elseif($userRequest->status === 'approved')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle me-1"></i> Approved
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle me-1"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Submitted</th>
                                    <td>{{ $userRequest->created_at->format('F d, Y h:i:s A') }}</td>
                                </tr>
                                @if($userRequest->approved_at)
                                <tr>
                                    <th>Approved At</th>
                                    <td>{{ $userRequest->approved_at->format('F d, Y h:i:s A') }}</td>
                                </tr>
                                @endif
                                @if($userRequest->rejected_at)
                                <tr>
                                    <th>Rejected At</th>
                                    <td>{{ $userRequest->rejected_at->format('F d, Y h:i:s A') }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if($userRequest->isPending())
                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <form action="{{ route('admin.user-requests.approve', $userRequest) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Approve this request?')">
                                <i class="fas fa-check me-2"></i> Approve Request
                            </button>
                        </form>
                        <form action="{{ route('admin.user-requests.reject', $userRequest) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this request?')">
                                <i class="fas fa-times me-2"></i> Reject Request
                            </button>
                        </form>
                    </div>
                    @endif

                    @if($userRequest->status !== 'pending')
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            This request has been <strong>{{ $userRequest->status }}</strong>.
                            @if($userRequest->approved_at)
                                Approved on {{ $userRequest->approved_at->format('F d, Y h:i:s A') }}
                            @endif
                            @if($userRequest->rejected_at)
                                Rejected on {{ $userRequest->rejected_at->format('F d, Y h:i:s A') }}
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection