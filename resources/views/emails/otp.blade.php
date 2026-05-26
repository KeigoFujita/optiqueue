<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f5;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        }
        .email-header {
            background-color: #1a3c2e;
            padding: 32px 40px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            font-size: 24px;
            margin: 0;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .email-body {
            padding: 40px;
        }
        .email-body p {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.6;
            margin: 0 0 16px;
        }
        .otp-code {
            text-align: center;
            margin: 32px 0;
        }
        .otp-code span {
            display: inline-block;
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #1a3c2e;
            background-color: #f0f5f2;
            padding: 16px 32px;
            border-radius: 12px;
            font-family: 'Courier New', Courier, monospace;
        }
        .email-footer {
            padding: 24px 40px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        .email-footer p {
            color: #a0aec0;
            font-size: 13px;
            margin: 0;
        }
        .email-footer a {
            color: #1a3c2e;
            text-decoration: none;
        }
        .expiry-note {
            font-size: 14px;
            color: #718096 !important;
            text-align: center;
            margin-top: 8px !important;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h1>Optiqueue</h1>
            </div>
            <div class="email-body">
                <p>Hello <strong>{{ $customerName }}</strong>,</p>
                <p>Use the following OTP code to verify your email address and complete your order. This code will expire in 5 minutes.</p>
                <div class="otp-code">
                    <span>{{ $otp }}</span>
                </div>
                <p class="expiry-note">If you didn't request this code, you can safely ignore this email.</p>
            </div>
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} Optiqueue. All rights reserved.</p>
                <p style="margin-top: 4px;"><a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
            </div>
        </div>
    </div>
</body>
</html>
