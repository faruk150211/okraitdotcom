@extends('layouts.adminlte')
@section('title', 'Sale Details')
@section('page-title', 'Sale Details')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title text-dark mb-0 fw-bold">
                    <i class="bi bi-receipt me-2 text-primary"></i>Invoice {{ $sale->invoice_no }}
                </h5>
                <span class="badge bg-light text-dark fs-6">{{ $sale->sale_date->format('d M Y') }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Product</th>
                                <th>Team Member</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $item->product->name }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $item->location->name ?? 'Unknown' }}</span></td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end text-muted">Tk. {{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-end pe-4 fw-bold">Tk. {{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Grand Total:</td>
                                <td class="text-end pe-4 fw-bold text-success fs-5">Tk. {{ number_format($sale->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-bold mb-3 border-bottom pb-2">Payment History</h6>
                @if($sale->payments->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($sale->payments as $payment)
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Tk. {{ number_format($payment->amount, 2) }}</strong>
                            <span class="text-muted ms-2 small">{{ $payment->payment_date->format('d M Y') }}</span>
                        </div>
                        <span class="badge bg-secondary">{{ $payment->payment_method }}</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted small mb-0">No payments recorded.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3 border-bottom pb-2">Information</h6>
                
                <div class="mb-3">
                    <span class="text-muted small d-block">Customer</span>
                    <span class="fw-bold fs-6 d-block">{{ $sale->customer_name }}</span>
                    <span class="text-secondary small"><i class="bi bi-telephone-fill me-1"></i>{{ $sale->customer_mobile }}</span>
                    @if($sale->customer_address)
                    <span class="text-secondary small d-block mt-1"><i class="bi bi-geo-alt-fill me-1"></i>{{ $sale->customer_address }}</span>
                    @endif
                </div>

                @if($sale->quotation_id)
                <div class="mb-3">
                    <span class="text-muted small d-block">Generated From</span>
                    <a href="{{ route('quotations.show', $sale->quotation_id) }}" class="fw-semibold text-decoration-none">
                        Quotation #{{ $sale->quotation_id }}
                    </a>
                </div>
                @endif
                
                @if($sale->notes)
                <div class="mb-3">
                    <span class="text-muted small d-block">Notes</span>
                    <p class="mb-0 small text-secondary">{{ $sale->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3 border-bottom pb-2">Financials</h6>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Amount:</span>
                    <span class="fw-bold">Tk. {{ number_format($sale->total_amount, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2 no-print bg-primary-subtle p-2 rounded">
                    <span class="text-primary fw-bold"><i class="bi bi-graph-up-arrow me-1"></i>Net Profit:</span>
                    <span class="fw-bold text-primary">Tk. {{ number_format($sale->total_profit, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Paid Amount:</span>
                    <span class="fw-bold text-success">Tk. {{ number_format($sale->paid_amount, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mt-3 pt-2 border-top">
                    <span class="fw-bold">Due Balance:</span>
                    <span class="fw-bold text-danger fs-5">Tk. {{ number_format(max(0, $sale->total_amount - $sale->paid_amount), 2) }}</span>
                </div>
                
                {{-- Quick Add Payment Form (Optional for Phase 3 but useful) --}}
                @if($sale->paid_amount < $sale->total_amount)
                <form action="{{ route('payments.store', $sale->id) }}" method="POST" class="mt-4 pt-3 border-top">
                    @csrf
                    <input type="hidden" name="type" value="sale">
                    <div class="input-group input-group-sm">
                        <input type="number" name="amount" class="form-control" placeholder="Amount..." min="1" max="{{ $sale->total_amount - $sale->paid_amount }}" required>
                        <select name="payment_method" class="form-select" style="max-width: 100px;">
                            <option>Cash</option>
                            <option>Bank</option>
                            <option>bKash</option>
                        </select>
                        <button class="btn btn-success" type="submit">Pay</button>
                    </div>
                </form>
                @endif
            </div>
        </div>

        <div class="mt-3 text-end">
            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if(request('print'))
<script>
    window.onload = function() {
        window.print();
        setTimeout(function() { window.close(); }, 500);
    };
</script>
<style>
    @media print {
        .app-header, .app-sidebar, .no-print, .btn { display: none !important; }
        body, .app-wrapper, .app-main { background: #fff !important; color: #000 !important; }
        .card { box-shadow: none !important; border: none !important; }
    }
</style>
@endif
@endsection
