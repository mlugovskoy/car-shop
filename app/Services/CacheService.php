<?php

namespace App\Services;

use App\Services\Contracts\CacheInterface;
use Illuminate\Support\Facades\Cache;

class CacheService implements CacheInterface
{
    public function getItem($key)
    {
        return Cache::get($key);
    }

    public function getItems(array $keys = array())
    {
        // TODO: Implement getItems() method.
    }

    public function hasItem($key)
    {
        // TODO: Implement hasItem() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function deleteItem($key): void
    {
        Cache::forget($key);
    }

    public function deleteItems(array $keys): void
    {
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    public function save($item, $key, $time)
    {
        Cache::put($key, $item, now()->addMinutes($time));
        return $item;
    }

    public function commit()
    {
        // TODO: Implement commit() method.
    }
}
