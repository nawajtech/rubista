@extends('layouts.admin')

@section('title', 'View CMS Page - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-eye"></i> View CMS Page</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="{{ route('admin.cms.edit', $id) }}" class="btn btn-primary">
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
                <h3 class="mb-0">About Us</h3>
                <div class="mt-2">
                    <span class="badge bg-success">Published</span>
                    <span class="badge bg-secondary">Slug: about-us</span>
                </div>
            </div>
            <div class="card-body">
                <div class="content-preview">
                    <p>Welcome to our About Us page. This is where you can tell your story, share your mission, and connect with your audience.</p>
                    
                    <h2>Our Story</h2>
                    <p>Founded with a passion for excellence, we have been serving our customers with dedication and innovation.</p>
                    
                    <h2>Our Mission</h2>
                    <p>To provide exceptional products and services that exceed our customers' expectations while maintaining the highest standards of quality and integrity.</p>
                    
                    <h2>Our Values</h2>
                    <ul>
                        <li><strong>Quality:</strong> We never compromise on quality</li>
                        <li><strong>Innovation:</strong> We embrace new ideas and technologies</li>
                        <li><strong>Customer Focus:</strong> Our customers are at the heart of everything we do</li>
                        <li><strong>Integrity:</strong> We operate with honesty and transparency</li>
                    </ul>
                </div>
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
                        <td><span class="badge bg-success">Published</span></td>
                    </tr>
                    <tr>
                        <th>URL Slug:</th>
                        <td><code>about-us</code></td>
                    </tr>
                    <tr>
                        <th>Created:</th>
                        <td>2 days ago</td>
                    </tr>
                    <tr>
                        <th>Last Modified:</th>
                        <td>1 hour ago</td>
                    </tr>
                    <tr>
                        <th>Author:</th>
                        <td>Admin User</td>
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
                    <p class="text-muted">About Us - Rubista</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Meta Description:</strong></label>
                    <p class="text-muted">Learn more about our company, mission, and values. Discover what makes us unique and how we serve our customers.</p>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.cms.edit', $id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Page
                    </a>
                    <a href="#" class="btn btn-success" target="_blank">
                        <i class="bi bi-eye"></i> View on Website
                    </a>
                    <form method="POST" action="{{ route('admin.cms.destroy', $id) }}" class="d-inline">
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