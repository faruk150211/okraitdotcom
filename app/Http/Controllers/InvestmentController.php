<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $investments = Investment::when($search, fn($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('notes', 'like', "%{$search}%"))
            ->orderByDesc('investment_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $totalAmount = Investment::when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->sum('amount');

        return view('investments.index', compact('investments', 'totalAmount'));
    }

    public function create()
    {
        $sources = Investment::sources();
        return view('investments.create', compact('sources'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'amount'          => 'required|numeric|min:0.01',
            'investment_date' => 'required|date',
            'source'          => 'required|string|in:' . implode(',', Investment::sources()),
            'notes'           => 'nullable|string',
        ]);

        Investment::create($validated);

        return redirect()->route('investments.index')->with('success', 'Investment recorded successfully.');
    }

    public function edit(Investment $investment)
    {
        $sources = Investment::sources();
        return view('investments.edit', compact('investment', 'sources'));
    }

    public function update(Request $request, Investment $investment)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'amount'          => 'required|numeric|min:0.01',
            'investment_date' => 'required|date',
            'source'          => 'required|string|in:' . implode(',', Investment::sources()),
            'notes'           => 'nullable|string',
        ]);

        $investment->update($validated);

        return redirect()->route('investments.index')->with('success', 'Investment updated successfully.');
    }

    public function destroy(Investment $investment)
    {
        $investment->delete();
        return redirect()->route('investments.index')->with('success', 'Investment record deleted.');
    }
}
