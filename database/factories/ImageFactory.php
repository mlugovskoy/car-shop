<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ImageFactory extends Factory
{
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_title' => $this->faker->sentence(),
            'image_path' => $this->faker->imageUrl(),
            'image_size' => $this->faker->numberBetween(100, 2000),
            'image_ext' => $this->faker->randomElement(['jpg', 'jpeg', 'png']),
        ];
    }
}
