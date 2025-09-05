@extends('layouts.admin')
@section('page_title', 'Edit Advertisement')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2 class="mb-4">Edit Advertisement</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.advertisements.update', $advertisement->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $advertisement->title) }}" required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ Storage::url($advertisement->image) }}" alt="{{ $advertisement->title }}" class="rounded border" style="height:120px; width:auto; max-width: 100%;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">New Advertisement Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Accepted: JPG, JPEG, PNG, WEBP. Max 5MB. Recommended size: 1200x300px for top banners.</div>
                    </div>

                    <div class="mb-3">
                        <label for="link_url" class="form-label">Link URL</label>
                        <input type="url" class="form-control" id="link_url" name="link_url" value="{{ old('link_url', $advertisement->link_url) }}" placeholder="https://example.com">
                        <div class="form-text">Optional: Where users should be redirected when they click the advertisement</div>
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                        <select class="form-select" id="position" name="position" required>
                            <option value="">Select Position</option>
                            <option value="top" {{ old('position', $advertisement->position) == 'top' ? 'selected' : '' }}>Top (Above Navigation)</option>
                            <option value="bottom" {{ old('position', $advertisement->position) == 'bottom' ? 'selected' : '' }}>Bottom (Footer Area)</option>
                            <option value="sidebar" {{ old('position', $advertisement->position) == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $advertisement->start_date ? $advertisement->start_date->format('Y-m-d\TH:i') : '') }}">
                                <div class="form-text">Leave empty for immediate display</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $advertisement->end_date ? $advertisement->end_date->format('Y-m-d\TH:i') : '') }}">
                                <div class="form-text">Leave empty for permanent display</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $advertisement->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Advertisement</button>
                        <a href="{{ route('admin.advertisements.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
