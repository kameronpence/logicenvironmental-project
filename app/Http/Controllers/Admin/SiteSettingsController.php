<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->canManageSettings()) {
            abort(403);
        }

        // Get notification emails (new format) or migrate from old format
        $notificationEmails = SiteSetting::get('notification_emails');
        if ($notificationEmails) {
            $notificationEmails = json_decode($notificationEmails, true) ?: [];
        } else {
            // Migrate from old single email format
            $oldEmail = SiteSetting::get('recipient_email', 'info@logicenvironmental.com');
            $notificationEmails = [
                ['email' => $oldEmail, 'proposal' => true, 'contact' => true, 'client_uploads' => true]
            ];
        }

        return view('admin.settings.index', compact('notificationEmails'));
    }

    public function update(Request $request)
    {
        if (!auth()->user()->canManageSettings()) {
            abort(403);
        }

        $validated = $request->validate([
            'emails' => 'required|array|min:1',
            'emails.*.email' => 'required|email|max:255',
            'emails.*.proposal' => 'nullable|boolean',
            'emails.*.contact' => 'nullable|boolean',
            'emails.*.client_uploads' => 'nullable|boolean',
        ]);

        // Build the notification emails array
        $notificationEmails = [];
        foreach ($validated['emails'] as $emailData) {
            $notificationEmails[] = [
                'email' => $emailData['email'],
                'proposal' => !empty($emailData['proposal']),
                'contact' => !empty($emailData['contact']),
                'client_uploads' => !empty($emailData['client_uploads']),
            ];
        }

        SiteSetting::set('notification_emails', json_encode($notificationEmails));

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'SiteSetting',
            'model_id' => null,
            'model_name' => 'Site Settings',
            'changes' => ['notification_emails' => $notificationEmails],
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Get email addresses for a specific form type.
     */
    public static function getEmailsForForm(string $formType): array
    {
        $notificationEmails = SiteSetting::get('notification_emails');
        if ($notificationEmails) {
            $emails = json_decode($notificationEmails, true) ?: [];
        } else {
            // Fallback to old format
            $oldEmail = SiteSetting::get('recipient_email', 'info@logicenvironmental.com');
            return [$oldEmail];
        }

        $recipients = [];
        foreach ($emails as $entry) {
            if (!empty($entry[$formType]) && !empty($entry['email'])) {
                $recipients[] = $entry['email'];
            }
        }

        // Fallback if no recipients configured
        if (empty($recipients)) {
            return ['info@logicenvironmental.com'];
        }

        return $recipients;
    }
}
