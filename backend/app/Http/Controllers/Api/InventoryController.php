<?php

namespace App\Http\Controllers\Api;

use App\Models\InventoryItem;
use App\Services\Audit\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InventoryController extends Controller
{
    public function __construct(private readonly AuditLogger $audit)
    {
    }

    public function items(Request $request): JsonResponse
    {
        return response()->json(InventoryItem::query()
            ->when($request->filled('q'), fn ($query) => $query->where('name_ar', 'like', '%'.$request->string('q').'%'))
            ->orderBy('item_code')
            ->paginate((int) $request->input('per_page', 20)));
    }

    public function storeItem(Request $request): JsonResponse
    {
        $data = $request->validate([
            'item_code' => ['required', 'string', 'max:80', 'unique:inventory_items,item_code'],
            'barcode' => ['nullable', 'string', 'max:120'],
            'name_ar' => ['required', 'string', 'max:190'],
            'name_en' => ['nullable', 'string', 'max:190'],
            'unit_of_measure' => ['required', 'string', 'max:40'],
            'reorder_level' => ['nullable', 'numeric', 'min:0'],
        ]);

        $item = InventoryItem::create($data);
        $this->audit->record('create', $item, ['module' => 'inventory'], $request);

        return response()->json($item, 201);
    }
}
