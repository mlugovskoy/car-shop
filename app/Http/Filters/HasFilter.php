<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    /**
     * @param Builder $builder
     * @param QueryFilter $filter
     */
    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        $filter->apply($builder);
    }
}
