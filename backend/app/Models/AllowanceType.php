<?php

namespace App\Models;

class AllowanceType extends BaseModel
{
    protected function casts(): array
    {
        return ['is_taxable' => 'boolean'];
    }
}
