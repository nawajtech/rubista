@extends('layouts.admin')

@section('title', 'CMS Pages - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-file-text"></i> CMS Pages</h1>
    <!-- <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.cms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Page
        </a>
    </div> -->
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Content Pages</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                    <tr>
                        <td><strong>{{ $page->title }}</strong></td>
                        <td><code>{{ $page->slug }}</code></td>
                        <td>
                            @if($page->status)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $page->created_at->diffForHumans() }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.cms.show', $page->id) }}" class="btn btn-outline-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.cms.edit', $page->id) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox"></i> No CMS pages found. Create your first page to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted">
                <i class="bi bi-info-circle"></i> Manage your website content pages, legal documents, and static content here.
            </p>
        </div>
    </div>
</div>
@endsection 