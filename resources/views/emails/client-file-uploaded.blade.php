<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New File Upload Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #742E6F 0%, #5a2357 100%); padding: 30px; text-align: center; border-radius: 8px 8px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 24px;">{{ config('app.name') }}</h1>
    </div>

    <div style="background: #f8f9fa; padding: 30px; border: 1px solid #e9ecef; border-top: none; border-radius: 0 0 8px 8px;">
        <h2 style="color: #333; margin-top: 0;">Hello {{ $recipientName }},</h2>

        <p>A client has uploaded {{ count($files) }} {{ Str::plural('file', count($files)) }} to their portal.</p>

        <div style="background: #fff; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6; margin: 20px 0;">
            <p style="margin: 0 0 10px 0;"><strong>Client:</strong> {{ $portal->client_name }}</p>
            @if($portal->client_company)
            <p style="margin: 0 0 10px 0;"><strong>Company:</strong> {{ $portal->client_company }}</p>
            @endif
            @if($portal->project_reference)
            <p style="margin: 0 0 10px 0;"><strong>Project Reference:</strong> {{ $portal->project_reference }}</p>
            @endif
        </div>

        <h3 style="color: #333; margin-bottom: 10px;">Uploaded Files:</h3>
        <ul style="background: #fff; padding: 15px 15px 15px 35px; border-radius: 5px; border: 1px solid #dee2e6; margin: 0 0 20px 0;">
            @foreach($files as $file)
            <li style="margin-bottom: 5px;">{{ $file['original_filename'] }} ({{ $file['human_size'] }})</li>
            @endforeach
        </ul>

        @if($description)
        <div style="background: #fff3cd; padding: 15px; border-radius: 5px; border: 1px solid #ffc107; margin-bottom: 20px;">
            <strong>Client's Message:</strong><br>
            {{ $description }}
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $adminUrl }}" style="background: #742E6F; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                View in Admin Portal
            </a>
        </div>

        <hr style="border: none; border-top: 1px solid #dee2e6; margin: 20px 0;">

        <p style="color: #666; font-size: 13px;">
            This is an automated notification from the client portal.
        </p>
    </div>

    <div style="text-align: center; padding: 20px; color: #999; font-size: 12px;">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
