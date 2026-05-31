<?php

namespace App\Console\Commands;

use App\Jobs\CsvReportJob;
use Illuminate\Console\Command;

class ReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:generate {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация отчета заказов';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        CsvReportJob::dispatch($this->argument('type'));
        $this->info('Отчёт поставлен в очередь');

        return 0;
    }
}
