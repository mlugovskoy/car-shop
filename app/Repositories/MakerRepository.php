<?php

namespace App\Repositories;

use App\Models\Maker;
use App\Repositories\Contracts\MakerRepositoryInterface;
use App\Services\CacheService;
use App\Services\Contracts\CacheInterface;
use Illuminate\Support\Collection;

class MakerRepository implements MakerRepositoryInterface
{
    public function __construct(private Maker $model, private CacheInterface $cache)
    {
    }

    public function getMakersAttachedToTransport(?Collection $arrMakerIds): Collection
    {
        $item = $this->model
            ->query()
            ->with(['images'])
            ->whereIn('id', $arrMakerIds)
            ->get(['id', 'name']);

        return $this->cache->save($item, $this->model::CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function getMakerId(string $section = null): ?Maker
    {
        if (empty($section)) {
            return null;
        }

        return $this->model
            ->query()
            ->where('name', 'ilike', $section)
            ->first('id');
    }
}
