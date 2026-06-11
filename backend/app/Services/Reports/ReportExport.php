<?php

namespace App\Services\Reports;

class ReportExport
{
    public function __construct(
        public readonly string $filename,
        public readonly string $mimeType,
        public readonly string $storagePath,
        public readonly array $meta = [],
    ) {
    }
}
