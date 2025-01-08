<?php

namespace App\Repositories;

use App\Models\Maker;
use App\Models\Transport;
use App\Repositories\Interfaces\MakerRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class MakerRepository implements MakerRepositoryInterface
{

    protected int $cacheTime = 10;

    public function __construct(protected Maker $model)
    {
    }

    public function getMakersAttachedToTransport(?Collection $arrMakerIds): Collection
    {
        $cacheKey = 'home_makers';

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () use ($arrMakerIds) {
            return $this->model::query()
                ->with(['images'])
                ->whereIn('id', $arrMakerIds)
                ->get(['id', 'name']);
        });
    }

    public function getMakerId(string $section = null)
    {
        $maker = null;

        if (!empty($section)) {
            $maker = $this->model::query()
                ->where('name', 'ilike', $section)
                ->first('id');
        }

        return $maker;
    }
}
