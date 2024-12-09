<?php

namespace App\Http\Filters;

class TransportsFilters extends QueryFilters
{
    protected function color($value)
    {
        if (!$value) {
            return;
        }
        $this->builder->where('color', $value);
    }

    protected function transmission($value)
    {
        if (!$value) {
            return;
        }
        $this->builder->where('transmission', $value);
    }

    protected function steeringWheel($value)
    {
        if (!$value) {
            return;
        }
        $this->builder->where('steering_wheel', $value);
    }

    protected function drive($value)
    {
        if (!$value) {
            return;
        }
        $this->builder->where('drive', $value);
    }
}
