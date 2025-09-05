<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdvertisementController extends Controller
{
    private const VALIDATION_RULES = [
        'store' => [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'link_url' => 'nullable|url|max:255',
            'position' => 'required|in:top,bottom,sidebar',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ],
        'update' => [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'link_url' => 'nullable|url|max:255',
            'position' => 'required|in:top,bottom,sidebar',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ],
    ];

    public function index(Request $request)
    {
        $query = Advertisement::query();

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by position
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        // Filter by status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        $advertisements = $query->ordered()->get();
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        return view('admin.advertisements.create');
    }

    public function store(Request $request)
    {
        try {
            $this->validateRequest($request, 'store');
            $data = $this->prepareData($request);
            $advertisement = Advertisement::create($data);

            Log::info('Advertisement created', ['id' => $advertisement->id]);

            return $this->successResponse($request, 'Advertisement created successfully.', $advertisement, 'admin.advertisements.index');
        } catch (\Exception $e) {
            Log::error('Error creating advertisement: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error creating advertisement'], 500);
            }
            return redirect()->back()->with('error', 'Error creating advertisement: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('admin.advertisements.edit', compact('advertisement'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $advertisement = Advertisement::findOrFail($id);
            $this->validateRequest($request, 'update');
            $data = $this->prepareData($request, $advertisement);
            $advertisement->update($data);

            Log::info('Advertisement updated', ['id' => $advertisement->id]);

            return $this->successResponse($request, 'Advertisement updated successfully.', $advertisement, 'admin.advertisements.index');
        } catch (\Exception $e) {
            Log::error('Error updating advertisement: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error updating advertisement'], 500);
            }
            return redirect()->back()->with('error', 'Error updating advertisement: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $advertisement = Advertisement::findOrFail($id);
            $this->deleteAdvertisementFiles($advertisement);
            $advertisement->delete();

            Log::info('Advertisement deleted', ['id' => $advertisement->id]);

            return $this->successResponse(request(), 'Advertisement deleted successfully.', null, 'admin.advertisements.index');
        } catch (\Exception $e) {
            Log::error('Error deleting advertisement: ' . $e->getMessage());
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error deleting advertisement'], 500);
            }
            return redirect()->back()->with('error', 'Error deleting advertisement');
        }
    }

    public function toggleStatus(Request $request, string $id)
    {
        try {
            $advertisement = Advertisement::findOrFail($id);
            $advertisement->update(['is_active' => !$advertisement->is_active]);

            $status = $advertisement->is_active ? 'activated' : 'deactivated';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Advertisement {$status} successfully",
                    'is_active' => $advertisement->is_active,
                ]);
            }

            return redirect()->back()->with('success', "Advertisement {$status} successfully");
        } catch (\Exception $e) {
            Log::error('Error toggling advertisement status: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error updating advertisement status'], 500);
            }
            return redirect()->back()->with('error', 'Error updating advertisement status');
        }
    }

    private function validateRequest(Request $request, string $action): void
    {
        $request->validate(self::VALIDATION_RULES[$action]);
    }

    private function prepareData(Request $request, ?Advertisement $advertisement = null): array
    {
        $data = $request->only(['title', 'link_url', 'position', 'is_active', 'start_date', 'end_date']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if updating
            if ($advertisement && $advertisement->image) {
                Storage::disk('public')->delete($advertisement->image);
            }
            $data['image'] = $request->file('image')->store('advertisements', 'public');
        }

        if (isset($data['is_active'])) {
            $data['is_active'] = (bool) $data['is_active'];
        }

        return $data;
    }

    private function deleteAdvertisementFiles(Advertisement $advertisement): void
    {
        if ($advertisement->image) {
            Storage::disk('public')->delete($advertisement->image);
        }
    }

    private function successResponse(Request $request, string $message, ?Advertisement $advertisement = null, string $route = null)
    {
        if ($request->expectsJson()) {
            $response = [
                'success' => true,
                'message' => $message,
            ];
            if ($advertisement) {
                $response['advertisement'] = $advertisement;
            }
            if ($route) {
                $response['redirect'] = route($route);
            }
            return response()->json($response);
        }

        return redirect()->route($route)->with('success', $message);
    }
}
