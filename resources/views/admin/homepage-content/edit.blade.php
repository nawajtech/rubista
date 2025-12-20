@extends('layouts.admin')

@section('title', 'Edit Homepage Content')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>Edit Homepage Content
                    </h5>
                    <a href="{{ route('admin.homepage-content.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.homepage-content.update', $homepageContent) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="section_type" class="form-label">Section Type <span class="text-danger">*</span></label>
                                    <select name="section_type" id="section_type" class="form-select @error('section_type') is-invalid @enderror" required>
                                        <option value="">Select Section Type</option>
                                        @foreach($sectionTypes as $key => $value)
                                            @php
                                                $sectionType = old('section_type');
                                                if ($sectionType === null) {
                                                    $sectionType = $homepageContent->section_type ?? '';
                                                }
                                                $sectionType = is_array($sectionType) ? '' : (string)$sectionType;
                                            @endphp
                                            <option value="{{ $key }}" {{ $sectionType == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('section_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order <span class="text-danger">*</span></label>
                                    @php
                                        $sortOrder = old('sort_order');
                                        if ($sortOrder === null) {
                                            $sortOrder = $homepageContent->sort_order ?? 0;
                                        }
                                        $sortOrder = is_array($sortOrder) ? 0 : (int)$sortOrder;
                                    @endphp
                                    <input type="number" name="sort_order" id="sort_order" 
                                           class="form-control @error('sort_order') is-invalid @enderror" 
                                           value="{{ $sortOrder }}" min="0" required>
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            @php
                                $title = old('title');
                                if ($title === null) {
                                    $title = $homepageContent->title ?? '';
                                }
                                $title = is_array($title) ? '' : (string)$title;
                            @endphp
                            <input type="text" name="title" id="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ $title }}" placeholder="Enter section title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle</label>
                            @php
                                $subtitle = old('subtitle');
                                if ($subtitle === null) {
                                    $subtitle = $homepageContent->subtitle ?? '';
                                }
                                $subtitle = is_array($subtitle) ? '' : (string)$subtitle;
                            @endphp
                            <input type="text" name="subtitle" id="subtitle" 
                                   class="form-control @error('subtitle') is-invalid @enderror" 
                                   value="{{ $subtitle }}" placeholder="Enter section subtitle">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            @php
                                $description = old('description');
                                if ($description === null) {
                                    $description = $homepageContent->description ?? '';
                                }
                                $description = is_array($description) ? '' : (string)$description;
                            @endphp
                            <textarea name="description" id="description" rows="4" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Enter section description">{{ $description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            @php
                                $imageUrl = $homepageContent->image_url ?? null;
                                $imageUrl = is_array($imageUrl) ? null : $imageUrl;
                            @endphp
                            @if($imageUrl)
                                <div class="mb-2">
                                    <img src="{{ $imageUrl }}" alt="Current Image" 
                                         class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <p class="text-muted mt-1">Current Image</p>
                                </div>
                            @endif
                            <input type="file" name="image" id="image" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB. Leave empty to keep current image.
                            </small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_text" class="form-label">Button Text</label>
                                    @php
                                        $buttonText = old('button_text');
                                        if ($buttonText === null) {
                                            $buttonText = $homepageContent->button_text ?? '';
                                        }
                                        $buttonText = is_array($buttonText) ? '' : (string)$buttonText;
                                    @endphp
                                    <input type="text" name="button_text" id="button_text" 
                                           class="form-control @error('button_text') is-invalid @enderror" 
                                           value="{{ $buttonText }}" placeholder="e.g., Shop Now, Learn More">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_url" class="form-label">Button URL</label>
                                    @php
                                        $buttonUrl = old('button_url');
                                        if ($buttonUrl === null) {
                                            $buttonUrl = $homepageContent->button_url ?? '';
                                        }
                                        $buttonUrl = is_array($buttonUrl) ? '' : (string)$buttonUrl;
                                    @endphp
                                    <input type="url" name="button_url" id="button_url" 
                                           class="form-control @error('button_url') is-invalid @enderror" 
                                           value="{{ $buttonUrl }}" placeholder="https://example.com">
                                    @error('button_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        {{-- <div class="mb-3">
                            <h6>Extra Fields (Optional)</h6>
                            <div id="extra-fields-container">
                                @if($homepageContent->extra_data && count($homepageContent->extra_data) > 0)
                                    @foreach($homepageContent->extra_data as $key => $value)
                                    <div class="row extra-field-row {{ $loop->index > 0 ? 'mt-2' : '' }}">
                                        <div class="col-md-5">
                                            <input type="text" name="extra_field_keys[]" class="form-control" placeholder="Field name" value="{{ is_array($key) ? '' : $key }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="extra_field_values[]" class="form-control" placeholder="Field value" value="{{ is_array($value) ? json_encode($value) : $value }}">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm remove-field">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="row extra-field-row">
                                        <div class="col-md-5">
                                            <input type="text" name="extra_field_keys[]" class="form-control" placeholder="Field name (e.g., color, price)">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="extra_field_values[]" class="form-control" placeholder="Field value">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm remove-field">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-extra-field">
                                <i class="bi bi-plus-lg"></i> Add Extra Field
                            </button>
                        </div> --}}
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="is_active" value="0">
                                    @php
                                        $isActive = old('is_active');
                                        if ($isActive === null) {
                                            $isActive = $homepageContent->is_active ?? false;
                                        }
                                        $isActive = is_array($isActive) ? false : (bool)$isActive;
                                    @endphp
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" 
                                       value="1" {{ $isActive ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (visible on homepage)
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-floppy"></i> Update Content
                            </button>
                            <a href="{{ route('admin.homepage-content.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview
        const imageInput = document.getElementById('image');
        const imagePreview = document.createElement('div');
        imagePreview.className = 'mt-2';
        imageInput.parentNode.insertBefore(imagePreview, imageInput.nextSibling);
        
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" 
                             class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        <p class="text-muted mt-1">New Image Preview</p>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.innerHTML = '';
            }
        });
        
        // Extra fields management
        const container = document.getElementById('extra-fields-container');
        const addButton = document.getElementById('add-extra-field');
        
        addButton.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'row extra-field-row mt-2';
            newRow.innerHTML = `
                <div class="col-md-5">
                    <input type="text" name="extra_field_keys[]" class="form-control" placeholder="Field name (e.g., color, price)">
                </div>
                <div class="col-md-6">
                    <input type="text" name="extra_field_values[]" class="form-control" placeholder="Field value">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-field">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
        });
        
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-field') || e.target.closest('.remove-field')) {
                const row = e.target.closest('.extra-field-row');
                if (container.children.length > 1) {
                    row.remove();
                }
            }
        });
        
        // Form submission handling
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const keys = document.querySelectorAll('input[name="extra_field_keys[]"]');
            const values = document.querySelectorAll('input[name="extra_field_values[]"]');
            
            // Create proper extra_fields object
            const extraFields = {};
            keys.forEach((key, index) => {
                if (key.value.trim() && values[index].value.trim()) {
                    extraFields[key.value.trim()] = values[index].value.trim();
                }
            });
            
            // Remove original fields and add processed data
            keys.forEach(field => field.remove());
            values.forEach(field => field.remove());
            
            // Add processed extra fields
            Object.keys(extraFields).forEach(key => {
                const hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.name = `extra_fields[${key}]`;
                hiddenField.value = extraFields[key];
                form.appendChild(hiddenField);
            });
        });
    });
</script>
@endsection 