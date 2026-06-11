<?php

namespace App\Models;

class PayrollItem extends BaseModel
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:3',
            'is_configurable_rule' => 'boolean',
        ];
    }
}
