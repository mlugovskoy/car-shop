<?php

namespace App\Services;

use Google\Client;
use Google\Service\Exception;
use Google\Service\Sheets;
use Google\Service\Sheets\ClearValuesRequest;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Log;

class GoogleSheetsReportService
{
    /**
     * @throws \Throwable
     */
    public function init(array $data = [], array $headers = []): void
    {
        $keyPath = base_path() . config('google.api_key');

        if (!file_exists($keyPath)) {
            Log::warning('Google API key не найден: ' . $keyPath);
            return;
        }

        try {
            $this->pushToGoogleSheets($data, $headers);
        } catch (\Throwable $e) {
            Log::error('Ошибка google sheets: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws Exception
     * @throws \Google\Exception
     * @throws \Throwable
     */
    protected function pushToGoogleSheets(array $data, array $headers): bool
    {
        if (empty($data)) {
            return false;
        }

        $client = new Client();
        $client->setApplicationName("Car Shop Reports");
        $client->setAuthConfig(base_path() . config('google.api_key'));
        $client->addScope(Sheets::SPREADSHEETS);

        $service = new Sheets($client);

        $rows = [$headers];
        foreach ($data as $row) {
            $rows[] = array_values($row);
        }

        try {
            $service->spreadsheets_values->clear(
                config('google.table_id'),
                config('google.sheet_name'),
                new ClearValuesRequest()
            );

            $service->spreadsheets_values->update(
                config('google.table_id'),
                config('google.sheet_name') . '!A1',
                new ValueRange(['values' => $rows]),
                ['valueInputOption' => 'USER_ENTERED']
            );
        } catch (\Throwable $e) {
            Log::error('Google Sheets API ошибка: ' . $e->getMessage());
            throw $e;
        }

        return true;
    }
}
