<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

interface QueryFilterInterface
{
    public function apply(Builder $builder);
}
