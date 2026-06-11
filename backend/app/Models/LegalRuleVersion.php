<?php

namespace App\Models;

class LegalRuleVersion extends BaseModel
{
    protected function casts(): array
    {
        return [
            'rules' => 'array',
            'effective_from' => 'date',
            'effective_to' => 'date',
            'approved_at' => 'datetime',
        ];
    }
}
