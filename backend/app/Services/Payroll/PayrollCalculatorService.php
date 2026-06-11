<?php

namespace App\Services\Payroll;

use App\Models\DeductionType;
use App\Models\Employee;
use App\Models\LegalRuleVersion;
use App\Models\PayrollDeduction;
use App\Models\PayrollItem;
use App\Models\PayrollRun;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PayrollCalculatorService
{
    public function calculate(PayrollRun $run): array
    {
        if (! in_array($run->status, ['draft', 'calculated'], true)) {
            throw new RuntimeException('Only draft payroll runs can be calculated.');
        }

        $rules = $this->rules($run->legal_rule_version_id);
        $warnings = [];

        DB::transaction(function () use ($run, $rules, &$warnings): void {
            PayrollItem::where('payroll_run_id', $run->id)->delete();
            PayrollDeduction::where('payroll_run_id', $run->id)->delete();

            $employees = Employee::query()
                ->with(['salaryGrade'])
                ->where('employment_status', 'active')
                ->when($run->branch_id, fn ($query) => $query->where('branch_id', $run->branch_id))
                ->when($run->department_id, fn ($query) => $query->where('department_id', $run->department_id))
                ->get();

            $gross = 0.0;
            $deductions = 0.0;

            foreach ($employees as $employee) {
                $base = (float) ($employee->salaryGrade?->base_salary ?? 0);
                if ($base <= 0) {
                    $warnings[] = "Employee {$employee->employee_number} has no configured base salary.";
                }

                $gross += $this->createItem($run, $employee, 'base_salary', $base, false);

                foreach (($rules['allowances'] ?? []) as $rule) {
                    $gross += $this->createItem($run, $employee, $rule['code'], $this->amount($rule, $base, $gross), true);
                }

                foreach (($rules['deductions'] ?? []) as $rule) {
                    $amount = $this->amount($rule, $base, $gross);
                    $deductions += $this->createDeduction($run, $employee, $rule['code'], $amount, true);
                }
            }

            $run->update([
                'status' => 'calculated',
                'gross_total' => $gross,
                'deduction_total' => $deductions,
                'net_total' => $gross - $deductions,
                'calculation_warnings' => $warnings,
            ]);
        });

        return [
            'payroll_run_id' => $run->id,
            'status' => $run->fresh()->status,
            'warnings' => $warnings,
        ];
    }

    private function rules(int $id): array
    {
        $version = LegalRuleVersion::query()
            ->where('status', 'approved')
            ->findOrFail($id);

        return $version->rules ?? [];
    }

    private function amount(array $rule, float $base, float $gross): float
    {
        $basis = match ($rule['basis'] ?? 'base_salary') {
            'gross' => $gross,
            default => $base,
        };

        $amount = match ($rule['type'] ?? 'fixed') {
            'percentage' => $basis * ((float) ($rule['rate'] ?? 0)),
            default => (float) ($rule['amount'] ?? 0),
        };

        if (isset($rule['cap'])) {
            $amount = min($amount, (float) $rule['cap']);
        }

        return round($amount, 3);
    }

    private function createItem(PayrollRun $run, Employee $employee, string $code, float $amount, bool $configurable): float
    {
        PayrollItem::create([
            'payroll_run_id' => $run->id,
            'employee_id' => $employee->id,
            'code' => $code,
            'description' => $code,
            'amount' => $amount,
            'is_configurable_rule' => $configurable,
        ]);

        return $amount;
    }

    private function createDeduction(PayrollRun $run, Employee $employee, string $code, float $amount, bool $configurable): float
    {
        $typeId = DeductionType::query()->where('code', $code)->value('id');

        PayrollDeduction::create([
            'payroll_run_id' => $run->id,
            'employee_id' => $employee->id,
            'deduction_type_id' => $typeId,
            'code' => $code,
            'description' => $code,
            'amount' => $amount,
            'is_configurable_rule' => $configurable,
        ]);

        return $amount;
    }
}
