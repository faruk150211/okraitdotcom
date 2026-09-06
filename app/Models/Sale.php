<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_mobile',
        'customer_address',
        'location_id',
        'quotation_id',
        'customer_id',
        'sale_date',
        'invoice_no',
        'total_amount',
        'paid_amount',
        'total_profit',
        'notes',
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function stockMovements()
    {
        return $this->morphMany(StockMovement::class, 'reference');
    }
}
