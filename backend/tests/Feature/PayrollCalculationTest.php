<?php

use App\Models\Employee;
use App\Models\LegalRuleVersion;
use App\Models\PayrollRun;
use App\Models\SalaryGrade;
use App\Models\SalaryScale;
use App\Services\Payroll\PayrollCalculatorService;

it('calculates payroll using configurable legal rules only', function (): void {
    $scale = SalaryScale::create(['code' => 'S1', 'name_ar' => 'سلم']);
    $grade = SalaryGrade::create(['salary_scale_id' => $scale->id, 'grade_code' => 'G1', 'base_salary' => 1000]);

    Employee::create([
        'employee_number' => 'E001',
        'full_name_ar' => 'موظف',
        'hire_date' => '2026-01-01',
        'salary_scale_id' => $scale->id,
        'salary_grade_id' => $grade->id,
        'contract_type' => 'permanent',
        'employment_status' => 'active',
    ]);

    $rules = LegalRuleVersion::create([
        'code' => 'TEST',
        'name_ar' => 'اختبار',
        'effective_from' => '2026-01-01',
        'status' => 'approved',
        'rules' => [
            'deductions' => [
                ['code' => 'income_tax', 'type' => 'percentage', 'basis' => 'base_salary', 'rate' => 0.10],
            ],
        ],
    ]);

    $run = PayrollRun::create([
        'period_month' => '2026-06-01',
        'legal_rule_version_id' => $rules->id,
        'status' => 'draft',
    ]);

    app(PayrollCalculatorService::class)->calculate($run);

    expect($run->fresh()->net_total)->toEqual('900.000');
});
