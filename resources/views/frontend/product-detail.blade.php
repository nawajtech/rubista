@extends('frontend.layouts.app')

@section('title', $product->name . ' - Rubista')

@section('extra-css')
<style>
    .product-detail-section {
        padding: 50px 0;
    }
    
    .product-gallery {
        position: sticky;
        top: 20px;
    }
    
    .main-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .thumbnail-gallery {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    
    .thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    .thumbnail:hover,
    .thumbnail.active {
        border-color: #667eea;
    }
    
    .product-info {
        padding-left: 30px;
    }
    
    .product-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }
    
    .product-rating {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .stars {
        color: #ffc107;
        font-size: 1.2rem;
    }
    
    .rating-text {
        color: #666;
        font-size: 1rem;
    }
    
    .product-price {
        margin-bottom: 30px;
    }
    
    .current-price {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
    }
    
    .original-price {
        font-size: 1.5rem;
        color: #999;
        text-decoration: line-through;
        margin-left: 15px;
    }
    
    .discount-badge {
        background: #e74c3c;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-left: 15px;
    }
    
    .product-actions {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .quantity-controls {
        display: flex;
        align-items: center;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .quantity-btn {
        width: 45px;
        height: 45px;
        border: none;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .quantity-btn:hover {
        background: #667eea;
        color: white;
    }
    
    .quantity-input {
        width: 60px;
        height: 45px;
        border: none;
        text-align: center;
        font-weight: 600;
        background: white;
    }
    
    .btn-add-to-cart {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 15px 30px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        flex: 1;
    }
    
    .btn-add-to-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }
    
    .btn-add-to-wishlist {
        background: white;
        border: 2px solid #667eea;
        color: #667eea;
        padding: 15px 20px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-add-to-wishlist:hover {
        background: #667eea;
        color: white;
    }
    
    .btn-buy-now {
        background: #28a745;
        border: none;
        color: white;
        padding: 15px 30px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        flex: 1;
    }
    
    .btn-buy-now:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
    }
    
    .product-features {
        margin-bottom: 30px;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .feature-icon {
        width: 50px;
        height: 50px;
        background: #667eea;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }
    
    .product-tabs {
        margin-top: 50px;
    }
    
    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
    }
    
    .nav-tabs .nav-link {
        border: none;
        color: #666;
        font-weight: 600;
        padding: 15px 25px;
        background: none;
    }
    
    .nav-tabs .nav-link.active {
        color: #667eea;
        border-bottom: 3px solid #667eea;
        background: none;
    }
    
    .tab-content {
        padding: 30px 0;
    }
    
    .specification-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .specification-table th,
    .specification-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }
    
    .specification-table th {
        background: #f8f9fa;
        font-weight: 600;
        width: 30%;
    }
    
    .review-item {
        padding: 20px;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .reviewer-name {
        font-weight: 600;
        color: #333;
    }
    
    .review-date {
        color: #666;
        font-size: 0.9rem;
    }
    
    .stock-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    .stock-available {
        background: #d4edda;
        color: #155724;
    }
    
    .stock-limited {
        background: #fff3cd;
        color: #856404;
    }
    
    .stock-out {
        background: #f8d7da;
        color: #721c24;
    }
    
    .delivery-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .delivery-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    
    .delivery-icon {
        color: #28a745;
        font-size: 1.1rem;
    }
    
    @media (max-width: 768px) {
        .product-info {
            padding-left: 0;
            margin-top: 30px;
        }
        
        .product-title {
            font-size: 2rem;
        }
        
        .current-price {
            font-size: 2rem;
        }
        
        .product-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<section class="product-detail-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product-gallery">
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=600&h=500&fit=crop' }}" 
                         alt="{{ $product->name }}" class="main-image" id="mainImage">
                    
                    <div class="thumbnail-gallery">
                        <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=100&h=100&fit=crop' }}" 
                             alt="{{ $product->name }}" class="thumbnail active" onclick="changeImage(this)">
                        <img src="https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=100&h=100&fit=crop" 
                             alt="{{ $product->name }}" class="thumbnail" onclick="changeImage(this)">
                        <img src="https://images.unsplash.com/photo-1609592424019-1080b4ac2418?w=100&h=100&fit=crop" 
                             alt="{{ $product->name }}" class="thumbnail" onclick="changeImage(this)">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&h=100&fit=crop" 
                             alt="{{ $product->name }}" class="thumbnail" onclick="changeImage(this)">
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="product-info">
                    <h1 class="product-title">{{ $product->name }}</h1>
                    
                    <div class="product-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <span class="rating-text">(4.2/5) | 245 Reviews</span>
                    </div>
                    
                    <div class="product-price">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="current-price">₹{{ number_format($product->sale_price) }}</span>
                            <span class="original-price">₹{{ number_format($product->price) }}</span>
                            <span class="discount-badge">
                                {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                            </span>
                        @else
                            <span class="current-price">₹{{ number_format($product->price) }}</span>
                        @endif
                    </div>
                    
                    <div class="stock-status stock-available">
                        <i class="fas fa-check-circle"></i>
                        <span>In Stock - Ready to Ship</span>
                    </div>
                    
                    <div class="delivery-info">
                        <h6 class="fw-bold mb-3">Delivery Information</h6>
                        <div class="delivery-item">
                            <i class="fas fa-shipping-fast delivery-icon"></i>
                            <span>Free delivery on orders above ₹1000</span>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-clock delivery-icon"></i>
                            <span>Delivery in 3-5 business days</span>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-undo delivery-icon"></i>
                            <span>30-day return policy</span>
                        </div>
                    </div>
                    
                    <div class="quantity-selector">
                        <label class="fw-bold">Quantity:</label>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="changeQuantity(-1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="quantity-input" id="quantity" value="1" min="1" max="10">
                            <button class="quantity-btn" onclick="changeQuantity(1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="product-actions">
                        <button class="btn-add-to-cart" onclick="addToCart({{ $product->id }})">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                        <button class="btn-add-to-wishlist" onclick="addToWishlist({{ $product->id }})">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                    
                    <div class="product-actions">
                        <button class="btn-buy-now" onclick="buyNow({{ $product->id }})">
                            <i class="fas fa-bolt me-2"></i>Buy Now
                        </button>
                    </div>
                    
                    <div class="product-features">
                        <h6 class="fw-bold mb-3">Key Features</h6>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">1 Year Warranty</h6>
                                <small class="text-muted">Comprehensive manufacturer warranty</small>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Premium Quality</h6>
                                <small class="text-muted">Tested and certified products</small>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">24/7 Support</h6>
                                <small class="text-muted">Expert technical support</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Tabs -->
        <div class="product-tabs">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                        Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                        Specifications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                        Reviews (245)
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-8">
                            <h4 class="fw-bold mb-4">Product Description</h4>
                            <p>{{ $product->description ?? 'Experience cutting-edge technology with this premium electronic device. Designed for performance, reliability, and style, this product combines the latest innovations with user-friendly features.' }}</p>
                            
                            <h5 class="fw-bold mt-4 mb-3">What\'s in the Box</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>{{ $product->name }}</li>
                                <li><i class="fas fa-check text-success me-2"></i>User Manual</li>
                                <li><i class="fas fa-check text-success me-2"></i>Warranty Card</li>
                                <li><i class="fas fa-check text-success me-2"></i>Charging Cable</li>
                                <li><i class="fas fa-check text-success me-2"></i>Original Packaging</li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=300&fit=crop" 
                                 alt="Product Features" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <h4 class="fw-bold mb-4">Technical Specifications</h4>
                    <table class="specification-table">
                        <tr>
                            <th>Brand</th>
                            <td>{{ $product->brand ?? 'Premium Electronics' }}</td>
                        </tr>
                        <tr>
                            <th>Model</th>
                            <td>{{ $product->model ?? 'PE-' . $product->id }}</td>
                        </tr>
                        <tr>
                            <th>Color</th>
                            <td>Black, Silver, Gold</td>
                        </tr>
                        <tr>
                            <th>Dimensions</th>
                            <td>150 x 75 x 8 mm</td>
                        </tr>
                        <tr>
                            <th>Weight</th>
                            <td>200g</td>
                        </tr>
                        <tr>
                            <th>Power</th>
                            <td>Rechargeable Li-ion Battery</td>
                        </tr>
                        <tr>
                            <th>Connectivity</th>
                            <td>Bluetooth 5.0, Wi-Fi, USB-C</td>
                        </tr>
                        <tr>
                            <th>Compatibility</th>
                            <td>Android, iOS, Windows</td>
                        </tr>
                    </table>
                </div>
                
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <h4 class="fw-bold mb-4">Customer Reviews</h4>
                    
                    <div class="review-item">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Rajesh Kumar</div>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="review-date">2 days ago</div>
                        </div>
                        <p>Excellent product! Great quality and fast delivery. Highly recommended for anyone looking for reliable electronics.</p>
                    </div>
                    
                    <div class="review-item">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Priya Sharma</div>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <div class="review-date">1 week ago</div>
                        </div>
                        <p>Good value for money. The product works as described and the customer service is very helpful.</p>
                    </div>
                    
                    <div class="review-item">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">Amit Patel</div>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="review-date">2 weeks ago</div>
                        </div>
                        <p>Perfect purchase! The product arrived quickly and was exactly as described. Will definitely buy again.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function changeImage(thumbnail) {
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    // Remove active class from all thumbnails
    thumbnails.forEach(thumb => thumb.classList.remove('active'));
    
    // Add active class to clicked thumbnail
    thumbnail.classList.add('active');
    
    // Change main image
    mainImage.src = thumbnail.src.replace('w=100&h=100', 'w=600&h=500');
}

function changeQuantity(delta) {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const newValue = currentValue + delta;
    
    if (newValue >= 1 && newValue <= 10) {
        quantityInput.value = newValue;
    }
}

function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: parseInt(quantity)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            alert('Product added to cart successfully!');
            
            // Update cart count in navbar if exists
            const cartBadge = document.querySelector('.navbar .badge');
            if (cartBadge) {
                cartBadge.textContent = data.cart_count;
            }
        } else {
            alert('Error adding product to cart: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding product to cart');
    });
}

function addToWishlist(productId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/wishlist/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product added to wishlist successfully!');
            
            // Change button style to indicate added to wishlist
            const wishlistBtn = document.querySelector('.btn-add-to-wishlist');
            wishlistBtn.style.background = '#dc3545';
            wishlistBtn.style.borderColor = '#dc3545';
            wishlistBtn.style.color = 'white';
            wishlistBtn.innerHTML = '<i class="fas fa-heart"></i>';
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding product to wishlist');
    });
}

function buyNow(productId) {
    const quantity = document.getElementById('quantity').value;
    
    // Add to cart first
    addToCart(productId);
    
    // Then redirect to cart after a short delay
    setTimeout(() => {
        window.location.href = '{{ route("frontend.cart") }}';
    }, 1000);
}
</script>
@endsection 