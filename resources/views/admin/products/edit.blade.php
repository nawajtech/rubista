@extends('layouts.admin')

@section('title', 'Edit Product - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Product: {{ $product->name }}</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $product->name) }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" name="short_description" rows="3" 
                                  placeholder="Brief description for product listings...">{{ old('short_description', $product->short_description) }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Full Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="6" 
                                  placeholder="Detailed product description...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category *</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Regular Price ($) *</label>
                                <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sale_price" class="form-label">Sale Price ($)</label>
                                <input type="number" step="0.01" min="0" class="form-control @error('sale_price') is-invalid @enderror" 
                                       id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" 
                                       placeholder="Optional sale price">
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave empty if not on sale</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                        <input type="number" min="0" class="form-control @error('stock_quantity') is-invalid @enderror" 
                               id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                        @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Upload a new image to replace the current one (JPEG, PNG, GIF). Max size: 2MB</div>
                        
                        <!-- Current Image -->
                        @if($product->image)
                            <div class="mt-3">
                                <label class="form-label">Current Image:</label>
                                <div class="current-image-container">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="img-thumbnail" 
                                         style="max-height: 200px;">
                                </div>
                            </div>
                        @endif
                        
                        <!-- New Image Preview -->
                        <div id="image-preview" class="mt-3" style="display: none;">
                            <label class="form-label">New Image Preview:</label>
                            <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                                   {{ old('status', $product->status) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">
                                <strong>Active Status</strong>
                            </label>
                            <div class="form-text">Product will be visible on the website</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" 
                                   {{ old('featured', $product->featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                <strong>Featured Product</strong>
                            </label>
                            <div class="form-text">Featured products appear in special sections</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Info</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <p><strong>SKU:</strong><br>{{ $product->sku }}</p>
                    </div>
                    <div class="col-6">
                        <p><strong>Category:</strong><br>{{ $product->category->name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p><strong>Created:</strong><br>{{ $product->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="col-6">
                        <p><strong>Updated:</strong><br>{{ $product->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p><strong>Status:</strong><br>
                            @if($product->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-6">
                        <p><strong>Featured:</strong><br>
                            @if($product->featured)
                                <span class="badge bg-warning text-dark">Yes</span>
                            @else
                                <span class="badge bg-light text-dark">No</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-info">
                        <i class="bi bi-eye"></i> View Product
                    </a>
                    <a href="{{ route('frontend.product.detail', $product->id) }}" class="btn btn-outline-success" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> View on Site
                    </a>
                    <a href="{{ route('admin.categories.show', $product->category) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-tags"></i> View Category
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Image Requirements</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="bi bi-image text-primary"></i> <strong>Format:</strong> JPEG, PNG, GIF</li>
                    <li class="mb-2"><i class="bi bi-file-earmark text-primary"></i> <strong>Size:</strong> Max 2MB</li>
                    <li class="mb-2"><i class="bi bi-aspect-ratio text-primary"></i> <strong>Dimensions:</strong> 800x800px recommended</li>
                    <li class="mb-2"><i class="bi bi-brightness-high text-primary"></i> <strong>Quality:</strong> High resolution</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });

    // Sale price validation
    const priceInput = document.getElementById('price');
    const salePriceInput = document.getElementById('sale_price');

    salePriceInput.addEventListener('blur', function() {
        const price = parseFloat(priceInput.value);
        const salePrice = parseFloat(salePriceInput.value);

        if (salePrice && price && salePrice >= price) {
            salePriceInput.setCustomValidity('Sale price must be less than regular price');
        } else {
            salePriceInput.setCustomValidity('');
        }
    });

    priceInput.addEventListener('blur', function() {
        salePriceInput.dispatchEvent(new Event('blur'));
    });
});
</script>
@endsection 