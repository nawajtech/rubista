@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')

@section('extra-css')
<style>
    .cart-page .cart-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #fff;
        padding: 36px 0;
        margin-bottom: 2rem;
        border-radius: 16px;
    }
    .cart-page .cart-hero h2 { color: #fff; font-weight: 700; margin: 0; }

    .cart-page .table thead th {
        background: #1a1a2e;
        color: #fff;
        font-weight: 600;
        border: none;
        padding: 14px 12px;
    }
    .cart-page .table tbody td {
        vertical-align: middle;
        padding: 16px 12px;
        color: #1a1a2e;
    }
    .cart-page .table tbody tr {
        border-bottom: 1px solid rgba(26,26,46,0.08);
        transition: background 0.2s ease;
    }
    .cart-page .table tbody tr:hover {
        background: rgba(245,166,35,0.04);
    }
    .cart-page .table h6 { color: #1a1a2e; }
    .cart-page .table .text-muted { color: #5a5a6e !important; }
    .cart-page .table .img-thumbnail {
        border-radius: 10px;
        border-color: rgba(26,26,46,0.1);
    }

    .cart-page .input-group .btn-outline-secondary {
        border-color: rgba(26,26,46,0.2);
        color: #1a1a2e;
        font-weight: 600;
    }
    .cart-page .input-group .btn-outline-secondary:hover {
        background: #f5a623;
        border-color: #f5a623;
        color: #fff;
    }
    .cart-page .input-group .form-control {
        border-color: rgba(26,26,46,0.15);
    }
    .cart-page .input-group .form-control:focus {
        border-color: #f5a623;
        box-shadow: 0 0 0 0.2rem rgba(245,166,35,0.25);
    }
    .cart-page .btn-danger {
        background: rgba(239,68,68,0.12);
        color: #ef4444;
        border: none;
        border-radius: 8px;
    }
    .cart-page .btn-danger:hover {
        background: #ef4444;
        color: #fff;
    }

    .cart-page .card {
        border-radius: 16px;
        border: 1px solid rgba(245,166,35,0.15);
        box-shadow: 0 4px 20px rgba(26,26,46,0.08);
    }
    .cart-page .card-title { color: #1a1a2e; font-weight: 600; }
    .cart-page .card-body span { color: #5a5a6e; }
    .cart-page .alert-info {
        background: rgba(245,166,35,0.12);
        border-color: rgba(245,166,35,0.3);
        color: #1a1a2e;
        border-radius: 10px;
    }
    .cart-page .btn-primary {
        background: linear-gradient(135deg, #f5a623, #e0941a) !important;
        border: none !important;
        font-weight: 600;
        border-radius: 12px;
        padding: 14px;
        box-shadow: 0 4px 14px rgba(245,166,35,0.35);
    }
    .cart-page .btn-primary:hover {
        background: #1a1a2e !important;
        box-shadow: 0 6px 20px rgba(26,26,46,0.3);
        color: #fff;
    }
    .cart-page .clear-cart.btn-outline-danger {
        border-color: rgba(26,26,46,0.2);
        color: #5a5a6e;
        border-radius: 12px;
        font-weight: 500;
    }
    .cart-page .clear-cart.btn-outline-danger:hover {
        background: rgba(239,68,68,0.08);
        border-color: #ef4444;
        color: #ef4444;
    }

    .cart-page .empty-cart {
        padding: 60px 20px;
        text-align: center;
    }
    .cart-page .empty-cart .fa-shopping-cart { color: #f5a623; opacity: 0.8; }
    .cart-page .empty-cart h4 { color: #1a1a2e; }
    .cart-page .empty-cart .text-muted { color: #5a5a6e !important; }
    .cart-page .empty-cart .btn-primary {
        background: linear-gradient(135deg, #f5a623, #e0941a) !important;
        border: none !important;
        font-weight: 600;
        border-radius: 12px;
        padding: 12px 24px;
        box-shadow: 0 4px 14px rgba(245,166,35,0.35);
    }
    .cart-page .empty-cart .btn-primary:hover {
        background: #1a1a2e !important;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="cart-page">
<div class="container py-4">
    <div class="cart-hero">
        <h2><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h2>
    </div>
    <div class="row">
        <div class="col-lg-8">
            @if(count($cartItems) > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr data-item-id="{{ $item['id'] }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item['product']->image)
                                            @if(Str::startsWith($item['product']->image, 'http'))
                                                <img src="{{ $item['product']->image }}" 
                                                     class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('storage/' . $item['product']->image) }}" 
                                                     class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                            @endif
                                        @else
                                            <div class="img-thumbnail me-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); display: flex; align-items: center; justify-content: center; color: #f5a623;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6>{{ $item['product']->name }}</h6>
                                            <small class="text-muted">{{ Str::limit($item['product']->description ?? '', 100) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>₹{{ number_format($item['price'], 2) }}</td>
                                <td>
                                    <div class="input-group" style="width: 120px;">
                                        <button class="btn btn-outline-secondary btn-sm decrease-quantity" 
                                                data-product-id="{{ $item['id'] }}" type="button">-</button>
                                        <input type="number" class="form-control text-center quantity-input" 
                                               value="{{ $item['quantity'] }}" min="1" data-product-id="{{ $item['id'] }}">
                                        <button class="btn btn-outline-secondary btn-sm increase-quantity" 
                                                data-product-id="{{ $item['id'] }}" type="button">+</button>
                                    </div>
                                </td>
                                <td class="item-total">₹{{ number_format($item['total'], 2) }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm remove-item" data-product-id="{{ $item['id'] }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center empty-cart py-5">
                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                    <h4>Your cart is empty</h4>
                    <p class="text-muted">Add some products to your cart to get started!</p>
                    <a href="{{ route('frontend.home') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @endif
        </div>
        
        @if(count($cartItems) > 0)
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="cart-subtotal">₹{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span id="cart-shipping">
                            @if($shipping > 0)
                                ₹{{ number_format($shipping, 2) }}
                            @else
                                Free
                            @endif
                        </span>
                    </div>
                    @if($tax > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span id="cart-tax">₹{{ number_format($tax, 2) }}</span>
                    </div>
                    @endif
                    @if(isset($settings['free_shipping_threshold']) && $settings['free_shipping_threshold'] > 0 && $total < $settings['free_shipping_threshold'])
                    <div class="alert alert-info py-2 px-3 mb-2" style="font-size: 0.85rem;">
                        <i class="fas fa-info-circle me-1"></i>
                        Add ₹{{ number_format($settings['free_shipping_threshold'] - $total, 2) }} more for free shipping!
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong id="cart-total">₹{{ number_format($grandTotal, 2) }}</strong>
                    </div>
                    <a href="{{ route('frontend.checkout') }}" class="btn btn-primary btn-lg w-100 mb-2">Proceed to Checkout</a>
                    <button class="btn btn-outline-danger w-100 clear-cart">Clear Cart</button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
</div>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Handle quantity changes
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            updateCartQuantity(this.dataset.productId, this.value);
        });
    });
    
    // Handle increase quantity
    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const input = document.querySelector(`input[data-product-id="${productId}"]`);
            const newQuantity = parseInt(input.value) + 1;
            input.value = newQuantity;
            updateCartQuantity(productId, newQuantity);
        });
    });
    
    // Handle decrease quantity
    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const input = document.querySelector(`input[data-product-id="${productId}"]`);
            const newQuantity = Math.max(1, parseInt(input.value) - 1);
            input.value = newQuantity;
            updateCartQuantity(productId, newQuantity);
        });
    });
    
    // Handle remove item
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            removeFromCart(productId);
        });
    });
    
    // Handle clear cart
    document.querySelector('.clear-cart')?.addEventListener('click', function() {
        if (confirm('Are you sure you want to clear your cart?')) {
            clearCart();
        }
    });
    
    function updateCartQuantity(productId, quantity) {
        fetch(`/cart/update/${productId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                quantity: parseInt(quantity)
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update item total
                const row = document.querySelector(`tr[data-item-id="${productId}"]`);
                if (row) {
                    row.querySelector('.item-total').textContent = `₹${data.item_total.toFixed(2)}`;
                }
                
                // Update cart totals
                document.getElementById('cart-subtotal').textContent = `₹${data.cart_total.toFixed(2)}`;
                
                // Update shipping
                const shippingElement = document.getElementById('cart-shipping');
                if (shippingElement) {
                    shippingElement.textContent = data.shipping > 0 ? `₹${data.shipping.toFixed(2)}` : 'Free';
                }
                
                // Update tax if exists
                const taxElement = document.getElementById('cart-tax');
                if (taxElement && data.tax > 0) {
                    taxElement.textContent = `₹${data.tax.toFixed(2)}`;
                }
                
                // Update grand total
                document.getElementById('cart-total').textContent = `₹${data.grand_total.toFixed(2)}`;
                
                // Update free shipping message
                updateFreeShippingMessage(data.cart_total, data.free_shipping_threshold);
                
                // Update navbar cart count
                updateCartCount(data.cart_count);
                
                showNotification('Cart updated successfully!', 'success');
            } else {
                showNotification('Error updating cart: ' + (data.message || 'Unknown error'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorMessage = error.message || error.errors || 'Error updating cart';
            showNotification(typeof errorMessage === 'string' ? errorMessage : 'Error updating cart', 'error');
        });
    }
    
    function removeFromCart(productId) {
        fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Remove the row
                const row = document.querySelector(`tr[data-item-id="${productId}"]`);
                if (row) {
                    row.remove();
                }
                
                // Update cart totals
                document.getElementById('cart-subtotal').textContent = `₹${data.cart_total.toFixed(2)}`;
                
                // Update shipping
                const shippingElement = document.getElementById('cart-shipping');
                if (shippingElement) {
                    shippingElement.textContent = data.shipping > 0 ? `₹${data.shipping.toFixed(2)}` : 'Free';
                }
                
                // Update tax if exists
                const taxElement = document.getElementById('cart-tax');
                if (taxElement && data.tax > 0) {
                    taxElement.textContent = `₹${data.tax.toFixed(2)}`;
                }
                
                // Update grand total
                document.getElementById('cart-total').textContent = `₹${data.grand_total.toFixed(2)}`;
                
                // Update free shipping message
                updateFreeShippingMessage(data.cart_total, data.free_shipping_threshold);
                
                // Update navbar cart count
                updateCartCount(data.cart_count);
                
                showNotification('Product removed from cart!', 'success');
                
                // Reload page if cart is empty
                if (data.cart_count === 0) {
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            } else {
                showNotification('Error removing product from cart: ' + (data.message || 'Unknown error'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorMessage = error.message || error.errors || 'Error removing product from cart';
            showNotification(typeof errorMessage === 'string' ? errorMessage : 'Error removing product from cart', 'error');
        });
    }
    
    function clearCart() {
        fetch('/cart/clear', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showNotification('Cart cleared successfully!', 'success');
                updateCartCount(0);
                
                // Reload page
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showNotification('Error clearing cart: ' + (data.message || 'Unknown error'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorMessage = error.message || error.errors || 'Error clearing cart';
            showNotification(typeof errorMessage === 'string' ? errorMessage : 'Error clearing cart', 'error');
        });
    }
    
    function updateFreeShippingMessage(cartTotal, freeShippingThreshold) {
        const freeShippingAlert = document.querySelector('.alert-info');
        if (freeShippingThreshold > 0 && cartTotal < freeShippingThreshold) {
            const amountNeeded = freeShippingThreshold - cartTotal;
            if (freeShippingAlert) {
                freeShippingAlert.innerHTML = `<i class="fas fa-info-circle me-1"></i> Add ₹${amountNeeded.toFixed(2)} more for free shipping!`;
                freeShippingAlert.style.display = 'block';
            }
        } else if (freeShippingAlert) {
            freeShippingAlert.style.display = 'none';
        }
    }
    
    // Helper function to show toast notifications
    function showNotification(message, type = 'success') {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? '#f5a623' : type === 'error' ? '#ef4444' : '#1a1a2e';
        toast.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${bgColor};
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                z-index: 9999;
                font-weight: 600;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                animation: slideInRight 0.3s ease;
            ">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} me-2"></i>${message}
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
    
    // Helper function to update cart count in navbar
    function updateCartCount(count) {
        const cartBadges = document.querySelectorAll('.cart-count, .cart-badge, [data-cart-count], .action-badge.cart-count');
        cartBadges.forEach(badge => {
            badge.textContent = count;
            if (count > 0) {
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        });
    }
});
</script>
<style>
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>
@endsection 
