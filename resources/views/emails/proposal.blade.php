<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Proposal Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 700px;
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
            width: 40%;
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 24px;">New Proposal Request</h1>
        <p style="margin: 5px 0 0 0;">Logic Environmental</p>
    </div>

    <div class="content">
        <!-- Person Requesting -->
        <div class="section">
            <div class="section-title">Person Requesting Proposal</div>
            <table>
                <tr>
                    <td class="label-cell">Name:</td>
                    <td>{{ $data['name'] }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Email:</td>
                    <td><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></td>
                </tr>
                @if(!empty($data['company']))
                <tr>
                    <td class="label-cell">Company:</td>
                    <td>{{ $data['company'] }}</td>
                </tr>
                @endif
                @if(!empty($data['branch']))
                <tr>
                    <td class="label-cell">Branch:</td>
                    <td>{{ $data['branch'] }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label-cell">Address:</td>
                    <td>
                        {{ $data['street_address'] }}<br>
                        {{ $data['city'] }}, {{ $data['state'] }} {{ $data['zip_code'] }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Property Information -->
        <div class="section">
            <div class="section-title">Property Information</div>
            <table>
                <tr>
                    <td class="label-cell">Property Address:</td>
                    <td>{{ $data['property_address'] }}</td>
                </tr>
                <tr>
                    <td class="label-cell">County:</td>
                    <td>{{ $data['county'] }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Property Size:</td>
                    <td>{{ $data['property_size'] }}</td>
                </tr>
                @if(!empty($data['owner_name']))
                <tr>
                    <td class="label-cell">Owner Name:</td>
                    <td>{{ $data['owner_name'] }}</td>
                </tr>
                @endif
                @if(!empty($data['owner_phone']))
                <tr>
                    <td class="label-cell">Owner Phone:</td>
                    <td>{{ $data['owner_phone'] }}</td>
                </tr>
                @endif
                @if(!empty($data['owner_email']))
                <tr>
                    <td class="label-cell">Owner Email:</td>
                    <td><a href="mailto:{{ $data['owner_email'] }}">{{ $data['owner_email'] }}</a></td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Proposal Details -->
        <div class="section">
            <div class="section-title">Proposal Details</div>
            <table>
                <tr>
                    <td class="label-cell">Investigation Type:</td>
                    <td><strong>{{ $data['investigation_type'] }}</strong></td>
                </tr>
                <tr>
                    <td class="label-cell">Report Deadline:</td>
                    <td>{{ $data['report_deadline'] }}</td>
                </tr>
                @if(!empty($data['verbal_deadline']))
                <tr>
                    <td class="label-cell">Verbal Deadline:</td>
                    <td>{{ $data['verbal_deadline'] }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label-cell">Hardcopies Needed:</td>
                    <td>{{ $data['hardcopies_needed'] }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Report Addressees:</td>
                    <td>{!! nl2br(e($data['report_addressees'])) !!}</td>
                </tr>
            </table>
        </div>

        <!-- Site Details -->
        <div class="section">
            <div class="section-title">Site Details</div>
            <table>
                <tr>
                    <td class="label-cell">Number of Structures:</td>
                    <td>{{ $data['num_structures'] }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Structure Age:</td>
                    <td>{{ $data['structure_age'] }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Survey Available:</td>
                    <td>{{ $data['survey_available'] }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Prior Reports:</td>
                    <td>{{ $data['prior_reports'] }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Access Problems:</td>
                    <td>{{ $data['access_problems'] }}</td>
                </tr>
            </table>
        </div>

        @if(!empty($data['attachments']) && count($data['attachments']) > 0)
        <!-- Attachments -->
        <div class="section">
            <div class="section-title">Attachments ({{ count($data['attachments']) }})</div>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($data['attachments'] as $attachment)
                <li>{{ $attachment['name'] }}</li>
                @endforeach
            </ul>
            <p style="margin: 10px 0 0 0; font-size: 12px; color: #6c757d;">
                <em>Attachments are saved in the admin panel. Log in to view them.</em>
            </p>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>This proposal request was submitted via the Logic Environmental website.</p>
        <p>{{ now()->format('F j, Y g:i A') }}</p>
    </div>
</body>
</html>
