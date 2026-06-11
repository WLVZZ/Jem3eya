<?php

namespace App\Models;

class Loan extends BaseModel
{
    protected function casts(): array
    {
        return [
            'principal_amount' => 'decimal:3',
            'outstanding_amount' => 'decimal:3',
            'started_at' => 'date',
        ];
    }
}
