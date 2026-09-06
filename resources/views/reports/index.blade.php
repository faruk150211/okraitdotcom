@extends('layouts.adminlte')
@section('title', 'Financial Reports')
@section('page-title', 'Financial Reports')

@section('styles')
<style>
    .period-btn { border-radius: 20px; font-size: 0.8rem; padding: 4px 14px; }
    .period-btn.active { font-weight: 700; }
    .stat-card { border-radius: 12px; border: none; transition: transform .15s; }
    .stat-card:hover { transform: translateY(-2px); }
    .stat-icon { width: 52px; height: 52px; border-radius: 12px; display:flex; align-items:center; justify-content:center; font-size: 1.4rem; flex-shrink:0; }
    .section-tab { cursor:pointer; padding: 8px 20px; border-radius: 20px; font-size:.85rem; font-weight:600; border:1px solid #dee2e6; background:transparent; }
    .section-tab.active { background:#0d6efd; color:#fff; border-color:#0d6efd; }

    /* All-time banner */
    .alltime-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
        border-radius: 16px;
        color: #fff;
    }
    .alltime-banner .label   { font-size: .75rem; letter-spacing: .06em; text-transform: uppercase; opacity: .65; }
    .alltime-banner .amount  { font-size: 1.3rem; font-weight: 700; }
    .alltime-banner .divider { border-left: 1px solid rgba(255,255,255,.18); }
    .alltime-banner .net-positive { color: #4ade80; }
    .alltime-banner .net-negative { color: #f87171; }

    /* Section heading chip */
    .section-chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f1f5f9; border-radius: 8px;
        padding: 6px 14px; font-size: .8rem; font-weight: 600;
        color: #64748b; margin-bottom: 1rem;
    }
    .section-chip span { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{-- VIEW 1 — ALL-TIME NET CASH POSITION (date-filter independent)        --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}
<div class="alltime-banner p-4 mb-4">
    <div class="d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-bank fs-5"></i>
        <span style="font-size:.8rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; opacity:.8">
            Current Cash Position — All Time (Never Filtered)
        </span>
    </div>
    <div class="row g-0 align-items-center">

        {{-- Revenue --}}
        <div class="col-6 col-md-3 pe-3">
            <div class="label mb-1">+ Revenue</div>
            <div class="amount text-success-emphasis" style="color:#86efac">
                Tk. {{ number_format($allTimeRevenue, 2) }}
            </div>
        </div>
        <div class="col-auto divider d-none d-md-block mx-2" style="height:48px"></div>

        {{-- Investments --}}
        <div class="col-6 col-md-3 pe-3">
            <div class="label mb-1">+ Investments</div>
            <div class="amount" style="color:#93c5fd">
                Tk. {{ number_format($allTimeInvestment, 2) }}
            </div>
        </div>
        <div class="col-auto divider d-none d-md-block mx-2" style="height:48px"></div>

        {{-- Expenses --}}
        <div class="col-6 col-md-3 pe-3 mt-3 mt-md-0">
            <div class="label mb-1">− Expenses & Disbursements</div>
            <div class="amount" style="color:#fca5a5">
                Tk. {{ number_format($allTimeExpense, 2) }}
                @if($allTimeDisbursement > 0)
                <small style="font-size:.7rem; opacity:.7">(Disb: Tk.{{ number_format($allTimeDisbursement,2) }})</small>
                @endif
            </div>
        </div>
        <div class="col-auto divider d-none d-md-block mx-2" style="height:48px"></div>

        {{-- Net --}}
        <div class="col-6 col-md-2 mt-3 mt-md-0">
            <div class="label mb-1">= Net Cash Balance</div>
            <div class="amount fs-5 fw-bold {{ $allTimeNet >= 0 ? 'net-positive' : 'net-negative' }}">
                {{ $allTimeNet >= 0 ? '+' : '' }}Tk. {{ number_format(abs($allTimeNet), 2) }}
            </div>
            <div style="font-size:.72rem; opacity:.6; margin-top:2px">
                {{ $allTimeNet >= 0 ? '▲ Surplus' : '▼ Deficit' }}
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{-- VIEW 2 — PERIOD ANALYSIS (affected by date filter)                   --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}

{{-- Filter Bar --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body py-3">
        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
            <span class="text-secondary small fw-semibold me-1">Period:</span>
            @foreach(['today'=>'Today','week'=>'This Week','month'=>'This Month','year'=>'This Year'] as $key=>$label)
            <a href="{{ route('reports.index', ['period' => $key]) }}"
               class="btn btn-sm period-btn {{ (!request('from') && !request('preset') && request('period','month')===$key) ? 'btn-primary active' : 'btn-outline-secondary' }}">
               {{ $label }}
            </a>
            @endforeach
            <span class="text-secondary small fw-semibold ms-3 me-1">Presets:</span>
            @foreach(['last7'=>'Last 7 Days','last30'=>'Last 30 Days','last6months'=>'Last 6 Months','last12months'=>'Last 12 Months'] as $key=>$label)
            <a href="{{ route('reports.index', ['preset' => $key]) }}"
               class="btn btn-sm period-btn {{ request('preset')===$key ? 'btn-info active text-white' : 'btn-outline-secondary' }}">
               {{ $label }}
            </a>
            @endforeach
        </div>
        <form action="{{ route('reports.index') }}" method="GET" class="d-flex flex-wrap align-items-end gap-2">
            <div>
                <label class="form-label small fw-semibold mb-1 text-secondary">From</label>
                <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from', $from) }}">
            </div>
            <div>
                <label class="form-label small fw-semibold mb-1 text-secondary">To</label>
                <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to', $to) }}">
            </div>
            <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-funnel me-1"></i> Apply Range</button>
            @if(request('from'))
            <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-danger">Reset</a>
            @endif
            <span class="text-muted small align-self-end ms-2">
                Showing: <strong>{{ \Carbon\Carbon::parse($from)->format('d M Y') }}</strong>
                → <strong>{{ \Carbon\Carbon::parse($to)->format('d M Y') }}</strong>
            </span>
        </form>
    </div>
</div>

{{-- Period label --}}
<div class="section-chip">
    <span style="background:#6366f1"></span>
    Period Analysis &nbsp;·&nbsp;
    {{ \Carbon\Carbon::parse($from)->format('d M Y') }} → {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
</div>

{{-- Period Summary Cards --}}
<div class="row g-3 mb-4">
    {{-- Period Revenue --}}
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-4">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div>
                    <div class="text-secondary small fw-semibold">Revenue (Period)</div>
                    <div class="fs-5 fw-bold text-success">Tk. {{ number_format($totalRevenue, 2) }}</div>
                    <div class="text-muted small">{{ $incomeRows->count() }} payment(s)</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Period Investments --}}
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-4">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-piggy-bank-fill"></i>
                </div>
                <div>
                    <div class="text-secondary small fw-semibold">Investments (Period)</div>
                    <div class="fs-5 fw-bold text-primary">Tk. {{ number_format($totalInvestment, 2) }}</div>
                    <div class="text-muted small">{{ $investmentRows->count() }} injection(s)</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Period Expenses --}}
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-4">
                <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                </div>
                <div>
                    <div class="text-secondary small fw-semibold">Expenses (Period)</div>
                    <div class="fs-5 fw-bold text-danger">Tk. {{ number_format($totalExpense, 2) }}</div>
                    <div class="text-muted small">
                        OpEx: Tk.{{ number_format($totalOpex,2) }}
                        @if($totalDisbursement > 0)· Disb: Tk.{{ number_format($totalDisbursement,2) }}@endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Period Net Change --}}
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card shadow-sm h-100 {{ $netBalance >= 0 ? 'border-start border-success border-3' : 'border-start border-danger border-3' }}">
            <div class="card-body d-flex align-items-center gap-3 py-4">
                <div class="stat-icon {{ $netBalance >= 0 ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div>
                    <div class="text-secondary small fw-semibold">Net Change (Period)</div>
                    <div class="fs-5 fw-bold {{ $netBalance >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $netBalance >= 0 ? '+' : '' }}Tk. {{ number_format(abs($netBalance), 2) }}
                    </div>
                    <div class="small fw-semibold {{ $netBalance >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $netBalance >= 0 ? '▲ Gain' : '▼ Loss' }} this period
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Chart ──────────────────────────────────────────────────────────── --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Revenue / Investments / Expenses — Last 12 Months</h6>
    </div>
    <div class="card-body">
        <canvas id="monthlyChart" height="90"></canvas>
    </div>
</div>

{{-- ── Expense category breakdown ─────────────────────────────────────── --}}
@if($expenseByCategory->count() > 0)
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-pie-chart-fill me-2 text-danger"></i>Expense Breakdown by Category (Period)</h6>
    </div>
    <div class="card-body">
        <div class="row g-2">
            @php $catColors=['Rent'=>'primary','Salary'=>'success','Utilities'=>'warning','Purchase'=>'info','Transport'=>'secondary','Marketing'=>'danger','Disbursement'=>'dark','Other'=>'secondary']; @endphp
            @foreach($expenseByCategory as $row)
            <div class="col-md-2 col-4">
                <div class="border rounded p-3 text-center">
                    <div class="badge bg-{{ $catColors[$row->category] ?? 'secondary' }} mb-1">{{ $row->category }}</div>
                    <div class="fw-bold text-dark small">Tk. {{ number_format($row->total, 2) }}</div>
                    <div class="text-muted" style="font-size:.75rem">{{ number_format($row->total / max($totalExpense,1) * 100, 1) }}%</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ── Transaction tabs ───────────────────────────────────────────────── --}}
<div class="d-flex gap-2 mb-3 flex-wrap">
    <button class="section-tab active" onclick="showTab('revenue', this)">
        <i class="bi bi-cash-coin me-1"></i> Revenue ({{ $incomeRows->count() }})
    </button>
    <button class="section-tab" onclick="showTab('investments', this)">
        <i class="bi bi-piggy-bank me-1"></i> Investments ({{ $investmentRows->count() }})
    </button>
    <button class="section-tab" onclick="showTab('expenses', this)">
        <i class="bi bi-receipt-cutoff me-1"></i> Expenses ({{ $expenseRows->count() }})
    </button>
</div>

{{-- Revenue Tab --}}
<div id="tab-revenue" class="card shadow-sm border-0 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width:50px">#</th>
                        <th>Date</th><th>Invoice No</th><th>Customer</th><th>Method</th><th>Reference</th>
                        <th class="text-end pe-4">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($incomeRows as $i => $payment)
                    <tr>
                        <td class="ps-4 text-secondary">{{ $i+1 }}</td>
                        <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                        <td>
                            @if($payment->sale)
                                <code class="bg-light text-dark px-2 py-1 rounded fw-bold">{{ $payment->sale->invoice_no ?? 'SALE-'.$payment->sale->id }}</code>
                            @else —
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $payment->sale->customer_name ?? '—' }}</td>
                        <td><span class="badge bg-secondary">{{ $payment->payment_method }}</span></td>
                        <td class="text-muted small">{{ $payment->reference_no ?? '—' }}</td>
                        <td class="text-end pe-4 fw-bold text-success">Tk. {{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>No revenue in this period.</td></tr>
                    @endforelse
                </tbody>
                @if($incomeRows->count() > 0)
                <tfoot class="table-light">
                    <tr>
                        <td colspan="6" class="text-end fw-bold pe-3">Period Total:</td>
                        <td class="text-end pe-4 fw-bold text-success fs-6">Tk. {{ number_format($totalRevenue, 2) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

{{-- Investments Tab --}}
<div id="tab-investments" class="card shadow-sm border-0 mb-4 d-none">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width:50px">#</th>
                        <th>Date</th><th>Title</th><th>Source</th><th>Notes</th>
                        <th class="text-end pe-4">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($investmentRows as $i => $inv)
                    @php $srcColors=['Owner'=>'success','Loan'=>'warning','Grant'=>'info','Other'=>'secondary']; @endphp
                    <tr>
                        <td class="ps-4 text-secondary">{{ $i+1 }}</td>
                        <td>{{ $inv->investment_date->format('Y-m-d') }}</td>
                        <td class="fw-semibold">{{ $inv->title }}</td>
                        <td><span class="badge bg-{{ $srcColors[$inv->source] ?? 'secondary' }}">{{ $inv->source }}</span></td>
                        <td class="text-muted small">{{ Str::limit($inv->notes, 60) ?? '—' }}</td>
                        <td class="text-end pe-4 fw-bold text-primary">Tk. {{ number_format($inv->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>No investments in this period.</td></tr>
                    @endforelse
                </tbody>
                @if($investmentRows->count() > 0)
                <tfoot class="table-light">
                    <tr>
                        <td colspan="5" class="text-end fw-bold pe-3">Period Total:</td>
                        <td class="text-end pe-4 fw-bold text-primary fs-6">Tk. {{ number_format($totalInvestment, 2) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

{{-- Expenses Tab --}}
<div id="tab-expenses" class="card shadow-sm border-0 mb-4 d-none">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width:50px">#</th>
                        <th>Date</th><th>Title</th><th>Category</th><th>Notes</th>
                        <th class="text-end pe-4">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenseRows as $i => $expense)
                    @php $catColors=['Rent'=>'primary','Salary'=>'success','Utilities'=>'warning','Purchase'=>'info','Transport'=>'secondary','Marketing'=>'danger','Disbursement'=>'dark','Other'=>'secondary']; @endphp
                    <tr>
                        <td class="ps-4 text-secondary">{{ $i+1 }}</td>
                        <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                        <td class="fw-semibold">{{ $expense->title }}</td>
                        <td><span class="badge bg-{{ $catColors[$expense->category] ?? 'secondary' }}">{{ $expense->category }}</span></td>
                        <td class="text-muted small">{{ Str::limit($expense->notes, 60) ?? '—' }}</td>
                        <td class="text-end pe-4 fw-bold text-danger">Tk. {{ number_format($expense->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>No expenses in this period.</td></tr>
                    @endforelse
                </tbody>
                @if($expenseRows->count() > 0)
                <tfoot class="table-light">
                    <tr>
                        <td colspan="5" class="text-end fw-bold pe-3">Period Total:</td>
                        <td class="text-end pe-4 fw-bold text-danger fs-6">Tk. {{ number_format($totalExpense, 2) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
function showTab(name, el) {
    ['revenue','investments','expenses'].forEach(t => document.getElementById('tab-'+t).classList.add('d-none'));
    document.getElementById('tab-' + name).classList.remove('d-none');
    document.querySelectorAll('.section-tab').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
}

const chartData = @json($chartData);
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: chartData.labels,
        datasets: [
            {
                label: 'Revenue (Tk.)',
                data: chartData.revenue,
                backgroundColor: 'rgba(25,135,84,0.75)',
                borderColor: 'rgba(25,135,84,1)',
                borderWidth: 1, borderRadius: 5,
            },
            {
                label: 'Investments (Tk.)',
                data: chartData.investment,
                backgroundColor: 'rgba(13,110,253,0.70)',
                borderColor: 'rgba(13,110,253,1)',
                borderWidth: 1, borderRadius: 5,
            },
            {
                label: 'Expenses (Tk.)',
                data: chartData.expense,
                backgroundColor: 'rgba(220,53,69,0.70)',
                borderColor: 'rgba(220,53,69,1)',
                borderWidth: 1, borderRadius: 5,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            tooltip: {
                callbacks: {
                    label: ctx => ' Tk. ' + ctx.parsed.y.toLocaleString('en-BD', {minimumFractionDigits:2})
                }
            }
        },
        scales: {
            y: { beginAtZero: true, ticks: { callback: v => 'Tk. ' + v.toLocaleString() } }
        }
    }
});
</script>
@endsection
