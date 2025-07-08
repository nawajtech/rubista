@extends('layouts.admin')

@section('title', 'Customers - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-people"></i> Customers</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Customer
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $totalCustomers }}</h5>
                <p class="card-text text-muted">Total Customers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $activeCustomers }}</h5>
                <p class="card-text text-muted">Active Customers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $newCustomers }}</h5>
                <p class="card-text text-muted">New This Month</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $totalCustomers - $activeCustomers }}</h5>
                <p class="card-text text-muted">Inactive Customers</p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.customers.index') }}">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search customers by name or email..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                        <a href="#" class="btn btn-success">
                            <i class="bi bi-download"></i> Export CSV
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Customers Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Customers</h5>
    </div>
    <div class="card-body">
        @if($customers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Orders</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $customer->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $customer->orders_count }}</span>
                            </td>
                            <td>{{ $customer->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
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
            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3">No customers found</h5>
                <p class="text-muted">No customers match your search criteria.</p>
            </div>
        @endif
    </div>
</div>
@endsection 