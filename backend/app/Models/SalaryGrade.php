<?php

namespace App\Models;

class SalaryGrade extends BaseModel
{
    protected function casts(): array
    {
        return [
            'base_salary' => 'decimal:3',
        ];
    }
}
