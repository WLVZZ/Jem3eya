<?php

namespace App\Models;

class AssetDepreciation extends BaseModel
{
    protected function casts(): array
    {
        return [
            'period_date' => 'date',
            'amount' => 'decimal:3',
            'accumulated_amount' => 'decimal:3',
        ];
    }
}
