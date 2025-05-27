@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Checkout</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
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
                                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"
                                                     class="mr-3">
                                            @endif
                                            <span>{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item['price'], 2) }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td colspan="3"><strong>Total:</strong></td>
                                    <td><strong>${{ number_format($total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Delivery Information</h5>
                </div>
                <div class="card-body">
                    <h6>{{ auth()->user()->name }}</h6>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                    
                    <hr>
                    
                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            This is a demo checkout. No payment is required.
                        </small>
                    </div>

                    <form action="{{ route('cart.place-order') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block btn-lg">
                            <i class="fas fa-check"></i> Place Order
                        </button>
                    </form>
                    
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-block mt-2">
                        <i class="fas fa-arrow-left"></i> Back to Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection