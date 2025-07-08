@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-speedometer2"></i> Admin Dashboard</h1>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle" style="width: 60px; height: 60px;">
                        <i class="bi bi-tags fs-4"></i>
                    </div>
                </div>
                <h3 class="card-title text-primary">{{ $totalCategories }}</h3>
                <p class="card-text text-muted">Total Categories</p>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-eye"></i> View All
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle" style="width: 60px; height: 60px;">
                        <i class="bi bi-box fs-4"></i>
                    </div>
                </div>
                <h3 class="card-title text-success">{{ $totalProducts }}</h3>
                <p class="card-text text-muted">Total Products</p>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-eye"></i> View All
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning text-dark rounded-circle" style="width: 60px; height: 60px;">
                        <i class="bi bi-star fs-4"></i>
                    </div>
                </div>
                <h3 class="card-title text-warning">{{ $featuredProducts }}</h3>
                <p class="card-text text-muted">Featured Products</p>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-warning btn-sm">
                    <i class="bi bi-eye"></i> Manage
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-info text-white rounded-circle" style="width: 60px; height: 60px;">
                        <i class="bi bi-bag fs-4"></i>
                    </div>
                </div>
                <h3 class="card-title text-info">{{ $totalOrders }}</h3>
                <p class="card-text text-muted">Total Orders</p>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-info btn-sm">
                    <i class="bi bi-eye"></i> View All
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle" style="width: 60px; height: 60px;">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                </div>
                <h3 class="card-title text-success">₹{{ number_format($totalRevenue, 2) }}</h3>
                <p class="card-text text-muted">Total Revenue</p>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-eye"></i> View Orders
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle" style="width: 60px; height: 60px;">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
                <h3 class="card-title text-danger">{{ $totalCustomers }}</h3>
                <p class="card-text text-muted">Total Customers</p>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-eye"></i> View All
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Product Status & Quick Actions -->
<div class="row mb-4">
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="bi bi-bar-chart me-2"></i>Product Status Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="p-3">
                            <h4 class="text-success mb-1">{{ $activeProducts }}</h4>
                            <p class="text-muted mb-0 small">Active Products</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3">
                            <h4 class="text-danger mb-1">{{ $inactiveProducts }}</h4>
                            <p class="text-muted mb-0 small">Inactive Products</p>
                        </div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 8px;">
                    @php
                        $total = $activeProducts + $inactiveProducts;
                        $activePercentage = $total > 0 ? ($activeProducts / $total) * 100 : 0;
                    @endphp
                    <div class="progress-bar bg-success" style="width: {{ $activePercentage }}%"></div>
                </div>
                <small class="text-muted">{{ number_format($activePercentage, 1) }}% of products are active</small>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i> Add New Category
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-lg me-2"></i> Add New Product
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-warning">
                        <i class="bi bi-bag me-2"></i> Manage Orders
                    </a>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-danger">
                        <i class="bi bi-people me-2"></i> Manage Customers
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Products -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history me-2"></i>Recent Products
                </h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-right me-1"></i> View All Products
                </a>
            </div>
            <div class="card-body">
                @if($recentProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 me-3">
                                                <i class="bi bi-box text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $product->name }}</h6>
                                                <small class="text-muted">{{ Str::limit($product->description ?? 'No description', 30) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-success">${{ number_format($product->price, 2) }}</strong>
                                    </td>
                                    <td>
                                        @if($product->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-box display-1 text-muted"></i>
                        </div>
                        <h5 class="text-muted">No products yet</h5>
                        <p class="text-muted">Start by creating your first product to see it here.</p>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-2"></i> Create First Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 