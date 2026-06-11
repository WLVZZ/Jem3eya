<?php

namespace App\Models;

class TwoFactorCode extends BaseModel
{
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'consumed_at' => 'datetime',
        ];
    }
}
