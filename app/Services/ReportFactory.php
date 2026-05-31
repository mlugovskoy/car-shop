<?php

namespace App\Services;

use App\Services\Contracts\ReportInterface;
use App\Services\Reports\DailyOrdersReport;
use App\Services\Reports\DailyTwoOrdersReport;

class ReportFactory
{
    public static function make(string $type): ReportInterface
    {
        return match ($type) {
            'daily_orders' => app(DailyOrdersReport::class),
            'daily_orders_two' => app(DailyTwoOrdersReport::class)
        };
    }
}
