<?php

namespace App\Services;

use App\Models\CartItem;
use App\Services\Interfaces\CacheInterface;
use Illuminate\Support\Facades\Cache;

class CacheService implements CacheInterface
{
    public function getItem($key)
    {
        // TODO: Implement getItem() method.
    }

    public function getItems(array $keys = array())
    {
        // TODO: Implement getItems() method.
    }

    public function hasItem($key)
    {
        // TODO: Implement hasItem() method.
    }

    public static function clear()
    {
        // TODO: Implement clear() method.
    }

    public static function deleteItem($key): void
    {
        if (Cache::has($key)) {
            Cache::forget($key);
        }
    }

    public static function deleteItems(array $keys): void
    {
        if (!empty($keys)) {
            foreach ($keys as $key) {
                if (Cache::has($key)) {
                    Cache::forget($key);
                }
            }
        }
    }

    public static function save($item, $key, $time)
    {
        return Cache::remember($key, now()->addMinutes($time), function () use ($item) {
            return $item;
        });
    }

    public function commit()
    {
        // TODO: Implement commit() method.
    }
}
