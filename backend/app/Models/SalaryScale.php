<?php

namespace App\Models;

class SalaryScale extends BaseModel
{
    public function grades()
    {
        return $this->hasMany(SalaryGrade::class);
    }
}
