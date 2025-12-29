@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))

@push('styles')
<!-- GLightbox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<style>
    .magnify-container {
        position: relative;
        overflow: hidden;
    }

    .product-main-image {
        transition: transform 0.3s ease;
    }

    .magnifier-lens {
        position: absolute;
        width: 200px;
        height: 200px;
        border: 3px solid #fff;
        border-radius: 50%;
        pointer-events: none;
        background-repeat: no-repeat;
        background-color: #fff;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
        z-index: 1000;
        display: none;
        overflow: hidden;
    }

    .magnify-container:hover .magnifier-lens {
        display: block;
    }

    .carousel-thumbnail {
        opacity: 0.6;
        transition: all 0.3s ease;
    }

    .carousel-thumbnail:hover,
    .carousel-thumbnail.active {
        opacity: 1;
        border-color: var(--primary-color) !important;
        transform: scale(1.05);
    }

    .carousel-thumbnail.active {
        border-width: 3px;
    }

    .product-image-wrapper {
        position: relative;
    }

    .product-image-wrapper a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .carousel-control-prev,
    .carousel-control-next {
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
    }

    /* Slow down carousel transitions */
    #productImageCarousel .carousel-item {
        transition: transform 0.8s ease-in-out;
    }

    #productImageCarousel .carousel-item-next:not(.carousel-item-start),
    #productImageCarousel .active.carousel-item-end {
        transform: translateX(100%);
    }

    #productImageCarousel .carousel-item-prev:not(.carousel-item-end),
    #productImageCarousel .active.carousel-item-start {
        transform: translateX(-100%);
    }

    @media (max-width: 768px) {
        .magnifier-lens {
            display: none !important;
        }
        
        .magnify-container {
            cursor: pointer;
        }
        
        #productImageCarousel .carousel-item {
            transition: transform 0.6s ease-in-out;
        }
    }
</style>
@endpush

@section('content')
<div class="container my-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Products</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            @php
                $allImages = collect();
                if($product->image) {
                    $allImages->push([
                        'type' => 'main',
                        'path' => $product->image,
                        'url' => asset('storage/' . $product->image)
                    ]);
                }
                foreach($product->images as $img) {
                    $allImages->push([
                        'type' => 'additional',
                        'path' => $img->image_path,
                        'url' => asset('storage/' . $img->image_path),
                        'is_main' => $img->is_main
                    ]);
                }
                // If no images, add placeholder
                if($allImages->isEmpty()) {
                    $allImages->push([
                        'type' => 'placeholder',
                        'path' => '',
                        'url' => product_placeholder(500, 500, 'No Image')
                    ]);
                }
            @endphp

            @if($allImages->count() > 1)
                <!-- Image Carousel -->
                <div id="productImageCarousel" class="carousel slide mb-3" data-bs-ride="false" data-bs-interval="false" data-bs-pause="true" data-bs-wrap="true">
                    <div class="carousel-inner">
                        @foreach($allImages as $index => $img)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="product-image-wrapper magnify-container" 
                                     style="min-height: 500px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; position: relative; cursor: zoom-in;">
                                    <a href="{{ $img['url'] }}" class="glightbox" data-gallery="product-gallery">
                                        <img src="{{ $img['url'] }}" 
                                             class="product-main-image" 
                                             alt="{{ $product->name }} - Image {{ $index + 1 }}" 
                                             data-magnify-src="{{ $img['url'] }}"
                                             style="max-height: 500px; max-width: 100%; object-fit: contain; padding: 20px;"
                                             loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                             onerror="this.onerror=null; this.src='{{ product_placeholder(500, 500, 'Image Error') }}';">
                                    </a>
                                    <div class="magnifier-lens" style="display: none;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($allImages->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev" style="width: 50px; height: 50px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); border-radius: 50%;">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next" style="width: 50px; height: 50px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); border-radius: 50%;">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>

                <!-- Thumbnail Navigation -->
                <div class="row g-2">
                    @foreach($allImages as $index => $img)
                        <div class="col-3">
                            <div class="product-thumbnail carousel-thumbnail {{ $index === 0 ? 'active' : '' }}" 
                                 data-bs-target="#productImageCarousel" 
                                 data-bs-slide-to="{{ $index }}"
                                 style="height: 80px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 2px solid #dee2e6; border-radius: 4px; cursor: pointer; overflow: hidden; transition: all 0.3s;">
                                <img src="{{ $img['url'] }}" 
                                     alt="Thumbnail {{ $index + 1 }}"
                                     style="max-width: 100%; max-height: 100%; object-fit: contain; padding: 5px;"
                                     loading="lazy">
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Single Image -->
                <div class="card border-0 shadow-sm">
                    <div class="product-image-wrapper magnify-container" 
                         style="min-height: 500px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; position: relative; cursor: zoom-in;">
                        <a href="{{ $allImages->first()['url'] }}" class="glightbox">
                            <img src="{{ $allImages->first()['url'] }}" 
                                 class="product-main-image" 
                                 alt="{{ $product->name }}" 
                                 data-magnify-src="{{ $allImages->first()['url'] }}"
                                 style="max-height: 500px; max-width: 100%; object-fit: contain; padding: 20px;"
                                 loading="eager"
                                 onerror="this.onerror=null; this.src='{{ product_placeholder(500, 500, 'Image Error') }}';">
                        </a>
                        <div class="magnifier-lens" style="display: none;"></div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <!-- Product Information Bar -->
            <div class="card border-0 shadow-sm mb-4" style="background-color: #f8f9fa;">
                <div class="card-body">
                    <div class="row g-3">
                        @if($product->product_code)
                            <div class="col-12">
                                <strong class="text-muted">Product Code:</strong>
                                <span class="ms-2">{{ $product->product_code }}</span>
                            </div>
                        @endif
                        <div class="col-12">
                            <strong class="text-muted">Brand:</strong>
                            <span class="ms-2 badge bg-info">{{ $product->brand->name ?? 'N/A' }}</span>
                        </div>
                        @if($product->price_updated_at)
                            <div class="col-12">
                                <strong class="text-muted">Price Updated On:</strong>
                                <span class="ms-2">{{ $product->price_updated_at->format('d M, Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <span class="badge bg-primary me-2">{{ $product->category->name }}</span>
                <span class="badge bg-secondary">SKU: {{ $product->sku }}</span>
            </div>

            @if($product->approvedReviews->count() > 0)
                <div class="mb-3 star-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star{{ $i <= $product->average_rating ? '' : '-o' }} fs-5"></i>
                    @endfor
                    <span class="ms-2">({{ $product->approvedReviews->count() }} reviews)</span>
                </div>
            @else
                <div class="mb-3 text-muted">
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <span class="ms-2">Be the first to write a review.</span>
                </div>
            @endif

            <div class="mb-4">
                @if($product->sale_price)
                    <h2 class="mb-2">
                        <span class="text-decoration-line-through text-muted me-2 fs-5">Rs. {{ number_format($product->price, 0) }}</span>
                        <span class="text-danger fw-bold">Rs. {{ number_format($product->sale_price, 0) }}</span>
                    </h2>
                    <span class="badge bg-success">Save Rs. {{ number_format($product->price - $product->sale_price, 0) }}</span>
                @else
                    <h2 class="text-primary fw-bold">Rs. {{ number_format($product->price, 0) }}</h2>
                @endif
            </div>

            @if($product->short_description)
                <div class="alert alert-light border mb-4">
                    <p class="mb-0"><strong>Quick Info:</strong> {{ $product->short_description }}</p>
                </div>
            @endif

            <div class="mb-4">
                <h5>Availability</h5>
                @if($product->stock > 0)
                    <p class="text-success mb-0">
                        <i class="fas fa-check-circle me-2"></i>In Stock ({{ $product->stock }} available)
                    </p>
                @else
                    <p class="text-danger mb-0">
                        <i class="fas fa-times-circle me-2"></i>Out of Stock
                    </p>
                @endif
            </div>

            <div class="d-grid gap-2 mb-4">
                <a href="https://wa.me/1234567890?text=I%20am%20interested%20in%20{{ urlencode($product->name) }}%20(SKU:%20{{ $product->sku }})" 
                   class="btn btn-success btn-lg" target="_blank">
                    <i class="fab fa-whatsapp me-2"></i> Contact via WhatsApp
                </a>
            </div>

            @if($product->description)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Description</h5>
                    </div>
                    <div class="card-body">
                        <div class="product-description" style="white-space: pre-line; line-height: 1.8;">{{ $product->description }}</div>
                    </div>
                </div>
            @endif

            @if($product->specifications && count($product->specifications) > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Specifications</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            @foreach($product->specifications as $key => $value)
                                <dt class="col-sm-4 mb-2">{{ $key }}:</dt>
                                <dd class="col-sm-8 mb-2">{{ $value }}</dd>
                            @endforeach
                        </dl>
                    </div>
                </div>
            @endif

            @if($product->condition || $product->has_warranty)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Product Details</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            @if($product->condition)
                                <dt class="col-sm-4 mb-2">Condition:</dt>
                                <dd class="col-sm-8 mb-2">
                                    <span class="badge bg-{{ $product->condition == 'new' ? 'success' : ($product->condition == 'used' ? 'warning' : 'info') }}">
                                        {{ ucfirst($product->condition) }}
                                    </span>
                                </dd>
                            @endif
                            @if($product->has_warranty && $product->warranty_months)
                                <dt class="col-sm-4 mb-2">Warranty:</dt>
                                <dd class="col-sm-8 mb-2">
                                    <span class="badge bg-success">
                                        <i class="fas fa-shield-alt me-1"></i>{{ $product->warranty_months }} Months
                                    </span>
                                </dd>
                            @elseif($product->has_warranty)
                                <dt class="col-sm-4 mb-2">Warranty:</dt>
                                <dd class="col-sm-8 mb-2">
                                    <span class="badge bg-success">
                                        <i class="fas fa-shield-alt me-1"></i>Yes (Details on request)
                                    </span>
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Customer Reviews</h3>
            <hr>

            <!-- Add Review Form -->
            @auth
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-star me-2"></i>Write a Review</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reviews.store', $product) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rating" class="form-label fw-bold">Rating</label>
                                <select class="form-select" id="rating" name="rating" required>
                                    <option value="">Select Rating</option>
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Good</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label fw-bold">Your Review</label>
                                <textarea class="form-control" id="comment" name="comment" rows="4" 
                                          placeholder="Share your experience with this product..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>Submit Review
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Please <a href="{{ route('login') }}" class="alert-link">login</a> to write a review.
                </div>
            @endauth

            <!-- Reviews List -->
            @if($product->approvedReviews->count() > 0)
                <div class="row">
                    @foreach($product->approvedReviews as $review)
                        <div class="col-12 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <strong class="me-2">{{ $review->user->name }}</strong>
                                            <div class="star-rating d-inline-block">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                    </div>
                                    @if($review->comment)
                                        <p class="mb-0">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-light text-center">
                    <i class="fas fa-comment-slash fa-2x mb-2 text-muted"></i>
                    <p class="mb-0">No reviews yet. Be the first to review this product!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Related Products</h3>
            <hr>
            <div class="row g-3">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 product-card border-0 shadow-sm">
                            <a href="{{ route('products.show', $relatedProduct->slug) }}" class="text-decoration-none">
                                <div class="position-relative">
                                    <div class="product-image-wrapper" style="height: 250px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                                        <img src="{{ $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : product_placeholder(300, 250, 'No Image') }}" 
                                             class="product-image" 
                                             alt="{{ $relatedProduct->name }}"
                                             style="max-width: 100%; max-height: 100%; object-fit: contain; padding: 10px;"
                                             loading="lazy"
                                             onerror="this.onerror=null; this.src='{{ product_placeholder(300, 250, 'Image Error') }}';">
                                        <div class="skeleton-loader" style="display: none;">
                                            <div class="skeleton-image"></div>
                                        </div>
                                    </div>
                                    @if($relatedProduct->sale_price)
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title text-dark mb-2" style="min-height: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $relatedProduct->name }}
                                    </h6>
                                    <div class="mb-2">
                                        @if($relatedProduct->sale_price)
                                            <span class="text-decoration-line-through text-muted me-2">Rs. {{ number_format($relatedProduct->price, 0) }}</span>
                                            <span class="fw-bold text-danger">Rs. {{ number_format($relatedProduct->sale_price, 0) }}</span>
                                        @else
                                            <span class="fw-bold text-primary">Rs. {{ number_format($relatedProduct->price, 0) }}</span>
                                        @endif
                                    </div>
                                    <div class="d-grid">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-primary btn-sm">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<!-- GLightbox JS -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    // Initialize GLightbox
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: false
    });

    // Image Magnifier
    document.addEventListener('DOMContentLoaded', function() {
        const magnifyContainers = document.querySelectorAll('.magnify-container');
        
        magnifyContainers.forEach(container => {
            const img = container.querySelector('.product-main-image');
            const lens = container.querySelector('.magnifier-lens');
            
            if (!img || !lens) return;
            
            const magnifySrc = img.getAttribute('data-magnify-src') || img.src;
            const zoomLevel = 2.5; // Zoom level
            
            // Wait for image to load
            function initMagnifier() {
                container.addEventListener('mousemove', function(e) {
                    if (window.innerWidth <= 768) return; // Disable on mobile
                    
                    const containerRect = container.getBoundingClientRect();
                    const imgRect = img.getBoundingClientRect();
                    
                    // Get mouse position relative to container
                    const x = e.clientX - containerRect.left;
                    const y = e.clientY - containerRect.top;
                    
                    // Lens size
                    const lensSize = 200;
                    const lensOffset = lensSize / 2;
                    
                    // Calculate lens position (centered on cursor)
                    let lensX = x - lensOffset;
                    let lensY = y - lensOffset;
                    
                    // Keep lens within container bounds
                    lensX = Math.max(0, Math.min(lensX, containerRect.width - lensSize));
                    lensY = Math.max(0, Math.min(lensY, containerRect.height - lensSize));
                    
                    // Position the lens
                    lens.style.left = lensX + 'px';
                    lens.style.top = lensY + 'px';
                    
                    // Calculate the position on the actual image
                    // Get image position relative to container
                    const imgXInContainer = imgRect.left - containerRect.left;
                    const imgYInContainer = imgRect.top - containerRect.top;
                    
                    // Mouse position relative to image
                    const mouseXOnImg = x - imgXInContainer;
                    const mouseYOnImg = y - imgYInContainer;
                    
                    // Calculate percentage position on image
                    const imgWidth = imgRect.width;
                    const imgHeight = imgRect.height;
                    const percentX = (mouseXOnImg / imgWidth) * 100;
                    const percentY = (mouseYOnImg / imgHeight) * 100;
                    
                    // Set background image and position
                    lens.style.backgroundImage = `url(${magnifySrc})`;
                    lens.style.backgroundSize = `${imgWidth * zoomLevel}px ${imgHeight * zoomLevel}px`;
                    lens.style.backgroundPosition = `${percentX}% ${percentY}%`;
                });
                
                container.addEventListener('mouseenter', function() {
                    if (window.innerWidth > 768) {
                        lens.style.display = 'block';
                    }
                });
                
                container.addEventListener('mouseleave', function() {
                    lens.style.display = 'none';
                });
            }
            
            // Initialize when image is loaded
            if (img.complete) {
                initMagnifier();
            } else {
                img.addEventListener('load', initMagnifier);
            }
        });
    });

    // Initialize carousel with manual control only (no auto-play)
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('productImageCarousel');
        if (carousel) {
            // Initialize carousel with no auto-play
            const bsCarousel = new bootstrap.Carousel(carousel, {
                interval: false,
                ride: false,
                wrap: true,
                keyboard: true
            });
            
            // Ensure it's paused (no auto-play)
            bsCarousel.pause();
            
            // Update active thumbnail on carousel slide
            carousel.addEventListener('slid.bs.carousel', function(e) {
                const thumbnails = document.querySelectorAll('.carousel-thumbnail');
                thumbnails.forEach((thumb, index) => {
                    thumb.classList.toggle('active', index === e.to);
                });
            });
            
            // Prevent any auto-cycling
            carousel.addEventListener('mouseenter', function() {
                bsCarousel.pause();
            });
            
            carousel.addEventListener('mouseleave', function() {
                bsCarousel.pause();
            });
        }
    });
</script>
@endpush
@endsection
