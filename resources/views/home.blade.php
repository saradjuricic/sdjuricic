@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6">
                <h1 class="display-4 font-weight-bold mb-4">Welcome to Blossom Boutique</h1>
                <p class="lead mb-4">Your premier destination for beautiful flowers, stunning plants, and elegant arrangements that bring nature's beauty into your life.</p>
                <div class="hero-buttons">
                    <a href="{{ route('products.catalog') }}" class="btn btn-light btn-lg mr-3 shadow">
                        <i class="fas fa-leaf mr-2"></i>Shop Now
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone mr-2"></i>Contact Us
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=500&h=400&fit=crop&crop=center" 
                         alt="Beautiful flowers" class="img-fluid rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="features-section py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="feature-card h-100">
                    <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-shipping-fast fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold">Same Day Delivery</h5>
                    <p class="text-muted">Order before 2 PM for same-day delivery in Belgrade area</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card h-100">
                    <div class="feature-icon bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-seedling fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold">Fresh & Quality</h5>
                    <p class="text-muted">Hand-picked flowers and plants, guaranteed fresh for 7 days</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card h-100">
                    <div class="feature-icon bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="fas fa-palette fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold">Custom Arrangements</h5>
                    <p class="text-muted">Personalized bouquets and arrangements for any occasion</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<div class="featured-section py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 font-weight-bold text-dark mb-3">Featured Products</h2>
                <p class="lead text-muted">Discover our most popular flowers and plants</p>
                <div class="title-underline bg-success mx-auto"></div>
            </div>
        </div>

        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="product-card card h-100 border-0 shadow-hover">
                    <div class="product-image-container">
                        @php
                            $placeholderImages = [
                                'Red Rose Bouquet' => 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?w=400&h=300&fit=crop',
                                'Snake Plant' => 'https://images.unsplash.com/photo-1593691509543-c55fb32d8de5?w=400&h=300&fit=crop',
                                'Spring Mix Bouquet' => 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=400&h=300&fit=crop',
                                'Fiddle Leaf Fig' => 'https://images.unsplash.com/photo-1586063833161-20e4d31b56bd?w=400&h=300&fit=crop',
                                'Ceramic Pot White' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=400&h=300&fit=crop'
                            ];
                            
                            $imageUrl = $product->image && file_exists(public_path('storage/' . $product->image)) 
                                ? asset('storage/' . $product->image) 
                                : ($placeholderImages[$product->name] ?? 'https://via.placeholder.com/400x300/f8f9fa/6c757d?text=' . urlencode($product->name));
                        @endphp
                        
                        <img src="{{ $imageUrl }}" 
                             class="card-img-top product-image" 
                             alt="{{ $product->name }}">
                        
                        @if($product->featured)
                            <div class="featured-badge">
                                <span class="badge badge-warning">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            </div>
                        @endif
                        
                        <div class="product-overlay">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-light btn-sm">
                                <i class="fas fa-eye"></i> Quick View
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body text-center">
                        <h5 class="card-title font-weight-bold">{{ $product->name }}</h5>
                        <p class="text-muted small mb-2">{{ $product->category->name }}</p>
                        <div class="price-section mb-3">
                            <span class="price h5 text-success font-weight-bold">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-success btn-block">
                            <i class="fas fa-shopping-cart mr-2"></i>View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('products.catalog') }}" class="btn btn-success btn-lg px-5">
                    <i class="fas fa-leaf mr-2"></i>View All Products
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action Section -->
<div class="cta-section py-5 bg-gradient-success text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="font-weight-bold mb-3">Ready to brighten your day?</h3>
                <p class="lead mb-0">Browse our collection of fresh flowers, beautiful plants, and elegant arrangements.</p>
            </div>
            <div class="col-lg-4 text-lg-right">
                <a href="{{ route('products.catalog') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-shopping-bag mr-2"></i>Start Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<div class="newsletter-section py-5 bg-dark text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h4 class="font-weight-bold mb-3">Stay in Bloom</h4>
                <p class="mb-4">Subscribe to our newsletter for seasonal tips, special offers, and new arrivals.</p>
                <form class="newsletter-form">
                    <div class="input-group input-group-lg">
                        <input type="email" class="form-control" placeholder="Enter your email address">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection