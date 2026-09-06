@extends('layouts.adminlte')
@section('title', 'Purchases')
@section('page-title', 'Purchases')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-cart-plus me-1"></i> New Purchase
                    </a>
                    <form action="{{ route('purchases.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                        <div class="input-group input-group-sm" style="width:250px">
                            <input type="text" name="search" class="form-control" placeholder="Search reference or supplier…" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                        @if(request('search'))
                        <a href="{{ route('purchases.index') }}" class="btn btn-outline-danger btn-sm">Reset</a>
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
                                <th>Reference</th>
                                <th>Supplier</th>
                                <th>Received At (Location)</th>
                                <th>Total Amount</th>
                                <th>Payment</th>
                                <th class="text-end pe-4">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $purchase)
                            <tr>
                                <td class="ps-4 text-secondary">{{ $purchase->purchase_date->format('Y-m-d') }}</td>
                                <td>
                                    @if($purchase->reference_no)
                                        <code class="bg-light text-dark px-2 py-1 rounded fw-bold">{{ $purchase->reference_no }}</code>
                                    @else — @endif
                                </td>
                                <td class="fw-bold">{{ $purchase->supplier->name }}</td>
                                <td><span class="badge bg-info text-dark"><i class="bi bi-geo-alt-fill me-1"></i>{{ $purchase->location->name }}</span></td>
                                <td class="fw-bold">Tk. {{ number_format($purchase->total_amount, 2) }}</td>
                                <td>
                                    @if($purchase->paid_amount >= $purchase->total_amount)
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($purchase->paid_amount > 0)
                                        <span class="badge bg-warning text-dark">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Details
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-cart-x fs-2 d-block mb-2"></i>
                                    No purchases found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($purchases->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $purchases->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
