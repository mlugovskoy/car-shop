<?php

namespace App\Providers;

use App\Http\Resources\TransportResource;
use App\Http\Resources\AdminUserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        TransportResource::withoutWrapping();
        AdminUserResource::withoutWrapping();
    }
}
