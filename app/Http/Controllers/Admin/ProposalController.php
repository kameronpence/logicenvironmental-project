<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function index()
    {
        $this->checkAccess();
        $proposals = Proposal::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.proposals.index', compact('proposals'));
    }

    public function show(Proposal $proposal)
    {
        $this->checkAccess();
        return view('admin.proposals.show', compact('proposal'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $this->checkAccess();
        $validated = $request->validate([
            'status' => 'required|in:new,reviewed,contacted,completed',
            'notes' => 'nullable|string',
        ]);

        $proposal->update($validated);

        return redirect()->route('admin.proposals.show', $proposal)
            ->with('success', 'Proposal updated successfully.');
    }

    public function destroy(Proposal $proposal)
    {
        $this->checkAccess();
        $proposal->delete();

        return redirect()->route('admin.proposals.index')
            ->with('success', 'Proposal deleted successfully.');
    }

    private function checkAccess()
    {
        if (!auth()->user()->canViewProposals()) {
            abort(403, 'Unauthorized');
        }
    }
}
