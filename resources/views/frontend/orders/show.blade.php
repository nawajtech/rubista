@extends('frontend.layouts.app')

@section('title', 'Order Details - Rubista')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-receipt me-2"></i>Order #{{ $order->order_number }}</h2>
                <div>
                    <a href="{{ route('frontend.orders.invoice.download', $order) }}" class="btn btn-success me-2" target="_blank">
                        <i class="fas fa-download me-1"></i> Download Bill
                    </a>
                    <a href="{{ route('frontend.orders') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i> Back to Orders
                    </a>
                    @if($order->canBeCancelled())
                        <form method="POST" action="{{ route('frontend.orders.cancel', $order) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to cancel this order?')">
                                <i class="fas fa-times me-1"></i> Cancel Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Details -->
        <div class="col-lg-8">
            <!-- Order Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">Order Date:</dt>
                                <dd class="col-sm-7">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</dd>
                                
                                <dt class="col-sm-5">Status:</dt>
                                <dd class="col-sm-7">
                                    <span class="badge bg-{{ $order->status_badge }} fs-6">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </dd>
                                
                                <dt class="col-sm-5">Payment:</dt>
                                <dd class="col-sm-7">
                                    <span class="badge bg-{{ $order->payment_status_badge }} fs-6">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">Payment Method:</dt>
                                <dd class="col-sm-7">{{ strtoupper($order->payment_method) }}</dd>
                                
                                @if($order->tracking_number)
                                <dt class="col-sm-5">Tracking #:</dt>
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
                    <h5 class="mb-0"><i class="fas fa-box me-2"></i>Order Items</h5>
                </div>
                <div class="card-body">
                    @foreach($order->orderItems as $item)
                    <div class="d-flex align-items-center border-bottom py-3 {{ $loop->last ? 'border-bottom-0 pb-0' : '' }}">
                        @if($item->product_image)
                            <img src="{{ $item->product_image }}" class="img-thumbnail me-3" style="width: 80px; height: 80px;">
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $item->product_name }}</h6>
                            <p class="text-muted mb-1">SKU: {{ $item->product_sku }}</p>
                            <p class="mb-0">
                                <strong>₹{{ number_format($item->unit_price, 2) }}</strong> × {{ $item->quantity }} = 
                                <strong>₹{{ number_format($item->total_price, 2) }}</strong>
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping & Billing Addresses -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Shipping Address</h5>
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Billing Address</h5>
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
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Order Summary</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-8">Subtotal:</dt>
                        <dd class="col-4 text-end">₹{{ number_format($order->subtotal, 2) }}</dd>
                        
                        @if($order->tax_amount > 0)
                        <dt class="col-8">Tax:</dt>
                        <dd class="col-4 text-end">₹{{ number_format($order->tax_amount, 2) }}</dd>
                        @endif
                        
                        @if($order->shipping_amount > 0)
                        <dt class="col-8">Shipping:</dt>
                        <dd class="col-4 text-end">₹{{ number_format($order->shipping_amount, 2) }}</dd>
                        @else
                        <dt class="col-8">Shipping:</dt>
                        <dd class="col-4 text-end text-success">Free</dd>
                        @endif
                    </dl>
                    <hr>
                    <dl class="row">
                        <dt class="col-8 h5">Total:</dt>
                        <dd class="col-4 text-end h5 text-primary">₹{{ number_format($order->total_amount, 2) }}</dd>
                    </dl>
                    
                    @if($order->notes)
                    <hr>
                    <h6>Order Notes:</h6>
                    <p class="text-muted">{{ $order->notes }}</p>
                    @endif
                    
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('frontend.orders') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-1"></i> View All Orders
                        </a>
                        <a href="{{ route('frontend.home') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-cart me-1"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Tracking -->
            @if($order->status !== 'cancelled')
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Order Tracking</h5>
                </div>
                <div class="card-body">
                    <div class="tracking-steps">
                        <div class="tracking-step {{ in_array($order->status, ['pending', 'processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                            <div class="step-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="step-content">
                                <h6>Order Confirmed</h6>
                                <p class="mb-0 text-muted">{{ $order->created_at->format('M d, Y - h:i A') }}</p>
                            </div>
                        </div>
                        
                        <div class="tracking-step {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                            <div class="step-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="step-content">
                                <h6>Processing</h6>
                                <p class="mb-0 text-muted">
                                    @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                        Processing started
                                    @else
                                        Pending processing
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="tracking-step {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '' }}">
                            <div class="step-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="step-content">
                                <h6>Shipped</h6>
                                <p class="mb-0 text-muted">
                                    @if($order->shipped_at)
                                        {{ $order->shipped_at->format('M d, Y - h:i A') }}
                                    @elseif($order->status === 'shipped')
                                        Recently shipped
                                    @else
                                        Awaiting shipment
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="tracking-step {{ $order->status === 'delivered' ? 'completed' : '' }}">
                            <div class="step-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="step-content">
                                <h6>Delivered</h6>
                                <p class="mb-0 text-muted">
                                    @if($order->delivered_at)
                                        {{ $order->delivered_at->format('M d, Y - h:i A') }}
                                    @else
                                        Pending delivery
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.tracking-steps {
    position: relative;
}

.tracking-step {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
    position: relative;
}

.tracking-step:last-child {
    margin-bottom: 0;
}

.tracking-step::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 2.5rem;
    width: 2px;
    height: calc(100% + 1rem);
    background: #dee2e6;
}

.tracking-step:last-child::before {
    display: none;
}

.tracking-step.completed::before {
    background: #28a745;
}

.step-icon {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
    z-index: 1;
    position: relative;
}

.tracking-step.completed .step-icon {
    background: #28a745;
}

.step-content h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
}
</style>
@endsection 