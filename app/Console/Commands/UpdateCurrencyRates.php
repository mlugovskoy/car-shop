<?php

namespace App\Console\Commands;

use App\Services\CurrencyService;
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
    protected $description = 'Обновление курса валюты';

    /**
     * Execute the console command.
     */
    public function handle(CurrencyService $currencyService)
    {
        $this->info('Началось обновление курса валют...');

        $codes = $this->argument('codes');

        if($currencyService->updateCurrency($codes)) {
            $this->info('Курсы валют успешно обновлены!');
        } else {
            $this->error('Не удалось обновить курсы валют');
        }

        return 0;
    }
}
