<?php

namespace App\Providers;

use App\Helpers\Breadcrumbs;
use App\Helpers\Contracts\BreadcrumbsInterface;
use App\Http\Resources\NewsResource;
use App\Http\Resources\TopSliderResource;
use App\Http\Resources\TransportResource;
use App\Http\Resources\AdminUserResource;
use App\Repositories\CartRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Contracts\CommentRepositoryInterface;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use App\Repositories\Contracts\FavoriteRepositoryInterface;
use App\Repositories\Contracts\MakerRepositoryInterface;
use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\TransportRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\CurrencyRepository;
use App\Repositories\FavoriteRepository;
use App\Repositories\MakerRepository;
use App\Repositories\NewsRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\TransportRepository;
use App\Repositories\UserRepository;
use App\Services\CacheService;
use App\Services\Contracts\CacheInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CacheInterface::class, CacheService::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(FavoriteRepositoryInterface::class, FavoriteRepository::class);
        $this->app->bind(MakerRepositoryInterface::class, MakerRepository::class);
        $this->app->bind(NewsRepositoryInterface::class, NewsRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(TransportRepositoryInterface::class, TransportRepository::class);
        $this->app->bind(BreadcrumbsInterface::class, Breadcrumbs::class);
    }

    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        TransportResource::withoutWrapping();
        AdminUserResource::withoutWrapping();
        NewsResource::withoutWrapping();
        TopSliderResource::withoutWrapping();
    }
}
