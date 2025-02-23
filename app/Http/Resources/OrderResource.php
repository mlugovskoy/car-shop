<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class OrderResource extends JsonResource
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
            'quantity' => count($this->orderTransports),
            'city' => $this->city,
            'phone' => $this->phone,
            'email' => $this->email,
            'price' => number_format($this->price, 0, '.', ' ') . ' ₽',
            'user' => $this->user,
            'created_at' => Date::parse($this->published_at)->translatedFormat('d F Y'),
        ];
    }
}
