<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCurrencyRatesJob;
use Illuminate\Console\Command;

class UpdateCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update-rates {codes?* : Коды валюты}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление курса валют';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $codes = $this->argument('codes');
        UpdateCurrencyRatesJob::dispatch($codes);
        $this->info('Задача обновления курсов валют отправлена в очередь');

        return 0;
    }
}
