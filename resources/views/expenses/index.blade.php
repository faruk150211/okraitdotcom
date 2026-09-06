@extends('layouts.adminlte')
@section('title', 'Expenses')
@section('page-title', 'Expense Records')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <a href="{{ route('expenses.create') }}" class="btn btn-danger btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Expense
                    </a>
                    <form action="{{ route('expenses.index') }}" method="GET" class="d-flex gap-2 align-items-center flex-wrap">
                        <select name="category" class="form-select form-select-sm" style="width:160px" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach(\App\Models\Expense::categories() as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        <div class="input-group input-group-sm" style="width:240px">
                            <input type="text" name="search" class="form-control" placeholder="Search title, notes…" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                        @if(request('search') || request('category'))
                        <a href="{{ route('expenses.index') }}" class="btn btn-outline-danger btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- Filtered total --}}
            @if(request('search') || request('category'))
            <div class="px-4 pb-2">
                <span class="text-secondary small">Filtered Total:
                    <strong class="text-danger fs-6">Tk. {{ number_format($totalAmount, 2) }}</strong>
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
                                <th>Category</th>
                                <th class="text-end">Amount</th>
                                <th>Notes</th>
                                <th class="text-end pe-4" style="width:140px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                            <tr>
                                <td class="ps-4 text-secondary">{{ ($expenses->currentPage()-1)*$expenses->perPage()+$loop->iteration }}</td>
                                <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                                <td class="fw-bold text-dark">{{ $expense->title }}</td>
                                <td>
                                    @php
                                        $catColors = ['Rent'=>'primary','Salary'=>'success','Utilities'=>'warning','Purchase'=>'info','Transport'=>'secondary','Marketing'=>'purple','Other'=>'dark'];
                                        $color = $catColors[$expense->category] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $expense->category }}</span>
                                </td>
                                <td class="text-end fw-bold text-danger">Tk. {{ number_format($expense->amount, 2) }}</td>
                                <td class="text-muted small">{{ Str::limit($expense->notes, 60) ?? '—' }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="delete-form d-inline">
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
                                    <i class="bi bi-receipt-cutoff fs-2 d-block mb-2"></i>
                                    No expenses found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($expenses->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $expenses->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
