@extends('frontend.layouts.app')

@section('title', 'Wishlist - Rubista')

@section('extra-css')
<style>
    .wishlist-page .wishlist-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #fff;
        padding: 36px 0;
        margin: 0 -12px 2rem -12px;
        border-radius: 0 0 16px 16px;
    }
    .wishlist-page .wishlist-hero h1 { color: #fff; font-weight: 700; margin: 0; }
    .wishlist-page .wishlist-hero .badge { background: #f5a623 !important; color: #fff; font-weight: 600; }
    .wishlist-page .wishlist-hero .fa-heart { color: #f5a623 !important; }

    .wishlist-page .wishlist-section {
        padding: 20px 0 50px;
        min-height: 50vh;
    }
    .wishlist-page .wishlist-item {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(26,26,46,0.08);
        padding: 24px;
        margin-bottom: 20px;
        transition: all 0.25s ease;
        border: 1px solid rgba(245,166,35,0.12);
    }
    .wishlist-page .wishlist-item:hover {
        box-shadow: 0 8px 28px rgba(245,166,35,0.15);
        transform: translateY(-2px);
        border-color: rgba(245,166,35,0.25);
    }
    .wishlist-page .wishlist-item h5 { color: #1a1a2e; }
    .wishlist-page .wishlist-item .text-muted { color: #5a5a6e !important; }
    .wishlist-page .product-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
    }
    .wishlist-page .btn-move-to-cart {
        background: linear-gradient(135deg, #f5a623, #e0941a);
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.25s ease;
        box-shadow: 0 2px 10px rgba(245,166,35,0.35);
    }
    .wishlist-page .btn-move-to-cart:hover {
        background: #1a1a2e;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(26,26,46,0.3);
        color: #fff;
    }
    .wishlist-page .btn-remove {
        color: #94a3b8;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .wishlist-page .btn-remove:hover {
        color: #ef4444;
        transform: scale(1.1);
    }
    .wishlist-page .empty-wishlist {
        text-align: center;
        padding: 80px 20px;
    }
    .wishlist-page .empty-wishlist-icon {
        font-size: 5rem;
        color: #f5a623;
        opacity: 0.7;
        margin-bottom: 30px;
    }
    .wishlist-page .empty-wishlist h3 { color: #1a1a2e; }
    .wishlist-page .empty-wishlist .text-muted { color: #5a5a6e !important; }
    .wishlist-page .empty-wishlist .btn-primary {
        background: linear-gradient(135deg, #f5a623, #e0941a);
        border: none;
        font-weight: 600;
        border-radius: 12px;
        padding: 14px 28px;
        box-shadow: 0 4px 14px rgba(245,166,35,0.35);
    }
    .wishlist-page .empty-wishlist .btn-primary:hover {
        background: #1a1a2e;
        box-shadow: 0 6px 20px rgba(26,26,46,0.3);
        color: #fff;
    }
    .wishlist-page .price-original {
        text-decoration: line-through;
        color: #94a3b8;
        font-size: 0.9rem;
    }
    .wishlist-page .price-sale {
        color: #f5a623;
        font-weight: 600;
    }
    .wishlist-page .stock-status {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .wishlist-page .stock-in {
        background: rgba(245,166,35,0.15);
        color: #1a1a2e;
    }
    .wishlist-page .stock-out {
        background: rgba(239,68,68,0.12);
        color: #b91c1c;
    }
    .wishlist-page .product-rating { display: flex; align-items: center; gap: 5px; margin-bottom: 10px; }
    .wishlist-page .stars { color: #f5a623; }
    .wishlist-page .rating-count { font-size: 0.85rem; color: #5a5a6e; }
    .wishlist-page .wishlist-actions { display: flex; gap: 10px; align-items: center; }
    .wishlist-page .save-for-later {
        background: rgba(26,26,46,0.05);
        border: 1px solid rgba(26,26,46,0.12);
        color: #1a1a2e;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.25s ease;
    }
    .wishlist-page .save-for-later:hover {
        background: #f5a623;
        border-color: #f5a623;
        color: #fff;
    }
    .wishlist-page .btn-outline-primary {
        border-color: #f5a623;
        color: #f5a623;
        font-weight: 600;
        border-radius: 12px;
    }
    .wishlist-page .btn-outline-primary:hover {
        background: #f5a623;
        border-color: #f5a623;
        color: #fff;
    }
    .wishlist-page .btn-success {
        background: linear-gradient(135deg, #f5a623, #e0941a) !important;
        border: none !important;
        font-weight: 600;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(245,166,35,0.35);
    }
    .wishlist-page .btn-success:hover {
        background: #1a1a2e !important;
        box-shadow: 0 4px 14px rgba(26,26,46,0.3);
        color: #fff;
    }
    .wishlist-page .btn-primary {
        background: linear-gradient(135deg, #f5a623, #e0941a) !important;
        border: none !important;
        font-weight: 600;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(245,166,35,0.35);
    }
    .wishlist-page .btn-primary:hover {
        background: #1a1a2e !important;
        box-shadow: 0 4px 14px rgba(26,26,46,0.3);
        color: #fff;
    }
    .wishlist-page .card {
        border-radius: 16px;
        border: 1px solid rgba(245,166,35,0.12);
        box-shadow: 0 4px 20px rgba(26,26,46,0.06);
    }
    .wishlist-page .card-title { color: #1a1a2e; }
    .wishlist-page .card .text-warning { color: #f5a623 !important; }
    .wishlist-page .card .text-info { color: #f5a623 !important; }
    .wishlist-page .card .text-success { color: #1a1a2e !important; }
    .wishlist-page .card .text-primary { color: #f5a623 !important; }
    .wishlist-page .card .small { color: #5a5a6e; }
</style>
@endsection

@section('content')
<div class="wishlist-page">
<section class="wishlist-section">
    <div class="container">
        <div class="wishlist-hero">
            <h1>
                <i class="fas fa-heart me-2"></i>My Wishlist
                @if(count($wishlistItems) > 0)
                    <span class="badge ms-2">{{ count($wishlistItems) }} items</span>
                @endif
            </h1>
        </div>
        
        @if(count($wishlistItems) > 0)
            <div class="row">
                <div class="col-12">
                    @foreach($wishlistItems as $item)
                    <div class="wishlist-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="{{ $item->product->image ?? 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=200&h=200&fit=crop' }}" 
                                     alt="{{ $item->product->name ?? '' }}" class="product-image">
                            </div>
                            <div class="col-md-5">
                                <h5 class="fw-bold mb-2">{{ $item->product->name ?? '' }}</h5>
                                <p class="text-muted small mb-2">{{ Str::limit($item->product->description ?? '', 150) }}</p>
                                
                                <div class="product-rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-count">(4.2) 245 reviews</span>
                                </div>
                                
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    
                                </div>
                                
                                <div class="mt-2">
                                    <span class="stock-status stock-in">In Stock</span>
                                    <span class="ms-2 small text-muted">Free delivery on orders above ₹1000</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="wishlist-actions">
                                    <form method="POST" action="{{ route('frontend.wishlist.move-to-cart', $item['id']) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-move-to-cart">
                                            <i class="fas fa-shopping-cart me-2"></i>Move to Cart
                                        </button>
                                    </form>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('frontend.product.detail', $item['product']->id) }}" class="save-for-later">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-end">
                                    <form method="POST" action="{{ route('frontend.wishlist.remove', $item['product']->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove" 
                                                onclick="return confirm('Remove this item from wishlist?')"
                                                title="Remove from wishlist">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="text-end mt-2">
                                    <small class="text-muted">Added recently</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('frontend.home') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                </a>
                                <div>
                                    <button class="btn btn-success me-2" onclick="addAllToCart()">
                                        <i class="fas fa-plus me-2"></i>Add All to Cart
                                    </button>
                                    <a href="{{ route('frontend.cart') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-cart me-2"></i>View Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-wishlist">
                <div class="empty-wishlist-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="fw-bold mb-3">Your wishlist is empty</h3>
                <p class="text-muted mb-4">Save items you love to your wishlist and shop them later.</p>
                <a href="{{ route('frontend.home') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                </a>
            </div>
        @endif
        
        @if(count($wishlistItems) > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-lightbulb me-2 text-warning"></i>Pro Tips
                            </h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-bell me-2 text-info"></i>
                                        <span class="small">Get notified when items go on sale</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-sync me-2 text-success"></i>
                                        <span class="small">Prices update automatically</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-share-alt me-2 text-primary"></i>
                                        <span class="small">Share your wishlist with friends</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
</div>

<script>
function addAllToCart() {
    const wishlistItems = @json($wishlistItems);
    
    if (wishlistItems.length === 0) {
        alert('No items in wishlist to add to cart.');
        return;
    }
    
    if (confirm(`Add all ${wishlistItems.length} items to cart?`)) {
        // Add each item to cart
        wishlistItems.forEach(item => {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: item.id,
                    quantity: 1
                })
            });
        });
        
        // Redirect to cart after a short delay
        setTimeout(() => {
            window.location.href = '{{ route("frontend.cart") }}';
        }, 1000);
    }
}
</script>
@endsection 