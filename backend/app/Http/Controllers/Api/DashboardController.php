<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use App\Models\InventoryItem;
use App\Models\JournalDetail;
use App\Models\PayrollRun;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function kpis(): JsonResponse
    {
        return response()->json([
            'employee_count' => Employee::where('employment_status', 'active')->count(),
            'monthly_payroll_total' => PayrollRun::latest('period_month')->value('net_total') ?? 0,
            'revenues' => JournalDetail::where('credit', '>', 0)->sum('credit'),
            'expenses' => JournalDetail::where('debit', '>', 0)->sum('debit'),
            'cash_bank_balance' => JournalDetail::sum('debit') - JournalDetail::sum('credit'),
            'active_projects' => Project::where('status', 'active')->count(),
            'project_budget_usage' => Project::avg('progress_percentage') ?? 0,
            'inventory_value' => InventoryItem::sum('inventory_value'),
            'low_stock_items' => InventoryItem::whereColumn('quantity_on_hand', '<=', 'reorder_level')->count(),
            'pending_approvals' => PayrollRun::whereIn('status', ['draft', 'calculated'])->count(),
            'audit_alerts' => 0,
        ]);
    }
}
