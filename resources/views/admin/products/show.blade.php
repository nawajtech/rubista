@extends('layouts.admin')

@section('title', 'Product Details - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Product: {{ $product->name }}</h1>
    <div class="btn-group">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit Product
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                 class="img-fluid rounded shadow">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="height: 300px;">
                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                <div class="ms-2">
                                    <p class="text-muted mb-0">No Image</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <h3>{{ $product->name }}</h3>
                        <p class="text-muted">SKU: {{ $product->sku }}</p>
                        <p class="text-muted">Category: 
                            <a href="{{ route('admin.categories.show', $product->category) }}" class="text-decoration-none">
                                {{ $product->category->name }}
                            </a>
                        </p>
                        
                        <div class="mt-3">
                            <h5>Pricing</h5>
                            <div class="d-flex align-items-center">
                                @if($product->is_on_sale)
                                    <span class="h4 text-success me-2">${{ $product->sale_price }}</span>
                                    <span class="text-muted text-decoration-line-through">${{ $product->price }}</span>
                                    <span class="badge bg-danger ms-2">
                                        {{ number_format((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                                    </span>
                                @else
                                    <span class="h4">${{ $product->price }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-3">
                            <h5>Stock</h5>
                            <div class="d-flex align-items-center">
                                <span class="h5 me-2">{{ $product->stock_quantity }}</span>
                                @if($product->stock_quantity > 0)
                                    <span class="badge bg-success">In Stock</span>
                                    @if($product->stock_quantity <= 5)
                                        <span class="badge bg-warning text-dark ms-1">Low Stock</span>
                                    @endif
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="d-flex gap-2">
                                @if($product->status)
                                    <span class="badge bg-success fs-6">Active</span>
                                @else
                                    <span class="badge bg-secondary fs-6">Inactive</span>
                                @endif
                                
                                @if($product->featured)
                                    <span class="badge bg-warning text-dark fs-6">
                                        <i class="bi bi-star-fill"></i> Featured
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($product->short_description)
                            <div class="mt-3">
                                <h5>Short Description</h5>
                                <p>{{ $product->short_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($product->description)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Full Description</h5>
            </div>
            <div class="card-body">
                <div class="bg-light p-3 rounded">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong><br>{{ $product->name }}</p>
                <p><strong>SKU:</strong><br>{{ $product->sku }}</p>
                <p><strong>Category:</strong><br>
                    <a href="{{ route('admin.categories.show', $product->category) }}" class="text-decoration-none">
                        {{ $product->category->name }}
                    </a>
                </p>
                <p><strong>Created:</strong><br>{{ $product->created_at->format('M d, Y H:i A') }}</p>
                <p><strong>Last Updated:</strong><br>{{ $product->updated_at->format('M d, Y H:i A') }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Product
                    </a>
                    <a href="{{ route('frontend.product.detail', $product->id) }}" class="btn btn-outline-success" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> View on Frontend
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus-lg"></i> Add New Product
                    </a>
                    <a href="{{ route('admin.categories.show', $product->category) }}" class="btn btn-outline-info">
                        <i class="bi bi-tags"></i> View Category
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Product Stats</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-primary">${{ $product->display_price }}</h4>
                        <p class="text-muted mb-0 small">Current Price</p>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ $product->stock_quantity }}</h4>
                        <p class="text-muted mb-0 small">In Stock</p>
                    </div>
                </div>
            </div>
        </div>

        @if($product->stock_quantity <= 5)
        <div class="card mt-3 border-warning">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle"></i> Stock Alert
                </h5>
            </div>
            <div class="card-body">
                @if($product->stock_quantity == 0)
                    <p class="text-danger mb-0">This product is out of stock!</p>
                @else
                    <p class="text-warning mb-0">Low stock: Only {{ $product->stock_quantity }} items left</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 