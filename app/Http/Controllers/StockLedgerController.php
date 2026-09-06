<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockLedgerController extends Controller
{
    /**
     * Display the stock ledger (Storage History).
     */
    public function index(Request $request)
    {
        $locations = Location::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        $locationId = $request->get('location_id');
        $productId = $request->get('product_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $movements = StockMovement::with(['product', 'location'])
            ->when($locationId, function ($query) use ($locationId) {
                $query->where('location_id', $locationId);
            })
            ->when($productId, function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('movement_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('movement_date', '<=', $dateTo);
            })
            ->orderByDesc('movement_date')
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        return view('stock_ledger.index', compact(
            'movements', 'locations', 'products', 
            'locationId', 'productId', 'dateFrom', 'dateTo'
        ));
    }
}
