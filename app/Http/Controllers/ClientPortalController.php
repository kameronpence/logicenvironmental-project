<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SiteSettingsController;
use App\Models\ClientPortal;
use App\Models\ClientFile;
use App\Models\MagicLink;
use App\Models\TeamMember;
use App\Mail\MagicLinkMail;
use App\Mail\ClientFileUploadedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClientPortalController extends Controller
{
    /**
     * Show the magic link request form.
     */
    public function showRequestForm()
    {
        return view('client-portal.request-link');
    }

    /**
     * Process magic link request.
     */
    public function requestLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = strtolower(trim($request->email));

        // Find all active portals for this email
        $portals = ClientPortal::where('email', $email)
            ->where('is_active', true)
            ->get();

        if ($portals->isEmpty()) {
            // Don't reveal whether email exists - just show success message
            return back()->with('success', 'If your email is in our system, you will receive an access link shortly.');
        }

        // Generate and send magic link for each portal
        // (In most cases there will be one, but client could have multiple projects)
        foreach ($portals as $portal) {
            $magicLink = $portal->generateMagicLink();
            Mail::to($email)->send(new MagicLinkMail($magicLink));
        }

        return back()->with('success', 'If your email is in our system, you will receive an access link shortly.');
    }

    /**
     * Access portal via magic link.
     */
    public function access(string $token)
    {
        $magicLink = MagicLink::findValidByToken($token);

        if (!$magicLink) {
            return view('client-portal.invalid-link');
        }

        // Mark link as used and record IP
        $magicLink->markAsUsed(request()->ip());

        // Update portal last accessed
        $magicLink->portal->markAsAccessed();

        // Store portal access in session (valid for 2 hours)
        session([
            'client_portal_id' => $magicLink->client_portal_id,
            'client_portal_expires' => now()->addHours(2),
        ]);

        return redirect()->route('client-portal.dashboard');
    }

    /**
     * Show the client portal dashboard.
     */
    public function dashboard()
    {
        $portal = $this->getAuthenticatedPortal();

        if (!$portal) {
            return redirect()->route('client-portal.request')
                ->with('error', 'Your session has expired. Please request a new access link.');
        }

        $filesForClient = $portal->filesForClient()->orderBy('created_at', 'desc')->get();
        $filesFromClient = $portal->filesFromClient()->orderBy('created_at', 'desc')->get();

        // Get active team members with email addresses for notification selection
        $teamMembers = TeamMember::active()->whereNotNull('email')->where('email', '!=', '')->orderBy('name')->get();

        return view('client-portal.dashboard', compact('portal', 'filesForClient', 'filesFromClient', 'teamMembers'));
    }

    /**
     * Download a file.
     */
    public function downloadFile(ClientFile $file)
    {
        $portal = $this->getAuthenticatedPortal();

        if (!$portal || $file->client_portal_id !== $portal->id) {
            abort(403);
        }

        // Only allow downloading files meant for the client
        if (!$file->isForClient()) {
            abort(403);
        }

        // Mark as downloaded
        $file->markAsDownloaded();

        // Return temporary S3 URL
        return redirect($file->getTemporaryUrl(5));
    }

    /**
     * Upload files from client.
     */
    public function uploadFiles(Request $request)
    {
        $portal = $this->getAuthenticatedPortal();

        if (!$portal) {
            return redirect()->route('client-portal.request')
                ->with('error', 'Your session has expired. Please request a new access link.');
        }

        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file|max:102400', // 100MB max
            'description' => 'nullable|string|max:1000',
            'notify_team_member' => 'nullable|exists:team_members,id',
        ]);

        $uploadedFiles = [];
        $teamMemberId = $request->notify_team_member;

        foreach ($request->file('files') as $file) {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = 'client-files/' . $portal->id . '/from-client/' . $filename;

            // Store on S3
            Storage::disk('s3')->put($path, file_get_contents($file));

            $clientFile = ClientFile::create([
                'client_portal_id' => $portal->id,
                'filename' => $filename,
                'original_filename' => $file->getClientOriginalName(),
                'file_path' => $path,
                'disk' => 's3',
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'type' => 'from_client',
                'description' => $request->description,
                'notified_team_member_id' => $teamMemberId,
            ]);

            $uploadedFiles[] = [
                'original_filename' => $file->getClientOriginalName(),
                'human_size' => $clientFile->human_file_size,
            ];
        }

        // Send notification
        $notificationSent = false;

        if ($teamMemberId) {
            // Send to selected team member
            $teamMember = TeamMember::find($teamMemberId);
            if ($teamMember && $teamMember->email) {
                try {
                    Mail::to($teamMember->email)->send(new ClientFileUploadedMail(
                        $portal,
                        $teamMember,
                        $uploadedFiles,
                        $request->description
                    ));

                    // Update all uploaded files with notification timestamp
                    ClientFile::where('client_portal_id', $portal->id)
                        ->where('notified_team_member_id', $teamMemberId)
                        ->whereNull('notified_at')
                        ->update(['notified_at' => now()]);

                    $notificationSent = true;
                } catch (\Exception $e) {
                    Log::warning('Failed to send file upload notification to team member: ' . $e->getMessage());
                }
            }
        } else {
            // No team member selected - send to site settings emails configured for client_uploads
            $recipientEmails = SiteSettingsController::getEmailsForForm('client_uploads');
            if (!empty($recipientEmails)) {
                try {
                    Mail::to($recipientEmails)->send(new ClientFileUploadedMail(
                        $portal,
                        null,
                        $uploadedFiles,
                        $request->description
                    ));
                    $notificationSent = true;
                } catch (\Exception $e) {
                    Log::warning('Failed to send file upload notification to site settings emails: ' . $e->getMessage());
                }
            }
        }

        $uploadedCount = count($uploadedFiles);
        $message = "{$uploadedCount} file(s) uploaded successfully.";
        if ($notificationSent) {
            $message .= " Our team has been notified.";
        }

        return redirect()->route('client-portal.dashboard')
            ->with('success', $message);
    }

    /**
     * Logout from client portal.
     */
    public function logout()
    {
        session()->forget(['client_portal_id', 'client_portal_expires']);

        return redirect()->route('client-portal.request')
            ->with('success', 'You have been logged out.');
    }

    /**
     * Get the authenticated portal from session.
     */
    protected function getAuthenticatedPortal(): ?ClientPortal
    {
        $portalId = session('client_portal_id');
        $expires = session('client_portal_expires');

        if (!$portalId || !$expires || now()->isAfter($expires)) {
            session()->forget(['client_portal_id', 'client_portal_expires']);
            return null;
        }

        return ClientPortal::where('id', $portalId)
            ->where('is_active', true)
            ->first();
    }
}
