@extends('layouts.app')

@section('title', 'View Category')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Category Details</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Icon:</strong></div>
                        <div class="col-md-8">
                            @if($category->icon_url)
                                <img src="{{ asset('storage/' . $category->icon_url) }}" 
                                     alt="{{ $category->name }}" 
                                     style="max-width: 100px; height: auto;">
                            @else
                                <i class="fas fa-box fa-2x text-muted"></i>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Name:</strong></div>
                        <div class="col-md-8">{{ $category->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Slug:</strong></div>
                        <div class="col-md-8"><code>{{ $category->slug }}</code></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Display Order:</strong></div>
                        <div class="col-md-8">{{ $category->display_order }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Status:</strong></div>
                        <div class="col-md-8">
                            @if($category->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Products:</strong></div>
                        <div class="col-md-8">{{ $category->products()->where('is_active', true)->count() }} active products</div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to List</a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">Edit Category</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

