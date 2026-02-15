<?php

namespace App\Repositories;

use App\Models\SiteSettings;
use App\Repositories\Contracts\SiteSettingsRepositoryInterface;
use App\Services\Contracts\CacheInterface;

class SiteSettingsRepository implements SiteSettingsRepositoryInterface
{
    public function __construct(private SiteSettings $model, private CacheInterface $cache)
    {
    }

    public function get(): SiteSettings
    {
        $settings = $this->model->query()->firstOrCreate();

        $this->cache->save($settings, $this->model::CACHE_KEY, $this->model::CACHE_TIME);

        return $settings;
    }

    public function update($data): void
    {
        $settings = $this->get();

        $settings->update($data);

        $this->cache->deleteItem($this->model::CACHE_KEY);
    }
}
