@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Review Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-star"></i> Review #{{ $review->id }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit Review
        </a>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Reviews
        </a>
    </div>
</div>

<div class="row">
    <!-- Review Information -->
    <div class="col-md-8">
        <!-- Review Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Review Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-5">Review ID:</dt>
                            <dd class="col-sm-7">#{{ $review->id }}</dd>
                            
                            <dt class="col-sm-5">Product:</dt>
                            <dd class="col-sm-7">
                                <a href="{{ route('admin.products.show', $review->product) }}">
                                    {{ $review->product->name }}
                                </a>
                            </dd>
                            
                            <dt class="col-sm-5">Customer:</dt>
                            <dd class="col-sm-7">
                                <a href="{{ route('admin.customers.show', $review->user) }}">
                                    {{ $review->user->name }}
                                </a>
                                <br>
                                <small class="text-muted">{{ $review->user->email }}</small>
                            </dd>
                            
                            <dt class="col-sm-5">Rating:</dt>
                            <dd class="col-sm-7">
                                <div class="d-flex align-items-center">
                                    <span class="text-warning me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}" style="font-size: 1.2rem;"></i>
                                        @endfor
                                    </span>
                                    <span class="fw-bold">({{ $review->rating }}/5)</span>
                                </div>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-5">Status:</dt>
                            <dd class="col-sm-7">
                                <span class="badge bg-{{ $review->status ? 'success' : 'warning' }} fs-6">
                                    {{ $review->status ? 'Approved' : 'Pending' }}
                                </span>
                            </dd>
                            
                            <dt class="col-sm-5">Created Date:</dt>
                            <dd class="col-sm-7">{{ $review->created_at->format('M d, Y \a\t h:i A') }}</dd>
                            
                            <dt class="col-sm-5">Updated Date:</dt>
                            <dd class="col-sm-7">{{ $review->updated_at->format('M d, Y \a\t h:i A') }}</dd>
                        </dl>
                    </div>
                </div>
                
                @if($review->comment)
                <hr>
                <div>
                    <h6>Review Comment:</h6>
                    <p class="text-muted">{{ $review->comment }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Photos -->
        @if($review->photos && count($review->photos) > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-image"></i> Photos ({{ count($review->photos) }})
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($review->photos as $photo)
                    <div class="col-md-3 mb-3">
                        <div class="position-relative">
                            <img src="{{ Storage::url($photo) }}" alt="Review Photo" 
                                 class="img-thumbnail w-100" style="height: 200px; object-fit: cover;">
                            <form method="POST" action="{{ route('admin.reviews.delete-photo', $review) }}" class="position-absolute top-0 end-0 m-2">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="photo_path" value="{{ $photo }}">
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Are you sure you want to delete this photo?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Videos -->
        @if($review->videos && count($review->videos) > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-camera-video"></i> Videos ({{ count($review->videos) }})
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($review->videos as $video)
                    <div class="col-md-6 mb-3">
                        <div class="position-relative">
                            <video controls class="w-100" style="max-height: 300px;">
                                <source src="{{ Storage::url($video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <form method="POST" action="{{ route('admin.reviews.delete-video', $review) }}" class="position-absolute top-0 end-0 m-2">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="video_path" value="{{ $video }}">
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Are you sure you want to delete this video?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.reviews.toggle-status', $review) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-{{ $review->status ? 'warning' : 'success' }} w-100 mb-2">
                        <i class="bi bi-{{ $review->status ? 'x-circle' : 'check-circle' }}"></i>
                        {{ $review->status ? 'Reject Review' : 'Approve Review' }}
                    </button>
                </form>
                
                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" 
                            onclick="return confirm('Are you sure you want to delete this review? This action cannot be undone.')">
                        <i class="bi bi-trash"></i> Delete Review
                    </button>
                </form>
            </div>
        </div>

        <!-- Product Info -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-box"></i> Product Information
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    @if($review->product->image)
                        <img src="{{ Storage::url($review->product->image) }}" 
                             alt="{{ $review->product->name }}" 
                             class="img-thumbnail" style="max-width: 150px;">
                    @endif
                </div>
                <h6>{{ $review->product->name }}</h6>
                <p class="text-muted small mb-2">SKU: {{ $review->product->sku ?? 'N/A' }}</p>
                <p class="text-muted small mb-0">Price: ₹{{ number_format($review->product->price, 2) }}</p>
                <a href="{{ route('admin.products.show', $review->product) }}" class="btn btn-sm btn-outline-primary mt-2 w-100">
                    <i class="bi bi-eye"></i> View Product
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
