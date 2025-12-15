@extends('frontend.layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

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
        height: 450px;
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
        cursor: pointer;
        position: relative;
        z-index: 1;
    }
    
    .btn-add-to-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }
    
    .btn-add-to-cart:active {
        transform: translateY(0);
    }
    
    .btn-add-to-wishlist {
        background: white;
        border: 2px solid #667eea;
        color: #667eea;
        padding: 15px 20px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        z-index: 1;
    }
    
    .btn-add-to-wishlist:hover {
        background: #667eea;
        color: white;
    }
    
    .btn-add-to-wishlist:active {
        transform: scale(0.95);
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
        cursor: pointer;
        position: relative;
        z-index: 1;
    }
    
    .btn-buy-now:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
    }
    
    .btn-buy-now:active {
        transform: translateY(0);
    }
    
    .btn-add-to-cart:disabled,
    .btn-buy-now:disabled,
    .quantity-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .quantity-input:disabled {
        opacity: 0.6;
        cursor: not-allowed;
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
    
    .related-products-section {
        background: #f8f9fa;
        padding: 50px 0;
        margin-top: 60px;
    }
    
    .product-card {
        transition: all 0.3s ease;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    
    /* Auto Scroll Section Styles */
    .auto-scroll-container {
        position: relative;
        overflow: hidden;
        width: 100%;
        padding: 20px 0;
    }
    
    .auto-scroll-wrapper {
        display: flex;
        gap: 20px;
        will-change: transform;
    }
    
    .auto-scroll-wrapper:hover {
        animation-play-state: paused !important;
    }
    
    .auto-scroll-item {
        flex: 0 0 auto;
        width: 280px;
    }
    
    @keyframes autoScroll {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }
    
    /* Apply animation only if wrapper exists */
    .auto-scroll-wrapper {
        animation: autoScroll 40s linear infinite;
    }
    
    .auto-scroll-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0;
        margin-top: 60px;
        position: relative;
        overflow: hidden;
    }
    
    .auto-scroll-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, transparent 50%, rgba(255,255,255,0.1) 100%);
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    .auto-scroll-content {
        position: relative;
        z-index: 1;
    }
    
    .auto-scroll-title {
        color: white;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .auto-scroll-title h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    
    .auto-scroll-title p {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
    .auto-scroll-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .auto-scroll-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }
    
    /* Reviews Section Styles */
    .reviews-section {
        padding: 20px 0;
    }
    
    .rating-input .stars-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    
    .rating-input .star-rating {
        transition: all 0.2s ease;
    }
    
    .rating-input .star-rating:hover,
    .rating-input .star-rating.active {
        transform: scale(1.1);
    }
    
    .rating-input .star-rating.active ~ .star-rating {
        color: #ffc107 !important;
    }
    
    .review-item {
        transition: all 0.3s ease;
    }
    
    .review-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .review-form-card {
        transition: all 0.3s ease;
    }
    
    .review-form-card:hover {
        border-color: #667eea !important;
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
        
        .related-products-section {
            padding: 30px 0;
        }
        
        .auto-scroll-section {
            padding: 40px 0;
        }
        
        .auto-scroll-title h2 {
            font-size: 1.8rem;
        }
        
        .auto-scroll-item {
            width: 240px;
        }
        
        .auto-scroll-card .card-body {
            padding: 15px !important;
        }
    }
    
    @media (max-width: 576px) {
        .auto-scroll-item {
            width: 200px;
        }
        
        .auto-scroll-title h2 {
            font-size: 1.5rem;
        }
        
        .auto-scroll-title p {
            font-size: 0.9rem;
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
                    @if($product->image)
                        @if(Str::startsWith($product->image, 'http'))
                            <img src="{{ $product->image }}" 
                                 alt="{{ $product->name }}" class="main-image" id="mainImage">
                        @else
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" class="main-image" id="mainImage">
                        @endif
                    @else
                        <div class="main-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem;">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                    
                    <div class="thumbnail-gallery">
                        @if($product->image)
                            @if(Str::startsWith($product->image, 'http'))
                                <img src="{{ $product->image }}" 
                                     alt="{{ $product->name }}" class="thumbnail active" onclick="changeImage(this)">
                            @else
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" class="thumbnail active" onclick="changeImage(this)">
                            @endif
                        @else
                            <div class="thumbnail active" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        
                        @if($product->gallery && is_array($product->gallery) && count($product->gallery) > 0)
                            @foreach($product->gallery as $galleryImage)
                                @if(Str::startsWith($galleryImage, 'http'))
                                    <img src="{{ $galleryImage }}" 
                                         alt="{{ $product->name }}" class="thumbnail" onclick="changeImage(this)">
                                @else
                                    <img src="{{ asset('storage/' . $galleryImage) }}" 
                                         alt="{{ $product->name }}" class="thumbnail" onclick="changeImage(this)">
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="product-info">
                    <h1 class="product-title">{{ $product->name }}</h1>
                    
                    @if($product->short_description)
                    <p class="text-muted mb-3">{{ $product->short_description }}</p>
                    @endif
                    
                    <div class="product-price">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="current-price">₹{{ number_format($product->sale_price, 2) }}</span>
                            <span class="original-price">₹{{ number_format($product->price, 2) }}</span>
                            <span class="discount-badge">
                                {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                            </span>
                        @else
                            <span class="current-price">₹{{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                    
                    @php
                        $stockQuantity = $product->stock_quantity ?? 0;
                        if ($stockQuantity > 10) {
                            $stockClass = 'stock-available';
                            $stockIcon = 'fa-check-circle';
                            $stockText = 'In Stock - Ready to Ship';
                        } elseif ($stockQuantity > 0) {
                            $stockClass = 'stock-limited';
                            $stockIcon = 'fa-exclamation-triangle';
                            $stockText = 'Limited Stock - Only ' . $stockQuantity . ' left';
                        } else {
                            $stockClass = 'stock-out';
                            $stockIcon = 'fa-times-circle';
                            $stockText = 'Out of Stock';
                        }
                    @endphp
                    <div class="stock-status {{ $stockClass }}">
                        <i class="fas {{ $stockIcon }}"></i>
                        <span>{{ $stockText }}</span>
                    </div>
                    
                    <div class="delivery-info">
                        <h6 class="fw-bold mb-3">Product Information</h6>
                        @if($product->warranty_period)
                        <div class="delivery-item">
                            <i class="fas fa-shield-alt delivery-icon"></i>
                            <span>Warranty: {{ $product->warranty_period }}</span>
                        </div>
                        @endif
                        @if($product->return_policy)
                        <div class="delivery-item">
                            <i class="fas fa-undo delivery-icon"></i>
                            <span>Return Policy: {{ Str::limit($product->return_policy, 50) }}</span>
                        </div>
                        @endif
                        @if($product->brand)
                        <div class="delivery-item">
                            <i class="fas fa-tag delivery-icon"></i>
                            <span>Brand: {{ $product->brand }}</span>
                        </div>
                        @endif
                        @if($product->model)
                        <div class="delivery-item">
                            <i class="fas fa-cube delivery-icon"></i>
                            <span>Model: {{ $product->model }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="quantity-selector">
                        <label class="fw-bold">Quantity:</label>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="changeQuantity(-1)" {{ $stockQuantity == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="quantity-input" id="quantity" value="1" min="1" max="{{ $stockQuantity > 0 ? $stockQuantity : 1 }}" {{ $stockQuantity == 0 ? 'disabled' : '' }}>
                            <button class="quantity-btn" onclick="changeQuantity(1)" {{ $stockQuantity == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="product-actions">
                        <button type="button" class="btn-add-to-cart" onclick="window.addToCart({{ $product->id }})" style="cursor: pointer;" {{ $stockQuantity == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-cart me-2"></i>{{ $stockQuantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
                        </button>
                        <button type="button" class="btn-add-to-wishlist" id="wishlist-btn-{{ $product->id }}" onclick="window.addToWishlist({{ $product->id }})" style="cursor: pointer; @if(isset($isInWishlist) && $isInWishlist) background: #dc3545; border-color: #dc3545; color: white; @endif">
                            <i class="{{ (isset($isInWishlist) && $isInWishlist) ? 'fas' : 'far' }} fa-heart"></i>
                        </button>
                    </div>
                    
                    @if($stockQuantity > 0)
                    <div class="product-actions">
                        <button type="button" class="btn-buy-now" onclick="window.buyNow({{ $product->id }})" style="cursor: pointer;">
                            <i class="fas fa-bolt me-2"></i>Buy Now
                        </button>
                    </div>
                    @endif
                    
                    @if($product->warranty_period || $product->brand || $product->model)
                    <div class="product-features">
                        <h6 class="fw-bold mb-3">Product Details</h6>
                        @if($product->warranty_period)
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Warranty</h6>
                                <small class="text-muted">{{ $product->warranty_period }}</small>
                            </div>
                        </div>
                        @endif
                        @if($product->brand)
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Brand</h6>
                                <small class="text-muted">{{ $product->brand }}</small>
                            </div>
                        </div>
                        @endif
                        @if($product->model)
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-cube"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Model</h6>
                                <small class="text-muted">{{ $product->model }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
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
                @if($product->return_policy)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="return-policy-tab" data-bs-toggle="tab" data-bs-target="#return-policy" type="button" role="tab">
                        Return Policy
                    </button>
                </li>
                @endif
            </ul>
            
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-8">
                            <h4 class="fw-bold mb-4">Product Description</h4>
                            @if($product->description)
                                <div class="product-description">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            @else
                                <p class="text-muted">No detailed description available for this product.</p>
                            @endif
                            
                            @if($product->short_description)
                            <div class="mt-4">
                                <h5 class="fw-bold mb-3">Overview</h5>
                                <p>{{ $product->short_description }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            @if($product->image)
                                @if(Str::startsWith($product->image, 'http'))
                                    <img src="{{ $product->image }}" 
                                         alt="Product Features" class="img-fluid rounded" style="height: 300px; width: 100%; object-fit: cover;">
                                @else
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="Product Features" class="img-fluid rounded" style="height: 300px; width: 100%; object-fit: cover;">
                                @endif
                            @else
                                <div class="img-fluid rounded" style="height: 300px; width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <h4 class="fw-bold mb-4">Product Specifications</h4>
                    <table class="specification-table">
                        @if($product->brand)
                        <tr>
                            <th>Brand</th>
                            <td>{{ $product->brand }}</td>
                        </tr>
                        @endif
                        @if($product->model)
                        <tr>
                            <th>Model</th>
                            <td>{{ $product->model }}</td>
                        </tr>
                        @endif
                        @if($product->color)
                        <tr>
                            <th>Color</th>
                            <td>{{ $product->color }}</td>
                        </tr>
                        @endif
                        @if($product->dimension)
                        <tr>
                            <th>Dimensions</th>
                            <td>{{ $product->dimension }}</td>
                        </tr>
                        @endif
                        @if($product->warranty_period)
                        <tr>
                            <th>Warranty Period</th>
                            <td>{{ $product->warranty_period }}</td>
                        </tr>
                        @endif
                        @if($product->sku)
                        <tr>
                            <th>SKU</th>
                            <td>{{ $product->sku }}</td>
                        </tr>
                        @endif
                        @if($product->category)
                        <tr>
                            <th>Category</th>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Stock Quantity</th>
                            <td>{{ $product->stock_quantity ?? 0 }} units available</td>
                        </tr>
                    </table>
                </div>
                
                @if($product->return_policy)
                <div class="tab-pane fade" id="return-policy" role="tabpanel">
                    <h4 class="fw-bold mb-4">Return Policy</h4>
                    <div class="return-policy-content">
                        {!! nl2br(e($product->return_policy)) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Ratings & Reviews Section - Always Visible -->
        <div class="ratings-reviews-section" style="margin-top: 50px; padding-top: 40px; border-top: 2px solid #e9ecef;">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="fw-bold mb-0" style="color: #333; font-size: 2rem;">
                                <i class="fas fa-star me-2" style="color: #ffc107;"></i>Ratings & Reviews
                            </h2>
                            @auth
                                @if(!isset($userReview) || !$userReview)
                                <button type="button" class="btn btn-primary" id="rate-product-btn" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; padding: 10px 20px; font-weight: 600;">
                                    <i class="fas fa-edit me-2"></i>Rate Product
                                </button>
                                @endif
                            @else
                                <a href="{{ route('frontend.login') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; padding: 10px 20px; font-weight: 600;">
                                    <i class="fas fa-edit me-2"></i>Rate Product
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="reviews-section">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="rating-summary-card p-4" style="background: #f8f9fa; border-radius: 15px; text-align: center;">
                                    <h3 class="mb-3" style="font-size: 3rem; font-weight: 700; color: #667eea;">
                                        <span id="average-rating-display">{{ number_format($averageRating ?? 0, 1) }}</span>
                                    </h3>
                                    <div class="rating-stars-display mb-3" id="average-rating-stars">
                                        @php
                                            $avgRating = $averageRating ?? 0;
                                            $fullStars = floor($avgRating);
                                            $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $fullStars)
                                                <i class="fas fa-star" style="color: #ffc107; font-size: 1.5rem;"></i>
                                            @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                <i class="fas fa-star-half-alt" style="color: #ffc107; font-size: 1.5rem;"></i>
                                            @else
                                                <i class="far fa-star" style="color: #ffc107; font-size: 1.5rem;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-muted mb-0">
                                        Based on <strong id="total-reviews-display">{{ $totalReviews ?? 0 }}</strong> review(s)
                                    </p>
                                </div>
                                
                                @auth
                                    @if(!isset($userReview) || !$userReview)
                                    <div class="review-form-card mt-4 p-4" id="review-form-container" style="background: white; border: 2px solid #e9ecef; border-radius: 15px; display: none;">
                                        <h5 class="mb-3 fw-bold">Write a Review</h5>
                                        <form id="review-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Your Rating</label>
                                                <div class="rating-input">
                                                    <input type="hidden" name="rating" id="rating-value" value="5" required>
                                                    <div class="stars-input">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <i class="fas fa-star star-rating" data-rating="{{ $i }}" style="font-size: 2rem; color: #ffc107; cursor: pointer; margin-right: 5px;"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="rating-text ms-2" id="rating-text">5 - Excellent</span>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="review-comment" class="form-label fw-bold">Your Review</label>
                                                <textarea class="form-control" id="review-comment" name="comment" rows="4" placeholder="Share your experience with this product..." maxlength="1000"></textarea>
                                                <small class="text-muted"><span id="char-count">0</span>/1000 characters</small>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; padding: 12px; font-weight: 600;">
                                                <i class="fas fa-paper-plane me-2"></i>Submit Review
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                    <div class="alert alert-info mt-4">
                                        <i class="fas fa-info-circle me-2"></i>You have already reviewed this product.
                                    </div>
                                    @endif
                                @else
                                    <div class="review-login-prompt mt-4 p-4" style="background: white; border: 2px dashed #667eea; border-radius: 15px; text-align: center;">
                                        <i class="fas fa-lock fa-2x mb-3" style="color: #667eea;"></i>
                                        <h6 class="fw-bold mb-2">Login to Write a Review</h6>
                                        <p class="text-muted small mb-3">Please login to share your experience with this product.</p>
                                        <a href="{{ route('frontend.login') }}" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login Now
                                        </a>
                                    </div>
                                @endauth
                            </div>
                            
                            <div class="col-lg-8">
                                <div class="reviews-list">
                                    <h5 class="fw-bold mb-4">Customer Reviews</h5>
                                    <div id="reviews-container">
                                        @if(isset($reviews) && $reviews->count() > 0)
                                            @foreach($reviews as $review)
                                            <div class="review-item mb-4 p-4" style="background: white; border: 1px solid #e9ecef; border-radius: 10px;">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div>
                                                        <h6 class="fw-bold mb-1">{{ $review->user->name }}</h6>
                                                        <div class="review-rating mb-2">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $review->rating)
                                                                    <i class="fas fa-star" style="color: #ffc107; font-size: 0.9rem;"></i>
                                                                @else
                                                                    <i class="far fa-star" style="color: #ffc107; font-size: 0.9rem;"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                                </div>
                                                @if($review->comment)
                                                <p class="mb-0" style="color: #555;">{{ $review->comment }}</p>
                                                @endif
                                                @auth
                                                    @if(auth()->user()->isAdmin() && !$review->status)
                                                    <div class="mt-2">
                                                        <span class="badge bg-warning">Pending Approval</span>
                                                    </div>
                                                    @endif
                                                @endauth
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="text-center py-5">
                                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products Section -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <!-- Auto Scroll Products Section -->
        <div class="auto-scroll-section">
            <div class="auto-scroll-content">
                <div class="container">
                    <div class="auto-scroll-title">
                        <h2><i class="fas fa-fire me-2"></i>You May Also Like</h2>
                        <p>Discover more products from the same category</p>
                    </div>
                </div>
                <div class="auto-scroll-container">
                    <div class="auto-scroll-wrapper" id="autoScrollWrapper">
                        @foreach($relatedProducts as $relatedProduct)
                        <div class="auto-scroll-item">
                            <div class="auto-scroll-card">
                                <a href="{{ route('frontend.product.detail', $relatedProduct->id) }}" style="text-decoration: none; color: inherit;">
                                    <div class="position-relative">
                                        @if($relatedProduct->image)
                                            @if(Str::startsWith($relatedProduct->image, 'http'))
                                                <img src="{{ $relatedProduct->image }}" 
                                                     alt="{{ $relatedProduct->name }}" style="height: 280px; object-fit: cover; width: 100%;">
                                            @else
                                                <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                                     alt="{{ $relatedProduct->name }}" style="height: 280px; object-fit: cover; width: 100%;">
                                            @endif
                                        @else
                                            <div style="height: 280px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->price)
                                            <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="font-size: 0.8rem; padding: 6px 12px; font-weight: 600;">SALE</span>
                                        @endif
                                        @if($relatedProduct->featured)
                                            <span class="badge bg-warning position-absolute top-0 end-0 m-2" style="font-size: 0.8rem; padding: 6px 12px; font-weight: 600;">FEATURED</span>
                                        @endif
                                    </div>
                                    <div class="card-body p-4">
                                        <h6 class="card-title mb-2" style="font-weight: 700; color: #333; font-size: 1.1rem; min-height: 50px;">{{ Str::limit($relatedProduct->name, 50) }}</h6>
                                        @if($relatedProduct->short_description)
                                        <p class="card-text text-muted mb-3" style="font-size: 0.9rem; min-height: 40px;">{{ Str::limit($relatedProduct->short_description, 70) }}</p>
                                        @endif
                                        <div class="mb-3">
                                            @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->price)
                                                <span class="text-muted text-decoration-line-through" style="font-size: 0.9rem;">₹{{ number_format($relatedProduct->price, 2) }}</span>
                                                <span class="fw-bold ms-2" style="color: #e74c3c; font-size: 1.3rem;">₹{{ number_format($relatedProduct->sale_price, 2) }}</span>
                                            @else
                                                <span class="fw-bold" style="color: #333; font-size: 1.3rem;">₹{{ number_format($relatedProduct->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary w-100" onclick="event.preventDefault(); window.location.href='{{ route('frontend.product.detail', $relatedProduct->id) }}'" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; border-radius: 8px; padding: 12px; font-weight: 600;">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </button>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        <!-- Duplicate items for seamless loop -->
                        @foreach($relatedProducts as $relatedProduct)
                        <div class="auto-scroll-item">
                            <div class="auto-scroll-card">
                                <a href="{{ route('frontend.product.detail', $relatedProduct->id) }}" style="text-decoration: none; color: inherit;">
                                    <div class="position-relative">
                                        @if($relatedProduct->image)
                                            @if(Str::startsWith($relatedProduct->image, 'http'))
                                                <img src="{{ $relatedProduct->image }}" 
                                                     alt="{{ $relatedProduct->name }}" style="height: 280px; object-fit: cover; width: 100%;">
                                            @else
                                                <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                                     alt="{{ $relatedProduct->name }}" style="height: 280px; object-fit: cover; width: 100%;">
                                            @endif
                                        @else
                                            <div style="height: 280px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->price)
                                            <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="font-size: 0.8rem; padding: 6px 12px; font-weight: 600;">SALE</span>
                                        @endif
                                        @if($relatedProduct->featured)
                                            <span class="badge bg-warning position-absolute top-0 end-0 m-2" style="font-size: 0.8rem; padding: 6px 12px; font-weight: 600;">FEATURED</span>
                                        @endif
                                    </div>
                                    <div class="card-body p-4">
                                        <h6 class="card-title mb-2" style="font-weight: 700; color: #333; font-size: 1.1rem; min-height: 50px;">{{ Str::limit($relatedProduct->name, 50) }}</h6>
                                        @if($relatedProduct->short_description)
                                        <p class="card-text text-muted mb-3" style="font-size: 0.9rem; min-height: 40px;">{{ Str::limit($relatedProduct->short_description, 70) }}</p>
                                        @endif
                                        <div class="mb-3">
                                            @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->price)
                                                <span class="text-muted text-decoration-line-through" style="font-size: 0.9rem;">₹{{ number_format($relatedProduct->price, 2) }}</span>
                                                <span class="fw-bold ms-2" style="color: #e74c3c; font-size: 1.3rem;">₹{{ number_format($relatedProduct->sale_price, 2) }}</span>
                                            @else
                                                <span class="fw-bold" style="color: #333; font-size: 1.3rem;">₹{{ number_format($relatedProduct->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary w-100" onclick="event.preventDefault(); window.location.href='{{ route('frontend.product.detail', $relatedProduct->id) }}'" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; border-radius: 8px; padding: 12px; font-weight: 600;">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </button>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
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
    
    // Change main image - use the thumbnail src directly
    if (thumbnail.tagName === 'IMG') {
        mainImage.src = thumbnail.src;
    }
}

function changeQuantity(delta) {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.getAttribute('max'));
    const newValue = currentValue + delta;
    
    if (newValue >= 1 && newValue <= maxValue) {
        quantityInput.value = newValue;
    }
}

window.addToCart = function(productId) {
    console.log('addToCart called with productId:', productId);
    
    const quantityInput = document.getElementById('quantity');
    if (!quantityInput) {
        console.error('Quantity input not found');
        showToast('Error: Quantity input not found', 'error');
        return;
    }
    
    const quantity = quantityInput.value || 1;
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (!csrfToken) {
        console.error('CSRF token not found');
        showToast('Error: CSRF token not found', 'error');
        return;
    }
    
    const addToCartBtn = document.querySelector('.btn-add-to-cart');
    if (!addToCartBtn) {
        console.error('Add to cart button not found');
        showToast('Error: Add to cart button not found', 'error');
        return;
    }
    
    // Add loading state
    const originalText = addToCartBtn.innerHTML;
    addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
    addToCartBtn.disabled = true;
    
    const requestData = {
        product_id: parseInt(productId),
        quantity: parseInt(quantity)
    };
    
    console.log('Sending request:', requestData);
    
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.json().then(err => {
                console.error('Response error:', err);
                throw new Error(err.message || 'Request failed');
            }).catch(() => {
                throw new Error('Request failed with status: ' + response.status);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Show success message
            showToast('Product added to cart successfully!', 'success');
            
            // Update cart count in navbar
            if (typeof updateCartCount === 'function') {
                updateCartCount(data.cart_count);
            }
            
            // Reset button
            addToCartBtn.innerHTML = originalText;
            addToCartBtn.disabled = false;
        } else {
            showToast('Error: ' + (data.message || 'Failed to add product to cart'), 'error');
            addToCartBtn.innerHTML = originalText;
            addToCartBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(error.message || 'Error adding product to cart', 'error');
        addToCartBtn.innerHTML = originalText;
        addToCartBtn.disabled = false;
    });
}

window.addToWishlist = function(productId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const wishlistBtn = document.getElementById('wishlist-btn-' + productId) || document.querySelector('.btn-add-to-wishlist');
    
    // Use toggle endpoint - server will check if product is in wishlist
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            product_id: parseInt(productId)
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Request failed');
            }).catch(() => {
                throw new Error('Request failed with status: ' + response.status);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update button based on server response
            if (data.in_wishlist) {
                wishlistBtn.style.background = '#dc3545';
                wishlistBtn.style.borderColor = '#dc3545';
                wishlistBtn.style.color = 'white';
                const icon = wishlistBtn.querySelector('i');
                if (icon) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                } else {
                    wishlistBtn.innerHTML = '<i class="fas fa-heart"></i>';
                }
            } else {
                wishlistBtn.style.background = 'white';
                wishlistBtn.style.borderColor = '#667eea';
                wishlistBtn.style.color = '#667eea';
                const icon = wishlistBtn.querySelector('i');
                if (icon) {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                } else {
                    wishlistBtn.innerHTML = '<i class="far fa-heart"></i>';
                }
            }
            updateWishlistCount(data.wishlist_count);
            showToast(data.message, 'success');
        } else {
            showToast(data.message || 'Error updating wishlist', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(error.message || 'Error updating wishlist', 'error');
    });
}

window.buyNow = function(productId) {
    const quantity = document.getElementById('quantity').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const buyNowBtn = document.querySelector('.btn-buy-now');
    
    // Add loading state
    const originalText = buyNowBtn.innerHTML;
    buyNowBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    buyNowBtn.disabled = true;
    
    // Add to cart first
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            product_id: parseInt(productId),
            quantity: parseInt(quantity)
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Request failed');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update cart count
            updateCartCount(data.cart_count);
            
            // Redirect to checkout
            window.location.href = '{{ route("frontend.checkout") }}';
        } else {
            showToast('Error: ' + (data.message || 'Failed to add product to cart'), 'error');
            buyNowBtn.innerHTML = originalText;
            buyNowBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(error.message || 'Error adding product to cart', 'error');
        buyNowBtn.innerHTML = originalText;
        buyNowBtn.disabled = false;
    });
}

// Helper function to show toast notifications
window.showToast = function(message, type = 'success') {
    const toast = document.createElement('div');
    const bgColor = type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#667eea';
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
window.updateCartCount = function(count) {
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

// Helper function to update wishlist count in navbar
window.updateWishlistCount = function(count) {
    const wishlistBadges = document.querySelectorAll('.wishlist-count, .wishlist-badge, [data-wishlist-count], .action-badge.wishlist-count');
    wishlistBadges.forEach(badge => {
        badge.textContent = count;
        if (count > 0) {
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    });
}

// Auto Scroll Section Initialization
document.addEventListener('DOMContentLoaded', function() {
    const autoScrollWrapper = document.getElementById('autoScrollWrapper');
    if (autoScrollWrapper) {
        // Pause on hover (handled by CSS, but adding for extra control)
        autoScrollWrapper.addEventListener('mouseenter', function() {
            this.style.animationPlayState = 'paused';
        });
        
        autoScrollWrapper.addEventListener('mouseleave', function() {
            this.style.animationPlayState = 'running';
        });
    }
    
    // Initialize Review System
    initializeReviewSystem();
    
    // Initialize Wishlist Button State
    initializeWishlistButton();
});

// Initialize Wishlist Button State
function initializeWishlistButton() {
    // The button state is already set by the server-side check
    // No need for additional initialization since we're using server-side rendering
    // The button will maintain its state from the initial page load
}

// Review System Functions
function initializeReviewSystem() {
    // Star Rating Input
    const starRatings = document.querySelectorAll('.star-rating');
    const ratingValue = document.getElementById('rating-value');
    const ratingText = document.getElementById('rating-text');
    const reviewComment = document.getElementById('review-comment');
    const charCount = document.getElementById('char-count');
    
    if (starRatings.length > 0) {
        // Set initial active state
        starRatings.forEach(star => {
            if (parseInt(star.dataset.rating) <= parseInt(ratingValue.value)) {
                star.classList.add('active');
            }
        });
        
        // Handle star clicks
        starRatings.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.dataset.rating);
                ratingValue.value = rating;
                
                // Update visual state
                starRatings.forEach(s => {
                    if (parseInt(s.dataset.rating) <= rating) {
                        s.classList.add('active');
                        s.style.color = '#ffc107';
                    } else {
                        s.classList.remove('active');
                        s.style.color = '#ffc107';
                        s.style.opacity = '0.3';
                    }
                });
                
                // Update rating text
                const ratingTexts = {
                    1: '1 - Poor',
                    2: '2 - Fair',
                    3: '3 - Good',
                    4: '4 - Very Good',
                    5: '5 - Excellent'
                };
                ratingText.textContent = ratingTexts[rating];
            });
            
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.rating);
                starRatings.forEach(s => {
                    if (parseInt(s.dataset.rating) <= rating) {
                        s.style.color = '#ffc107';
                        s.style.opacity = '1';
                    } else {
                        s.style.opacity = '0.3';
                    }
                });
            });
        });
        
        // Reset on mouse leave
        document.querySelector('.stars-input').addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingValue.value);
            starRatings.forEach(s => {
                if (parseInt(s.dataset.rating) <= currentRating) {
                    s.style.color = '#ffc107';
                    s.style.opacity = '1';
                } else {
                    s.style.opacity = '0.3';
                }
            });
        });
    }
    
    // Character counter
    if (reviewComment && charCount) {
        reviewComment.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
    
    // Review form submission
    const reviewForm = document.getElementById('review-form');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitReview();
        });
    }
    
    // Rate Product button click handler
    const rateProductBtn = document.getElementById('rate-product-btn');
    if (rateProductBtn) {
        rateProductBtn.addEventListener('click', function() {
            const reviewFormContainer = document.getElementById('review-form-container');
            if (reviewFormContainer) {
                if (reviewFormContainer.style.display === 'none') {
                    reviewFormContainer.style.display = 'block';
                    reviewFormContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    reviewFormContainer.style.display = 'none';
                }
            }
        });
    }
}

// Submit Review Function
function submitReview() {
    const form = document.getElementById('review-form');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Disable button
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    fetch('{{ route("frontend.reviews.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : '',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            
            // Add new review to the list
            addReviewToDOM(data.review);
            
            // Update rating summary
            updateRatingSummary(data.average_rating, data.total_reviews);
            
            // Reset form
            form.reset();
            document.getElementById('rating-value').value = '5';
            document.getElementById('rating-text').textContent = '5 - Excellent';
            document.getElementById('char-count').textContent = '0';
            
        // Reset stars
        const allStars = document.querySelectorAll('.star-rating');
        allStars.forEach((star, index) => {
            const rating = parseInt(star.dataset.rating);
            if (rating <= 5) {
                star.classList.add('active');
                star.style.color = '#ffc107';
                star.style.opacity = '1';
            } else {
                star.classList.remove('active');
                star.style.opacity = '0.3';
            }
        });
            
            // Hide form if user already reviewed
            const reviewFormContainer = document.getElementById('review-form-container');
            if (reviewFormContainer) {
                reviewFormContainer.style.display = 'none';
                reviewFormContainer.innerHTML = '<div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>You have already reviewed this product.</div>';
            }
            
            // Hide rate product button
            const rateProductBtn = document.getElementById('rate-product-btn');
            if (rateProductBtn) {
                rateProductBtn.style.display = 'none';
            }
        } else {
            if (data.redirect) {
                // User not logged in, redirect to login
                window.location.href = data.redirect;
            } else {
                showToast(data.message || 'Error submitting review', 'error');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error submitting review. Please try again.', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

// Add review to DOM
function addReviewToDOM(review) {
    const reviewsContainer = document.getElementById('reviews-container');
    
    // Remove "no reviews" message if exists
    const noReviewsMsg = reviewsContainer.querySelector('.text-center');
    if (noReviewsMsg) {
        noReviewsMsg.remove();
    }
    
    // Create review HTML
    const reviewHTML = `
        <div class="review-item mb-4 p-4" style="background: white; border: 1px solid #e9ecef; border-radius: 10px; animation: slideInUp 0.5s ease;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h6 class="fw-bold mb-1">${review.user_name}</h6>
                    <div class="review-rating mb-2">
                        ${generateStarRating(review.rating)}
                    </div>
                </div>
                <small class="text-muted">${review.created_at}</small>
            </div>
            ${review.comment ? `<p class="mb-0" style="color: #555;">${escapeHtml(review.comment)}</p>` : ''}
        </div>
    `;
    
    // Insert at the top
    reviewsContainer.insertAdjacentHTML('afterbegin', reviewHTML);
    
    // Update reviews count display
    const totalReviewsDisplay = document.getElementById('total-reviews-display');
    if (totalReviewsDisplay) {
        const reviewsCount = parseInt(totalReviewsDisplay.textContent) + 1;
        totalReviewsDisplay.textContent = reviewsCount;
    }
}

// Generate star rating HTML
function generateStarRating(rating) {
    let starsHTML = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= rating) {
            starsHTML += '<i class="fas fa-star" style="color: #ffc107; font-size: 0.9rem;"></i>';
        } else {
            starsHTML += '<i class="far fa-star" style="color: #ffc107; font-size: 0.9rem;"></i>';
        }
    }
    return starsHTML;
}

// Update rating summary
function updateRatingSummary(averageRating, totalReviews) {
    document.getElementById('average-rating-display').textContent = parseFloat(averageRating).toFixed(1);
    document.getElementById('total-reviews-display').textContent = totalReviews;
    
    // Update star display
    const avgStarsContainer = document.getElementById('average-rating-stars');
    avgStarsContainer.innerHTML = generateStarRating(Math.round(averageRating));
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}
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

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection 