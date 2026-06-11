<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use App\Services\Audit\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProjectController extends Controller
{
    public function __construct(private readonly AuditLogger $audit)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json(Project::query()
            ->with(['costCenter'])
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')))
            ->latest('id')
            ->paginate((int) $request->input('per_page', 20)));
    }

    public function store(Request $request): JsonResponse
    {
        $project = Project::create($request->validate([
            'code' => ['required', 'string', 'max:80', 'unique:projects,code'],
            'name_ar' => ['required', 'string', 'max:190'],
            'name_en' => ['nullable', 'string', 'max:190'],
            'type' => ['required', 'string', 'max:80'],
            'budget' => ['required', 'numeric', 'min:0'],
            'funding_source' => ['nullable', 'string', 'max:190'],
            'cost_center_account_id' => ['nullable', 'integer', 'exists:accounts,id'],
            'status' => ['required', 'in:planned,active,on_hold,completed,cancelled'],
            'progress_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]));

        $this->audit->record('create', $project, ['module' => 'projects'], $request);

        return response()->json($project, 201);
    }

    public function show(Project $project): JsonResponse
    {
        return response()->json($project->load(['budgets', 'expenses', 'documents', 'costCenter']));
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $project->update($request->validate([
            'name_ar' => ['sometimes', 'string', 'max:190'],
            'name_en' => ['nullable', 'string', 'max:190'],
            'budget' => ['sometimes', 'numeric', 'min:0'],
            'funding_source' => ['nullable', 'string', 'max:190'],
            'status' => ['sometimes', 'in:planned,active,on_hold,completed,cancelled'],
            'progress_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]));

        $this->audit->record('update', $project, ['module' => 'projects'], $request);

        return response()->json($project->fresh());
    }

    public function destroy(Request $request, Project $project): JsonResponse
    {
        $project->delete();
        $this->audit->record('delete', $project, ['module' => 'projects'], $request);

        return response()->json(['message' => 'Project archived.']);
    }
}
