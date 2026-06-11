<?php

namespace App\Models;

class Setting extends BaseModel
{
    protected function casts(): array
    {
        return [
            'value' => 'array',
            'is_sensitive' => 'boolean',
        ];
    }
}
