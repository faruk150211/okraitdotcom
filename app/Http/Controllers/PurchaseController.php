<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Location;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $purchases = Purchase::with(['supplier', 'location'])
            ->when($search, function ($query) use ($search) {
                $query->where('reference_no', 'like', "%{$search}%")
                      ->orWhereHas('supplier', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('purchases.create', compact('suppliers', 'locations', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'      => 'required|exists:suppliers,id',
            'location_id'      => 'required|exists:locations,id',
            'purchase_date'    => 'required|date',
            'reference_no'     => 'nullable|string|max:100',
            'paid_amount'      => 'required|numeric|min:0',
            'notes'            => 'nullable|string',
            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += ($item['quantity'] * $item['unit_price']);
            }

            // 1. Create Purchase
            $purchase = Purchase::create([
                'supplier_id'   => $request->supplier_id,
                'location_id'   => $request->location_id,
                'purchase_date' => $request->purchase_date,
                'reference_no'  => $request->reference_no,
                'total_amount'  => $totalAmount,
                'paid_amount'   => $request->paid_amount,
                'notes'         => $request->notes,
            ]);

            // 2. Create Items & Stock Movements
            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];
                
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id'  => $item['product_id'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                    'subtotal'    => $subtotal,
                ]);

                // Increase stock in ledger
                StockMovement::create([
                    'product_id'     => $item['product_id'],
                    'location_id'    => $request->location_id,
                    'type'           => 'purchase',
                    'quantity'       => $item['quantity'], // Positive
                    'reference_type' => Purchase::class,
                    'reference_id'   => $purchase->id,
                    'movement_date'  => $request->purchase_date,
                    'notes'          => 'Purchase ' . ($request->reference_no ?? '#' . $purchase->id),
                ]);
            }

            // 3. Create Expense Record for Financial Integration (Money Out)
            if ($request->paid_amount > 0) {
                Expense::create([
                    'title'        => 'Purchase Payment: Supplier ' . $purchase->supplier->name,
                    'category'     => 'Purchase',
                    'amount'       => $request->paid_amount,
                    'expense_date' => $request->purchase_date,
                    'notes'        => 'Linked to Purchase #' . $purchase->id . ($request->reference_no ? ' (' . $request->reference_no . ')' : ''),
                ]);
            }

            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Purchase recorded successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create purchase: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['items.product', 'supplier', 'location']);
        return view('purchases.show', compact('purchase'));
    }

    // Note: For an ERP, updating and deleting purchases is highly complex because it requires 
    // reversing stock movements and financial expenses. For Phase 2, we will disable them.
}
