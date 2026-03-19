@php
    $emailSettings = \App\Models\Setting::where('group', 'email')->pluck('value', 'key');
    $logo = $emailSettings['email_logo'] ?? null;
    $footerText = $emailSettings['email_footer_text'] ?? 'This is an automated email. Please do not reply to this message.';
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>Email Verification</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

        @if($logo)
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="{{ url('storage/' . $logo) }}" alt="Logo" style="max-height: 50px;">
            </div>
        @endif

        <h2 style="color: #333333; text-align: center;">Verify Your Email Address</h2>
        <p style="color: #666666; line-height: 1.6;">Hello {{ $user->name }},</p>
        <p style="color: #666666; line-height: 1.6;">Please use the following One Time Password (OTP) to verify your
            email address and complete your registration:</p>

        <div style="text-align: center; margin: 30px 0;">
            <div
                style="display: inline-block; background-color: #f0f0f0; padding: 15px 30px; font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #333333; border-radius: 4px; border: 1px solid #dddddd;">
                {{ $otp }}
            </div>
        </div>

        <p style="color: #666666; line-height: 1.6;">This code will expire in 10 minutes.</p>
        <p style="color: #666666; line-height: 1.6;">If you did not request this, please ignore this email.</p>

        <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">

        <p style="color: #afafaf; font-size: 12px; text-align: center; white-space: pre-line;">
            {{ $footerText }}
        </p>
        <p style="color: #afafaf; font-size: 12px; text-align: center;">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</body>

</html>