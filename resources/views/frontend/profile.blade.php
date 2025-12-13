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
<!-- Success/Error Messages -->
@if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<!-- Profile Header -->
<section class="profile-header">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-12">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h1 class="fw-bold mb-2">{{ $user->name }}</h1>
                <p class="lead mb-0">{{ $user->email }}</p>
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
                    <form id="profileForm" action="{{ route('frontend.profile.update') }}" method="POST">
                        @csrf
                        <div class="info-item">
                            <span class="info-label">Full Name</span>
                            <span class="info-value">
                                <span id="display-name">{{ $user->name }}</span>
                                <input type="text" name="name" id="edit-name" value="{{ $user->name }}" 
                                       class="form-control d-none" style="max-width: 300px; display: inline-block;">
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email Address</span>
                            <span class="info-value">
                                <span id="display-email">{{ $user->email }}</span>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>Email cannot be changed
                                </small>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Member Since</span>
                            <span class="info-value">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Account Status</span>
                            <span class="info-value">
                                <span class="badge bg-success">Active</span>
                            </span>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn-edit" id="editProfileBtn" onclick="toggleEditProfile()">
                                <i class="fas fa-edit me-2"></i>Edit Profile
                            </button>
                            <button type="submit" class="btn-edit d-none" id="saveProfileBtn">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            <button type="button" class="btn btn-secondary d-none" id="cancelProfileBtn" onclick="cancelEditProfile()">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Address Information -->
                <div class="profile-card">
                    <h5><i class="fas fa-map-marker-alt me-2"></i>Address Information</h5>
                    <form id="addressForm" action="{{ route('frontend.profile.update-address') }}" method="POST">
                        @csrf
                        @php
                            $userAddress = session('user_address', []);
                            if ($latestOrder) {
                                $userAddress = [
                                    'address' => $latestOrder->shipping_address ?? '',
                                    'city' => $latestOrder->shipping_city ?? '',
                                    'state' => $latestOrder->shipping_state ?? '',
                                    'postal_code' => $latestOrder->shipping_postal_code ?? '',
                                    'phone' => $latestOrder->shipping_phone ?? '',
                                ];
                            }
                        @endphp
                        <div class="info-item">
                            <span class="info-label">Street Address</span>
                            <span class="info-value">
                                <span id="display-address">{{ $userAddress['address'] ?? 'Not set' }}</span>
                                <textarea name="address" id="edit-address" rows="2" 
                                          class="form-control d-none" style="max-width: 300px;">{{ $userAddress['address'] ?? '' }}</textarea>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">City</span>
                            <span class="info-value">
                                <span id="display-city">{{ $userAddress['city'] ?? 'Not set' }}</span>
                                <input type="text" name="city" id="edit-city" value="{{ $userAddress['city'] ?? '' }}" 
                                       class="form-control d-none" style="max-width: 300px; display: inline-block;">
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">State</span>
                            <span class="info-value">
                                <span id="display-state">{{ $userAddress['state'] ?? 'Not set' }}</span>
                                <input type="text" name="state" id="edit-state" value="{{ $userAddress['state'] ?? '' }}" 
                                       class="form-control d-none" style="max-width: 300px; display: inline-block;">
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">PIN Code</span>
                            <span class="info-value">
                                <span id="display-postal">{{ $userAddress['postal_code'] ?? 'Not set' }}</span>
                                <input type="text" name="postal_code" id="edit-postal" value="{{ $userAddress['postal_code'] ?? '' }}" 
                                       class="form-control d-none" style="max-width: 300px; display: inline-block;">
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Phone</span>
                            <span class="info-value">
                                <span id="display-phone">{{ $userAddress['phone'] ?? 'Not set' }}</span>
                                <input type="text" name="phone" id="edit-phone" value="{{ $userAddress['phone'] ?? '' }}" 
                                       class="form-control d-none" style="max-width: 300px; display: inline-block;">
                            </span>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn-edit" id="editAddressBtn" onclick="toggleEditAddress()">
                                <i class="fas fa-edit me-2"></i>Edit Address
                            </button>
                            <button type="submit" class="btn-edit d-none" id="saveAddressBtn">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            <button type="button" class="btn btn-secondary d-none" id="cancelAddressBtn" onclick="cancelEditAddress()">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Recent Orders -->
                <div class="recent-orders">
                    <h5><i class="fas fa-shopping-bag me-2"></i>Recent Orders</h5>
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                        <div class="order-item">
                            <div>
                                <div class="fw-bold">
                                    <a href="{{ route('frontend.orders.show', $order->id) }}" class="text-decoration-none">
                                        Order #{{ $order->order_number }}
                                    </a>
                                </div>
                                <small class="text-muted">Placed on {{ $order->created_at->format('M d, Y') }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</div>
                                <div class="order-status status-{{ strtolower($order->status) }}">
                                    {{ ucfirst($order->status) }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No orders yet</p>
                            <a href="{{ route('frontend.home') }}" class="btn btn-primary">Start Shopping</a>
                        </div>
                    @endif
                    @if($orders->count() > 0)
                    <div class="text-center mt-3">
                        <a href="{{ route('frontend.orders') }}" class="btn btn-outline-primary">
                            View All Orders
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Account Stats -->
                <div class="row">
                    <div class="col-6">
                        <div class="stats-card">
                            <span class="stats-number">{{ $totalOrders }}</span>
                            <div class="stats-label">Total Orders</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-card">
                            <span class="stats-number">{{ $wishlistCount }}</span>
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
                    <form id="passwordForm" action="{{ route('frontend.profile.change-password') }}" method="POST">
                        @csrf
                        <div class="info-item">
                            <span class="info-label">Password</span>
                            <span class="info-value">••••••••</span>
                        </div>
                        <div id="passwordFields" class="d-none">
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                                @error('current_password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control" required>
                                @error('new_password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn-edit" id="changePasswordBtn" onclick="toggleChangePassword()">
                                <i class="fas fa-key me-2"></i>Change Password
                            </button>
                            <button type="submit" class="btn-edit d-none" id="savePasswordBtn">
                                <i class="fas fa-save me-2"></i>Save Password
                            </button>
                            <button type="button" class="btn btn-secondary d-none" id="cancelPasswordBtn" onclick="cancelChangePassword()">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    // Profile Edit Toggle
    function toggleEditProfile() {
        document.getElementById('display-name').classList.add('d-none');
        document.getElementById('edit-name').classList.remove('d-none');
        document.getElementById('editProfileBtn').classList.add('d-none');
        document.getElementById('saveProfileBtn').classList.remove('d-none');
        document.getElementById('cancelProfileBtn').classList.remove('d-none');
    }

    function cancelEditProfile() {
        document.getElementById('display-name').classList.remove('d-none');
        document.getElementById('edit-name').classList.add('d-none');
        document.getElementById('editProfileBtn').classList.remove('d-none');
        document.getElementById('saveProfileBtn').classList.add('d-none');
        document.getElementById('cancelProfileBtn').classList.add('d-none');
        
        // Reset form values
        document.getElementById('edit-name').value = document.getElementById('display-name').textContent;
    }

    // Address Edit Toggle
    function toggleEditAddress() {
        document.getElementById('display-address').classList.add('d-none');
        document.getElementById('display-city').classList.add('d-none');
        document.getElementById('display-state').classList.add('d-none');
        document.getElementById('display-postal').classList.add('d-none');
        document.getElementById('display-phone').classList.add('d-none');
        
        document.getElementById('edit-address').classList.remove('d-none');
        document.getElementById('edit-city').classList.remove('d-none');
        document.getElementById('edit-state').classList.remove('d-none');
        document.getElementById('edit-postal').classList.remove('d-none');
        document.getElementById('edit-phone').classList.remove('d-none');
        
        document.getElementById('editAddressBtn').classList.add('d-none');
        document.getElementById('saveAddressBtn').classList.remove('d-none');
        document.getElementById('cancelAddressBtn').classList.remove('d-none');
    }

    function cancelEditAddress() {
        document.getElementById('display-address').classList.remove('d-none');
        document.getElementById('display-city').classList.remove('d-none');
        document.getElementById('display-state').classList.remove('d-none');
        document.getElementById('display-postal').classList.remove('d-none');
        document.getElementById('display-phone').classList.remove('d-none');
        
        document.getElementById('edit-address').classList.add('d-none');
        document.getElementById('edit-city').classList.add('d-none');
        document.getElementById('edit-state').classList.add('d-none');
        document.getElementById('edit-postal').classList.add('d-none');
        document.getElementById('edit-phone').classList.add('d-none');
        
        document.getElementById('editAddressBtn').classList.remove('d-none');
        document.getElementById('saveAddressBtn').classList.add('d-none');
        document.getElementById('cancelAddressBtn').classList.add('d-none');
    }

    // Password Change Toggle
    function toggleChangePassword() {
        document.getElementById('passwordFields').classList.remove('d-none');
        document.getElementById('changePasswordBtn').classList.add('d-none');
        document.getElementById('savePasswordBtn').classList.remove('d-none');
        document.getElementById('cancelPasswordBtn').classList.remove('d-none');
    }

    function cancelChangePassword() {
        document.getElementById('passwordFields').classList.add('d-none');
        document.getElementById('changePasswordBtn').classList.remove('d-none');
        document.getElementById('savePasswordBtn').classList.add('d-none');
        document.getElementById('cancelPasswordBtn').classList.add('d-none');
        
        // Reset form
        document.getElementById('passwordForm').reset();
    }

    // Form submissions with proper error handling
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = document.getElementById('saveProfileBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                document.querySelector('input[name="_token"]')?.value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update display values
                document.getElementById('display-name').textContent = formData.get('name');
                cancelEditProfile();
                
                // Show success message
                showNotification('Profile updated successfully!', 'success');
                // Reload page to update header
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message || 'Error updating profile', 'error');
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating profile. Please try again.', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    document.getElementById('addressForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = document.getElementById('saveAddressBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                document.querySelector('input[name="_token"]')?.value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update display values
                document.getElementById('display-address').textContent = formData.get('address') || 'Not set';
                document.getElementById('display-city').textContent = formData.get('city') || 'Not set';
                document.getElementById('display-state').textContent = formData.get('state') || 'Not set';
                document.getElementById('display-postal').textContent = formData.get('postal_code') || 'Not set';
                document.getElementById('display-phone').textContent = formData.get('phone') || 'Not set';
                cancelEditAddress();
                
                // Show success message
                showNotification('Address updated successfully!', 'success');
            } else {
                showNotification(data.message || 'Error updating address', 'error');
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating address. Please try again.', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = document.getElementById('savePasswordBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                document.querySelector('input[name="_token"]')?.value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Password changed successfully!', 'success');
                cancelChangePassword();
            } else {
                showNotification(data.message || 'Error changing password', 'error');
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error changing password. Please try again.', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // Notification function
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        notification.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
</script>
@endsection 