<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteImage;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteImageController extends Controller
{
    public function index()
    {
        $images = [];
        foreach (SiteImage::LOCATIONS as $location => $label) {
            $images[$location] = [
                'label' => $label,
                'image' => SiteImage::where('location', $location)->first(),
            ];
        }

        return view('admin.images.index', compact('images'));
    }

    public function edit(string $location)
    {
        if (!array_key_exists($location, SiteImage::LOCATIONS)) {
            abort(404);
        }

        $image = SiteImage::where('location', $location)->first();
        $label = SiteImage::LOCATIONS[$location];

        return view('admin.images.edit', compact('image', 'location', 'label'));
    }

    public function update(Request $request, string $location)
    {
        if (!array_key_exists($location, SiteImage::LOCATIONS)) {
            abort(404);
        }

        $rules = [
            'title' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_active' => 'boolean',
        ];

        // Add overlay opacity, image scale, position, and height validation for banner
        if ($location === 'banner') {
            $rules['overlay_opacity'] = 'nullable|integer|min:0|max:100';
            $rules['image_scale'] = 'nullable|integer|min:20|max:200';
            $rules['image_position_x'] = 'nullable|integer|min:0|max:100';
            $rules['image_position_y'] = 'nullable|integer|min:0|max:100';
            $rules['banner_height'] = 'nullable|integer|min:100|max:600';
        }

        $validated = $request->validate($rules);

        // Find existing record or create new one
        $image = SiteImage::where('location', $location)->first();
        $existingImagePath = $image?->image_path;

        if (!$image) {
            $image = new SiteImage();
            $image->location = $location;
        }

        $image->title = $validated['title'] ?? null;
        $image->alt_text = $validated['alt_text'] ?? null;
        $image->is_active = $request->has('is_active');

        // Set overlay opacity, image scale, position, and height for banner
        if ($location === 'banner') {
            $image->overlay_opacity = $validated['overlay_opacity'] ?? 60;
            $image->image_scale = $validated['image_scale'] ?? 100;
            $image->image_position_x = $validated['image_position_x'] ?? 50;
            $image->image_position_y = $validated['image_position_y'] ?? 50;
            $image->banner_height = $validated['banner_height'] ?? 300;
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($existingImagePath) {
                Storage::delete($existingImagePath);
            }

            $path = $request->file('image')->store('site-images', 'public');
            $image->image_path = $path;
        } else {
            // Preserve existing image path
            $image->image_path = $existingImagePath;
        }

        $image->save();

        ActivityLog::log('updated', $image);

        return redirect()->route('admin.images.index')
            ->with('success', SiteImage::LOCATIONS[$location] . ' updated successfully.');
    }

    public function destroy(string $location)
    {
        if (!array_key_exists($location, SiteImage::LOCATIONS)) {
            abort(404);
        }

        $image = SiteImage::where('location', $location)->first();

        if ($image) {
            // Only delete the image file, keep the record
            if ($image->image_path) {
                Storage::delete($image->image_path);
                $image->image_path = null;
                $image->save();
                ActivityLog::log('removed image from', $image);
            }
        }

        return redirect()->route('admin.images.index')
            ->with('success', 'Image removed successfully.');
    }
}
