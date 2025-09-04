<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FestivalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FestivalCategoryController extends Controller
{
    const VALIDATION_RULES = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        'content' => 'nullable|string',
        'color_scheme' => 'required|in:violet,rose,emerald,amber,indigo,pink,blue,green,red,yellow'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FestivalCategory::query();

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

        $categories = $query->ordered()->get();
        return view('admin.festival-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.festival-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $this->validateRequest($request);
            $data = $this->prepareData($request);

            $category = FestivalCategory::create($data);

            return $this->successResponse(
                'Festival category created successfully!',
                route('admin.festival-categories.index')
            );
        } catch (\Exception $e) {
            \Log::error('Error creating festival category: ' . $e->getMessage());
            return $this->errorResponse('Error creating festival category: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FestivalCategory $festivalCategory)
    {
        return view('admin.festival-categories.show', compact('festivalCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FestivalCategory $festivalCategory)
    {
        return view('admin.festival-categories.edit', compact('festivalCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FestivalCategory $festivalCategory)
    {
        try {
            $rules = self::VALIDATION_RULES;
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';

            $data = $this->validateRequest($request, $rules);
            $data = $this->prepareData($request, $festivalCategory);

            $festivalCategory->update($data);

            return $this->successResponse(
                'Festival category updated successfully!',
                route('admin.festival-categories.index')
            );
        } catch (\Exception $e) {
            \Log::error('Error updating festival category: ' . $e->getMessage());
            return $this->errorResponse('Error updating festival category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FestivalCategory $festivalCategory)
    {
        try {
            $this->deleteCategoryFiles($festivalCategory);
            $festivalCategory->delete();

            return $this->successResponse('Festival category deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting festival category: ' . $e->getMessage());
            return $this->errorResponse('Error deleting festival category: ' . $e->getMessage());
        }
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(FestivalCategory $festivalCategory)
    {
        try {
            $festivalCategory->update(['is_active' => !$festivalCategory->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Category status updated successfully!',
                'is_active' => $festivalCategory->is_active
            ]);
        } catch (\Exception $e) {
            \Log::error('Error toggling category status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating category status'
            ], 500);
        }
    }

    /**
     * Validate request data
     */
    private function validateRequest(Request $request, array $rules = null)
    {
        return $request->validate($rules ?? self::VALIDATION_RULES);
    }

    /**
     * Prepare data for storage
     */
    private function prepareData(Request $request, ?FestivalCategory $category = null)
    {
        $data = $request->only(['title', 'description', 'content', 'color_scheme']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if updating
            if ($category && $category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')->store('festival-categories', 'public');
        }

        // Generate slug if not provided
        if (empty($data['slug'] ?? '')) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $data;
    }

    /**
     * Delete category files
     */
    private function deleteCategoryFiles(FestivalCategory $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
    }

    /**
     * Success response
     */
    private function successResponse(string $message, string $redirect = null)
    {
        $response = ['success' => true, 'message' => $message];
        if ($redirect) {
            $response['redirect'] = $redirect;
        }
        return response()->json($response);
    }

    /**
     * Error response
     */
    private function errorResponse(string $message)
    {
        return response()->json(['success' => false, 'message' => $message], 500);
    }
}
