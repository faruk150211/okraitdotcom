@extends('layouts.adminlte')

@section('title', 'Storage History / Stock Ledger')
@section('page-title', 'Storage History')

@section('content')
<div class="row">
    <!-- Filter Card -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="GET" action="{{ route('stock.ledger') }}" class="row g-3 align-items-end">
                    
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Storage Location</label>
                        <select name="location_id" class="form-select select2">
                            <option value="">-- All Storage Locations --</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}" {{ $locationId == $loc->id ? 'selected' : '' }}>
                                    {{ $loc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Product</label>
                        <select name="product_id" class="form-select select2">
                            <option value="">-- All Products --</option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->id }}" {{ $productId == $prod->id ? 'selected' : '' }}>
                                    {{ $prod->name }} {{ $prod->model ? ' - '.$prod->model : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">From Date</label>
                        <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">To Date</label>
                        <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i> Filter</button>
                        <a href="{{ route('stock.ledger') }}" class="btn btn-outline-secondary w-100">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title text-dark mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Movement History</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Storage Location</th>
                                <th>Product Name</th>
                                <th>Movement Type</th>
                                <th class="text-end">Quantity</th>
                                <th>Notes / Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $movement)
                                <tr>
                                    <td class="text-secondary fw-semibold">
                                        {{ $movement->movement_date ? $movement->movement_date->format('d M, Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary text-white">{{ $movement->location->name ?? 'Unknown' }}</span>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        {{ $movement->product->name ?? 'Unknown' }}
                                    </td>
                                    <td>
                                        @if($movement->type === 'purchase')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                <i class="bi bi-arrow-down-left-circle me-1"></i>Purchase
                                            </span>
                                        @elseif($movement->type === 'sale')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                <i class="bi bi-arrow-up-right-circle me-1"></i>Sale
                                            </span>
                                        @elseif($movement->type === 'transfer')
                                            <span class="badge bg-info-subtle text-info border border-info-subtle">
                                                <i class="bi bi-arrow-left-right me-1"></i>Transfer
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($movement->type) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end fw-bold {{ $movement->quantity > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                                    </td>
                                    <td class="text-muted small">
                                        {{ $movement->notes ?? 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        No stock movements found matching the criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($movements->hasPages())
            <div class="card-footer bg-white border-top border-light">
                {{ $movements->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });
    </script>
@endsection
