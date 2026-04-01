<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'sections',
        'meta_title',
        'meta_description',
        'is_published',
        'show_in_menu',
        'menu_location',
        'menu_title',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_in_menu' => 'boolean',
        'sections' => 'array',
    ];

    public function hasSections(): bool
    {
        return !empty($this->sections) && count($this->sections) > 0;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true)->where('is_published', true);
    }

    public function scopeMenuLocation($query, $location)
    {
        return $query->where('menu_location', $location);
    }

    public function getMenuDisplayTitleAttribute(): string
    {
        return $this->menu_title ?: $this->title;
    }
}
