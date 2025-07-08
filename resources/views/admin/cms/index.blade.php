@extends('layouts.admin')

@section('title', 'CMS Pages - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-file-text"></i> CMS Pages</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.cms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Page
        </a>
    </div>
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
                    <!-- Sample data - in real app this would come from database -->
                    <tr>
                        <td><strong>About Us</strong></td>
                        <td><code>about-us</code></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td><small class="text-muted">2 days ago</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.cms.show', 1) }}" class="btn btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.cms.edit', 1) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.cms.destroy', 1) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Privacy Policy</strong></td>
                        <td><code>privacy-policy</code></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td><small class="text-muted">1 week ago</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.cms.show', 2) }}" class="btn btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.cms.edit', 2) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.cms.destroy', 2) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Terms of Service</strong></td>
                        <td><code>terms-of-service</code></td>
                        <td><span class="badge bg-secondary">Draft</span></td>
                        <td><small class="text-muted">3 days ago</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.cms.show', 3) }}" class="btn btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.cms.edit', 3) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.cms.destroy', 3) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
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