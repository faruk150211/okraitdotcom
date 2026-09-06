@extends('layouts.adminlte')

@section('title', 'Quotations')
@section('page-title', 'Quotations')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header & Search -->
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <a href="{{ route('quotations.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Create Quotation
                    </a>
                    
                    <form action="{{ route('quotations.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                        <!-- Search Box -->
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="search" class="form-control" placeholder="Search customer, mobile, quote..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>

                        @if(request('search'))
                        <a href="{{ route('quotations.index') }}" class="btn btn-outline-danger btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Card Body (Table) -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">SL</th>
                                <th>Quotation No</th>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Mobile</th>
                                <th class="text-end">Grand Total</th>
                                <th class="text-end">Paid</th>
                                <th class="text-end">Due</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4" style="width: 180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($quotations as $quotation)
                            <tr>
                                <td class="ps-4 text-secondary">{{ ($quotations->currentPage() - 1) * $quotations->perPage() + $loop->iteration }}</td>
                                <td>
                                    <code class="bg-light text-dark px-2 py-1 rounded fw-bold">{{ $quotation->quotation_no }}</code>
                                </td>
                                <td>{{ $quotation->quotation_date->format('Y-m-d') }}</td>
                                <td class="fw-bold text-dark">{{ $quotation->customer_name }}</td>
                                <td>{{ $quotation->customer_mobile }}</td>
                                <td class="text-end fw-bold text-success">{{ number_format($quotation->grand_total, 2) }}</td>
                                <td class="text-end fw-bold text-primary">{{ number_format($quotation->amount_paid, 2) }}</td>
                                <td class="text-end fw-bold {{ $quotation->due_amount > 0 ? 'text-danger' : 'text-muted' }}">
                                    {{ number_format($quotation->due_amount, 2) }}
                                </td>
                                <td class="text-center">
                                    @if($quotation->payment_status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($quotation->payment_status === 'partial')
                                        <span class="badge bg-warning text-dark">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('quotations.show', $quotation->id) }}" class="btn btn-outline-info btn-sm me-1" title="View / Pay">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('quotations.destroy', $quotation->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="bi bi-file-earmark-text fs-2 d-block mb-2"></i>
                                    No quotations found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer (Pagination) -->
            @if($quotations->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $quotations->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
