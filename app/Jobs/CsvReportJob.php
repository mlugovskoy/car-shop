<?php

namespace App\Jobs;

use App\Services\ReportFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CsvReportJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $timeout = 120;

    public function backoff(): array
    {
        return [30, 30, 30];
    }

    /**
     * Create a new job instance.
     */
    public function __construct(private string $reportType)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Запуск отчёта: {$this->reportType}");

        $report = ReportFactory::make($this->reportType);
        $report->generate();

        Log::info("Отчёт завершён: {$this->reportType}");
    }
}
