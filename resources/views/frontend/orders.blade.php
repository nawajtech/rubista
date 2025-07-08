@extends('frontend.layouts.app')

@section('title', 'My Orders - Rubista')

@section('extra-css')
<style>
    .orders-section {
        padding: 50px 0;
        background: #f8f9fa;
    }
    
    .orders-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
        margin-bottom: 50px;
    }
    
    .order-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 30px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .order-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .order-number {
        font-size: 1.2rem;
        font-weight: 700;
        color: #667eea;
    }
    
    .order-date {
        color: #666;
        font-size: 0.9rem;
    }
    
    .order-status {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .status-delivered {
        background: #d4edda;
        color: #155724;
    }
    
    .status-processing {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-shipped {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }
    
    .order-items {
        margin-bottom: 20px;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .item-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
    }
    
    .item-details {
        flex: 1;
    }
    
    .item-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    
    .item-price {
        color: #666;
        font-size: 0.9rem;
    }
    
    .item-quantity {
        color: #666;
        font-size: 0.9rem;
    }
    
    .order-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #eee;
        margin-top: 20px;
    }
    
    .total-amount {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
    }
    
    .order-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-track {
        background: #28a745;
        border: none;
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-track:hover {
        background: #218838;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-reorder {
        background: #667eea;
        border: none;
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-reorder:hover {
        background: #5a67d8;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-cancel {
        background: #dc3545;
        border: none;
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #c82333;
        transform: translateY(-2px);
    }
    
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }
    
    .filter-tab {
        padding: 10px 20px;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        background: white;
        color: #666;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .filter-tab.active,
    .filter-tab:hover {
        border-color: #667eea;
        color: #667eea;
        background: #f8f9ff;
    }
    
    .empty-orders {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .empty-icon {
        font-size: 5rem;
        color: #dee2e6;
        margin-bottom: 30px;
    }
    
    .tracking-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-top: 15px;
    }
    
    .tracking-step {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .tracking-step:last-child {
        margin-bottom: 0;
    }
    
    .tracking-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #28a745;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 0.7rem;
    }
    
    .tracking-icon.pending {
        background: #6c757d;
    }
    
    .tracking-text {
        flex: 1;
    }
    
    .tracking-date {
        color: #666;
        font-size: 0.8rem;
    }
</style>
@endsection

@section('content')
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
@endsection 