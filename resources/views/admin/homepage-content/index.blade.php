@extends('layouts.admin')

@section('title', 'Homepage Content Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-house-gear me-2"></i>Homepage Content Management
                    </h5>
                    <!-- <a href="{{ route('admin.homepage-content.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Add New Content
                    </a> -->
                </div>
                <div class="card-body">
                    @if($contents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Section Type</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contents as $content)
                                    <tr>
                                        <td>
                                            @if($content->image_url)
                                                <img src="{{ $content->image_url }}" 
                                                     alt="{{ $content->title }}" 
                                                     class="img-thumbnail" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 60px; border-radius: 4px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($content->section_type) }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $content->title ?? 'No Title' }}</strong>
                                            @if($content->subtitle)
                                                <br><small class="text-muted">{{ Str::limit($content->subtitle, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($content->description)
                                                {{ Str::limit($content->description, 100) }}
                                            @else
                                                <span class="text-muted">No description</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $content->sort_order }}</span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.homepage-content.toggle-status', $content) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $content->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                    {{ $content->is_active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Content actions">
                                                <!-- <a href="{{ route('admin.homepage-content.show', $content) }}" 
                                                   class="btn btn-sm btn-outline-info" 
                                                   title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a> -->
                                                <a href="{{ route('admin.homepage-content.edit', $content) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <!-- <form method="POST" action="{{ route('admin.homepage-content.destroy', $content) }}" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this content?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form> -->
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $contents->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-house-gear display-1 text-muted mb-3"></i>
                            <h4>No Homepage Content Found</h4>
                            <p class="text-muted">Start by adding your first homepage content section.</p>
                            <a href="{{ route('admin.homepage-content.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg"></i> Add Content
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
    // Auto-refresh status after toggle
    document.addEventListener('DOMContentLoaded', function() {
        const statusForms = document.querySelectorAll('form[action*="toggle-status"]');
        statusForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const button = this.querySelector('button[type="submit"]');
                const originalText = button.textContent.trim();
                const originalClass = button.className;
                
                button.textContent = 'Updating...';
                button.disabled = true;
                button.className = 'btn btn-sm btn-secondary';
                
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        '_method': 'PATCH',
                        '_token': this.querySelector('input[name="_token"]').value
                    })
                })
                .then(response => {
                    if (response.ok) {
                        // Toggle the button state
                        if (originalText === 'Active') {
                            button.textContent = 'Inactive';
                            button.className = 'btn btn-sm btn-secondary';
                        } else {
                            button.textContent = 'Active';
                            button.className = 'btn btn-sm btn-success';
                        }
                        button.disabled = false;
                        
                        // Show success message
                        showAlert('Status updated successfully!', 'success');
                    } else {
                        throw new Error('Failed to update status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    button.textContent = originalText;
                    button.className = originalClass;
                    button.disabled = false;
                    showAlert('Failed to update status. Please try again.', 'error');
                });
            });
        });
    });
    
    // Show alert function
    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
</script>
@endsection

@section('extra-css')
<style>
    .table td {
        vertical-align: middle;
    }
    
    .table .btn-group {
        white-space: nowrap;
    }
    
    .table .btn-group .btn {
        border-radius: 0;
    }
    
    .table .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    
    .table .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
        
        .btn-group .btn i {
            font-size: 0.875rem;
        }
    }
    
    .alert {
        margin-bottom: 1rem;
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection 