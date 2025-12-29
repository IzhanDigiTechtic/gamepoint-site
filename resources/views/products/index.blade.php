@extends('layouts.app')

@section('title', 'Products - ' . config('app.name'))

@section('content')
<div class="container my-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                        <!-- Search -->
                        <div class="mb-3">
                            <label for="search" class="form-label fw-bold">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Search products...">
                        </div>

                        <!-- Category Filter -->
                        @if($categories->count() > 0)
                        <div class="mb-3">
                            <label for="category" class="form-label fw-bold">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->products()->where('is_active', true)->count() }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <!-- Brand Filter -->
                        @if($brands->count() > 0)
                        <div class="mb-3">
                            <label for="brand" class="form-label fw-bold">Brand</label>
                            <select class="form-select" id="brand" name="brand">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-search me-1"></i>Apply Filters
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-1"></i>Clear Filters
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Products</h2>
                <span class="text-muted">{{ $products->total() }} product(s) found</span>
            </div>

            @if($products->count() > 0)
                <div class="row g-3">
                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 product-card border-0 shadow-sm">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                                    <div class="position-relative">
                                        <div class="product-image-wrapper" style="height: 250px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                                            <img src="{{ $product->image ? asset('storage/' . $product->image) : product_placeholder(300, 250, 'No Image') }}" 
                                                 class="product-image" 
                                                 alt="{{ $product->name }}"
                                                 style="max-width: 100%; max-height: 100%; object-fit: contain; padding: 10px;"
                                                 loading="lazy"
                                                 onerror="this.onerror=null; this.src='{{ product_placeholder(300, 250, 'Image Error') }}';">
                                            <div class="skeleton-loader" style="display: none;">
                                                <div class="skeleton-image"></div>
                                            </div>
                                        </div>
                                        @if($product->sale_price)
                                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>
                                        @endif
                                        @if($product->stock <= 0)
                                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                                                <span class="badge bg-secondary fs-6">Out of Stock</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title text-dark mb-2" style="min-height: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $product->name }}
                                        </h6>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-tag me-1"></i>{{ $product->category->name }} | 
                                            <i class="fas fa-certificate me-1"></i>{{ $product->brand->name }}
                                        </p>
                                        <div class="mb-2">
                                            @if($product->sale_price)
                                                <span class="text-decoration-line-through text-muted me-2">Rs. {{ number_format($product->price, 0) }}</span>
                                                <span class="fw-bold text-danger fs-5">Rs. {{ number_format($product->sale_price, 0) }}</span>
                                            @else
                                                <span class="fw-bold text-primary fs-5">Rs. {{ number_format($product->price, 0) }}</span>
                                            @endif
                                        </div>
                                        @if($product->approvedReviews->count() > 0)
                                            <div class="star-rating mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= $product->average_rating ? '' : '-o' }}"></i>
                                                @endfor
                                                <small class="text-muted ms-1">({{ $product->approvedReviews->count() }})</small>
                                            </div>
                                        @endif
                                        <div class="d-grid">
                                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i> View Details
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-3x mb-3 text-primary"></i>
                    <h4>No products found</h4>
                    <p class="mb-0">Try adjusting your filters or <a href="{{ route('products.index') }}" class="alert-link">view all products</a>.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
