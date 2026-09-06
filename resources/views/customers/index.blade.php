@extends('layouts.adminlte')

@section('title', 'Customers')
@section('page-title', 'Customer Management')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title text-dark mb-0"><i class="bi bi-people me-2 text-primary"></i>All Customers</h5>
        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Add Customer
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td class="ps-4 text-muted">#{{ $customer->id }}</td>
                            <td class="fw-bold">{{ $customer->name }}</td>
                            <td>
                                @if($customer->mobile)
                                    <span class="badge bg-secondary"><i class="bi bi-telephone me-1"></i>{{ $customer->mobile }}</span>
                                @else
                                    <span class="text-muted fst-italic">Walk-in</span>
                                @endif
                            </td>
                            <td>{{ $customer->address ?: '-' }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
