<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->canManageUsers()) {
            abort(403, 'Unauthorized');
        }

        $users = User::where('is_admin', true)->orderBy('name')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->canManageUsers()) {
            abort(403, 'Unauthorized');
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canManageUsers()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'can_manage_pages' => 'boolean',
            'can_manage_team' => 'boolean',
            'can_manage_users' => 'boolean',
            'can_view_activity' => 'boolean',
            'can_view_proposals' => 'boolean',
            'can_manage_services' => 'boolean',
            'can_view_documents' => 'boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => true,
            'role' => 'admin',
            'can_manage_pages' => $request->has('can_manage_pages'),
            'can_manage_team' => $request->has('can_manage_team'),
            'can_manage_users' => $request->has('can_manage_users'),
            'can_view_activity' => $request->has('can_view_activity'),
            'can_view_proposals' => $request->has('can_view_proposals'),
            'can_manage_services' => $request->has('can_manage_services'),
            'can_view_documents' => $request->has('can_view_documents'),
        ]);

        ActivityLog::log('created', $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user created successfully.');
    }

    public function edit(User $user)
    {
        if (!auth()->user()->canManageUsers()) {
            abort(403, 'Unauthorized');
        }

        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Cannot edit super admin');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->canManageUsers()) {
            abort(403, 'Unauthorized');
        }

        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Cannot edit super admin');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'can_manage_pages' => 'boolean',
            'can_manage_team' => 'boolean',
            'can_manage_users' => 'boolean',
            'can_view_activity' => 'boolean',
            'can_view_proposals' => 'boolean',
            'can_manage_services' => 'boolean',
            'can_view_documents' => 'boolean',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if (!$user->isSuperAdmin()) {
            $user->can_manage_pages = $request->has('can_manage_pages');
            $user->can_manage_team = $request->has('can_manage_team');
            $user->can_manage_users = $request->has('can_manage_users');
            $user->can_view_activity = $request->has('can_view_activity');
            $user->can_view_proposals = $request->has('can_view_proposals');
            $user->can_manage_services = $request->has('can_manage_services');
            $user->can_view_documents = $request->has('can_view_documents');
        }

        $user->save();

        ActivityLog::log('updated', $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user updated successfully.');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->canManageUsers()) {
            abort(403, 'Unauthorized');
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete super admin.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete yourself.');
        }

        ActivityLog::log('deleted', $user);

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user deleted successfully.');
    }
}
