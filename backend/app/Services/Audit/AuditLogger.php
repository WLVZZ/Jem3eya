<?php

namespace App\Services\Audit;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuditLogger
{
    public function record(string $action, ?Model $subject = null, array $meta = [], ?Request $request = null): void
    {
        AuditLog::create([
            'user_id' => $request?->user()?->id,
            'action' => $action,
            'module' => $meta['module'] ?? null,
            'auditable_type' => $subject ? $subject::class : null,
            'auditable_id' => $subject?->getKey(),
            'before_values' => $meta['before'] ?? null,
            'after_values' => $meta['after'] ?? $subject?->getAttributes(),
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'meta' => $meta,
        ]);
    }
}
