@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                    <h1 class="text-success">Order Submitted Successfully!</h1>
                    <p class="lead">Thank you for your order. We'll process it shortly.</p>
                    
                    <div class="alert alert-info">
                        <strong>Order #{{ $order->id }}</strong><br>
                        <small>Order Date: {{ $order->created_at->format('M d, Y H:i') }}</small>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>Order Details</h5>
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
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td colspan="3"><strong>Total:</strong></td>
                                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('products.catalog') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                    <i class="fas fa-user"></i> View My Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection