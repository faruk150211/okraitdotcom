<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $sales = Sale::with(['items.location'])
            ->when($search, function ($query) use ($search) {
                $query->where('invoice_no', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_mobile', 'like', "%{$search}%");
            })
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('sales.index', compact('sales'));
    }

    public function create(Request $request)
    {
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        $quotation = null;
        if ($request->has('quotation_id')) {
            $quotation = Quotation::with('items.product')->findOrFail($request->quotation_id);
        }

        return view('sales.create', compact('locations', 'products', 'quotation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_mobile'  => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'sale_date'        => 'required|date',
            'invoice_no'       => 'nullable|string|max:100',
            'paid_amount'      => 'required|numeric|min:0',
            'payment_method'   => 'nullable|string|max:100',
            'notes'            => 'nullable|string',
            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.location_id' => 'required|exists:locations,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'quotation_id'     => 'nullable|exists:quotations,id',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $totalProfit = 0;
            
            $processedItems = [];
            foreach ($request->items as $item) {
                // Stock Validation
                $availableStock = StockMovement::where('product_id', $item['product_id'])
                    ->where('location_id', $item['location_id'])
                    ->sum('quantity');
                    
                if ($item['quantity'] > $availableStock) {
                    $product = Product::find($item['product_id']);
                    $loc = Location::find($item['location_id']);
                    $productName = $product ? $product->name : 'Unknown Product';
                    $locName = $loc ? $loc->name : 'Unknown Location';
                    
                    DB::rollBack();
                    return back()->with('error', "Insufficient stock! Only {$availableStock} available for '{$productName}' at '{$locName}'.")->withInput();
                }

                $product = Product::find($item['product_id']);
                $basePrice = $product ? $product->base_price : 0;
                $profit = ($item['unit_price'] - $basePrice) * $item['quantity'];
                
                $totalAmount += ($item['quantity'] * $item['unit_price']);
                $totalProfit += $profit;
                
                $processedItems[] = array_merge($item, [
                    'base_unit_price' => $basePrice,
                    'profit' => $profit
                ]);
            }

            // Generate Invoice No if missing
            $invoiceNo = $request->invoice_no;
            if (!$invoiceNo) {
                $latest = Sale::latest('id')->first();
                $invoiceNo = 'INV-' . date('Ym') . '-' . str_pad(($latest ? $latest->id + 1 : 1), 4, '0', STR_PAD_LEFT);
            }

            // Customer Handling
            $mobile = $request->customer_mobile;
            $customerName = $request->customer_name ?: 'Unknown';
            $customer = null;

            if ($mobile) {
                $customer = \App\Models\Customer::where('mobile', $mobile)->first();
                if (!$customer) {
                    $customer = \App\Models\Customer::create([
                        'name' => $customerName,
                        'mobile' => $mobile,
                        'address' => $request->customer_address,
                    ]);
                } else {
                    // Optionally update name/address if changed, but we'll leave as is for now
                }
            } else {
                $customer = \App\Models\Customer::create([
                    'name' => $customerName,
                    'address' => $request->customer_address,
                ]);
            }

            // 1. Create Sale
            $sale = Sale::create([
                'customer_id'      => $customer->id,
                'customer_name'    => $customer->name,
                'customer_mobile'  => $customer->mobile,
                'customer_address' => $customer->address,
                'quotation_id'     => $request->quotation_id,
                'sale_date'        => $request->sale_date,
                'invoice_no'       => $invoiceNo,
                'total_amount'     => $totalAmount,
                'paid_amount'      => $request->paid_amount,
                'total_profit'     => $totalProfit,
                'notes'            => $request->notes,
            ]);

            // 2. Create Items & Stock Movements
            foreach ($processedItems as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];
                
                SaleItem::create([
                    'sale_id'         => $sale->id,
                    'product_id'      => $item['product_id'],
                    'location_id'     => $item['location_id'],
                    'quantity'        => $item['quantity'],
                    'base_unit_price' => $item['base_unit_price'],
                    'unit_price'      => $item['unit_price'],
                    'subtotal'        => $subtotal,
                    'profit'          => $item['profit'],
                ]);

                // Decrease stock in ledger
                StockMovement::create([
                    'product_id'     => $item['product_id'],
                    'location_id'    => $item['location_id'],
                    'type'           => 'sale',
                    'quantity'       => -$item['quantity'], // Negative
                    'reference_type' => Sale::class,
                    'reference_id'   => $sale->id,
                    'movement_date'  => $request->sale_date,
                    'notes'          => 'Sale ' . $invoiceNo,
                ]);
            }

            // 3. Record Payment if paid
            if ($request->paid_amount > 0) {
                Payment::create([
                    'sale_id'        => $sale->id,
                    'amount'         => $request->paid_amount,
                    'payment_date'   => $request->sale_date,
                    'payment_method' => $request->payment_method ?? 'Cash',
                    'notes'          => 'Initial payment for Invoice ' . $invoiceNo,
                ]);
            }

            DB::commit();
            return redirect()->route('sales.show', $sale->id)->with('success', 'Sale completed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create sale: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['items.product', 'items.location', 'payments']);
        return view('sales.show', compact('sale'));
    }
}
