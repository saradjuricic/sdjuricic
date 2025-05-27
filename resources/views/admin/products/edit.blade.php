@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Product: {{ $product->name }}</h1>
    <div>
        <a href="{{ route('products.show', $product) }}" class="btn btn-info" target="_blank">
            <i class="fas fa-eye"></i> View Product
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category <span class="text-danger">*</span></label>
                        <select class="form-control @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Price ($) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">Stock Quantity <span class="text-danger">*</span></label>
                                <input type="number" min="0" 
                                       class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="6" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Product Image</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                                <small class="text-muted d-block">Current image</small>
                            </div>
                        @endif
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <small class="form-text text-muted">
                            Leave empty to keep current image. Accepted formats: JPEG, PNG, JPG. Max size: 2MB
                        </small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input" id="featured" name="featured" value="1" 
                               {{ old('featured', $product->featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="featured">
                            <strong>Featured Product</strong>
                            <small class="text-muted d-block">Show this product on the homepage</small>
                        </label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Product Preview</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid mb-3" 
                             style="max-height: 200px; border-radius: 8px;">
                    @else
                        <div class="bg-light mb-3 d-flex align-items-center justify-content-center" 
                             style="height: 200px; border-radius: 8px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                    
                    <h5>{{ $product->name }}</h5>
                    <p class="text-muted">{{ $product->category->name }}</p>
                    <h4 class="text-success">${{ number_format($product->price, 2) }}</h4>
                    
                    @if($product->featured)
                        <span class="badge badge-warning mb-2">Featured</span>
                    @endif
                    
                    <div class="mt-3">
                        <small class="text-muted">
                            Created: {{ $product->created_at->format('M d, Y') }}<br>
                            Updated: {{ $product->updated_at->format('M d, Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection