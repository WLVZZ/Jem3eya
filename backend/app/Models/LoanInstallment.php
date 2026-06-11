<?php

namespace App\Models;

class LoanInstallment extends BaseModel
{
    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'amount' => 'decimal:3',
            'paid_at' => 'datetime',
        ];
    }
}
