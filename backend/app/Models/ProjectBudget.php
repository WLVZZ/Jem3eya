<?php

namespace App\Models;

class ProjectBudget extends BaseModel
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:3',
            'period_start' => 'date',
            'period_end' => 'date',
        ];
    }
}
