@extends('layouts.admin')

@section('title', 'Banner Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-image me-2"></i>Banner Management</h5>
                    <div class="d-flex gap-2">
                        @if(request('trashed'))
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary"><i class="bi bi-archive"></i> View Active</a>
                        @else
                        <a href="{{ route('admin.banners.index', ['trashed' => 1]) }}" class="btn btn-outline-secondary"><i class="bi bi-trash"></i> View Deleted</a>
                        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Banner</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                    @endif
                    @if($banners->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Status</th>
                                @if(request('trashed'))<th>Deleted At</th>@endif
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
                                <td>
                                    @if($banner->image)
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner" class="img-thumbnail" style="width: 80px; height: 50px; object-fit: cover;">
                                    @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 50px;"><i class="bi bi-image text-muted"></i></div>
                                    @endif
                                </td>
                                <td>
                                    @if(!request('trashed'))
                                    <span class="badge {{ $banner->status ? 'bg-success' : 'bg-secondary' }}">{{ $banner->status ? 'Active' : 'Inactive' }}</span>
                                    @else
                                    <span class="badge bg-secondary">—</span>
                                    @endif
                                </td>
                                @if(request('trashed'))
                                <td>{{ $banner->deleted_at ? $banner->deleted_at->format('M d, Y H:i') : '' }}</td>
                                @endif
                                <td>
                                    @if(request('trashed'))
                                    <form method="POST" action="{{ route('admin.banners.restore', $banner->id) }}" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-counterclockwise"></i> Restore</button></form>
                                    <form method="POST" action="{{ route('admin.banners.force-destroy', $banner->id) }}" class="d-inline" onsubmit="return confirm('Permanently delete?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button></form>
                                    @else
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" class="d-inline" onsubmit="return confirm('Move to trash?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">{{ $banners->withQueryString()->links() }}</div>
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-image display-1 text-muted mb-3"></i>
                        <h4>No Banners Found</h4>
                        <p class="text-muted">{{ request('trashed') ? 'No deleted banners.' : 'Add your first banner.' }}</p>
                        @if(!request('trashed'))<a href="{{ route('admin.banners.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Banner</a>@endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
