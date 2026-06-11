<?php

namespace App\Models;

class PurchaseOrder extends BaseModel
{
    protected function casts(): array
    {
        return [
            'order_date' => 'date',
            'expected_at' => 'date',
            'total_amount' => 'decimal:3',
            'items' => 'array',
        ];
    }
}
