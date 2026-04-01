<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::orderBy('sort_order')->get();
        $canCreate = Achievement::canCreateMore();
        $remainingSlots = Achievement::remainingSlots();

        return view('admin.achievements.index', compact('achievements', 'canCreate', 'remainingSlots'));
    }

    public function create()
    {
        if (!Achievement::canCreateMore()) {
            return redirect()->route('admin.achievements.index')
                ->with('error', 'Maximum of 6 achievements allowed.');
        }

        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        if (!Achievement::canCreateMore()) {
            return redirect()->route('admin.achievements.index')
                ->with('error', 'Maximum of 6 achievements allowed.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icon' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['sort_order'] = Achievement::max('sort_order') + 1;
        $validated['is_active'] = $request->has('is_active');

        $achievement = Achievement::create($validated);

        ActivityLog::log('created', $achievement);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement created successfully.');
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icon' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $achievement->update($validated);

        ActivityLog::log('updated', $achievement);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement updated successfully.');
    }

    public function destroy(Achievement $achievement)
    {
        ActivityLog::log('deleted', $achievement);

        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:achievements,id',
        ]);

        foreach ($request->order as $index => $id) {
            Achievement::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
