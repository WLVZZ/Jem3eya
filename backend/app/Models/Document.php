<?php

namespace App\Models;

class Document extends BaseModel
{
    protected function casts(): array
    {
        return [
            'retention_until' => 'date',
            'expires_at' => 'date',
            'meta' => 'array',
        ];
    }

    public function linkable()
    {
        return $this->morphTo();
    }

    public function versions()
    {
        return $this->hasMany(DocumentVersion::class);
    }
}
