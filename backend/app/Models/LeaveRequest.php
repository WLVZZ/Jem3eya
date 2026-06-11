<?php

namespace App\Models;

class LeaveRequest extends BaseModel
{
    protected function casts(): array
    {
        return [
            'starts_at' => 'date',
            'ends_at' => 'date',
            'approved_at' => 'datetime',
        ];
    }
}
