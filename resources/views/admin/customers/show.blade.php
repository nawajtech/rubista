@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="bi bi-person"></i> Customer Details
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit Customer
        </a>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Customers
        </a>
    </div>
</div>

<div class="row">
    <!-- Customer Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-circle"></i> Personal Information
                </h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Full Name:</dt>
                    <dd class="col-sm-9">{{ $customer->name }}</dd>
                    
                    <dt class="col-sm-3">Email:</dt>
                    <dd class="col-sm-9">{{ $customer->email }}</dd>
                    
                    <dt class="col-sm-3">Customer ID:</dt>
                    <dd class="col-sm-9">#{{ $customer->id }}</dd>
                    
                    <dt class="col-sm-3">Registration Date:</dt>
                    <dd class="col-sm-9">{{ $customer->created_at->format('M d, Y \a\t h:i A') }}</dd>
                    
                    <dt class="col-sm-3">Last Updated:</dt>
                    <dd class="col-sm-9">{{ $customer->updated_at->format('M d, Y \a\t h:i A') }}</dd>
                </dl>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-bag"></i> Recent Orders
                </h5>
            </div>
            <div class="card-body">
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>{{ $order->orderItems->count() }} items</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_badge }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-bag text-muted" style="font-size: 3rem;"></i>
                        <h6 class="mt-3">No orders yet</h6>
                        <p class="text-muted">This customer hasn't placed any orders.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Customer Stats -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i> Account Summary
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-12 mb-3">
                        <div class="border-bottom pb-2">
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h4 class="mb-0 text-primary">{{ $customer->orders_count }}</h4>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="border-bottom pb-2">
                            <h6 class="text-muted mb-1">Total Spent</h6>
                            <h4 class="mb-0 text-success">₹{{ number_format($totalSpent, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="border-bottom pb-2">
                            <h6 class="text-muted mb-1">Days Since Registration</h6>
                            <h4 class="mb-0 text-info">{{ $customer->created_at->diffInDays(now()) }}</h4>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <small class="text-muted">
                        <strong>Customer ID:</strong> #{{ $customer->id }}<br>
                        <strong>Account Status:</strong> Active<br>
                        <strong>User Type:</strong> Customer
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 