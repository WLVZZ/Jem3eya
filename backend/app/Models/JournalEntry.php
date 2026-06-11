<?php

namespace App\Models;

class JournalEntry extends BaseModel
{
    protected function casts(): array
    {
        return [
            'entry_date' => 'date',
            'posted_at' => 'datetime',
        ];
    }

    public function details()
    {
        return $this->hasMany(JournalDetail::class);
    }
}
