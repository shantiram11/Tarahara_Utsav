<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SponsorController extends Controller
{
    private const VALIDATION_RULES = [
        'store' => [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tier' => 'required|in:tier1,tier2',
            'website_url' => 'nullable|url|max:255',
        ],
        'update' => [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tier' => 'required|in:tier1,tier2',
            'website_url' => 'nullable|url|max:255',
        ]
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sponsors = Sponsor::latest()->get();
        return view('admin.sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sponsors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validateRequest($request, 'store');

            $data = $this->prepareData($request);
            $sponsor = Sponsor::create($data);

            Log::info('Sponsor created', ['id' => $sponsor->id]);

            return $this->successResponse($request, 'Sponsor created successfully.', $sponsor, 'admin.sponsors.index');

        } catch (\Exception $e) {
            Log::error('Error creating sponsor: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating sponsor: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error creating sponsor: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sponsor = Sponsor::findOrFail($id);
        return view('admin.sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sponsor = Sponsor::findOrFail($id);
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $sponsor = Sponsor::findOrFail($id);
            $this->validateRequest($request, 'update');

            $data = $this->prepareData($request, $sponsor);
            $sponsor->update($data);

            Log::info('Sponsor updated', ['id' => $sponsor->id]);

            return $this->successResponse($request, 'Sponsor updated successfully.', $sponsor, 'admin.sponsors.index');

        } catch (\Exception $e) {
            Log::error('Error updating sponsor: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating sponsor: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error updating sponsor: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sponsor = Sponsor::findOrFail($id);
            $this->deleteSponsorFiles($sponsor);
            $sponsor->delete();

            Log::info('Sponsor deleted', ['id' => $sponsor->id]);

            return $this->successResponse(request(), 'Sponsor deleted successfully.', null, 'admin.sponsors.index');

        } catch (\Exception $e) {
            Log::error('Error deleting sponsor: ' . $e->getMessage());

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting sponsor: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error deleting sponsor: ' . $e->getMessage());
        }
    }

    /**
     * Toggle sponsor active status
     */
    public function toggleStatus(Request $request, string $id)
    {
        try {
            $sponsor = Sponsor::findOrFail($id);
            $sponsor->update(['is_active' => !$sponsor->is_active]);

            $status = $sponsor->is_active ? 'activated' : 'deactivated';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Sponsor {$status} successfully",
                    'is_active' => $sponsor->is_active
                ]);
            }

            return redirect()->back()->with('success', "Sponsor {$status} successfully");

        } catch (\Exception $e) {
            Log::error('Error toggling sponsor status: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating sponsor status'
                ], 500);
            }

            return redirect()->back()->with('error', 'Error updating sponsor status');
        }
    }

    /**
     * Validate the request data
     */
    private function validateRequest(Request $request, string $action)
    {
        $rules = self::VALIDATION_RULES[$action];
        $request->validate($rules);
    }

    /**
     * Prepare data for storage/update
     */
    private function prepareData(Request $request, ?Sponsor $sponsor = null): array
    {
        $data = $request->only(['title', 'tier', 'website_url', 'is_active']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if updating
            if ($sponsor && $sponsor->image) {
                Storage::disk('public')->delete($sponsor->image);
            }

            $data['image'] = $request->file('image')->store('sponsors', 'public');
        }

        // Convert is_active to boolean
        if (isset($data['is_active'])) {
            $data['is_active'] = (bool) $data['is_active'];
        }

        return $data;
    }

    /**
     * Delete sponsor associated files
     */
    private function deleteSponsorFiles(Sponsor $sponsor): void
    {
        if ($sponsor->image) {
            Storage::disk('public')->delete($sponsor->image);
        }
    }

    /**
     * Return success response (JSON for AJAX, redirect for regular requests)
     */
    private function successResponse(Request $request, string $message, ?Sponsor $sponsor = null, string $route = null)
    {
        if ($request->expectsJson()) {
            $response = [
                'success' => true,
                'message' => $message,
            ];

            if ($sponsor) {
                $response['sponsor'] = $sponsor;
            }

            if ($route) {
                $response['redirect'] = route($route);
            }

            return response()->json($response);
        }

        return redirect()->route($route)->with('success', $message);
    }
}
