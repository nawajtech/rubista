@extends('frontend.layouts.app')

@section('title', 'Product Categories - Rubista')

@section('extra-css')
<style>
    .categories-page .categories-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #fff;
        padding: 80px 0;
        text-align: center;
    }
    .categories-page .categories-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #fff;
    }
    .categories-page .categories-hero p {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.9);
        max-width: 500px;
        margin: 0 auto;
    }

    .categories-page .categories-section {
        padding: 60px 0;
        background: #f8fafc;
    }

    .categories-page .category-filters {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }
    .categories-page .filter-btn {
        background: #fff;
        border: 1px solid rgba(26,26,46,0.12);
        color: #5a5a6e;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.25s ease;
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(26,26,46,0.06);
    }
    .categories-page .filter-btn:hover {
        background: #f5a623;
        border-color: #f5a623;
        color: #fff;
        box-shadow: 0 4px 14px rgba(245,166,35,0.35);
    }
    .categories-page .filter-btn.active {
        background: #1a1a2e;
        border-color: #1a1a2e;
        color: #fff;
        box-shadow: 0 4px 14px rgba(26,26,46,0.25);
    }

    .categories-page .category-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(26,26,46,0.08);
        border: 1px solid rgba(245,166,35,0.12);
        transition: box-shadow 0.3s ease;
    }
    .categories-page .category-card:hover {
        box-shadow: 0 8px 28px rgba(245,166,35,0.12);
    }
    .categories-page .category-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(26,26,46,0.08);
    }
    .categories-page .category-title {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .categories-page .category-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #f5a623, #e0941a);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
        box-shadow: 0 4px 12px rgba(245,166,35,0.3);
    }
    .categories-page .category-info h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }
    .categories-page .category-info p {
        color: #5a5a6e;
        margin: 4px 0 0 0;
        font-size: 0.85rem;
    }
    .categories-page .view-all-btn {
        background: #f5a623;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 2px 10px rgba(245,166,35,0.3);
    }
    .categories-page .view-all-btn:hover {
        background: #1a1a2e;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(26,26,46,0.25);
    }

    .categories-page .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }
    .categories-page .product-item {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(26,26,46,0.06);
        border: 1px solid rgba(26,26,46,0.06);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .categories-page .product-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(245,166,35,0.15);
        border-color: rgba(245,166,35,0.2);
    }
    .categories-page .product-image-wrapper {
        position: relative;
        height: 160px;
        overflow: hidden;
    }
    .categories-page .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .categories-page .product-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #f5a623;
        color: #fff;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .categories-page .product-details {
        padding: 15px;
    }
    .categories-page .product-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 8px;
        line-height: 1.3;
        height: 2.4em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .categories-page .product-rating {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 10px;
    }
    .categories-page .stars {
        color: #f5a623;
        font-size: 0.75rem;
    }
    .categories-page .review-count {
        font-size: 0.7rem;
        color: #5a5a6e;
    }
    .categories-page .product-price {
        margin-bottom: 12px;
    }
    .categories-page .current-price {
        font-size: 1.1rem;
        font-weight: 600;
        color: #f5a623;
    }
    .categories-page .original-price {
        font-size: 0.8rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 6px;
    }
    .categories-page .add-to-cart-btn {
        width: 100%;
        background: linear-gradient(135deg, #f5a623, #e0941a);
        color: #fff;
        border: none;
        padding: 10px 12px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 2px 10px rgba(245,166,35,0.3);
    }
    .categories-page .add-to-cart-btn:hover {
        background: #1a1a2e;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(26,26,46,0.3);
    }

    .categories-page .no-products {
        text-align: center;
        padding: 50px 20px;
        color: #5a5a6e;
        background: rgba(26,26,46,0.03);
        border-radius: 12px;
    }
    .categories-page .no-products i {
        font-size: 2.5rem;
        color: rgba(245,166,35,0.4);
        margin-bottom: 15px;
    }
    .categories-page .no-products h4 {
        font-size: 1.1rem;
        margin-bottom: 8px;
        color: #1a1a2e;
    }
    .categories-page .no-products p {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    @media (max-width: 768px) {
        .categories-page .categories-hero {
            padding: 60px 0;
        }
        .categories-page .categories-hero h1 {
            font-size: 2.2rem;
        }
        .categories-page .categories-hero p {
            font-size: 1rem;
        }
        .categories-page .categories-section {
            padding: 40px 0;
        }
        .categories-page .category-card {
            padding: 20px;
            margin-bottom: 25px;
        }
        .categories-page .category-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        .categories-page .category-info h3 {
            font-size: 1.3rem;
        }
        .categories-page .category-icon {
            width: 42px;
            height: 42px;
            font-size: 1.1rem;
        }
        .categories-page .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
        }
        .categories-page .product-image-wrapper {
            height: 140px;
        }
        .categories-page .product-details {
            padding: 12px;
        }
        .categories-page .category-filters {
            gap: 8px;
            margin-bottom: 35px;
        }
        .categories-page .filter-btn {
            padding: 10px 18px;
            font-size: 0.85rem;
        }
    }
</style>
@endsection

@section('content')
<div class="categories-page">
<!-- Categories Hero Section -->
<section class="categories-hero">
    <div class="container">
        <h1>Product Categories</h1>
        <p>Browse our products by category and find what you need quickly</p>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <!-- Category Filters -->
        <div class="category-filters">
            <button class="filter-btn active" data-category="all">All Categories</button>
            @foreach($categories as $category)
            <button class="filter-btn" data-category="{{ $category->id }}">{{ $category->name }}</button>
            @endforeach
        </div>

        <!-- Categories Content -->
        @foreach($categories as $category)
        <div class="category-card" data-category="{{ $category->id }}">
            <div class="category-header">
                <div class="category-title">
                    <div class="category-icon">
                        <i class="fas fa-{{ $loop->index % 6 == 0 ? 'laptop' : ($loop->index % 6 == 1 ? 'mobile-alt' : ($loop->index % 6 == 2 ? 'headphones' : ($loop->index % 6 == 3 ? 'tv' : ($loop->index % 6 == 4 ? 'camera' : 'gamepad')))) }}"></i>
                    </div>
                    <div class="category-info">
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->products->count() }} products</p>
                    </div>
                </div>
                <a href="#" class="view-all-btn">View All</a>
            </div>

            @if($category->products->count() > 0)
            <div class="products-grid">
                @foreach($category->products->take(4) as $product)
                <div class="product-item">
                    <div class="product-image-wrapper">
                        @if($product->image)
                            @if(Str::startsWith($product->image, 'http'))
                                <img src="{{ $product->image }}" 
                                     class="product-image" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="product-image" alt="{{ $product->name }}">
                            @endif
                        @else
                            <div class="product-image" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); display: flex; align-items: center; justify-content: center; color: #f5a623; font-size: 2rem;">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        @if($product->price > 5000)
                        <div class="product-badge">Sale</div>
                        @endif
                    </div>
                    <div class="product-details">
                        <h4 class="product-name">{{ $product->name }}</h4>
                        <div class="product-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="review-count">({{ rand(50, 200) }})</span>
                        </div>
                        <div class="product-price">
                            @if($product->price > 5000)
                                <span class="current-price">₹{{ number_format($product->price - 1000, 0) }}</span>
                                <span class="original-price">₹{{ number_format($product->price, 0) }}</span>
                            @else
                                <span class="current-price">₹{{ number_format($product->price, 0) }}</span>
                            @endif
                        </div>
                        <button class="add-to-cart-btn" data-product-id="{{ $product->id }}">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="no-products">
                <i class="fas fa-box-open"></i>
                <h4>No products available</h4>
                <p>Check back soon for new products!</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</section>
</div>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category Filter Functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const categoryCards = document.querySelectorAll('.category-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter category cards
            categoryCards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Add to Cart Functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-check"></i> Added!';
                this.style.background = '#1a1a2e';
                
                // Show success message
                const toast = document.createElement('div');
                toast.innerHTML = `
                    <div style="
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: #f5a623;
                        color: white;
                        padding: 12px 20px;
                        border-radius: 10px;
                        z-index: 9999;
                        font-weight: 600;
                        font-size: 0.9rem;
                        box-shadow: 0 4px 14px rgba(245, 166, 35, 0.4);
                    ">
                        <i class="fas fa-check me-2"></i>Product added to cart!
                    </div>
                `;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.background = '';
                    this.disabled = false;
                }, 2000);
            }, 600);
        });
    });
});
</script>
@endsection

