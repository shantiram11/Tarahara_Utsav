@extends('layouts.admin')
@section('page_title', 'Advertisements Management')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0">Advertisements Management</h2>
            <a href="{{ route('admin.advertisements.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i>Add New Advertisement
            </a>
        </div>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search advertisements by title..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="button" onclick="searchAdvertisements()">
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
                    <select class="form-select" id="positionFilter" onchange="filterByPosition()">
                        <option value="">All Positions</option>
                        <option value="top" {{ request('position') == 'top' ? 'selected' : '' }}>Top</option>
                        <option value="bottom" {{ request('position') == 'bottom' ? 'selected' : '' }}>Bottom</option>
                        <option value="sidebar" {{ request('position') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                    </select>
                    <select class="form-select" id="statusFilter" onchange="filterByStatus()">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Position</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Date Range</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($advertisements as $index => $advertisement)
                            <tr id="advertisement-row-{{ $advertisement->id }}">
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                <td style="width:100px;">
                                    <img src="{{ Storage::url($advertisement->image) }}" alt="{{ $advertisement->title }}" class="rounded" style="height:60px; width:100px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $advertisement->title }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info text-capitalize">{{ $advertisement->position }}</span>
                                </td>
                                <td>
                                    @if($advertisement->link_url)
                                        <a href="{{ $advertisement->link_url }}" target="_blank" class="text-primary">
                                            <i class="ri-external-link-line"></i> View
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $advertisement->is_active ? 'bg-success' : 'bg-secondary' }}" id="status-badge-{{ $advertisement->id }}">{{ $advertisement->is_active ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td>
                                    @if($advertisement->start_date || $advertisement->end_date)
                                        <small>
                                            @if($advertisement->start_date)
                                                {{ $advertisement->start_date->format('M d, Y') }}
                                            @else
                                                Always
                                            @endif
                                            @if($advertisement->end_date)
                                                - {{ $advertisement->end_date->format('M d, Y') }}
                                            @endif
                                        </small>
                                    @else
                                        <span class="text-muted">Always</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm {{ $advertisement->is_active ? 'btn-warning' : 'btn-success' }} me-1" onclick="toggleAdvertisementStatus({{ $advertisement->id }})">
                                        {{ $advertisement->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                    <a href="{{ route('admin.advertisements.edit', $advertisement->id) }}" class="btn btn-sm btn-info me-1">Edit</a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteAdvertisement({{ $advertisement->id }})">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <h5 class="text-muted mb-3">No Advertisements Found</h5>
                                    <a href="{{ route('admin.advertisements.create') }}" class="btn btn-primary">
                                        <i class="ri-add-line me-1"></i>Add First Advertisement
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        async function toggleAdvertisementStatus(id) {
            try {
                const response = await fetch(`{{ url('admin/advertisements') }}/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    const badge = document.getElementById(`status-badge-${id}`);
                    badge.textContent = data.is_active ? 'Active' : 'Inactive';
                    badge.classList.toggle('bg-success', data.is_active);
                    badge.classList.toggle('bg-secondary', !data.is_active);
                } else {
                    alert(data.message || 'Failed to update status');
                }
            } catch (e) {
                alert('Failed to update status');
            }
        }

        async function deleteAdvertisement(id) {
            if (!confirm('Are you sure you want to delete this advertisement?')) return;
            try {
                const response = await fetch(`{{ url('admin/advertisements') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success || response.ok) {
                    const row = document.getElementById(`advertisement-row-${id}`);
                    if (row) row.remove();
                } else {
                    alert(data.message || 'Failed to delete');
                }
            } catch (e) {
                alert('Failed to delete');
            }
        }

        // Search and Filter Functions
        function searchAdvertisements() {
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
            url.searchParams.delete('position');
            url.searchParams.delete('status');
            window.location.href = url.toString();
        }

        function filterByPosition() {
            const position = document.getElementById('positionFilter').value;
            const url = new URL(window.location);

            if (position) {
                url.searchParams.set('position', position);
            } else {
                url.searchParams.delete('position');
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
                searchAdvertisements();
            }
        });
    </script>
@endsection
