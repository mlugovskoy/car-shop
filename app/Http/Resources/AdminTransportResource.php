<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class AdminTransportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'active' => $this->active,
            'maker' => $this->maker,
            'model' => $this->model,
            'fuel_type' => $this->fuelType,
            'transport_type' => $this->transportType,
            'city' => $this->city,
            'year' => $this->year,
            'power' => number_format($this->power, 0, '.', ' '),
            'engine' => $this->engine,
            'fuel_supply_type' => $this->fuel_supply_type,
            'mileage' => number_format($this->mileage, 0, '.', ' '),
            'price' => number_format($this->price, 0, '.', ' ') . ' ₽',
            'description' => $this->description,
            'user_id' => $this->user_id,
            'published_at' => Date::parse($this->published_at)->translatedFormat('d F Y'),
            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image_title' => $image->image_title,
                    'image_path' => asset(Storage::url($image->image_path)),
                    'image_size' => $image->image_size,
                    'image_ext' => $image->image_ext,
                    'image_source' => $image->image_source,
                ];
            })
        ];
    }
}
