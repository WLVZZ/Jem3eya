<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'super-admin' => 'Super Admin',
            'general-manager' => 'General Manager',
            'hr-manager' => 'HR Manager',
            'finance-manager' => 'Finance Manager',
            'warehouse-manager' => 'Warehouse Manager',
            'projects-manager' => 'Projects Manager',
            'dawah-department' => 'Dawah Department',
            'internal-auditor' => 'Internal Auditor',
            'normal-user' => 'Normal User',
        ];

        foreach ($roles as $slug => $name) {
            Role::updateOrCreate(['slug' => $slug], ['name' => $name]);
        }

        $permissions = [
            'dashboard.kpis.view',
            'hr.employees.view',
            'hr.employees.manage',
            'hr.employees.delete',
            'hr.attendance.view',
            'hr.attendance.manage',
            'hr.leave.view',
            'hr.leave.approve',
            'hr.personnel.view',
            'hr.personnel.approve',
            'payroll.runs.view',
            'payroll.runs.create',
            'payroll.runs.calculate',
            'payroll.runs.approve',
            'payroll.runs.close',
            'payroll.rules.manage',
            'finance.accounts.view',
            'finance.accounts.manage',
            'finance.journals.view',
            'finance.journals.post',
            'inventory.items.view',
            'inventory.items.create',
            'inventory.stock.manage',
            'purchases.requests.manage',
            'assets.assets.manage',
            'projects.projects.view',
            'projects.projects.manage',
            'documents.documents.view',
            'documents.documents.upload',
            'reports.exports.create',
            'audit.logs.view',
            'settings.manage',
        ];

        foreach ($permissions as $slug) {
            [$module, $screen, $action] = explode('.', $slug);
            Permission::updateOrCreate(
                ['slug' => $slug],
                compact('module', 'screen', 'action') + ['description' => $slug],
            );
        }

        Role::where('slug', 'super-admin')->first()->permissions()->sync(Permission::pluck('id'));

        Role::where('slug', 'hr-manager')->first()->permissions()->sync(
            Permission::whereIn('module', ['dashboard', 'hr', 'payroll', 'documents'])->pluck('id')
        );

        Role::where('slug', 'finance-manager')->first()->permissions()->sync(
            Permission::whereIn('module', ['dashboard', 'finance', 'payroll', 'reports'])->pluck('id')
        );

        Role::where('slug', 'warehouse-manager')->first()->permissions()->sync(
            Permission::whereIn('module', ['dashboard', 'inventory', 'purchases'])->pluck('id')
        );

        Role::where('slug', 'projects-manager')->first()->permissions()->sync(
            Permission::whereIn('module', ['dashboard', 'projects', 'documents'])->pluck('id')
        );

        Role::where('slug', 'internal-auditor')->first()->permissions()->sync(
            Permission::whereIn('module', ['dashboard', 'audit', 'reports', 'finance'])->pluck('id')
        );

        $admin = User::updateOrCreate(
            ['username' => env('ERP_ADMIN_USERNAME', 'admin')],
            [
                'name_ar' => 'مدير النظام',
                'name_en' => 'System Administrator',
                'email' => env('ERP_ADMIN_EMAIL', 'admin@example.com'),
                'password' => Hash::make(env('ERP_ADMIN_PASSWORD', 'ChangeMe!234')),
                'status' => 'active',
            ],
        );

        $admin->roles()->sync([Role::where('slug', 'super-admin')->value('id')]);
    }
}
