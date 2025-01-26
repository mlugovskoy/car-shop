<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    public function updateCurrency(array $codes = [])
    {
        try {
            $response = Http::get('https://www.cbr-xml-daily.ru/daily.xml');
            if ($response->successful()) {
                $contentXml = Http::get('https://www.cbr-xml-daily.ru/daily.xml')->getBody()->getContents();
                $xmlObj = new \SimpleXMLElement($contentXml);

                foreach ($xmlObj->Valute as $currency) {
                    if (!empty($codes) && !in_array($currency->CharCode, $codes)) {
                        continue;
                    }

                    $rate = str_replace(',', '.', $currency->Value);

                    Currency::query()
                        ->updateOrCreate(
                            ['code' => $currency->CharCode],
                            [
                                'name' => $currency->Name,
                                'rate' => $rate
                            ]
                        );
                }
            }
            return true;
        } catch (\Exception $err) {
            Log::error($err->getMessage());
        }
        return false;
    }

    public function getFormattedPrice(string $price, ?string $code = ''): string
    {
        if (!empty($code) && $code !== 'RUB') {
            $currency = Currency::query()
                ->where('code', $code)
                ->first();

            $formatPrice = $price / $currency['rate'];
            $icon = $this->getCurrencyIcon($currency['code']);
        } else {
            $formatPrice = $price;
            $icon = $this->getCurrencyIcon();
        }


        return number_format($formatPrice, 0, '.', ' ') . ' ' . $icon;
    }

    protected function getCurrencyIcon(string $code = ''): string
    {
        return match ($code) {
            'USD' => '$',
            'EUR' => '€',
            'CNY' => '¥',
            default => '₽',
        };
    }
}
