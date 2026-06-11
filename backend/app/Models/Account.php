<?php

namespace App\Models;

class Account extends BaseModel
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'cost_center_required' => 'boolean',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id')->orderBy('code');
    }
}
