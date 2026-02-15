@extends('frontend.layouts.app')

@section('title', $category->name . ' - Rubista')

@section('extra-css')
<style>
    .category-products-page .product-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .category-products-page .product-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
    .category-products-page .card-img-top { width: 100%; object-fit: cover; }
    .category-products-page .position-relative { aspect-ratio: 1; overflow: hidden; }
    .category-products-page .position-relative .card-img-top.img-fluid { height: 100%; object-fit: cover; }
    .category-products-page .category-products-placeholder {
        aspect-ratio: 1; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        display: flex; align-items: center; justify-content: center; color: #f5a623; font-size: clamp(1.5rem, 5vw, 2rem);
    }
    .category-products-page .product-favourite-btn {
        position: absolute; top: 8px; right: 8px; z-index: 2;
        width: 36px; height: 36px; border-radius: 50%; border: none;
        background: rgba(255,255,255,0.95); color: #f5a623;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .category-products-page .product-favourite-btn:hover {
        background: #f5a623; color: #fff; transform: scale(1.08);
    }
    .category-products-page .product-favourite-btn.active {
        background: #ef4444; color: #fff;
    }
    .category-products-page .cat-add-to-cart-btn {
        width: auto; min-width: 0;
        background: linear-gradient(135deg, #f5a623 0%, #e0941a 100%);
        color: #fff; border: none;
        padding: 5px 8px; border-radius: 6px;
        font-size: 9px; font-weight: 600;
        letter-spacing: 0.02em; text-transform: uppercase;
        cursor: pointer; transition: all 0.2s ease;
        display: inline-flex; align-items: center; justify-content: center; gap: 3px;
    }
    .category-products-page .cat-add-to-cart-btn:hover { background: #1a1a2e; color: #fff; transform: translateY(-1px); }
    .category-products-page .cat-add-to-cart-btn i { font-size: 8px; }
    .category-products-page .card-body { text-align: center; }
    .category-products-page .card-title,
    .category-products-page .card-text { display: block; }
    .category-products-page .card-body .d-flex { justify-content: center; }
    .category-products-page .cat-product-actions {
        display: flex; align-items: center; justify-content: center; margin-top: 6px;
    }
    .category-products-page .category-product-image-link { color: inherit; }
    .category-products-page .category-product-image-link:hover { opacity: 0.95; }
    .category-products-page .card-title-link { color: #1a1a2e; }
    .category-products-page .card-title-link:hover { color: #f5a623; }
    .category-products-page .card-title-link .card-title { margin-bottom: 0; transition: color 0.2s ease; }
    .category-products-page .category-icon {
        width: 48px; height: 48px; border-radius: 12px;
        background: linear-gradient(135deg, #f5a623, #e0941a);
        color: #fff; display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; box-shadow: 0 4px 12px rgba(245,166,35,0.3);
    }
    .category-products-page .card-title { color: #1a1a2e; }
    .category-products-page .current-price, .category-products-page .price-sale { color: #f5a623 !important; }
    .category-products-page .breadcrumb-item a { color: #1a1a2e; }
    .category-products-page .breadcrumb-item a:hover { color: #f5a623; }
    .category-products-page .breadcrumb-item.active { color: #5a5a6e; }
    .category-products-page .category-products-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
    }
    .category-products-page .category-product-item {
        min-width: 0;
    }
    @media (max-width: 1200px) {
        .category-products-page .category-products-grid { grid-template-columns: repeat(4, 1fr); }
    }
    @media (max-width: 992px) {
        .category-products-page .category-products-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; }
    }
    @media (max-width: 576px) {
        .category-products-page .category-products-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    }
    @media (max-width: 576px) {
        .category-products-page .container { padding-left: 12px; padding-right: 12px; }
        .category-products-page .card-body { padding: 10px !important; }
        .category-products-page .card-title { font-size: 0.85rem; }
        .category-products-page .card-text { font-size: 0.75rem; display: none; }
        .category-products-page .cat-add-to-cart-btn { font-size: 8px; padding: 4px 6px; }
    }
</style>
@endsection

@section('content')
<div class="category-products-page">
<div class="container py-3 py-md-4 px-2 px-sm-3">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}#categories">Categories</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <div class="category-icon me-3">
                    <i class="fas fa-laptop"></i>
                </div>
                <div>
                    <h1 class="mb-0">{{ $category->name }}</h1>
                    <p class="text-muted mb-0">{{ $products->total() }} products found</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="category-products-grid">
            @foreach($products as $product)
            <div class="category-product-item">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <button type="button" class="product-favourite-btn" id="cat-products-wishlist-btn-{{ $product->id }}" onclick="event.stopPropagation(); categoryProductsWishlistToggle({{ $product->id }})" title="Add to wishlist" aria-label="Add to wishlist">
                            <i class="far fa-heart"></i>
                        </button>
                        <a href="{{ route('frontend.product.detail', $product->id) }}" class="category-product-image-link d-block text-decoration-none">
                            @if($product->image)
                                @if(Str::startsWith($product->image, 'http'))
                                    <img src="{{ $product->image }}" 
                                         class="card-img-top img-fluid" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="card-img-top img-fluid" alt="{{ $product->name }}">
                                @endif
                            @else
                                <div class="card-img-top category-products-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </a>
                        @if($product->featured)
                            <span class="badge position-absolute top-0 start-0 m-2" style="background: #f5a623; color: #fff;">FEATURED</span>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        <a href="{{ route('frontend.product.detail', $product->id) }}" class="card-title-link text-decoration-none">
                            <h6 class="card-title">{{ Str::limit($product->name, 60) }}</h6>
                        </a>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                        
                        <!-- Rating Display -->
                        @php
                            $avgRating = $product->average_rating ?? 0;
                            $totalReviews = $product->total_reviews ?? 0;
                        @endphp
                        @if($totalReviews > 0)
                        <div class="mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2" style="font-size: 0.85rem; padding: 4px 8px;">
                                    <i class="fas fa-star" style="font-size: 0.75rem;"></i> {{ number_format($avgRating, 1) }}
                                </span>
                                <small class="text-muted">({{ $totalReviews }} {{ $totalReviews == 1 ? 'review' : 'reviews' }})</small>
                            </div>
                        </div>
                        @else
                        <div class="mb-2">
                            <small class="text-muted">No reviews yet</small>
                        </div>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex flex-wrap justify-content-center gap-1 w-100">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="price-original small text-muted text-decoration-line-through">₹{{ number_format($product->price, 2) }}</span>
                                    <span class="price-sale fw-bold">₹{{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="fw-bold current-price">₹{{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="cat-product-actions">
                            <button type="button" class="cat-add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); categoryAddToCart({{ $product->id }})"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h3>No products found</h3>
            <p class="text-muted">No products available in this category at the moment.</p>
            <a href="{{ route('frontend.home') }}" class="btn btn-primary">Back to Home</a>
        </div>
    @endif
</div>
</div>
@endsection

@section('extra-js')
<script>
(function() {
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) return;
    csrfToken = csrfToken.getAttribute('content');
    function showToast(message, type) {
        type = type || 'success';
        var el = document.createElement('div');
        el.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;padding:12px 20px;border-radius:10px;font-weight:600;font-size:14px;box-shadow:0 4px 14px rgba(0,0,0,0.2);';
        el.style.background = type === 'success' ? '#f5a623' : '#ef4444';
        el.style.color = '#fff';
        el.innerHTML = (type === 'success' ? '<i class="fas fa-check me-2"></i>' : '') + message;
        document.body.appendChild(el);
        setTimeout(function() { el.remove(); }, 3000);
    }
    window.categoryAddToCart = function(productId) {
        var btn = document.querySelector('.cat-add-to-cart-btn[data-product-id="' + productId + '"]');
        if (!btn) return;
        var orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;
        fetch('{{ url("/cart/add") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_id: parseInt(productId), quantity: 1 })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) { showToast('Added to cart!', 'success');
                var badge = document.getElementById('header-cart-count');
                if (badge) { badge.textContent = data.cart_count || 0; badge.style.display = data.cart_count > 0 ? 'inline-block' : 'none'; }
            } else { showToast(data.message || 'Could not add to cart', 'error'); }
        })
        .catch(function() { showToast('Error adding to cart', 'error'); })
        .finally(function() { btn.innerHTML = orig; btn.disabled = false; });
    };

    window.categoryProductsWishlistToggle = function(productId) {
        var btn = document.getElementById('cat-products-wishlist-btn-' + productId);
        if (!csrfToken || !btn) return;
        var icon = btn.querySelector('i');
        var wasActive = btn.classList.contains('active');
        if (icon) icon.className = 'fas fa-spinner fa-spin';
        fetch('{{ url("/wishlist/toggle") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_id: parseInt(productId) })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var inWishlist = data.in_wishlist;
            btn.classList.toggle('active', inWishlist);
            var i = btn.querySelector('i');
            if (i) i.className = inWishlist ? 'fas fa-heart' : 'far fa-heart';
            showToast(data.message || (inWishlist ? 'Added to wishlist' : 'Removed from wishlist'), 'success');
            var badge = document.getElementById('header-wishlist-count');
            if (badge) { badge.textContent = data.wishlist_count || 0; badge.style.display = (data.wishlist_count > 0) ? 'inline-block' : 'none'; }
        })
        .catch(function() {
            showToast('Error updating wishlist', 'error');
            var i = btn.querySelector('i');
            if (i) i.className = wasActive ? 'fas fa-heart' : 'far fa-heart';
        });
    };
})();
</script>
@endsection
