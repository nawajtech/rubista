@extends('frontend.layouts.app')

@section('title', 'My Profile - Rubista')

@section('extra-css')
<style>
    .profile-section {
        padding: 50px 0;
        background: #f8f9fa;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
        margin-bottom: 50px;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto 30px;
    }
    
    .profile-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 30px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .profile-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .profile-card h5 {
        color: #667eea;
        margin-bottom: 25px;
        font-weight: 700;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #666;
    }
    
    .info-value {
        color: #333;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 25px;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #667eea;
        display: block;
    }
    
    .stats-label {
        color: #666;
        font-size: 0.9rem;
        margin-top: 5px;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    
    .action-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }
    
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        color: inherit;
    }
    
    .action-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 2rem;
    }
    
    .recent-orders {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 30px;
        margin-top: 30px;
    }
    
    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .order-status {
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
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
</style>
@endsection

@section('content')
<!-- Profile Header -->
<section class="profile-header">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-12">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h1 class="fw-bold mb-2">{{ Auth::user()->name }}</h1>
                <p class="lead mb-0">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Profile Content -->
<section class="profile-section">
    <div class="container">
        <div class="row">
            <!-- Profile Information -->
            <div class="col-lg-8">
                <div class="profile-card">
                    <h5><i class="fas fa-user me-2"></i>Personal Information</h5>
                    <div class="info-item">
                        <span class="info-label">Full Name</span>
                        <span class="info-value">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email Address</span>
                        <span class="info-value">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Member Since</span>
                        <span class="info-value">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Account Status</span>
                        <span class="info-value">
                            <span class="badge bg-success">Active</span>
                        </span>
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn-edit">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </button>
                    </div>
                </div>
                
                <!-- Address Information -->
                <div class="profile-card">
                    <h5><i class="fas fa-map-marker-alt me-2"></i>Address Information</h5>
                    <div class="info-item">
                        <span class="info-label">Street Address</span>
                        <span class="info-value">123 Main Street</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">City</span>
                        <span class="info-value">Mumbai</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">State</span>
                        <span class="info-value">Maharashtra</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">PIN Code</span>
                        <span class="info-value">400001</span>
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn-edit">
                            <i class="fas fa-edit me-2"></i>Edit Address
                        </button>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="recent-orders">
                    <h5><i class="fas fa-shopping-bag me-2"></i>Recent Orders</h5>
                    <div class="order-item">
                        <div>
                            <div class="fw-bold">Order #12345</div>
                            <small class="text-muted">Placed on Jan 15, 2025</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">₹2,999</div>
                            <div class="order-status status-delivered">Delivered</div>
                        </div>
                    </div>
                    <div class="order-item">
                        <div>
                            <div class="fw-bold">Order #12344</div>
                            <small class="text-muted">Placed on Jan 12, 2025</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">₹1,499</div>
                            <div class="order-status status-shipped">Shipped</div>
                        </div>
                    </div>
                    <div class="order-item">
                        <div>
                            <div class="fw-bold">Order #12343</div>
                            <small class="text-muted">Placed on Jan 10, 2025</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">₹999</div>
                            <div class="order-status status-processing">Processing</div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('frontend.orders') }}" class="btn btn-outline-primary">
                            View All Orders
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Account Stats -->
                <div class="row">
                    <div class="col-6">
                        <div class="stats-card">
                            <span class="stats-number">15</span>
                            <div class="stats-label">Total Orders</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-card">
                            <span class="stats-number">5</span>
                            <div class="stats-label">Wishlist Items</div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <a href="{{ route('frontend.orders') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h6 class="fw-bold">My Orders</h6>
                        <p class="text-muted small mb-0">View order history</p>
                    </a>
                    
                    <a href="{{ route('frontend.wishlist') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h6 class="fw-bold">Wishlist</h6>
                        <p class="text-muted small mb-0">Saved items</p>
                    </a>
                    
                    <a href="{{ route('frontend.cart') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h6 class="fw-bold">Shopping Cart</h6>
                        <p class="text-muted small mb-0">Items in cart</p>
                    </a>
                    
                    <a href="{{ route('frontend.contact') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h6 class="fw-bold">Support</h6>
                        <p class="text-muted small mb-0">Get help</p>
                    </a>
                </div>
                
                <!-- Account Security -->
                <div class="profile-card mt-4">
                    <h5><i class="fas fa-shield-alt me-2"></i>Account Security</h5>
                    <div class="info-item">
                        <span class="info-label">Password</span>
                        <span class="info-value">••••••••</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Two-Factor Auth</span>
                        <span class="info-value">
                            <span class="badge bg-warning">Disabled</span>
                        </span>
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn-edit">
                            <i class="fas fa-key me-2"></i>Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 