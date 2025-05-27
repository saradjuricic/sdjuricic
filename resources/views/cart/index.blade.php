@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Your Shopping Cart</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(empty($cart))
        <div class="alert alert-info">
            <h4>Your cart is empty</h4>
            <p>Start shopping to add items to your cart.</p>
            <a href="{{ route('products.catalog') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    @else
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $productId => $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" 
                                             alt="{{ $item['name'] }}" 
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                                             class="mr-3">
                                    @else
                                        <div class="bg-light rounded mr-3 d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $item['name'] }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>
                                <input type="number" 
                                       name="quantities[{{ $productId }}]" 
                                       value="{{ $item['quantity'] }}" 
                                       min="0" 
                                       class="form-control" 
                                       style="width: 80px;">
                            </td>
                            <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            <td>
                                <a href="{{ route('cart.remove', $productId) }}" 
                                   class="btn btn-sm btn-danger"
                                   onclick="event.preventDefault(); document.getElementById('remove-{{ $productId }}').submit();">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <form id="remove-{{ $productId }}" action="{{ route('cart.remove', $productId) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <td colspan="3"><strong>Total:</strong></td>
                            <td><strong>${{ number_format($total, 2) }}</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-sync"></i> Update Cart
                    </button>
                    <a href="{{ route('products.catalog') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('cart.checkout') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-credit-card"></i> Proceed to Checkout
                    </a>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection