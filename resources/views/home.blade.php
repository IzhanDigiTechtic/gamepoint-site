@extends('layouts.app')

@section('title', 'Home - ' . config('app.name'))

@section('content')
    <!-- Banner Carousel -->
    @if($banners->count() > 0)
    <div class="banner mb-0">
        <div class="container">
            <div class="slider-content position-relative">
                <!-- Carousel -->
                <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators">
                        @foreach($banners as $index => $banner)
                            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="{{ $index }}" 
                                    class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                                    aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner">
                        @foreach($banners as $index => $banner)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                @if($banner->link)
                                    <a href="{{ $banner->link }}" @if(($banner->link_target ?? '_self') == '_blank') target="_blank" @endif>
                                        <img src="{{ asset('storage/' . $banner->image) }}" 
                                             class="d-block w-100 slider-img" 
                                             alt="{{ $banner->title ?? 'Banner' }}">
                                    </a>
                                @else
                                    <img src="{{ asset('storage/' . $banner->image) }}" 
                                         class="d-block w-100 slider-img" 
                                         alt="{{ $banner->title ?? 'Banner' }}">
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation Controls -->
                    <button class="carousel-control-prev slider-control" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next slider-control" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Official Notice Banner -->
    <div class="container">
        <div class="official-notice-banner ">
        <div class="container-fluid">
            <span class="notice-label">Notice:</span>
            <span class="notice-text">
                {{ config('app.name') }} operates 
                <a href="{{ route('home') }}" class="notice-link">Only one Official store</a>. 
                Beware of fake stores claiming our name.
            </span>
        </div>
    </div>
    </div>


    <!-- Category Icon Bar -->
    @if(isset($iconCategories) && $iconCategories->count() > 0)
    <div class="category-icon-bar">
        <div class="container">
            <div class="icon-bar-wrapper">
                @foreach($iconCategories as $index => $category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="icon-item" title="{{ $category->name }}">
                        <div class="icon-image-wrapper">
                            @if($category->icon_url)
                                <img src="{{ asset('storage/' . $category->icon_url) }}" alt="{{ $category->name }}" class="icon-image">
                            @else
                                <i class="fas fa-box icon-fallback"></i>
                            @endif
                        </div>
                        <span class="icon-label">{{ $category->name }}</span>
                    </a>
                    @if(($index + 1) % 4 == 0 && $index + 1 < $iconCategories->count())
                        <div class="icon-row-divider"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Featured Products -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">FEATURED PRODUCTS</h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary d-none d-md-inline-block">View All Products</a>
        </div>
        <div class="row g-4">
            @forelse($featuredProducts as $product)
                @php
                    $discountPercent = $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
                @endphp
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card h-100 product-card border-0 shadow-sm position-relative">
                        <div class="position-relative">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}" 
                                 class="card-img-top product-image" alt="{{ $product->name }}"
                                 style="height: 250px; object-fit: contain; background: #f8f9fa; padding: 10px;">
                            @if($product->sale_price && $discountPercent > 0)
                                <span class="discount-badge position-absolute top-0 start-0 m-2">
                                    {{ $discountPercent }}% OFF
                                </span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-dark mb-2 fw-bold" style="min-height: 50px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.95rem;">
                                {{ $product->name }}
                            </h6>
                            @if($product->description)
                                <div class="product-features mb-3 flex-grow-1" style="font-size: 0.85rem; color: #666; line-height: 1.5;">
                                    <div style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ Str::limit(strip_tags($product->description), 150) }}
                                    </div>
                                </div>
                            @endif
                            <div class="mb-3">
                                @if($product->sale_price)
                                    <div class="d-flex align-items-baseline gap-2">
                                        <span class="text-decoration-line-through text-muted" style="font-size: 0.9rem;">Rs. {{ number_format($product->price, 0) }}</span>
                                        <span class="fw-bold text-primary" style="font-size: 1.2rem;">Rs. {{ number_format($product->sale_price, 0) }}</span>
                                    </div>
                                @else
                                    <span class="fw-bold text-primary" style="font-size: 1.2rem;">Rs. {{ number_format($product->price, 0) }}</span>
                                @endif
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary w-100" style="background-color: #283593; border-color: #283593;">
                                    VIEW DETAIL
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>No featured products available at the moment.
                    </div>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg" style="background-color: #283593; border-color: #283593;">
                <i class="fas fa-th me-2"></i>View All Products
            </a>
        </div>
    </div>

    <!-- Latest Products -->
    @php
        $latestProducts = \App\Models\Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();
    @endphp
    @if($latestProducts->count() > 0)
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Latest Products</h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary d-none d-md-inline-block">View All</a>
        </div>
        <div class="row g-3">
            @foreach($latestProducts as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 product-card border-0 shadow-sm">
                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                            <div class="position-relative">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}" 
                                     class="card-img-top product-image" alt="{{ $product->name }}">
                                @if($product->sale_price)
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <h6 class="card-title text-dark mb-2" style="min-height: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $product->name }}
                                </h6>
                                <div class="mb-2">
                                    @if($product->sale_price)
                                        <span class="text-decoration-line-through text-muted me-2">Rs. {{ number_format($product->price, 0) }}</span>
                                        <span class="fw-bold text-danger fs-5">Rs. {{ number_format($product->sale_price, 0) }}</span>
                                    @else
                                        <span class="fw-bold text-primary fs-5">Rs. {{ number_format($product->price, 0) }}</span>
                                    @endif
                                </div>
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
    </div>
    @endif
@endsection
