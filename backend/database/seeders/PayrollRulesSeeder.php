<?php

namespace Database\Seeders;

use App\Models\LegalRuleVersion;
use Illuminate\Database\Seeder;

class PayrollRulesSeeder extends Seeder
{
    public function run(): void
    {
        LegalRuleVersion::updateOrCreate(
            ['code' => 'LY-PAYROLL-DRAFT-001'],
            [
                'name_ar' => 'قواعد رواتب ليبيا - مسودة للمراجعة',
                'name_en' => 'Libya Payroll Rules - Review Draft',
                'jurisdiction' => 'LY',
                'effective_from' => '2026-01-01',
                'effective_to' => null,
                'status' => 'approved',
                'rules' => [
                    'legal_references' => [
                        'Libyan Labour Relations Law No. 12 of 2010',
                        'Libyan Income Tax Law No. 7 of 2010',
                    ],
                    'review_required' => true,
                    'allowances' => [],
                    'deductions' => [
                        [
                            'code' => 'income_tax',
                            'type' => 'percentage',
                            'basis' => 'gross',
                            'rate' => 0,
                            'review_required' => true,
                        ],
                        [
                            'code' => 'insurance',
                            'type' => 'percentage',
                            'basis' => 'base_salary',
                            'rate' => 0,
                            'review_required' => true,
                        ],
                    ],
                    'notes' => 'Rates are intentionally zero until legal/accounting review configures approved values.',
                ],
            ],
        );
    }
}
