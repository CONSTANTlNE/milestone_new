<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Carrier/Dispatcher Application</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .section {
            margin-bottom: 25px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .section h3 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .label {
            font-weight: bold;
            color: #495057;
        }
        .value {
            color: #6c757d;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚛 New Carrier/Dispatcher Application</h1>
        <p>Milestone Brokers - B2B Onboarding</p>
    </div>

    <div class="content">
        <div class="section">
            <h3>📋 Application Summary</h3>
            <div class="info-row">
                <span class="label">Application ID:</span>
                <span class="value">#{{ $carrierDispatcher->id }}</span>
            </div>
            <div class="info-row">
                <span class="label">Submitted:</span>
                <span class="value">{{ $carrierDispatcher->created_at->format('M d, Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Status:</span>
                <span class="value">{{ ucfirst($carrierDispatcher->status) }}</span>
            </div>
        </div>

        <div class="section">
            <h3>🏢 Company Information</h3>
            <div class="info-row">
                <span class="label">Legal Business Name:</span>
                <span class="value">{{ $carrierDispatcher->legal_business_name }}</span>
            </div>
            @if($carrierDispatcher->dba)
            <div class="info-row">
                <span class="label">DBA:</span>
                <span class="value">{{ $carrierDispatcher->dba }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="label">Business Type:</span>
                <span class="value">{{ $carrierDispatcher->business_type }}</span>
            </div>
            <div class="info-row">
                <span class="label">Years in Operation:</span>
                <span class="value">{{ $carrierDispatcher->years_operation }}</span>
            </div>
            <div class="info-row">
                <span class="label">MC Number:</span>
                <span class="value">{{ $carrierDispatcher->mc_number }}</span>
            </div>
            <div class="info-row">
                <span class="label">DOT Number:</span>
                <span class="value">{{ $carrierDispatcher->dot_number }}</span>
            </div>
            <div class="info-row">
                <span class="label">Cars Under Management:</span>
                <span class="value">{{ number_format($carrierDispatcher->cars_under_management) }}</span>
            </div>
        </div>

        <div class="section">
            <h3>👤 Primary Contact</h3>
            <div class="info-row">
                <span class="label">Contact Name:</span>
                <span class="value">{{ $carrierDispatcher->contact_name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Title:</span>
                <span class="value">{{ $carrierDispatcher->contact_title }}</span>
            </div>
            <div class="info-row">
                <span class="label">Phone:</span>
                <span class="value">{{ $carrierDispatcher->contact_phone }}</span>
            </div>
            <div class="info-row">
                <span class="label">Email:</span>
                <span class="value">{{ $carrierDispatcher->contact_email }}</span>
            </div>
        </div>

        <div class="section">
            <h3>📍 Location & Operations</h3>
            <div class="info-row">
                <span class="label">Main Address:</span>
                <span class="value">{{ $carrierDispatcher->main_address }}</span>
            </div>
            <div class="info-row">
                <span class="label">Multiple Locations:</span>
                <span class="value">{{ ucfirst($carrierDispatcher->multiple_locations) }}</span>
            </div>
            @if($carrierDispatcher->additional_addresses)
            <div class="info-row">
                <span class="label">Additional Addresses:</span>
                <span class="value">{{ $carrierDispatcher->additional_addresses }}</span>
            </div>
            @endif
        </div>

        <div class="section">
            <h3>💳 Billing & Payment</h3>
            <div class="info-row">
                <span class="label">Billing Contact:</span>
                <span class="value">{{ $carrierDispatcher->billing_contact }}</span>
            </div>
            <div class="info-row">
                <span class="label">Billing Email:</span>
                <span class="value">{{ $carrierDispatcher->billing_email }}</span>
            </div>
            <div class="info-row">
                <span class="label">Payment Methods:</span>
                <span class="value">{{ $carrierDispatcher->payment_method_text }}</span>
            </div>
        </div>

        <div class="section">
            <h3>📄 Documents & Verification</h3>
            <div class="info-row">
                <span class="label">NDA Required:</span>
                <span class="value">{{ ucfirst($carrierDispatcher->nda_required) }}</span>
            </div>
            <div class="info-row">
                <span class="label">W-9 Uploaded:</span>
                <span class="value">{{ $carrierDispatcher->w9_upload ? 'Yes' : 'No' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Insurance Certificate:</span>
                <span class="value">{{ $carrierDispatcher->insurance_certificate ? 'Yes' : 'No' }}</span>
            </div>
            @if($carrierDispatcher->presentation_file)
            <div class="info-row">
                <span class="label">Presentation File:</span>
                <span class="value">Yes</span>
            </div>
            @endif
            @if($carrierDispatcher->vehicle_list_file)
            <div class="info-row">
                <span class="label">Vehicle List File:</span>
                <span class="value">Yes</span>
            </div>
            @endif
        </div>

        <div style="text-align: center;">
            <a href="{{ route('backend.carrier_dispatchers.show', $carrierDispatcher->id) }}" class="btn">
                View Full Application
            </a>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated notification from Milestone Brokers.</p>
        <p>Please review this application in the admin dashboard.</p>
    </div>
</body>
</html>
