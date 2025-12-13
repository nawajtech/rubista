<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }} - {{ $settings['site_name'] ?? 'Rubista' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Arial', sans-serif;
        }
        
        .invoice-container {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .invoice-header {
            border-bottom: 3px solid #7c3aed;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .company-info h2 {
            color: #7c3aed;
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }
        
        .invoice-title {
            text-align: right;
        }
        
        .invoice-title h1 {
            color: #333;
            font-size: 2.5rem;
            margin: 0;
            font-weight: 700;
        }
        
        .invoice-title p {
            color: #666;
            margin: 5px 0 0 0;
        }
        
        .invoice-details {
            margin: 30px 0;
        }
        
        .detail-section {
            margin-bottom: 30px;
        }
        
        .detail-section h5 {
            color: #7c3aed;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .detail-section p {
            margin: 5px 0;
            color: #333;
        }
        
        .detail-section strong {
            color: #555;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        
        .items-table thead {
            background: #7c3aed;
            color: white;
        }
        
        .items-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .items-table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .items-table tfoot {
            background: #f8f9fa;
            font-weight: 600;
        }
        
        .items-table tfoot td {
            padding: 15px;
            border-top: 2px solid #7c3aed;
        }
        
        .total-row {
            font-size: 1.2rem;
            color: #7c3aed;
        }
        
        .invoice-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
            text-align: center;
            color: #666;
        }
        
        .action-buttons {
            margin: 20px 0;
            text-align: center;
        }
        
        .action-buttons .btn {
            margin: 5px;
        }
        
        .badge-status {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .badge-pending {
            background: #ffc107;
            color: #000;
        }
        
        .badge-processing {
            background: #17a2b8;
            color: white;
        }
        
        .badge-shipped {
            background: #007bff;
            color: white;
        }
        
        .badge-delivered {
            background: #28a745;
            color: white;
        }
        
        .badge-cancelled {
            background: #dc3545;
            color: white;
        }
        
        .badge-paid {
            background: #28a745;
            color: white;
        }
        
        .badge-pending-payment {
            background: #ffc107;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="company-info">
                        <h2>{{ $settings['site_name'] ?? 'RUBISTA' }}</h2>
                        @if(isset($settings['site_address']))
                        <p class="mb-1">{{ $settings['site_address'] }}</p>
                        @endif
                        @if(isset($settings['site_phone']))
                        <p class="mb-1"><i class="fas fa-phone me-1"></i> {{ $settings['site_phone'] }}</p>
                        @endif
                        @if(isset($settings['site_email']))
                        <p class="mb-0"><i class="fas fa-envelope me-1"></i> {{ $settings['site_email'] }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="invoice-title">
                        <h1>INVOICE</h1>
                        <p>Invoice #{{ $order->order_number }}</p>
                        <p>Date: {{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-section">
                        <h5><i class="fas fa-user me-2"></i>Bill To:</h5>
                        <p><strong>{{ $order->billing_first_name }} {{ $order->billing_last_name }}</strong></p>
                        <p>{{ $order->billing_address }}</p>
                        <p>{{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postal_code }}</p>
                        <p>{{ $order->billing_country }}</p>
                        <p><strong>Phone:</strong> {{ $order->billing_phone }}</p>
                        <p><strong>Email:</strong> {{ $order->billing_email }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-section">
                        <h5><i class="fas fa-truck me-2"></i>Ship To:</h5>
                        <p><strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong></p>
                        <p>{{ $order->shipping_address }}</p>
                        <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                        <p>{{ $order->shipping_country }}</p>
                        <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="detail-section">
                        <h5><i class="fas fa-info-circle me-2"></i>Order Information:</h5>
                        <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge-status badge-{{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                        <p><strong>Payment Status:</strong> 
                            <span class="badge-status badge-{{ $order->payment_status === 'paid' ? 'paid' : 'pending-payment' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                        <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method ?? 'N/A') }}</p>
                        @if($order->tracking_number)
                        <p><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>SKU</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                    </td>
                    <td>{{ $item->product_sku }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->unit_price, 2) }}</td>
                    <td>₹{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                    <td colspan="2"><strong>₹{{ number_format($order->subtotal, 2) }}</strong></td>
                </tr>
                @if($order->tax_amount > 0)
                <tr>
                    <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                    <td colspan="2"><strong>₹{{ number_format($order->tax_amount, 2) }}</strong></td>
                </tr>
                @endif
                <tr>
                    <td colspan="4" class="text-end"><strong>Shipping:</strong></td>
                    <td colspan="2">
                        <strong>
                            @if($order->shipping_amount > 0)
                                ₹{{ number_format($order->shipping_amount, 2) }}
                            @else
                                Free
                            @endif
                        </strong>
                    </td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" class="text-end"><strong>Total Amount:</strong></td>
                    <td colspan="2"><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>

        @if($order->notes)
        <div class="detail-section">
            <h5><i class="fas fa-sticky-note me-2"></i>Order Notes:</h5>
            <p>{{ $order->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="invoice-footer">
            <p class="mb-2"><strong>Thank you for your business!</strong></p>
            <p class="mb-0">This is a computer-generated invoice and does not require a signature.</p>
            @if(isset($settings['site_name']))
            <p class="mt-2 mb-0">© {{ date('Y') }} {{ $settings['site_name'] }}. All rights reserved.</p>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('frontend.orders.show', $order) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Order
            </a>
            <a href="{{ route('frontend.orders') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list me-1"></i> All Orders
            </a>
        </div>
    </div>
</body>
</html>

