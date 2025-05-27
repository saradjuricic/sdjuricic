@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Category
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="categoriesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Products Count</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            <strong>{{ $category->name }}</strong>
                        </td>
                        <td>
                            @if($category->description)
                                <span title="{{ $category->description }}">
                                    {{ Str::limit($category->description, 50) }}
                                </span>
                            @else
                                <em class="text-muted">No description</em>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $category->products_count > 0 ? 'primary' : 'secondary' }}">
                                {{ $category->products_count }} products
                            </span>
                        </td>
                        <td>{{ $category->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('categories.show', $category) }}" 
                               class="btn btn-sm btn-info" title="View on Site" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this category? This will remove {{ $category->products_count }} products.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                        {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Note:</strong> Categories with products cannot be deleted. You must first move or delete all products in a category before deleting the category itself.
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#categoriesTable').DataTable({
        "pageLength": 10,
        "ordering": true,
        "searching": true,
        "lengthChange": true,
        "info": true,
        "order": [[ 0, "desc" ]], // Sort by ID descending (newest first)
        "columnDefs": [
            { "orderable": false, "targets": 5 } // Disable sorting on Actions column
        ]
    });
});
</script>
@endpush