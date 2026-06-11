<?php

namespace App\Models;

class InventoryItem extends BaseModel
{
    protected function casts(): array
    {
        return [
            'quantity_on_hand' => 'decimal:3',
            'reorder_level' => 'decimal:3',
            'inventory_value' => 'decimal:3',
        ];
    }
}
