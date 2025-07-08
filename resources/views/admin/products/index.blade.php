@extends('layouts.admin')

@section('title', 'Products - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add New Product
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($products->count() > 0)
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Tip:</strong> You can drag and drop products to reorder them. Click and hold the drag handle <i class="bi bi-grip-vertical"></i> to move items.
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="40">Order</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-products">
                        @foreach($products as $product)
                        <tr data-id="{{ $product->id }}">
                            <td class="text-center">
                                <span class="drag-handle" style="cursor: move;">
                                    <i class="bi bi-grip-vertical text-muted"></i>
                                </span>
                            </td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                         class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $product->name }}</strong>
                                    @if($product->featured)
                                        <span class="badge bg-warning text-dark ms-1">Featured</span>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ $product->sku }}</small>
                                </div>
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>
                                @if($product->is_on_sale)
                                    <span class="text-muted text-decoration-line-through">${{ $product->price }}</span>
                                    <span class="fw-bold text-success">${{ $product->sale_price }}</span>
                                @else
                                    <span class="fw-bold">${{ $product->price }}</span>
                                @endif
                            </td>
                            <td>
                                @if($product->stock_quantity > 0)
                                    <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                            <td>
                                @if($product->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="btn btn-sm btn-outline-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" 
                                          class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-box display-1 text-muted"></i>
                <h3 class="mt-3">No products found</h3>
                <p class="text-muted">Create your first product to get started.</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add New Product
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Loading overlay -->
<div id="loading-overlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" 
     style="background-color: rgba(0,0,0,0.5); z-index: 9999;">
    <div class="position-absolute top-50 start-50 translate-middle text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="text-white mt-2">Updating order...</div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Dragula CSS -->
<link href="https://cdn.jsdelivr.net/npm/dragula@3.7.3/dist/dragula.min.css" rel="stylesheet">
<!-- Dragula JS -->
<script src="https://cdn.jsdelivr.net/npm/dragula@3.7.3/dist/dragula.min.js"></script>

<style>
    .gu-mirror {
        position: fixed !important;
        margin: 0 !important;
        z-index: 9999 !important;
        opacity: 0.8;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .gu-hide {
        display: none !important;
    }

    .gu-unselectable {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
    }

    .gu-transit {
        opacity: 0.2;
    }

    .drag-handle:hover {
        color: #007bff !important;
    }

    .dragging {
        background-color: #f8f9fa !important;
    }

    .drop-target {
        background-color: #e3f2fd !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('sortable-products');
    const loadingOverlay = document.getElementById('loading-overlay');
    
    if (!container) return;
    
    // Initialize Dragula
    const drake = dragula([container], {
        moves: function(el, container, handle) {
            return handle.classList.contains('drag-handle') || handle.parentNode.classList.contains('drag-handle');
        },
        accepts: function(el, target) {
            return target === container;
        }
    });

    // Handle drag events
    drake.on('drag', function(el) {
        el.classList.add('dragging');
    });

    drake.on('dragend', function(el) {
        el.classList.remove('dragging');
    });

    drake.on('over', function(el, container) {
        container.classList.add('drop-target');
    });

    drake.on('out', function(el, container) {
        container.classList.remove('drop-target');
    });

    // Handle drop event
    drake.on('drop', function(el, target, source, sibling) {
        // Show loading overlay
        loadingOverlay.classList.remove('d-none');
        
        // Get all rows and build sort order data
        const rows = Array.from(container.querySelectorAll('tr[data-id]'));
        const products = rows.map((row, index) => ({
            id: parseInt(row.dataset.id),
            sort_order: index
        }));

        // Send AJAX request to update sort order
        fetch('{{ route('admin.products.update-sort-order') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ products: products })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showToast('success', data.message);
            } else {
                // Show error message
                showToast('error', 'Failed to update sort order');
                // Revert the change
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'An error occurred while updating sort order');
            // Revert the change
            location.reload();
        })
        .finally(() => {
            // Hide loading overlay
            loadingOverlay.classList.add('d-none');
        });
    });

    // Toast notification function
    function showToast(type, message) {
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0 position-fixed top-0 end-0 m-3" 
                 style="z-index: 10000" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', toastHtml);
        const toast = document.querySelector('.toast:last-child');
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove toast element after it's hidden
        toast.addEventListener('hidden.bs.toast', function() {
            toast.remove();
        });
    }
});
</script>
@endsection 