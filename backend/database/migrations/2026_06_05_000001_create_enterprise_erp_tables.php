<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('city')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('departments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->nullable()->index();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('username')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->string('status')->default('active')->index();
            $table->boolean('two_factor_enabled')->default(false);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table): void {
            $table->id();
            $table->string('module')->index();
            $table->string('screen')->index();
            $table->string('action')->index();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('user_roles', function (Blueprint $table): void {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['user_id', 'role_id']);
        });

        Schema::create('role_permissions', function (Blueprint $table): void {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create('audit_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action')->index();
            $table->string('module')->nullable()->index();
            $table->nullableMorphs('auditable');
            $table->json('before_values')->nullable();
            $table->json('after_values')->nullable();
            $table->string('ip_address', 60)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('login_attempts', function (Blueprint $table): void {
            $table->id();
            $table->string('username')->index();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address', 60)->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('successful')->default(false);
            $table->string('failure_reason')->nullable();
            $table->timestamp('attempted_at')->index();
        });

        Schema::create('two_factor_codes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('code_hash');
            $table->string('channel')->default('email');
            $table->string('purpose')->default('login');
            $table->timestamp('expires_at');
            $table->timestamp('consumed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('refresh_tokens', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('token_hash');
            $table->timestamp('expires_at')->index();
            $table->timestamp('revoked_at')->nullable()->index();
            $table->string('ip_address', 60)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table): void {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('group')->index();
            $table->string('key')->unique();
            $table->string('label_ar');
            $table->string('label_en')->nullable();
            $table->json('value')->nullable();
            $table->boolean('is_sensitive')->default(false);
            $table->timestamps();
        });

        Schema::create('salary_scales', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('salary_grades', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('salary_scale_id')->constrained()->cascadeOnDelete();
            $table->string('grade_code');
            $table->decimal('base_salary', 15, 3)->default(0);
            $table->json('steps')->nullable();
            $table->timestamps();
            $table->unique(['salary_scale_id', 'grade_code']);
        });

        Schema::create('employees', function (Blueprint $table): void {
            $table->id();
            $table->string('employee_number')->unique();
            $table->string('full_name_ar');
            $table->string('full_name_en')->nullable();
            $table->string('national_id')->nullable()->index();
            $table->string('photo_path')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('nationality')->nullable();
            $table->string('marital_status')->nullable();
            $table->unsignedInteger('children_count')->default(0);
            $table->string('education_qualification')->nullable();
            $table->date('hire_date');
            $table->string('employment_grade')->nullable();
            $table->foreignId('salary_scale_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('salary_grade_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('contract_type')->index();
            $table->string('employment_status')->default('active')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->foreign('employee_id')->references('id')->on('employees')->nullOnDelete();
        });

        Schema::create('employee_documents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('number')->nullable();
            $table->date('issued_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();
        });

        Schema::create('contracts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('contract_type')->index();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('agreed_salary', 15, 3)->nullable();
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('attendance_records', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->date('attendance_date')->index();
            $table->timestamp('check_in_at')->nullable();
            $table->timestamp('check_out_at')->nullable();
            $table->string('source')->default('manual');
            $table->string('fingerprint_device_id')->nullable();
            $table->string('qr_token_id')->nullable();
            $table->decimal('gps_latitude', 10, 7)->nullable();
            $table->decimal('gps_longitude', 10, 7)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->unique(['employee_id', 'attendance_date']);
        });

        Schema::create('leave_types', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->boolean('is_paid')->default(true);
            $table->timestamps();
        });

        Schema::create('leave_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('leave_type_id')->constrained()->restrictOnDelete();
            $table->date('starts_at');
            $table->date('ends_at');
            $table->decimal('days_count', 8, 2);
            $table->string('status')->default('draft')->index();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
        });

        Schema::create('personnel_actions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('action_type')->index();
            $table->date('effective_date');
            $table->json('payload')->nullable();
            $table->string('status')->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('allowance_types', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->boolean('is_taxable')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('deduction_types', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->boolean('is_legal')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('legal_rule_versions', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('jurisdiction')->default('LY');
            $table->date('effective_from');
            $table->date('effective_to')->nullable();
            $table->json('rules');
            $table->string('status')->default('draft')->index();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('payroll_runs', function (Blueprint $table): void {
            $table->id();
            $table->date('period_month')->index();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('legal_rule_version_id')->constrained()->restrictOnDelete();
            $table->string('status')->default('draft')->index();
            $table->decimal('gross_total', 15, 3)->default(0);
            $table->decimal('deduction_total', 15, 3)->default(0);
            $table->decimal('net_total', 15, 3)->default(0);
            $table->json('calculation_warnings')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['period_month', 'branch_id', 'department_id']);
        });

        Schema::create('payroll_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('payroll_run_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('description')->nullable();
            $table->decimal('amount', 15, 3);
            $table->boolean('is_configurable_rule')->default(false);
            $table->timestamps();
        });

        Schema::create('payroll_deductions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('payroll_run_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('deduction_type_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code');
            $table->string('description')->nullable();
            $table->decimal('amount', 15, 3);
            $table->boolean('is_configurable_rule')->default(false);
            $table->timestamps();
        });

        Schema::create('loans', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->decimal('principal_amount', 15, 3);
            $table->decimal('outstanding_amount', 15, 3);
            $table->date('started_at');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('loan_installments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->date('due_date');
            $table->decimal('amount', 15, 3);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('accounts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('type')->index();
            $table->string('normal_balance');
            $table->boolean('cost_center_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('journal_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('entry_number')->unique();
            $table->date('entry_date')->index();
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('status')->default('draft');
            $table->text('description')->nullable();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('journal_details', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('journal_entry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->constrained()->restrictOnDelete();
            $table->foreignId('cost_center_account_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->decimal('debit', 15, 3)->default(0);
            $table->decimal('credit', 15, 3)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('vendors', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('warehouses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('inventory_items', function (Blueprint $table): void {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('barcode')->nullable()->index();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('image_path')->nullable();
            $table->string('unit_of_measure');
            $table->decimal('quantity_on_hand', 15, 3)->default(0);
            $table->decimal('reorder_level', 15, 3)->default(0);
            $table->decimal('inventory_value', 15, 3)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('stock_transactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained()->restrictOnDelete();
            $table->foreignId('warehouse_id')->constrained()->restrictOnDelete();
            $table->foreignId('target_warehouse_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $table->string('transaction_type')->index();
            $table->date('transaction_date');
            $table->decimal('quantity', 15, 3);
            $table->decimal('unit_cost', 15, 3)->default(0);
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_requests', function (Blueprint $table): void {
            $table->id();
            $table->string('request_number')->unique();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('required_at')->nullable();
            $table->json('items');
            $table->string('status')->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_orders', function (Blueprint $table): void {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('purchase_request_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vendor_id')->constrained()->restrictOnDelete();
            $table->date('order_date');
            $table->date('expected_at')->nullable();
            $table->json('items');
            $table->decimal('total_amount', 15, 3)->default(0);
            $table->string('status')->default('draft');
            $table->timestamps();
        });

        Schema::create('goods_receipts', function (Blueprint $table): void {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->foreignId('purchase_order_id')->constrained()->restrictOnDelete();
            $table->date('received_at');
            $table->json('items');
            $table->string('status')->default('received');
            $table->timestamps();
        });

        Schema::create('supplier_invoices', function (Blueprint $table): void {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('vendor_id')->constrained()->restrictOnDelete();
            $table->foreignId('purchase_order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('journal_entry_id')->nullable()->constrained()->nullOnDelete();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->decimal('total_amount', 15, 3);
            $table->string('status')->default('draft');
            $table->timestamps();
        });

        Schema::create('fixed_assets', function (Blueprint $table): void {
            $table->id();
            $table->string('asset_number')->unique();
            $table->string('category')->index();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->date('acquired_at');
            $table->decimal('acquisition_cost', 15, 3);
            $table->string('depreciation_method')->default('straight_line');
            $table->unsignedInteger('useful_life_months')->default(0);
            $table->decimal('annual_depreciation', 15, 3)->default(0);
            $table->foreignId('custodian_employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('status')->default('active');
            $table->date('disposed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('asset_depreciations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('fixed_asset_id')->constrained()->cascadeOnDelete();
            $table->date('period_date');
            $table->decimal('amount', 15, 3);
            $table->decimal('accumulated_amount', 15, 3);
            $table->foreignId('journal_entry_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('type')->index();
            $table->decimal('budget', 15, 3)->default(0);
            $table->string('funding_source')->nullable();
            $table->json('donors')->nullable();
            $table->foreignId('cost_center_account_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->string('status')->default('planned');
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('project_budgets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('budget_line');
            $table->decimal('amount', 15, 3);
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->timestamps();
        });

        Schema::create('project_expenses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('journal_entry_id')->nullable()->constrained()->nullOnDelete();
            $table->date('expense_date');
            $table->string('description');
            $table->decimal('amount', 15, 3);
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table): void {
            $table->id();
            $table->string('category')->index();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->nullableMorphs('linkable');
            $table->string('disk');
            $table->string('path');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->string('checksum', 64);
            $table->unsignedInteger('version')->default(1);
            $table->string('ocr_status')->default('pending');
            $table->string('search_status')->default('pending');
            $table->date('retention_until')->nullable();
            $table->date('expires_at')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('document_versions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('version');
            $table->string('disk');
            $table->string('path');
            $table->string('checksum', 64);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['document_id', 'version']);
        });

        Schema::create('notifications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('channel')->index();
            $table->string('type')->index();
            $table->string('title');
            $table->text('body')->nullable();
            $table->json('data')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('jobs', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('failed_jobs', function (Blueprint $table): void {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach (array_reverse([
            'branches', 'departments', 'users', 'roles', 'permissions', 'user_roles', 'role_permissions',
            'audit_logs', 'login_attempts', 'two_factor_codes', 'refresh_tokens', 'password_reset_tokens', 'settings',
            'salary_scales', 'salary_grades', 'employees', 'employee_documents', 'contracts',
            'attendance_records', 'leave_types', 'leave_requests', 'personnel_actions',
            'allowance_types', 'deduction_types', 'legal_rule_versions', 'payroll_runs',
            'payroll_items', 'payroll_deductions', 'loans', 'loan_installments', 'accounts',
            'journal_entries', 'journal_details', 'vendors', 'customers', 'warehouses',
            'inventory_items', 'stock_transactions', 'purchase_requests', 'purchase_orders',
            'goods_receipts', 'supplier_invoices', 'fixed_assets', 'asset_depreciations',
            'projects', 'project_budgets', 'project_expenses', 'documents', 'document_versions',
            'notifications', 'jobs', 'failed_jobs',
        ]) as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();
    }
};
