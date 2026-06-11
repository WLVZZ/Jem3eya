<?php

namespace Database\Seeders;

use App\Models\AllowanceType;
use App\Models\Branch;
use App\Models\DeductionType;
use App\Models\Department;
use App\Models\LeaveType;
use App\Models\SalaryGrade;
use App\Models\SalaryScale;
use Illuminate\Database\Seeder;

class CoreReferenceSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::updateOrCreate(
            ['code' => 'HQ'],
            ['name_ar' => 'الإدارة العامة', 'name_en' => 'Head Office', 'city' => 'Tripoli']
        );

        foreach ([
            ['HR', 'الموارد البشرية', 'Human Resources'],
            ['FIN', 'المالية', 'Finance'],
            ['WH', 'المخازن', 'Warehouses'],
            ['PRJ', 'المشاريع', 'Projects'],
            ['DAWAH', 'الدعوة', 'Dawah'],
        ] as [$code, $nameAr, $nameEn]) {
            Department::updateOrCreate(
                ['code' => $code],
                ['branch_id' => $branch->id, 'name_ar' => $nameAr, 'name_en' => $nameEn]
            );
        }

        foreach ([
            ['annual', 'إجازة سنوية', 'Annual'],
            ['sick', 'إجازة مرضية', 'Sick'],
            ['emergency', 'إجازة طارئة', 'Emergency'],
            ['hajj_umrah', 'حج / عمرة', 'Hajj / Umrah'],
            ['unpaid', 'إجازة بدون مرتب', 'Unpaid'],
        ] as [$code, $nameAr, $nameEn]) {
            LeaveType::updateOrCreate(['code' => $code], ['name_ar' => $nameAr, 'name_en' => $nameEn]);
        }

        $scale = SalaryScale::updateOrCreate(['code' => 'LIBYA-GENERAL'], [
            'name_ar' => 'سلم رواتب عام قابل للتعديل',
            'name_en' => 'Configurable General Salary Scale',
        ]);

        SalaryGrade::updateOrCreate(
            ['salary_scale_id' => $scale->id, 'grade_code' => 'G1'],
            ['base_salary' => 0, 'steps' => []]
        );

        foreach ([
            ['housing', 'بدل سكن', 'Housing', false],
            ['transport', 'بدل مواصلات', 'Transport', false],
            ['nature_of_work', 'بدل طبيعة عمل', 'Nature of Work', true],
            ['management', 'بدل إدارة', 'Management', true],
            ['supervision', 'بدل إشراف', 'Supervision', true],
            ['overtime', 'عمل إضافي', 'Overtime', true],
            ['night_work', 'عمل ليلي', 'Night Work', true],
            ['holiday_work', 'عمل عطلات', 'Holiday Work', true],
        ] as [$code, $nameAr, $nameEn, $taxable]) {
            AllowanceType::updateOrCreate(['code' => $code], [
                'name_ar' => $nameAr,
                'name_en' => $nameEn,
                'is_taxable' => $taxable,
            ]);
        }

        foreach ([
            ['absence', 'غياب', 'Absence', false],
            ['lateness', 'تأخير', 'Lateness', false],
            ['loans', 'قروض', 'Loans', false],
            ['income_tax', 'ضريبة الدخل', 'Income Tax', true],
            ['insurance', 'ضمان / تأمين اجتماعي', 'Insurance / Social Security', true],
            ['judicial_garnishment', 'حجز قضائي', 'Judicial Garnishment', true],
            ['other', 'استقطاع آخر', 'Other', false],
        ] as [$code, $nameAr, $nameEn, $legal]) {
            DeductionType::updateOrCreate(['code' => $code], [
                'name_ar' => $nameAr,
                'name_en' => $nameEn,
                'is_legal' => $legal,
            ]);
        }
    }
}
