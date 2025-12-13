@extends('frontend.layouts.app')

@section('title', 'Search Results - Rubista')

@section('content')
<div class="container py-4">
    <!-- Search Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-2">Search Results</h1>
            @if($query)
                <p class="text-muted">Showing results for "<strong>{{ $query }}</strong>" - {{ $products->total() }} products found</p>
            @else
                <p class="text-muted">{{ $products->total() }} products found</p>
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
                            <div class="card-img-top" style="height: 200px; width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
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
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="price-original small">₹{{ number_format($product->price, 2) }}</span>
                                    <span class="price-sale">₹{{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="fw-bold">₹{{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <small class="text-muted">⭐ 4.5</small>
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
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h3>No products found</h3>
            @if($query)
                <p class="text-muted">Sorry, no products match your search for "{{ $query }}".</p>
                <p class="text-muted">Try different keywords or browse our categories.</p>
            @else
                <p class="text-muted">No products available at the moment.</p>
            @endif
            <a href="{{ route('frontend.home') }}" class="btn btn-primary">Back to Home</a>
        </div>
    @endif
</div>
@endsection 