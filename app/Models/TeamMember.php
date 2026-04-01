<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'bio',
        'photo',
        'email',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            // Check if it's in storage or public images
            if (file_exists(public_path('images/team/' . $this->photo))) {
                return asset('images/team/' . $this->photo);
            }
            return asset('storage/team/' . $this->photo);
        }
        return asset('images/team/default-avatar.png');
    }
}
