@extends('layouts.adminlte')
@section('title', 'Sales / Invoices')
@section('page-title', 'Sales / Invoices')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-cart-check me-1"></i> New Sale
                    </a>
                    <form action="{{ route('sales.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                        <div class="input-group input-group-sm" style="width:250px">
                            <input type="text" name="search" class="form-control" placeholder="Search invoice or customer…" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                        @if(request('search'))
                        <a href="{{ route('sales.index') }}" class="btn btn-outline-danger btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th>Provided By</th>
                                <th>Total Amount</th>
                                <th>Profit</th>
                                <th>Payment</th>
                                <th class="text-end pe-4">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                            <tr>
                                <td class="ps-4 text-secondary">{{ $sale->sale_date->format('Y-m-d') }}</td>
                                <td>
                                    <code class="bg-light text-dark px-2 py-1 rounded fw-bold">{{ $sale->invoice_no }}</code>
                                </td>
                                <td class="fw-bold">
                                    {{ $sale->customer_name }}
                                    <span class="d-block text-muted small fw-normal">{{ $sale->customer_mobile }}</span>
                                </td>
                                <td><span class="badge bg-info text-dark"><i class="bi bi-geo-alt-fill me-1"></i>{{ $sale->items->first()->location->name ?? 'Mixed' }}</span></td>
                                <td class="fw-bold text-success">Tk. {{ number_format($sale->total_amount, 2) }}</td>
                                <td class="fw-bold text-primary">Tk. {{ number_format($sale->total_profit, 2) }}</td>
                                <td>
                                    @if($sale->paid_amount >= $sale->total_amount)
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($sale->paid_amount > 0)
                                        <span class="badge bg-warning text-dark">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Details
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-receipt fs-2 d-block mb-2"></i>
                                    No sales found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($sales->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $sales->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
