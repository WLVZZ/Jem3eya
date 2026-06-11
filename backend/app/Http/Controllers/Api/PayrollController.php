<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Payroll\PayrollRunRequest;
use App\Models\PayrollRun;
use App\Services\Audit\AuditLogger;
use App\Services\Payroll\PayrollCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PayrollController extends Controller
{
    public function __construct(
        private readonly PayrollCalculatorService $calculator,
        private readonly AuditLogger $audit,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json(PayrollRun::query()
            ->with('legalRuleVersion')
            ->latest('period_month')
            ->paginate((int) $request->input('per_page', 20)));
    }

    public function store(PayrollRunRequest $request): JsonResponse
    {
        $run = PayrollRun::create([
            ...$request->validated(),
            'period_month' => $request->date('period_month')->startOfMonth(),
            'status' => 'draft',
            'created_by' => $request->user()->id,
        ]);

        $this->audit->record('create', $run, ['module' => 'payroll'], $request);

        return response()->json($run, 201);
    }

    public function calculate(Request $request, PayrollRun $payrollRun): JsonResponse
    {
        $result = $this->calculator->calculate($payrollRun);
        $this->audit->record('calculate', $payrollRun, ['module' => 'payroll', 'result' => $result], $request);

        return response()->json($result);
    }

    public function approve(Request $request, PayrollRun $payrollRun): JsonResponse
    {
        abort_unless($payrollRun->status === 'calculated', 422, 'Payroll must be calculated first.');

        $payrollRun->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $this->audit->record('approve', $payrollRun, ['module' => 'payroll'], $request);

        return response()->json($payrollRun->fresh());
    }

    public function close(Request $request, PayrollRun $payrollRun): JsonResponse
    {
        abort_unless($payrollRun->status === 'approved', 422, 'Payroll must be approved first.');

        $payrollRun->update([
            'status' => 'closed',
            'closed_by' => $request->user()->id,
            'closed_at' => now(),
        ]);

        $this->audit->record('close', $payrollRun, ['module' => 'payroll'], $request);

        return response()->json($payrollRun->fresh());
    }
}
