@extends('layouts.admin')

@section('page_title', 'Sponsors Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Sponsors Management</h2>
    <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary">
        <i class="ri-add-line me-1"></i>Add New Sponsor
    </a>
</div>

<!-- Search Bar -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" id="searchInput" placeholder="Search sponsors by title..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="button" onclick="searchSponsors()">
                <i class="ri-search-line"></i>
            </button>
            @if(request('search'))
                <button class="btn btn-outline-danger" type="button" onclick="clearSearch()">
                    <i class="ri-close-line"></i>
                </button>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex gap-2">
            <select class="form-select" id="tierFilter" onchange="filterByTier()">
                <option value="">All Tiers</option>
                <option value="tier1" {{ request('tier') == 'tier1' ? 'selected' : '' }}>Tier 1 - Premium</option>
                <option value="tier2" {{ request('tier') == 'tier2' ? 'selected' : '' }}>Tier 2 - Standard</option>
            </select>
            <select class="form-select" id="statusFilter" onchange="filterByStatus()">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
<div id="alert-container"></div>

<div class="row justify-content-center">
    @if($sponsors->count() > 0)
        <!-- Tier 1 Sponsors -->
        <div class="col-12 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <h5 class="mb-0">Tier 1 - Premium Sponsors</h5>
                <span class="badge bg-warning text-dark">{{ $sponsors->where('tier', 'tier1')->count() }} sponsor(s)</span>
            </div>

            @if($sponsors->where('tier', 'tier1')->count() > 0)
                <div class="masonry">
                    @foreach($sponsors->where('tier', 'tier1') as $sponsor)
                        <div class="masonry-item sponsor-card" id="sponsor-{{ $sponsor->id }}">
                            <img src="{{ Storage::url($sponsor->image) }}"
                                 class="masonry-img"
                                 alt="{{ $sponsor->title }}">

                            <div class="sponsor-overlay">
                                <div class="sponsor-info">
                                    <h6 class="sponsor-title">{{ $sponsor->title }}</h6>
                                    <p class="sponsor-date">{{ $sponsor->created_at->format('M d, Y') }}</p>
                                    @if($sponsor->website_url)
                                        <a href="{{ $sponsor->website_url }}" target="_blank" class="sponsor-website">
                                            <i class="ri-external-link-line me-1"></i>Website
                                        </a>
                                    @endif
                                </div>

                                <div class="sponsor-actions">
                                    <button type="button" class="btn btn-sm btn-outline-light me-1"
                                            onclick="toggleStatus({{ $sponsor->id }})"
                                            title="{{ $sponsor->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="ri-{{ $sponsor->is_active ? 'eye-line' : 'eye-off-line' }}"></i>
                                    </button>
                                    <a href="{{ route('admin.sponsors.edit', $sponsor->id) }}"
                                       class="btn btn-sm btn-outline-light me-1" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteSponsor({{ $sponsor->id }})" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>

                            <span class="res-badge"></span>
                            <div class="status-badge {{ $sponsor->is_active ? 'active' : 'inactive' }}">
                                {{ $sponsor->is_active ? 'Active' : 'Inactive' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="ri-star-line text-muted" style="font-size: 2rem;"></i>
                    <p class="text-muted mt-2 mb-0">No Tier 1 sponsors yet</p>
                </div>
            @endif
        </div>

        <!-- Tier 2 Sponsors -->
        <div class="col-12 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <h5 class="mb-0">Tier 2 - Standard Sponsors</h5>
                <span class="badge bg-info">{{ $sponsors->where('tier', 'tier2')->count() }} sponsor(s)</span>
            </div>

            @if($sponsors->where('tier', 'tier2')->count() > 0)
                <div class="masonry">
                    @foreach($sponsors->where('tier', 'tier2') as $sponsor)
                        <div class="masonry-item sponsor-card" id="sponsor-{{ $sponsor->id }}">
                            <img src="{{ Storage::url($sponsor->image) }}"
                                 class="masonry-img"
                                 alt="{{ $sponsor->title }}">

                            <div class="sponsor-overlay">
                                <div class="sponsor-info">
                                    <h6 class="sponsor-title">{{ $sponsor->title }}</h6>
                                    <p class="sponsor-date">{{ $sponsor->created_at->format('M d, Y') }}</p>
                                    @if($sponsor->website_url)
                                        <a href="{{ $sponsor->website_url }}" target="_blank" class="sponsor-website">
                                            <i class="ri-external-link-line me-1"></i>Website
                                        </a>
                                    @endif
                                </div>

                                <div class="sponsor-actions">
                                    <button type="button" class="btn btn-sm btn-outline-light me-1"
                                            onclick="toggleStatus({{ $sponsor->id }})"
                                            title="{{ $sponsor->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="ri-{{ $sponsor->is_active ? 'eye-line' : 'eye-off-line' }}"></i>
                                    </button>
                                    <a href="{{ route('admin.sponsors.edit', $sponsor->id) }}"
                                       class="btn btn-sm btn-outline-light me-1" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteSponsor({{ $sponsor->id }})" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>

                            <span class="res-badge"></span>
                            <div class="status-badge {{ $sponsor->is_active ? 'active' : 'inactive' }}">
                                {{ $sponsor->is_active ? 'Active' : 'Inactive' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="ri-group-line text-muted" style="font-size: 2rem;"></i>
                    <p class="text-muted mt-2 mb-0">No Tier 2 sponsors yet</p>
                </div>
            @endif
        </div>
    @else
        <div class="col-12">
            <div class="text-center py-5">
                <i class="ri-group-line text-muted" style="font-size: 3rem;"></i>
                <h4 class="text-muted mt-3">No Sponsors Found</h4>
                <p class="text-muted">Create your first sponsor to get started.</p>
                <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary">
                    <i class="ri-add-line me-1"></i>Add First Sponsor
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this sponsor? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.masonry {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
}

.masonry-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 16px rgba(18, 38, 63, .06);
    transition: all 0.3s ease;
}

.masonry-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(18, 38, 63, .1);
}

.masonry-img {
    height: 200px;
    width: 100%;
    object-fit: contain;
    display: block;
    background: #f7f9fc;
}

.sponsor-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 12px;
    opacity: 0;
    transition: all 0.3s ease;
}

.masonry-item:hover .sponsor-overlay {
    opacity: 1;
}

.sponsor-info {
    color: white;
}

.sponsor-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 4px;
    color: white;
}

.sponsor-date {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.8);
    margin-bottom: 4px;
}

.sponsor-website {
    font-size: 0.75rem;
    color: #4fc3f7;
    text-decoration: none;
}

.sponsor-website:hover {
    color: #81d4fa;
}

.sponsor-actions {
    display: flex;
    justify-content: flex-end;
    gap: 4px;
}

.res-badge {
    position: absolute;
    left: 8px;
    bottom: 8px;
    padding: 2px 8px;
    font-size: .75rem;
    font-weight: 600;
    color: #0b1324;
    background: rgba(255,255,255,.9);
    border-radius: 999px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
}

.status-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    padding: 4px 8px;
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.active {
    background: rgba(40, 167, 69, 0.9);
    color: white;
}

.status-badge.inactive {
    background: rgba(108, 117, 125, 0.9);
    color: white;
}
</style>

<script>
let sponsorToDelete = null;

function toggleStatus(sponsorId) {
    const sponsorCard = document.getElementById(`sponsor-${sponsorId}`);
    const statusBadge = sponsorCard?.querySelector('.status-badge');
    const toggleBtn = sponsorCard?.querySelector('[onclick="toggleStatus(' + sponsorId + ')"]');

    if (toggleBtn) {
        toggleBtn.disabled = true;
        toggleBtn.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
    }

    fetch(`/admin/sponsors/${sponsorId}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update status badge
            if (statusBadge) {
                const isActive = data.is_active;
                statusBadge.className = `status-badge ${isActive ? 'active' : 'inactive'}`;
                statusBadge.textContent = isActive ? 'Active' : 'Inactive';
            }

            // Update toggle button
            if (toggleBtn) {
                const isActive = data.is_active;
                toggleBtn.innerHTML = `<i class="ri-${isActive ? 'eye-line' : 'eye-off-line'}"></i>`;
                toggleBtn.title = isActive ? 'Deactivate' : 'Activate';
            }

            showAlert('success', data.message || 'Sponsor status updated successfully');
        } else {
            showAlert('danger', data.message || 'Error updating sponsor status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'An error occurred while updating sponsor status');
    })
    .finally(() => {
        if (toggleBtn) {
            toggleBtn.disabled = false;
        }
    });
}

function deleteSponsor(sponsorId) {
    sponsorToDelete = sponsorId;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (!sponsorToDelete) return;

    // Show loading state
    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';

    fetch(`/admin/sponsors/${sponsorToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove sponsor card with animation
            const sponsorCard = document.getElementById(`sponsor-${sponsorToDelete}`);
            if (sponsorCard) {
                sponsorCard.style.transition = 'all 0.3s ease';
                sponsorCard.style.opacity = '0';
                sponsorCard.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    sponsorCard.remove();

                    // Check if no sponsors left and show empty state
                    const masonry = document.querySelector('.masonry');
                    if (masonry && masonry.querySelectorAll('.masonry-item').length === 0) {
                        location.reload();
                    }
                }, 300);
            }

            showAlert('success', data.message || 'Sponsor deleted successfully');
        } else {
            showAlert('danger', data.message || 'Error deleting sponsor');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'An error occurred while deleting the sponsor');
    })
    .finally(() => {
        // Reset button state
        this.disabled = false;
        this.innerHTML = 'Delete';

        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
    });
});

function showAlert(type, message) {
    const alertContainer = document.getElementById('alert-container');
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    alertContainer.innerHTML = alertHtml;

    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

// Search and Filter Functions
function searchSponsors() {
    const searchTerm = document.getElementById('searchInput').value;
    const url = new URL(window.location);

    if (searchTerm.trim()) {
        url.searchParams.set('search', searchTerm);
    } else {
        url.searchParams.delete('search');
    }

    window.location.href = url.toString();
}

function clearSearch() {
    const url = new URL(window.location);
    url.searchParams.delete('search');
    url.searchParams.delete('tier');
    url.searchParams.delete('status');
    window.location.href = url.toString();
}

function filterByTier() {
    const tier = document.getElementById('tierFilter').value;
    const url = new URL(window.location);

    if (tier) {
        url.searchParams.set('tier', tier);
    } else {
        url.searchParams.delete('tier');
    }

    window.location.href = url.toString();
}

function filterByStatus() {
    const status = document.getElementById('statusFilter').value;
    const url = new URL(window.location);

    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }

    window.location.href = url.toString();
}

// Allow Enter key to trigger search
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchSponsors();
    }
});

// Apply resolution badges
function applyResolutionBadges() {
    document.querySelectorAll('.masonry-img').forEach(img => {
        const setBadge = () => {
            try {
                const w = img.naturalWidth || 0;
                const h = img.naturalHeight || 0;
                const parent = img.parentElement;
                const badge = parent ? parent.querySelector('.res-badge') : null;
                if (badge && w && h) {
                    badge.textContent = `${w} × ${h}`;
                }
            } catch (e) { /* noop */ }
        };
        if (img.complete) {
            setBadge();
        } else {
            img.addEventListener('load', setBadge, { once: true });
            img.addEventListener('error', () => {
                const badge = img.parentElement.querySelector('.res-badge');
                if (badge) { badge.textContent = '–'; }
            }, { once: true });
        }
    });
}

document.addEventListener('DOMContentLoaded', applyResolutionBadges);
</script>
@endpush
