<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\TeamMember;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pages' => Page::count(),
            'published_pages' => Page::where('is_published', true)->count(),
            'team_members' => TeamMember::count(),
            'active_team_members' => TeamMember::where('is_active', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
