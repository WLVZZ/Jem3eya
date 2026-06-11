<?php

namespace App\Models;

class EmployeeDocument extends BaseModel
{
    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
            'expires_at' => 'date',
        ];
    }
}
