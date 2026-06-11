<?php

namespace App\Services\Reports;

use InvalidArgumentException;

class ReportService implements ReportServiceInterface
{
    public function export(string $reportKey, array $filters, string $format): ReportExport
    {
        if (! in_array($format, ['pdf', 'xlsx', 'docx'], true)) {
            throw new InvalidArgumentException('Unsupported report format.');
        }

        return new ReportExport(
            filename: "{$reportKey}.{$format}",
            mimeType: match ($format) {
                'pdf' => 'application/pdf',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                default => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            },
            storagePath: "reports/pending/{$reportKey}.{$format}",
            meta: [
                'filters' => $filters,
                'engine' => 'local-abstraction',
                'jasper_ready' => true,
                'todo' => 'Wire concrete PDF/Excel/Word renderers per report.',
            ],
        );
    }
}
