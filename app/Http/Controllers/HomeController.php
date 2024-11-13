<?php

namespace App\Http\Controllers;

use App\Models\Transport;

class HomeController extends Controller
{
    public function index()
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

        return inertia('Home', ['transports' => $transports]);
    }
}
