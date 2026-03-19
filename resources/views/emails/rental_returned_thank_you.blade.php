@php
    $emailSettings = \App\Models\Setting::where('group', 'email')->pluck('value', 'key');
    $headerColor = $emailSettings['email_header_color'] ?? 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
    $logo = $emailSettings['email_logo'] ?? null;
    $footerText = $emailSettings['email_footer_text'] ?? 'This is an automated email. Please do not reply to this message.';

    $contentTemplate = $emailSettings['email_rental_returned_content'] ?? 'Thank you for returning the book for rental #{rental_id}. We hope you enjoyed reading it!';
    $content = str_replace('{rental_id}', $rental->id, $contentTemplate);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Returning</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            background:
                {{ $headerColor }}
            ;
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }

        .header img {
            max-height: 60px;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
            font-weight: 600;
        }

        .header p {
            margin: 0;
            font-size: 16px;
            opacity: 0.95;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 20px;
            color: #333333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .message {
            font-size: 16px;
            color: #555555;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .book-info {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: #f0fdf4;
            border: 2px solid #10b981;
            border-radius: 8px;
            margin: 25px 0;
        }

        .book-icon {
            width: 70px;
            height: 90px;
            background:
                {{ $headerColor }}
            ;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            flex-shrink: 0;
        }

        .book-details {
            flex: 1;
        }

        .book-title {
            font-weight: 600;
            font-size: 18px;
            color: #111827;
            margin: 0 0 8px 0;
        }

        .book-author {
            font-size: 15px;
            color: #6b7280;
            margin: 0;
        }

        .thank-you-box {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 5px solid #3b82f6;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
            text-align: center;
        }

        .thank-you-box h2 {
            margin: 0 0 15px 0;
            color: #1e40af;
            font-size: 24px;
        }

        .thank-you-box p {
            margin: 0;
            color: #1e3a8a;
            font-size: 16px;
            line-height: 1.6;
        }

        .stats-box {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .stat-row:last-child {
            border-bottom: none;
        }

        .stat-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 14px;
        }

        .stat-value {
            color: #111827;
            font-size: 14px;
            font-weight: 500;
        }

        .footer {
            background: #f9fafb;
            padding: 25px 30px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            white-space: pre-line;
        }

        .footer .brand {
            font-size: 20px;
            font-weight: 700;
            color: #10b981;
            margin-bottom: 10px;
        }

        .emoji-large {
            font-size: 48px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            @if($logo)
                <img src="{{ url('storage/' . $logo) }}" alt="Logo">
            @endif
            <h1>📚 Thank You!</h1>
            <p>We appreciate you returning the book</p>
        </div>

        <div class="content">
            <p class="greeting">Hello {{ $rental->user->name }},</p>

            <div style="text-align: center;">
                <div class="emoji-large">✨</div>
            </div>

            <div class="thank-you-box">
                <h2>Thanks for Using Tunturu!</h2>
                <p>
                    <strong>Happy Learning!</strong><br>
                    {{ $content }}
                </p>
            </div>

            <div class="book-info">
                <div class="book-icon">📖</div>
                <div class="book-details">
                    <p class="book-title">{{ $rental->book->title }}</p>
                    <p class="book-author">by {{ $rental->book->author }}</p>
                </div>
            </div>

            <div class="stats-box">
                <div class="stat-row">
                    <span class="stat-label">Rental Period:</span>
                    <span class="stat-value">{{ $rental->rental_date->format('M d') }} -
                        {{ $rental->actual_return_date->format('M d, Y') }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Total Days:</span>
                    <span class="stat-value">{{ $rental->rental_date->diffInDays($rental->actual_return_date) }}
                        days</span>
                </div>
                @if($rental->late_fee > 0)
                    <div class="stat-row">
                        <span class="stat-label">Late Fee:</span>
                        <span class="stat-value">₹{{ number_format($rental->late_fee, 2) }}</span>
                    </div>
                @endif
                <div class="stat-row">
                    <span class="stat-label">Total Amount:</span>
                    <span class="stat-value">₹{{ number_format($rental->total_amount, 2) }}</span>
                </div>
            </div>

            <p class="message" style="text-align: center; font-size: 17px; color: #10b981; font-weight: 600;">
                We look forward to serving you again soon! 📚
            </p>

            <p class="message" style="text-align: center; color: #6b7280;">
                Keep reading, keep learning, and keep growing!
            </p>
        </div>

        <div class="footer">
            <div class="brand">Tunturu Library</div>
            <p>Empowering minds through knowledge</p>
            <p style="margin-top: 15px; font-size: 12px;">{{ $footerText }}</p>
            <p style="font-size: 12px;">&copy; {{ date('Y') }} Tunturu Library Management System. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>