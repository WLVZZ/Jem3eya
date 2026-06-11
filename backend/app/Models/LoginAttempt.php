<?php

namespace App\Models;

class LoginAttempt extends BaseModel
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'successful' => 'boolean',
            'attempted_at' => 'datetime',
        ];
    }
}
