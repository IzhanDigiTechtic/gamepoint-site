@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Create New Product</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku" class="form-label">SKU *</label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                                   id="sku" name="sku" value="{{ old('sku') }}" required>
                                            @error('sku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="product_code" class="form-label">Product Code</label>
                                            <input type="text" class="form-control @error('product_code') is-invalid @enderror" 
                                                   id="product_code" name="product_code" value="{{ old('product_code') }}">
                                            @error('product_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category *</label>
                                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                                    id="category_id" name="category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="brand_id" class="form-label">Brand *</label>
                                            <select class="form-select @error('brand_id') is-invalid @enderror" 
                                                    id="brand_id" name="brand_id" required>
                                                <option value="">Select Brand</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price (Rs.) *</label>
                                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                                   id="price" name="price" value="{{ old('price') }}" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="sale_price" class="form-label">Sale Price (Rs.)</label>
                                            <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror" 
                                                   id="sale_price" name="sale_price" value="{{ old('sale_price') }}">
                                            @error('sale_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stock *</label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                                   id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                              id="short_description" name="short_description" rows="3">{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Full Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Specifications</label>
                                    <div id="specifications-container">
                                        <div class="specification-row mb-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control form-control-sm" 
                                                           name="specifications[key][]" placeholder="Specification Name (e.g., Memory)">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control form-control-sm" 
                                                           name="specifications[value][]" placeholder="Specification Value (e.g., 16GB GDDR7)">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-sm btn-danger remove-spec" style="display: none;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-secondary" id="add-specification">
                                        <i class="fas fa-plus"></i> Add Specification
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Main Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Max size: 2MB</small>
                                </div>

                                <div class="mb-3">
                                    <label for="images" class="form-label">Additional Images</label>
                                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                                           id="images" name="images[]" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" multiple>
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">You can select multiple images. Max size: 2MB each</small>
                                </div>

                                <div class="mb-3">
                                    <label for="condition" class="form-label">Condition *</label>
                                    <select class="form-select @error('condition') is-invalid @enderror" 
                                            id="condition" name="condition" required>
                                        <option value="new" {{ old('condition', 'new') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                                        <option value="refurbished" {{ old('condition') == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="hidden" name="has_warranty" value="0">
                                    <input type="checkbox" class="form-check-input" id="has_warranty" name="has_warranty" value="1"
                                           {{ old('has_warranty', true) ? 'checked' : '' }} onchange="toggleWarrantyMonths()">
                                    <label class="form-check-label" for="has_warranty">
                                        Has Warranty
                                    </label>
                                </div>

                                <div class="mb-3" id="warranty_months_container">
                                    <label for="warranty_months" class="form-label">Warranty Period (Months)</label>
                                    <input type="number" class="form-control @error('warranty_months') is-invalid @enderror" 
                                           id="warranty_months" name="warranty_months" 
                                           value="{{ old('warranty_months', 36) }}" min="0" max="60">
                                    @error('warranty_months')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Enter warranty period in months (e.g., 12, 24, 36)</small>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('specifications-container');
    const addBtn = document.getElementById('add-specification');
    
    addBtn.addEventListener('click', function() {
        const newRow = document.querySelector('.specification-row').cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        newRow.querySelector('.remove-spec').style.display = 'block';
        container.appendChild(newRow);
    });
    
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-spec')) {
            if (container.querySelectorAll('.specification-row').length > 1) {
                e.target.closest('.specification-row').remove();
            }
        }
    });
    
    toggleWarrantyMonths();
});

function toggleWarrantyMonths() {
    const hasWarranty = document.getElementById('has_warranty').checked;
    const warrantyContainer = document.getElementById('warranty_months_container');
    const warrantyInput = document.getElementById('warranty_months');
    
    if (hasWarranty) {
        warrantyContainer.style.display = 'block';
        warrantyInput.required = true;
    } else {
        warrantyContainer.style.display = 'none';
        warrantyInput.required = false;
        warrantyInput.value = '';
    }
}
</script>
@endsection

