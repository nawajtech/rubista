@extends('layouts.admin')

@section('title', 'Add New Category - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Category</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Categories
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">The category name will be used to generate the URL slug automatically.</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Upload an image for the category (JPG, PNG, GIF - Max: 2MB)</div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                                   {{ old('status', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">
                                Active Status
                            </label>
                        </div>
                        <div class="form-text">Uncheck to hide this category from the frontend.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Create Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Guidelines</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Use clear, descriptive names</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Add relevant descriptions</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Upload high-quality images</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Keep categories organized</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 