<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'account_name',
    'description',
    'balance',
    'currency',
])]
class Account extends Model
{
    protected $table = 'account';

    protected $primaryKey = 'account_id';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'currency' => 'string',
            'balance' => 'float',
        ];
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'account_id', 'account_id');
    }
}

