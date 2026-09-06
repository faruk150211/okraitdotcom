@extends('layouts.adminlte')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header & Filters -->
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Product
                    </a>
                    
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                        <!-- Brand Filter -->
                        <select name="brand_id" class="form-select form-select-sm" style="width: 150px;">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>

                        <!-- Category Filter -->
                        <select name="category_id" class="form-select form-select-sm" style="width: 150px;">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <!-- Model Filter -->
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="model" class="form-control" placeholder="Model..." value="{{ request('model') }}">
                        </div>

                        <!-- Name Search -->
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>

                        @if(request('search') || request('brand_id') || request('category_id') || request('model'))
                        <a href="{{ route('products.index') }}" class="btn btn-outline-danger btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Card Body (Table) -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">SL</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th class="text-end">Base Price</th>
                                <th class="text-end">Selling Price</th>
                                <th class="text-end">Quotation Price</th>
                                <th class="text-end pe-4" style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td class="ps-4 text-secondary">{{ $loop->index + 1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ $product->name }}</div>
                                    <small class="text-muted">{{ $product->model }}</small>
                                </td>
                                <td><span class="badge bg-secondary">{{ $product->brand->name }}</span></td>
                                <td>
                                    @if($product->category)
                                    <span class="badge bg-info text-dark">{{ $product->category->name }}</span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold text-secondary">{{ number_format($product->base_price, 2) }}</td>
                                <td class="text-end fw-bold text-success">{{ number_format($product->selling_price, 2) }}</td>
                                <td class="text-end fw-bold text-primary">{{ number_format($product->quotation_price, 2) }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
                                    No products found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer (Pagination) -->
            @if($products->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
