<?php

namespace App\Models;

class DeductionType extends BaseModel
{
    protected function casts(): array
    {
        return ['is_legal' => 'boolean'];
    }
}
