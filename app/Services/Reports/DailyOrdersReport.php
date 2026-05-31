<?php

namespace App\Services\Reports;

use App\Models\Order;
use App\Services\Contracts\ReportInterface;
use App\Services\GoogleSheetsReportService;
use Illuminate\Support\Facades\Storage;

class DailyOrdersReport implements ReportInterface
{
    public function __construct(
        private GoogleSheetsReportService $sheetsService
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function generate(): void
    {
        $filename = 'order_report_' . time() . '.csv';
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['ID', 'Дата', 'Сумма']);

        $rows = [];

        Order::query()
            ->where('price', '>', 5558980)
            ->chunk(200, function ($orders) use ($handle, &$rows) {
                foreach ($orders as $order) {
                    $row = [
                        'id' => $order->id,
                        'created_at' => $order->created_at,
                        'price' => $order->price,
                    ];

                    fputcsv($handle, [
                        $order->id,
                        $order->created_at,
                        $order->price,
                    ]);

                    $rows[] = $row;
                }
            });

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        Storage::disk('public')->put($filename, $csvContent);
        $this->sheetsService->init($rows, ['ID', 'Дата', 'Сумма']);
    }
}
