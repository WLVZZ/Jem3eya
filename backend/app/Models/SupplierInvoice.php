<?php

namespace App\Models;

class SupplierInvoice extends BaseModel
{
    protected function casts(): array
    {
        return [
            'invoice_date' => 'date',
            'due_date' => 'date',
            'total_amount' => 'decimal:3',
        ];
    }
}
