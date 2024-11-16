<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Maker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ImageMakerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "maker_id" => $this->faker->numberBetween(1, Maker::query()->count()),
            "image_id" => $this->faker->numberBetween(1, Image::query()->count())
        ];
    }
}
