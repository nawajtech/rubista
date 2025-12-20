@extends('layouts.admin')

@section('title', 'Edit CMS Page - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-pencil"></i> Edit CMS Page</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.cms.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to CMS
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Content Page</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.cms.update', $cmsPage->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Page Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $cmsPage->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="slug" class="form-label">URL Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $cmsPage->slug ?? 'about-us') }}">
                        <div class="form-text">Leave empty to auto-generate from title</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15" required>{{ old('content', $cmsPage->content) }}</textarea>
                        <div class="form-text">You can use Markdown formatting in the content area.</div>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="pdf_file" class="form-label">
                            <i class="bi bi-file-pdf"></i> PDF Document
                            <span class="text-muted">(Optional - For Terms & Conditions, Privacy Policy, etc.)</span>
                        </label>
                        <input type="file" class="form-control @error('pdf_file') is-invalid @enderror" 
                               id="pdf_file" name="pdf_file" accept=".pdf,application/pdf">
                        <div class="form-text">
                            Upload a PDF file (Max: 10MB). This is useful for Terms & Conditions, Privacy Policy, Shipping Policy, etc.
                        </div>
                        @error('pdf_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @php
                            $currentPdfUrl = old('pdf_url', $cmsPage->pdf_url);
                        @endphp
                        @if($currentPdfUrl)
                            <div class="mt-2">
                                <div class="alert alert-info d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="bi bi-file-pdf text-danger"></i>
                                        <strong>Current PDF:</strong> 
                                        <a href="{{ $currentPdfUrl }}" target="_blank" class="text-decoration-none">
                                            {{ basename($currentPdfUrl) }}
                                        </a>
                                        <span class="text-muted ms-2">(Click to view/download)</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePdf()">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="remove_pdf" id="remove_pdf" value="0">
                            <input type="hidden" name="pdf_url" value="{{ $currentPdfUrl }}">
                        @endif
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Page Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="1" {{ old('status', $cmsPage->status ? '1' : '0') == '1' ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ old('status', $cmsPage->status ? '1' : '0') == '0' ? 'selected' : '' }}>Draft</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                       value="{{ old('meta_title', $cmsPage->meta_title) }}" placeholder="SEO Title">
                            </div>
                            
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" 
                                          rows="3" placeholder="SEO Description">{{ old('meta_description', $cmsPage->meta_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Page Info</h6>
                        </div>
                        <div class="card-body">
                            <small class="text-muted">
                                <strong>Created:</strong> {{ $cmsPage->created_at->diffForHumans() }}<br>
                                <strong>Last Modified:</strong> {{ $cmsPage->updated_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.cms.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Update Page
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function(e) {
        const title = e.target.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('slug').value = slug;
    });
    
    // Remove PDF function
    function removePdf() {
        if (confirm('Are you sure you want to remove the current PDF file?')) {
            document.getElementById('remove_pdf').value = '1';
            const alertDiv = event.target.closest('.alert');
            if (alertDiv) {
                alertDiv.style.display = 'none';
            }
        }
    }
    
    // Show file name when PDF is selected
    document.getElementById('pdf_file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const fileSize = (file.size / 1024 / 1024).toFixed(2); // Size in MB
            if (file.size > 10 * 1024 * 1024) {
                alert('File size exceeds 10MB. Please choose a smaller file.');
                e.target.value = '';
                return;
            }
            console.log('PDF selected:', file.name, '(' + fileSize + ' MB)');
        }
    });
</script>
@endsection 