<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
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
            margin: 0 0 8px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .email-header .order-badge {
            display: inline-block;
            background-color: rgba(255,255,255,0.15);
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .email-body {
            padding: 40px;
        }
        .email-body p {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.6;
            margin: 0 0 8px;
        }
        .email-body .greeting {
            text-align: center;
            margin-bottom: 24px;
        }
        .email-body .greeting h2 {
            color: #1a3c2e;
            font-size: 22px;
            margin: 0 0 4px;
        }
        .status-update-box {
            background-color: #f8faf7;
            border-radius: 12px;
            padding: 24px;
            margin: 20px 0;
            text-align: center;
        }
        .status-transition {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin: 16px 0;
        }
        .old-status, .new-status {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .old-status {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .new-status {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-arrow {
            font-size: 20px;
            color: #a0aec0;
        }
        .order-summary {
            background-color: #f8faf7;
            border-radius: 12px;
            padding: 20px 24px;
            margin: 20px 0;
        }
        .order-summary h3 {
            color: #1a3c2e;
            font-size: 16px;
            margin: 0 0 16px;
            font-weight: 700;
        }
        .order-info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }
        .order-info-row:last-child {
            border-bottom: none;
        }
        .order-info-row .label {
            color: #718096;
        }
        .order-info-row .value {
            color: #1a202c;
            font-weight: 600;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }
        .items-table th {
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #a0aec0;
            padding: 8px 12px;
            border-bottom: 2px solid #e2e8f0;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            color: #4a5568;
        }
        .items-table td:last-child {
            text-align: right;
            font-weight: 600;
            color: #1a202c;
        }
        .total-row td {
            font-weight: 700 !important;
            color: #1a3c2e !important;
            font-size: 16px !important;
            border-bottom: none !important;
            padding-top: 16px !important;
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
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h1>Optiqueue</h1>
                <span class="order-badge">Order Status Update</span>
            </div>
            <div class="email-body">
                <div class="greeting">
                    <h2>Your order has been updated!</h2>
                    <p>Hi <strong>{{ $order->customer->name }}</strong>, your order status has changed.</p>
                </div>

                <div class="status-update-box">
                    <p style="font-size: 13px; color: #718096; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Status Update</p>
                    <div class="status-transition">
                        <span class="old-status">{{ str_replace('-', ' ', ucwords($oldStatus, '-')) }}</span>
                        <span class="status-arrow">→</span>
                        <span class="new-status">{{ str_replace('-', ' ', ucwords($order->status, '-')) }}</span>
                    </div>
                </div>

                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div class="order-info-row">
                        <span class="label">Order Number</span>
                        <span class="value">{{ $order->order_no }}</span>
                    </div>
                    <div class="order-info-row">
                        <span class="label">Current Status</span>
                        <span class="value" style="color: #166534;">{{ str_replace('-', ' ', ucwords($order->status, '-')) }}</span>
                    </div>
                    <div class="order-info-row">
                        <span class="label">Email</span>
                        <span class="value">{{ $order->customer->email }}</span>
                    </div>
                    <div class="order-info-row">
                        <span class="label">Contact</span>
                        <span class="value">{{ $order->customer->phone_number ?? '—' }}</span>
                    </div>
                </div>

                <h3 style="color: #1a3c2e; font-size: 16px; margin: 24px 0 12px; font-weight: 700;">Items Ordered</h3>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach ($order->orderDetails as $detail)
                            @php
                                $itemPrice = $detail->product ? (int) $detail->product->price : 0;
                                $subtotal += $itemPrice * $detail->quantity;
                            @endphp
                            <tr>
                                <td>{{ $detail->product ? $detail->product->name : 'Product #'.$detail->product_id }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>₱{{ number_format($itemPrice, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="2">Total</td>
                            <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} Optiqueue. All rights reserved.</p>
                <p style="margin-top: 4px;"><a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
            </div>
        </div>
    </div>
</body>
</html>
