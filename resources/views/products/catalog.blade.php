@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Product Catalog</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <h5>Filter by Category</h5>
            <div class="list-group">
                <a href="{{ route('products.catalog') }}" class="list-group-item">All Products</a>
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" class="list-group-item">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ $product->price }}</p>
                            <p class="text-muted">{{ $product->category->name }}</p>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection