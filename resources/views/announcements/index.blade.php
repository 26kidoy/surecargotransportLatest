@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Header with counters and toggle button --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-nowrap gap-2 gap-sm-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-bullhorn text-primary"></i>
                <span class="d-none d-sm-inline ms-1">Announcements</span>
            </h2>
            <div class="mt-0">
                <span class="badge bg-primary rounded-pill" id="totalBadge">{{ $announcements->total() ?? 0 }} total</span>
                <span class="badge bg-secondary rounded-pill ms-1" id="hiddenBadge">0 hidden</span>
            </div>
        </div>
        <button class="btn btn-outline-secondary rounded-pill px-2 px-sm-4" id="toggleHiddenBtn">
            <i class="fas fa-eye-slash" id="toggleIcon"></i>
            <span class="d-none d-sm-inline ms-1" id="toggleText">Show Hidden</span>
        </button>
    </div>

    {{-- Announcement cards --}}
    @if($announcements->count())
        <div class="row g-4" id="announcementContainer">
            @foreach($announcements as $announcement)
                <div class="col-md-6 col-lg-4 announcement-card" data-id="{{ $announcement->id }}">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                        {{-- IMAGE SECTION - FIXED: Single image render with clean fallback --}}
                        @php
                            $imageUrl = $announcement->image_url;
                        @endphp
                        <div class="card-img-top-wrapper" style="height: 200px; background: #f8f9fa; position: relative; overflow: hidden;">
                            @if($imageUrl)
                                <img src="{{ e($imageUrl) }}"
                                     class="card-img-top w-100 h-100"
                                     alt="{{ e($announcement->title) }}"
                                     style="object-fit: cover;"
                                     onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'w-100 h-100 d-flex align-items-center justify-content-center\'><i class=\'fas fa-image fa-3x text-muted\'></i></div>';">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ e($announcement->title) }}</h5>
                            <p class="card-text flex-grow-1">{{ e(Str::limit($announcement->content, 120)) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $announcement->published_at ? $announcement->published_at->format('M d, Y') : 'Draft' }}
                                </small>
                                <button class="btn btn-sm btn-outline-danger rounded-pill mark-read-btn">
                                    <i class="fas fa-check me-1"></i> Mark as Read
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $announcements->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-bullhorn fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No announcements yet</h4>
            <p class="text-muted">Check back later for important updates.</p>
        </div>
    @endif
</div>

@push('scripts')
<script nonce="{{ $csp_nonce }}">
    (function() {
        'use strict';

        // Key for localStorage
        const STORAGE_KEY = 'read_announcements';

        // Get stored read IDs (array of numbers)
        function getReadIds() {
            try {
                const data = localStorage.getItem(STORAGE_KEY);
                return data ? JSON.parse(data) : [];
            } catch {
                return [];
            }
        }

        // Save read IDs
        function saveReadIds(ids) {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
        }

        // Add an ID to the read list
        function markAsRead(id) {
            const ids = getReadIds();
            if (!ids.includes(id)) {
                ids.push(id);
                saveReadIds(ids);
            }
        }

        // Check if an ID is read
        function isRead(id) {
            return getReadIds().includes(id);
        }

        // Update the hidden badge count
        function updateHiddenBadge() {
            const hidden = document.querySelectorAll('.announcement-card.hidden');
            const badge = document.getElementById('hiddenBadge');
            if (badge) {
                badge.textContent = hidden.length + ' hidden';
            }
        }

        // Toggle hidden visibility
        let showHidden = false;
        function toggleHidden() {
            showHidden = !showHidden;
            const hiddenCards = document.querySelectorAll('.announcement-card.hidden');
            hiddenCards.forEach(card => {
                card.style.display = showHidden ? '' : 'none';
            });
            const btn = document.getElementById('toggleHiddenBtn');
            if (btn) {
                const icon = document.getElementById('toggleIcon');
                const text = document.getElementById('toggleText');
                if (showHidden) {
                    icon.className = 'fas fa-eye me-1';
                    text.textContent = 'Hide Hidden';
                } else {
                    icon.className = 'fas fa-eye-slash me-1';
                    text.textContent = 'Show Hidden';
                }
            }
        }

        // Apply initial hiding based on read status
        function applyInitialHide() {
            const cards = document.querySelectorAll('.announcement-card');
            let hiddenCount = 0;
            cards.forEach(card => {
                const id = parseInt(card.dataset.id);
                if (isRead(id)) {
                    card.classList.add('hidden');
                    card.style.display = 'none'; // hidden by default
                    hiddenCount++;
                } else {
                    card.classList.remove('hidden');
                    card.style.display = ''; // visible
                }
            });
            // Update badge
            const badge = document.getElementById('hiddenBadge');
            if (badge) {
                badge.textContent = hiddenCount + ' hidden';
            }
            // Set toggle button state to "Show Hidden" initially
            const btn = document.getElementById('toggleHiddenBtn');
            if (btn) {
                const icon = document.getElementById('toggleIcon');
                const text = document.getElementById('toggleText');
                icon.className = 'fas fa-eye-slash me-1';
                text.textContent = 'Show Hidden';
            }
            showHidden = false;
        }

        // Event handler for "Mark as Read" buttons
        function handleMarkRead(e) {
            const btn = e.target.closest('.mark-read-btn');
            if (!btn) return;
            const card = btn.closest('.announcement-card');
            if (!card) return;
            const id = parseInt(card.dataset.id);
            if (isRead(id)) return; // already read

            // Mark as read
            markAsRead(id);
            card.classList.add('hidden');
            card.style.display = 'none'; // hide immediately
            updateHiddenBadge();
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Apply initial hide
            applyInitialHide();

            // Event delegation for mark-read buttons
            const container = document.getElementById('announcementContainer');
            if (container) {
                container.addEventListener('click', handleMarkRead);
            }

            // Toggle button
            const toggleBtn = document.getElementById('toggleHiddenBtn');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleHidden);
            }
        });

    })();
</script>
@endpush
@endsection
