<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $this->checkAccess();
        $services = Service::orderBy('sort_order')->paginate(20);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $this->checkAccess();
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $this->checkAccess();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'short_description' => 'required|string',
            'full_description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? Service::max('sort_order') + 1;

        $service = Service::create($validated);

        ActivityLog::log('created', $service);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service added successfully.');
    }

    public function edit(Service $service)
    {
        $this->checkAccess();
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $this->checkAccess();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'short_description' => 'required|string',
            'full_description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $changes = array_diff_assoc($validated, $service->toArray());

        $service->update($validated);

        ActivityLog::log('updated', $service, $changes);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $this->checkAccess();
        ActivityLog::log('deleted', $service);

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:services,id',
        ]);

        foreach ($request->order as $index => $id) {
            Service::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    private function checkAccess()
    {
        if (!auth()->user()->canManageServices()) {
            abort(403, 'Unauthorized');
        }
    }
}
