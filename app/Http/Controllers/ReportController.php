<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Investment;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // ── Resolve date range ─────────────────────────────────────────────
        [$from, $to] = $this->resolveDateRange($request);

        $fromDate = Carbon::parse($from)->startOfDay();
        $toDate   = Carbon::parse($to)->endOfDay();

        // ── Income (Payments received for Sales) ───────────────────────────
        $incomeRows = Payment::with('sale')->whereBetween('payment_date', [$fromDate, $toDate])->orderByDesc('payment_date')->get();
        $totalRevenue = $incomeRows->sum('amount');

        // ── Investments: capital injected ───────────────────────────────────
        $investmentRows  = Investment::whereBetween('investment_date', [$fromDate, $toDate])
            ->orderByDesc('investment_date')
            ->get();
        $totalInvestment = $investmentRows->sum('amount');

        // ── Total Money IN ──────────────────────────────────────────────────
        $totalIn = $totalRevenue + $totalInvestment;

        // ── Expenses (includes Disbursements as a category) ─────────────────
        $expenseRows  = Expense::whereBetween('expense_date', [$fromDate, $toDate])
            ->orderByDesc('expense_date')
            ->get();
        $totalExpense = $expenseRows->sum('amount');

        // Separate disbursements for reporting clarity
        $totalDisbursement = $expenseRows->where('category', 'Disbursement')->sum('amount');
        $totalOpex         = $totalExpense - $totalDisbursement;

        // ── Net Cash Position ───────────────────────────────────────────────
        // Net = (Revenue + Investments) - (OpEx + Disbursements)
        $netBalance = $totalIn - $totalExpense;

        // ── Monthly chart (last 12 months) ─────────────────────────────────
        $chartData = $this->buildMonthlyChart();

        // ── Expense breakdown by category (for the selected period) ────────
        $expenseByCategory = Expense::whereBetween('expense_date', [$fromDate, $toDate])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // ── ALL-TIME aggregates (never filtered — the true cash position) ──
        $allTimeRevenue    = Payment::sum('amount');
        $allTimeInvestment = Investment::sum('amount');
        $allTimeExpense    = Expense::sum('amount');
        $allTimeNet        = $allTimeRevenue + $allTimeInvestment - $allTimeExpense;
        $allTimeDisbursement = Expense::where('category', 'Disbursement')->sum('amount');

        return view('reports.index', compact(
            'from', 'to',
            'totalRevenue', 'totalInvestment', 'totalIn',
            'totalExpense', 'totalDisbursement', 'totalOpex',
            'netBalance',
            'incomeRows', 'investmentRows', 'expenseRows',
            'chartData', 'expenseByCategory',
            // all-time
            'allTimeRevenue', 'allTimeInvestment', 'allTimeExpense',
            'allTimeNet', 'allTimeDisbursement'
        ));
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    private function resolveDateRange(Request $request): array
    {
        $from = $request->get('from');
        $to   = $request->get('to');

        if ($from && $to) {
            return [$from, $to];
        }

        $preset = $request->get('preset');
        if ($preset) {
            return match ($preset) {
                'last7'       => [now()->subDays(6)->toDateString(),  now()->toDateString()],
                'last30'      => [now()->subDays(29)->toDateString(), now()->toDateString()],
                'last6months' => [now()->subMonths(5)->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()],
                'last12months'=> [now()->subMonths(11)->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()],
                default       => [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()],
            };
        }

        $period = $request->get('period', 'month');
        return match ($period) {
            'today'  => [now()->toDateString(), now()->toDateString()],
            'week'   => [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()],
            'year'   => [now()->startOfYear()->toDateString(), now()->endOfYear()->toDateString()],
            default  => [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()],
        };
    }

    private function buildMonthlyChart(): array
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        $revenueByMonth = Payment::select(
                DB::raw("DATE_FORMAT(payment_date, '%Y-%m') as month"),
                DB::raw('SUM(amount) as total')
            )
            ->where('payment_date', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')->pluck('total', 'month');

        $investmentByMonth = Investment::select(
                DB::raw("DATE_FORMAT(investment_date, '%Y-%m') as month"),
                DB::raw('SUM(amount) as total')
            )
            ->where('investment_date', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')->pluck('total', 'month');

        $expenseByMonth = Expense::select(
                DB::raw("DATE_FORMAT(expense_date, '%Y-%m') as month"),
                DB::raw('SUM(amount) as total')
            )
            ->where('expense_date', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')->pluck('total', 'month');

        $labels = $revenue = $investment = $expense = [];

        foreach ($months as $m) {
            $labels[]     = Carbon::parse($m . '-01')->format('M Y');
            $revenue[]    = round((float)($revenueByMonth[$m] ?? 0), 2);
            $investment[] = round((float)($investmentByMonth[$m] ?? 0), 2);
            $expense[]    = round((float)($expenseByMonth[$m] ?? 0), 2);
        }

        return compact('labels', 'revenue', 'investment', 'expense');
    }
}
