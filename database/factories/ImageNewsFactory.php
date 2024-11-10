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
            "news_id" => $this->faker->numberBetween(1, News::query()->count()),
            "image_id" => $this->faker->numberBetween(1, Image::query()->count())
        ];
    }
}
