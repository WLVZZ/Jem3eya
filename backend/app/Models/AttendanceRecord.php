<?php

namespace App\Models;

class AttendanceRecord extends BaseModel
{
    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
            'check_in_at' => 'datetime',
            'check_out_at' => 'datetime',
            'meta' => 'array',
        ];
    }
}
