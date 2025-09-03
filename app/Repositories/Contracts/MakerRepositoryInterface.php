<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface MakerRepositoryInterface
{
    public function getMakersAttachedToTransport(?Collection $arrMakerIds);

    public function getMakerId(string $section);
}
