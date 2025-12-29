<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    
    <!-- Preconnect for faster font loading -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    
    <!-- Font Awesome - Using Cloudflare CDN (faster) with optimized loading -->
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
          crossorigin="anonymous" 
          referrerpolicy="no-referrer">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Top Utility Bar -->
    <div class="bg-primary text-white py-2" style="background-color: #1a237e !important;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#" class="text-white text-decoration-none small">About {{ config('app.name') }}</a>
                        <a href="#" class="text-white text-decoration-none small">Feedbacks & Suggestions</a>
                        <a href="#" class="text-white text-decoration-none small">Contact Us</a>
                        <a href="#" class="text-white text-decoration-none small">FAQs</a>
                        <a href="#" class="text-white text-decoration-none small">Policies</a>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        @auth
                            <div class="dropdown">
                                <a class="text-white text-decoration-none small dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    My Account
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                    @if(Auth::user()->isAdmin())
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-white text-decoration-none small">Log In</a>
                            <a href="{{ route('register') }}" class="text-white text-decoration-none small">Create Account</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-primary py-3" style="background-color: #283593 !important;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-md-3 col-6">
                    <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center">
                        <span class="text-white fw-bold fs-3 me-2">{{ strtoupper(explode(' ', config('app.name', 'GamePoint'))[0]) }}</span>
                        <span class="bg-warning text-dark fw-bold px-2 py-1 border border-dark" style="background-color: #ffeb3b !important;">
                            {{ strtoupper(explode(' ', config('app.name', 'GamePoint'))[1] ?? 'POINT') }}
                        </span>
                    </a>
                </div>
                
                <!-- Search Bar -->
                <div class="col-md-6 d-none d-md-block">
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                        <div class="input-group" style="height: 45px;">
                            <input type="text" name="search" class="form-control rounded-0" 
                                   placeholder="Search entire store here...." value="{{ request('search') }}" style="border: none;">
                            <select name="category" class="form-select rounded-0" style="border: none; border-left: 1px solid #ddd; max-width: 150px;">
                                <option value="">Categories</option>
                                @php
                                    $headerCategories = \App\Models\Category::where('is_active', true)->get();
                                    $selectedCategoryId = request()->query('category');
                                @endphp
                                @foreach($headerCategories as $category)
                                    <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn rounded-0 text-white" style="background-color: #ffeb3b; width: 45px; border: none;">
                                <i class="fas fa-search text-dark"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Cart -->
                <div class="col-md-3 col-6 text-end">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <i class="fas fa-shopping-cart text-white fs-4"></i>
                        <span class="text-white">(Rs.0.00)</span>
                    </div>
                    <button class="navbar-toggler d-md-none text-white border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Bottom Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark py-2" style="background-color: #1a237e !important;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-uppercase fw-bold dropdown-toggle" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown">
                            Products
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($headerCategories as $category)
                                <li><a class="dropdown-item" href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @foreach($headerCategories->take(10) as $category)
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fw-bold" href="{{ route('products.index', ['category' => $category->id]) }}">{{ strtoupper($category->name) }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex align-items-center">
                    <a href="#" class="text-white me-3" target="_blank">
                        <i class="fab fa-facebook-f fs-5"></i>
                    </a>
                    <!-- Mobile Search -->
                    <form action="{{ route('products.index') }}" method="GET" class="d-md-none">
                        <div class="input-group" style="width: 200px;">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3">{{ config('app.name', 'GamePoint') }}</h5>
                    <p class="text-muted">Your trusted source for quality gaming products. We offer the best prices and fastest delivery.</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-light text-decoration-none">All Products</a></li>
                        @auth
                            <li class="mb-2"><a href="{{ route('dashboard') }}" class="text-light text-decoration-none">My Account</a></li>
                        @else
                            <li class="mb-2"><a href="{{ route('login') }}" class="text-light text-decoration-none">Login</a></li>
                            <li class="mb-2"><a href="{{ route('register') }}" class="text-light text-decoration-none">Register</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3">Categories</h5>
                    <ul class="list-unstyled">
                        @php
                            $footerCategories = \App\Models\Category::where('is_active', true)->take(5)->get();
                        @endphp
                        @foreach($footerCategories as $category)
                            <li class="mb-2">
                                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="text-light text-decoration-none">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3">Contact Us</h5>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +92 300 1234567</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@gamepoint.com</li>
                        <li class="mb-2">
                            <a href="https://wa.me/1234567890" target="_blank" class="text-success text-decoration-none">
                                <i class="fab fa-whatsapp me-2"></i> WhatsApp Us
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="bg-light my-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">Designed with <i class="fas fa-heart text-danger"></i> for gamers</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/1234567890?text=Hello%20I%20am%20interested%20in%20your%20products" 
       class="whatsapp-float" 
       target="_blank" 
       rel="noopener noreferrer"
       title="Contact us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
</body>
</html>
