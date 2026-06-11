<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Finance\AccountRequest;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Services\Audit\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FinanceController extends Controller
{
    public function __construct(private readonly AuditLogger $audit)
    {
    }

    public function accounts(): JsonResponse
    {
        return response()->json(Account::query()
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('code')
            ->get());
    }

    public function storeAccount(AccountRequest $request): JsonResponse
    {
        $account = Account::create($request->validated());
        $this->audit->record('create', $account, ['module' => 'finance'], $request);

        return response()->json($account, 201);
    }

    public function journalEntries(Request $request): JsonResponse
    {
        return response()->json(JournalEntry::query()
            ->with(['details.account'])
            ->latest('entry_date')
            ->paginate((int) $request->input('per_page', 20)));
    }
}
