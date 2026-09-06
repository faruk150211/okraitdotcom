@extends('layouts.adminlte')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard / Inventory Hub')

@section('content')
<h6 class="fw-bold text-secondary mb-3"><i class="bi bi-calendar-day me-2"></i>Today's Financials</h6>
<div class="row mb-4">
    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="small-box bg-info shadow-sm rounded-3 h-100">
            <div class="inner p-4">
                <h3>Tk. {{ number_format($todayRevenue, 0) }}</h3>
                <p class="mb-0 fw-semibold">Today's Sales</p>
            </div>
            <div class="icon">
                <i class="bi bi-cart-check"></i>
            </div>
            <a href="{{ route('sales.index') }}" class="small-box-footer rounded-bottom-3 text-white-50">
                View all sales <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="small-box bg-primary shadow-sm rounded-3 h-100">
            <div class="inner p-4">
                <h3>Tk. {{ number_format($todayProfit, 0) }}</h3>
                <p class="mb-0 fw-semibold">Today's Gross Profit</p>
            </div>
            <div class="icon">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <a href="{{ route('sales.index') }}" class="small-box-footer rounded-bottom-3 text-white-50">
                From sales <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="small-box bg-danger shadow-sm rounded-3 h-100">
            <div class="inner p-4">
                <h3>Tk. {{ number_format($todayExpense, 0) }}</h3>
                <p class="mb-0 fw-semibold">Today's Expenses</p>
            </div>
            <div class="icon">
                <i class="bi bi-receipt-cutoff text-white opacity-50"></i>
            </div>
            <a href="{{ route('expenses.index') }}" class="small-box-footer rounded-bottom-3 text-white-50">
                View expenses <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6 mb-3 mb-lg-0">
        <div class="small-box {{ $todayNet >= 0 ? 'bg-success' : 'bg-secondary' }} shadow-sm rounded-3 h-100">
            <div class="inner p-4">
                <h3>Tk. {{ number_format($todayNet, 0) }}</h3>
                <p class="mb-0 fw-semibold">Today's Net (Profit - Expense)</p>
            </div>
            <div class="icon">
                <i class="bi bi-wallet2"></i>
            </div>
            <a href="#" class="small-box-footer rounded-bottom-3 text-white-50">
                Today's bottom line <i class="bi bi-info-circle ms-1"></i>
            </a>
        </div>
    </div>
</div>

<h6 class="fw-bold text-secondary mb-3 mt-4"><i class="bi bi-box-seam me-2"></i>Inventory & Operations</h6>
<div class="row">
    <div class="col-lg-4 col-12 mb-3 mb-lg-0">
        <div class="small-box bg-success shadow-sm rounded-3 h-100">
            <div class="inner p-4">
                <h3>Tk. {{ number_format($totalStockValue, 0) }}</h3>
                <p class="mb-0 fw-semibold">Total Stock Value</p>
            </div>
            <div class="icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <a href="{{ route('products.index') }}" class="small-box-footer rounded-bottom-3 text-white-50">
                View inventory <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-6 mb-3 mb-lg-0">
        <div class="small-box bg-warning shadow-sm rounded-3 h-100">
            <div class="inner p-4">
                <h3>{{ count($locations) }}</h3>
                <p class="mb-0 fw-semibold text-dark">Active Team Locations</p>
            </div>
            <div class="icon">
                <i class="bi bi-geo-alt-fill text-dark opacity-50"></i>
            </div>
            <a href="{{ route('locations.index') }}" class="small-box-footer rounded-bottom-3 text-dark">
                Manage team <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-6 mb-3 mb-lg-0">
        <div class="small-box bg-danger shadow-sm rounded-3 h-100">
            <div class="inner p-4">
                <h3>{{ count($lowStockProducts) }}</h3>
                <p class="mb-0 fw-semibold">Low Stock Alerts</p>
            </div>
            <div class="icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <a href="#alerts" class="small-box-footer rounded-bottom-3 text-white-50">
                View alerts <i class="bi bi-arrow-down-circle ms-1"></i>
            </a>
        </div>
    </div>
</div>

<div class="row mt-3">
    <!-- Low Stock Alerts -->
    <div class="col-lg-7" id="alerts">
        <div class="card shadow-sm border-0 border-top border-danger border-3 h-100">
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle text-danger fs-5 me-2"></i>
                <h5 class="card-title text-dark mb-0 fw-bold">Critical Stock Alerts</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Product</th>
                                <th>Category</th>
                                <th class="text-center">Min Req.</th>
                                <th class="text-center">Current</th>
                                <th class="text-center pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts as $product)
                            <tr>
                                <td class="ps-4 fw-semibold text-dark">
                                    {{ $product->name }}
                                    <span class="d-block text-muted small fw-normal">{{ $product->model }}</span>
                                </td>
                                <td><span class="badge bg-secondary">{{ $product->category->name ?? 'None' }}</span></td>
                                <td class="text-center text-muted">{{ $product->alert_quantity }}</td>
                                <td class="text-center fw-bold {{ $product->current_stock <= 0 ? 'text-danger' : 'text-warning' }}">
                                    {{ $product->current_stock }}
                                </td>
                                <td class="text-center pe-4">
                                    @if($product->current_stock <= 0)
                                        <span class="badge bg-danger-subtle text-danger border border-danger">Out of Stock</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning">Low</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-shield-check fs-1 text-success d-block mb-3"></i>
                                    All inventory levels are healthy!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock by Location -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <i class="bi bi-geo-alt-fill text-warning fs-5 me-2"></i>
                <h5 class="card-title text-dark mb-0 fw-bold">Stock By Team Member</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($locations as $loc)
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:40px; height:40px;">
                                <i class="bi bi-person-fill fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">{{ $loc->name }}</h6>
                                <span class="text-muted small">{{ $loc->address ?? 'Location/Storage' }}</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="fs-4 fw-bold text-primary">{{ $loc->current_stock }}</span>
                            <span class="d-block text-muted small mt-n1">items held</span>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-5 text-muted">
                        No team members defined yet.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="bi bi-receipt text-success fs-5 me-2"></i>
                    <h5 class="card-title text-dark mb-0 fw-bold">Recent POS Sales</h5>
                </div>
                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th>Team Member</th>
                                <th class="text-end">Amount</th>
                                <th class="text-center pe-4">Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                            <tr>
                                <td class="ps-4 text-muted">{{ $sale->sale_date->format('d M Y') }}</td>
                                <td><code class="bg-light text-dark px-2 py-1 rounded fw-bold">{{ $sale->invoice_no }}</code></td>
                                <td class="fw-semibold">{{ $sale->customer_name }}</td>
                                <td><span class="badge bg-info text-dark"><i class="bi bi-person-fill me-1"></i>{{ $sale->items->first()->location->name ?? 'Mixed' }}</span></td>
                                <td class="text-end fw-bold text-success">Tk. {{ number_format($sale->total_amount, 2) }}</td>
                                <td class="text-center pe-4">
                                    @if($sale->paid_amount >= $sale->total_amount)
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($sale->paid_amount > 0)
                                        <span class="badge bg-warning text-dark">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No sales recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
