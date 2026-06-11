<?php

namespace App\Services\Accounting;

use App\Models\JournalEntry;
use RuntimeException;

class JournalPostingService
{
    public function post(JournalEntry $entry): JournalEntry
    {
        $debit = (float) $entry->details()->sum('debit');
        $credit = (float) $entry->details()->sum('credit');

        if (round($debit, 3) !== round($credit, 3)) {
            throw new RuntimeException('Journal entry must balance before posting.');
        }

        $entry->update([
            'status' => 'posted',
            'posted_at' => now(),
        ]);

        return $entry;
    }
}
