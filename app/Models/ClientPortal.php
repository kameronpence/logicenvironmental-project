<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClientPortal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'project_reference',
        'notes',
        'is_active',
        'last_accessed_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_accessed_at' => 'datetime',
    ];

    /**
     * Get all files for this portal
     */
    public function files()
    {
        return $this->hasMany(ClientFile::class);
    }

    /**
     * Get files uploaded for the client (by admin)
     */
    public function filesForClient()
    {
        return $this->hasMany(ClientFile::class)->where('type', 'for_client');
    }

    /**
     * Get files uploaded by the client
     */
    public function filesFromClient()
    {
        return $this->hasMany(ClientFile::class)->where('type', 'from_client');
    }

    /**
     * Get magic links for this portal
     */
    public function magicLinks()
    {
        return $this->hasMany(MagicLink::class);
    }

    /**
     * Generate a new magic link for this portal
     */
    public function generateMagicLink(int $expiresInHours = 24): MagicLink
    {
        return $this->magicLinks()->create([
            'token' => Str::random(64),
            'email' => $this->email,
            'expires_at' => now()->addHours($expiresInHours),
        ]);
    }

    /**
     * Scope for active portals
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Update last accessed timestamp
     */
    public function markAsAccessed()
    {
        $this->update(['last_accessed_at' => now()]);
    }
}
