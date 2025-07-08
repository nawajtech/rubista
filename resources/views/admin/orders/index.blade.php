@extends('layouts.admin')

@section('title', 'Orders - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-bag"></i> Orders</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="#" class="btn btn-success">
            <i class="bi bi-download"></i> Export Orders
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $totalOrders }}</h5>
                <p class="card-text text-muted">Total Orders</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $pendingOrders }}</h5>
                <p class="card-text text-muted">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $processingOrders }}</h5>
                <p class="card-text text-muted">Processing</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $shippedOrders }}</h5>
                <p class="card-text text-muted">Shipped</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $deliveredOrders }}</h5>
                <p class="card-text text-muted">Delivered</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">₹{{ number_format($totalRevenue, 0) }}</h5>
                <p class="card-text text-muted">Revenue</p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search orders..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="payment_status" class="form-select">
                        <option value="">All Payment Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Orders</h5>
    </div>
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>
                                <div>
                                    <div class="fw-bold">{{ $order->user->name }}</div>
                                    <small class="text-muted">{{ $order->billing_email }}</small>
                                </div>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status_badge }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_status_badge }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>₹{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($order->status === 'cancelled')
                                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-bag text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3">No orders found</h5>
                <p class="text-muted">No orders match your search criteria.</p>
            </div>
        @endif
    </div>
</div>
@endsection 