<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientPortal;
use App\Models\ClientFile;
use App\Mail\MagicLinkMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClientPortalController extends Controller
{
    /**
     * Display a listing of client portals.
     */
    public function index()
    {
        $portals = ClientPortal::withCount(['filesForClient', 'filesFromClient'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.client-portals.index', compact('portals'));
    }

    /**
     * Show the form for creating a new client portal.
     */
    public function create()
    {
        return view('admin.client-portals.create');
    }

    /**
     * Store a newly created client portal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'project_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'send_link' => 'boolean',
        ]);

        $portal = ClientPortal::create($validated);

        // Optionally send magic link immediately
        if ($request->boolean('send_link')) {
            $magicLink = $portal->generateMagicLink();
            Mail::to($portal->email)->send(new MagicLinkMail($magicLink));
        }

        return redirect()->route('admin.client-portals.show', $portal)
            ->with('success', 'Client portal created successfully.');
    }

    /**
     * Display the specified client portal.
     */
    public function show(ClientPortal $clientPortal)
    {
        $clientPortal->load(['filesForClient.uploader', 'filesFromClient']);

        return view('admin.client-portals.show', compact('clientPortal'));
    }

    /**
     * Show the form for editing the specified client portal.
     */
    public function edit(ClientPortal $clientPortal)
    {
        return view('admin.client-portals.edit', compact('clientPortal'));
    }

    /**
     * Update the specified client portal.
     */
    public function update(Request $request, ClientPortal $clientPortal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'project_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $clientPortal->update($validated);

        return redirect()->route('admin.client-portals.show', $clientPortal)
            ->with('success', 'Client portal updated successfully.');
    }

    /**
     * Remove the specified client portal.
     */
    public function destroy(ClientPortal $clientPortal)
    {
        $clientPortal->delete();

        return redirect()->route('admin.client-portals.index')
            ->with('success', 'Client portal deleted successfully.');
    }

    /**
     * Upload files for a client.
     */
    public function uploadFiles(Request $request, ClientPortal $clientPortal)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file|max:102400', // 100MB max
            'description' => 'nullable|string',
        ]);

        $uploadedCount = 0;

        foreach ($request->file('files') as $file) {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = 'client-files/' . $clientPortal->id . '/for-client/' . $filename;

            // Store on S3
            Storage::disk('s3')->put($path, file_get_contents($file));

            ClientFile::create([
                'client_portal_id' => $clientPortal->id,
                'filename' => $filename,
                'original_filename' => $file->getClientOriginalName(),
                'file_path' => $path,
                'disk' => 's3',
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'type' => 'for_client',
                'description' => $request->description,
                'uploaded_by' => auth()->id(),
            ]);

            $uploadedCount++;
        }

        return redirect()->route('admin.client-portals.show', $clientPortal)
            ->with('success', "{$uploadedCount} file(s) uploaded successfully.");
    }

    /**
     * Delete a file.
     */
    public function deleteFile(ClientPortal $clientPortal, ClientFile $file)
    {
        if ($file->client_portal_id !== $clientPortal->id) {
            abort(404);
        }

        $file->delete();

        return redirect()->route('admin.client-portals.show', $clientPortal)
            ->with('success', 'File deleted successfully.');
    }

    /**
     * Download a file (for admin).
     */
    public function downloadFile(ClientPortal $clientPortal, ClientFile $file)
    {
        if ($file->client_portal_id !== $clientPortal->id) {
            abort(404);
        }

        return redirect($file->getTemporaryUrl(5));
    }

    /**
     * Send a magic link to the client.
     */
    public function sendMagicLink(ClientPortal $clientPortal)
    {
        $magicLink = $clientPortal->generateMagicLink();

        Mail::to($clientPortal->email)->send(new MagicLinkMail($magicLink));

        return redirect()->route('admin.client-portals.show', $clientPortal)
            ->with('success', 'Magic link sent to ' . $clientPortal->email);
    }
}
