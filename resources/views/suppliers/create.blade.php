@extends('layouts.adminlte')
@section('title', 'Add Supplier')
@section('page-title', 'Add Supplier')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title text-dark mb-0"><i class="bi bi-truck me-2 text-primary"></i>New Supplier</h5>
            </div>
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="card-body row">

                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-bold">Company / Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="contact_person" class="form-label fw-bold">Contact Person <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="text" name="contact_person" id="contact_person"
                               class="form-control @error('contact_person') is-invalid @enderror"
                               value="{{ old('contact_person') }}">
                        @error('contact_person')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="mobile" class="form-label fw-bold">Mobile / Phone <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="text" name="mobile" id="mobile"
                               class="form-control @error('mobile') is-invalid @enderror"
                               value="{{ old('mobile') }}">
                        @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-bold">Email <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="address" class="form-label fw-bold">Address <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea name="address" id="address" rows="2"
                                  class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-12 mb-3">
                        <label for="notes" class="form-label fw-bold">Notes <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea name="notes" id="notes" rows="2"
                                  class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                </div>
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Save Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
