<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Record a new payment against a sale.
     */
    public function store(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'amount'         => 'required|numeric|min:0.01',
            'payment_date'   => 'nullable|date',
            'payment_method' => 'required|string|in:Cash,Bank,bKash,Nagad,Bank Transfer,Cheque,Mobile Banking',
            'reference_no'   => 'nullable|string|max:255',
            'notes'          => 'nullable|string',
        ]);

        $due = max(0, $sale->total_amount - $sale->paid_amount);
        if ($validated['amount'] > $due && $due > 0) {
            return back()->withErrors([
                'amount' => 'Payment amount ('. number_format($validated['amount'], 2) .') exceeds the outstanding due ('. number_format($due, 2) .').'
            ])->withInput();
        }

        DB::transaction(function () use ($validated, $sale) {
            Payment::create([
                'sale_id'        => $sale->id,
                'amount'         => $validated['amount'],
                'payment_date'   => $validated['payment_date'] ?? today(),
                'payment_method' => $validated['payment_method'],
                'reference_no'   => $validated['reference_no'] ?? null,
                'notes'          => $validated['notes'] ?? null,
            ]);

            $this->recalculateSalePaymentStatus($sale);
        });

        return back()->with('success', 'Payment of Tk. ' . number_format($validated['amount'], 2) . ' recorded successfully.');
    }

    /**
     * Delete a payment and recalculate the sale payment status.
     */
    public function destroy(Payment $payment)
    {
        $sale = $payment->sale;

        DB::transaction(function () use ($payment, $sale) {
            $payment->delete();
            $this->recalculateSalePaymentStatus($sale);
        });

        return back()->with('success', 'Payment record removed successfully.');
    }

    /**
     * Recalculate and persist paid_amount on the sale.
     */
    private function recalculateSalePaymentStatus(Sale $sale): void
    {
        $sale->refresh();
        $totalPaid = $sale->payments()->sum('amount');

        $sale->update([
            'paid_amount' => $totalPaid,
        ]);
    }
}
