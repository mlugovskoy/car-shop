<?php

namespace App\Jobs;

use App\Services\CurrencyService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCurrencyRatesJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $codes = [])
    {
    }

    public function backoff(): array
    {
        return [10, 30, 60];
    }

    /**
     * Execute the job.
     * @throws \Exception
     */
    public function handle(CurrencyService $currencyService): void
    {
        $result = $currencyService->updateCurrency($this->codes);

        if (!$result) {
            throw new \Exception('Не удалось обновить курсы валют');
        }
    }
}
