<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransportService
{
    private function getCurrencyCode(string $code): float
    {
        $res = '';
        try {
            if (Http::get('https://www.cbr-xml-daily.ru/daily.xml')->successful()) {
                $contentXml = Http::get('https://www.cbr-xml-daily.ru/daily.xml')->getBody()->getContents();
                $xmlObj = new \SimpleXMLElement($contentXml);

                foreach ($xmlObj->Valute as $value) {
                    if ($code === (string)$value->CharCode) {
                        $res = (float)$value->Value;
                    }
                }
            }
        } catch (\Exception $err) {
            Log::error($err->getMessage());
        }

        return $res;
    }
}
