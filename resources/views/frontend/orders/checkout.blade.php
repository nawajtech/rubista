@extends('frontend.layouts.app')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@section('title', 'Checkout - Rubista')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4"><i class="fas fa-credit-card me-2"></i>Checkout</h2>
        </div>
    </div>

    <form method="POST" action="{{ route('frontend.checkout.store') }}" id="checkout-form">
        @csrf
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature" value="">
        <div class="row">
            <!-- Checkout Form -->
            <div class="col-lg-8">
                <!-- Billing Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Billing Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="billing_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="billing_first_name" id="billing_first_name" 
                                           class="form-control @error('billing_first_name') is-invalid @enderror" 
                                           value="{{ old('billing_first_name', Auth::user()->name ?? '') }}" required>
                                    @error('billing_first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="billing_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="billing_last_name" id="billing_last_name" 
                                           class="form-control @error('billing_last_name') is-invalid @enderror" 
                                           value="{{ old('billing_last_name') }}" required>
                                    @error('billing_last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="billing_email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="billing_email" id="billing_email" 
                                           class="form-control @error('billing_email') is-invalid @enderror" 
                                           value="{{ old('billing_email', Auth::user()->email ?? '') }}" required>
                                    @error('billing_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="billing_phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="billing_phone" id="billing_phone" 
                                           class="form-control @error('billing_phone') is-invalid @enderror" 
                                           value="{{ old('billing_phone') }}" required>
                                    @error('billing_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea name="billing_address" id="billing_address" rows="3" 
                                      class="form-control @error('billing_address') is-invalid @enderror" 
                                      required>{{ old('billing_address') }}</textarea>
                            @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="billing_city" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" name="billing_city" id="billing_city" 
                                           class="form-control @error('billing_city') is-invalid @enderror" 
                                           value="{{ old('billing_city') }}" required>
                                    @error('billing_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="billing_state" class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" name="billing_state" id="billing_state" 
                                           class="form-control @error('billing_state') is-invalid @enderror" 
                                           value="{{ old('billing_state') }}" required>
                                    @error('billing_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="billing_postal_code" class="form-label">ZIP Code <span class="text-danger">*</span></label>
                                    <input type="text" name="billing_postal_code" id="billing_postal_code" 
                                           class="form-control @error('billing_postal_code') is-invalid @enderror" 
                                           value="{{ old('billing_postal_code') }}" required>
                                    @error('billing_postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="billing_country" class="form-label">Country <span class="text-danger">*</span></label>
                            <select name="billing_country" id="billing_country" 
                                    class="form-select @error('billing_country') is-invalid @enderror" required>
                                <option value="">Select Country</option>
                                <option value="India" {{ old('billing_country') === 'India' ? 'selected' : '' }}>India</option>
                                <option value="United States" {{ old('billing_country') === 'United States' ? 'selected' : '' }}>United States</option>
                                <option value="United Kingdom" {{ old('billing_country') === 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                            </select>
                            @error('billing_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Shipping Information</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="same_as_billing" onchange="copyBillingToShipping()">
                            <label class="form-check-label" for="same_as_billing">
                                Same as billing address
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shipping_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_first_name" id="shipping_first_name" 
                                           class="form-control @error('shipping_first_name') is-invalid @enderror" 
                                           value="{{ old('shipping_first_name') }}" required>
                                    @error('shipping_first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shipping_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_last_name" id="shipping_last_name" 
                                           class="form-control @error('shipping_last_name') is-invalid @enderror" 
                                           value="{{ old('shipping_last_name') }}" required>
                                    @error('shipping_last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_phone" id="shipping_phone" 
                                   class="form-control @error('shipping_phone') is-invalid @enderror" 
                                   value="{{ old('shipping_phone') }}" required>
                            @error('shipping_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" id="shipping_address" rows="3" 
                                      class="form-control @error('shipping_address') is-invalid @enderror" 
                                      required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shipping_city" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_city" id="shipping_city" 
                                           class="form-control @error('shipping_city') is-invalid @enderror" 
                                           value="{{ old('shipping_city') }}" required>
                                    @error('shipping_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="shipping_state" class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_state" id="shipping_state" 
                                           class="form-control @error('shipping_state') is-invalid @enderror" 
                                           value="{{ old('shipping_state') }}" required>
                                    @error('shipping_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="shipping_postal_code" class="form-label">ZIP Code <span class="text-danger">*</span></label>
                                    <input type="text" name="shipping_postal_code" id="shipping_postal_code" 
                                           class="form-control @error('shipping_postal_code') is-invalid @enderror" 
                                           value="{{ old('shipping_postal_code') }}" required>
                                    @error('shipping_postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_country" class="form-label">Country <span class="text-danger">*</span></label>
                            <select name="shipping_country" id="shipping_country" 
                                    class="form-select @error('shipping_country') is-invalid @enderror" required>
                                <option value="">Select Country</option>
                                <option value="India" {{ old('shipping_country') === 'India' ? 'selected' : '' }}>India</option>
                                <option value="United States" {{ old('shipping_country') === 'United States' ? 'selected' : '' }}>United States</option>
                                <option value="United Kingdom" {{ old('shipping_country') === 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                            </select>
                            @error('shipping_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" 
                                           {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cod">
                                        <i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="razorpay" value="razorpay"
                                           {{ old('payment_method') === 'razorpay' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="razorpay">
                                        <i class="fas fa-credit-card me-2"></i>Online Payment (Razorpay)
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('payment_method')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Order Notes (Optional)</h5>
                    </div>
                    <div class="card-body">
                        <textarea name="notes" id="notes" rows="3" 
                                  class="form-control" 
                                  placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <!-- Cart Items -->
                        <div class="order-items mb-3">
                            @foreach($cartItems as $item)
                            <div class="d-flex align-items-center mb-3">
                                @if($item['product']->image)
                                    <img src="{{ $item['product']->image }}" class="img-thumbnail me-3" style="width: 50px; height: 50px;">
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $item['product']->name }}</h6>
                                    <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                </div>
                                <div>
                                    <strong>₹{{ number_format($item['total'], 2) }}</strong>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <hr>
                        
                        <!-- Order Totals -->
                        <dl class="row">
                            <dt class="col-8">Subtotal:</dt>
                            <dd class="col-4 text-end">₹{{ number_format($subtotal, 2) }}</dd>
                            
                            <dt class="col-8">Shipping:</dt>
                            <dd class="col-4 text-end text-success">
                                @if($shipping > 0)
                                    ₹{{ number_format($shipping, 2) }}
                                @else
                                    Free
                                @endif
                            </dd>
                            
                            @if($tax > 0)
                            <dt class="col-8">Tax:</dt>
                            <dd class="col-4 text-end">₹{{ number_format($tax, 2) }}</dd>
                            @endif
                        </dl>
                        
                        <hr>
                        
                        <dl class="row">
                            <dt class="col-8 h5">Total:</dt>
                            <dd class="col-4 text-end h5 text-primary">₹{{ number_format($total, 2) }}</dd>
                        </dl>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="place-order-btn">
                                <i class="fas fa-lock me-2"></i>Place Order
                            </button>
                            <a href="{{ route('frontend.cart') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Cart
                            </a>
                        </div>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Secure checkout powered by SSL encryption
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function copyBillingToShipping() {
    const checkbox = document.getElementById('same_as_billing');
    if (checkbox.checked) {
        // Copy billing to shipping
        document.getElementById('shipping_first_name').value = document.getElementById('billing_first_name').value;
        document.getElementById('shipping_last_name').value = document.getElementById('billing_last_name').value;
        document.getElementById('shipping_phone').value = document.getElementById('billing_phone').value;
        document.getElementById('shipping_address').value = document.getElementById('billing_address').value;
        document.getElementById('shipping_city').value = document.getElementById('billing_city').value;
        document.getElementById('shipping_state').value = document.getElementById('billing_state').value;
        document.getElementById('shipping_postal_code').value = document.getElementById('billing_postal_code').value;
        document.getElementById('shipping_country').value = document.getElementById('billing_country').value;
    } else {
        // Clear shipping fields
        document.getElementById('shipping_first_name').value = '';
        document.getElementById('shipping_last_name').value = '';
        document.getElementById('shipping_phone').value = '';
        document.getElementById('shipping_address').value = '';
        document.getElementById('shipping_city').value = '';
        document.getElementById('shipping_state').value = '';
        document.getElementById('shipping_postal_code').value = '';
        document.getElementById('shipping_country').value = '';
    }
}
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
(function () {
    var orderTotalRupees = {{ round($total, 2) }};
    var createOrderUrl = "{{ url('/create-order') }}";
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var form = document.getElementById('checkout-form');
    var placeOrderBtn = document.getElementById('place-order-btn');

    form.addEventListener('submit', function (e) {
        if (window.razorpayFormSubmitting) return;
        var paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod || paymentMethod.value !== 'razorpay') {
            return;
        }
        e.preventDefault();

        placeOrderBtn.disabled = true;
        placeOrderBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Opening payment...';

        fetch(createOrderUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ amount: orderTotalRupees })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.error) {
                alert(data.error || 'Could not create payment order.');
                placeOrderBtn.disabled = false;
                placeOrderBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Place Order';
                return;
            }
            var options = {
                key: data.key,
                amount: data.amount,
                currency: 'INR',
                name: '{{ config("app.name", "Rubista") }}',
                description: 'Order Payment',
                order_id: data.order_id,
                handler: function (response) {
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                    placeOrderBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Placing order...';
                    window.razorpayFormSubmitting = true;
                    form.submit();
                },
                modal: {
                    ondismiss: function () {
                        placeOrderBtn.disabled = false;
                        placeOrderBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Place Order';
                    }
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        })
        .catch(function (err) {
            console.error(err);
            alert('Payment could not be started. Please try again.');
            placeOrderBtn.disabled = false;
            placeOrderBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Place Order';
        });
    });
})();
</script>
@endsection 