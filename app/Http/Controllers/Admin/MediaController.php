<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    private const VALIDATION_RULES = [
        'store' => [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'website_url' => 'nullable|url|max:255',
        ],
        'update' => [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'website_url' => 'nullable|url|max:255',
        ],
    ];

    public function index(Request $request)
    {
        $query = Media::query();

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        $media = $query->latest()->get();
        return view('admin.media.index', compact('media'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        try {
            $this->validateRequest($request, 'store');
            $data = $this->prepareData($request);
            $media = Media::create($data);

            Log::info('Media created', ['id' => $media->id]);

            return $this->successResponse($request, 'Media created successfully.', $media, 'admin.media.index');
        } catch (\Exception $e) {
            Log::error('Error creating media: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error creating media'], 500);
            }
            return redirect()->back()->with('error', 'Error creating media: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        $media = Media::findOrFail($id);
        return view('admin.media.edit', compact('media'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $media = Media::findOrFail($id);
            $this->validateRequest($request, 'update');
            $data = $this->prepareData($request, $media);
            $media->update($data);

            Log::info('Media updated', ['id' => $media->id]);

            return $this->successResponse($request, 'Media updated successfully.', $media, 'admin.media.index');
        } catch (\Exception $e) {
            Log::error('Error updating media: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error updating media'], 500);
            }
            return redirect()->back()->with('error', 'Error updating media: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $media = Media::findOrFail($id);
            $this->deleteMediaFiles($media);
            $media->delete();

            Log::info('Media deleted', ['id' => $media->id]);

            return $this->successResponse(request(), 'Media deleted successfully.', null, 'admin.media.index');
        } catch (\Exception $e) {
            Log::error('Error deleting media: ' . $e->getMessage());
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error deleting media'], 500);
            }
            return redirect()->back()->with('error', 'Error deleting media');
        }
    }

    public function toggleStatus(Request $request, string $id)
    {
        try {
            $media = Media::findOrFail($id);
            $media->update(['is_active' => !$media->is_active]);

            $status = $media->is_active ? 'activated' : 'deactivated';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Media {$status} successfully",
                    'is_active' => $media->is_active,
                ]);
            }

            return redirect()->back()->with('success', "Media {$status} successfully");
        } catch (\Exception $e) {
            Log::error('Error toggling media status: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error updating media status'], 500);
            }
            return redirect()->back()->with('error', 'Error updating media status');
        }
    }

    private function validateRequest(Request $request, string $action): void
    {
        $request->validate(self::VALIDATION_RULES[$action]);
    }

    private function prepareData(Request $request, ?Media $media = null): array
    {
        $data = $request->only(['title', 'website_url', 'is_active']);

        if ($request->hasFile('image')) {
            if ($media && $media->image) {
                Storage::disk('public')->delete($media->image);
            }
            $data['image'] = $request->file('image')->store('media', 'public');
        }

        if (isset($data['is_active'])) {
            $data['is_active'] = (bool) $data['is_active'];
        }

        return $data;
    }

    private function deleteMediaFiles(Media $media): void
    {
        if ($media->image) {
            Storage::disk('public')->delete($media->image);
        }
    }

    private function successResponse(Request $request, string $message, ?Media $media = null, string $route = null)
    {
        if ($request->expectsJson()) {
            $response = [
                'success' => true,
                'message' => $message,
            ];
            if ($media) {
                $response['media'] = $media;
            }
            if ($route) {
                $response['redirect'] = route($route);
            }
            return response()->json($response);
        }

        return redirect()->route($route)->with('success', $message);
    }
}
