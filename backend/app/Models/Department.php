<?php

namespace App\Models;

class Department extends BaseModel
{
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
