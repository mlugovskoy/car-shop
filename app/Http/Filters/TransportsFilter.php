<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class TransportsFilter extends QueryFilter
{
    protected const MAKERS = 'makers';
    protected const MODELS = 'models';

    protected function getCallbacks(): array
    {
        return [
            self::MAKERS => [$this, 'makers'],
            self::MODELS => [$this, 'models'],
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
}
