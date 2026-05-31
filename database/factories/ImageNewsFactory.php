<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ImageNewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "news_id" => News::query()->inRandomOrder()->value('id'),
            "image_id" => Image::query()->inRandomOrder()->value('id')
        ];
    }
}
