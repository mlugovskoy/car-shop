<?php

use App\Console\Commands\UpdateCurrencyRates;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\ShareCartData;
use App\Http\Middleware\ShareNotifications;
use App\Jobs\CsvReportJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
        $middleware->alias([
            'admin' => IsAdmin::class,
            'notifications' => ShareNotifications::class,
            'cart' => ShareCartData::class
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command(UpdateCurrencyRates::class, ['USD', 'EUR', 'CNY'])->everyMinute()->runInBackground();
        $schedule->job(new CsvReportJob('daily_orders'))->everyMinute();
        $schedule->job(new CsvReportJob('daily_orders_two'))->everyMinute();
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
    })
    ->withExceptions(function (Exceptions $exceptions) {
    })->create();
