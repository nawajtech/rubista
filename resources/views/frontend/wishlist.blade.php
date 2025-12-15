@extends('frontend.layouts.app')

@section('title', 'Wishlist - Rubista')

@section('extra-css')
<style>
    .wishlist-section {
        padding: 50px 0;
        min-height: 60vh;
    }
    
    .wishlist-item {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .wishlist-item:hover {
        box-shadow: 0 5px 25px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    
    .product-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
    }
    
    .btn-move-to-cart {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-move-to-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }
    
    .btn-remove {
        color: #dc3545;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-remove:hover {
        color: #c82333;
        transform: scale(1.1);
    }
    
    .empty-wishlist {
        text-align: center;
        padding: 80px 20px;
    }
    
    .empty-wishlist-icon {
        font-size: 5rem;
        color: #dee2e6;
        margin-bottom: 30px;
    }
    
    .price-original {
        text-decoration: line-through;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .price-sale {
        color: #dc3545;
        font-weight: bold;
    }
    
    .stock-status {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .stock-in {
        background: #d4edda;
        color: #155724;
    }
    
    .stock-out {
        background: #f8d7da;
        color: #721c24;
    }
    
    .product-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 10px;
    }
    
    .stars {
        color: #ffc107;
    }
    
    .rating-count {
        font-size: 0.85rem;
        color: #666;
    }
    
    .wishlist-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    
    .save-for-later {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #6c757d;
        padding: 8px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .save-for-later:hover {
        background: #e9ecef;
        color: #495057;
    }
</style>
@endsection

@section('content')
<section class="wishlist-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="fw-bold mb-4">
                    <i class="fas fa-heart me-2 text-danger"></i>My Wishlist
                    @if(count($wishlistItems) > 0)
                        <span class="badge bg-danger ms-2">{{ count($wishlistItems) }} items</span>
                    @endif
                </h1>
            </div>
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