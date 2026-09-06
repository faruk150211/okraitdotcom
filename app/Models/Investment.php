<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'investment_date',
        'source',
        'notes',
    ];

    protected $casts = [
        'investment_date' => 'date',
        'amount'          => 'decimal:2',
    ];

    public static function sources(): array
    {
        return ['Owner', 'Loan', 'Grant', 'Other'];
    }
}
