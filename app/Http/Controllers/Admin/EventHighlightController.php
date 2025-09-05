<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventHighlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventHighlightController extends Controller
{
    private const VALIDATION_RULES = [
        'store' => [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'date' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'color_scheme' => 'required|in:amber,emerald,rose,blue,green,red,purple,orange,pink',
        ],
        'update' => [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'date' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'color_scheme' => 'required|in:amber,emerald,rose,blue,green,red,purple,orange,pink',
        ],
    ];

    public function index(Request $request)
    {
        $query = EventHighlight::query();

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Filter by color scheme
        if ($request->filled('color')) {
            $query->where('color_scheme', $request->color);
        }

        $highlights = $query->latest()->get();
        return view('admin.event-highlights.index', compact('highlights'));
    }

    public function create()
    {
        return view('admin.event-highlights.create');
    }

    public function store(Request $request)
    {
        try {
            $this->validateRequest($request, 'store');
            $data = $this->prepareData($request);
            $highlight = EventHighlight::create($data);

            Log::info('Event highlight created', ['id' => $highlight->id]);

            return $this->successResponse($request, 'Event highlight created successfully.', $highlight, 'admin.event-highlights.index');
        } catch (\Exception $e) {
            Log::error('Error creating event highlight: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error creating event highlight'], 500);
            }
            return redirect()->back()->with('error', 'Error creating event highlight: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        $highlight = EventHighlight::findOrFail($id);
        return view('admin.event-highlights.edit', compact('highlight'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $highlight = EventHighlight::findOrFail($id);
            $this->validateRequest($request, 'update');
            $data = $this->prepareData($request, $highlight);
            $highlight->update($data);

            Log::info('Event highlight updated', ['id' => $highlight->id]);

            return $this->successResponse($request, 'Event highlight updated successfully.', $highlight, 'admin.event-highlights.index');
        } catch (\Exception $e) {
            Log::error('Error updating event highlight: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error updating event highlight'], 500);
            }
            return redirect()->back()->with('error', 'Error updating event highlight: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $highlight = EventHighlight::findOrFail($id);
            $highlight->delete();

            Log::info('Event highlight deleted', ['id' => $highlight->id]);

            return $this->successResponse(request(), 'Event highlight deleted successfully.', null, 'admin.event-highlights.index');
        } catch (\Exception $e) {
            Log::error('Error deleting event highlight: ' . $e->getMessage());
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error deleting event highlight'], 500);
            }
            return redirect()->back()->with('error', 'Error deleting event highlight');
        }
    }

    public function toggleStatus(Request $request, string $id)
    {
        try {
            $highlight = EventHighlight::findOrFail($id);
            $highlight->update(['is_active' => !$highlight->is_active]);

            $status = $highlight->is_active ? 'activated' : 'deactivated';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Event highlight {$status} successfully",
                    'is_active' => $highlight->is_active,
                ]);
            }

            return redirect()->back()->with('success', "Event highlight {$status} successfully");
        } catch (\Exception $e) {
            Log::error('Error toggling event highlight status: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error updating event highlight status'], 500);
            }
            return redirect()->back()->with('error', 'Error updating event highlight status');
        }
    }

    private function validateRequest(Request $request, string $action): void
    {
        $request->validate(self::VALIDATION_RULES[$action]);
    }

    private function prepareData(Request $request, ?EventHighlight $highlight = null): array
    {
        $data = $request->only(['title', 'description', 'date', 'icon', 'color_scheme', 'is_active']);

        if (isset($data['is_active'])) {
            $data['is_active'] = (bool) $data['is_active'];
        }

        return $data;
    }

    private function successResponse(Request $request, string $message, ?EventHighlight $highlight = null, string $route = null)
    {
        if ($request->expectsJson()) {
            $response = [
                'success' => true,
                'message' => $message,
            ];
            if ($highlight) {
                $response['highlight'] = $highlight;
            }
            if ($route) {
                $response['redirect'] = route($route);
            }
            return response()->json($response);
        }

        return redirect()->route($route)->with('success', $message);
    }
}
