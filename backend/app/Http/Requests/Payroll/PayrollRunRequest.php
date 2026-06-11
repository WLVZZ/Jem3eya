<?php

namespace App\Http\Requests\Payroll;

use Illuminate\Foundation\Http\FormRequest;

class PayrollRunRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission('payroll.runs.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'period_month' => ['required', 'date_format:Y-m'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'legal_rule_version_id' => ['required', 'integer', 'exists:legal_rule_versions,id'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
