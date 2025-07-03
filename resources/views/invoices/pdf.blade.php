<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        .invoice-title {
            font-size: 20px;
            margin: 20px 0;
        }
        .invoice-details {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .invoice-details > div {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals td {
            padding: 5px 10px;
            border-bottom: 1px solid #ddd;
        }
        .total-row {
            font-weight: bold;
            font-size: 16px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Nexitel POS System</div>
        <div>Point of Sales & Customer Management</div>
    </div>

    <div class="invoice-title">
        <h2>Invoice {{ $invoice->invoice_number }}</h2>
    </div>

    <div class="invoice-details">
        <div>
            <h4>Bill To:</h4>
            <strong>{{ $invoice->customer->name }}</strong><br>
            {{ $invoice->customer->email }}<br>
            {{ $invoice->customer->phone }}<br>
            @if($invoice->customer->company)
                {{ $invoice->customer->company }}<br>
            @endif
            @if($invoice->customer->address)
                {{ $invoice->customer->address }}
            @endif
        </div>
        <div style="text-align: right;">
            <strong>Invoice Date:</strong> {{ $invoice->billing_date->format('M d, Y') }}<br>
            @if($invoice->due_date)
                <strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}<br>
            @endif
            <strong>Status:</strong> {{ ucfirst($invoice->status) }}<br>
            <strong>Created by:</strong> {{ $invoice->employee->name }}
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Plan</th>
                <th>SKU</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td>{{ $item->plan ?? '-' }}</td>
                <td>{{ $item->sku ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->unit_price, 2) }}</td>
                <td>${{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td style="text-align: right;">${{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Tax (8%):</td>
                <td style="text-align: right;">${{ number_format($invoice->tax_amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Total:</td>
                <td style="text-align: right;">${{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    @if($invoice->notes)
    <div style="margin-top: 30px;">
        <h4>Notes:</h4>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>Generated on {{ now()->format('M d, Y H:i:s') }}</p>
    </div>
</body>
</html>
