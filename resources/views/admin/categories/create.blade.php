@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add New Category</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Categories
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Category Information</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required
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
                                  placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Optional description that will help customers understand what products are in this category.
                        </small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Category
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
                <h6 class="m-0 font-weight-bold text-primary">Tips</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <i class="fas fa-lightbulb fa-3x text-warning mb-3"></i>
                    <h5>Category Guidelines</h5>
                </div>
                
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        Use clear, descriptive names
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        Keep names concise (2-3 words max)
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        Add helpful descriptions
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        Think about customer navigation
                    </li>
                </ul>

                <hr>

                <h6>Example Categories:</h6>
                <ul class="list-unstyled small text-muted">
                    <li>• Wedding Bouquets</li>
                    <li>• Indoor Plants</li>
                    <li>• Garden Accessories</li>
                    <li>• Seasonal Arrangements</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection