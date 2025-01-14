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
}
