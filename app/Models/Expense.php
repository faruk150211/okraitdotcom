<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'expense_date',
        'category',
        'notes',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount'       => 'decimal:2',
    ];

    /**
     * Available expense categories.
     */
    public static function categories(): array
    {
        return ['Rent', 'Salary', 'Utilities', 'Purchase', 'Transport', 'Marketing', 'Disbursement', 'Other'];
    }
}
