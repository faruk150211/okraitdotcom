@extends('layouts.adminlte')

@section('title', 'Create Brand')
@section('page-title', 'Create Brand')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title text-dark mb-0">Brand Information</h5>
            </div>
            
            <form action="{{ route('brands.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <!-- Name Input -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Brand Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Samsung" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug Input -->
                    <div class="mb-3">
                        <label for="slug" class="form-label fw-bold">Slug (SEO URL)</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="e.g. samsung" value="{{ old('slug') }}" required>
                        <div class="form-text text-muted">Unique identifier used in URLs.</div>
                        @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description Input -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Optional description of the brand...">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Brand</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const nameInput = document.getElementById("name");
        const slugInput = document.getElementById("slug");

        nameInput.addEventListener("input", function() {
            const slugValue = nameInput.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, "") // Remove non-word chars
                .replace(/[\s_-]+/g, "-") // Replace spaces/underscores with single dash
                .replace(/^-+|-+$/g, ""); // Trim leading/trailing dashes
            slugInput.value = slugValue;
        });
    });
</script>
@endsection
