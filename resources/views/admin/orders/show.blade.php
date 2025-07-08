@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="bi bi-bag"></i> Order #{{ $order->order_number }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit Order
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

<div class="row">
    <!-- Order Information -->
    <div class="col-md-8">
        <!-- Order Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Order Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-5">Order Number:</dt>
                            <dd class="col-sm-7">{{ $order->order_number }}</dd>
                            
                            <dt class="col-sm-5">Order Date:</dt>
                            <dd class="col-sm-7">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</dd>
                            
                            <dt class="col-sm-5">Customer:</dt>
                            <dd class="col-sm-7">
                                <a href="{{ route('admin.customers.show', $order->user) }}">
                                    {{ $order->user->name }}
                                </a>
                            </dd>
                            
                            <dt class="col-sm-5">Payment Method:</dt>
                            <dd class="col-sm-7">{{ strtoupper($order->payment_method) }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-5">Status:</dt>
                            <dd class="col-sm-7">
                                <span class="badge bg-{{ $order->status_badge }} fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </dd>
                            
                            <dt class="col-sm-5">Payment Status:</dt>
                            <dd class="col-sm-7">
                                <span class="badge bg-{{ $order->payment_status_badge }} fs-6">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </dd>
                            
                            @if($order->tracking_number)
                            <dt class="col-sm-5">Tracking:</dt>
                            <dd class="col-sm-7">{{ $order->tracking_number }}</dd>
                            @endif
                            
                            @if($order->shipped_at)
                            <dt class="col-sm-5">Shipped Date:</dt>
                            <dd class="col-sm-7">{{ $order->shipped_at->format('M d, Y') }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-box"></i> Order Items
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product_image)
                                            <img src="{{ $item->product_image }}" class="img-thumbnail me-3" style="width: 50px; height: 50px;">
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $item->product_name }}</div>
                                            @if($item->product)
                                                <small class="text-muted">
                                                    <a href="{{ route('admin.products.show', $item->product) }}">View Product</a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->product_sku }}</td>
                                <td>₹{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Subtotal:</th>
                                <th>₹{{ number_format($order->subtotal, 2) }}</th>
                            </tr>
                            @if($order->tax_amount > 0)
                            <tr>
                                <th colspan="4" class="text-end">Tax:</th>
                                <th>₹{{ number_format($order->tax_amount, 2) }}</th>
                            </tr>
                            @endif
                            @if($order->shipping_amount > 0)
                            <tr>
                                <th colspan="4" class="text-end">Shipping:</th>
                                <th>₹{{ number_format($order->shipping_amount, 2) }}</th>
                            </tr>
                            @endif
                            <tr class="table-primary">
                                <th colspan="4" class="text-end">Total:</th>
                                <th>₹{{ number_format($order->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Billing & Shipping -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-credit-card"></i> Billing Address
                        </h5>
                    </div>
                    <div class="card-body">
                        <address>
                            <strong>{{ $order->billing_full_name }}</strong><br>
                            {{ $order->billing_address }}<br>
                            {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postal_code }}<br>
                            {{ $order->billing_country }}<br>
                            <strong>Phone:</strong> {{ $order->billing_phone }}<br>
                            <strong>Email:</strong> {{ $order->billing_email }}
                        </address>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-truck"></i> Shipping Address
                        </h5>
                    </div>
                    <div class="card-body">
                        <address>
                            <strong>{{ $order->shipping_full_name }}</strong><br>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                            {{ $order->shipping_country }}<br>
                            <strong>Phone:</strong> {{ $order->shipping_phone }}
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Actions -->
    <div class="col-md-4">
        <!-- Quick Status Update -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="status" class="form-label">Update Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i> Order Summary
                </h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-6">Items:</dt>
                    <dd class="col-sm-6">{{ $order->orderItems->count() }}</dd>
                    
                    <dt class="col-sm-6">Total Qty:</dt>
                    <dd class="col-sm-6">{{ $order->orderItems->sum('quantity') }}</dd>
                    
                    <dt class="col-sm-6">Order Value:</dt>
                    <dd class="col-sm-6">₹{{ number_format($order->total_amount, 2) }}</dd>
                </dl>
                
                @if($order->notes)
                <hr>
                <h6>Customer Notes:</h6>
                <p class="text-muted">{{ $order->notes }}</p>
                @endif
                
                @if($order->admin_notes)
                <hr>
                <h6>Admin Notes:</h6>
                <p class="text-muted">{{ $order->admin_notes }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 