<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class RemoveSectionCache
{
    public function removeSectionCache(string|array $code): void
    {
        $cacheKey = $code;

        if (is_array($cacheKey)) {
            foreach ($cacheKey as $key) {
                if (Cache::has($key)) {
                    Cache::forget($key);
                }
            }
        } elseif (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
    }
}
