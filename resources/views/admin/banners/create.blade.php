@extends('layouts.admin')

@section('title', 'Add Banner')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Add Banner</h5>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to List</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="form-text text-muted">JPEG, PNG, JPG, GIF, SVG, WebP. Max 2MB.</small>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Create Banner</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
