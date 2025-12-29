@extends('layouts.app')

@section('title', 'Brand Details')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Brand Details</h4>
                    <div>
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Name:</dt>
                        <dd class="col-sm-9">{{ $brand->name }}</dd>

                        <dt class="col-sm-3">Slug:</dt>
                        <dd class="col-sm-9"><code>{{ $brand->slug }}</code></dd>

                        <dt class="col-sm-3">Status:</dt>
                        <dd class="col-sm-9">
                            @if($brand->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">Products:</dt>
                        <dd class="col-sm-9">
                            {{ $brand->products()->where('is_active', true)->count() }} active product(s)
                        </dd>

                        <dt class="col-sm-3">Created:</dt>
                        <dd class="col-sm-9">{{ $brand->created_at->format('M d, Y h:i A') }}</dd>

                        <dt class="col-sm-3">Updated:</dt>
                        <dd class="col-sm-9">{{ $brand->updated_at->format('M d, Y h:i A') }}</dd>
                    </dl>

                    @if($brand->products()->count() > 0)
                        <hr>
                        <h5>Associated Products</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brand->products()->latest()->take(10)->get() as $product)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.products.edit', $product) }}" class="text-decoration-none">
                                                    {{ $product->name }}
                                                </a>
                                            </td>
                                            <td><code>{{ $product->sku }}</code></td>
                                            <td>Rs. {{ number_format($product->price, 0) }}</td>
                                            <td>
                                                @if($product->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($brand->products()->count() > 10)
                            <p class="text-muted small">Showing first 10 products. <a href="{{ route('admin.products.index', ['brand' => $brand->id]) }}">View all</a></p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

