@extends('layouts.admin')

@section('title', 'Edit Customer')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-person-gear"></i> Edit Customer</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-info me-2">
            <i class="bi bi-eye"></i> View Customer
        </a>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Customers
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Customer Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $customer->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $customer->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control">
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Update Customer
                        </button>
                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Customer Details</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">ID:</dt>
                    <dd class="col-sm-8">{{ $customer->id }}</dd>
                    
                    <dt class="col-sm-4">Registered:</dt>
                    <dd class="col-sm-8">{{ $customer->created_at->format('M d, Y') }}</dd>
                    
                    <dt class="col-sm-4">Last Updated:</dt>
                    <dd class="col-sm-8">{{ $customer->updated_at->format('M d, Y') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection 