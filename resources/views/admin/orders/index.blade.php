@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Orders Management</h1>
    <div>
        <span class="badge badge-info">Total Orders: {{ $orders->count() }}</span>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

<!-- Orders Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orders->where('status', 'pending')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Processing</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orders->where('status', 'processing')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cog fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Shipped</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orders->where('status', 'shipped')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shipping-fast fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Delivered</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orders->where('status', 'delivered')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow">
                <div class="dropdown-header">Export Options:</div>
                <a class="dropdown-item" href="#" onclick="exportTableToCSV('orders.csv')">
                    <i class="fas fa-file-csv fa-sm fa-fw mr-2 text-gray-400"></i> Export to CSV
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <strong>#{{ $order->id }}</strong>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small font-weight-bold">{{ $order->user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $order->user->email }}</td>
                        <td>
                            <span class="badge badge-light">
                                {{ $order->orderItems->count() }} items
                            </span>
                            <div class="small text-muted">
                                @foreach($order->orderItems->take(2) as $item)
                                    {{ $item->product->name }}@if(!$loop->last), @endif
                                @endforeach
                                @if($order->orderItems->count() > 2)
                                    <span class="text-muted">... +{{ $order->orderItems->count() - 2 }} more</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <strong class="text-success">${{ number_format($order->total, 2) }}</strong>
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'processing' => 'info',
                                    'shipped' => 'primary',
                                    'delivered' => 'success'
                                ];
                                $statusIcons = [
                                    'pending' => 'clock',
                                    'processing' => 'cog',
                                    'shipped' => 'shipping-fast',
                                    'delivered' => 'check-circle'
                                ];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                <i class="fas fa-{{ $statusIcons[$order->status] ?? 'question' }} mr-1"></i>
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <span title="{{ $order->created_at->format('M d, Y H:i:s') }}">
                                {{ $order->created_at->format('M d, Y') }}
                            </span>
                            <div class="small text-muted">
                                {{ $order->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" 
                               class="btn btn-sm btn-info" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <!-- Status Update Dropdown -->
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                        data-toggle="dropdown" title="Update Status">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <div class="dropdown-menu">
                                    @foreach(['pending', 'processing', 'shipped', 'delivered'] as $status)
                                        @if($status !== $order->status)
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="{{ $status }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-{{ $statusIcons[$status] }} mr-2"></i>
                                                    {{ ucfirst($status) }}
                                                </button>
                                            </form>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#ordersTable').DataTable({
        "pageLength": 15,
        "ordering": true,
        "searching": true,
        "lengthChange": true,
        "info": true,
        "order": [[ 0, "desc" ]], // Sort by Order ID descending (newest first)
        "columnDefs": [
            { "orderable": false, "targets": 7 }, // Disable sorting on Actions column
            { "width": "10%", "targets": 0 },      // Order ID column width
            { "width": "15%", "targets": 1 },      // Customer column width
            { "width": "15%", "targets": 7 }       // Actions column width
        ],
        "responsive": true,
        "language": {
            "search": "Search orders:",
            "lengthMenu": "Show _MENU_ orders per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ orders",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
});

// Export to CSV function
function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("#ordersTable tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length - 1; j++) { // Exclude last column (actions)
            row.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
        }
        
        csv.push(row.join(","));
    }
    
    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;
    
    csvFile = new Blob([csv], {type: "text/csv"});
    downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}
</script>

<style>
.icon-circle {
    height: 2.5rem;
    width: 2.5rem;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endpush