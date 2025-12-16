@extends('layouts.admin')

@section('title', 'Reviews - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-star"></i> Reviews & Ratings</h1>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $totalReviews }}</h5>
                <p class="card-text text-muted">Total Reviews</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-success">{{ $approvedReviews }}</h5>
                <p class="card-text text-muted">Approved</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-warning">{{ $pendingReviews }}</h5>
                <p class="card-text text-muted">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ number_format($averageRating, 1) }} <i class="bi bi-star-fill text-warning"></i></h5>
                <p class="card-text text-muted">Average Rating</p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reviews.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search reviews..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="rating" class="form-select">
                        <option value="">All Ratings</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="product_id" class="form-select">
                        <option value="">All Products</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Reviews Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Reviews</h5>
    </div>
    <div class="card-body">
        @if($reviews->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Media</th>
                            <th>Status</th>
                            <th style="min-width: 110px;">Date</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                        <tr>
                            <td>#{{ $review->id }}</td>
                            <td>
                                <div>
                                    <div class="fw-bold">{{ Str::limit($review->product->name, 30) }}</div>
                                    <small class="text-muted">SKU: {{ $review->product->sku ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-bold">{{ $review->user->name }}</div>
                                    <small class="text-muted">{{ $review->user->email }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="text-warning me-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </span>
                                    <span class="ms-1">({{ $review->rating }})</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" title="{{ $review->comment }}">
                                    {{ $review->comment ? Str::limit($review->comment, 50) : 'No comment' }}
                                </div>
                            </td>
                            <td>
                                @php
                                    $photoCount = $review->photos ? count($review->photos) : 0;
                                    $videoCount = $review->videos ? count($review->videos) : 0;
                                @endphp
                                @if($photoCount > 0 || $videoCount > 0)
                                    <span class="badge bg-info">
                                        <i class="bi bi-image"></i> {{ $photoCount }}
                                        @if($videoCount > 0)
                                            <i class="bi bi-camera-video ms-1"></i> {{ $videoCount }}
                                        @endif
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $review->status ? 'success' : 'warning' }}">
                                    {{ $review->status ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td class="text-nowrap">{{ $review->created_at->format('M d, Y') }}</td>
                            <td class="text-nowrap" style="width: 120px;">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-outline-info btn-sm p-1" style="min-width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;" title="View">
                                        <i class="bi bi-eye" style="font-size: 0.875rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-outline-primary btn-sm p-1" style="min-width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;" title="Edit">
                                        <i class="bi bi-pencil" style="font-size: 0.875rem;"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.reviews.toggle-status', $review) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-{{ $review->status ? 'warning' : 'success' }} btn-sm p-1" 
                                                style="min-width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;"
                                                title="{{ $review->status ? 'Reject' : 'Approve' }}">
                                            <i class="bi bi-{{ $review->status ? 'x-circle' : 'check-circle' }}" style="font-size: 0.875rem;"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm p-1" 
                                                style="min-width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;"
                                                onclick="return confirm('Are you sure you want to delete this review?')" title="Delete">
                                            <i class="bi bi-trash" style="font-size: 0.875rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-star text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3">No reviews found</h5>
                <p class="text-muted">No reviews match your search criteria.</p>
            </div>
        @endif
    </div>
</div>
@endsection
