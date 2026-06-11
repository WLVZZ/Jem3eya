<?php

namespace App\Models;

class StockTransaction extends BaseModel
{
    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'quantity' => 'decimal:3',
            'unit_cost' => 'decimal:3',
            'meta' => 'array',
        ];
    }
}
