<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdminUserResource extends JsonResource
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
            'name' => $this->name,
            'city' => $this->city,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
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
