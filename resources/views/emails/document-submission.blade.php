<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Document Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #198754;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
        }
        .section {
            background-color: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }
        .section-title {
            color: #198754;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #198754;
        }
        .footer {
            text-align: center;
            padding: 15px;
            color: #6c757d;
            font-size: 12px;
        }
        table {
            width: 100%;
        }
        td {
            padding: 5px 0;
            vertical-align: top;
        }
        .label-cell {
            width: 30%;
            font-weight: bold;
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #198754;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 24px;">New Document Submission</h1>
        <p style="margin: 5px 0 0 0;">Logic Environmental</p>
    </div>

    <div class="content">
        <div class="section">
            <div class="section-title">Submission Details</div>
            <table>
                <tr>
                    <td class="label-cell">From:</td>
                    <td>{{ $submission->name }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Email:</td>
                    <td><a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a></td>
                </tr>
                @if($submission->reference)
                <tr>
                    <td class="label-cell">Reference:</td>
                    <td><strong>{{ $submission->reference }}</strong></td>
                </tr>
                @endif
            </table>
        </div>

        <div class="section">
            <div class="section-title">Description</div>
            <p style="margin: 0;">{!! nl2br(e($submission->description)) !!}</p>
        </div>

        <div class="section">
            <div class="section-title">Files Uploaded ({{ count($submission->files) }})</div>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($submission->files as $file)
                <li>{{ $file['name'] }}</li>
                @endforeach
            </ul>
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/admin/documents/' . $submission->id) }}" class="btn">View in Admin Panel</a>
        </div>
    </div>

    <div class="footer">
        <p>This document was submitted via the Logic Environmental website.</p>
        <p>{{ now()->format('F j, Y g:i A') }}</p>
    </div>
</body>
</html>
