<?php

namespace App\Models;

class AuditLog extends BaseModel
{
    protected function casts(): array
    {
        return [
            'before_values' => 'array',
            'after_values' => 'array',
            'meta' => 'array',
        ];
    }
}
