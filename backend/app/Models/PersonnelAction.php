<?php

namespace App\Models;

class PersonnelAction extends BaseModel
{
    protected function casts(): array
    {
        return [
            'effective_date' => 'date',
            'payload' => 'array',
            'approved_at' => 'datetime',
        ];
    }
}
