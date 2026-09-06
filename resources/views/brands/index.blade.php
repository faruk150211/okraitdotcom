@extends('layouts.adminlte')

@section('title', 'Brands')
@section('page-title', 'Brands')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header -->
            <div class="card-header bg-white py-3 border-0 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <a href="{{ route('brands.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add Brand
                </a>
                
                <form action="{{ route('brands.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Search brands..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('brands.index') }}" class="btn btn-outline-danger">Clear</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Card Body (Table) -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th class="text-end pe-4" style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $brand)
                            <tr>
                                <td class="ps-4 text-secondary">{{ $brand->id }}</td>
                                <td class="fw-bold">{{ $brand->name }}</td>
                                <td><code class="bg-light text-primary px-2 py-1 rounded">{{ $brand->slug }}</code></td>
                                <td class="text-muted text-truncate" style="max-width: 250px;">{{ $brand->description ?? 'No description' }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-info-circle fs-2 d-block mb-2"></i>
                                    No brands found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer (Pagination) -->
            @if($brands->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $brands->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
