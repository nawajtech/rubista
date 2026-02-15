@extends('layouts.admin')

@section('title', 'Edit Banner')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>Edit Banner #{{ $banner->id }}
                    </h5>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            @if($banner->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="Current" class="img-thumbnail" style="max-height: 120px;">
                                    <small class="d-block text-muted">Current image. Upload a new file to replace.</small>
                                </div>
                            @endif
                            <input type="file" name="image" id="image" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to keep current image. JPEG, PNG, JPG, GIF, SVG, WebP. Max 2MB.</small>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="1" {{ old('status', $banner->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $banner->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Update Banner
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
