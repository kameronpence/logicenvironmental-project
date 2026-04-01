<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $this->checkAccess();
        $logs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.activity.index', compact('logs'));
    }

    private function checkAccess()
    {
        if (!auth()->user()->canViewActivity()) {
            abort(403, 'Unauthorized');
        }
    }
}
