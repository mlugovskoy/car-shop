<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ImageReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "review_id" => $this->faker->numberBetween(1, Review::query()->count()),
            "image_id" => $this->faker->numberBetween(1, Image::query()->count())
        ];
    }
}
