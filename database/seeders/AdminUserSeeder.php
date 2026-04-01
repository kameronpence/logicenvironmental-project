<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@logicenvironmental.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'role' => 'super_admin',
            'can_manage_pages' => true,
            'can_manage_team' => true,
            'can_manage_users' => true,
            'can_view_activity' => true,
            'can_view_proposals' => true,
            'email_verified_at' => now(),
        ]);
    }
}
