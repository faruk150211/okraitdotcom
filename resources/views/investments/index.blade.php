@extends('layouts.adminlte')
@section('title', 'Investments')
@section('page-title', 'Investment Records')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <a href="{{ route('investments.create') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Investment
                    </a>
                    <form action="{{ route('investments.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                        <div class="input-group input-group-sm" style="width:250px">
                            <input type="text" name="search" class="form-control" placeholder="Search title, notes…" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                        @if(request('search'))
                        <a href="{{ route('investments.index') }}" class="btn btn-outline-danger btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            @if(request('search'))
            <div class="px-4 pb-2">
                <span class="text-secondary small">Filtered Total:
                    <strong class="text-success fs-6">Tk. {{ number_format($totalAmount, 2) }}</strong>
                </span>
            </div>
            @endif

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width:60px">SL</th>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Source</th>
                                <th class="text-end">Amount</th>
                                <th>Notes</th>
                                <th class="text-end pe-4" style="width:140px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($investments as $investment)
                            <tr>
                                <td class="ps-4 text-secondary">{{ ($investments->currentPage()-1)*$investments->perPage()+$loop->iteration }}</td>
                                <td>{{ $investment->investment_date->format('Y-m-d') }}</td>
                                <td class="fw-bold text-dark">{{ $investment->title }}</td>
                                <td>
                                    @php $srcColors=['Owner'=>'success','Loan'=>'warning','Grant'=>'info','Other'=>'secondary']; @endphp
                                    <span class="badge bg-{{ $srcColors[$investment->source] ?? 'secondary' }}">{{ $investment->source }}</span>
                                </td>
                                <td class="text-end fw-bold text-success">Tk. {{ number_format($investment->amount, 2) }}</td>
                                <td class="text-muted small">{{ Str::limit($investment->notes, 60) ?? '—' }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('investments.edit', $investment->id) }}" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('investments.destroy', $investment->id) }}" method="POST" class="delete-form d-inline">
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
                                    <i class="bi bi-piggy-bank fs-2 d-block mb-2"></i>
                                    No investment records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($investments->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $investments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
