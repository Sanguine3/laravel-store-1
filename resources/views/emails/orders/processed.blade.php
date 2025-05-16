<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order #{{ $order->order_number }} Has Been Processed!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
        }

        .header {
            background-color: #007bff; /* Example primary color - CHOOSE YOUR BRAND COLOR */
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .header img { /* For your logo */
            max-height: 60px; /* Adjust as needed */
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 25px;
        }

        .content h2 {
            color: #333333; /* Darker heading color */
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 10px;
        }

        .content p {
            margin-bottom: 15px;
        }

        .order-summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .order-summary-table th, .order-summary-table td {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: left;
        }

        .order-summary-table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .order-summary-table .total-row td {
            font-weight: bold;
        }

        .order-summary-table .align-right {
            text-align: right;
        }

        .order-summary-table .align-center {
            text-align: center;
        }

        .panel {
            background-color: #f9f9f9;
            border: 1px solid #eeeeee;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }

        .button-container {
            text-align: center;
            margin: 25px 0;
        }

        .button {
            background-color: #007bff; /* Example primary color - CHOOSE YOUR BRAND COLOR */
            color: #ffffff !important;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #777777;
            border-top: 1px solid #dddddd;
        }

        hr.separator {
            border: 0;
            border-top: 1px solid #eeeeee;
            margin: 25px 0;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <img src="{{ asset('favicon.ico') }}" alt="{{ config('app.name') }} Logo"
             style="max-height: 50px; margin-bottom: 10px;">
    </div>

    <div class="content">
        <h2>Your Order #{{ $order->order_number }} Has Been Processed!</h2>

        <p>Hi {{ $customerName }},</p>

        <p>Thank you for your order! We're pleased to inform you that your order
            <strong>#{{ $order->order_number }}</strong> has been successfully processed. We're excited to get it to
            you.</p>

        <hr class="separator">

        <h2>Order Summary</h2>
        <table class="order-summary-table">
            <thead>
            <tr>
                <th>Item</th>
                <th class="align-center">Quantity</th>
                <th class="align-right">Price</th>
                <th class="align-right">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product ? $item->product->name : 'Product ID: '.$item->product_id }}</td>
                    <td class="align-center">{{ $item->quantity }}</td>
                    <td class="align-right">${{ number_format($item->price, 2) }}</td>
                    <td class="align-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="total-row">
                <td colspan="3" class="align-right"><strong>Total:</strong></td>
                <td class="align-right"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
            </tr>
            </tfoot>
        </table>

        <hr class="separator">

        <h2>Shipping Details</h2>
        <div class="panel">
            <p><strong>Shipping Address:</strong><br>
                {!! nl2br(e($order->shipping_address)) !!}</p>
        </div>

        @if($order->notes)
            <h2>Your Special Instructions</h2>
            <div class="panel">
                <p>{!! nl2br(e($order->notes)) !!}</p>
            </div>
        @endif

        <hr class="separator">

        <h2>What's Next?</h2>
        <div class="panel">
            <p>We are now carefully preparing your items. You'll receive another email with tracking information (if
                applicable) as soon as your order is shipped.</p>
        </div>

        @php
            $orderViewUrl = route('orders.show', $order);
        @endphp
        <div class="button-container">
            <a href="{{ $orderViewUrl }}" class="button">View Your Order</a>
        </div>

        <hr class="separator">

        <h2>Questions?</h2>
        <p>If you have any questions about your order, please reply to this email or contact our support team at
            {{-- Replace with your actual support email --}}
            <a href="mailto:voquanghuy2806@gmail.com">voquanghuy2806@gmail.com</a>.</p>

        <p>Thank you for shopping with us!</p>

        <p>Sincerely,<br>
            The Team at {{ config('app.name') }}</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        {{-- Optional: You can add your company address or unsubscribe links here --}}
    </div>
</div>
</body>
</html>
