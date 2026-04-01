<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $this->checkAccess();
        $members = TeamMember::orderBy('sort_order')->paginate(20);
        $teamSectionTitle = SiteSetting::get('team_section_title', 'Our Team');
        return view('admin.team.index', compact('members', 'teamSectionTitle'));
    }

    public function updateSectionTitle(Request $request)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'team_section_title' => 'required|string|max:255',
        ]);

        SiteSetting::set('team_section_title', $validated['team_section_title']);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'SiteSetting',
            'model_id' => null,
            'model_name' => 'Team Section Title',
            'changes' => ['team_section_title' => $validated['team_section_title']],
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team section title updated successfully.');
    }

    public function create()
    {
        $this->checkAccess();
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Handle cropped photo (base64) or regular file upload
        if ($request->filled('cropped_photo')) {
            $imageData = $request->input('cropped_photo');
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
            $imageData = base64_decode($imageData);
            $filename = 'team_' . time() . '_' . uniqid() . '.jpg';
            Storage::disk('public')->put('team/' . $filename, $imageData);
            $validated['photo'] = $filename;
        } elseif ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('team', 'public');
            $validated['photo'] = basename($path);
        }

        $member = TeamMember::create($validated);

        ActivityLog::log('created', $member);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member added successfully.');
    }

    public function edit(TeamMember $team)
    {
        $this->checkAccess();
        return view('admin.team.edit', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team)
    {
        $this->checkAccess();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Handle cropped photo (base64) or regular file upload
        if ($request->filled('cropped_photo')) {
            // Delete old photo if exists
            if ($team->photo) {
                Storage::disk('public')->delete('team/' . $team->photo);
            }
            // Decode base64 and save
            $imageData = $request->input('cropped_photo');
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
            $imageData = base64_decode($imageData);
            $filename = 'team_' . time() . '_' . uniqid() . '.jpg';
            Storage::disk('public')->put('team/' . $filename, $imageData);
            $validated['photo'] = $filename;
        } elseif ($request->hasFile('photo')) {
            if ($team->photo) {
                Storage::disk('public')->delete('team/' . $team->photo);
            }
            $path = $request->file('photo')->store('team', 'public');
            $validated['photo'] = basename($path);
        }

        $changes = array_diff_assoc(
            collect($validated)->except('photo')->toArray(),
            collect($team->toArray())->except('photo')->toArray()
        );

        $team->update($validated);

        ActivityLog::log('updated', $team, $changes);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $team)
    {
        $this->checkAccess();
        ActivityLog::log('deleted', $team);

        if ($team->photo) {
            Storage::disk('public')->delete('team/' . $team->photo);
        }

        $team->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:team_members,id',
        ]);

        foreach ($request->order as $index => $id) {
            TeamMember::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    private function checkAccess()
    {
        if (!auth()->user()->canManageTeam()) {
            abort(403, 'Unauthorized');
        }
    }
}
