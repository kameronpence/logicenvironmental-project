<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Page;
use App\Models\SiteImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $this->checkAccess();
        $pages = Page::where('slug', '!=', 'home')
            ->orderBy('sort_order')
            ->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $this->checkAccess();
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer',
            'show_in_menu' => 'boolean',
            'menu_location' => 'nullable|string|in:main,about,footer',
            'menu_title' => 'nullable|string|max:255',
            'sections' => 'nullable|json',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_published'] = $request->has('is_published');
        $validated['show_in_menu'] = $request->has('show_in_menu');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['menu_location'] = $validated['menu_location'] ?? 'main';

        // Parse sections JSON
        if (!empty($validated['sections'])) {
            $validated['sections'] = json_decode($validated['sections'], true);
        }

        $page = Page::create($validated);

        ActivityLog::log('created', $page);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    // Map page slugs to SiteImage locations (single image pages)
    private const PAGE_IMAGE_LOCATIONS = [
        'company-history' => 'history',
        'about' => 'about',
    ];

    // Map page slugs to multiple SiteImage locations
    private const PAGE_MULTI_IMAGE_LOCATIONS = [
        'locations' => [
            'location_georgia' => 'Georgia Office Image',
            'location_florida' => 'Florida Office Image',
        ],
    ];

    public function edit(Page $page)
    {
        $this->checkAccess();

        // Prevent editing home page
        if ($page->slug === 'home') {
            return redirect()->route('admin.pages.index')
                ->with('error', 'The home page cannot be edited here.');
        }

        // Load page-specific image if this page has one
        $pageImage = null;
        $imageLocation = self::PAGE_IMAGE_LOCATIONS[$page->slug] ?? null;
        if ($imageLocation) {
            $pageImage = SiteImage::where('location', $imageLocation)->first();
        }

        // Load multiple images for pages that have them
        $pageImages = [];
        $multiImageLocations = self::PAGE_MULTI_IMAGE_LOCATIONS[$page->slug] ?? null;
        if ($multiImageLocations) {
            foreach ($multiImageLocations as $location => $label) {
                $pageImages[$location] = [
                    'label' => $label,
                    'image' => SiteImage::where('location', $location)->first(),
                ];
            }
        }

        return view('admin.pages.edit', compact('page', 'pageImage', 'imageLocation', 'pageImages', 'multiImageLocations'));
    }

    public function update(Request $request, Page $page)
    {
        $this->checkAccess();

        // Prevent updating home page
        if ($page->slug === 'home') {
            return redirect()->route('admin.pages.index')
                ->with('error', 'The home page cannot be edited here.');
        }

        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer',
            'show_in_menu' => 'boolean',
            'menu_location' => 'nullable|string|in:main,about,footer',
            'menu_title' => 'nullable|string|max:255',
            'sections' => 'nullable|json',
        ];

        // Add image validation for pages with single image
        $imageLocation = self::PAGE_IMAGE_LOCATIONS[$page->slug] ?? null;
        if ($imageLocation) {
            $rules['page_image'] = 'nullable|image|mimes:jpeg,png,gif,webp|max:5120';
            $rules['image_alt_text'] = 'nullable|string|max:255';
        }

        // Add image validation for pages with multiple images
        $multiImageLocations = self::PAGE_MULTI_IMAGE_LOCATIONS[$page->slug] ?? null;
        if ($multiImageLocations) {
            foreach ($multiImageLocations as $location => $label) {
                $rules["images.{$location}"] = 'nullable|image|mimes:jpeg,png,gif,webp|max:5120';
                $rules["image_title.{$location}"] = 'nullable|string|max:255';
                $rules["image_alt.{$location}"] = 'nullable|string|max:255';
            }
        }

        $validated = $request->validate($rules);

        $validated['is_published'] = $request->has('is_published');
        $validated['show_in_menu'] = $request->has('show_in_menu');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['menu_location'] = $validated['menu_location'] ?? 'main';

        // Parse sections JSON
        if (!empty($validated['sections'])) {
            $validated['sections'] = json_decode($validated['sections'], true);
        }

        // Handle section image uploads
        $sectionImages = $request->file('section_images');
        if ($sectionImages && is_array($validated['sections'])) {
            foreach ($request->file('section_images', []) as $sectionIndex => $columnImages) {
                foreach ($columnImages as $columnIndex => $imageFile) {
                    if ($imageFile && $imageFile->isValid()) {
                        // Delete old image if one exists
                        $oldPath = $validated['sections'][$sectionIndex]['columns'][$columnIndex]['content'] ?? null;
                        if ($oldPath && is_string($oldPath) && Storage::disk('public')->exists($oldPath)) {
                            Storage::disk('public')->delete($oldPath);
                        }

                        // Store the new image
                        $path = $imageFile->store('section-images', 'public');

                        // Update the sections data with the new image path
                        if (isset($validated['sections'][$sectionIndex]['columns'][$columnIndex])) {
                            $validated['sections'][$sectionIndex]['columns'][$columnIndex]['content'] = $path;
                        }
                    }
                }
            }
        }

        // Handle page image upload for pages with images
        if ($imageLocation && $request->hasFile('page_image')) {
            $imageTitle = SiteImage::LOCATIONS[$imageLocation] ?? $page->title;
            $siteImage = SiteImage::firstOrCreate(
                ['location' => $imageLocation],
                ['title' => $imageTitle, 'is_active' => true]
            );

            // Delete old image if exists
            if ($siteImage->image_path) {
                Storage::disk('public')->delete($siteImage->image_path);
            }

            $path = $request->file('page_image')->store('site-images', 'public');
            $siteImage->update([
                'image_path' => $path,
                'alt_text' => $request->input('image_alt_text', $page->title),
            ]);
        }

        // Handle multiple image uploads for pages with multiple images
        if ($multiImageLocations) {
            foreach ($multiImageLocations as $location => $label) {
                $hasNewImage = $request->hasFile("images.{$location}");
                $hasUpdatedMeta = $request->has("image_title.{$location}") || $request->has("image_alt.{$location}");

                if ($hasNewImage || $hasUpdatedMeta) {
                    $siteImage = SiteImage::firstOrCreate(
                        ['location' => $location],
                        ['title' => $label, 'is_active' => true]
                    );

                    $updateData = [
                        'title' => $request->input("image_title.{$location}", $siteImage->title ?: $label),
                        'alt_text' => $request->input("image_alt.{$location}", $siteImage->alt_text ?: $label),
                    ];

                    // Handle image upload if provided
                    if ($hasNewImage) {
                        // Delete old image if exists
                        if ($siteImage->image_path) {
                            Storage::disk('public')->delete($siteImage->image_path);
                        }

                        $updateData['image_path'] = $request->file("images.{$location}")->store('site-images', 'public');
                    }

                    $siteImage->update($updateData);
                }
            }
        }

        // Remove image-related fields from page update
        unset($validated['page_image'], $validated['image_alt_text'], $validated['images'], $validated['image_alt'], $validated['image_title']);

        $changes = array_diff_assoc(
            collect($validated)->except('sections')->toArray(),
            collect($page->toArray())->except('sections')->toArray()
        );

        $page->update($validated);

        ActivityLog::log('updated', $page, $changes);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $this->checkAccess();

        // Prevent deleting home page
        if ($page->slug === 'home') {
            return redirect()->route('admin.pages.index')
                ->with('error', 'The home page cannot be deleted.');
        }

        ActivityLog::log('deleted', $page);

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    public function destroyImage(Request $request, Page $page, ?string $location = null)
    {
        $this->checkAccess();

        $deleted = false;

        // If location is provided, delete that specific image (for multi-image pages)
        if ($location) {
            $multiImageLocations = self::PAGE_MULTI_IMAGE_LOCATIONS[$page->slug] ?? [];
            if (array_key_exists($location, $multiImageLocations)) {
                $siteImage = SiteImage::where('location', $location)->first();
                if ($siteImage && $siteImage->image_path) {
                    Storage::disk('public')->delete($siteImage->image_path);
                    $siteImage->update(['image_path' => null]);
                    $deleted = true;
                }
            }
        } else {
            // Single image page
            $imageLocation = self::PAGE_IMAGE_LOCATIONS[$page->slug] ?? null;
            if ($imageLocation) {
                $siteImage = SiteImage::where('location', $imageLocation)->first();
                if ($siteImage && $siteImage->image_path) {
                    Storage::disk('public')->delete($siteImage->image_path);
                    $siteImage->update(['image_path' => null]);
                    $deleted = true;
                }
            }
        }

        // Return JSON for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => $deleted,
                'message' => $deleted ? 'Image removed successfully.' : 'No image found to remove.',
            ]);
        }

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', 'Image removed successfully.');
    }

    private function checkAccess()
    {
        if (!auth()->user()->canManagePages()) {
            abort(403, 'Unauthorized');
        }
    }
}
