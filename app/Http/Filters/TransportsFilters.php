<?php

namespace App\Http\Filters;

use App\Models\Transport;

class TransportsFilters extends QueryFilters
{
    protected function color($value)
    {
        $this->builder->where('color', $value);
    }

    protected function transmission($value)
    {
        $this->builder->where('transmission', $value);
    }

    protected function steeringWheel($value)
    {
        $this->builder->where('steering_wheel', $value);
    }

    protected function drive($value)
    {
        $this->builder->where('drive', $value);
    }

    protected function price(array $value)
    {
        if (!isset($value[0])) {
            $value[0] = 0;
        }
        if (!isset($value[1])) {
            $value[1] = Transport::query()->max('price');
        }

        $this->builder->where('price', '>=', $value[0])->where('price', '<=', $value[1]);
    }

    protected function year(array $value)
    {
        if (!isset($value[0])) {
            $value[0] = 0;
        }
        if (!isset($value[1])) {
            $value[1] = Transport::query()->max('year');
        }

        $this->builder->where('year', '>=', $value[0])->where('year', '<=', $value[1]);
    }
}
