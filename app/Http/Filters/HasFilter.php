<?php

namespace App\Http\Filters;

trait HasFilter
{
    public function scopeFilter($builder, QueryFilters $filters)
    {
        return $filters->apply($builder);
    }
}
