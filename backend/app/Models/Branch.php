<?php

namespace App\Models;

class Branch extends BaseModel
{
    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
