<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Secure Access Link</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #742E6F 0%, #5a2357 100%); padding: 30px; text-align: center; border-radius: 8px 8px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 24px;">{{ config('app.name') }}</h1>
    </div>

    <div style="background: #f8f9fa; padding: 30px; border: 1px solid #e9ecef; border-top: none; border-radius: 0 0 8px 8px;">
        <h2 style="color: #333; margin-top: 0;">Hello {{ $portal->name }},</h2>

        <p>You requested access to your secure client portal. Click the button below to access your files:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}" style="background: #742E6F; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                Access Your Portal
            </a>
        </div>

        @if($portal->project_reference)
        <p style="background: #fff; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6;">
            <strong>Project Reference:</strong> {{ $portal->project_reference }}
        </p>
        @endif

        <p style="color: #666; font-size: 14px;">
            <strong>This link will expire on:</strong><br>
            {{ $expiresAt->format('F j, Y \a\t g:i A') }} ({{ $expiresAt->diffForHumans() }})
        </p>

        <hr style="border: none; border-top: 1px solid #dee2e6; margin: 20px 0;">

        <p style="color: #666; font-size: 13px;">
            If you didn't request this link, you can safely ignore this email. The link will expire automatically.
        </p>

        <p style="color: #666; font-size: 13px;">
            If the button above doesn't work, copy and paste this URL into your browser:<br>
            <a href="{{ $url }}" style="color: #742E6F; word-break: break-all;">{{ $url }}</a>
        </p>
    </div>

    <div style="text-align: center; padding: 20px; color: #999; font-size: 12px;">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
