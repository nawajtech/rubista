@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2>Shopping Cart</h2>
            
            @if(count($cartItems) > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
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
                                        <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=80&h=80&fit=crop" 
                                             class="img-thumbnail me-3" style="width: 80px; height: 80px;">
                                        <div>
                                            <h6>{{ $item['product']->name }}</h6>
                                            <small class="text-muted">{{ Str::limit($item['product']->description, 100) }}</small>
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
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h4>Your cart is empty</h4>
                    <p class="text-muted">Add some products to your cart to get started!</p>
                    <a href="{{ route('frontend.home') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @endif
        </div>
        
        @if(count($cartItems) > 0)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="cart-subtotal">₹{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span>₹0.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong id="cart-total">₹{{ number_format($total, 2) }}</strong>
                    </div>
                    <a href="{{ route('frontend.checkout') }}" class="btn btn-primary btn-lg w-100 mb-2">Proceed to Checkout</a>
                    <button class="btn btn-outline-danger w-100 clear-cart">Clear Cart</button>
                </div>
            </div>
        </div>
        @endif
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
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                quantity: parseInt(quantity)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update item total
                const row = document.querySelector(`tr[data-item-id="${productId}"]`);
                if (row) {
                    row.querySelector('.item-total').textContent = `₹${data.item_total.toFixed(2)}`;
                }
                
                // Update cart totals
                document.getElementById('cart-subtotal').textContent = `₹${data.cart_total.toFixed(2)}`;
                document.getElementById('cart-total').textContent = `₹${data.cart_total.toFixed(2)}`;
                
                // Update navbar cart count
                updateCartCount(data.cart_count);
                
                showNotification('Cart updated successfully!', 'success');
            } else {
                showNotification('Error updating cart: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating cart', 'error');
        });
    }
    
    function removeFromCart(productId) {
        fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the row
                const row = document.querySelector(`tr[data-item-id="${productId}"]`);
                if (row) {
                    row.remove();
                }
                
                // Update cart totals
                document.getElementById('cart-subtotal').textContent = `₹${data.cart_total.toFixed(2)}`;
                document.getElementById('cart-total').textContent = `₹${data.cart_total.toFixed(2)}`;
                
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
                showNotification('Error removing product from cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error removing product from cart', 'error');
        });
    }
    
    function clearCart() {
        fetch('/cart/clear', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Cart cleared successfully!', 'success');
                updateCartCount(0);
                
                // Reload page
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showNotification('Error clearing cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error clearing cart', 'error');
        });
    }
});
</script>
@endsection 