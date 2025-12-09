<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class NewsResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'comments' => $this->comments->map(fn($comment) => array_merge($comment->toArray(), [
                'comment_user_name' => $comment->user->name,
                'comment_user_image' => $comment->user->images->map(fn($image) => [
                    'id' => $image->id,
                    'image_title' => $image->image_title,
                    'image_path' => asset(Storage::url($image->image_path)),
                    'image_size' => $image->image_size,
                    'image_ext' => $image->image_ext,
                    'image_source' => $image->image_source,
                ])
            ])),
            'user_id' => $this->user_id,
            'published_at' => Date::parse($this->published_at)->translatedFormat('d F Y'),
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
