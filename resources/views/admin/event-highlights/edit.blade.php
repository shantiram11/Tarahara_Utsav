@extends('layouts.admin')
@section('page_title', 'Edit Event Highlight')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2 class="mb-4">Edit Event Highlight</h2>

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
                <form action="{{ route('admin.event-highlights.update', $highlight->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $highlight->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $highlight->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="date" name="date" value="{{ old('date', $highlight->date) }}" placeholder="e.g., December 15, 2025" required>
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', $highlight->icon) }}" placeholder="e.g., ⭐, 🚩, 👨‍🍳" required>
                        <div class="form-text">Enter an emoji or icon character</div>
                    </div>

                    <div class="mb-3">
                        <label for="color_scheme" class="form-label">Color Scheme <span class="text-danger">*</span></label>
                        <select class="form-select" id="color_scheme" name="color_scheme" required>
                            <option value="">Select a color scheme</option>
                            <option value="amber" {{ old('color_scheme', $highlight->color_scheme) == 'amber' ? 'selected' : '' }}>Amber</option>
                            <option value="emerald" {{ old('color_scheme', $highlight->color_scheme) == 'emerald' ? 'selected' : '' }}>Emerald</option>
                            <option value="rose" {{ old('color_scheme', $highlight->color_scheme) == 'rose' ? 'selected' : '' }}>Rose</option>
                            <option value="blue" {{ old('color_scheme', $highlight->color_scheme) == 'blue' ? 'selected' : '' }}>Blue</option>
                            <option value="green" {{ old('color_scheme', $highlight->color_scheme) == 'green' ? 'selected' : '' }}>Green</option>
                            <option value="red" {{ old('color_scheme', $highlight->color_scheme) == 'red' ? 'selected' : '' }}>Red</option>
                            <option value="purple" {{ old('color_scheme', $highlight->color_scheme) == 'purple' ? 'selected' : '' }}>Purple</option>
                            <option value="orange" {{ old('color_scheme', $highlight->color_scheme) == 'orange' ? 'selected' : '' }}>Orange</option>
                            <option value="pink" {{ old('color_scheme', $highlight->color_scheme) == 'pink' ? 'selected' : '' }}>Pink</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $highlight->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Event Highlight</button>
                        <a href="{{ route('admin.event-highlights.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
