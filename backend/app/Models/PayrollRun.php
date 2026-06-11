<?php

namespace App\Models;

class PayrollRun extends BaseModel
{
    protected function casts(): array
    {
        return [
            'period_month' => 'date',
            'gross_total' => 'decimal:3',
            'deduction_total' => 'decimal:3',
            'net_total' => 'decimal:3',
            'calculation_warnings' => 'array',
            'approved_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public function legalRuleVersion()
    {
        return $this->belongsTo(LegalRuleVersion::class);
    }

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function deductions()
    {
        return $this->hasMany(PayrollDeduction::class);
    }
}
