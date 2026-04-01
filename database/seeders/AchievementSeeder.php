<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            [
                'title' => '20+ Years',
                'subtitle' => 'Industry experience',
                'icon' => 'fa-award',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Expert Team',
                'subtitle' => 'Licensed specialists',
                'icon' => 'fa-users',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Fast Turnaround',
                'subtitle' => 'Quick response times',
                'icon' => 'fa-clock',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Client Focused',
                'subtitle' => 'Personalized solutions',
                'icon' => 'fa-handshake',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
