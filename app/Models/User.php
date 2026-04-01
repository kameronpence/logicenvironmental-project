<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'role',
        'can_manage_pages',
        'can_manage_team',
        'can_manage_users',
        'can_view_activity',
        'can_view_proposals',
        'can_manage_services',
        'can_view_documents',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'can_manage_pages' => 'boolean',
            'can_manage_team' => 'boolean',
            'can_manage_users' => 'boolean',
            'can_view_activity' => 'boolean',
            'can_view_proposals' => 'boolean',
            'can_manage_services' => 'boolean',
            'can_view_documents' => 'boolean',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function canManagePages(): bool
    {
        return $this->isSuperAdmin() || $this->can_manage_pages;
    }

    public function canManageTeam(): bool
    {
        return $this->isSuperAdmin() || $this->can_manage_team;
    }

    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin() || $this->can_manage_users;
    }

    public function canViewActivity(): bool
    {
        return $this->isSuperAdmin() || $this->can_view_activity;
    }

    public function canViewProposals(): bool
    {
        return $this->isSuperAdmin() || $this->can_view_proposals;
    }

    public function canManageSettings(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canManageServices(): bool
    {
        return $this->isSuperAdmin() || $this->can_manage_services;
    }

    public function canViewDocuments(): bool
    {
        return $this->isSuperAdmin() || $this->can_view_documents;
    }
}
