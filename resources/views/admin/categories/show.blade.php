@extends('layouts.admin')

@section('title', 'Category Details - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Category: {{ $category->name }}</h1>
    <div class="btn-group">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit Category
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" 
                                 class="img-fluid rounded shadow">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                <div class="ms-2">
                                    <p class="text-muted mb-0">No Image</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h3>{{ $category->name }}</h3>
                        <p class="text-muted">{{ $category->slug }}</p>
                        
                        @if($category->description)
                            <div class="mt-3">
                                <h5>Description</h5>
                                <p>{{ $category->description }}</p>
                            </div>
                        @endif

                        <div class="mt-3">
                            <span class="badge {{ $category->status ? 'bg-success' : 'bg-secondary' }} fs-6">
                                {{ $category->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Products -->
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Products in this Category ({{ $category->products_count }})</h5>
                <a href="{{ route('admin.products.create') }}?category={{ $category->id }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Product
                </a>
            </div>
            <div class="card-body">
                @if($category->products->count() > 0)
                    <div class="row">
                        @foreach($category->products as $product)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" 
                                         alt="{{ $product->name }}" style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 150px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ $product->name }}</h6>
                                    <p class="card-text text-muted small">{{ $product->sku }}</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @if($product->is_on_sale)
                                                    <span class="text-muted text-decoration-line-through small">${{ $product->price }}</span>
                                                    <span class="fw-bold text-success">${{ $product->sale_price }}</span>
                                                @else
                                                    <span class="fw-bold">${{ $product->price }}</span>
                                                @endif
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.products.show', $product) }}" 
                                                   class="btn btn-outline-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.products.edit', $product) }}" 
                                                   class="btn btn-outline-primary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="mt-1">
                                            @if($product->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                            @if($product->featured)
                                                <span class="badge bg-warning text-dark">Featured</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-box display-4 text-muted"></i>
                        <h5 class="mt-3">No products in this category</h5>
                        <p class="text-muted">Start by adding some products to this category.</p>
                        <a href="{{ route('admin.products.create') }}?category={{ $category->id }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Add First Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Created:</strong><br>{{ $category->created_at->format('M d, Y H:i A') }}</p>
                <p><strong>Last Updated:</strong><br>{{ $category->updated_at->format('M d, Y H:i A') }}</p>
                <p><strong>Total Products:</strong><br>{{ $category->products_count }}</p>
                <p><strong>Status:</strong><br>
                    <span class="badge {{ $category->status ? 'bg-success' : 'bg-secondary' }}">
                        {{ $category->status ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Category
                    </a>
                    <a href="{{ route('frontend.category.products', $category->id) }}" class="btn btn-outline-success" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> View on Frontend
                    </a>
                    <a href="{{ route('admin.products.create') }}?category={{ $category->id }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus-lg"></i> Add Product
                    </a>
                </div>
            </div>
        </div>

        @if($category->products()->where('status', false)->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0 text-warning">
                    <i class="bi bi-exclamation-triangle"></i> Inactive Products
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">This category has {{ $category->products()->where('status', false)->count() }} inactive products.</p>
                <a href="{{ route('admin.products.index') }}?category={{ $category->id }}&status=inactive" class="btn btn-sm btn-outline-warning">
                    View Inactive Products
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 