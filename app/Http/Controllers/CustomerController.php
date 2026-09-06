<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderByDesc('created_at')->get();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20|unique:customers',
            'address' => 'nullable|string',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20|unique:customers,mobile,' . $customer->id,
            'address' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if ($customer->sales()->exists() || $customer->quotations()->exists()) {
            return redirect()->route('customers.index')->with('error', 'Cannot delete customer with existing sales or quotations.');
        }

        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    /**
     * Search existing customers by mobile number.
     *
     * GET /customers/search?q=017...
     * Returns JSON: [{ id, mobile, name, address }, ...]
     */
    public function search(Request $request)
    {
        $q = trim($request->input('search_query', $request->input('q', '')));

        $customers = Customer::whereNotNull('mobile')
            ->when($q, function ($query, $q) {
                $query->where('mobile', 'like', "%{$q}%");
            })
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($row) => [
                'id'      => $row->mobile, // Keeping id as mobile for legacy Select2 compatibility
                'mobile'  => $row->mobile,
                'name'    => $row->name,
                'address' => $row->address ?? '',
            ])->values();

        return response()->json($customers);
    }
}
