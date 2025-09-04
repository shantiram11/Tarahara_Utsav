@extends('layouts.admin')
@section('page_title', 'Media Management')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0">Media Management</h2>
            <a href="{{ route('admin.media.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i>Add New Media
            </a>
        </div>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search media by title..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="button" onclick="searchMedia()">
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
                            <th>Logo</th>
                            <th>Title</th>
                            <th>Website</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($media as $index => $item)
                            <tr id="media-row-{{ $item->id }}">
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                <td style="width:88px;">
                                    <img src="{{ $item->image ? Storage::url($item->image) : asset('assets/Logo.png') }}" alt="{{ $item->title }}" class="rounded" style="height:48px; width:auto">
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    @if($item->website_url)
                                        <a href="{{ $item->website_url }}" target="_blank">{{ parse_url($item->website_url, PHP_URL_HOST) }}</a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}" id="status-badge-{{ $item->id }}">{{ $item->is_active ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm {{ $item->is_active ? 'btn-warning' : 'btn-success' }} me-1" onclick="toggleMediaStatus({{ $item->id }})">
                                        {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                    <a href="{{ route('admin.media.edit', $item->id) }}" class="btn btn-sm btn-info me-1">Edit</a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteMedia({{ $item->id }})">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <h5 class="text-muted mb-3">No Media Found</h5>
                                    <a href="{{ route('admin.media.create') }}" class="btn btn-primary">
                                        <i class="ri-add-line me-1"></i>Add First Media
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
        async function toggleMediaStatus(id) {
            try {
                const response = await fetch(`{{ url('admin/media') }}/${id}/toggle-status`, {
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

        async function deleteMedia(id) {
            if (!confirm('Are you sure you want to delete this media item?')) return;
            try {
                const response = await fetch(`{{ url('admin/media') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success || response.ok) {
                    const row = document.getElementById(`media-row-${id}`);
                    if (row) row.remove();
                } else {
                    alert(data.message || 'Failed to delete');
                }
            } catch (e) {
                alert('Failed to delete');
            }
        }

        // Search and Filter Functions
        function searchMedia() {
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
                searchMedia();
            }
        });
    </script>
@endsection
