@extends('frontend.layouts.app')

@section('title', 'Search Results - Rubista')

@section('extra-css')
<style>
    .search-page .search-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #fff;
        padding: 40px 0;
        margin: 0 -12px 2rem -12px;
        border-radius: 0 0 16px 16px;
    }
    .search-page .search-hero h1 { color: #fff; font-weight: 700; margin-bottom: 0.5rem; }
    .search-page .search-hero p { color: rgba(255,255,255,0.9); margin: 0; }
    .search-page .search-hero strong { color: #f5a623; }

    .search-page .product-card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(26,26,46,0.08);
        box-shadow: 0 2px 12px rgba(26,26,46,0.06);
        transition: all 0.25s ease;
    }
    .search-page .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(245,166,35,0.15);
        border-color: rgba(245,166,35,0.2);
    }
    .search-page .product-card .card-title { color: #1a1a2e; font-weight: 600; }
    .search-page .product-card .text-muted { color: #5a5a6e !important; }
    .search-page .product-card .price-sale,
    .search-page .product-card .fw-bold { color: #f5a623; }
    .search-page .product-card .price-original { color: #94a3b8; text-decoration: line-through; }
    .search-page .product-card .btn-primary {
        background: linear-gradient(135deg, #f5a623, #e0941a);
        border: none;
        font-weight: 600;
        border-radius: 10px;
        padding: 8px 12px;
        box-shadow: 0 2px 10px rgba(245,166,35,0.3);
    }
    .search-page .product-card .btn-primary:hover {
        background: #1a1a2e;
        box-shadow: 0 4px 14px rgba(26,26,46,0.3);
    }
    .search-page .badge-sale {
        background: #f5a623 !important;
        color: #fff;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
    }
    .search-page .badge.bg-warning { background: #1a1a2e !important; color: #fff; }
    .search-page .badge.bg-success { background: rgba(245,166,35,0.2) !important; color: #1a1a2e; }
    .search-page .badge.bg-success i { color: #f5a623; }

    .search-page .no-results {
        padding: 60px 20px;
        color: #5a5a6e;
    }
    .search-page .no-results .fa-search { color: #f5a623; opacity: 0.8; }
    .search-page .no-results h3 { color: #1a1a2e; }
    .search-page .no-results .btn-primary {
        background: linear-gradient(135deg, #f5a623, #e0941a);
        border: none;
        font-weight: 600;
        border-radius: 12px;
        padding: 12px 24px;
        box-shadow: 0 4px 14px rgba(245,166,35,0.35);
    }
    .search-page .no-results .btn-primary:hover {
        background: #1a1a2e;
        box-shadow: 0 6px 20px rgba(26,26,46,0.3);
    }
    .search-page .pagination .page-link {
        color: #1a1a2e;
        border-color: rgba(26,26,46,0.12);
        border-radius: 8px;
        margin: 0 2px;
    }
    .search-page .pagination .page-link:hover {
        background: #f5a623;
        border-color: #f5a623;
        color: #fff;
    }
    .search-page .pagination .page-item.active .page-link {
        background: #1a1a2e;
        border-color: #1a1a2e;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="search-page">
<div class="container py-4">
    <!-- Search Header -->
    <div class="search-hero">
        <div class="container">
            <h1>Search Results</h1>
            @if($query)
                <p>Showing results for "<strong>{{ $query }}</strong>" — {{ $products->total() }} products found</p>
            @else
                <p>{{ $products->total() }} products found</p>
            @endif
        </div>
    </div>

    <!-- Search Results -->
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-6 mb-4">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        @if($product->image)
                            @if(Str::startsWith($product->image, 'http'))
                                <img src="{{ $product->image }}" 
                                     class="card-img-top" alt="{{ $product->name }}" style="height: 200px; width: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="card-img-top" alt="{{ $product->name }}" style="height: 200px; width: 100%; object-fit: cover;">
                            @endif
                        @else
                            <div class="card-img-top" style="height: 200px; width: 100%; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); display: flex; align-items: center; justify-content: center; color: #f5a623; font-size: 2rem;">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="badge-sale position-absolute top-0 start-0 m-2">SALE</span>
                        @endif
                        @if($product->featured)
                            <span class="badge bg-warning position-absolute top-0 end-0 m-2">FEATURED</span>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        <h6 class="card-title">{{ Str::limit($product->name, 60) }}</h6>
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
                            <div>
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="price-original small">₹{{ number_format($product->price, 2) }}</span>
                                    <span class="price-sale">₹{{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="fw-bold">₹{{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('frontend.product.detail', $product->id) }}" 
                           class="btn btn-primary btn-sm w-100">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(request()->input())->links() }}
        </div>
    @else
        <div class="text-center no-results">
            <i class="fas fa-search fa-3x mb-3"></i>
            <h3>No products found</h3>
            @if($query)
                <p>Sorry, no products match your search for "{{ $query }}".</p>
                <p>Try different keywords or browse our categories.</p>
            @else
                <p>No products available at the moment.</p>
            @endif
            <a href="{{ route('frontend.home') }}" class="btn btn-primary">Back to Home</a>
        </div>
    @endif
</div>
</div>
@endsection 