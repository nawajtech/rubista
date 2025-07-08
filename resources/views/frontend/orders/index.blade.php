@extends('frontend.layouts.app')

@section('title', 'My Orders - Rubista')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-shopping-bag me-2"></i>My Orders</h2>
                <a href="{{ route('frontend.home') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-1"></i> Continue Shopping
                </a>
            </div>
            
            @if($orders->count() > 0)
                <div class="row">
                    @foreach($orders as $order)
                    <div class="col-12 mb-4">
                        <div class="card order-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Order #{{ $order->order_number }}</h6>
                                    <small class="text-muted">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</small>
                                </div>
                                <div>
                                    <span class="badge bg-{{ $order->status_badge }} me-2">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <span class="badge bg-{{ $order->payment_status_badge }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6>Items ({{ $order->orderItems->count() }})</h6>
                                        <div class="row">
                                            @foreach($order->orderItems->take(3) as $item)
                                            <div class="col-md-4 mb-2">
                                                <div class="d-flex align-items-center">
                                                    @if($item->product_image)
                                                        <img src="{{ $item->product_image }}" class="img-thumbnail me-2" style="width: 50px; height: 50px;">
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold small">{{ Str::limit($item->product_name, 20) }}</div>
                                                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @if($order->orderItems->count() > 3)
                                            <div class="col-md-12">
                                                <small class="text-muted">and {{ $order->orderItems->count() - 3 }} more items...</small>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <h5 class="text-primary">₹{{ number_format($order->total_amount, 2) }}</h5>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('frontend.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i> View Details
                                            </a>
                                            @if($order->canBeCancelled())
                                                <form method="POST" action="{{ route('frontend.orders.cancel', $order) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this order?')">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                    <h4>No orders yet</h4>
                    <p class="text-muted">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                    <a href="{{ route('frontend.home') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-cart me-1"></i> Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.order-card {
    border: 1px solid #dee2e6;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.order-card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.order-card .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}
</style>
@endsection 