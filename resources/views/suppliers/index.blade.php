@extends('layouts.adminlte')
@section('title', 'Suppliers')
@section('page-title', 'Suppliers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Supplier
                    </a>
                    <form action="{{ route('suppliers.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                        <div class="input-group input-group-sm" style="width:300px">
                            <input type="text" name="search" class="form-control" placeholder="Search name, phone, contact…" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                        @if(request('search'))
                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-danger btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width:60px">SL</th>
                                <th>Name</th>
                                <th>Contact Person</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th class="text-end pe-4" style="width:140px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $supplier)
                            <tr>
                                <td class="ps-4 text-secondary">{{ ($suppliers->currentPage()-1)*$suppliers->perPage()+$loop->iteration }}</td>
                                <td class="fw-bold text-dark">{{ $supplier->name }}</td>
                                <td class="text-muted">{{ $supplier->contact_person ?? '—' }}</td>
                                <td>
                                    @if($supplier->mobile)
                                    <span class="badge bg-secondary">{{ $supplier->mobile }}</span>
                                    @else — @endif
                                </td>
                                <td class="text-muted small">{{ $supplier->email ?? '—' }}</td>
                                <td class="text-muted small">{{ Str::limit($supplier->address, 30) ?? '—' }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-truck fs-2 d-block mb-2"></i>
                                    No suppliers found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($suppliers->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $suppliers->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
