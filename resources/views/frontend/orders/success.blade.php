@extends('frontend.layouts.app')

@section('title', 'Order Confirmation - Rubista')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="text-success mb-3">Order Placed Successfully!</h2>
                    <p class="lead">Thank you for your order. We've received your order and will process it shortly.</p>
                    
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Order Details</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Order Number:</dt>
                                <dd class="col-sm-8"><strong>{{ $order->order_number }}</strong></dd>
                                
                                <dt class="col-sm-4">Order Date:</dt>
                                <dd class="col-sm-8">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</dd>
                                
                                <dt class="col-sm-4">Total Amount:</dt>
                                <dd class="col-sm-8"><strong>₹{{ number_format($order->total_amount, 2) }}</strong></dd>
                                
                                <dt class="col-sm-4">Payment Status:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-{{ $order->payment_status_badge }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h6>What's Next?</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Order confirmation email has been sent</li>
                            <li><i class="fas fa-check text-success me-2"></i> We'll process your order within 24 hours</li>
                            <li><i class="fas fa-check text-success me-2"></i> You'll receive shipping updates via email</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex gap-3 justify-content-center mt-4">
                        <a href="{{ route('frontend.orders.show', $order) }}" class="btn btn-primary">
                            <i class="fas fa-eye me-1"></i> View Order
                        </a>
                        <a href="{{ route('frontend.home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart me-1"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 