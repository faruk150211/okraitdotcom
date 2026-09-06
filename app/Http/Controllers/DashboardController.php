<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Product;
use App\Models\Sale;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Overall Low Stock Alerts
        // We get products where sum(quantity) across all stock movements is <= alert_quantity
        // Note: For large DBs, it's better to cache this or store current stock on products table.
        // For now, we query the ledger dynamically.
        $products = Product::with(['category', 'brand'])->get();
        
        // Aggregate stock from ledger
        $ledgerStock = StockMovement::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->pluck('total_qty', 'product_id');

        $lowStockProducts = [];
        $totalStockValue = 0;
        
        foreach ($products as $product) {
            $qty = $ledgerStock[$product->id] ?? 0;
            $totalStockValue += ($qty * $product->base_price);
            
            if ($qty <= $product->alert_quantity) {
                $product->current_stock = $qty;
                $lowStockProducts[] = $product;
            }
        }

        // 2. Stock Per Location (Team Member)
        $locations = Location::where('is_active', true)->get();
        $locationStock = StockMovement::select('location_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('location_id')
            ->pluck('total_qty', 'location_id');
            
        foreach ($locations as $loc) {
            $loc->current_stock = $locationStock[$loc->id] ?? 0;
        }

        // 3. Recent Sales Overview
        $recentSales = Sale::with('items.location')->latest('sale_date')->take(5)->get();
        $todayRevenue = Sale::whereDate('sale_date', today())->sum('total_amount');
        $todayProfit = Sale::whereDate('sale_date', today())->sum('total_profit');
        $todayExpense = \App\Models\Expense::whereDate('expense_date', today())->sum('amount');
        $todayNet = $todayProfit - $todayExpense;

        return view('dashboard', compact(
            'lowStockProducts', 
            'totalStockValue', 
            'locations', 
            'recentSales',
            'todayRevenue',
            'todayProfit',
            'todayExpense',
            'todayNet'
        ));
    }
}
