<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'name',
        'email',
        'company',
        'branch',
        'street_address',
        'city',
        'state',
        'zip_code',
        'property_address',
        'county',
        'property_size',
        'owner_name',
        'owner_phone',
        'owner_email',
        'investigation_type',
        'report_deadline',
        'verbal_deadline',
        'hardcopies_needed',
        'report_addressees',
        'num_structures',
        'structure_age',
        'survey_available',
        'prior_reports',
        'access_problems',
        'attachments',
        'status',
        'notes',
    ];

    protected $casts = [
        'attachments' => 'array',
        'num_structures' => 'integer',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new' => 'New',
            'reviewed' => 'Reviewed',
            'contacted' => 'Contacted',
            'completed' => 'Completed',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new' => 'primary',
            'reviewed' => 'info',
            'contacted' => 'warning',
            'completed' => 'success',
            default => 'secondary',
        };
    }
}
