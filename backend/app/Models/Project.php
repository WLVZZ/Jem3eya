<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends BaseModel
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'budget' => 'decimal:3',
            'progress_percentage' => 'decimal:2',
        ];
    }

    public function budgets()
    {
        return $this->hasMany(ProjectBudget::class);
    }

    public function expenses()
    {
        return $this->hasMany(ProjectExpense::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'linkable');
    }

    public function costCenter()
    {
        return $this->belongsTo(Account::class, 'cost_center_account_id');
    }
}
