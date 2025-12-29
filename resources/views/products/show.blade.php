@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))

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
            <div class="card border-0 shadow-sm">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/500' }}" 
                     class="card-img-top" alt="{{ $product->name }}" style="max-height: 600px; object-fit: contain;">
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <div class="mb-3">
                <span class="badge bg-primary me-2">{{ $product->category->name }}</span>
                <span class="badge bg-info">{{ $product->brand->name }}</span>
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
                    <span class="ms-2">No reviews yet</span>
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
                        <p class="mb-0">{{ $product->description }}</p>
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
                                    <img src="{{ $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : 'https://via.placeholder.com/300' }}" 
                                         class="card-img-top product-image" alt="{{ $relatedProduct->name }}">
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
@endsection
