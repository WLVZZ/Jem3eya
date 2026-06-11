<?php

namespace App\Models;

class GoodsReceipt extends BaseModel
{
    protected function casts(): array
    {
        return [
            'received_at' => 'date',
            'items' => 'array',
        ];
    }
}
