<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
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
        .message-box {
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 15px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 24px;">Contact Form Submission</h1>
        <p style="margin: 5px 0 0 0;">Logic Environmental</p>
    </div>

    <div class="content">
        <div class="section">
            <div class="section-title">Contact Information</div>
            <table>
                <tr>
                    <td class="label-cell">Name:</td>
                    <td>{{ $data['name'] }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Email:</td>
                    <td><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></td>
                </tr>
                @if(!empty($data['phone']))
                <tr>
                    <td class="label-cell">Phone:</td>
                    <td>{{ $data['phone'] }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label-cell">Subject:</td>
                    <td><strong>{{ $data['subject'] }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Message</div>
            <div class="message-box">
                {!! nl2br(e($data['message'])) !!}
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This message was submitted via the Logic Environmental contact form.</p>
        <p>{{ now()->format('F j, Y g:i A') }}</p>
    </div>
</body>
</html>
