@extends('frontend.layouts.app')

@section('title', $category->name . ' - Rubista')

@section('content')
<div class="container py-4">
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
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-6 mb-4">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        @if($product->image)
                            @if(Str::startsWith($product->image, 'http'))
                                <img src="{{ $product->image }}" 
                                     class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                            @endif
                        @else
                            <div class="card-img-top" style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
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
            {{ $products->links() }}
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
@endsection 