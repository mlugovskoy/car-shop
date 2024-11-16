<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Transport;

class HomeService
{
    public function getTransportsInTopSlider(): \Illuminate\Database\Eloquent\Collection
    {
        $transports = Transport::query()
            ->orderBy('published_at', 'desc')
            ->limit(15)
            ->get(['id', 'city', 'model_id', 'maker_id', 'price']);


        foreach ($transports as $transport) {
            foreach ($transport->images as $image) {
                $transport->push($image);
            }
        }

        return $transports;
    }


}
