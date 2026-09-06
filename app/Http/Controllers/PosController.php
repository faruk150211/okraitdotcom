<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        // Load all active locations for the salesperson to pick where they are selling from
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        
        // Load products for the grid (assuming they are active)
        $products = Product::orderBy('name')->get();

        return view('pos.index', compact('locations', 'products'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name'    => 'nullable|string|max:255',
            'customer_mobile'  => 'nullable|string|max:20',
            'payment_method'   => 'required|string',
            'paid_amount'      => 'required|numeric|min:0',
            'cart'             => 'required|string', // JSON string from frontend
        ]);

        $cart = json_decode($request->cart, true);
        if (!$cart || count($cart) === 0) {
            return back()->with('error', 'Cart is empty!');
        }

        // Validate each item has a location
        foreach ($cart as $item) {
            if (empty($item['location_id'])) {
                return back()->with('error', 'Please select a Team Member for all items in the cart.');
            }
        }

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $totalProfit = 0;
            
            // Pre-calculate totals and profit before creating sale
            $processedCart = [];
            foreach ($cart as $item) {
                // Stock Validation
                $availableStock = StockMovement::where('product_id', $item['id'])
                    ->where('location_id', $item['location_id'])
                    ->sum('quantity');
                    
                if ($item['quantity'] > $availableStock) {
                    $product = Product::find($item['id']);
                    $loc = Location::find($item['location_id']);
                    $productName = $product ? $product->name : 'Unknown Product';
                    $locName = $loc ? $loc->name : 'Unknown Location';
                    
                    DB::rollBack();
                    return back()->with('error', "Insufficient stock! Only {$availableStock} available for '{$productName}' at '{$locName}'.");
                }

                $product = Product::find($item['id']);
                $basePrice = $product ? $product->base_price : 0;
                $profit = ($item['price'] - $basePrice) * $item['quantity'];
                
                $totalAmount += ($item['quantity'] * $item['price']);
                $totalProfit += $profit;
                
                $processedCart[] = array_merge($item, [
                    'base_unit_price' => $basePrice,
                    'profit' => $profit
                ]);
            }

            // Generate Invoice No
            $latest = Sale::latest('id')->first();
            $invoiceNo = 'POS-' . date('Ym') . '-' . str_pad(($latest ? $latest->id + 1 : 1), 4, '0', STR_PAD_LEFT);

            // Customer Handling
            $mobile = $request->customer_mobile;
            $customerName = $request->customer_name ?: 'Walk-in Customer';
            $customer = null;

            if ($mobile) {
                $customer = \App\Models\Customer::where('mobile', $mobile)->first();
                if (!$customer) {
                    $customer = \App\Models\Customer::create([
                        'name' => $customerName,
                        'mobile' => $mobile,
                    ]);
                }
            } else {
                $customer = \App\Models\Customer::create([
                    'name' => $customerName,
                ]);
            }

            // 1. Create Sale
            $sale = Sale::create([
                'customer_id'      => $customer->id,
                'customer_name'    => $customer->name,
                'customer_mobile'  => $customer->mobile,
                'sale_date'        => today(),
                'invoice_no'       => $invoiceNo,
                'total_amount'     => $totalAmount,
                'paid_amount'      => $request->paid_amount,
                'total_profit'     => $totalProfit,
                'notes'            => 'POS Sale',
            ]);

            // 2. Create Items & Deduct Stock
            foreach ($processedCart as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                
                SaleItem::create([
                    'sale_id'         => $sale->id,
                    'product_id'      => $item['id'],
                    'location_id'     => $item['location_id'],
                    'quantity'        => $item['quantity'],
                    'base_unit_price' => $item['base_unit_price'],
                    'unit_price'      => $item['price'],
                    'subtotal'        => $subtotal,
                    'profit'          => $item['profit'],
                ]);

                // Decrease stock
                StockMovement::create([
                    'product_id'     => $item['id'],
                    'location_id'    => $item['location_id'],
                    'type'           => 'sale',
                    'quantity'       => -$item['quantity'],
                    'reference_type' => Sale::class,
                    'reference_id'   => $sale->id,
                    'movement_date'  => today(),
                    'notes'          => 'POS Sale ' . $invoiceNo,
                ]);
            }

            // 3. Record Payment
            if ($request->paid_amount > 0) {
                Payment::create([
                    'sale_id'        => $sale->id,
                    'amount'         => $request->paid_amount,
                    'payment_date'   => today(),
                    'payment_method' => $request->payment_method,
                    'notes'          => 'POS Payment',
                ]);
            }

            DB::commit();

            // Redirect back with a flash session containing the sale ID to auto-print receipt
            return redirect()->route('pos.index')->with('success', 'Sale completed successfully!')->with('print_sale_id', $sale->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }
}
