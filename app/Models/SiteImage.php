<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteImage extends Model
{
    protected $fillable = [
        'location',
        'title',
        'image_path',
        'alt_text',
        'overlay_opacity',
        'image_scale',
        'image_position_x',
        'image_position_y',
        'banner_height',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'overlay_opacity' => 'integer',
        'image_scale' => 'integer',
        'image_position_x' => 'integer',
        'image_position_y' => 'integer',
        'banner_height' => 'integer',
    ];

    // Predefined image locations for Site Images admin section
    public const LOCATIONS = [
        'banner' => 'Homepage Banner',
        'services_1' => 'Services Image 1',
        'services_2' => 'Services Image 2',
        'services_3' => 'Services Image 3',
        'services_4' => 'Services Image 4',
    ];

    // Page-specific image locations (managed via page editor)
    public const PAGE_LOCATIONS = [
        'about' => 'About Us Page',
        'history' => 'Company History Page',
        'location_georgia' => 'Georgia Office',
        'location_florida' => 'Florida Office',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return Storage::url($this->image_path);
        }
        return null;
    }

    public static function getByLocation(string $location): ?self
    {
        return self::where('location', $location)->where('is_active', true)->first();
    }

    public static function getImageUrl(string $location): ?string
    {
        $image = self::getByLocation($location);
        return $image?->image_url;
    }
}
