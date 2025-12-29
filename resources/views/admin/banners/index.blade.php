@extends('layouts.app')

@section('title', 'Banner Management')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Banner Management</h2>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Banner
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($banners->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $banner)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $banner->image) }}" 
                                             alt="{{ $banner->title }}" 
                                             style="width: 100px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>{{ $banner->title ?? 'N/A' }}</td>
                                    <td>
                                        @if($banner->link)
                                            <a href="{{ $banner->link }}" target="_blank">View Link</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $banner->order }}</td>
                                    <td>
                                        @if($banner->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.banners.destroy', $banner) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted">No banners found. <a href="{{ route('admin.banners.create') }}">Create one now</a>.</p>
            @endif
        </div>
    </div>
</div>
@endsection

