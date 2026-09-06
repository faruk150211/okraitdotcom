<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'location_id',
        'type', // purchase, sale, purchase_return, sale_return, transfer, adjustment
        'quantity',
        'reference_type',
        'reference_id',
        'movement_date',
        'notes',
    ];

    protected $casts = [
        'movement_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }
}
