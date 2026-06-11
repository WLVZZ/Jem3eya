<?php

namespace App\Models;

class JournalDetail extends BaseModel
{
    protected function casts(): array
    {
        return [
            'debit' => 'decimal:3',
            'credit' => 'decimal:3',
        ];
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
