@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <h3 class="text-primary">{{ \App\Models\Product::count() }}</h3>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <h3 class="text-success">{{ \App\Models\Category::count() }}</h3>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-success">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Brands</h5>
                    <h3 class="text-info">{{ \App\Models\Brand::count() }}</h3>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-sm btn-info">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Banners</h5>
                    <h3 class="text-warning">{{ \App\Models\Banner::count() }}</h3>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-warning">Manage</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add New Product</a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Add New Category</a>
                        <a href="{{ route('admin.brands.create') }}" class="btn btn-info">Add New Brand</a>
                        <a href="{{ route('admin.banners.create') }}" class="btn btn-warning">Add New Banner</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

