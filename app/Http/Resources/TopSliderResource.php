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
            'title' => $this->title,
            'city' => $this->city,
            'price' => $this->price_formatted,
            'published_at' => $this->published_at_formatted,
            'images' => $this->images->map(fn($image) => [
                'id' => $image->id,
                'image_title' => $image->image_title,
                'image_path' => asset(Storage::url($image->image_path)),
                'image_size' => $image->image_size,
                'image_ext' => $image->image_ext,
                'image_source' => $image->image_source,
            ])
        ];
    }
}
