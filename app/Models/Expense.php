<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'account_id',
    'category_id',
    'title',
    'details',
    'url',
    'amount',
    'my_share_type',
    'my_share_value',
    'active_amount',
    'currency',
    'is_recurring',
    'day_of_month',
    'transaction_date',
    'due_date',
    'is_active',
    'meta',
])]
class Expense extends Model
{
    protected $table = 'expense';

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'my_share_value' => 'decimal:2',
            'active_amount' => 'decimal:2',
            'is_recurring' => 'boolean',
            'is_active' => 'boolean',
            'day_of_month' => 'integer',
            'transaction_date' => 'date',
            'due_date' => 'date',
            'meta' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'account_id');
    }
}