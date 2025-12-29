@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Product</h4>
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

                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku" class="form-label">SKU *</label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                                   id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
                                            @error('sku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="product_code" class="form-label">Product Code</label>
                                            <input type="text" class="form-control @error('product_code') is-invalid @enderror" 
                                                   id="product_code" name="product_code" value="{{ old('product_code', $product->product_code) }}">
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
                                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
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
                                                   id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="sale_price" class="form-label">Sale Price (Rs.)</label>
                                            <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror" 
                                                   id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}">
                                            @error('sale_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stock *</label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                                   id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                              id="short_description" name="short_description" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Full Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Specifications</label>
                                    <div id="specifications-container">
                                        @if($product->specifications && count($product->specifications) > 0)
                                            @foreach($product->specifications as $key => $value)
                                                <div class="specification-row mb-2">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <input type="text" class="form-control form-control-sm" 
                                                                   name="specifications[key][]" placeholder="Specification Name" value="{{ $key }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control form-control-sm" 
                                                                   name="specifications[value][]" placeholder="Specification Value" value="{{ $value }}">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-sm btn-danger remove-spec">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="specification-row mb-2">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control form-control-sm" 
                                                               name="specifications[key][]" placeholder="Specification Name">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control form-control-sm" 
                                                               name="specifications[value][]" placeholder="Specification Value">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-sm btn-danger remove-spec" style="display: none;">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-secondary" id="add-specification">
                                        <i class="fas fa-plus"></i> Add Specification
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Main Image</label>
                                    @if($product->image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="Current image" 
                                                 style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Leave empty to keep current image. Max size: 2MB</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Additional Images</label>
                                    @if($product->images->count() > 0)
                                        <div class="mb-3">
                                            <div class="row g-2">
                                                @foreach($product->images as $image)
                                                    <div class="col-6">
                                                        <div class="position-relative">
                                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                                 alt="Product image" 
                                                                 style="width: 100%; height: 100px; object-fit: cover; border: 2px solid {{ $image->is_main ? '#28a745' : '#ddd' }}; padding: 2px;">
                                                            @if($image->is_main)
                                                                <span class="badge bg-success position-absolute top-0 start-0 m-1">Main</span>
                                                            @endif
                                                            <div class="form-check mt-1">
                                                                <input class="form-check-input" type="radio" name="main_image_id" 
                                                                       id="main_image_{{ $image->id }}" value="{{ $image->id }}"
                                                                       {{ $image->is_main ? 'checked' : '' }}>
                                                                <label class="form-check-label small" for="main_image_{{ $image->id }}">
                                                                    Set as main
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="delete_images[]" 
                                                                       id="delete_image_{{ $image->id }}" value="{{ $image->id }}">
                                                                <label class="form-check-label small text-danger" for="delete_image_{{ $image->id }}">
                                                                    Delete
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
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
                                        <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Used</option>
                                        <option value="refurbished" {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="hidden" name="has_warranty" value="0">
                                    <input type="checkbox" class="form-check-input" id="has_warranty" name="has_warranty" value="1"
                                           {{ old('has_warranty', $product->has_warranty) ? 'checked' : '' }} onchange="toggleWarrantyMonths()">
                                    <label class="form-check-label" for="has_warranty">
                                        Has Warranty
                                    </label>
                                </div>

                                <div class="mb-3" id="warranty_months_container">
                                    <label for="warranty_months" class="form-label">Warranty Period (Months)</label>
                                    <input type="number" class="form-control @error('warranty_months') is-invalid @enderror" 
                                           id="warranty_months" name="warranty_months" 
                                           value="{{ old('warranty_months', $product->warranty_months) }}" min="0" max="60">
                                    @error('warranty_months')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Enter warranty period in months (e.g., 12, 24, 36)</small>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>

                                @if($product->price_updated_at)
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle"></i> Price last updated: {{ $product->price_updated_at->format('d M, Y') }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Product</button>
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
        newRow.querySelectorAll('input').forEach(input => {
            if (input.name.includes('specifications')) {
                input.value = '';
            }
        });
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

