@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Product Image -->
            <div class="card">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}"
                         style="height: 400px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/400x400/f8f9fa/6c757d?text={{ urlencode($product->name) }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}"
                         style="height: 400px; object-fit: cover;">
                @endif
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Product Details -->
            <div class="mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.catalog') }}">Products</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a></li>
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>

            <h1 class="h2">{{ $product->name }}</h1>
            
            <p class="text-muted mb-2">Category: {{ $product->category->name }}</p>
            
            <div class="mb-3">
                <span class="h3 text-success">${{ number_format($product->price, 2) }}</span>
                @if($product->featured)
                    <span class="badge badge-warning ml-2">Featured</span>
                @endif
            </div>

            <!-- Stock Status -->
            <div class="mb-3">
                @if($product->stock > 0)
                    <span class="badge badge-success">In Stock ({{ $product->stock }} available)</span>
                @else
                    <span class="badge badge-danger">Out of Stock</span>
                @endif
            </div>

            <!-- Product Description -->
            <div class="mb-4">
                <h5>Description</h5>
                <div class="product-description">
                    {!! $product->description !!}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mb-4">
                @auth
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                            @csrf
                            <div class="d-flex align-items-center mb-3">
                                <label for="quantity" class="mr-2">Quantity:</label>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity"
                                       class="form-control" 
                                       style="width: 80px;" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}"
                                       required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg mr-2">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </form>
                        
                        <form action="{{ route('product.buy-now', $product) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="quantity" id="buy-now-quantity" value="1">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-bolt"></i> Buy Now
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-times"></i> Out of Stock
                        </button>
                    @endif
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Please <a href="{{ route('login') }}">login</a> to purchase this item.
                    </div>
                @endauth
            </div>

            <!-- Additional Product Info -->
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">
                        <i class="fas fa-truck"></i> 
                        Free delivery on orders over $50
                    </small>
                </div>
                <div class="col-6">
                    <small class="text-muted">
                        <i class="fas fa-undo"></i> 
                        30-day return policy
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3>Related Products</h3>
            <div class="row">
                @foreach($product->category->products->where('id', '!=', $product->id)->take(4) as $relatedProduct)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        @if($relatedProduct->image)
                            <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $relatedProduct->name }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200/f8f9fa/6c757d?text={{ urlencode($relatedProduct->name) }}" 
                                 class="card-img-top" 
                                 alt="{{ $relatedProduct->name }}"
                                 style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                            <p class="card-text">${{ number_format($relatedProduct->price, 2) }}</p>
                            <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-sm btn-outline-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
// Sync quantity for buy now button
document.getElementById('quantity').addEventListener('input', function() {
    document.getElementById('buy-now-quantity').value = this.value;
});
</script>
@endsection