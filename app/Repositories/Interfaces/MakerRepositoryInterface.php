<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface MakerRepositoryInterface
{
    public function getMakersAttachedToTransport(?Collection $arrMakerIds);

    public function getMakerId(string $section);
}
