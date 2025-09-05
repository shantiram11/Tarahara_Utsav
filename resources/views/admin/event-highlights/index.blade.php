@extends('layouts.admin')
@section('page_title', 'Event Highlights Management')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0">Event Highlights Management</h2>
            <a href="{{ route('admin.event-highlights.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i>Add New Event Highlight
            </a>
        </div>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search highlights by title..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="button" onclick="searchHighlights()">
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
                    <select class="form-select" id="statusFilter" onchange="filterByStatus()">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <select class="form-select" id="colorFilter" onchange="filterByColor()">
                        <option value="">All Colors</option>
                        <option value="amber" {{ request('color') == 'amber' ? 'selected' : '' }}>Amber</option>
                        <option value="emerald" {{ request('color') == 'emerald' ? 'selected' : '' }}>Emerald</option>
                        <option value="rose" {{ request('color') == 'rose' ? 'selected' : '' }}>Rose</option>
                        <option value="blue" {{ request('color') == 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="green" {{ request('color') == 'green' ? 'selected' : '' }}>Green</option>
                        <option value="red" {{ request('color') == 'red' ? 'selected' : '' }}>Red</option>
                        <option value="purple" {{ request('color') == 'purple' ? 'selected' : '' }}>Purple</option>
                        <option value="orange" {{ request('color') == 'orange' ? 'selected' : '' }}>Orange</option>
                        <option value="pink" {{ request('color') == 'pink' ? 'selected' : '' }}>Pink</option>
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
                            <th>Icon</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Color</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($highlights as $index => $highlight)
                            <tr id="highlight-row-{{ $highlight->id }}">
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background-color: {{ $highlight->color_scheme === 'amber' ? '#fef3c7' : ($highlight->color_scheme === 'emerald' ? '#d1fae5' : ($highlight->color_scheme === 'rose' ? '#fce7f3' : '#e5e7eb')) }};">
                                        <span style="font-size: 18px;">{{ $highlight->icon }}</span>
                                    </div>
                                </td>
                                <td>{{ $highlight->title }}</td>
                                <td>{{ $highlight->date }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border text-capitalize">{{ $highlight->color_scheme }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $highlight->is_active ? 'bg-success' : 'bg-secondary' }}" id="status-badge-{{ $highlight->id }}">{{ $highlight->is_active ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm {{ $highlight->is_active ? 'btn-warning' : 'btn-success' }} me-1" onclick="toggleHighlightStatus({{ $highlight->id }})">
                                        {{ $highlight->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                    <a href="{{ route('admin.event-highlights.edit', $highlight->id) }}" class="btn btn-sm btn-info me-1">Edit</a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteHighlight({{ $highlight->id }})">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <h5 class="text-muted mb-3">No Event Highlights Found</h5>
                                    <a href="{{ route('admin.event-highlights.create') }}" class="btn btn-primary">
                                        <i class="ri-add-line me-1"></i>Add First Event Highlight
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
        async function toggleHighlightStatus(id) {
            try {
                const response = await fetch(`{{ url('admin/event-highlights') }}/${id}/toggle-status`, {
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

        async function deleteHighlight(id) {
            if (!confirm('Are you sure you want to delete this event highlight?')) return;
            try {
                const response = await fetch(`{{ url('admin/event-highlights') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success || response.ok) {
                    const row = document.getElementById(`highlight-row-${id}`);
                    if (row) row.remove();
                } else {
                    alert(data.message || 'Failed to delete');
                }
            } catch (e) {
                alert('Failed to delete');
            }
        }

        // Search and Filter Functions
        function searchHighlights() {
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
            url.searchParams.delete('status');
            url.searchParams.delete('color');
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

        function filterByColor() {
            const color = document.getElementById('colorFilter').value;
            const url = new URL(window.location);

            if (color) {
                url.searchParams.set('color', color);
            } else {
                url.searchParams.delete('color');
            }

            window.location.href = url.toString();
        }

        // Allow Enter key to trigger search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchHighlights();
            }
        });
    </script>
@endsection
