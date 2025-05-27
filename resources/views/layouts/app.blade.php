@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blossom Boutique</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
/* Custom styles for better homepage */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.min-vh-50 {
    min-height: 50vh;
}

.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=1200&h=800&fit=crop&crop=center') center/cover;
    opacity: 0.1;
    z-index: -1;
}

.rounded-lg {
    border-radius: 15px !important;
}

.feature-icon {
    width: 80px;
    height: 80px;
}

.feature-card {
    padding: 2rem 1rem;
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.title-underline {
    height: 4px;
    width: 80px;
    border-radius: 2px;
}

.product-card {
    transition: all 0.3s ease;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

.product-image-container {
    position: relative;
    overflow: hidden;
}

.product-image {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.featured-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 2;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.shadow-hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.price {
    font-size: 1.5rem;
}

.newsletter-form .form-control {
    border: none;
    background: rgba(255,255,255,0.1);
    color: white;
    border-radius: 50px 0 0 50px;
}

.newsletter-form .form-control::placeholder {
    color: rgba(255,255,255,0.7);
}

.newsletter-form .btn {
    border-radius: 0 50px 50px 0;
    border: none;
}

.cta-section {
    position: relative;
    overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-section {
        text-align: center;
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
    
    .hero-buttons {
        margin-top: 2rem;
    }
    
    .hero-buttons .btn {
        display: block;
        margin: 0.5rem 0;
    }
}

/* Animation for smooth loading */
.product-card {
    animation: fadeInUp 0.6s ease-out;
}

.product-card:nth-child(2) {
    animation-delay: 0.1s;
}

.product-card:nth-child(3) {
    animation-delay: 0.2s;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">🌸 Blossom Boutique</a>
        
        <!-- Add navigation toggle for mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Main Navigation -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.catalog') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>
            
            <!-- User Navigation -->
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ array_sum(array_column(session('cart'), 'quantity')) }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">Profile</a>
                    </li>
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
