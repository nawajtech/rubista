@extends('layouts.admin')

@section('title', 'Edit Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="bi bi-pencil"></i> Edit Order #{{ $order->order_number }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info">
            <i class="bi bi-eye"></i> View Order
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Order Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Order Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending" {{ old('status', $order->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ old('status', $order->status) === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ old('status', $order->status) === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ old('status', $order->status) === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ old('status', $order->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                                <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                    <option value="pending" {{ old('payment_status', $order->payment_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ old('payment_status', $order->payment_status) === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ old('payment_status', $order->payment_status) === 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ old('payment_status', $order->payment_status) === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tracking_number" class="form-label">Tracking Number</label>
                        <input type="text" name="tracking_number" id="tracking_number" 
                               class="form-control @error('tracking_number') is-invalid @enderror" 
                               value="{{ old('tracking_number', $order->tracking_number) }}">
                        @error('tracking_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" rows="4" 
                                  class="form-control @error('admin_notes') is-invalid @enderror">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Update Order
                        </button>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">
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
                <h5 class="mb-0">Order Details</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-5">Order #:</dt>
                    <dd class="col-sm-7">{{ $order->order_number }}</dd>
                    
                    <dt class="col-sm-5">Customer:</dt>
                    <dd class="col-sm-7">{{ $order->user->name }}</dd>
                    
                    <dt class="col-sm-5">Date:</dt>
                    <dd class="col-sm-7">{{ $order->created_at->format('M d, Y') }}</dd>
                    
                    <dt class="col-sm-5">Total:</dt>
                    <dd class="col-sm-7">₹{{ number_format($order->total_amount, 2) }}</dd>
                    
                    <dt class="col-sm-5">Items:</dt>
                    <dd class="col-sm-7">{{ $order->orderItems->count() }}</dd>
                </dl>
                
                <hr>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    <strong>Note:</strong> Status changes will automatically update timestamps for shipped and delivered orders.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 