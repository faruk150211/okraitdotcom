<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $quotations = Quotation::when($search, function ($query, $search) {
                return $query->where('quotation_no', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_mobile', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all products with their brand and category relationships
        $products = Product::with(['brand', 'category'])->orderBy('name')->get();

        // Generate dynamic Quotation Number: QT-YYYYMMDD-XXXX
        $today = date('Ymd');
        $lastQuotation = Quotation::whereDate('created_at', today())->latest()->first();
        if ($lastQuotation && preg_match('/QT-\d{8}-(\d{4})/', $lastQuotation->quotation_no, $matches)) {
            $lastNum = intval($matches[1]);
            $nextNum = str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNum = '0001';
        }
        $nextQuotationNo = "QT-{$today}-{$nextNum}";

        return view('quotations.create', compact('products', 'nextQuotationNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_mobile' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'quotation_date' => 'required|date',
            'discount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($validated) {
            // Re-generate Quotation Number inside transaction for safety
            $today = date('Ymd');
            $lastQuotation = Quotation::whereDate('created_at', today())->latest()->first();
            if ($lastQuotation && preg_match('/QT-\d{8}-(\d{4})/', $lastQuotation->quotation_no, $matches)) {
                $lastNum = intval($matches[1]);
                $nextNum = str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $nextNum = '0001';
            }
            $quotationNo = "QT-{$today}-{$nextNum}";

            // Calculate Totals
            $subTotal = 0;
            $itemsToCreate = [];

            foreach ($validated['items'] as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                $itemTotal = $itemData['quantity'] * $itemData['price'];
                $subTotal += $itemTotal;

                $itemsToCreate[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'model' => $product->model,
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'total' => $itemTotal
                ];
            }

            $discount = $validated['discount'];
            $grandTotal = max(0, $subTotal - $discount);

            // Customer Handling
            $mobile = $validated['customer_mobile'];
            $customerName = $validated['customer_name'] ?: 'Unknown';
            $customer = null;

            if ($mobile) {
                $customer = \App\Models\Customer::where('mobile', $mobile)->first();
                if (!$customer) {
                    $customer = \App\Models\Customer::create([
                        'name' => $customerName,
                        'mobile' => $mobile,
                        'address' => $validated['customer_address'],
                    ]);
                }
            } else {
                $customer = \App\Models\Customer::create([
                    'name' => $customerName,
                    'address' => $validated['customer_address'],
                ]);
            }

            // Create Quotation
            $quotation = Quotation::create([
                'quotation_no' => $quotationNo,
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_mobile' => $customer->mobile,
                'customer_address' => $customer->address,
                'quotation_date' => $validated['quotation_date'],
                'sub_total' => $subTotal,
                'discount' => $discount,
                'grand_total' => $grandTotal,
                'notes' => $validated['notes']
            ]);

            // Save Items
            foreach ($itemsToCreate as $item) {
                $item['quotation_id'] = $quotation->id;
                QuotationItem::create($item);
            }
        });

        return redirect()->route('quotations.index')->with('success', 'Quotation generated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        $quotation->load('items');
        return view('quotations.show', compact('quotation'));
    }

    public function edit(Quotation $quotation)
    {
        $products = Product::with(['brand', 'category'])->orderBy('name')->get();
        $quotation->load('items');
        return view('quotations.edit', compact('quotation', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_mobile' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'quotation_date' => 'required|date',
            'discount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($validated, $quotation) {
            // Calculate Totals
            $subTotal = 0;
            $itemsToCreate = [];

            foreach ($validated['items'] as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                $itemTotal = $itemData['quantity'] * $itemData['price'];
                $subTotal += $itemTotal;

                $itemsToCreate[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'model' => $product->model,
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'total' => $itemTotal
                ];
            }

            $discount = $validated['discount'];
            $grandTotal = max(0, $subTotal - $discount);

            // Customer Handling
            $mobile = $validated['customer_mobile'];
            $customerName = $validated['customer_name'] ?: 'Unknown';
            $customer = null;

            if ($mobile) {
                $customer = \App\Models\Customer::where('mobile', $mobile)->first();
                if (!$customer) {
                    $customer = \App\Models\Customer::create([
                        'name' => $customerName,
                        'mobile' => $mobile,
                        'address' => $validated['customer_address'],
                    ]);
                }
            } else {
                $customer = \App\Models\Customer::create([
                    'name' => $customerName,
                    'address' => $validated['customer_address'],
                ]);
            }

            // Update Quotation
            $quotation->update([
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_mobile' => $customer->mobile,
                'customer_address' => $customer->address,
                'quotation_date' => $validated['quotation_date'],
                'sub_total' => $subTotal,
                'discount' => $discount,
                'grand_total' => $grandTotal,
                'notes' => $validated['notes']
            ]);

            // Clear old items and recreate new items
            $quotation->items()->delete();
            foreach ($itemsToCreate as $item) {
                $item['quotation_id'] = $quotation->id;
                QuotationItem::create($item);
            }
        });

        return redirect()->route('quotations.index')->with('success', 'Quotation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect()->route('quotations.index')->with('success', 'Quotation deleted successfully.');
    }
}
