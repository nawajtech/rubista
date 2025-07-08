@extends('frontend.layouts.frontend')

@section('title', 'Category Products')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Category Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">Mobile Phones</a>
                <a href="#" class="list-group-item list-group-item-action">Smart Watches</a>
                <a href="#" class="list-group-item list-group-item-action">Power Banks</a>
                <a href="#" class="list-group-item list-group-item-action">Headphones</a>
                <a href="#" class="list-group-item list-group-item-action">Chargers</a>
            </div>
        </div>
        <!-- Product Grid -->
        <div class="col-md-9">
            <h2 class="mb-4">Mobile Phones</h2>
            <div class="row">
                @for($i = 0; $i < 8; $i++)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/200x200?text=Product" class="card-img-top" alt="Product Image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Product Name {{ $i+1 }}</h5>
                            <p class="card-text mb-2">₹1,099 <span class="text-muted text-decoration-line-through">₹1,499</span></p>
                            <a href="#" class="btn btn-primary mt-auto">Buy Now</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection 