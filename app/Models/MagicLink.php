<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagicLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_portal_id',
        'token',
        'email',
        'expires_at',
        'used_at',
        'ip_address',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    /**
     * Get the client portal this link belongs to
     */
    public function portal()
    {
        return $this->belongsTo(ClientPortal::class, 'client_portal_id');
    }

    /**
     * Check if the link is valid (not expired and not used)
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->isUsed();
    }

    /**
     * Check if the link has expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if the link has been used
     */
    public function isUsed(): bool
    {
        return $this->used_at !== null;
    }

    /**
     * Mark the link as used
     */
    public function markAsUsed(?string $ipAddress = null): void
    {
        $this->update([
            'used_at' => now(),
            'ip_address' => $ipAddress,
        ]);
    }

    /**
     * Scope for valid links
     */
    public function scopeValid($query)
    {
        return $query->whereNull('used_at')
            ->where('expires_at', '>', now());
    }

    /**
     * Find a valid link by token
     */
    public static function findValidByToken(string $token): ?self
    {
        return static::where('token', $token)
            ->valid()
            ->first();
    }

    /**
     * Get the full URL for this magic link
     */
    public function getUrl(): string
    {
        return route('client-portal.access', ['token' => $this->token]);
    }
}
