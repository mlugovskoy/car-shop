<?php

namespace App\Services\Reports;

use App\Models\Order;
use App\Services\Contracts\ReportInterface;
use Illuminate\Support\Facades\Storage;

class DailyTwoOrdersReport implements ReportInterface
{
    public function generate(): void
    {
        $filename = 'order_report_two_' . time() . '.csv';
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['ID', 'Дата', 'Сумма']);

        Order::query()->where('price', '>', 2558980)->chunk(200, function ($orders) use ($handle) {
            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->id,
                    $order->created_at,
                    $order->price,
                ]);
            }
        });

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        Storage::disk('public')->put($filename, $csvContent);
    }
}
