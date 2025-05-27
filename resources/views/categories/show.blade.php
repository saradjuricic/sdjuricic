@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.catalog') }}">Products</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </nav>

            <h1>{{ $category->name }}</h1>
            @if($category->description)
                <p class="lead">{{ $category->description }}</p>
            @endif
        </div>
    </div>

    <div class="row">
        @forelse($category->products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}"
                         style="height: 250px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/300x250/f8f9fa/6c757d?text={{ urlencode($product->name) }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}"
                         style="height: 250px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">${{ number_format($product->price, 2) }}</p>
                    @if($product->stock > 0)
                        <span class="badge badge-success mb-2">In Stock</span>
                    @else
                        <span class="badge badge-danger mb-2">Out of Stock</span>
                    @endif
                    <br>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                <h4>No products found</h4>
                <p>There are currently no products in the {{ $category->name }} category.</p>
                <a href="{{ route('products.catalog') }}" class="btn btn-primary">Browse All Products</a>
            </div>
        </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="{{ route('products.catalog') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to All Products
            </a>
        </div>
    </div>
</div>
@endsection