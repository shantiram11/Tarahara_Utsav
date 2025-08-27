<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hero;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class HeroController extends Controller
{
    private const VALIDATION_RULES = [
        'store' => [
            'description' => 'nullable|string',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ],
        'update' => [
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]
    ];

    public function index()
    {
        $heroes = Hero::latest()->get();
        return view('admin.heroes.index', compact('heroes'));
    }

    public function create()
    {
        // Check if a hero section already exists
        $heroCount = Hero::count();
        if ($heroCount >= 1) {
            return redirect()->route('admin.heroes.index')
                ->with('error', 'Only one hero section is allowed. Please edit the existing one.');
        }

        return view('admin.heroes.create');
    }

        public function store(Request $request)
    {
        // Check if a hero section already exists
        $heroCount = Hero::count();
        if ($heroCount >= 1) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only one hero section is allowed. Please edit the existing one.'
                ], 422);
            }
            return redirect()->route('admin.heroes.index')
                ->with('error', 'Only one hero section is allowed. Please edit the existing one.');
        }

        $this->validateRequest($request, 'store');

        $data = $this->prepareData($request);
        $hero = Hero::create($data);

        Log::info('Hero created', ['id' => $hero->id]);

        return $this->successResponse($request, 'Hero section created successfully.', $hero, 'admin.heroes.index');
    }

    public function edit(Hero $hero)
    {
        return view('admin.heroes.edit', compact('hero'));
    }

    public function update(Request $request, Hero $hero)
    {
        $this->validateRequest($request, 'update');

        $data = $this->prepareData($request, $hero);
        $hero->update($data);

        Log::info('Hero updated', ['id' => $hero->id]);

        return $this->successResponse($request, 'Hero section updated successfully.', $hero, 'admin.heroes.index');
    }

        public function destroy(Request $request, Hero $hero)
    {
        $this->deleteHeroFiles($hero);
        $hero->delete();

        Log::info('Hero deleted', ['id' => $hero->id]);

        return $this->successResponse($request, 'Hero section deleted successfully.', null, 'admin.heroes.index');
    }

    /**
     * Remove a specific image from hero
     */
    public function removeImage(Request $request, Hero $hero, $imageIndex)
    {
        try {
            $images = $hero->images ?? [];

            if (!isset($images[$imageIndex])) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Image not found'
                    ], 404);
                }
                return redirect()->back()->with('error', 'Image not found');
            }

            // Delete the image file from storage
            Storage::disk('public')->delete($images[$imageIndex]);

            // Remove the image from the array
            unset($images[$imageIndex]);

            // Reindex the array to avoid gaps
            $images = array_values($images);

            // Update the hero with the new images array
            $hero->update(['images' => $images]);

            Log::info('Image removed from hero', [
                'hero_id' => $hero->id,
                'image_index' => $imageIndex,
                'remaining_images' => count($images)
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Image removed successfully',
                    'remaining_images' => count($images)
                ]);
            }

            return redirect()->back()->with('success', 'Image removed successfully');

        } catch (\Exception $e) {
            Log::error('Error removing image: ' . $e->getMessage(), [
                'hero_id' => $hero->id,
                'image_index' => $imageIndex,
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while removing the image: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'An error occurred while removing the image');
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
    private function prepareData(Request $request, ?Hero $hero = null): array
    {
        $data = $request->only(['description']);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $newImages = collect($request->file('images'))
                ->map(fn($image) => $image->store('hero', 'public'))
                ->toArray();

            // Merge with existing images (increment, don't replace)
            $existingImages = $hero?->images ?? [];
            $data['images'] = array_merge($existingImages, $newImages);
        }

        return $data;
    }

    /**
     * Delete hero associated files
     */
    private function deleteHeroFiles(Hero $hero): void
    {
        if ($hero->images) {
            foreach ($hero->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
    }

    /**
     * Return success response (JSON for AJAX, redirect for regular requests)
     */
    private function successResponse(Request $request, string $message, ?Hero $hero = null, string $route = null)
    {
        if ($request->expectsJson()) {
            $response = [
                'success' => true,
                'message' => $message,
            ];

            if ($hero) {
                $response['hero'] = $hero;
            }

            if ($route) {
                $response['redirect'] = route($route);
            }

            return response()->json($response);
        }

        return redirect()->route($route)->with('success', $message);
    }
}
