<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'quotation_no',
        'customer_id',
        'customer_name',
        'customer_mobile',
        'customer_address',
        'quotation_date',
        'sub_total',
        'discount',
        'grand_total',
        'notes',
        'amount_paid',
        'payment_status',
    ];

    protected $casts = [
        'quotation_date' => 'date',
        'amount_paid'    => 'decimal:2',
    ];

    /**
     * Outstanding amount still owed by the customer.
     */
    public function getDueAmountAttribute(): float
    {
        return max(0, (float) $this->grand_total - (float) $this->amount_paid);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
