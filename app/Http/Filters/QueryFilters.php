<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class QueryFilters
{
    protected $builder;

    protected const KEYS_ARRAY = ['price', 'year'];

    public function __construct(private Request $request)
    {
    }

    public function apply($builder)
    {
        foreach ($this->filters() as $method => $value) {
            $methodName = Str::camel($method);
            $this->builder = $builder;

            if ($value === null) {
                continue;
            }

            if (method_exists($this, $methodName)) {
                if (in_array($method, static::KEYS_ARRAY, true)) {
                    $value = is_array($value) ? $value : [$value];
                }

                $this->builder = $this->{$methodName}($value);
            }
        }

        return $this->builder;
    }

    public function filters(): array
    {
        return $this->request->all();
    }
}
