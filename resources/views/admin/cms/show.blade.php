@extends('layouts.admin')

@section('title', 'View CMS Page - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-eye"></i> View CMS Page</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="{{ route('admin.cms.edit', $page->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit Page
            </a>
            <a href="{{ route('admin.cms.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to CMS
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">{{ $page->title }}</h3>
                <div class="mt-2">
                    @if($page->status)
                        <span class="badge bg-success">Published</span>
                    @else
                        <span class="badge bg-secondary">Draft</span>
                    @endif
                    <span class="badge bg-secondary">Slug: {{ $page->slug }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="content-preview">
                    {!! nl2br(e($page->content)) !!}
                </div>
                @if($page->pdf_url)
                <div class="mt-3">
                    <a href="{{ $page->pdf_url }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> View PDF Document
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Page Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($page->status)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>URL Slug:</th>
                        <td><code>{{ $page->slug }}</code></td>
                    </tr>
                    <tr>
                        <th>Created:</th>
                        <td>{{ $page->created_at->diffForHumans() }}</td>
                    </tr>
                    <tr>
                        <th>Last Modified:</th>
                        <td>{{ $page->updated_at->diffForHumans() }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">SEO Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Meta Title:</strong></label>
                    <p class="text-muted">{{ $page->meta_title ?? 'N/A' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Meta Description:</strong></label>
                    <p class="text-muted">{{ $page->meta_description ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.cms.edit', $page->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Page
                    </a>
                    <a href="{{ route('frontend.cms.page', $page->slug) }}" class="btn btn-success" target="_blank">
                        <i class="bi bi-eye"></i> View on Website
                    </a>
                    <form method="POST" action="{{ route('admin.cms.destroy', $page->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this page?')">
                            <i class="bi bi-trash"></i> Delete Page
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 