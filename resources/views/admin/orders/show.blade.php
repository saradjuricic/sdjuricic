@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Order Details #{{ $order->id }}</h1>
    <div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

<div class="row">
    <!-- Order Information -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Order Information</h6>
                <span class="badge badge-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'warning' : 'info') }} badge-lg">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Customer Details</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Customer Since:</strong></td>
                                <td>{{ $order->user->created_at->format('M d, Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Order Details</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Order ID:</strong></td>
                                <td>#{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Order Date:</strong></td>
                                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-control form-control-sm d-inline" style="width: auto;" onchange="this.form.submit()">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td class="h5 text-success">${{ number_format($order->total, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="rounded mr-3"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded mr-3 d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $item->product->name }}</strong>
                                            <div class="small text-muted">Product ID: #{{ $item->product->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->product->category->name }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>
                                    <span class="badge badge-primary">{{ $item->quantity }}</span>
                                </td>
                                <td>
                                    <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                <td><strong class="h5 text-success">${{ number_format($order->total, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Summary Sidebar -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    @php
                        $statusColors = [
                            'pending' => 'warning',
                            'processing' => 'info', 
                            'shipped' => 'primary',
                            'delivered' => 'success'
                        ];
                    @endphp
                    <span class="badge badge-{{ $statusColors[$order->status] ?? 'secondary' }} badge-lg p-2">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <table class="table table-borderless">
                    <tr>
                        <td><strong>Items:</strong></td>
                        <td>{{ $order->orderItems->sum('quantity') }} items</td>
                    </tr>
                    <tr>
                        <td><strong>Subtotal:</strong></td>
                        <td>${{ number_format($order->total, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Shipping:</strong></td>
                        <td>Free</td>
                    </tr>
                    <tr class="border-top">
                        <td><strong>Total:</strong></td>
                        <td><strong class="text-success">${{ number_format($order->total, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Timeline</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item {{ $order->status == 'pending' ? 'active' : 'completed' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Order Placed</h6>
                            <p class="text-muted">{{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $order->status == 'processing' ? 'active' : ($order->status == 'pending' ? '' : 'completed') }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Processing</h6>
                            <p class="text-muted">{{ $order->status != 'pending' ? $order->updated_at->format('M d, Y H:i') : 'Pending...' }}</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $order->status == 'shipped' ? 'active' : ($order->status == 'delivered' ? 'completed' : '') }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Shipped</h6>
                            <p class="text-muted">{{ in_array($order->status, ['shipped', 'delivered']) ? $order->updated_at->format('M d, Y H:i') : 'Not yet shipped' }}</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $order->status == 'delivered' ? 'active completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Delivered</h6>
                            <p class="text-muted">{{ $order->status == 'delivered' ? $order->updated_at->format('M d, Y H:i') : 'Not yet delivered' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 20px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -20px;
    top: 8px;
    bottom: -22px;
    width: 2px;
    background: #e3e6f0;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 8px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #e3e6f0;
    border: 2px solid #fff;
}

.timeline-item.active .timeline-marker {
    background: #f6c23e;
}

.timeline-item.completed .timeline-marker {
    background: #1cc88a;
}

.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}
</style>
@endpush