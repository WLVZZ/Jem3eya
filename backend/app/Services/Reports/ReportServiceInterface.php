<?php

namespace App\Services\Reports;

interface ReportServiceInterface
{
    public function export(string $reportKey, array $filters, string $format): ReportExport;
}
