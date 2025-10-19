@extends('frontend.layouts.app')

@section('title', 'Product Categories - Rubista')

@section('extra-css')
<style>
    .categories-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
    }

    .categories-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .categories-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 500px;
        margin: 0 auto;
    }

    .categories-section {
        padding: 60px 0;
        background: #f8fafc;
    }

    .category-filters {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }

    .filter-btn {
        background: white;
        border: 1px solid #e2e8f0;
        color: #64748b;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }

    .category-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .category-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .category-title {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .category-icon {
        width: 45px;
        height: 45px;
        background: #667eea;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .category-info h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .category-info p {
        color: #64748b;
        margin: 4px 0 0 0;
        font-size: 0.85rem;
    }

    .view-all-btn {
        background: #667eea;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .view-all-btn:hover {
        background: #5a67d8;
        color: white;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .product-item {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #f1f5f9;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .product-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .product-image-wrapper {
        position: relative;
        height: 160px;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #ef4444;
        color: white;
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 500;
    }

    .product-details {
        padding: 15px;
    }

    .product-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        line-height: 1.3;
        height: 2.4em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 10px;
    }

    .stars {
        color: #fbbf24;
        font-size: 0.75rem;
    }

    .review-count {
        font-size: 0.7rem;
        color: #64748b;
    }

    .product-price {
        margin-bottom: 12px;
    }

    .current-price {
        font-size: 1.1rem;
        font-weight: 600;
        color: #667eea;
    }

    .original-price {
        font-size: 0.8rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 6px;
    }

    .add-to-cart-btn {
        width: 100%;
        background: #667eea;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
        cursor: pointer;
        transition: background 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .add-to-cart-btn:hover {
        background: #5a67d8;
    }

    .no-products {
        text-align: center;
        padding: 40px 20px;
        color: #64748b;
    }

    .no-products i {
        font-size: 2.5rem;
        color: #e2e8f0;
        margin-bottom: 15px;
    }

    .no-products h4 {
        font-size: 1.1rem;
        margin-bottom: 8px;
    }

    .no-products p {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    @media (max-width: 768px) {
        .categories-hero {
            padding: 60px 0;
        }

        .categories-hero h1 {
            font-size: 2.2rem;
        }

        .categories-hero p {
            font-size: 1rem;
        }

        .categories-section {
            padding: 40px 0;
        }

        .category-card {
            padding: 20px;
            margin-bottom: 25px;
        }

        .category-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .category-info h3 {
            font-size: 1.3rem;
        }

        .category-icon {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
        }

        .product-image-wrapper {
            height: 140px;
        }

        .product-details {
            padding: 12px;
        }

        .category-filters {
            gap: 8px;
            margin-bottom: 35px;
        }

        .filter-btn {
            padding: 10px 18px;
            font-size: 0.85rem;
        }
    }
</style>
@endsection

@section('content')
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
                        <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=300&h=200&fit=crop" 
                             class="product-image" alt="{{ $product->name }}">
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
                this.style.background = '#10b981';
                
                // Show success message
                const toast = document.createElement('div');
                toast.innerHTML = `
                    <div style="
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: #10b981;
                        color: white;
                        padding: 12px 20px;
                        border-radius: 6px;
                        z-index: 9999;
                        font-weight: 500;
                        font-size: 0.9rem;
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
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

