<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ClientFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_portal_id',
        'filename',
        'original_filename',
        'file_path',
        'disk',
        'file_size',
        'mime_type',
        'type',
        'description',
        'downloaded_at',
        'uploaded_by',
        'notified_team_member_id',
        'notified_at',
    ];

    protected $casts = [
        'downloaded_at' => 'datetime',
        'notified_at' => 'datetime',
        'file_size' => 'integer',
    ];

    /**
     * Get the client portal this file belongs to
     */
    public function portal()
    {
        return $this->belongsTo(ClientPortal::class, 'client_portal_id');
    }

    /**
     * Get the user who uploaded this file (admin)
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the team member who was notified about this file
     */
    public function notifiedTeamMember()
    {
        return $this->belongsTo(TeamMember::class, 'notified_team_member_id');
    }

    /**
     * Check if this file is for the client (uploaded by admin)
     */
    public function isForClient(): bool
    {
        return $this->type === 'for_client';
    }

    /**
     * Check if this file is from the client (uploaded by client)
     */
    public function isFromClient(): bool
    {
        return $this->type === 'from_client';
    }

    /**
     * Get a temporary signed URL for downloading (S3)
     */
    public function getTemporaryUrl(int $minutes = 30): string
    {
        return Storage::disk($this->disk)->temporaryUrl(
            $this->file_path,
            now()->addMinutes($minutes)
        );
    }

    /**
     * Get human-readable file size
     */
    public function getHumanFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Mark file as downloaded
     */
    public function markAsDownloaded()
    {
        $this->update(['downloaded_at' => now()]);
    }

    /**
     * Delete the file from storage
     */
    public function deleteFile(): bool
    {
        if (Storage::disk($this->disk)->exists($this->file_path)) {
            return Storage::disk($this->disk)->delete($this->file_path);
        }
        return true;
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            $file->deleteFile();
        });
    }
}
