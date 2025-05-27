@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Category: {{ $category->name }}</h1>
    <div>
        <a href="{{ route('categories.show', $category) }}" class="btn btn-info" target="_blank">
            <i class="fas fa-eye"></i> View Category
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Category Information</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $category->name) }}" required
                               placeholder="e.g., Bouquets, House Plants, Garden Tools">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Category name must be unique and will be displayed on the website.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Brief description of this category...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Optional description that will help customers understand what products are in this category.
                        </small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Category Overview</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Category ID:</strong></td>
                        <td>#{{ $category->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Current Name:</strong></td>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Products:</strong></td>
                        <td>
                            <span class="badge badge-{{ $category->products->count() > 0 ? 'primary' : 'secondary' }}">
                                {{ $category->products->count() }} products
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $category->created_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated:</strong></td>
                        <td>{{ $category->updated_at->format('M d, Y') }}</td>
                    </tr>
                </table>

                @if($category->products->count() > 0)
                    <hr>
                    <h6>Products in this category:</h6>
                    <ul class="list-unstyled">
                        @foreach($category->products->take(5) as $product)
                            <li class="mb-1">
                                <small>
                                    <i class="fas fa-leaf text-success"></i>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-decoration-none">
                                        {{ $product->name }}
                                    </a>
                                </small>
                            </li>
                        @endforeach
                        @if($category->products->count() > 5)
                            <li><small class="text-muted">... and {{ $category->products->count() - 5 }} more</small></li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('categories.show', $category) }}" class="btn btn-info btn-block" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View on Website
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" class="btn btn-primary btn-block">
                        <i class="fas fa-list"></i> View Products
                    </a>
                    
                    @if($category->products->count() == 0)
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash"></i> Delete Category
                            </button>
                        </form>
                    @else
                        <button class="btn btn-danger btn-block" disabled title="Cannot delete category with products">
                            <i class="fas fa-trash"></i> Delete Category
                        </button>
                        <small class="text-muted">Remove all products first to delete this category.</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection