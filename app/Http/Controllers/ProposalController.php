<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SiteSettingsController;
use App\Mail\ProposalRequest;
use App\Mail\ContactRequest;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProposalController extends Controller
{
    /**
     * Verify Cloudflare Turnstile response
     */
    private function verifyTurnstile(Request $request): bool
    {
        $token = $request->input('cf-turnstile-response');

        if (!$token) {
            return false;
        }

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret_key'),
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        return $response->json('success', false);
    }

    public function submit(Request $request)
    {
        // Verify Turnstile
        if (!$this->verifyTurnstile($request)) {
            return back()
                ->withInput()
                ->withErrors(['cf-turnstile-response' => 'Please complete the security verification.']);
        }

        $validated = $request->validate([
            // Person Requesting
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            // Property Information
            'property_address' => 'required|string|max:500',
            'county' => 'required|string|max:255',
            'property_size' => 'required|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:50',
            'owner_email' => 'nullable|email|max:255',
            // Proposal Information
            'investigation_type' => 'required|string',
            'report_deadline' => 'required|string',
            'verbal_deadline' => 'nullable|string',
            'hardcopies_needed' => 'required|string|in:Yes,No',
            'report_addressees' => 'required|string',
            'num_structures' => 'required|integer|min:0|max:15',
            'structure_age' => 'required|string|max:255',
            'survey_available' => 'required|string',
            'prior_reports' => 'required|string',
            'access_problems' => 'required|string',
            // File attachments (max 100MB per file, 5 files total)
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'nullable|file|max:102400',
        ]);

        // Handle file uploads
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('proposal-attachments', 'public');
                $attachmentPaths[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                ];
            }
        }
        $validated['attachments'] = $attachmentPaths;

        // Save to database
        $proposal = Proposal::create($validated);

        // Try to send email, but don't fail if mail isn't configured
        try {
            $recipientEmails = SiteSettingsController::getEmailsForForm('proposal');
            Mail::mailer('mailgun_request')
                ->to($recipientEmails)
                ->send(new ProposalRequest($validated));
        } catch (\Exception $e) {
            Log::warning('Failed to send proposal email: ' . $e->getMessage());
        }

        return redirect()->route('proposal')
            ->with('proposal_success', true);
    }

    public function contact(Request $request)
    {
        // Verify Turnstile
        if (!$this->verifyTurnstile($request)) {
            return back()
                ->withInput()
                ->withErrors(['cf-turnstile-response' => 'Please complete the security verification.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Send email to Logic Environmental
        try {
            $recipientEmails = SiteSettingsController::getEmailsForForm('contact');
            Mail::mailer('mailgun_form')
                ->to($recipientEmails)
                ->send(new ContactRequest($validated));
        } catch (\Exception $e) {
            Log::warning('Failed to send contact email: ' . $e->getMessage());
        }

        return redirect()->route('contact')
            ->with('contact_success', true);
    }
}
