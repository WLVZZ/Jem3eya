<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Employees\EmployeeRequest;
use App\Models\Employee;
use App\Services\Audit\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmployeeController extends Controller
{
    public function __construct(private readonly AuditLogger $audit)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $employees = Employee::query()
            ->with(['branch', 'department', 'salaryScale', 'salaryGrade'])
            ->when($request->filled('status'), fn ($query) => $query->where('employment_status', $request->string('status')))
            ->when($request->filled('q'), function ($query) use ($request): void {
                $q = '%'.$request->string('q').'%';
                $query->where(fn ($inner) => $inner
                    ->where('employee_number', 'like', $q)
                    ->orWhere('full_name_ar', 'like', $q)
                    ->orWhere('full_name_en', 'like', $q));
            })
            ->latest('id')
            ->paginate((int) $request->input('per_page', 20));

        return response()->json($employees);
    }

    public function store(EmployeeRequest $request): JsonResponse
    {
        $employee = Employee::create($request->validated());
        $this->audit->record('create', $employee, ['module' => 'hr'], $request);

        return response()->json($employee->load(['branch', 'department']), 201);
    }

    public function show(Employee $employee): JsonResponse
    {
        return response()->json($employee->load([
            'branch',
            'department',
            'contracts',
            'documents',
            'leaveRequests',
            'personnelActions',
        ]));
    }

    public function update(EmployeeRequest $request, Employee $employee): JsonResponse
    {
        $before = $employee->getOriginal();
        $employee->update($request->validated());
        $this->audit->record('update', $employee, ['module' => 'hr', 'before' => $before], $request);

        return response()->json($employee->fresh());
    }

    public function destroy(Request $request, Employee $employee): JsonResponse
    {
        $employee->delete();
        $this->audit->record('delete', $employee, ['module' => 'hr'], $request);

        return response()->json(['message' => 'Employee archived.']);
    }
}
