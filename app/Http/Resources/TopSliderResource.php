<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class TopSliderResource extends JsonResource
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
            'maker' => $this->maker,
            'model' => $this->model,
            'title' => $this->maker->name . ' ' . $this->model->name,
            'city' => $this->city,
            'price' => number_format($this->price, 0, '.', ' ') . ' ₽',
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
