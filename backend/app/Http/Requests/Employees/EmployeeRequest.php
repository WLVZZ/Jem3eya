<?php

namespace App\Http\Requests\Employees;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission('hr.employees.manage') ?? false;
    }

    public function rules(): array
    {
        return [
            'employee_number' => ['required', 'string', 'max:50'],
            'full_name_ar' => ['required', 'string', 'max:190'],
            'full_name_en' => ['nullable', 'string', 'max:190'],
            'national_id' => ['nullable', 'string', 'max:50'],
            'passport_number' => ['nullable', 'string', 'max:50'],
            'nationality' => ['nullable', 'string', 'max:80'],
            'marital_status' => ['nullable', 'string', 'max:40'],
            'children_count' => ['nullable', 'integer', 'min:0'],
            'education_qualification' => ['nullable', 'string', 'max:150'],
            'hire_date' => ['required', 'date'],
            'employment_grade' => ['nullable', 'string', 'max:80'],
            'salary_scale_id' => ['nullable', 'integer', 'exists:salary_scales,id'],
            'salary_grade_id' => ['nullable', 'integer', 'exists:salary_grades,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
            'address' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:190'],
            'contract_type' => ['required', 'in:permanent,temporary,cooperation,expert'],
            'employment_status' => ['required', 'in:active,suspended,terminated,retired'],
        ];
    }
}
