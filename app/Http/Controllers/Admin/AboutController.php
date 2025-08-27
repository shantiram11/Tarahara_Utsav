<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::first();
        return view('admin.about.index', compact('about'));
    }

    public function create(Request $request)
    {
        // Allow only one About record similar to hero logic
        if (About::count() >= 1) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only one About section is allowed. Please edit the existing one.'
                ], 422);
            }
            return redirect()->route('admin.about.index')
                ->with('error', 'Only one About section is allowed. Please edit the existing one.');
        }
        return view('admin.about.create');
    }

    public function edit()
    {
        $about = About::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $about = About::first() ?? new About();

        $about->title = $request->input('title');
        $about->content = $request->input('content');

        $existing = $about->images ?? [];

        if ($request->hasFile('images')) {
            $uploaded = collect($request->file('images'))
                ->filter()
                ->map(fn($file) => $file->store('about', 'public'))
                ->values()
                ->toArray();

            $merged = array_merge($existing, $uploaded);

            // Enforce even number from dashboard input via validation-style error
            if (count($merged) % 2 !== 0) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['images' => ['Please upload an even number of images.']]
                    ], 422);
                }
                return back()->withErrors(['images' => 'Please upload an even number of images.'])->withInput();
            }

            $about->images = array_values($merged);
        }

        $about->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'about' => $about,
                'redirect' => route('admin.about.index'),
                'message' => 'About section updated'
            ]);
        }

        return redirect()->route('admin.about.index')->with('success', 'About section updated');
    }

    public function store(Request $request)
    {
        if (About::count() >= 1) {
            return redirect()->route('admin.about.index')
                ->with('error', 'Only one About section is allowed. Please edit the existing one.');
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $about = new About();
        $about->title = $request->input('title');
        $about->content = $request->input('content');

        $uploaded = [];
        if ($request->hasFile('images')) {
            $uploaded = collect($request->file('images'))
                ->filter()
                ->map(fn($file) => $file->store('about', 'public'))
                ->values()
                ->toArray();

            if (count($uploaded) % 2 !== 0) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['images' => ['Please upload an even number of images.']]
                    ], 422);
                }
                return back()->withErrors(['images' => 'Please upload an even number of images.'])->withInput();
            }
        }

        $about->images = $uploaded;
        $about->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'about' => $about,
                'redirect' => route('admin.about.index'),
                'message' => 'About section created'
            ]);
        }
        return redirect()->route('admin.about.index')->with('success', 'About section created');
    }

    public function removeImage(Request $request, $index)
    {
        $about = About::firstOrFail();
        $images = $about->images ?? [];
        if (!isset($images[$index])) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }
        Storage::disk('public')->delete($images[$index]);
        unset($images[$index]);
        $images = array_values($images);
        $about->images = $images;
        $about->save();

        return response()->json(['success' => true, 'remaining' => count($images)]);
    }

    public function destroy()
    {
        $about = About::first();
        if ($about) {
            foreach (($about->images ?? []) as $img) {
                Storage::disk('public')->delete($img);
            }
            $about->delete();
        }
        return redirect()->route('admin.about.index')->with('success', 'About section deleted');
    }
}
