@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Edit Review')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-pencil"></i> Edit Review #{{ $review->id }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Review</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.reviews.update', $review) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="product" class="form-label">Product</label>
                        <input type="text" class="form-control" value="{{ $review->product->name }}" disabled>
                        <small class="text-muted">Product cannot be changed</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="user" class="form-label">Customer</label>
                        <input type="text" class="form-control" value="{{ $review->user->name }} ({{ $review->user->email }})" disabled>
                        <small class="text-muted">Customer cannot be changed</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select name="rating" id="rating" class="form-select @error('rating') is-invalid @enderror" required>
                            <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>1 Star</option>
                            <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>2 Stars</option>
                            <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>3 Stars</option>
                            <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>4 Stars</option>
                            <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>5 Stars</option>
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" 
                                  rows="5" maxlength="1000">{{ old('comment', $review->comment) }}</textarea>
                        <small class="text-muted"><span id="char-count">{{ strlen($review->comment ?? '') }}</span>/1000 characters</small>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="0" {{ !$review->status ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $review->status ? 'selected' : '' }}>Approved</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Update Review
                        </button>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Photos -->
        @if($review->photos && count($review->photos) > 0)
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0">Photos</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($review->photos as $photo)
                    <div class="col-6 mb-2">
                        <div class="position-relative">
                            <img src="{{ Storage::url($photo) }}" alt="Review Photo" 
                                 class="img-thumbnail w-100" style="height: 100px; object-fit: cover;">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        
        <!-- Videos -->
        @if($review->videos && count($review->videos) > 0)
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Videos</h6>
            </div>
            <div class="card-body">
                @foreach($review->videos as $video)
                <div class="mb-2">
                    <video controls class="w-100" style="max-height: 150px;">
                        <source src="{{ Storage::url($video) }}" type="video/mp4">
                    </video>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const commentTextarea = document.getElementById('comment');
    const charCount = document.getElementById('char-count');
    
    if (commentTextarea && charCount) {
        commentTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
});
</script>
@endsection
