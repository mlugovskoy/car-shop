<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class TransportsFilter extends QueryFilter
{
    protected const MAKERS = 'makers';
    protected const MODELS = 'models';
    protected const COLORS = 'colors';

    protected function getCallbacks(): array
    {
        return [
            self::MAKERS => [$this, 'makers'],
            self::MODELS => [$this, 'models'],
            self::COLORS => [$this, 'colors'],
        ];
    }

    protected function makers(Builder $builder, $value): Builder
    {
        $builder->whereHas('makers_id', function ($b) use ($value) {
            $b->whereIn('makers_id', $value);
        });
    }

    protected function models(Builder $builder, $value): Builder
    {
        $builder->whereHas('models_id', function ($b) use ($value) {
            $b->whereIn('models_id', $value);
        });
    }

    protected function colors(Builder $builder, $value): Builder
    {
        $builder->whereHas('colors', function ($b) use ($value) {
            $b->whereIn('colors', $value);
        });
    }
}
