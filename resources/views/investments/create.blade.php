@extends('layouts.adminlte')
@section('title', 'Add Investment')
@section('page-title', 'Add Investment')

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title text-dark mb-0"><i class="bi bi-piggy-bank me-2 text-success"></i>New Investment Entry</h5>
            </div>
            <form action="{{ route('investments.store') }}" method="POST">
                @csrf
                <div class="card-body row">

                    <div class="col-md-8 mb-3">
                        <label for="title" class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="e.g. Owner Capital Injection – August" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="amount" class="form-label fw-bold">Amount (Tk.) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Tk.</span>
                            <input type="number" step="0.01" min="0.01" name="amount" id="amount"
                                   class="form-control @error('amount') is-invalid @enderror"
                                   placeholder="0.00" value="{{ old('amount') }}" required>
                            @error('amount')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="investment_date" class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                        <input type="date" name="investment_date" id="investment_date"
                               class="form-control @error('investment_date') is-invalid @enderror"
                               value="{{ old('investment_date', date('Y-m-d')) }}" required>
                        @error('investment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="source" class="form-label fw-bold">Source <span class="text-danger">*</span></label>
                        <select name="source" id="source" class="form-select @error('source') is-invalid @enderror" required>
                            @foreach($sources as $src)
                            <option value="{{ $src }}" {{ old('source') == $src ? 'selected' : '' }}>{{ $src }}</option>
                            @endforeach
                        </select>
                        @error('source')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="notes" class="form-label fw-bold">Notes <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="form-control @error('notes') is-invalid @enderror"
                                  placeholder="Any additional details…">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('investments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Save Investment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
