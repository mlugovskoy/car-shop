<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TransportResource extends JsonResource
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
            'power' => $this->power_formatted,
            'engine' => $this->engine,
            'fuel_supply_type' => $this->fuel_supply_type,
            'mileage' => $this->mileage_formatted,
            'price' => $this->price_formatted,
            'description' => $this->description,
            'title' => $this->title,
            'preview' => $this->preview_text,
            'user' => $this->user,
            'published_at' => $this->published_at_formatted,
            'images' => $this->images->map(fn($image) => [
                'id' => $image->id,
                'image_title' => $image->image_title,
                'alt_title' => $this->title,
                'image_path' => asset(Storage::url($image->image_path)),
                'image_size' => $image->image_size,
                'image_ext' => $image->image_ext,
                'image_source' => $image->image_source,
            ])
        ];
    }
}
