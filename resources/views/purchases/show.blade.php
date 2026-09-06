@extends('layouts.adminlte')
@section('title', 'Purchase Details')
@section('page-title', 'Purchase Details')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title text-dark mb-0 fw-bold">
                    <i class="bi bi-cart-check me-2 text-primary"></i>Purchase #{{ $purchase->id }}
                </h5>
                <span class="badge bg-light text-dark fs-6">{{ $purchase->purchase_date->format('d M Y') }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Product</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchase->items as $item)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $item->product->name }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end text-muted">Tk. {{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-end pe-4 fw-bold">Tk. {{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                                <td class="text-end pe-4 fw-bold text-primary fs-5">Tk. {{ number_format($purchase->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3 border-bottom pb-2">Information</h6>
                
                <div class="mb-3">
                    <span class="text-muted small d-block">Supplier</span>
                    <span class="fw-bold fs-6">{{ $purchase->supplier->name }}</span>
                </div>

                <div class="mb-3">
                    <span class="text-muted small d-block">Received At (Team Member)</span>
                    <span class="badge bg-info text-dark fs-6"><i class="bi bi-geo-alt-fill me-1"></i>{{ $purchase->location->name }}</span>
                </div>

                <div class="mb-3">
                    <span class="text-muted small d-block">Reference No</span>
                    <span class="fw-semibold">{{ $purchase->reference_no ?? '—' }}</span>
                </div>

                <div class="mb-3">
                    <span class="text-muted small d-block">Notes</span>
                    <p class="mb-0 small text-secondary">{{ $purchase->notes ?? '—' }}</p>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3 border-bottom pb-2">Financials</h6>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Amount:</span>
                    <span class="fw-bold">Tk. {{ number_format($purchase->total_amount, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Paid Amount:</span>
                    <span class="fw-bold text-success">Tk. {{ number_format($purchase->paid_amount, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mt-3 pt-2 border-top">
                    <span class="fw-bold">Due Balance:</span>
                    <span class="fw-bold text-danger fs-5">Tk. {{ number_format(max(0, $purchase->total_amount - $purchase->paid_amount), 2) }}</span>
                </div>
            </div>
        </div>

        <div class="mt-3 text-end">
            <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
