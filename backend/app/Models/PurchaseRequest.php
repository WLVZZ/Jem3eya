<?php

namespace App\Models;

class PurchaseRequest extends BaseModel
{
    protected function casts(): array
    {
        return [
            'required_at' => 'date',
            'approved_at' => 'datetime',
            'items' => 'array',
        ];
    }
}
