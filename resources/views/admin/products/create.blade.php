@extends('layouts.admin')

@section('title', 'Add New Product - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Product</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" name="short_description" rows="3" 
                                  placeholder="Brief description for product listings...">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Full Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="6" 
                                  placeholder="Detailed product description...">{{ old('description') }}</textarea>
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
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                       id="price" name="price" value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sale_price" class="form-label">Sale Price ($)</label>
                                <input type="number" step="0.01" min="0" class="form-control @error('sale_price') is-invalid @enderror" 
                                       id="sale_price" name="sale_price" value="{{ old('sale_price') }}" 
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
                               id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required>
                        @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                       id="brand" name="brand" value="{{ old('brand') }}" 
                                       placeholder="e.g., Samsung, Apple, Sony">
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                       id="model" name="model" value="{{ old('model') }}" 
                                       placeholder="e.g., iPhone 15 Pro, Galaxy S24">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                       id="color" name="color" value="{{ old('color') }}" 
                                       placeholder="e.g., Black, White, Red">
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dimension" class="form-label">Dimension</label>
                                <input type="text" class="form-control @error('dimension') is-invalid @enderror" 
                                       id="dimension" name="dimension" value="{{ old('dimension') }}" 
                                       placeholder="e.g., 10 x 5 x 2 inches">
                                @error('dimension')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="warranty_period" class="form-label">Warranty Period</label>
                        <input type="text" class="form-control @error('warranty_period') is-invalid @enderror" 
                               id="warranty_period" name="warranty_period" value="{{ old('warranty_period') }}" 
                               placeholder="e.g., 1 Year, 2 Years, 6 Months">
                        @error('warranty_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="return_policy" class="form-label">Return Policy</label>
                        <textarea class="form-control @error('return_policy') is-invalid @enderror" 
                                  id="return_policy" name="return_policy" rows="3" 
                                  placeholder="Describe the return policy for this product...">{{ old('return_policy') }}</textarea>
                        @error('return_policy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Main Product Image *</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Upload a high-quality main image (JPEG, PNG, GIF). Max size: 2MB</div>
                        
                        <!-- Image Preview -->
                        <div id="image-preview" class="mt-3" style="display: none;">
                            <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="gallery_images" class="form-label">Gallery Images (Multiple)</label>
                        <input type="file" class="form-control @error('gallery_images.*') is-invalid @enderror" 
                               id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                        @error('gallery_images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Upload multiple images for product gallery (JPEG, PNG, GIF). Max size: 2MB per image</div>
                        
                        <!-- Gallery Preview -->
                        <div id="gallery-preview" class="mt-3 row g-2" style="display: none;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                                   {{ old('status', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">
                                <strong>Active Status</strong>
                            </label>
                            <div class="form-text">Product will be visible on the website</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" 
                                   {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                <strong>Featured Product</strong>
                            </label>
                            <div class="form-text">Featured products appear in special sections</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Guidelines</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Use descriptive names</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Add detailed descriptions</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Set accurate pricing</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Upload quality images</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Track inventory levels</li>
                    <li class="mb-2"><i class="bi bi-info-circle text-info"></i> SKU will be auto-generated</li>
                </ul>
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
    // Main image preview functionality
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

    // Gallery images preview functionality
    const galleryInput = document.getElementById('gallery_images');
    const galleryPreview = document.getElementById('gallery-preview');

    galleryInput.addEventListener('change', function(e) {
        const files = e.target.files;
        galleryPreview.innerHTML = '';
        
        if (files.length > 0) {
            galleryPreview.style.display = 'block';
            
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3';
                    col.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" alt="Gallery ${index + 1}" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                        </div>
                    `;
                    galleryPreview.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        } else {
            galleryPreview.style.display = 'none';
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