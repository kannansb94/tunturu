@php
    $emailSettings = \App\Models\Setting::where('group', 'email')->pluck('value', 'key');
    $headerColor = $emailSettings['email_header_color'] ?? 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
    $logo = $emailSettings['email_logo'] ?? null;
    $footerText = $emailSettings['email_footer_text'] ?? 'This is an automated email. Please do not reply to this message.';
    $footerCopyright = $emailSettings['email_footer_copyright'] ?? '© {year} Library Management System. All rights reserved.';
    $footerCopyright = str_replace('{year}', date('Y'), $footerCopyright);

    $contentKey = "email_rental_{$statusType}_{$newStatus}_content";
    $defaultContent = 'We wanted to let you know that the status of your rental #{rental_id} has been updated to: {status}.';

    $contentTemplate = $emailSettings[$contentKey] ?? $defaultContent;

    $content = str_replace(
        ['{rental_id}', '{status_type}', '{status}'],
        [$rental->id, $statusType === 'payment' ? 'payment' : 'delivery', ucwords(str_replace('_', ' ', $newStatus))],
        $contentTemplate
    );
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Status Update</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f8fafc;
            padding: 40px 0;
        }

        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }

        .top-accent {
            height: 8px;
            width: 100%;
            background:
                {{ $headerColor }}
            ;
        }

        .header {
            padding: 48px 40px 32px 40px;
            text-align: center;
        }

        .header img {
            max-height: 56px;
            margin-bottom: 24px;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .content {
            padding: 0 40px 48px 40px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 16px 0;
        }

        .message {
            font-size: 16px;
            color: #475569;
            line-height: 1.6;
            margin: 0 0 32px 0;
        }

        .status-box {
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin-bottom: 32px;
        }

        .status-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            margin-bottom: 12px;
            font-weight: 700;
            display: block;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 15px;
        }

        .status-payment-pending,
        .status-delivery-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-payment-paid,
        .status-payment-completed,
        .status-delivery-delivered {
            background: #d1fae5;
            color: #065f46;
        }

        .status-payment-failed,
        .status-payment-refunded,
        .status-delivery-cancelled {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-delivery-dispatched {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-delivery-on_the_way {
            background: #e0e7ff;
            color: #3730a3;
        }

        .status-delivery-returned {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .book-card {
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 32px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02);
        }

        .book-cover {
            width: 72px;
            height: 104px;
            border-radius: 6px;
            overflow: hidden;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-details {
            margin-left: 20px;
            flex: 1;
        }

        .book-title {
            margin: 0 0 6px 0;
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.4;
        }

        .book-author {
            margin: 0;
            font-size: 15px;
            color: #64748b;
        }

        .summary-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02);
        }

        .summary-header {
            background-color: #f8fafc;
            padding: 18px 24px;
            border-bottom: 1px solid #e2e8f0;
        }

        .summary-header h3 {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #475569;
            font-weight: 700;
        }

        .summary-body {
            padding: 8px 24px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            border: 0;
            margin: 0;
            padding: 0;
        }

        .summary-row td {
            border-bottom: 1px solid #f1f5f9;
            padding: 14px 0;
        }

        .summary-row:last-child td {
            border-bottom: none;
        }

        .summary-label {
            color: #64748b;
            font-size: 15px;
            text-align: left;
            vertical-align: top;
            width: 45%;
        }

        .summary-value {
            color: #0f172a;
            font-size: 15px;
            font-weight: 600;
            text-align: right;
            vertical-align: top;
            width: 55%;
            word-break: break-word;
        }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-top: 24px;
            font-size: 14.5px;
            line-height: 1.5;
            font-weight: 500;
        }

        .alert-warning {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e3a8a;
        }

        .footer {
            text-align: center;
            padding: 32px 40px;
            color: #94a3b8;
            font-size: 13px;
        }

        .footer p {
            margin: 0 0 8px 0;
            line-height: 1.5;
        }

        .footer p:last-child {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <div class="top-accent"></div>

            <div class="header">
                @if($logo && file_exists(storage_path('app/public/' . $logo)))
                    <img src="{{ $message->embedData(file_get_contents(storage_path('app/public/' . $logo)), \Illuminate\Support\Str::slug(config('app.name', 'Library')) . '-logo.' . pathinfo($logo, PATHINFO_EXTENSION)) }}"
                        alt="Logo">
                @endif
                <h1>Rental Status Update</h1>
            </div>

            <div class="content">
                <p class="greeting">Hello {{ $rental->user->name }},</p>
                <p class="message">{{ $content }}</p>

                <div class="status-box">
                    <span class="status-label">Current {{ ucfirst($statusType) }} Status</span>
                    <span class="status-badge status-{{ $statusType }}-{{ $newStatus }}">
                        {{ ucwords(str_replace('_', ' ', $newStatus)) }}
                    </span>
                </div>

                <div class="book-card">
                    <div class="book-cover">
                        @if($rental->book->cover_image && file_exists(storage_path('app/public/' . $rental->book->cover_image)))
                            <img src="{{ $message->embedData(file_get_contents(storage_path('app/public/' . $rental->book->cover_image)), 'book-cover.' . pathinfo($rental->book->cover_image, PATHINFO_EXTENSION)) }}"
                                alt="Book Cover">
                        @else
                            📖
                        @endif
                    </div>
                    <div class="book-details">
                        <p class="book-title">{{ $rental->book->title }}</p>
                        <p class="book-author">by {{ $rental->book->author }}</p>
                    </div>
                </div>

                <div class="summary-box">
                    <div class="summary-header">
                        <h3>Rental Summary</h3>
                    </div>
                    <div class="summary-body">
                        <table class="summary-table" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr class="summary-row">
                                <td class="summary-label">Rental ID</td>
                                <td class="summary-value">#{{ $rental->id }}</td>
                            </tr>
                            <tr class="summary-row">
                                <td class="summary-label">Rental Date</td>
                                <td class="summary-value">{{ $rental->rental_date->format('M d, Y') }}</td>
                            </tr>
                            <tr class="summary-row">
                                <td class="summary-label">Expected Return</td>
                                <td class="summary-value">{{ $rental->expected_return_date->format('M d, Y') }}</td>
                            </tr>
                            @if($rental->actual_return_date)
                                <tr class="summary-row">
                                    <td class="summary-label">Actual Return</td>
                                    <td class="summary-value">{{ $rental->actual_return_date->format('M d, Y') }}</td>
                                </tr>
                            @endif
                            <tr class="summary-row">
                                <td class="summary-label">Rental Price</td>
                                <td class="summary-value">₹{{ number_format($rental->rental_price, 2) }}</td>
                            </tr>
                            @if($rental->late_fee > 0)
                                <tr class="summary-row">
                                    <td class="summary-label">Late Fee</td>
                                    <td class="summary-value" style="color: #ef4444;">+
                                        ₹{{ number_format($rental->late_fee, 2) }}</td>
                                </tr>
                            @endif
                            <tr class="summary-row">
                                <td class="summary-label">Total Amount</td>
                                <td class="summary-value">₹{{ number_format($rental->total_amount, 2) }}</td>
                            </tr>
                            <tr class="summary-row">
                                <td class="summary-label">Payment Status</td>
                                <td class="summary-value">{{ ucfirst($rental->payment_status ?? 'Pending') }}</td>
                            </tr>
                            <tr class="summary-row">
                                <td class="summary-label">Delivery Status</td>
                                <td class="summary-value">
                                    {{ ucwords(str_replace('_', ' ', $rental->delivery_status ?? 'Pending')) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($rental->is_overdue && $rental->status !== 'returned')
                    <div class="alert alert-warning">
                        <strong>⚠️ Overdue Notice:</strong> This rental is {{ $rental->days_overdue }} day(s) overdue. Late
                        fees
                        may apply: <strong>₹{{ number_format($rental->calculated_late_fee, 2) }}</strong>
                    </div>
                @endif
                @if($statusType === 'delivery' && $newStatus === 'delivered')
                    <div class="alert alert-success">
                        <strong>✅ Book Delivered:</strong> Your rental book has been delivered. Please return it by
                        <strong>{{ $rental->expected_return_date->format('M d, Y') }}</strong> to avoid late fees.
                    </div>
                @endif
                @if($statusType === 'delivery' && $newStatus === 'cancelled')
                    <div class="alert alert-warning">
                        <strong>⚠️ Rental Cancelled:</strong> This rental request has been cancelled. If any payment was
                        made, it has been refunded to your wallet.
                    </div>
                @endif
                @if($statusType === 'delivery' && $newStatus === 'returned')
                    <div class="alert alert-info">
                        <strong>📚 Book Returned:</strong> Thank you for returning the book. We hope you enjoyed reading it!
                    </div>
                @endif

            </div>

            <div class="footer">
                <p>{{ $footerText }}</p>
                <p>{{ $footerCopyright }}</p>
                <span
                    style="display:none; color:transparent; font-size:0px; opacity:0; mso-hide:all; height:0; width:0; line-height:0; overflow:hidden;">Ref
                    ID: {{ \Illuminate\Support\Str::random(16) }} - {{ time() }}</span>
            </div>
        </div>
    </div>
</body>

</html>