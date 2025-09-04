@extends('layouts.admin')
@section('page_title', 'Edit Media')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2 class="mb-4">Edit Media</h2>

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
                <form action="{{ route('admin.media.update', $media->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $media->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="website_url" class="form-label">Website URL</label>
                        <input type="url" class="form-control" id="website_url" name="website_url" value="{{ old('website_url', $media->website_url) }}" placeholder="https://example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Current Logo/Image</label>
                        <div>
                            <img src="{{ $media->image ? Storage::url($media->image) : asset('assets/Logo.png') }}" alt="{{ $media->title }}" class="rounded border" style="height:72px; width:auto">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">New Logo/Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Accepted: JPG, JPEG, PNG, WEBP. Max 2MB.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $media->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Media</button>
                        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
