@extends('layouts.adminlte')
@section('title', 'Add Location')
@section('page-title', 'Add Location')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title text-dark mb-0"><i class="bi bi-geo-alt me-2 text-primary"></i>New Location (Team Member)</h5>
            </div>
            <form action="{{ route('locations.store') }}" method="POST">
                @csrf
                <div class="card-body">

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g. Manik's Storage, Office Desk" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-bold">Address <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="text" name="address" id="address"
                               class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address') }}">
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label fw-bold">Notes <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_active">Active Location</label>
                    </div>

                </div>
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Save Location</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
