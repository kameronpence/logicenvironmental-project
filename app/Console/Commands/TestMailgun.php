<?php

namespace App\Console\Commands;

use App\Mail\ProposalRequest;
use App\Mail\ContactRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailgun extends Command
{
    protected $signature = 'mail:test {email? : Email address to send test to} {--mailer=mailgun_form : Mailer to use (mailgun_form or mailgun_request)} {--type=simple : Type of test (simple, proposal, contact)}';

    protected $description = 'Send a test email via Mailgun to verify configuration';

    public function handle()
    {
        $email = $this->argument('email') ?? $this->ask('Enter email address to send test to');
        $mailer = $this->option('mailer');
        $type = $this->option('type');

        if (!in_array($mailer, ['mailgun_form', 'mailgun_request'])) {
            $this->error('Invalid mailer. Use mailgun_form or mailgun_request');
            return 1;
        }

        $this->info("Testing Mailgun with mailer: {$mailer}");
        $this->info("Email type: {$type}");
        $this->info("Sending to: {$email}");

        try {
            if ($type === 'proposal') {
                $this->sendProposalTest($email, $mailer);
            } elseif ($type === 'contact') {
                $this->sendContactTest($email, $mailer);
            } else {
                $this->sendSimpleTest($email, $mailer);
            }

            $this->info('Test email sent successfully!');
            $this->newLine();
            $this->info('Check your inbox (and spam folder) for the test email.');

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to send test email!');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->warn('Troubleshooting tips:');
            $this->line('  1. Verify MAILGUN credentials in .env file');
            $this->line('  2. Check that the domain is verified in Mailgun');
            $this->line('  3. Ensure the sending address is authorized');

            return 1;
        }
    }

    private function sendSimpleTest(string $email, string $mailer): void
    {
        Mail::mailer($mailer)->raw(
            "This is a test email from Logic Environmental.\n\n" .
            "Mailer: {$mailer}\n" .
            "Time: " . now()->format('Y-m-d H:i:s') . "\n\n" .
            "If you received this email, Mailgun is configured correctly!",
            function ($message) use ($email, $mailer) {
                $message->to($email)
                    ->subject("Test Email - Logic Environmental ({$mailer})");
            }
        );
    }

    private function sendProposalTest(string $email, string $mailer): void
    {
        $testData = [
            'name' => 'John Test',
            'email' => 'john.test@example.com',
            'company' => 'Test Company LLC',
            'branch' => 'Atlanta Branch',
            'street_address' => '123 Test Street',
            'city' => 'Atlanta',
            'state' => 'GA',
            'zip_code' => '30301',
            'property_address' => '456 Property Lane, Suite 100',
            'county' => 'Fulton',
            'property_size' => '2.5 acres',
            'owner_name' => 'Jane Owner',
            'owner_phone' => '(555) 123-4567',
            'owner_email' => 'owner@example.com',
            'investigation_type' => 'Phase I ESA',
            'report_deadline' => '2 Weeks',
            'verbal_deadline' => '2-3 Days',
            'copies_needed' => 3,
            'report_addressees' => "John Test, Test Company LLC\n123 Test Street\nAtlanta, GA 30301",
            'num_structures' => 2,
            'structure_age' => '15-20 years',
            'survey_available' => 'Yes',
            'prior_reports' => 'No',
            'access_problems' => 'No',
            'attachments' => [],
        ];

        Mail::mailer($mailer)
            ->to($email)
            ->send(new ProposalRequest($testData));
    }

    private function sendContactTest(string $email, string $mailer): void
    {
        $testData = [
            'name' => 'Jane Test',
            'email' => 'jane.test@example.com',
            'phone' => '(555) 987-6543',
            'subject' => 'Test Contact Form Submission',
            'message' => "This is a test message from the contact form.\n\nIt includes multiple lines to test formatting.\n\nThank you!",
        ];

        Mail::mailer($mailer)
            ->to($email)
            ->send(new ContactRequest($testData));
    }
}
