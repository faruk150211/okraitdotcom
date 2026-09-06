@extends('layouts.adminlte')
@section('title', 'Locations')
@section('page-title', 'Team / Locations')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('locations.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Location
                    </a>
                    <form action="{{ route('locations.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                        <div class="input-group input-group-sm" style="width:250px">
                            <input type="text" name="search" class="form-control" placeholder="Search name, address…" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                        @if(request('search'))
                        <a href="{{ route('locations.index') }}" class="btn btn-outline-danger btn-sm">Reset</a>
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
                                <th>Status</th>
                                <th>Address</th>
                                <th>Notes</th>
                                <th class="text-end pe-4" style="width:140px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locations as $location)
                            <tr>
                                <td class="ps-4 text-secondary">{{ ($locations->currentPage()-1)*$locations->perPage()+$loop->iteration }}</td>
                                <td class="fw-bold text-dark">{{ $location->name }}</td>
                                <td>
                                    @if($location->is_active)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ Str::limit($location->address, 40) ?? '—' }}</td>
                                <td class="text-muted small">{{ Str::limit($location->notes, 40) ?? '—' }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('locations.destroy', $location->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-geo-alt fs-2 d-block mb-2"></i>
                                    No locations found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($locations->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $locations->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
