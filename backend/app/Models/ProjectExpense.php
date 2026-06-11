<?php

namespace App\Models;

class ProjectExpense extends BaseModel
{
    protected function casts(): array
    {
        return [
            'expense_date' => 'date',
            'amount' => 'decimal:3',
        ];
    }
}
