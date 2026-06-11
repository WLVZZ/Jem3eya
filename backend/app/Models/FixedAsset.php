<?php

namespace App\Models;

class FixedAsset extends BaseModel
{
    protected function casts(): array
    {
        return [
            'acquired_at' => 'date',
            'acquisition_cost' => 'decimal:3',
            'annual_depreciation' => 'decimal:3',
            'disposed_at' => 'date',
        ];
    }
}
