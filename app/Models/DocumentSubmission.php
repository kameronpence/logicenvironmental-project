<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentSubmission extends Model
{
    protected $fillable = [
        'name',
        'email',
        'reference',
        'description',
        'files',
        'status',
        'notes',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new' => 'New',
            'reviewed' => 'Reviewed',
            'completed' => 'Completed',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new' => 'primary',
            'reviewed' => 'warning',
            'completed' => 'success',
            default => 'secondary',
        };
    }
}
