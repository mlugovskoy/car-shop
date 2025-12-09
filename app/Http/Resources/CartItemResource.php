<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => sprintf('%06d', $this->id),
            'code' => $this->code,
            'transport' => $this->transport,
            'title' => $this->transport->maker->name . ' ' . $this->transport->model->name,
            'images' => $this->transport->images->map(fn($image) => [
                'id' => $image->id,
                'image_title' => $image->image_title,
                'image_path' => asset(Storage::url($image->image_path)),
                'image_size' => $image->image_size,
                'image_ext' => $image->image_ext,
                'image_source' => $image->image_source,
            ]),
            'price' => number_format($this->transport->price, 0, '.', ' ') . ' ₽',
            'created_at' => Date::parse($this->published_at)->translatedFormat('d F Y'),
        ];
    }
}
