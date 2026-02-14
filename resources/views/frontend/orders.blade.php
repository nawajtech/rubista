@extends('frontend.layouts.app')

@section('title', 'My Orders - Rubista')

@section('extra-css')
<style>
    .orders-page .orders-section {
        padding: 50px 0;
        background: #f8f9fa;
    }
    .orders-page .orders-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #fff;
        padding: 60px 0;
        margin-bottom: 50px;
    }
    .orders-page .orders-header h1,
    .orders-page .orders-header .lead { color: #fff; }
    .orders-page .order-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(26,26,46,0.08);
        padding: 30px;
        margin-bottom: 30px;
        border: 1px solid rgba(245,166,35,0.12);
        transition: all 0.25s ease;
    }
    .orders-page .order-card:hover {
        box-shadow: 0 8px 28px rgba(245,166,35,0.12);
        border-color: rgba(245,166,35,0.2);
    }
    .orders-page .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(26,26,46,0.08);
    }
    .orders-page .order-number {
        font-size: 1.2rem;
        font-weight: 700;
        color: #f5a623;
    }
    .orders-page .order-date {
        color: #5a5a6e;
        font-size: 0.9rem;
    }
    .orders-page .order-status {
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
    }
    .orders-page .status-delivered {
        background: rgba(245,166,35,0.2);
        color: #1a1a2e;
    }
    .orders-page .status-processing {
        background: rgba(26,26,46,0.08);
        color: #1a1a2e;
    }
    .orders-page .status-shipped {
        background: rgba(245,166,35,0.12);
        color: #1a1a2e;
    }
    .orders-page .status-cancelled {
        background: rgba(239,68,68,0.12);
        color: #b91c1c;
    }
    .orders-page .order-items { margin-bottom: 20px; }
    .orders-page .order-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid rgba(26,26,46,0.06);
    }
    .orders-page .order-item:last-child { border-bottom: none; }
    .orders-page .item-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
        margin-right: 15px;
        border: 1px solid rgba(26,26,46,0.08);
    }
    .orders-page .item-details { flex: 1; }
    .orders-page .item-name {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 5px;
    }
    .orders-page .item-price,
    .orders-page .item-quantity {
        color: #5a5a6e;
        font-size: 0.9rem;
    }
    .orders-page .order-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid rgba(26,26,46,0.08);
        margin-top: 20px;
    }
    .orders-page .total-amount {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a2e;
    }
    .orders-page .order-actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .orders-page .btn-track {
        background: linear-gradient(135deg, #f5a623, #e0941a);
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.25s ease;
        text-decoration: none;
        box-shadow: 0 2px 10px rgba(245,166,35,0.3);
    }
    .orders-page .btn-track:hover {
        background: #1a1a2e;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(26,26,46,0.25);
    }
    .orders-page .btn-reorder {
        background: linear-gradient(135deg, #f5a623, #e0941a);
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.25s ease;
        text-decoration: none;
        box-shadow: 0 2px 10px rgba(245,166,35,0.3);
    }
    .orders-page .btn-reorder:hover {
        background: #1a1a2e;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(26,26,46,0.25);
    }
    .orders-page .btn-cancel {
        background: rgba(239,68,68,0.12);
        border: 1px solid rgba(239,68,68,0.4);
        color: #b91c1c;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.25s ease;
    }
    .orders-page .btn-cancel:hover {
        background: #ef4444;
        color: #fff;
        border-color: #ef4444;
        transform: translateY(-2px);
    }
    .orders-page .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }
    .orders-page .filter-tab {
        padding: 10px 20px;
        border: 2px solid rgba(26,26,46,0.12);
        border-radius: 12px;
        background: #fff;
        color: #5a5a6e;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.25s ease;
    }
    .orders-page .filter-tab.active,
    .orders-page .filter-tab:hover {
        border-color: #f5a623;
        color: #f5a623;
        background: rgba(245,166,35,0.06);
    }
    .orders-page .empty-orders {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(26,26,46,0.08);
        border: 1px solid rgba(245,166,35,0.1);
    }
    .orders-page .empty-icon {
        font-size: 5rem;
        color: #f5a623;
        opacity: 0.6;
        margin-bottom: 30px;
    }
    .orders-page .tracking-info {
        background: rgba(26,26,46,0.04);
        padding: 15px;
        border-radius: 12px;
        margin-top: 15px;
        border: 1px solid rgba(245,166,35,0.08);
    }
    .orders-page .tracking-info h6 { color: #1a1a2e; }
    .orders-page .tracking-step {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .orders-page .tracking-step:last-child { margin-bottom: 0; }
    .orders-page .tracking-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #f5a623;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 0.7rem;
    }
    .orders-page .tracking-icon.pending {
        background: #94a3b8;
    }
    .orders-page .tracking-text { flex: 1; }
    .orders-page .tracking-text .fw-bold { color: #1a1a2e; }
    .orders-page .tracking-date {
        color: #5a5a6e;
        font-size: 0.8rem;
    }
    .orders-page .btn-primary {
        background: linear-gradient(135deg, #f5a623, #e0941a) !important;
        border: none !important;
        font-weight: 600;
        border-radius: 12px;
        padding: 14px 28px;
        box-shadow: 0 4px 14px rgba(245,166,35,0.35);
    }
    .orders-page .btn-primary:hover {
        background: #1a1a2e !important;
        box-shadow: 0 6px 20px rgba(26,26,46,0.3);
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="orders-page">
<!-- Orders Header -->
<section class="orders-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 text-center">
                <h1 class="fw-bold mb-3">
                    <i class="fas fa-shopping-bag me-2"></i>My Orders
                </h1>
                <p class="lead mb-0">Track and manage your orders</p>
            </div>
        </div>
    </div>
</section>

<!-- Orders Content -->
<section class="orders-section">
    <div class="container">
        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="#" class="filter-tab active">All Orders</a>
            <a href="#" class="filter-tab">Processing</a>
            <a href="#" class="filter-tab">Shipped</a>
            <a href="#" class="filter-tab">Delivered</a>
            <a href="#" class="filter-tab">Cancelled</a>
        </div>
        
        <!-- Sample Orders -->
        <div class="order-card">
            <div class="order-header">
                <div>
                    <div class="order-number">Order #12345</div>
                    <div class="order-date">Placed on January 15, 2025</div>
                </div>
                <div class="order-status status-delivered">Delivered</div>
            </div>
            
            <div class="order-items">
                <div class="order-item">
                    <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=60&h=60&fit=crop" 
                         alt="Smart Airpods Pro" class="item-image">
                    <div class="item-details">
                        <div class="item-name">Smart Airpods Pro</div>
                        <div class="item-price">₹2,999 × 1</div>
                    </div>
                </div>
            </div>
            
            <div class="tracking-info">
                <h6 class="fw-bold mb-3">Order Tracking</h6>
                <div class="tracking-step">
                    <div class="tracking-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Order Confirmed</div>
                        <div class="tracking-date">Jan 15, 2025 - 10:30 AM</div>
                    </div>
                </div>
                <div class="tracking-step">
                    <div class="tracking-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Order Shipped</div>
                        <div class="tracking-date">Jan 16, 2025 - 2:15 PM</div>
                    </div>
                </div>
                <div class="tracking-step">
                    <div class="tracking-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Out for Delivery</div>
                        <div class="tracking-date">Jan 18, 2025 - 9:00 AM</div>
                    </div>
                </div>
                <div class="tracking-step">
                    <div class="tracking-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Delivered</div>
                        <div class="tracking-date">Jan 18, 2025 - 3:45 PM</div>
                    </div>
                </div>
            </div>
            
            <div class="order-total">
                <div class="total-amount">Total: ₹2,999</div>
                <div class="order-actions">
                    <a href="#" class="btn-reorder">Reorder</a>
                    <a href="#" class="btn-track">Download Invoice</a>
                </div>
            </div>
        </div>
        
        <div class="order-card">
            <div class="order-header">
                <div>
                    <div class="order-number">Order #12344</div>
                    <div class="order-date">Placed on January 12, 2025</div>
                </div>
                <div class="order-status status-shipped">Shipped</div>
            </div>
            
            <div class="order-items">
                <div class="order-item">
                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=60&h=60&fit=crop" 
                         alt="Smart Watch" class="item-image">
                    <div class="item-details">
                        <div class="item-name">Smart Watch Pro</div>
                        <div class="item-price">₹1,499 × 1</div>
                    </div>
                </div>
            </div>
            
            <div class="tracking-info">
                <h6 class="fw-bold mb-3">Order Tracking</h6>
                <div class="tracking-step">
                    <div class="tracking-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Order Confirmed</div>
                        <div class="tracking-date">Jan 12, 2025 - 11:20 AM</div>
                    </div>
                </div>
                <div class="tracking-step">
                    <div class="tracking-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Order Shipped</div>
                        <div class="tracking-date">Jan 14, 2025 - 4:30 PM</div>
                    </div>
                </div>
                <div class="tracking-step">
                    <div class="tracking-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Out for Delivery</div>
                        <div class="tracking-date">Expected: Jan 16, 2025</div>
                    </div>
                </div>
                <div class="tracking-step">
                    <div class="tracking-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Delivered</div>
                        <div class="tracking-date">Expected: Jan 16, 2025</div>
                    </div>
                </div>
            </div>
            
            <div class="order-total">
                <div class="total-amount">Total: ₹1,499</div>
                <div class="order-actions">
                    <a href="#" class="btn-track">Track Order</a>
                    <button class="btn-cancel">Cancel Order</button>
                </div>
            </div>
        </div>
        
        <div class="order-card">
            <div class="order-header">
                <div>
                    <div class="order-number">Order #12343</div>
                    <div class="order-date">Placed on January 10, 2025</div>
                </div>
                <div class="order-status status-processing">Processing</div>
            </div>
            
            <div class="order-items">
                <div class="order-item">
                    <img src="https://images.unsplash.com/photo-1609592424019-1080b4ac2418?w=60&h=60&fit=crop" 
                         alt="Power Bank" class="item-image">
                    <div class="item-details">
                        <div class="item-name">Power Bank 20000mAh</div>
                        <div class="item-price">₹999 × 1</div>
                    </div>
                </div>
            </div>
            
            <div class="tracking-info">
                <h6 class="fw-bold mb-3">Order Tracking</h6>
                <div class="tracking-step">
                    <div class="tracking-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Order Confirmed</div>
                        <div class="tracking-date">Jan 10, 2025 - 2:45 PM</div>
                    </div>
                </div>
                <div class="tracking-step">
                    <div class="tracking-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Order Shipped</div>
                        <div class="tracking-date">Expected: Jan 17, 2025</div>
                    </div>
                </div>
                <div class="tracking-step">
                    <div class="tracking-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Out for Delivery</div>
                        <div class="tracking-date">Expected: Jan 19, 2025</div>
                    </div>
                </div>
                <div class="tracking-step">
                    <div class="tracking-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="tracking-text">
                        <div class="fw-bold">Delivered</div>
                        <div class="tracking-date">Expected: Jan 19, 2025</div>
                    </div>
                </div>
            </div>
            
            <div class="order-total">
                <div class="total-amount">Total: ₹999</div>
                <div class="order-actions">
                    <button class="btn-cancel">Cancel Order</button>
                </div>
            </div>
        </div>
        
        <!-- Back to Shopping -->
        <div class="text-center mt-5">
            <a href="{{ route('frontend.home') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
            </a>
        </div>
    </div>
</section>
</div>
@endsection 